@extends('layout.app')
@section('title', 'Посты')
@section('content')
    @include('partials.header')
    <div class="posts-container">
        <div class="posts-header">
            <h1 class="page-title">Все посты</h1>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Создать пост
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="posts-grid">
            @forelse($posts as $post)
                <div class="post-card">
                    <div class="card-content">
                        <h3 class="post-title">{{ $post->title }}</h3>
                        <div class="post-meta">
                            <span class="meta-item">
                                <i class="far fa-calendar"></i>
                                {{ $post->created_at->format('d.m.Y') }}
                            </span>
                            <span class="meta-item">
                                <i class="far fa-clock"></i>
                                {{ $post->created_at->format('H:i') }}
                            </span>
                        </div>
                        <div class="card-actions">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary">
                                <i class="fas fa-book-reader"></i> Читать далее
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="no-posts">
                    <div class="no-posts-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>Посты не найдены</h3>
                    <p>Пока нет ни одного поста. Будьте первым, кто создаст пост!</p>
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Создать первый пост
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .posts-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .posts-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            color: #333;
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
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

        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .post-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #e1e5e9;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-content {
            padding: 1.5rem;
        }

        .post-title {
            margin: 0 0 1rem 0;
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            line-height: 1.4;
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

        .card-actions {
            display: flex;
            justify-content: flex-end;
        }

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
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
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

        .no-posts {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            background: #f8f9fa;
            border-radius: 12px;
            margin: 2rem 0;
        }

        .no-posts-icon {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .no-posts h3 {
            color: #333;
            margin-bottom: 1rem;
        }

        .no-posts p {
            color: #6c757d;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .posts-container {
                margin: 1rem auto;
                padding: 0 0.5rem;
            }

            .posts-header {
                flex-direction: column;
                text-align: center;
            }

            .page-title {
                font-size: 2rem;
            }

            .posts-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .post-card {
                margin-bottom: 1rem;
            }

            .card-content {
                padding: 1rem;
            }

            .post-meta {
                flex-direction: column;
                gap: 0.5rem;
            }

            .card-actions {
                justify-content: center;
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

        .post-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .post-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .post-card:nth-child(4) {
            animation-delay: 0.3s;
        }

        .post-card:nth-child(5) {
            animation-delay: 0.4s;
        }

        .post-card:nth-child(6) {
            animation-delay: 0.5s;
        }
    </style>
@endsection