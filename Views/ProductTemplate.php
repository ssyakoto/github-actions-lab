<?php
namespace Views;

class ProductTemplate extends BaseTemplate
{
    public static function render(array $product): string
    {
        $template = parent::getTemplate();
        $title = ($product['name'] ?? 'Товар') . ' — spin4spin';

        // 🔧 Генерация списка преимуществ с проверкой
        $featuresHtml = '';
        $features = $product['features'] ?? []; // Если нет ключа — пустой массив
        if (is_array($features)) {
            foreach ($features as $feature) {
                $featuresHtml .= '<li class="feature-item">' . htmlspecialchars($feature) . '</li>';
            }
        }

        // 🔧 Форматирование цены
        $price = $product['price'] ?? 0;
        $priceDisplay = $price > 0
            ? number_format($price, 0, '.', ' ') . ' ₽'
            : 'По запросу';

        // Проверка авторизации
        $isAuth = isset($_SESSION['user_id']);

        // Логика кнопки добавления
        $productId = $product['id'] ?? 0;
        if ($isAuth && $price > 0) {
            $addToCartForm = '
            <form method="POST" action="/cart/add" class="mb-3">
                <input type="hidden" name="id" value="'.$productId.'">
                <button type="submit" class="btn-buy w-100">Добавить в корзину</button>
            </form>';
        } elseif ($price > 0) {
            $addToCartForm = '<button type="button" class="btn-buy-outline w-100 mb-3" data-bs-toggle="modal" data-bs-target="#authModal">Добавить в корзину</button>';
        } else {
            $addToCartForm = '';
        }

        // Модальное окно
        $authModal = '
        <div class="modal fade" id="authModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content" style="border-radius: 4px; border: 1px solid #e5e5e5; box-shadow: none;">
                    <div class="modal-header border-0 pb-0" style="background:#fff;">
                        <h6 class="modal-title fw-bold text-uppercase ls-1">Авторизация</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center px-4 py-4">
                        <p class="mb-4 text-muted small">Войдите, чтобы оформить заказ</p>
                        <div class="d-grid gap-2">
                            <a href="/login" class="btn-buy text-decoration-none py-2" style="font-size:0.85rem;">Войти</a>
                            <a href="/register" class="btn-buy-outline text-decoration-none py-2" style="font-size:0.85rem;">Регистрация</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        // 🔧 ИЗОБРАЖЕНИЕ С РАЗМЫТИЕМ НА ФОНЕ
        $productImage = htmlspecialchars($product['image'] ?? '/assets/images/placeholder.jpg');

        $content = '
        <style>
            :root {
                --color-text: #111111;
                --color-muted: #666666;
                --color-border: #e5e5e5;
                --color-accent: #000000;
            }

            /* 🔹 ФОНОВОЕ ИЗОБРАЖЕНИЕ С РАЗМЫТИЕМ */
            .product-bg-blur {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                overflow: hidden;
                pointer-events: none;
            }
            
            .product-bg-blur::before {
                content: "";
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 60%;
                height: 80%;
                background-image: url(\''.$productImage.'\');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                filter: blur(80px) brightness(0.9);
                opacity: 0.5;
            }
            
            .product-bg-blur::after {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(2px);
            }

            .product-container {
                max-width: 1100px;
                margin: 3rem auto;
                padding: 0 1rem;
                position: relative;
                z-index: 1;
            }

            .back-link {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                color: var(--color-muted);
                text-decoration: none;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                font-weight: 600;
                margin-bottom: 2rem;
                transition: color 0.2s;
            }
            .back-link:hover { color: var(--color-accent); }

            /* Product Image */
            .product-image-container {
                margin-bottom: 3rem;
                text-align: center;
            }
            .product-main-image {
                width: 100%;
                max-width: 800px;
                height: auto;
                border-radius: 8px;
                overflow: hidden;
                margin: 0 auto;
                background: #f9f9f9;
            }
            .product-main-image img {
                width: 100%;
                height: auto;
                object-fit: cover;
                display: block;
            }

            /* Header Section */
            .product-header {
                text-align: center;
                margin-bottom: 4rem;
                padding-bottom: 2rem;
                border-bottom: 1px solid var(--color-border);
            }
            .product-title {
                font-size: 2.75rem;
                font-weight: 700;
                color: var(--color-text);
                margin-bottom: 1rem;
                letter-spacing: -0.03em;
            }
            .product-desc {
                font-size: 1.15rem;
                color: var(--color-muted);
                max-width: 700px;
                margin: 0 auto 2rem;
                line-height: 1.6;
            }
            .product-price {
                font-size: 2.25rem;
                font-weight: 700;
                color: var(--color-accent);
                margin-bottom: 1.5rem;
                display: block;
            }
            .coverage-badge {
                display: inline-block;
                padding: 0.5rem 1.25rem;
                border: 1px solid var(--color-text);
                color: var(--color-text);
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                font-weight: 600;
            }

            /* Grid Layout */
            .product-grid {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 4rem;
            }

            /* Features */
            .features-title {
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: var(--color-muted);
                margin-bottom: 1.5rem;
                font-weight: 600;
            }
            .feature-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            .feature-item {
                padding: 1.25rem 0;
                border-bottom: 1px solid #f0f0f0;
                color: var(--color-text);
                font-size: 1.05rem;
                display: flex;
                align-items: center;
            }
            .feature-item:last-child { border-bottom: none; }
            .feature-item::before {
                content: "•";
                color: var(--color-accent);
                font-size: 1.5rem;
                line-height: 0;
                margin-right: 1rem;
                opacity: 0.5;
            }

            /* Action Box */
            .action-box {
                border: 1px solid var(--color-border);
                padding: 2.5rem 2rem;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 4px;
                text-align: center;
            }
            .action-box h5 {
                font-size: 1rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-bottom: 1.5rem;
                font-weight: 600;
            }

            /* Buttons */
            .btn-buy {
                background: var(--color-accent);
                color: #fff;
                border: 1px solid var(--color-accent);
                padding: 1rem 2rem;
                font-size: 0.9rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border-radius: 2px;
                cursor: pointer;
                transition: all 0.2s;
                text-decoration: none;
                display: inline-block;
            }
            .btn-buy:hover {
                background: #333;
                border-color: #333;
                color: #fff;
                text-decoration: none;
            }
            .btn-buy-outline {
                background: transparent;
                color: var(--color-text);
                border: 1px solid var(--color-border);
                padding: 1rem 2rem;
                font-size: 0.9rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border-radius: 2px;
                cursor: pointer;
                transition: all 0.2s;
            }
            .btn-buy-outline:hover {
                border-color: var(--color-text);
                background: #f9f9f9;
            }
            .btn-calc {
                display: block;
                margin-top: 1rem;
                color: var(--color-muted);
                font-size: 0.85rem;
                text-decoration: underline;
                text-decoration-color: #ddd;
            }
            .btn-calc:hover { color: var(--color-text); }

            .contact-phone {
                display: block;
                margin-top: 2rem;
                padding-top: 1.5rem;
                border-top: 1px solid #f0f0f0;
                color: var(--color-text);
                text-decoration: none;
                font-weight: 600;
                font-size: 1.1rem;
            }
            .contact-phone:hover { opacity: 0.7; }

            @media (max-width: 768px) {
                .product-bg-blur::before {
                    width: 80%;
                    height: 60%;
                    filter: blur(60px);
                }
                .product-grid { grid-template-columns: 1fr; gap: 2rem; }
                .product-title { font-size: 2rem; }
                .action-box { padding: 1.5rem; }
                .product-main-image { max-width: 100%; }
            }
        </style>

        <!-- 🔹 ФОНОВОЕ РАЗМЫТИЕ -->
        <div class="product-bg-blur"></div>

        <div class="product-container">
            <a href="/products" class="back-link">← Каталог</a>

            <!-- 🔹 PRODUCT IMAGE -->
            <div class="product-image-container">
                <div class="product-main-image">
                    <img src="'.$productImage.'" 
                         alt="'.htmlspecialchars($product['name'] ?? 'Товар').'"
                         onerror="this.src=\'/assets/images/placeholder.jpg\'">
                </div>
            </div>

            <div class="product-header">
                <h1 class="product-title">'.htmlspecialchars($product['name'] ?? 'Товар').'</h1>
                <p class="product-desc">'.htmlspecialchars($product['description'] ?? '').'</p>
                <span class="product-price">'.$priceDisplay.'</span>
                <div class="coverage-badge">Покрытие: '.htmlspecialchars($product['coverage'] ?? '—').'</div>
            </div>

            <div class="product-grid">
                <div class="features-section">
                    <h4 class="features-title"></h4>
                    <ul class="feature-list">
                        '.$featuresHtml.'
                    </ul>
                </div>

                <div class="product-sidebar">
                    <div class="action-box">
                        <h5>Оформление</h5>
                        <p class="text-muted small mb-4">Рассчитайте стоимость доставки</p>
                        
                        '.$addToCartForm.'
                        
                        <a href="/services#calculator" class="btn-buy-outline w-100 mb-3">Рассчитать</a>
                        <a href="tel:+79999999999" class="contact-phone">+7 (999) 999-99-99</a>
                    </div>
                </div>
            </div>
        </div>

        '.$authModal;

        return str_replace(['{TITLE}', '{CONTENT}'], [$title, $content], $template);
    }
}