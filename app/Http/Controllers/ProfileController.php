<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; 

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = auth()->user();
        return view("profile", compact("user"));
    }

    public function showOtherProfile($id)
    {
        $user = User::findOrFail($id);
        return view("profile", compact("user"));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'remove_avatar' => ['boolean'],
        ]);

        if ($request->boolean('remove_avatar')) {
            try {
                if ($user->avatar_path) {
                    Storage::disk('public')->delete($user->avatar_path);
                    $user->avatar_path = null;
                    $user->save();
                }
            } catch (\Exception $e) {
                return back()->withErrors(['avatar' => 'Ошибка при удалении аватара: ' . $e->getMessage()]);
            }

        }

        if ($request->hasFile('avatar') && !$request->boolean('remove_avatar')) {
            try {
                if ($user->avatar_path) {
                    Storage::disk('public')->delete($user->avatar_path);
                }

                $file = $request->file('avatar');
                $filename = 'avatars/' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('', $filename, 'public');

                $user->avatar_path = $path;
            } catch (\Exception $e) {
                return back()->withErrors(['avatar' => 'Ошибка при загрузке аватара: ' . $e->getMessage()]);
            }
        }

        $user->name = $validated['name'];
        $user->save();

        return redirect()->route('profile')->with('success', 'Профиль успешно обновлён!');
    }
}