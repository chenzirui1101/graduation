<?php

namespace App\Http\Controllers\Api;

use App\Models\Reply;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * 获取话题列表
     */
    public function getTopics(Request $request)
    {
        $topics = Topic::with('user:id,username,avatar')
            ->select('id', 'title', 'content', 'user_id', 'replies_count', 'created_at')
            ->latest()
            ->paginate(10);

        // 格式化响应数据
        $formattedTopics = $topics->map(function ($topic) {
            return [
                'id' => $topic->id,
                'title' => $topic->title,
                'content' => $topic->content,
                'author' => [
                    'id' => $topic->user->id,
                    'username' => $topic->user->username,
                    'avatar' => $topic->user->avatar || 'https://picsum.photos/100/100?random=' . $topic->user->id
                ],
                'created_at' => $topic->created_at->format('Y-m-d H:i:s'),
                'replies_count' => $topic->replies_count
            ];
        });

        return response()->json([
            'code' => 200,
            'data' => $formattedTopics,
            'msg' => 'success',
            'total' => $topics->total()
        ]);
    }

    /**
     * 获取话题详情
     */
    public function getTopicDetail(Request $request, $id)
    {
        $topic = Topic::with('user:id,username,avatar')
            ->findOrFail($id);

        // 格式化响应数据
        $formattedTopic = [
            'id' => $topic->id,
            'title' => $topic->title,
            'content' => $topic->content,
            'author' => [
                'id' => $topic->user->id,
                'username' => $topic->user->username,
                'avatar' => $topic->user->avatar || 'https://picsum.photos/100/100?random=' . $topic->user->id
            ],
            'created_at' => $topic->created_at->format('Y-m-d H:i:s'),
            'replies_count' => $topic->replies_count
        ];

        return response()->json(['code' => 200, 'data' => $formattedTopic, 'msg' => 'success']);
    }

    /**
     * 获取话题评论
     */
    public function getComments(Request $request, $id)
    {
        $comments = Reply::with('user:id,username,avatar')
            ->where('topic_id', $id)
            ->latest()
            ->get();

        // 格式化响应数据
        $formattedComments = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'user' => [
                    'id' => $comment->user->id,
                    'username' => $comment->user->username,
                    'avatar' => $comment->user->avatar || 'https://picsum.photos/100/100?random=' . $comment->user->id
                ],
                'content' => $comment->content,
                'created_at' => $comment->created_at->format('Y-m-d H:i:s')
            ];
        });

        return response()->json(['code' => 200, 'data' => $formattedComments, 'msg' => 'success']);
    }

    /**
     * 添加评论
     */
    public function addComment(Request $request, $id)
    {
        // 获取当前用户（需要登录认证）
        $user = Auth::user();

        if (!$user) {
            return response()->json(['code' => 401, 'msg' => '请先登录'], 401);
        }

        // 创建评论
        $comment = Reply::create([
            'topic_id' => $id,
            'user_id' => $user->id,
            'content' => $request->input('content')
        ]);

        // 更新话题的回复数量
        $topic = Topic::findOrFail($id);
        $topic->increment('replies_count');

        // 加载用户信息
        $comment->load('user:id,username,avatar');

        // 格式化响应数据
        $formattedComment = [
            'id' => $comment->id,
            'user' => [
                'id' => $comment->user->id,
                'username' => $comment->user->username,
                'avatar' => $comment->user->avatar || 'https://picsum.photos/100/100?random=' . $comment->user->id
            ],
            'content' => $comment->content,
            'created_at' => $comment->created_at->format('Y-m-d H:i:s')
        ];

        return response()->json(['code' => 200, 'data' => $formattedComment, 'msg' => '评论添加成功']);
    }

    /**
     * 获取热门话题
     */
    public function getHotTopics(Request $request)
    {
        $hotTopics = Topic::select('id', 'title', 'replies_count')
            ->orderBy('replies_count', 'desc')
            ->take(5)
            ->get();

        return response()->json(['code' => 200, 'data' => $hotTopics, 'msg' => 'success']);
    }

    /**
     * 获取活跃用户
     */
    public function getActiveUsers(Request $request)
    {
        // 获取评论数最多的用户
        $activeUsers = Reply::select('user_id')
            ->selectRaw('COUNT(*) as reply_count')
            ->groupBy('user_id')
            ->orderBy('reply_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $user = \App\Models\User::find($item->user_id);
                return [
                    'id' => $user->id,
                    'username' => $user->username,
                    'avatar' => $user->avatar || 'https://picsum.photos/100/100?random=' . $user->id
                ];
            });

        return response()->json(['code' => 200, 'data' => $activeUsers, 'msg' => 'success']);
    }
}
