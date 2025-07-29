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
                        <button class="btn btn-paw" id="likeButton" data-post-id="{{ $post->id }}">
                            <img src="{{ asset('images/pets.png') }}" alt="Лапка кошки" class="paw-icon">
                            <span id="likesCount">{{ $post->likesCount() }}</span>
                        </button>
                    @else
                        <div class="likes-info">
                            <img src="{{ asset('images/pets.png') }}" alt="Лапка кошки" class="paw-icon">
                            <span>{{ $post->likesCount() }}</span>
                        </div>
                    @endauth
                    
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
            <div class="post-comments">
    <h3>Комментарии ({{ $post->comments()->count() }})</h3>
    
    @auth
        <div class="comment-form-container">
            <form action="{{ route('comments.store', $post) }}" method="POST" class="comment-form">
                @csrf
                <div class="form-group">
                    <textarea name="text" class="form-control" placeholder="Напишите комментарий..." rows="3" required></textarea>
                    @error('text')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
    @else
        <div class="comment-login-prompt">
            <p><a href="{{ route('login') }}">Войдите</a>, чтобы оставить комментарий.</p>
        </div>
    @endauth
        <div class="comments-list">
    @forelse($post->comments as $comment)
        <div class="comment-item" id="comment-{{ $comment->id }}">
            <div class="comment-header">
                <strong>{{ $comment->user->name }}</strong>
                <span class="comment-date">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
            </div>
            <div class="comment-text">
                {{ $comment->text }}
            </div>
            <div class="comment-actions">
                <!-- Кнопка лайка для комментария -->
                @auth
                    <button class="btn btn-comment-like" data-comment-id="{{ $comment->id }}">
                        <img src="{{ asset('images/pets.png') }}" alt="Лапка кошки" class="paw-icon">
                        <span class="likes-count">{{ $comment->likesCount() }}</span>
                    </button>
                @else
                    <div class="comment-likes-info">
                        <i class="far fa-heart"></i>
                        <span>{{ $comment->likesCount() }}</span>
                    </div>
                @endauth

                @auth
                    @if($comment->user_id === auth()->id())
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="delete-comment-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link btn-sm text-danger" 
                                    onclick="return confirm('Вы уверены, что хотите удалить комментарий?')">
                                Удалить
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    @empty
        <div class="no-comments">
            <p>Пока нет комментариев. Будьте первым!</p>
        </div>
    @endforelse
    </div>
    </div>
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
        
        /* Стили для кнопки лайка */
        .btn-like {
            background: #fff;
            color: #dc3545;
            border: 2px solid #dc3545;
            padding: 0.6rem 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-like:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }
        
        .btn-like.liked {
            background: #dc3545;
            color: white;
        }
        
        .likes-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            color: #6c757d;
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
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .heart-pulse {
            animation: pulse 0.3s ease;
        }

        .post-comments {
            margin-top: 2rem;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 0 0 16px 16px;
        }

        .post-comments h3 {
            margin-bottom: 1.5rem;
            color: #333;
            border-bottom: 2px solid #e1e5e9;
            padding-bottom: 0.5rem;
        }

        .comment-form-container {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .comment-form .form-group {
            margin-bottom: 1rem;
        }

        .comment-form textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            resize: vertical;
            font-family: inherit;
        }

        .comment-form textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .comment-login-prompt {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .comment-item {
            padding: 1.5rem;
            margin-bottom: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .comment-item:last-child {
            margin-bottom: 0;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        .comment-header strong {
            color: #667eea;
        }

        .comment-date {
            color: #6c757d;
        }

        .comment-text {
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .comment-actions {
            text-align: right;
        }

        .comment-actions .btn-link {
            padding: 0;
            text-decoration: none;
        }

        .no-comments {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .text-danger {
            color: #dc3545;
        }

        .btn-link.text-danger:hover {
            color: #c82333 !important;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .btn-paw {
            background: linear-gradient(135deg, #ff9a9e 30%, #fad0c4 100%);
            color: #ffffffff;
            border: 2px solid #f39c12;
            padding: 0.7rem 1.3rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 10px rgba(243, 156, 18, 0.3);
        }
        
        .btn-paw:focus {
            outline: none;
            box-shadow: none; 
        }

        .btn-paw:hover {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            transform: translateY(-3px) scale(1.08);
            box-shadow: 0 6px 20px rgba(243, 156, 18, 0.5);
        }

        .btn-paw.liked {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: black;
            border-color: #c0392b;
            animation: bounce 0.6s ease;
        }

        .paw-icon {
            width: 24px;
            height: auto;
            filter: invert(1);
            transition: filter 0.3s ease, transform 0.3s ease;
        }

        .btn-paw.liked .paw-icon {
            filter: invert(0);
            transform: scale(1.1);
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0) scale(1); }
            40% { transform: translateY(-10px) scale(1.1); }
            60% { transform: translateY(-5px) scale(1.05); }
        }

        .likes-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border: 2px solid #e1e5e9;
            border-radius: 50px;
            color: #6c757d;
        }

        .likes-info .fa-paw {
            color: #ff6b6b;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .heart-pulse {
            animation: pulse 0.3s ease;
        }
        .btn-comment-like {
            background: linear-gradient(135deg, #232f82ff 30%, #8c00ffff 100%);
            color: #ffffffff;
            border: 2px solid #001649ff;
            padding: 0.3rem 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.1rem;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 10px rgba(243, 156, 18, 0.3);
        }
        .btn-comment-like:focus {
            outline: none;
            box-shadow: none; 
        }

        .btn-comment-like:hover {
            background: #800056ff;
            color: white;
            transform: translateY(-1px);
        }

        .btn-comment-like.liked {
            background: #dc3545;
            color: white;
        }

        .comment-likes-info {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.75rem;
            border: 1px solid #e1e5e9;
            border-radius: 12px;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .comment-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.5rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const likeButton = document.getElementById('likeButton');
        if (likeButton) {
            likeButton.addEventListener('click', function() {
                const postId = this.dataset.postId;
                const icon = this.querySelector('.paw-icon');
                const countSpan = this.querySelector('span');

                icon.classList.add('heart-pulse');
                fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    
                    countSpan.textContent = data.likesCount;
                    
                    if (data.liked) {
                        this.classList.add('liked');
                    } else {
                        this.classList.remove('liked');
                    }
                    
                    setTimeout(() => {
                        icon.classList.remove('heart-pulse');
                    }, 300);
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    icon.classList.remove('heart-pulse');
                });
            });
        }
    });
        document.querySelectorAll('.btn-comment-like').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const icon = this.querySelector('i');
            const countSpan = this.querySelector('.likes-count');
            
            fetch(`/comments/${commentId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }
                
                // Обновляем счетчик лайков
                countSpan.textContent = data.likesCount;
                
                // Обновляем иконку
                if (data.liked) {
                    icon.className = 'fas fa-heart';
                    this.classList.add('liked');
                } else {
                    icon.className = 'far fa-heart';
                    this.classList.remove('liked');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
        });
    });
    </script>
@endsection