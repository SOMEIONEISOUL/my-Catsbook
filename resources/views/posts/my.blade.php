@extends('layout.app')

@section('title', 'Мои посты')

@section('content')
@include('partials.header')

<div class="my-posts-container">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">Мои посты</h1>
            <p class="page-subtitle">Все статьи, опубликованные вами</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Создать новый пост
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($posts->count() > 0)
        <div class="posts-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $posts->count() }}</div>
                    <div class="stat-label">Всего постов</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $posts->first()->created_at->format('d.m.Y') }}</div>
                    <div class="stat-label">Первый пост</div>
                </div>
            </div>
        </div>

        <div class="posts-grid">
            @foreach($posts as $post)
                <div class="post-card">
                    <div class="post-content">
                        <h3 class="post-title">{{ $post->title }}</h3>
                        
                        <div class="post-excerpt">
                            @if(strlen($post->content) > 150)
                                {{ substr($post->content, 0, 150) }}...
                            @else
                                {{ $post->content }}
                            @endif
                        </div>
                        
                        <div class="post-meta">
                            <div class="meta-item">
                                <i class="far fa-calendar"></i>
                                <span>{{ $post->created_at->format('d.m.Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="far fa-clock"></i>
                                <span>{{ $post->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="post-actions">
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye"></i> Просмотр
                        </a>
                        <div class="action-dropdown">
                          <button type="button" class="dropdown-item text-danger" onclick="confirmDelete({{ $post->id }})">
                            <i class="fas fa-trash"></i> Удалить
                          </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <h3 class="empty-title">У вас пока нет постов</h3>
            <p class="empty-description">Начните делиться своими мыслями и идеями</p>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Создать первый пост
            </a>
        </div>
    @endif
</div>

<!-- Форма удаления (скрыта) -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
    .my-posts-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e1e5e9;
    }

    .header-content {
        flex: 1;
    }

    .page-title {
        color: #333;
        margin: 0 0 0.5rem 0;
        font-size: 2.5rem;
        font-weight: 700;
    }

    .page-subtitle {
        color: #6c757d;
        margin: 0;
        font-size: 1.1rem;
    }

    .header-actions .btn {
        white-space: nowrap;
    }

    /* Alert */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        animation: slideIn 0.5s ease-out;
    }

    .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .alert i {
        margin-right: 0.5rem;
        font-size: 1.2rem;
    }

    /* Stats */
    .posts-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid #e1e5e9;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .stat-content {
        flex: 1;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* Posts Grid */
    .posts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .post-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #e1e5e9;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .post-content {
        padding: 1.5rem;
        flex: 1;
    }

    .post-title {
        margin: 0 0 1rem 0;
        font-size: 1.3rem;
        font-weight: 600;
        color: #333;
        line-height: 1.4;
    }

    .post-excerpt {
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .post-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .meta-item i {
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }

    .post-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-top: 1px solid #e1e5e9;
        background: #f8f9fa;
    }

    .action-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        padding: 0.5rem;
        min-width: auto;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        padding: 0.5rem 0;
        min-width: 180px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .action-dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
        width: 100%;
        border: none;
        background: none;
        text-align: left;
        cursor: pointer;
    }

    .dropdown-item i {
        margin-right: 0.75rem;
        width: 20px;
        text-align: center;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
        color: #667eea;
    }

    .dropdown-item.text-danger:hover {
        background: #dc3545;
        color: white;
    }

    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e1e5e9;
    }

    .empty-icon {
        font-size: 5rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-title {
        color: #333;
        margin-bottom: 1rem;
        font-size: 2rem;
    }

    .empty-description {
        color: #6c757d;
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-outline-primary {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
    }

    .btn-outline-primary:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .my-posts-container {
            margin: 1rem auto;
            padding: 0 0.5rem;
        }

        .page-header {
            padding: 1.5rem;
            flex-direction: column;
            text-align: center;
        }

        .page-title {
            font-size: 2rem;
        }

        .posts-stats {
            grid-template-columns: 1fr;
        }

        .posts-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .post-card {
            margin-bottom: 1rem;
        }

        .post-actions {
            flex-direction: column;
            gap: 0.5rem;
            text-align: center;
        }

        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 1.8rem;
        }

        .posts-grid {
            grid-template-columns: 1fr;
        }

        .post-meta {
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }

        .btn i {
            margin-right: 0.3rem;
        }
    }

    /* Анимации */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

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

    .post-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .post-card:nth-child(2) { animation-delay: 0.1s; }
    .post-card:nth-child(3) { animation-delay: 0.2s; }
    .post-card:nth-child(4) { animation-delay: 0.3s; }
    .post-card:nth-child(5) { animation-delay: 0.4s; }
    .post-card:nth-child(6) { animation-delay: 0.5s; }
</style>

<script>
    function confirmDelete(postId) {
        if (confirm('Вы уверены, что хотите удалить этот пост?')) {
            const form = document.getElementById('delete-form');
            form.action = `/posts/${postId}`;
            form.submit();
        }
    }
</script>
@endsection