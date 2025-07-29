
<meta name="csrf-token" content="{{ csrf_token() }}">
<header class="header">
    <nav class="navbar">
        <div class="nav-container">
            <!-- Логотип -->
            <div class="nav-brand">
                <a href="{{ route('home') }}" class="brand-link">
                    <i class="fas fa-blog brand-icon"></i>
                    <span class="brand-text">Catsbook</span>
                </a>
            </div>

            <!-- Навигация -->
            <div class="nav-menu">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') }}">
                    <i class="fas fa-home"></i> <span>Главная</span>
                </a>
                <a href="{{ route('posts') }}" class="nav-link {{ request()->routeIs('posts.*') && !request()->routeIs('posts.create') }}">
                    <i class="fas fa-book-reader"></i> <span>Посты</span>
                </a>
            </div>

            <!-- Правая часть -->
            <div class="nav-actions">
                @auth("web")
                    <div class="nav-buttons">
                        
                        <!-- Круглая кнопка профиля -->
                        <div class="profile-dropdown">
                            <div class="profile-trigger">
                                <div class="profile-circle">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="profile-menu">
                                <div class="profile-header">
                                    <div class="profile-avatar-circle">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="profile-info">
                                        <div class="profile-username">{{ auth()->user()->name }}</div>
                                        <div class="profile-email">{{ auth()->user()->email }}</div>
                                    </div>
                                </div>           
                                <a href="{{ route('profile') }}" class="profile-item">
                                    <i class="fas fa-user-circle"></i> Профиль
                                </a>
                                <a href="{{ route('posts.my') }}" class="profile-item">
                                    <i class="fas fa-list"></i> Мои посты
                                </a>
                                <a href="{{ route('posts.create') }}" class="profile-item">
                                    <i class="fas fa-plus-circle"></i> Создать пост
                                </a>
                                <div class="profile-divider"></div>
                                <a href="{{ route('logout') }}" class="profile-item logout-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Выйти
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-outline">
                            <i class="fas fa-sign-in-alt"></i> Войти
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Регистрация
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
</header>

<style>
    .header {
        background: white;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .navbar {
        padding: 0 2rem;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 70px;
    }

    /* Логотип */
    .nav-brand {
        flex-shrink: 0;
        position: relative;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .nav-brand::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-radius: 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }

    .nav-brand:hover::before {
        opacity: 1;
    }

    .nav-brand:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
    }

    .brand-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #333;
        font-weight: 800;
        font-size: 1.6rem;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .brand-link:hover {
        transform: scale(1.05);
    }

    .brand-icon {
        margin-right: 0.75rem;
        color: #667eea;
        font-size: 1.8rem;
        text-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* Навигация */
    .nav-menu {
        display: flex;
        gap: 2rem;
        flex: 1;
        justify-content: center;
    }

    .nav-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #6c757d;
        font-weight: 700;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .nav-link i {
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }

    .nav-link:hover {
        color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .nav-link.active {
        color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    /* Правая часть */
    .nav-actions {
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }

    .nav-buttons {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Кнопки авторизации */
    .auth-buttons {
        display: flex;
        gap: 0.75rem;
    }

    .btn {
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
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
        font-size: 0.9rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-outline {
        background: transparent;
        border: 2px solid #747474ff;
        color: #667eea;
    }

    .btn-outline:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }

    /* Круглая кнопка профиля */
    .profile-dropdown {
        position: relative;
    }

    .profile-trigger {
        display: flex;
        align-items: center;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 50%;
        transition: background 0.3s ease;
    }

    .profile-trigger:hover {
        background: #f0f0f0;
    }

    .profile-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #b60909ff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        transition: transform 0.2s ease;
    }

    .profile-trigger:hover .profile-circle {
        transform: scale(1.05);
    }

    .profile-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        padding: 1rem 0;
        min-width: 280px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 1000;
        border: 1px solid #e1e5e9;
    }

    .profile-dropdown:hover .profile-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .profile-header {
        display: flex;
        align-items: center;
        padding: 0 1.5rem 1rem;
        border-bottom: 1px solid #e1e5e9;
        margin-bottom: 0.5rem;
    }

    .profile-avatar-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #b60909ff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        margin-right: 1rem;
    }

    .profile-info {
        flex: 1;
    }

    .profile-username {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .profile-email {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .profile-divider {
        height: 1px;
        background: #e1e5e9;
        margin: 0.5rem 0;
    }

    .profile-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .profile-item i {
        margin-right: 0.75rem;
        width: 20px;
        text-align: center;
        font-size: 0.9rem;
    }

    .profile-item:hover {
        background: #f8f9fa;
        color: #667eea;
    }

    .logout-item:hover {
        background: #dc3545;
        color: white;
    }

    /* Адаптивность */
    @media (max-width: 992px) {
        .nav-container {
            padding: 0 1rem;
        }
        
        .nav-menu {
            gap: 1rem;
        }
        
        .nav-buttons {
            gap: 0.75rem;
        }
    }

    @media (max-width: 768px) {
        .nav-container {
            flex-wrap: wrap;
            height: auto;
            padding: 1rem;
        }
        
        .nav-menu {
            order: 3;
            width: 100%;
            justify-content: flex-start;
            margin-top: 1rem;
            gap: 0.5rem;
        }
        
        .nav-link {
            padding: 0.5rem;
            font-size: 0.9rem;
        }
        
        .nav-link span {
            display: none;
        }
        
        .nav-link i {
            margin-right: 0;
            font-size: 1.2rem;
        }
        
        .nav-buttons {
            gap: 0.5rem;
        }
        
        .btn span {
            display: none;
        }
        
        .btn i {
            margin-right: 0;
        }
        
        .auth-buttons {
            gap: 0.5rem;
        }
        
        .btn {
            padding: 0.5rem 0.8rem;
            font-size: 0.85rem;
        }
        
        .profile-circle {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .brand-text {
            display: none;
        }
        
        .brand-icon {
            margin-right: 0;
        }
        
        .nav-actions {
            margin-left: auto;
        }
    }

    /* Анимации */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .header {
        animation: fadeInDown 0.5s ease-out;
    }
</style>