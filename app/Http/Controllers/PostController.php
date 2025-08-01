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
            'photo' => 'nullable|array|max:10',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|max:100',
            'content' => 'required',
        ]);

        if (!auth()->check()) {
        abort(403, 'Вы должны быть авторизованы');
        }

        $photoPaths = [];
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('posts', $filename, 'public');
                $photoPaths[] = $path;
            }
        }

        $validated['photo'] = json_encode($photoPaths);
        $validated['user_id'] = auth()->id();

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

    public function showTopPosts()
    {
        $posts = Post::with('user')->withCount('likes')->orderBy('likes_count', 'desc')->limit(10)->get();
        return view('posts.top', compact('posts'));
    }

}
