<?php

namespace App\Http\Controllers;

use App\Models\LostFound;
use Illuminate\Http\Request;

class LostFoundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LostFound::query();

        // Apply filters if provided
        if ($request->has('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Paginate the results
        $lostFoundItems = $query->with('user')
                                ->orderBy('created_at', 'desc')
                                ->paginate(12);

        // Format the response
        $data = [
            'list' => $lostFoundItems->items(),
            'total' => $lostFoundItems->total(),
            'pageNum' => $lostFoundItems->currentPage(),
            'pageSize' => $lostFoundItems->perPage(),
        ];

        return response()->json(['code' => 200, 'data' => $data, 'msg' => 'success']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:lost,found',
            'status' => 'required|in:looking,found',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Create the lost/found item
        $lostFound = LostFound::create([
            'title' => $request->title,
            'type' => $request->type,
            'status' => $request->status,
            'location' => $request->location,
            'cover_img' => $request->cover_img,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return response()->json(['code' => 200, 'data' => $lostFound, 'msg' => '发布成功']);
    }

    /**
     * Display the specified resource.
     */
    public function show(LostFound $lostFound)
    {
        return response()->json(['code' => 200, 'data' => $lostFound, 'msg' => 'success']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LostFound $lostFound)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:lost,found',
            'status' => 'required|in:looking,found',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Update the lost/found item
        $lostFound->update([
            'title' => $request->title,
            'type' => $request->type,
            'status' => $request->status,
            'location' => $request->location,
            'cover_img' => $request->cover_img,
            'description' => $request->description,
        ]);

        return response()->json(['code' => 200, 'data' => $lostFound, 'msg' => '更新成功']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LostFound $lostFound)
    {
        $lostFound->delete();
        return response()->json(['code' => 200, 'msg' => '删除成功']);
    }
}
