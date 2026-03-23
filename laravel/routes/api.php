<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\RatingController;

// 无需登录的公开接口
Route::prefix('auth')->group(function () {
    Route::get('captcha', [AuthController::class, 'captcha']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register'])->middleware('ip.limit');
});

// 商品公开接口
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
});

// 失物招领公开接口
Route::prefix('lostfound')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\LostFoundController::class, 'index']);
    Route::get('/{id}', [\App\Http\Controllers\Api\LostFoundController::class, 'show']);
});

// 论坛相关接口
Route::prefix('forum')->group(function () {
    // 获取话题列表
    Route::get('/topics', [\App\Http\Controllers\Api\ForumController::class, 'getTopics']);
    // 获取话题详情
    Route::get('/topics/{id}', [\App\Http\Controllers\Api\ForumController::class, 'getTopicDetail']);
    // 获取话题评论
    Route::get('/topics/{id}/replies', [\App\Http\Controllers\Api\ForumController::class, 'getComments']);
    // 添加评论
    Route::post('/topics/{id}/replies', [\App\Http\Controllers\Api\ForumController::class, 'addComment'])->middleware('auth:sanctum');
    // 获取热门话题
    Route::get('/hot-topics', [\App\Http\Controllers\Api\ForumController::class, 'getHotTopics']);
    // 获取活跃用户
    Route::get('/active-users', [\App\Http\Controllers\Api\ForumController::class, 'getActiveUsers']);
});

// 上传接口
Route::prefix('upload')->group(function () {
    Route::post('image', [\App\Http\Controllers\Api\UploadController::class, 'uploadImage'])->middleware('auth:sanctum');
});

// 测试接口
Route::prefix('test')->group(function () {
    Route::get('create-test-user', [\App\Http\Controllers\Api\TestController::class, 'createTestUser']);
    // 测试LostFound模型
    Route::get('lostfound/{id}', function ($id) {
        $lostFound = \App\Models\LostFound::find($id);
        if (!$lostFound) {
            return response()->json(['code' => 404, 'msg' => '失物招领不存在']);
        }
        return response()->json(['code' => 200, 'data' => $lostFound, 'msg' => 'success']);
    });
    // 获取所有LostFound记录
    Route::get('lostfound-list', function () {
        $lostFounds = \App\Models\LostFound::all();
        return response()->json(['code' => 200, 'data' => $lostFounds, 'msg' => 'success']);
    });
});

// 需要登录的接口
Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/me', [AuthController::class, 'getUserInfo']);
        Route::get('auth/check-token', [AuthController::class, 'checkToken']);
        Route::post('auth/update', [AuthController::class, 'update']);

    Route::prefix('products')->group(function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
        Route::get('/my/list', [ProductController::class, 'myProducts']);
    });

    // 聊天相关接口
    Route::prefix('chat')->group(function () {
        Route::get('/conversations', [\App\Http\Controllers\Api\ChatController::class, 'getConversations']);
        Route::post('/conversations', [\App\Http\Controllers\Api\ChatController::class, 'createConversation']);
        Route::get('/conversations/{id}/messages', [\App\Http\Controllers\Api\ChatController::class, 'getMessages']);
        Route::post('/conversations/{id}/messages', [\App\Http\Controllers\Api\ChatController::class, 'sendMessage']);
    });

    // 收藏相关接口
    Route::prefix('favorites')->group(function () {
        Route::get('/', [FavoriteController::class, 'index']);
        Route::post('/', [FavoriteController::class, 'store']);
        Route::delete('/{productId}', [FavoriteController::class, 'destroy']);
        Route::get('/check/{productId}', [FavoriteController::class, 'check']);
        Route::post('/check/batch', [FavoriteController::class, 'batchCheck']); // 批量检查收藏状态
    });

    // 评价相关接口
    Route::prefix('ratings')->group(function () {
        Route::post('/', [RatingController::class, 'store']);
        Route::get('/user', [RatingController::class, 'userRatings']);
        Route::put('/{id}', [RatingController::class, 'update']);
        Route::delete('/{id}', [RatingController::class, 'destroy']);
    });

    // 商品评价公开接口
    Route::get('/products/{productId}/ratings', [RatingController::class, 'productRatings']);
});

// 管理员相关接口
Route::prefix('admin')->group(function () {
    // 管理员登录
    Route::post('login', [\App\Http\Controllers\Api\AdminController::class, 'login']);

    // 管理员需要登录的接口
    Route::middleware('auth:sanctum')->group(function () {
        // 商品管理
        Route::prefix('products')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\AdminController::class, 'getProducts']);
            Route::delete('/{id}', [\App\Http\Controllers\Api\AdminController::class, 'deleteProduct']);
        });

        // 用户管理
        Route::prefix('users')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\AdminController::class, 'getUsers']);
        });
    });
});
