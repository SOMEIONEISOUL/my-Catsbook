@extends('layout.app')
@section('title', 'Пост')
@section('content')
@include('partials.header')

<!-- Подключение Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<div class="post-detail-container">
    <article class="post-article">
        <header class="post-header">
            <h1 class="post-title">{{ $post->title }}</h1>

            <!-- Отображение нескольких фото через Swiper -->
            @php
                $photos = json_decode($post->photo, true) ?? [];
            @endphp

            @if(!empty($photos))
            <div class="swiper-container post-swiper">
                <div class="swiper-wrapper">
                    @foreach($photos as $photo)
                    <div class="swiper-slide">
                        <div class="post-slide-item">
                            <img src="{{ asset('storage/' . $photo) }}" alt="{{ $post->title }}" class="slide-image">
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Кнопки навигации -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Пагинация (опционально, можно убрать) -->
                <!-- <div class="swiper-pagination"></div> -->
            </div>
            @endif

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
                    @if($post->user)
                    <a href="{{ route('profile.public', $post->user->id) }}" class="author-link">
                        {{ $post->user->name }}
                    </a>
                    @else
                    <span>Аноним</span>
                    @endif
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
                <button class="btn btn-paw {{ ($userLiked ?? false) ? 'liked' : '' }}" id="likeButton" data-post-id="{{ $post->id }}">
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
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline delete-form">
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

        <!-- Комментарии -->
        <div class="post-comments">
            <h3>Комментарии ({{ $post->comments()->count() }})</h3>

            @auth
            <div class="comment-form-container">
                <form action="{{ route('comments.store', $post) }}" method="POST" class="comment-form">
                    @csrf
                    <div class="form-group">
                        <textarea name="text" class="form-control" placeholder="Напишите комментарий..." rows="3"
                            required></textarea>
                        @error('text')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primarys">Отправить</button>
                </form>
            </div>
            @else
            <div class="comment-login-prompt">
                <p><a href="{{ route('login') }}">Войдите</a>, чтобы оставить комментарий.</p>
            </div>
            @endauth

            <div class="comments-list">
                
                @forelse($post->comments->sortByDesc('likes_count')->sortByDesc('created_at')->values() as $comment)
                <div class="comment-item" id="comment-{{ $comment->id }}">
                    <div class="comment-header">
                        <strong>{{ $comment->user->name }}</strong>
                        <span class="comment-date">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="comment-text">{{ $comment->text }}</div>
                    <div class="comment-actions">
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

<!-- Подключение Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
    /* === SWIPER ГАЛЕРЕЯ === */
    .post-swiper {
        width: 100%;
        height: 400px; /* Высота слайдера */
        margin: 1.5rem 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .swiper-slide {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f0f0; /* Фон, если фото не загрузилось */
    }

    .post-slide-item {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slide-image {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Обрезает фото, чтобы заполнить контейнер */
        display: block;
    }

    /* Стили для кнопок навигации */
    .swiper-button-next,
    .swiper-button-prev {
        color: #667eea; /* Цвет стрелок */
        background: rgba(255, 255, 255, 0.7); /* Полупрозрачный фон */
        width: 40px;
        height: 40px;
        border-radius: 50%;
        transition: all 0.3s ease;
        margin-top: -20px; /* Центрирование по вертикали */
    }

    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 18px; /* Размер иконки стрелки */
        font-weight: bold;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background: rgba(255, 255, 255, 1);
        transform: scale(1.1);
    }

    /* Позиционирование кнопок */
    .swiper-button-next {
        right: 15px;
    }

    .swiper-button-prev {
        left: 15px;
    }

    /* Стили для пагинации (если будете использовать)
    .swiper-pagination {
        bottom: 10px;
    }
    .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.7);
        opacity: 1;
    }
    .swiper-pagination-bullet-active {
        background: #667eea;
    }
    */

    /* === ОСТАЛЬНЫЕ СТИЛИ (оригинальные, без изменений) === */
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
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
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

    .btn-primarys {
        background: #007bff;
        color: white;
    }

    .btn-primarys:hover {
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

    .likes-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        border: 2px solid #e1e5e9;
        border-radius: 50px;
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

    .author-link {
        color: #ffffff;
        text-decoration: underline;
        font-weight: 600;
        transition: color 0.2s ease;
        border-radius: 4px;
        padding: 2px 4px;
    }

    .author-link:hover,
    .author-link:focus {
        color: #e0e0e0;
        text-decoration: none;
        background-color: rgba(255, 255, 255, 0.1);
        outline: none;
    }

    .author-link:focus-visible {
        outline: 2px solid #ffffff;
        outline-offset: 2px;
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

        /* Адаптация Swiper для мобильных */
        .post-swiper {
            height: 300px;
        }

        .swiper-button-next,
        .swiper-button-prev {
            width: 30px;
            height: 30px;
            margin-top: -15px;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 14px;
        }

        .swiper-button-next {
            right: 10px;
        }

        .swiper-button-prev {
            left: 10px;
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

        .post-swiper {
            height: 250px;
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

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    .post-article:hover .post-title {
        animation: float 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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

    .comment-item {
        padding: 1.5rem;
        margin-bottom: 1rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .comment-text {
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .comment-actions {
        text-align: right;
    }

    .comment-actions .btn-link {
        padding: 0;
        text-decoration: none;
        outline: none;
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
        background: linear-gradient(135deg, #c32222ff 30%, #b335a8ff 100%);
        color: #ffffffff;
        padding: 0.7rem 1.3rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        border-radius: 50px;
        font-weight: 700;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 6px 20px rgba(245, 101, 187, 0.5);
    }

    .btn-paw:focus {
        outline: none;
        box-shadow: none;
    }

    .btn-paw:hover {
        background: linear-gradient(135deg, #e00d0dff 30%, #d20ec2ff 100%);
        color: white;
        transform: translateY(-3px) scale(1.08);
        box-shadow: 0 6px 20px rgba(245, 101, 187, 0.5);
    }

    .btn-paw.liked {
        background: linear-gradient(135deg, #e00d0dff 30%, #d20ec2ff 100%);
        color: white;
    }

    .btn-paw.liked .paw-icon {
        filter: invert(0);
        transform: scale(1.1);
    }

    .paw-icon {
        width: 24px;
        height: auto;
        filter: invert(1);
        transition: filter 0.3s ease, transform 0.3s ease;
    }


    .btn-comment-like {
        background: linear-gradient(135deg, #c32222ff 30%, #b335a8ff 100%);
        color: #ffffffff;
        padding: 0.7rem 1.3rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        border-radius: 50px;
        font-weight: 700;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 6px 20px rgba(245, 101, 187, 0.5);
    }

    .btn-comment-like:hover {
        background: linear-gradient(135deg, #e00d0dff 30%, #d20ec2ff 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(245, 101, 187, 0.5);
    }

    .btn-comment-like:focus {
        outline: none;
        box-shadow: none;
    }

    .comment-likes-info {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        color: #6c757d;
        font-size: 0.85rem;
    }
</style>

<script>
// Обработка отправки формы комментариев через AJAX
const commentForm = document.querySelector('.comment-form');
if (commentForm) {
    commentForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Предотвращаем стандартную отправку формы
        
        const formData = new FormData(this);
        const action = this.action;
        
        // Блокируем кнопку отправки во время запроса
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Отправка...';
        
        fetch(action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Очищаем форму
                this.reset();
                
                // Создаем и добавляем новый комментарий в DOM
                const commentsList = document.querySelector('.comments-list');
                if (commentsList) {
                    const noCommentsDiv = document.querySelector('.no-comments');
                    if (noCommentsDiv) {
                        noCommentsDiv.remove();
                    }
                    
                    const newComment = document.createElement('div');
                    newComment.className = 'comment-item';
                    newComment.id = `comment-${data.comment.id}`;
                    newComment.innerHTML = `
                        <div class="comment-header">
                            <strong>${data.comment.user.name}</strong>
                            <span class="comment-date">только что</span>
                        </div>
                        <div class="comment-text">${data.comment.text}</div>
                        <div class="comment-actions">
                            <button class="btn btn-comment-like" data-comment-id="${data.comment.id}">
                                <img src="${document.querySelector('.paw-icon').src}" alt="Лапка кошки" class="paw-icon">
                                <span class="likes-count">0</span>
                            </button>
                            <form action="/comments/${data.comment.id}" method="POST" class="delete-comment-form">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-link btn-sm text-danger" 
                                 onclick="return confirm('Вы уверены, что хотите удалить комментарий?')">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    `;
                    commentsList.prepend(newComment);
                    
                    // Добавляем обработчик лайка для нового комментария
                    const newLikeButton = newComment.querySelector('.btn-comment-like');
                    if (newLikeButton) {
                        newLikeButton.addEventListener('click', function() {
                            const commentId = this.dataset.commentId;
                            const icon = this.querySelector('.paw-icon');
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
                                countSpan.textContent = data.likesCount;
                                if (data.liked) {
                                    this.classList.add('liked');
                                    icon.style.filter = 'invert(0)';
                                } else {
                                    this.classList.remove('liked');
                                    icon.style.filter = 'invert(1)';
                                }
                            })
                            .catch(error => {
                                console.error('Ошибка:', error);
                            });
                        });
                    }
                }
                
            } else {
                alert('Ошибка при добавлении комментария');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при отправке комментария');
        })
        .finally(() => {
            // Восстанавливаем кнопку отправки
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        });
    });
}

// Делегирование события для обработки удаления комментариев через AJAX
// Используем делегирование, потому что новые комментарии добавляются динамически
document.addEventListener('submit', function(e) {
    // Проверяем, является ли цель (e.target) формой удаления комментария
    if (e.target.matches('.delete-comment-form')) {
        e.preventDefault(); // Предотвращаем стандартную отправку формы
        
        const form = e.target;
        const action = form.action;
        const method = form.querySelector('input[name="_method"]')?.value || form.method;
        
        // Блокируем кнопку отправки во время запроса
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Удаление...';
        
        // Собираем данные для отправки (включая CSRF токен и метод)
        const formData = new FormData(form);
        
        fetch(action, {
            method: 'POST', // Laravel обычно использует POST для DELETE через _method
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                // 'X-CSRF-TOKEN' уже в FormData через скрытое поле _token
                // Но можно и так, для надежности:
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
             // Проверяем, является ли ответ JSON
             const contentType = response.headers.get("content-type");
             if (contentType && contentType.indexOf("application/json") !== -1) {
                 return response.json();
             } else {
                 // Если не JSON, возможно, редирект или ошибка
                 return response.text().then(text => {
                     console.warn('Получен не JSON ответ:', text);
                     // Пытаемся преобразовать, если это возможно, или выбрасываем ошибку
                     try {
                         return JSON.parse(text);
                     } catch (e) {
                         // Если не JSON, создаем объект ошибки
                         return { success: false, message: 'Неожиданный ответ от сервера' };
                     }
                 });
             }
        })
        .then(data => {
            if (data.success) {
                // Удаляем комментарий из DOM
                const commentItem = form.closest('.comment-item');
                if (commentItem) {
                    commentItem.remove();
                    
                    // Проверяем, остались ли комментарии, и показываем сообщение "Пока нет комментариев" при необходимости
                     const commentsList = document.querySelector('.comments-list');
                     const commentItems = commentsList?.querySelectorAll('.comment-item');
                     if (commentsList && (!commentItems || commentItems.length === 0)) {
                         const noCommentsDiv = document.createElement('div');
                         noCommentsDiv.className = 'no-comments';
                         noCommentsDiv.innerHTML = '<p>Пока нет комментариев. Будьте первым!</p>';
                         commentsList.appendChild(noCommentsDiv);
                     }
                } else {
                    location.reload(); // Или location.href = location.href;
                }
            } else {
                const errorMsg = data.message || data.error || 'Ошибка при удалении комментария';
                alert(errorMsg);
                console.error('Ошибка удаления:', errorMsg);
            }
        })
        .catch(error => {
            console.error('Ошибка сети или парсинга:', error);
            alert('Произошла ошибка при удалении комментария: ' + error.message);
        })
        .finally(() => {
            // Восстанавливаем кнопку отправки
            if (submitButton && originalText) {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Инициализация Swiper
    const swiper = new Swiper('.post-swiper', {
        // Основные параметры
        loop: false, // Можно включить, если нужно зациклить
        slidesPerView: 1,
        spaceBetween: 0,
        // Навигация кнопками
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    // --- ОСНОВНОЙ JAVASCRIPT ДЛЯ ЛАЙКОВ И КОММЕНТАРИЕВ ---

    // Лайк поста
    const likeButton = document.getElementById('likeButton');
    if (likeButton) {
        const isInitiallyLiked = likeButton.classList.contains('liked');
        likeButton.addEventListener('click', function () {
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

    // Лайки комментариев
    document.querySelectorAll('.btn-comment-like').forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.dataset.commentId;
            const icon = this.querySelector('.paw-icon');
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
                countSpan.textContent = data.likesCount;
                if (data.liked) {
                    this.classList.add('liked');
                    icon.style.filter = 'invert(0)';
                } else {
                    this.classList.remove('liked');
                    icon.style.filter = 'invert(1)';
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
        });
    });
    

});
</script>
@endsection