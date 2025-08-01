@extends('layout.app')
@section('title', 'Главная страница')
@section('content')
  @include('partials.header')
<div class="hero-section">
    <div class="hero-container">
        <div class="hero-content">
            <h1 class="hero-title">Добро пожаловать в наш блог</h1>
            <p class="hero-subtitle">Откройте для себя интересные статьи, полезные советы и вдохновляющие истории</p>
            <div class="hero-actions">
                <a href="{{ route('posts') }}" class="btn btn-primary">
                    <i class="fas fa-book-reader"></i> Читать посты
                </a>
                <a href="{{ route('posts.create') }}" class="btn btn-outline">
                    <i class="fas fa-plus-circle"></i> Создать пост
                </a>
            </div>
        </div>
    </div>
</div>

<div class="features-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Почему выбирают нас</h2>
            <p class="section-subtitle">Лучшие возможности для ваших статей</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon bg1">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3 class="feature-title">Идеи и вдохновение</h3>
                <p class="feature-description">Находите вдохновение в тысячах статей от авторов со всего мира</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon bg2">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="feature-title">Сообщество</h3>
                <p class="feature-description">Присоединяйтесь к активному сообществу авторов и читателей</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon bg3">
                    <i class="fas fa-share-alt"></i>
                </div>
                <h3 class="feature-title">Распространение</h3>
                <p class="feature-description">Делитесь своими мыслями с миллионами пользователей</p>
            </div>
        </div>
    </div>
</div>

<div class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Готовы начать?</h2>
            <p class="cta-subtitle">Присоединяйтесь к нашему сообществу уже сегодня</p>
            <div class="cta-actions">
                @auth
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Создать пост
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Зарегистрироваться
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline">
                        <i class="fas fa-sign-in-alt"></i> Войти
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<style>
    /* Общие стили */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --primary-color: #667eea;
        --secondary-color: #764ba2;
        --light-bg: #f8f9fa;
        --dark-text: #333;
        --light-text: #ffffff;
        --gray-text: #6c757d;
        --border-radius: 12px;
        --box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        --transition: all 0.3s ease;
    }

    /* Hero Section */
    .hero-section {
        background: var(--primary-gradient);
        padding: 6rem 2rem;
        color: var(--light-text);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero-container {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-size: 2.8rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .hero-subtitle {
        font-size: 1.2rem;
        margin-bottom: 2.5rem;
        opacity: 0.9;
        line-height: 1.6;
    }

    .hero-actions {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    /* Features Section */
    .features-section {
        padding: 5rem 2rem;
        background: var(--light-bg);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 1rem;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: var(--gray-text);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2.5rem;
    }

    .feature-card {
        background: var(--light-text);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        text-align: center;
        transition: var(--transition);
        border: 1px solid #e1e5e9;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--light-text);
        font-size: 1.8rem;
    }

    /* Разноцветные иконки */
    .bg1 {
        background: var(--primary-gradient);
    }
    .bg2 {
        background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%);
    }
    .bg3 {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .feature-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 1rem;
    }

    .feature-description {
        color: var(--gray-text);
        line-height: 1.6;
    }

    /* CTA Section */
    .cta-section {
        background: var(--primary-gradient);
        color: var(--light-text);
        padding: 5rem 2rem;
        text-align: center;
    }

    .cta-content {
        max-width: 600px;
        margin: 0 auto;
    }

    .cta-title {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .cta-subtitle {
        font-size: 1.1rem;
        margin-bottom: 2.5rem;
        opacity: 0.9;
    }

    .cta-actions {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    /* Buttons */
    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn i {
        margin-right: 0.5rem;
    }

    .btn-primary {
        background: var(--light-text);
        color: var(--primary-color);
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
    }

    .btn-outline {
        background: transparent;
        border: 2px solid var(--light-text);
        color: var(--light-text);
    }

    .btn-outline:hover {
        background: var(--light-text);
        color: var(--primary-color);
        transform: translateY(-3px);
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.2rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .section-title, .cta-title {
            font-size: 1.8rem;
        }

        .features-grid {
            gap: 1.5rem;
        }

        .feature-card {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .hero-section {
            padding: 3rem 1rem;
        }

        .hero-title {
            font-size: 1.8rem;
        }

        .hero-actions,
        .cta-actions {
            flex-direction: column;
            align-items: center;
        }

        .btn {
            width: 100%;
            max-width: 300px;
        }

        .features-section,
        .cta-section {
            padding: 3rem 1rem;
        }
    }
</style>
@endsection