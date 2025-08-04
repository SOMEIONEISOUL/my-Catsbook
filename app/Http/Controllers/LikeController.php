<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        
        if (!auth()->check()) {
            return response()->json(['error' => 'Вы должны быть авторизованы'], 401);
        }

        $existingLike = Like::where('user_id', auth()->id())
        ->where('post_id', $post->id)
        ->first();

        if ($existingLike) {

            $existingLike->delete();
            $liked = false;
        } else {
            
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
            $liked = true;
        }

        $likesCount = $post->likes()->count();

        return response()->json([
            'liked' => $liked,
            'likesCount' => $likesCount
        ]);
    }
}