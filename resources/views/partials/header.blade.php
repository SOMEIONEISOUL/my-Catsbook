<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Catsbook</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Подключение Font Awesome (предполагается, что вы используете CDN или локальные файлы) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --color-primary: #667eea;
            --color-primary-dark: #5a6fd8;
            --color-secondary: #764ba2;
            --color-background: #ffffff;
            --color-text: #333333;
            --color-text-secondary: #6c757d;
            --color-border: #e1e5e9;
            --color-hover-bg: #f8f9fa;
            --color-danger: #dc3545;
            --shadow-default: 0 2px 20px rgba(0, 0, 0, 0.1);
            --shadow-dropdown: 0 10px 30px rgba(0, 0, 0, 0.15);
            --border-radius: 8px;
            --border-radius-circle: 50%;
            --transition-default: all 0.3s ease;
            --navbar-height: 70px;
            --max-width-container: 1200px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: var(--color-text);
            /* background-color: #f5f7fa; */ /* Убран фон страницы */
        }


        /* Хедер */
        .site-header {
            background: var(--color-background);
            box-shadow: var(--shadow-default);
            position: sticky;
            top: 0;
            z-index: 1000;
            animation: fadeInDown 0.5s ease-out;
        }

        .navbar {
            padding: 0 clamp(1rem, 3vw, 2rem);
        }

        .nav-container {
            max-width: var(--max-width-container);
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: var(--navbar-height);
            gap: 1rem; /* Общий отступ между частями */
        }

        /* Логотип */
        .nav-brand {
            flex-shrink: 0;
        }

        .brand-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--color-text);
            font-weight: 700;
            font-size: clamp(1.2rem, 2.5vw, 1.5rem);
            transition: var(--transition-default);
        }

        .brand-link:hover {
            color: var(--color-primary);
        }

        .brand-icon {
            margin-right: 0.5rem;
            color: var(--color-primary);
            font-size: 1.5rem;
        }

        .brand-text {
            /* Управление видимостью текста логотипа на маленьких экранах */
        }

        /* Навигация */
        .nav-menu {
            display: flex;
            gap: clamp(1rem, 2vw, 2rem);
            flex: 1;
            justify-content: center;
        }

        .nav-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--color-text-secondary);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition-default);
            white-space: nowrap;
        }

        .nav-link i {
            margin-right: 0.5rem;
            font-size: 0.9rem;
            min-width: 16px;
            text-align: center;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: var(--color-primary);
            background: rgba(102, 126, 234, 0.1);
            outline: none; /* Убираем outline при фокусе */
        }

        .nav-link.active {
            color: var(--color-primary);
            background: rgba(102, 126, 234, 0.1);
        }

        /* Правая часть */
        .nav-actions {
            display: flex;
            align-items: center;
            flex-shrink: 0;
            gap: 1rem;
        }

        .nav-buttons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Кнопки авторизации */
        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        /* Общие стили для кнопок */
        .btn {
            padding: 0.6rem 1.2rem;
            border: 2px solid transparent;
            border-radius: var(--border-radius);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-default);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            height: 40px;
            box-sizing: border-box;
        }

        .btn i {
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        .btn:focus {
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
        }

        /* Стили для кнопки "Создать пост" */
        .btn-create-post {
            background: transparent;
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .btn-create-post:hover,
        .btn-create-post:focus {
            background: var(--color-primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Стили для кнопок входа/регистрации */
        .btn-primary {
            background: transparent;
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--color-primary);
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
            justify-content: center;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: var(--border-radius-circle);
            transition: background 0.3s ease;
            height: 60px;
            width: 60px;
            background: none;
            border: none;
            color: inherit; /* Наследуем цвет от родителя */
        }

        .profile-trigger:hover,
        .profile-trigger:focus {
            background: #f0f0f0;
            outline: none;
        }

        .profile-trigger:focus {
             outline: 2px solid var(--color-primary);
             outline-offset: 2px;
         }

        .profile-circle {
            width: 60px;
            height: 53px;
            border-radius: 60px;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
            transition: transform 0.2s ease;
        }

        .profile-trigger:hover .profile-circle,
        .profile-trigger:focus .profile-circle {
            transform: scale(1.05);
        }


        /* Выпадающее меню профиля */
        .profile-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: var(--color-background);
            border-radius: 16px;
            box-shadow: var(--shadow-dropdown);
            padding: 0;
            min-width: 280px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: var(--transition-default);
            z-index: 1000;
            border: 1px solid var(--color-border);
            list-style: none; /* Убираем маркеры списка */
        }

        /* Класс для открытого состояния меню */
        .profile-menu.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .profile-header {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--color-border);
        }

        .profile-avatar-circle {
            width: 50px;
            height: 50px;
            border-radius: var(--border-radius-circle);
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            margin-right: 1rem;
            flex-shrink: 0; /* Предотвращает сжатие аватара */
        }

        .profile-info {
            flex: 1;
            min-width: 0; /* Позволяет обрезать длинный текст */
        }

        .profile-username {
            font-weight: 600;
            color: var(--color-text);
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-email {
            font-size: 0.85rem;
            color: var(--color-text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-menu-list {
            list-style: none;
            margin: 0;
            padding: 0.5rem 0;
        }

        .profile-menu-item {
            margin: 0px;;
        }

        .profile-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            color: var(--color-text);
            transition: var(--transition-default);
            font-weight: 500;
            width: 100%; /* Занимает всю ширину для удобства клика */
        }

        .profile-item i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            font-size: 0.9rem;
        }

        .profile-item:hover,
        .profile-item:focus {
            background: var(--color-hover-bg);
            color: var(--color-primary);
            outline: none;
        }

        .logout-item:hover,
        .logout-item:focus {
            background: var(--color-danger);
            color: white;
        }
        
        /* Адаптивность */
        @media (max-width: 992px) {
            .nav-container {
                padding: 0 clamp(0.75rem, 2vw, 1rem);
            }
            .nav-menu {
                gap: 1rem;
            }
            .nav-buttons,
            .auth-buttons {
                gap: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                flex-wrap: wrap;
                height: auto;
                padding: 1rem;
                gap: 0.75rem;
            }
            .nav-menu {
                order: 3;
                width: 100%;
                justify-content: flex-start;
                margin-top: 1rem;
                gap: 0.5rem;
                flex-wrap: wrap; /* Позволяет перенос строк */
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
            .nav-buttons,
            .auth-buttons {
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
            .brand-text {
                /* display: none; */ /* Можно скрыть, если логотип не помещается */
            }
            .brand-icon {
                margin-right: 0;
            }
            .nav-actions {
                margin-left: auto;
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
            .nav-buttons,
            .auth-buttons {
                gap: 0.4rem;
            }
            .btn {
                padding: 0.4rem 0.6rem;
                font-size: 0.8rem;
            }
            .nav-link {
                 padding: 0.4rem;
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

    </style>
</head>
<body>
    <header class="site-header" role="banner">
        <nav class="navbar" role="navigation" aria-label="Основная навигация">
            <div class="nav-container">
                <!-- Логотип -->
                <div class="nav-brand">
                    <a href="{{ route('home') }}" class="brand-link">
                        <i class="fas fa-blog brand-icon" aria-hidden="true"></i>
                        <span class="brand-text">Catsbook</span>
                    </a>
                </div>
                <!-- Навигация -->
                <div class="nav-menu">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-home" aria-hidden="true"></i> <span>Главная</span>
                    </a>
                    <a href="{{ route('posts') }}" class="nav-link {{ request()->routeIs('posts') && !request()->routeIs('posts.top') ? 'active' : '' }}">
                        <i class="fas fa-book-reader" aria-hidden="true"></i> <span>Посты</span>
                    </a>
                    <a href="{{ route('posts.top') }}" class="nav-link {{ request()->routeIs('posts.top') ? 'active' : '' }}">
                        <i class="fas fa-fire" aria-hidden="true"></i> <span>Топ постов</span>
                    </a>
                </div>
                <!-- Правая часть -->
                <div class="nav-actions">
                    @auth("web")
                        <div class="nav-buttons">
                            <!-- Кнопка "Создать пост" -->
                            <a href="{{ route('posts.create') }}" class="btn btn-outline btn-create-post">
                                <i class="fas fa-plus-circle" aria-hidden="true"></i> <span>Создать пост</span>
                            </a>
                            <!-- Круглая кнопка профиля -->
                            <div class="profile-dropdown" data-dropdown>
                                <button class="profile-trigger" aria-haspopup="true" aria-expanded="false" aria-label="Меню профиля">
                                    <div class="profile-circle">
                                        <i class="fas fa-user" aria-hidden="true"></i>
                                    </div>
                                </button>
                                <div class="profile-menu" role="menu">
                                    <div class="profile-header">
                                        <div class="profile-avatar-circle">
                                            <i class="fas fa-user" aria-hidden="true"></i>
                                        </div>
                                        <div class="profile-info">
                                            <div class="profile-username">{{ auth()->user()->name }}</div>
                                            <div class="profile-email">{{ auth()->user()->email }}</div>
                                        </div>
                                    </div>
                                    <ul class="profile-menu-list">
                                        <li class="profile-menu-item">
                                            <a href="{{ route('profile') }}" class="profile-item" role="menuitem">
                                                <i class="fas fa-user-circle" aria-hidden="true"></i> Профиль
                                            </a>
                                        </li>
                                        <li class="profile-menu-item">
                                            <a href="{{ route('posts.my') }}" class="profile-item" role="menuitem">
                                                <i class="fas fa-list" aria-hidden="true"></i> Мои посты
                                            </a>
                                        </li>
                                        <li class="profile-menu-item" role="separator">
                                            <hr class="profile-divider">
                                        </li>
                                        <li class="profile-menu-item">
                                            <a href="{{ route('logout') }}" class="profile-item logout-item" role="menuitem"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Выйти
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="auth-buttons">
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt" aria-hidden="true"></i><span>Войти</span>
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus" aria-hidden="true"></i> <span>Регистрация</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdowns = document.querySelectorAll('[data-dropdown]');

            dropdowns.forEach(dropdown => {
                const trigger = dropdown.querySelector('.profile-trigger');
                const menu = dropdown.querySelector('.profile-menu');

                // Функция для открытия меню
                function openMenu() {
                    menu.classList.add('open');
                    trigger.setAttribute('aria-expanded', 'true');
                }

                // Функция для закрытия меню
                function closeMenu() {
                    menu.classList.remove('open');
                    trigger.setAttribute('aria-expanded', 'false');
                }

                // Переключение меню по клику на триггер
                trigger.addEventListener('click', function (e) {
                    e.stopPropagation(); // Предотвращаем всплытие события
                    const isOpen = menu.classList.contains('open');
                    closeAllMenus(); // Закрываем все другие меню
                    if (!isOpen) {
                        openMenu();
                    }
                });

                // Закрытие меню при клике вне его области
                document.addEventListener('click', function (e) {
                    if (!dropdown.contains(e.target)) {
                        closeMenu();
                    }
                });

                 // Закрытие меню при потере фокуса (если фокус ушел за пределы меню)
                 dropdown.addEventListener('focusout', function(e) {
                     // Проверяем, находится ли новый элемент фокуса внутри этого дропдауна
                     // setTimeout нужен, чтобы событие focusout успело отработать
                     setTimeout(() => {
                         if (!dropdown.contains(document.activeElement)) {
                             closeMenu();
                         }
                     }, 1);
                 });
            });

            // Функция для закрытия всех открытых меню
            function closeAllMenus() {
                document.querySelectorAll('.profile-menu.open').forEach(menu => {
                    menu.classList.remove('open');
                    menu.closest('[data-dropdown]').querySelector('.profile-trigger').setAttribute('aria-expanded', 'false');
                });
            }

            // Закрытие меню при нажатии Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeAllMenus();
                }
            });
        });
    </script>
</body>
</html>