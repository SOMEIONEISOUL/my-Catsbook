<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{   
    public function showPosts()
    {
        $posts = Post::latest()->get();
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

    public function showPost($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function myPosts()
    {
        $posts = auth()->user()->posts()->latest()->get();

        return view('posts.my', compact('posts'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Вы не можете удалить чужой пост');
        }
        
        $post->delete();
        
        return redirect()->route('posts')->with('success', 'Пост успешно удален!');
    }

}
