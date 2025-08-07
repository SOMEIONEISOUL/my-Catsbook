@extends('layout.app')
@section('title', 'Редактировать профиль')
@section('content')
    @include('partials.header')

    <div class="profile-edit-container">
        <h1 class="page-title">Редактировать профиль</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="edit-card">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group avatar-upload-group">
                    <label class="form-label">Аватар</label>
                    <div class="avatar-preview-container">
                        <!-- Обновлено: логика отображения предпросмотра -->
                        @if(auth()->user()->avatar_url)
                            <img id="avatarPreview" src="{{ auth()->user()->avatar_url }}" alt="Предпросмотр аватара"
                                class="avatar-preview">
                        @else
                            <div id="avatarPreviewPlaceholder" class="avatar-preview-placeholder-large">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <img id="avatarPreview" src="" alt="Предпросмотр аватара" class="avatar-preview"
                                style="display: none;">
                        @endif
                    </div>
                    <div class="avatar-controls">
                        <!-- Скрытое поле для указания, что аватар нужно удалить -->
                        <input type="hidden" name="remove_avatar" id="removeAvatarInput" value="0">

                        <!-- Кнопка выбора файла -->
                        <input type="file" name="avatar" id="avatarInput" class="form-control-file" accept="image/*"
                            style="display: none;">
                        <button type="button" class="btn btn-secondary" id="chooseAvatarBtn">
                            Выбрать файл
                        </button>

                        <!-- Кнопка сброса аватара (показывается только если аватар есть) -->
                        @if(auth()->user()->avatar_url)
                            <button type="button" class="btn btn-outline-danger" id="removeAvatarBtn">
                                <i class="fas fa-trash-alt"></i> Удалить аватар
                            </button>
                        @endif
                    </div>
                    <small class="form-text text-muted">Выберите изображение (JPEG, PNG, JPG, GIF, WebP, до 2MB)</small>
                </div>

                <div class="form-group">
                    <label for="name" class="form-label">Имя пользователя</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', auth()->user()->name) }}" required>
                </div>

                <div class="form-actions">
                    <a href="{{ route('profile') }}" class="btn btn-secondary">Отмена</a>
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .profile-edit-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .page-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .edit-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            border: 1px solid #e1e5e9;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #667eea;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-control-file {
            width: 100%;
            padding: 0.5rem 0;
        }

        .form-text {
            display: block;
            margin-top: 0.25rem;
        }

        .text-muted {
            color: #6c757d;
        }

        .avatar-upload-group {
            text-align: center;
        }

        .avatar-preview-container {
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .avatar-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e1e5e9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .avatar-preview-placeholder-large {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
            color: #6c757d;
            border: 3px solid #e1e5e9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #f8f9fa;
        }

        /* Новые стили для элементов управления аватаром */
        .avatar-controls {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            align-items: center;
            margin: 1rem 0;
        }

        .btn-outline-danger {
            background: transparent;
            border: 2px solid #dc3545;
            color: #dc3545;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
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

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
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

        @media (max-width: 480px) {
            .profile-edit-container {
                margin: 1rem auto;
                padding: 0 0.5rem;
            }

            .edit-card {
                padding: 1.5rem;
            }

            .avatar-preview,
            .avatar-preview-placeholder-large {
                width: 120px;
                height: 120px;
                font-size: 4rem;
            }

            .form-actions {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

    <script>
        // Обновлённый JavaScript для управления аватаром
        document.addEventListener('DOMContentLoaded', function () {
            const avatarInput = document.getElementById('avatarInput');
            const avatarPreview = document.getElementById('avatarPreview');
            const avatarPreviewPlaceholder = document.getElementById('avatarPreviewPlaceholder');
            const removeAvatarBtn = document.getElementById('removeAvatarBtn');
            const removeAvatarInput = document.getElementById('removeAvatarInput');
            const chooseAvatarBtn = document.getElementById('chooseAvatarBtn');

            // Кнопка выбора файла
            if (chooseAvatarBtn && avatarInput) {
                chooseAvatarBtn.addEventListener('click', function () {
                    avatarInput.click();
                });
            }

            // Обработка выбора файла
            if (avatarInput && avatarPreview) {
                avatarInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            // Показываем img и скрываем placeholder
                            avatarPreview.src = e.target.result;
                            avatarPreview.style.display = 'block';
                            if (avatarPreviewPlaceholder) {
                                avatarPreviewPlaceholder.style.display = 'none';
                            }
                            // Сбрасываем флаг удаления аватара
                            if (removeAvatarInput) {
                                removeAvatarInput.value = '0';
                            }
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Кнопка удаления аватара
            if (removeAvatarBtn) {
                removeAvatarBtn.addEventListener('click', function () {
                    // Показываем placeholder и скрываем изображение
                    if (avatarPreviewPlaceholder) {
                        avatarPreviewPlaceholder.style.display = 'flex';
                    }
                    avatarPreview.style.display = 'none';
                    // Сбрасываем значение input файла
                    if (avatarInput) {
                        avatarInput.value = '';
                    }
                    // Устанавливаем флаг удаления аватара
                    if (removeAvatarInput) {
                        removeAvatarInput.value = '1';
                    }
                });
            }
        });
    </script>
@endsection