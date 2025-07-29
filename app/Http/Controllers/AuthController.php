<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginForm;
use App\Http\Requests\RegistrationForm;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("auth.login");
    }

    public function login(LoginForm $request)
    {
        $data = $request->validated();

        if(auth("web")->attempt($data))
        {
            return redirect(route("posts"));
        }

        return redirect(route("login"))->withErrors(["email" => 'Пользователь не найден, либо данные введнены не правильно']);
    }

    public function logout(Request $request)
    {
        auth('web')->logout();

        return redirect(route("posts"));
    }
    public function showRegisterForm()
    {
        return view("auth.register");
    } 

    public function register(RegistrationForm $request)
    {
        $data = $request->validated();
        
        $user = User::create([
            "name"=> $data["name"],
            "email"=> $data["email"],
            "password"=> bcrypt($data["password"]),
        ]);

        if($user)
        {
            auth("web")->login($user);
        }

        return redirect(route("posts"));
    }
}
