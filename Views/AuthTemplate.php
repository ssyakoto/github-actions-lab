<?php
namespace Views;

class AuthTemplate extends BaseTemplate
{
    public static function registerForm(): string
    {
        $template = parent::getTemplate();
        $title = 'Регистрация — spin4spin';
        
        $errors = $_SESSION['auth_errors'] ?? [];
        $old = $_SESSION['auth_old'] ?? [];
        unset($_SESSION['auth_errors'], $_SESSION['auth_old']);
        
        $errorsHtml = '';
        if (!empty($errors)) {
            $errorsHtml = '<div class="alert alert-danger mb-4">' . implode('<br>', array_map('htmlspecialchars', $errors)) . '</div>';
        }

        $content = '
        <style>
            /* Стилизация в духе spin4spin (минимализм) */
            .auth-card {
                max-width: 400px;
                margin: 4rem auto;
                border: 1px solid #e5e5e5;
                border-radius: 4px;
                background: #ffffff;
                box-shadow: none !important; /* Убираем тень bootstrap */
            }
            
            .auth-header {
                background: #ffffff;
                color: #111111;
                padding: 2rem 1.5rem 1rem;
                border-bottom: 1px solid #e5e5e5;
                text-align: center;
                border-radius: 4px 4px 0 0;
            }
            
            .auth-header h2 { 
                margin: 0; 
                font-size: 1.5rem; 
                font-weight: 600; 
                letter-spacing: -0.02em;
            }
            
            .auth-body { 
                padding: 2rem 1.5rem; 
            }
            
            .form-label { 
                font-weight: 500; 
                color: #111111; 
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
            }
            
            .form-control {
                border: 1px solid #e5e5e5;
                border-radius: 2px;
                padding: 0.75rem 0.5rem;
                font-size: 0.95rem;
                background: #fff;
            }
            
            .form-control:focus {
                border-color: #111111;
                box-shadow: none; /* Убираем синюю обводку */
            }
            
            .btn-auth {
                background: #000000 !important;
                border: 1px solid #000000 !important;
                color: #ffffff;
                border-radius: 2px;
                padding: 0.85rem 1rem;
                font-weight: 500;
                width: 100%;
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            
            .btn-auth:hover {
                opacity: 0.85;
                color: #ffffff !important;
            }
            
            .auth-link {
                text-align: center;
                margin-top: 2rem;
                color: #666666;
                font-size: 0.9rem;
            }
            
            .auth-link a {
                color: #000000;
                text-decoration: none;
                font-weight: 600;
                border-bottom: 1px solid #000000;
            }
            
            .auth-link a:hover { 
                text-decoration: none; 
                opacity: 0.7;
            }

            /* Переопределение Alert */
            .alert-danger {
                background: #ffe6e6;
                border: 1px solid #ffcccc;
                color: #cc0000;
                border-radius: 2px;
            }
        </style>
        <section class="container py-5">
            <div class="card auth-card">
                <div class="auth-header">
                    <h2>Регистрация</h2>
                </div>
                <div class="auth-body">
                    '.$errorsHtml.'
                    <form method="POST" action="/register/process">
                        <div class="mb-3">
                            <label class="form-label">Имя</label>
                            <input type="text" name="name" class="form-control"
                            value="'.htmlspecialchars($old['name'] ?? '').'" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                            value="'.htmlspecialchars($old['email'] ?? '').'" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                            <small class="text-muted">Минимум 6 символов</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Подтвердите пароль</label>
                            <input type="password" name="password_confirm" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-auth">Зарегистрироваться</button>
                    </form>
                    <div class="auth-link">
                        Уже есть аккаунт? <a href="/login">Войти</a>
                    </div>
                </div>
            </div>
        </section>';
        
        return str_replace(['{TITLE}', '{CONTENT}'], [$title, $content], $template);
    }

    public static function loginForm(): string
    {
        $template = parent::getTemplate();
        $title = 'Вход — spin4spin';
        
        $errors = $_SESSION['auth_errors'] ?? [];
        $old = $_SESSION['auth_old'] ?? [];
        $referer = $_SERVER['HTTP_REFERER'] ?? '/products';
        unset($_SESSION['auth_errors'], $_SESSION['auth_old']);
        
        $errorsHtml = '';
        if (!empty($errors)) {
            $errorsHtml = '<div class="alert alert-danger mb-4">' . implode('<br>', array_map('htmlspecialchars', $errors)) . '</div>';
        }

        $content = '
        <style>
            /* Стилизация в духе spin4spin (минимализм) */
            .auth-card {
                max-width: 400px;
                margin: 4rem auto;
                border: 1px solid #e5e5e5;
                border-radius: 4px;
                background: #ffffff;
                box-shadow: none !important;
            }
            
            .auth-header {
                background: #ffffff;
                color: #111111;
                padding: 2rem 1.5rem 1rem;
                border-bottom: 1px solid #e5e5e5;
                text-align: center;
                border-radius: 4px 4px 0 0;
            }
            
            .auth-header h2 { 
                margin: 0; 
                font-size: 1.5rem; 
                font-weight: 600; 
                letter-spacing: -0.02em;
            }
            
            .auth-body { 
                padding: 2rem 1.5rem; 
            }
            
            .form-label { 
                font-weight: 500; 
                color: #111111; 
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
            }
            
            .form-control {
                border: 1px solid #e5e5e5;
                border-radius: 2px;
                padding: 0.75rem 0.5rem;
                font-size: 0.95rem;
                background: #fff;
            }
            
            .form-control:focus {
                border-color: #111111;
                box-shadow: none;
            }
            
            .btn-auth {
                background: #000000 !important;
                border: 1px solid #000000 !important;
                color: #ffffff;
                border-radius: 2px;
                padding: 0.85rem 1rem;
                font-weight: 500;
                width: 100%;
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            
            .btn-auth:hover {
                opacity: 0.85;
                color: #ffffff !important;
            }
            
            .auth-link {
                text-align: center;
                margin-top: 2rem;
                color: #666666;
                font-size: 0.9rem;
            }
            
            .auth-link a {
                color: #000000;
                text-decoration: none;
                font-weight: 600;
                border-bottom: 1px solid #000000;
            }
            
            .auth-link a:hover { 
                text-decoration: none; 
                opacity: 0.7;
            }
        </style>
        <section class="container py-5">
            <div class="card auth-card">
                <div class="auth-header">
                    <h2>Вход в аккаунт</h2>
                </div>
                <div class="auth-body">
                    '.$errorsHtml.'
                    <form method="POST" action="/login/process">
                        <input type="hidden" name="referer" value="'.htmlspecialchars($referer).'">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                            value="'.htmlspecialchars($old['email'] ?? '').'" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Пароль</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-auth">Войти</button>
                    </form>
                    <div class="auth-link">
                        Нет аккаунта? <a href="/register">Зарегистрироваться</a>
                    </div>
                </div>
            </div>
        </section>';
        
        return str_replace(['{TITLE}', '{CONTENT}'], [$title, $content], $template);
    }
}