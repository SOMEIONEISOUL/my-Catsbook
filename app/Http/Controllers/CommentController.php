<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\CommentForm;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentForm $request, Post $post)
    {
        // Создаем комментарий
        $comment = $post->comments()->create([
            'text' => $request->text,
            'user_id' => auth()->id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user'),
                'message' => 'Комментарий добавлен успешно!'
            ]);
        }

        // Если обычный запрос, перенаправляем назад
        return redirect()->back()->with('success', 'Комментарий добавлен успешно!');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Вы не можете удалить чужой комментарий');
        }

        $comment->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Комментарий удален успешно!'
            ]);
        }

        return redirect()->back()->with('success', 'Комментарий удален успешно!');
    }
}