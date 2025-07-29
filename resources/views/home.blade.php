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
        <div class="hero-image">
            <i class="fas fa-blog hero-icon"></i>
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
                <div class="feature-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3 class="feature-title">Идеи и вдохновение</h3>
                <p class="feature-description">Находите вдохновение в тысячах статей от авторов со всего мира</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="feature-title">Сообщество</h3>
                <p class="feature-description">Присоединяйтесь к активному сообществу авторов и читателей</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
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
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 4rem 0;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .hero-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: center;
    }
    
    .hero-content {
        animation: fadeInLeft 1s ease-out;
    }
    
    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        margin: 0 0 1rem 0;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .hero-subtitle {
        font-size: 1.25rem;
        margin: 0 0 2rem 0;
        opacity: 0.9;
        line-height: 1.6;
    }
    
    .hero-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .hero-image {
        text-align: center;
        animation: fadeInRight 1s ease-out;
    }
    
    .hero-icon {
        font-size: 8rem;
        opacity: 0.8;
        animation: float 3s ease-in-out infinite;
    }
    /* Features Section */
    .features-section {
        padding: 5rem 0;
        background: #f8f9fa;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        margin: 0 0 1rem 0;
    }
    
    .section-subtitle {
        font-size: 1.1rem;
        color: #6c757d;
        margin: 0;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .feature-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid #e1e5e9;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
    }
    
    .feature-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
        margin: 0 0 1rem 0;
    }
    
    .feature-description {
        color: #6c757d;
        line-height: 1.6;
        margin: 0;
    }
    
    .cta-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 5rem 0;
        color: white;
        text-align: center;
    }
    
    .cta-content {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .cta-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0 0 1rem 0;
    }
    
    .cta-subtitle {
        font-size: 1.25rem;
        margin: 0 0 2rem 0;
        opacity: 0.9;
    }
    
    .cta-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    /* Buttons */
    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn i {
        margin-right: 0.5rem;
    }
    
    .btn-primary {
        background: white;
        color: #667eea;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
    }
    
    .btn-outline {
        background: transparent;
        border: 2px solid white;
        color: white;
    }
    
    .btn-outline:hover {
        background: white;
        color: #667eea;
        transform: translateY(-3px);
    }
    
    /* Адаптивность */
    @media (max-width: 992px) {
        .hero-container {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 2rem;
        }
        
        .hero-actions {
            justify-content: center;
        }
        
        .hero-title {
            font-size: 2.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .hero-section {
            padding: 2rem 0;
        }
        
        .hero-container {
            padding: 0 1rem;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .hero-icon {
            font-size: 5rem;
        }
        
        .features-section {
            padding: 3rem 0;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .cta-section {
            padding: 3rem 0;
        }
        
        .cta-title {
            font-size: 2rem;
        }
        
        .cta-subtitle {
            font-size: 1rem;
        }
    }
    
    @media (max-width: 480px) {
        .hero-actions,
        .cta-actions {
            flex-direction: column;
            width: 100%;
        }
        
        .btn {
            width: 100%;
        }
        
        .feature-card {
            padding: 1.5rem;
        }
    }
    
    /* Анимации */
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .feature-card {
        animation: slideInUp 0.8s ease-out;
    }
    
    .feature-card:nth-child(1) { animation-delay: 0.1s; }
    .feature-card:nth-child(2) { animation-delay: 0.3s; }
    .feature-card:nth-child(3) { animation-delay: 0.5s; }
</style>
@endsection
  