<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * 管理员登录
     */
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string'
            ]);

            // 只允许admin用户登录
            if ($validated['username'] !== 'admin') {
                return response()->json([
                    'code' => 403,
                    'msg' => '非管理员账号，禁止登录',
                    'errors' => ['username' => ['非管理员账号，禁止登录']]
                ], 403);
            }

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
            $token = $user->createToken('admin_token')->plainTextToken;

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
                    ]
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'code' => 422,
                'msg' => '验证失败',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('管理员登录错误：' . $e->getMessage());
            return response()->json([
                'code' => 500,
                'msg' => '登录失败',
                'errors' => ['login' => ['登录失败，请重试']]
            ], 500);
        }
    }

    /**
     * 获取所有商品列表（管理员）
     */
    public function getProducts(Request $request)
    {
        try {
            $pageNum = $request->input('pageNum', 1);
            $pageSize = $request->input('pageSize', 12);
            $keyword = $request->input('keyword', '');

            // 直接查询商品数据，不使用with('user')预加载
            $query = Product::orderBy('created_at', 'desc');

            // 添加搜索功能
            if (!empty($keyword)) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', '%' . $keyword . '%')
                      ->orWhere('description', 'like', '%' . $keyword . '%');
                      // 暂时移除用户相关搜索，避免关联查询错误
                      // ->orWhereHas('user', function ($q) use ($keyword) {
                      //     $q->where('name', 'like', '%' . $keyword . '%')
                      //       ->orWhere('username', 'like', '%' . $keyword . '%');
                      // });
                });
            }

            $products = $query->paginate($pageSize, ['*'], 'page', $pageNum);

            $list = collect($products->items())->map(function ($item) {
                // 直接返回商品信息，不包含用户详情
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'price' => number_format($item->price, 2, '.', ''),
                    'category' => $this->getCategoryName($item->category_id),
                    'categoryId' => $item->category_id,
                    'coverImg' => $item->cover_img ?? '',
                    'createTime' => $item->created_at ? $item->created_at->format('Y-m-d') : '',
                    'sellerName' => '未知用户', // 暂时固定为未知用户
                    'sellerUsername' => '未知用户', // 暂时固定为未知用户
                    'sellerId' => $item->user_id
                ];
            })->values();

            return response()->json([
                'code' => 200,
                'data' => [
                    'list' => $list,
                    'total' => $products->total()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('获取商品列表错误：' . $e->getMessage());
            Log::error('错误堆栈：' . $e->getTraceAsString());
            return response()->json([
                'code' => 500,
                'msg' => '服务器错误',
                'error' => $e->getMessage() // 返回具体错误信息
            ], 500);
        }
    }

    /**
     * 删除商品（管理员）
     */
    public function deleteProduct($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'code' => 404,
                    'msg' => '商品不存在'
                ], 404);
            }

            $product->delete();

            return response()->json([
                'code' => 200,
                'msg' => '商品删除成功'
            ]);

        } catch (\Exception $e) {
            Log::error('删除商品错误：' . $e->getMessage());
            return response()->json([
                'code' => 500,
                'msg' => '删除失败'
            ], 500);
        }
    }

    /**
     * 获取所有用户列表（管理员）
     */
    public function getUsers(Request $request)
    {
        try {
            $pageNum = $request->input('pageNum', 1);
            $pageSize = $request->input('pageSize', 12);
            $keyword = $request->input('keyword', '');

            $query = User::orderBy('created_at', 'desc');

            // 添加搜索功能
            if (!empty($keyword)) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%')
                      ->orWhere('username', 'like', '%' . $keyword . '%')
                      ->orWhere('email', 'like', '%' . $keyword . '%');
                });
            }

            $users = $query->paginate($pageSize, ['*'], 'page', $pageNum);

            $list = collect($users->items())->map(function ($item) {
                // 直接返回用户信息，暂时不获取商品数量
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'username' => $item->username,
                    'email' => $item->email,
                    'createTime' => $item->created_at ? $item->created_at->format('Y-m-d') : '',
                    'productCount' => 0 // 暂时固定为0，避免关联查询错误
                ];
            })->values();

            return response()->json([
                'code' => 200,
                'data' => [
                    'list' => $list,
                    'total' => $users->total()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('获取用户列表错误：' . $e->getMessage());
            Log::error('错误堆栈：' . $e->getTraceAsString());
            return response()->json([
                'code' => 500,
                'msg' => '服务器错误',
                'error' => $e->getMessage() // 返回具体错误信息
            ], 500);
        }
    }

    /**
     * 获取分类名称
     */
    private function getCategoryName($id)
    {
        $categories = [
            1 => '数码产品',
            2 => '生活用品',
            3 => '学习资料',
            4 => '服饰鞋包',
            5 => '其他'
        ];
        return $categories[$id] ?? '其他';
    }
}
