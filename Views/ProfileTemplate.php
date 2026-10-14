<?php
namespace Views;

class ProfileTemplate extends BaseTemplate
{
    public static function render(array $user): string
    {
        $template = parent::getTemplate();
        $userName = isset($user['name']) ? $user['name'] : 'Пользователь';
        $userEmail = isset($user['email']) ? $user['email'] : '';
        $userPhone = isset($user['phone']) ? $user['phone'] : '';
        $userCard = isset($user['card_last4']) ? $user['card_last4'] : '';
        $userCreated = isset($user['created_at']) ? $user['created_at'] : date('Y-m-d H:i:s');
        $title = 'Профиль — ' . htmlspecialchars($userName);

        $errors = isset($_SESSION['profile_errors']) ? $_SESSION['profile_errors'] : [];
        $success = isset($_SESSION['profile_success']) ? $_SESSION['profile_success'] : '';
        unset($_SESSION['profile_errors'], $_SESSION['profile_success']);

        $alertsHtml = '';
        if (!empty($errors)) {
            $alertsHtml .= '<div class="alert alert-custom alert-danger">' . implode('<br>', array_map('htmlspecialchars', $errors)) . '</div>';
        }
        if (!empty($success)) {
            $alertsHtml .= '<div class="alert alert-custom alert-success">' . htmlspecialchars($success) . '</div>';
        }

        $phoneDisplay = !empty($userPhone) ? self::formatPhone($userPhone) : 'Не привязан';
        $cardDisplay = !empty($userCard) ? '•••• ' . $userCard : 'Не привязана';
        
        // Карточка карты (если привязана)
        $cardAlertBlock = '';
        if (!empty($userCard)) {
            $cardAlertBlock = '
            <div class="info-card mt-4" style="border-color:#e5e5e5; background:#fafafa;">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-uppercase ls-1 fw-bold">Текущая карта</span>
                    <span class="fw-bold">•••• •••• •••• '.htmlspecialchars($userCard).'</span>
                </div>
            </div>';
        }

        // 🔹 ИСТОРИЯ ЗАКАЗОВ
        $orderModel = new \Models\Order();
        $orders = $orderModel->getUserOrders($user['id']);
        $ordersHtml = '';
        if (empty($orders)) {
            $ordersHtml = '<div class="empty-state"><p class="text-muted">Заказов ещё нет. <a href="/products" style="color:#000; text-decoration:underline;">Перейти в каталог</a></p></div>';
        } else {
            foreach ($orders as $order) {
                $productsList = '';
                if (!empty($order['products'])) {
                    foreach ($order['products'] as $item) {
                        $pName = htmlspecialchars($item['product']['name'] ?? 'Товар');
                        $pQty = $item['quantity'] ?? 1;
                        $productsList .= '<div class="small text-muted">'.$pName.' × '.$pQty.'</div>';
                    }
                }
                
                $ordersHtml .= '
                <div class="order-item">
                    <div class="order-header">
                        <span class="order-id">Заказ #'.htmlspecialchars($order['order_id']).'</span>
                        <span class="order-date">'.date('d.m.Y', strtotime($order['created_at'])).'</span>
                    </div>
                    <div class="order-body">
                        <div class="order-products">
                            '.$productsList.'
                        </div>
                        <div class="order-actions">
                            <span class="order-amount">'.number_format($order['total'], 0, '.', ' ').' ₽</span>
                        </div>
                    </div>
                </div>';
            }
        }

        $customStyles = '
        <style>
            /* Luxury Profile Styles */
            :root {
                --color-text: #111111;
                --color-muted: #666666;
                --color-border: #e5e5e5;
                --color-accent: #000000;
                --font-main: "Inter", sans-serif;
            }

            body { font-family: var(--font-main); background: #fff; }
            
            .profile-wrapper {
                max-width: 900px;
                margin: 3rem auto;
                padding: 0 1rem;
            }

            /* Header */
            .profile-header {
                display: flex;
                align-items: center;
                gap: 1.5rem;
                border-bottom: 1px solid var(--color-border);
                padding-bottom: 2rem;
                margin-bottom: 2rem;
            }
            
            .profile-avatar {
                width: 72px;
                height: 72px;
                border-radius: 50%;
                background: var(--color-text);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.75rem;
                font-weight: 600;
                flex-shrink: 0;
            }
            
            .profile-info h1 {
                font-size: 1.75rem;
                font-weight: 600;
                margin: 0 0 0.25rem;
                color: var(--color-text);
            }
            .profile-info p {
                margin: 0;
                color: var(--color-muted);
                font-size: 0.95rem;
            }

            /* Navigation */
            .profile-nav {
                display: flex;
                gap: 2rem;
                border-bottom: 1px solid var(--color-border);
                margin-bottom: 2rem;
            }
            
            .profile-nav a {
                padding-bottom: 0.75rem;
                text-decoration: none;
                color: var(--color-muted);
                font-weight: 500;
                font-size: 0.9rem;
                border-bottom: 2px solid transparent;
                transition: all 0.2s;
            }
            
            .profile-nav a:hover {
                color: var(--color-text);
            }
            
            .profile-nav a.active {
                color: var(--color-text);
                border-bottom-color: var(--color-accent);
            }

            /* Sections */
            .profile-section {
                display: none;
                animation: fadeIn 0.3s ease;
            }
            .profile-section.active { display: block; }

            .section-title {
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 1.5rem;
                color: var(--color-text);
            }

            /* Info List */
            .info-list {
                list-style: none;
                padding: 0;
                margin: 0;
                border: 1px solid var(--color-border);
                border-radius: 4px;
            }
            
            .info-item {
                display: flex;
                justify-content: space-between;
                padding: 1rem 1.25rem;
                border-bottom: 1px solid #f0f0f0;
                font-size: 0.95rem;
            }
            
            .info-item:last-child { border-bottom: none; }
            .info-label { color: var(--color-muted); }
            .info-value { font-weight: 500; color: var(--color-text); text-align: right; }

            /* Forms */
            .form-label {
                display: block;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                font-weight: 600;
                color: var(--color-text);
                margin-bottom: 0.5rem;
            }
            
            .form-input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid var(--color-border);
                border-radius: 4px;
                font-size: 0.95rem;
                background: #fff;
                transition: border-color 0.2s;
                margin-bottom: 1.25rem;
            }
            
            .form-input:focus {
                outline: none;
                border-color: var(--color-text);
            }
            
            .btn-profile {
                background: var(--color-accent);
                color: #fff;
                border: none;
                padding: 0.85rem 2rem;
                font-size: 0.85rem;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border-radius: 4px;
                cursor: pointer;
                transition: opacity 0.2s;
            }
            
            .btn-profile:hover { opacity: 0.85; }

            /* Orders */
            .order-item {
                border: 1px solid var(--color-border);
                border-radius: 4px;
                margin-bottom: 1rem;
                overflow: hidden;
            }
            
            .order-header {
                background: #fafafa;
                padding: 0.75rem 1.25rem;
                display: flex;
                justify-content: space-between;
                border-bottom: 1px solid #f0f0f0;
                font-size: 0.85rem;
            }
            
            .order-id { font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
            .order-date { color: var(--color-muted); }
            
            .order-body {
                padding: 1.25rem;
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
            }
            
            .order-products { flex: 1; }
            .order-amount {
                font-size: 1.1rem;
                font-weight: 600;
                margin-left: 2rem;
                white-space: nowrap;
            }

            /* Utilities */
            .alert-custom {
                padding: 1rem;
                border-radius: 4px;
                margin-bottom: 1.5rem;
                border: 1px solid var(--color-border);
                font-size: 0.9rem;
            }
            .alert-danger { background: #fff5f5; color: #c53030; border-color: #feb2b2; }
            .alert-success { background: #f0fff4; color: #276749; border-color: #9ae6b4; }
            
            .empty-state { padding: 3rem 0; text-align: center; }
            .ls-1 { letter-spacing: 0.05em; }
            .info-card { padding: 1rem; border-radius: 4px; border: 1px solid #e5e5e5; }

            @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

            @media (max-width: 600px) {
                .profile-nav { gap: 1rem; overflow-x: auto; padding-bottom: 1px; }
                .order-body { flex-direction: column; }
                .order-amount { margin-left: 0; margin-top: 1rem; }
            }
        </style>';

        $content = $customStyles . $alertsHtml . '
        <div class="profile-wrapper">
            <!-- Header -->
            <div class="profile-header">
                <div class="profile-avatar">'.strtoupper(substr($userName, 0, 1)).'</div>
                <div class="profile-info">
                    <h1>'.htmlspecialchars($userName).'</h1>
                    <p>'.htmlspecialchars($userEmail).'</p>
                </div>
            </div>

            <!-- Navigation -->
            <div class="profile-nav">
                <a href="#general" class="active" onclick="showSection(\'general\', this); return false;">Информация</a>
                <a href="#orders" onclick="showSection(\'orders\', this); return false;">Заказы</a>
                <a href="#phone" onclick="showSection(\'phone\', this); return false;">Телефон</a>
                <a href="#password" onclick="showSection(\'password\', this); return false;">Пароль</a>
                <a href="#card" onclick="showSection(\'card\', this); return false;">Карта</a>
            </div>

            <!-- Sections -->
            <div id="general" class="profile-section active">
                <h4 class="section-title">Личные данные</h4>
                <ul class="info-list">
                    <li class="info-item"><span class="info-label">Имя</span><span class="info-value">'.htmlspecialchars($userName).'</span></li>
                    <li class="info-item"><span class="info-label">Email</span><span class="info-value">'.htmlspecialchars($userEmail).'</span></li>
                    <li class="info-item"><span class="info-label">Телефон</span><span class="info-value">'.$phoneDisplay.'</span></li>
                    <li class="info-item"><span class="info-label">Карта</span><span class="info-value">'.$cardDisplay.'</span></li>
                    <li class="info-item"><span class="info-label">Клиент с</span><span class="info-value">'.date('d.m.Y', strtotime($userCreated)).'</span></li>
                </ul>
            </div>

            <div id="orders" class="profile-section">
                <h4 class="section-title">История заказов</h4>
                '.$ordersHtml.'
            </div>

            <div id="phone" class="profile-section">
                <h4 class="section-title">Номер телефона</h4>
                <form method="POST" action="/profile/phone">
                    <label class="form-label">Новый номер</label>
                    <input type="tel" name="phone" class="form-input" value="'.htmlspecialchars($userPhone).'" placeholder="+7 (999) 000-00-00" required>
                    <button type="submit" class="btn-profile">Сохранить</button>
                </form>
            </div>

            <div id="password" class="profile-section">
                <h4 class="section-title">Смена пароля</h4>
                <form method="POST" action="/profile/password">
                    <label class="form-label">Текущий пароль</label>
                    <input type="password" name="current_password" class="form-input" required>
                    
                    <label class="form-label">Новый пароль</label>
                    <input type="password" name="new_password" class="form-input" required minlength="6">
                    
                    <label class="form-label">Повторите новый пароль</label>
                    <input type="password" name="confirm_password" class="form-input" required>
                    
                    <button type="submit" class="btn-profile">Обновить пароль</button>
                </form>
            </div>

            <div id="card" class="profile-section">
                <h4 class="section-title">Банковская карта</h4>
                <form method="POST" action="/profile/card">
                    <label class="form-label">Номер карты</label>
                    <input type="text" name="card_number" class="form-input" placeholder="0000 0000 0000 0000" maxlength="19">
                    <button type="submit" class="btn-profile">Привязать карту</button>
                </form>
                '.$cardAlertBlock.'
            </div>
        </div>

        <script>
        function showSection(id, link) {
            // Скрываем все секции
            document.querySelectorAll(".profile-section").forEach(function(sec) {
                sec.classList.remove("active");
            });
            // Убираем активный класс у ссылок
            document.querySelectorAll(".profile-nav a").forEach(function(a) {
                a.classList.remove("active");
            });
            // Показываем нужную секцию
            document.getElementById(id).classList.add("active");
            // Активируем ссылку
            link.classList.add("active");
        }
        </script>';

       return str_replace(['{TITLE}', '{CONTENT}'], [$title, $content], $template);
    }
    }
