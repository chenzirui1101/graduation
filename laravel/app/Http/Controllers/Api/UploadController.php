<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * 上传图片
     */
    public function uploadImage(Request $request)
    {
        try {
            // 验证请求
            $request->validate([
                'file' => 'required|image|max:2048', // 最大2MB
            ]);

            // 获取当前用户
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'code' => 401,
                    'msg' => '请先登录'
                ], 401);
            }

            // 生成唯一文件名
            $file = $request->file('file');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $userDir = 'images/' . $user->username;
            $disk = config('filesystems.default');

            // 上传文件
            if ($disk === 's3') {
                // 使用S3云存储
                $path = $file->storeAs($userDir, $filename, ['disk' => 's3', 'visibility' => 'public']);
                $url = Storage::disk('s3')->url($path);
            } else {
                // 使用本地存储
                if (!Storage::exists($userDir)) {
                    Storage::makeDirectory($userDir);
                }
                $path = $file->storeAs($userDir, $filename, 'public');
                $url = asset('storage/' . $path);
            }

            return response()->json([
                'code' => 200,
                'data' => [
                    'url' => $url,
                    'path' => $path,
                    'disk' => $disk
                ],
                'msg' => '上传成功'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'code' => 422,
                'msg' => '验证失败',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'msg' => '上传失败: ' . $e->getMessage()
            ], 500);
        }
    }
}
