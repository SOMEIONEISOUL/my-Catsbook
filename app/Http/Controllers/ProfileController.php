<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
