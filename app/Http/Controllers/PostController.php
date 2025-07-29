<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{   
    public function showPosts(Post $post)
    {
        $posts = Post::latest()->get();
        $post->load('comments.user');
        return view('posts.index', compact('posts'));
    }

    public function createPost()
    {
        return view('posts.create');
    }

    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'content' => 'required',
        ]);

        if (!auth()->check()) {
        abort(403, 'Вы должны быть авторизованы');
        }

        $validated['user_id'] = auth()->id();

        Post::create($validated);

        return redirect()->route('posts')->with('success', 'Пост успешно создан!');
    }

    public function showPost(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function myPosts()
    {
        $posts = auth()->user()->posts()->latest()->get();

        return view('posts.my', compact('posts'));
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Вы не можете удалить чужой пост');
        }
        
        $post->delete();
        
        return redirect()->route('posts')->with('success', 'Пост успешно удален!');
    }

}
