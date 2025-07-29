@extends('layout.app')

@section('title', 'Профиль')

@section('content')
@include('partials.header')

<div class="profile-container">
    <div class="profile-header">
        <div class="profile-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="profile-info">
            <h1 class="profile-name">{{ auth()->user()->name }}</h1>
            <p class="profile-email">{{ auth()->user()->email }}</p>
            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-number">0</span>
                    <span class="stat-label">Постов</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">0</span>
                    <span class="stat-label">Лайков</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">0</span>
                    <span class="stat-label">Комментариев</span>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-content">
        <div class="profile-sidebar">
            <div class="sidebar-card">
                <h3 class="sidebar-title">Навигация</h3>
                <ul class="nav-list">
                    <li class="nav-item active">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user"></i> Профиль
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-book"></i> Мои посты
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-heart"></i> Избранное
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i> Настройки
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-card">
                <h3 class="sidebar-title">Статистика</h3>
                <div class="stats-list">
                    <div class="stat-row">
                        <span class="stat-key">Дата регистрации</span>
                        <span class="stat-value">{{ auth()->user()->created_at->format('d.m.Y') }}</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-key">Последний вход</span>
                        <span class="stat-value">{{ auth()->user()->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-main">
            <div class="profile-card">
                <div class="card-header">
                    <h2 class="card-title">Информация о профиле</h2>
                </div>
                <div class="card-body">
                    <div class="profile-details">
                        <div class="detail-row">
                            <label class="detail-label">Имя пользователя</label>
                            <div class="detail-value">{{ auth()->user()->name }}</div>
                        </div>
                        <div class="detail-row">
                            <label class="detail-label">Email</label>
                            <div class="detail-value">{{ auth()->user()->email }}</div>
                        </div>
                        <div class="detail-row">
                            <label class="detail-label">Статус</label>
                            <div class="detail-value">
                                <span class="status-badge active">Активен</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-card">
                <div class="card-header">
                    <h2 class="card-title">Действия</h2>
                </div>
                <div class="card-body">
                    <div class="actions-grid">
                        <a href="{{ route('posts.create') }}" class="action-card">
                            <div class="action-icon primary">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="action-content">
                                <h3 class="action-title">Создать пост</h3>
                                <p class="action-description">Написать новую статью</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('posts.my') }}" class="action-card">
                            <div class="action-icon secondary">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <div class="action-content">
                                <h3 class="action-title">Мои посты</h3>
                                <p class="action-description">Просмотреть свои статьи</p>
                            </div>
                        </a>
                        
                        <a href="#" class="action-card">
                            <div class="action-icon warning">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="action-content">
                                <h3 class="action-title">Настройки</h3>
                                <p class="action-description">Изменить настройки профиля</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('logout') }}" class="action-card" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="action-icon danger">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <div class="action-content">
                                <h3 class="action-title">Выйти</h3>
                                <p class="action-description">Завершить сеанс</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<style>
    .profile-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    /* Profile Header */
    .profile-header {
        background: linear-gradient(135deg, #864586ff 20%, #000000ff 100%);
        border-radius: 20px;
        padding: 3rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .profile-avatar {
        font-size: 5rem;
        color: rgba(255, 255, 255, 0.9);
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .profile-email {
        font-size: 1.2rem;
        opacity: 0.9;
        margin: 0 0 2rem 0;
    }

    .profile-stats {
        display: flex;
        gap: 2rem;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 2rem;
        font-weight: 700;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    /* Profile Content */
    .profile-content {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2rem;
    }

    /* Sidebar */
    .profile-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .sidebar-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        border: 1px solid #e1e5e9;
    }

    .sidebar-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin: 0 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e1e5e9;
    }

    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        margin-bottom: 0.25rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        text-decoration: none;
        color: #6c757d;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .nav-link i {
        margin-right: 0.75rem;
        width: 20px;
        text-align: center;
    }

    .nav-link:hover {
        background: #f8f9fa;
        color: #667eea;
    }

    .nav-item.active .nav-link {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .stats-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
    }

    .stat-key {
        color: #6c757d;
    }

    .stat-value {
        color: #333;
        font-weight: 500;
    }

    /* Main Content */
    .profile-main {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e1e5e9;
        overflow: hidden;
    }

    .card-header {
        background: #f8f9fa;
        padding: 1.5rem;
        border-bottom: 1px solid #e1e5e9;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Profile Details */
    .profile-details {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f3f4;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .detail-value {
        color: #6c757d;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-badge.active {
        background: #d4edda;
        color: #155724;
    }

    /* Actions */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .action-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        text-decoration: none;
        background: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid #e1e5e9;
    }

    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .action-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
    }

    .action-icon.primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .action-icon.secondary { background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); }
    .action-icon.warning { background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%); }
    .action-icon.danger { background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%); }

    .action-content {
        flex: 1;
    }

    .action-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin: 0 0 0.25rem 0;
    }

    .action-description {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 0;
    }

    /* Адаптивность */
    @media (max-width: 992px) {
        .profile-content {
            grid-template-columns: 1fr;
        }
        
        .profile-sidebar {
            flex-direction: row;
            flex-wrap: wrap;
        }
        
        .sidebar-card {
            flex: 1;
            min-width: 250px;
        }
    }

    @media (max-width: 768px) {
        .profile-container {
            margin: 1rem auto;
            padding: 0 0.5rem;
        }
        
        .profile-header {
            padding: 2rem 1.5rem;
            flex-direction: column;
            text-align: center;
        }
        
        .profile-stats {
            justify-content: center;
        }
        
        .actions-grid {
            grid-template-columns: 1fr;
        }
        
        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }

    @media (max-width: 480px) {
        .profile-header {
            padding: 1.5rem;
        }
        
        .profile-name {
            font-size: 2rem;
        }
        
        .profile-stats {
            flex-direction: column;
            gap: 1rem;
        }
        
        .action-card {
            padding: 1rem;
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

    .profile-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .profile-card:nth-child(1) { animation-delay: 0.1s; }
    .profile-card:nth-child(2) { animation-delay: 0.2s; }
</style>
@endsection