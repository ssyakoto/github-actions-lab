<?php
namespace Views;

class BaseTemplate
{
    public static function getTemplate(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $logoPath = '/assets/images/5.png';
        $cartCount = 0;
        $useSessions = $_COOKIE['cart_storage'] ?? 'session';
        
        if ($useSessions === 'session' && isset($_SESSION['basket']) && is_array($_SESSION['basket'])) {
            foreach ($_SESSION['basket'] as $item) {
                $cartCount += $item['quantity'] ?? 0;
            }
        } elseif ($useSessions === 'cookie' && isset($_COOKIE['basket'])) {
            $cookieCart = json_decode($_COOKIE['basket'], true);
            if (is_array($cookieCart)) {
                foreach ($cookieCart as $item) {
                    $cartCount += $item['quantity'] ?? 0;
                }
            }
        }

        $cartBadge = $cartCount > 0
            ? '<span class="cart-badge">'.$cartCount.'</span>'
            : '';

        $authBlock = '';
        if (isset($_SESSION['user_id'])) {
            $userName = htmlspecialchars($_SESSION['user_name'] ?? 'Пользователь');
            $authBlock = '
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <span class="user-avatar">'.$userName[0].'</span>
                    '.$userName.'
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="/profile">Профиль</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="/logout">Выйти</a></li>
                </ul>
            </li>';
        } else {
            $authBlock = '
            <li class="nav-item"><a class="nav-link" href="/login">Войти</a></li>
            <li class="nav-item"><a class="nav-link btn-nav-primary" href="/register">Регистрация</a></li>';
        }

        return '
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{TITLE}</title>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                :root {
                    --bg-primary: #ffffff; --bg-secondary: #fafafa;
                    --text-primary: #111111; --text-secondary: #666666;
                    --text-muted: #999999; --border-color: #e5e5e5;
                    --accent: #000000; --radius: 4px;
                    --font-main: "Inter", sans-serif;
                }
                body { font-family: var(--font-main); background: var(--bg-primary); color: var(--text-primary); line-height: 1.6; }
                .navbar { background: #fff !important; border-bottom: 1px solid var(--border-color); padding: 0.75rem 0; box-shadow: none; }
                
                /* 🔹 ЛОГОТИП-КНОПКА */
                .navbar-brand {
                    padding: 0;
                    margin-right: 2rem;
                    transition: all 0.3s ease;
                }
                .navbar-brand:hover {
                    transform: scale(1.05);
                    opacity: 0.9;
                }
                .navbar-brand img {
                    height: 45px;
                    width: auto;
                    object-fit: contain;
                    border-radius: 8px;
                    transition: all 0.3s ease;
                }
                .navbar-brand:hover img {
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                }
                
                .nav-link { color: var(--text-secondary) !important; font-weight: 500; font-size: 0.95rem; padding: 0.5rem 1rem !important; transition: color 0.2s; }
                .nav-link:hover { color: var(--text-primary) !important; }
                .btn-nav-primary { background: var(--text-primary) !important; color: #fff !important; border-radius: var(--radius); padding: 0.5rem 1.25rem !important; }
                .user-avatar { width: 32px; height: 32px; background: var(--text-primary); color: #fff; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem; margin-right: 0.5rem; }
                .cart-badge { position: absolute; top: 0; right: 0; background: var(--text-primary); color: #fff; font-size: 0.625rem; font-weight: 700; padding: 0.15rem 0.4rem; border-radius: 10px; min-width: 18px; text-align: center; }
                footer { background: var(--bg-secondary) !important; border-top: 1px solid var(--border-color); padding: 2rem 0 !important; color: var(--text-secondary) !important; font-size: 0.875rem; }
                h1, h2, h3, h4, h5, h6 { font-weight: 600; letter-spacing: -0.02em; color: var(--text-primary); }
                a { color: var(--text-primary); text-decoration: none; }
                a:hover { text-decoration: underline; }
                .btn-primary { background: var(--text-primary); border-color: var(--text-primary); border-radius: var(--radius); }
                .btn-primary:hover { background: #333; border-color: #333; }
                .form-control { border: 1px solid var(--border-color); border-radius: var(--radius); }
                .form-control:focus { border-color: var(--text-primary); box-shadow: 0 0 0 3px rgba(0,0,0,0.08); }
                @media (max-width: 768px) { .navbar-collapse { background: #fff; padding: 1rem; border-top: 1px solid var(--border-color); margin-top: 1rem; } }
            </style>
        </head>
        <body>
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <!-- 🔹 ЛОГОТИП-КНОПКА (вместо текста) -->
                    <a class="navbar-brand" href="/" title="spin4spin - на главную">
                        <img src="'.$logoPath.'" alt="spin4spin" onerror="this.style.display=\'none\'">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="nav-item"><a class="nav-link" href="/">Главная</a></li>
                            <li class="nav-item"><a class="nav-link" href="/services">Коллекция</a></li>
                            <li class="nav-item"><a class="nav-link" href="/products">Каталог</a></li>
                            <li class="nav-item"><a class="nav-link" href="/about">О магазине</a></li>
                            <li class="nav-item position-relative mx-2">
                                <a class="nav-link" href="/cart" style="font-size: 1.25rem;">🛒'.$cartBadge.'</a>
                            </li>
                            '.$authBlock.'
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="container py-4">{CONTENT}</main>

            <footer>
                <div class="container text-center">
                    <p>© 2025 Магазин одежды «spin4spin»</p>
                </div>
            </footer>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>';
    }
}