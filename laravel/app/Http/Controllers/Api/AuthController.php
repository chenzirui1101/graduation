<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * 生成验证码
     */
    public function captcha()
    {
        // 生成一个简单的数学验证码（避免依赖第三方包）
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $result = $num1 + $num2;

        // 生成一个唯一key
        $key = md5(uniqid(rand(), true));

        // 将结果存入缓存，5分钟过期
        Cache::put('captcha_' . $key, $result, 300);

        // 生成验证码图片（使用简单的文本）
        $image = imagecreatetruecolor(120, 40);
        $bgColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);

        imagefilledrectangle($image, 0, 0, 120, 40, $bgColor);
        imagestring($image, 5, 20, 10, $num1 . ' + ' . $num2 . ' = ?', $textColor);

        // 添加干扰线
        for ($i = 0; $i < 5; $i++) {
            $lineColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
            imageline($image, rand(0, 120), rand(0, 40), rand(0, 120), rand(0, 40), $lineColor);
        }

        // 输出图片
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        // 返回JSON，包含图片的base64和key
        return response()->json([
            'code' => 200,
            'key' => $key,
            'image' => 'data:image/png;base64,' . base64_encode($imageData)
        ]);
    }

    /**
     * 登录接口
     */
    public function login(Request $request)
    {
        try {
            // 验证请求参数
            $validated = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
                'captcha' => 'required|string',
                'captcha_key' => 'required|string'
            ]);

            // 验证验证码
            $captchaKey = 'captcha_' . $validated['captcha_key'];
            $correctResult = Cache::get($captchaKey);

            if (!$correctResult || $correctResult != $validated['captcha']) {
                return response()->json([
                    'code' => 422,
                    'msg' => '验证码错误',
                    'errors' => ['captcha' => ['验证码错误或已过期']]
                ], 422);
            }

            // 验证通过后删除验证码
            Cache::forget($captchaKey);

            // 尝试登录
            if (!Auth::attempt([
                'username' => $validated['username'],
                'password' => $validated['password']
            ])) {
                return response()->json([
                    'code' => 422,
                    'msg' => '用户名或密码错误',
                    'errors' => ['password' => ['用户名或密码错误']]
                ], 422);
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'code' => 200,
                'msg' => '登录成功',
                'data' => [
                    'token' => $token,
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'name' => $user->name,
                        'email' => $user->email,
                        'avatar' => $user->avatar,
                    ]
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'code' => 422,
                'msg' => '验证失败',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * 登出接口
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'code' => 200,
            'msg' => '登出成功'
        ]);
    }

    /**
     * 获取当前登录用户信息
     */
    public function getUserInfo(Request $request)
    {
        return response()->json([
            'code' => 200,
            'data' => $request->user()
        ]);
    }

    /**
     * 检查token有效性
     */
    public function checkToken(Request $request)
    {
        return response()->json([
            'code' => 200,
            'msg' => 'token有效',
            'data' => [
                'user_id' => $request->user()->id,
                'token_valid' => true
            ]
        ]);
    }

    /**
     * 注册接口
     */
    public function register(Request $request)
    {
        try {
            // 验证请求参数
            $validated = $request->validate([
                'username' => 'required|string|unique:users,username|min:3|max:20',
                'name' => 'required|string|max:50',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6'
            ]);

            // 创建用户
            $user = \App\Models\User::create([
                'username' => $validated['username'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password'])
            ]);

            // 生成 token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'code' => 200,
                'msg' => '注册成功',
                'data' => [
                    'token' => $token,
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'name' => $user->name,
                        'email' => $user->email,
                        'avatar' => $user->avatar,
                    ]
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'code' => 422,
                'msg' => '验证失败',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * 更新用户信息接口
     */
    public function update(Request $request)
    {
        try {
            $user = $request->user();

            // 验证请求参数
            $validated = $request->validate([
                'username' => 'required|string|min:3|max:20|unique:users,username,' . $user->id,
                'email' => 'required|email|unique:users,email,' . $user->id,
                'old_password' => 'sometimes|required|string',
                'new_password' => 'sometimes|required|string|min:6',
                'avatar' => 'sometimes|image|max:2048', // 头像文件，最大2MB
            ]);

            // 准备更新数据
            $updateData = [
                'username' => $validated['username'],
                'email' => $validated['email'],
            ];

            // 如果提供了密码更新
            if (isset($validated['old_password']) && isset($validated['new_password'])) {
                // 验证旧密码
                if (!\Hash::check($validated['old_password'], $user->password)) {
                    return response()->json([
                        'code' => 422,
                        'msg' => '旧密码错误',
                        'errors' => ['old_password' => ['旧密码错误']]
                    ], 422);
                }

                // 更新密码
                $updateData['password'] = bcrypt($validated['new_password']);
            }

            // 处理头像上传
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $path = $avatar->store('avatars', 'public');
                $updateData['avatar'] = $path;
            }

            // 更新用户信息
            $user->update($updateData);

            return response()->json([
                'code' => 200,
                'msg' => '更新成功',
                'data' => $user
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'code' => 422,
                'msg' => '验证失败',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
