<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    public function store(Comment $comment)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Вы должны быть авторизованы'], 401);
        }

        $existingLike = CommentLike::where('user_id', auth()->id())
                           ->where('comment_id', $comment->id)
                           ->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            CommentLike::create([
                'user_id' => auth()->id(),
                'comment_id' => $comment->id,
            ]);
            $liked = true;
        }

        $likesCount = $comment->likes()->count();

        return response()->json([
            'liked' => $liked,
            'likesCount' => $likesCount
        ]);
    }
}