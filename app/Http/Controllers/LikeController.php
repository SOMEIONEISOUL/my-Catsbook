<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        // Проверяем, авторизован ли пользователь
        if (!auth()->check()) {
            return response()->json(['error' => 'Вы должны быть авторизованы'], 401);
        }

        // Проверяем, не лайкал ли уже пользователь этот пост
        $existingLike = Like::where('user_id', auth()->id())
                           ->where('post_id', $post->id)
                           ->first();

        if ($existingLike) {
            // Если лайк уже есть, удаляем его (отменяем лайк)
            $existingLike->delete();
            $liked = false;
        } else {
            // Если лайка нет, создаем новый
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
            $liked = true;
        }

        // Возвращаем обновленное количество лайков
        $likesCount = $post->likes()->count();

        return response()->json([
            'liked' => $liked,
            'likesCount' => $likesCount
        ]);
    }
}