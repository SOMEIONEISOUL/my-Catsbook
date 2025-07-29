@extends('layout.app')
@section('title', 'Пост')
@section('content')
  @include('partials.header')
    <div class="post-detail-container">
        <article class="post-article">
            <header class="post-header">
                <h1 class="post-title">{{ $post->title }}</h1>
                <div class="post-meta">
                    <div class="meta-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $post->created_at->format('d.m.Y') }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="far fa-clock"></i>
                        <span>{{ $post->created_at->format('H:i') }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="far fa-user"></i>
                        <span>{{ $post->user->name ?? 'Аноним' }}</span>
                    </div>
                </div>
            </header>

            <div class="post-content">
                <p>{{ $post->content }}</p>
            </div>

            <footer class="post-footer">
                <div class="post-actions">
                    <a href="{{ route('posts') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Назад к списку постов
                    </a>
                    
                    @auth
                        @if($post->user_id === auth()->id())
                            <div class="post-owner-actions">
                                <form action="{{ route('posts.destroy',$post->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('Вы уверены, что хотите удалить пост &quot;{{ $post->title }}&quot;?')">
                                        <i class="fas fa-trash-alt"></i> Удалить
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                    
                    <div class="social-share">
                        <span>Поделиться:</span>
                        <a href="#" class="share-btn"> 
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="#" class="share-btn">
                            <i class="fab fa-vk"></i>
                        </a>
                        <a href="#" class="share-btn">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </footer>
        </article>
    </div>

    <style>
        .post-detail-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .post-article {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }
        
        .post-article:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        
        .post-header {
            padding: 2.5rem 2.5rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .post-title {
            margin: 0 0 1.5rem 0;
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1.3;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .post-meta {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            opacity: 0.9;
        }
        
        .meta-item i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }
        
        .post-content {
            padding: 2.5rem;
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }
        
        .post-content p {
            margin: 0 0 1.5rem 0;
            text-align: justify;
        }
        
        .post-content p:last-child {
            margin-bottom: 0;
        }
        
        .post-footer {
            padding: 0 2.5rem 2.5rem;
        }
        
        .post-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            border-top: 1px solid #e1e5e9;
            padding-top: 2rem;
        }
        
        .post-owner-actions {
            display: flex;
            gap: 0.8rem;
        }
        
        .btn {
            padding: 0.8rem 1.8rem;
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
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }
        
        .social-share {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        
        .social-share span {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .share-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f8f9fa;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid #e1e5e9;
        }
        
        .share-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .share-btn:nth-child(2):hover { background: #0088cc; color: white; }
        .share-btn:nth-child(3):hover { background: #4c75a3; color: white; }
        .share-btn:nth-child(4):hover { background: #1da1f2; color: white; }
        
        .delete-form {
            display: inline;
        }
        
        /* Адаптивность */
        @media (max-width: 768px) {
            .post-detail-container {
                margin: 1rem auto;
                padding: 0 0.5rem;
            }
            
            .post-header {
                padding: 1.5rem;
            }
            
            .post-title {
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }
            
            .post-meta {
                gap: 1rem;
                font-size: 0.85rem;
            }
            
            .post-content {
                padding: 1.5rem;
                font-size: 1rem;
            }
            
            .post-footer {
                padding: 0 1.5rem 1.5rem;
            }
            
            .post-actions {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }
            
            .post-owner-actions {
                order: -1;
            }
            
            .social-share {
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .post-meta {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .post-title {
                font-size: 1.5rem;
            }
            
            .post-content {
                padding: 1rem;
                font-size: 0.95rem;
                line-height: 1.6;
            }
            
            .post-owner-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
        
        /* Анимации */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .post-article {
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        .post-article:hover .post-title {
            animation: float 2s ease-in-out infinite;
        }
    </style>
@endsection