@extends('layout.app')
@section('title', 'Топ 10 популярных постов')
@section('content')
  @include('partials.header')

  <div class="top-posts-container">
    <h1 class="page-title">Топ 10 популярных постов</h1>
    <p class="page-subtitle">Посты с наибольшим количеством лайков</p>

    @if($posts->isEmpty())
      <div class="no-posts-message">
        <p>Пока нет постов для отображения.</p>
      </div>
    @else
      <div class="posts-grid">
        @foreach($posts as $index => $post)
          <article class="post-card">
            <div class="post-rank">
              <span class="rank-number">#{{ $index + 1 }}</span>
            </div>
            <div class="post-card-content">
              <header class="post-card-header">
                <h2 class="post-card-title">
                  <a href="{{ route('posts.show', $post) }}" class="post-link">{{ $post->title }}</a>
                </h2>
                
                <!-- Исправлено: логика отображения фото как в рабочем примере -->
                @php
                  // Предполагаем, что фото хранятся в поле $post->photo как JSON
                  $photos = json_decode($post->photo, true) ?? [];
                  // Берем первое фото для превью, если оно есть
                  $firstPhoto = !empty($photos) ? $photos[0] : null;
                @endphp
                @if($firstPhoto)
                  <div class="post-card-image">
                    <!-- Используем тот же путь, что и в рабочем примере -->
                    <img src="{{ asset('storage/' . $firstPhoto) }}" 
                         alt="{{ $post->title }}" 
                         class="post-image-preview">
                  </div>
                @endif
                <!-- Конец исправлений -->

                <div class="post-card-meta">
                  <div class="meta-item">
                    <i class="far fa-user"></i>
                    <span>{{ $post->user->name ?? 'Аноним' }}</span>
                  </div>
                  <div class="meta-item">
                    <i class="far fa-calendar-alt"></i>
                    <span>{{ $post->created_at->format('d.m.Y') }}</span>
                  </div>
                </div>
              </header>
              <div class="post-card-excerpt">
                <p>{{ Str::limit($post->content, 150) }}</p>
              </div>
              <footer class="post-card-footer">
                <div class="post-card-stats">
                  <div class="stat-item">
                    <img src="{{ asset('images/pets.png') }}" alt="Лапка кошки" class="paw-icon-small">
                    <span class="likes-count"> {{ $post->likesCount() }}</span>
                  </div>
                  <div class="stat-item">
                    <i class="far fa-comment"></i>
                    <span>Комментариев: {{ $post->comments()->count() }}</span>
                  </div>
                </div>
                <a href="{{ route('posts.show', $post) }}" class="btn btn-read-more">
                  Читать далее <i class="fas fa-arrow-right"></i>
                </a>
              </footer>
            </div>
          </article>
        @endforeach
      </div>
    @endif
  </div>

  <style>
    .top-posts-container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1rem;
    }

    .page-title {
      text-align: center;
      font-size: 2.5rem;
      font-weight: 800;
      color: #333;
      margin-bottom: 0.5rem;
    }

    .page-subtitle {
      text-align: center;
      font-size: 1.2rem;
      color: #6c757d;
      margin-bottom: 2rem;
    }

    .no-posts-message {
      text-align: center;
      padding: 3rem;
      background: #f8f9fa;
      border-radius: 12px;
      color: #6c757d;
    }

    .posts-grid {
      display: flex;
      flex-direction: column;
      gap: 2rem;
    }

    .post-card {
      display: flex;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      transition: all 0.3s ease;
      border: 1px solid #e1e5e9;
      position: relative;
    }

    .post-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .post-rank {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 80px;
    }

    .rank-number {
      font-size: 1.8rem;
      font-weight: 800;
    }

    .post-card-content {
      flex: 1;
      padding: 2rem;
      display: flex;
      flex-direction: column;
    }

    .post-card-header {
      margin-bottom: 1.5rem;
    }

    .post-card-title {
      margin: 0 0 1rem 0;
      font-size: 1.6rem;
      font-weight: 700;
    }

    .post-link {
      color: #333;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .post-link:hover {
      color: #667eea;
    }

    .post-card-image {
      margin: 1rem 0;
      text-align: center;
    }

    /* Исправлено: увеличен размер изображения */
    .post-image-preview {
      width: 100%;
      height: 500px; /* Увеличена высота с 200px до 300px */
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      display: block;
      margin: 0 auto;
    }

    .post-card-meta {
      display: flex;
      gap: 1.5rem;
      flex-wrap: wrap;
      color: #6c757d;
      font-size: 0.9rem;
    }

    .meta-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .post-card-excerpt {
      margin-bottom: 1.5rem;
      flex: 1;
    }

    .post-card-excerpt p {
      margin: 0;
      line-height: 1.6;
      color: #555;
    }

    .post-card-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-top: 1px solid #e1e5e9;
      padding-top: 1.5rem;
      margin-top: auto;
    }

    .post-card-stats {
      display: flex;
      gap: 1.5rem;
    }

    .stat-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: #6c757d;
      font-weight: 500;
    }

    .paw-icon-small {
      width: 20px;
      height: auto;
      filter: invert(30%); /* Темно-красный цвет для иконки лайка */
    }

    .btn-read-more {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 0.6rem 1.2rem;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
    }

    .btn-read-more:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    /* Адаптивность */
    @media (max-width: 768px) {
      .page-title {
        font-size: 2rem;
      }

      .post-card {
        flex-direction: column;
      }

      .post-rank {
        min-width: auto;
        padding: 0.5rem 1rem;
      }

      .rank-number {
        font-size: 1.4rem;
      }

      .post-card-content {
        padding: 1.5rem;
      }

      .post-card-title {
        font-size: 1.4rem;
      }

      .post-card-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }

      .post-card-stats {
        width: 100%;
        justify-content: space-between;
      }
      
      /* Адаптивные стили для изображения */
      .post-image-preview {
        height: 250px; /* Уменьшена высота на планшетах */
      }
    }

    @media (max-width: 480px) {
      .top-posts-container {
        margin: 1rem auto;
        padding: 0 0.5rem;
      }

      .page-title {
        font-size: 1.8rem;
      }

      .page-subtitle {
        font-size: 1rem;
      }

      .post-rank {
        padding: 0.3rem 0.8rem;
      }

      .rank-number {
        font-size: 1.2rem;
      }

      .post-card-content {
        padding: 1rem;
      }

      .post-card-title {
        font-size: 1.2rem;
      }

      .post-card-meta {
        gap: 1rem;
        font-size: 0.8rem;
      }

      .post-image-preview {
        height: 200px; /* Еще меньше на мобильных */
      }

      .btn-read-more {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
@endsection