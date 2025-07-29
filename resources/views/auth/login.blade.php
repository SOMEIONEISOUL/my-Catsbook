@extends('layout.app')

@section('title', 'Авторизация')

@section('content')
@include('partials.header')
<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h1 class="auth-title">Добро пожаловать</h1>
                <p class="auth-subtitle">Войдите в свою учетную запись</p>
            </div>

            <form method="POST" action="{{ route('login_process') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input name="email" 
                               type="email" 
                               id="email"
                               class="form-control @error('email') is-invalid @enderror" 
                               placeholder="Введите ваш email"
                               value="{{ old('email') }}"
                               required>
                    </div>
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Пароль</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input name="password" 
                               type="password" 
                               id="password"
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Введите ваш пароль"
                               required>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span class="checkmark"></span>
                        Запомнить меня
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Войти
                </button>

                <div class="auth-footer">
                    <p>Нет аккаунта? 
                        <a href="{{ route('register') }}" class="auth-link">Зарегистрироваться</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .auth-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .auth-container {
        width: 100%;
        max-width: 450px;
    }

    .auth-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        transition: transform 0.3s ease;
    }

    .auth-card:hover {
        transform: translateY(-5px);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .logo-icon {
        font-size: 3rem;
        color: #667eea;
        margin-bottom: 1rem;
    }

    .auth-title {
        color: #333;
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .auth-subtitle {
        color: #6c757d;
        font-size: 1rem;
        margin: 0;
    }

    .auth-form {
        margin-top: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 1.1rem;
    }

    .form-control {
        width: 100%;
        height: 50px;
        padding: 0 1rem 0 3rem;
        border: 2px solid #e1e5e9;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #fafbff;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background-color: white;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background-color: #fff5f5;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
    }

    .invalid-feedback i {
        margin-right: 0.5rem;
        font-size: 1rem;
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        cursor: pointer;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .remember-me input {
        margin-right: 0.5rem;
    }

    .btn {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn i {
        margin-right: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e1e5e9;
    }

    .auth-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .auth-link:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .forgot-link {
        display: block;
        margin-top: 0.5rem;
        color: #6c757d;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .forgot-link:hover {
        color: #667eea;
        text-decoration: underline;
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .auth-wrapper {
            padding: 0.5rem;
        }

        .auth-card {
            padding: 1.5rem;
            margin: 1rem;
        }

        .auth-title {
            font-size: 1.5rem;
        }

        .form-options {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {
        .auth-card {
            padding: 1.25rem;
        }

        .logo-icon {
            font-size: 2.5rem;
        }

        .auth-title {
            font-size: 1.3rem;
        }
    }

    /* Анимации */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .auth-card {
        animation: fadeInUp 0.6s ease-out;
    }
</style>
@endsection