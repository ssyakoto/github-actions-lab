<?php
namespace Views;

class CatalogTemplate extends BaseTemplate
{
    public static function render(array $products): string
    {
        $template = parent::getTemplate();
        $title = 'Каталог — spin4spin';
        
        // Контейнер для уведомлений
        $toastContainer = '<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;"></div>';
        
        // Проверка авторизации
        $isAuth = isset($_SESSION['user_id']);
        
        // Генерация карточек товаров
        $itemsHtml = '';
        foreach ($products as $product) {
            // Форматирование цены
            $priceDisplay = $product['price'] > 0 
                ? number_format($product['price'], 0, '.', ' ') . ' ₽' 
                : 'По запросу';

            // Логика кнопки
            $buttonHtml = '';
            if ($product['price'] > 0) {
                if ($isAuth) {
                    // Кнопка добавления в корзину (AJAX)
                    $buttonHtml = '<button type="button" class="btn-luxury js-add-to-cart" 
                        data-id="'.$product['id'].'" 
                        data-name="'.htmlspecialchars($product['name']).'">
                        В корзину
                    </button>';
                } else {
                    // Кнопка для гостей
                    $buttonHtml = '<button type="button" class="btn-luxury btn-luxury-outline btn-need-auth"
                        data-name="'.htmlspecialchars($product['name']).'">
                        В корзину
                    </button>';
                }
            }

            // HTML карточки
            $itemsHtml .= '
            <div class="product-card-luxury">
                <a href="/product/'.$product['id'].'" class="product-link">
                    <div class="product-image-wrapper">
                        <img src="'.htmlspecialchars($product['image']).'"
                             alt="'.htmlspecialchars($product['name']).'"
                             class="product-image"
                             onerror="this.src=\'https://placehold.co/600x800/f5f5f5/333?text=Image\'">
                    </div>
                </a>
                <div class="product-content">
                    <div class="product-brand">spin4spin</div>
                    <h3 class="product-title">
                        <a href="/product/'.$product['id'].'">'.htmlspecialchars($product['name']).'</a>
                    </h3>
                    <div class="product-footer">
                        <span class="product-price">'.$priceDisplay.'</span>
                        '.$buttonHtml.'
                    </div>
                </div>
            </div>';
        }

        // Стили
        $customStyles = '
        <style>
            /* Luxury Catalog Styles */
            :root {
                --color-text: #111111;
                --color-muted: #666666;
                --color-border: #e5e5e5;
                --color-accent: #000000;
                --font-main: "Inter", sans-serif;
            }

            body { font-family: var(--font-main); }

            .catalog-header {
                text-align: center;
                margin-bottom: 4rem;
                padding-top: 2rem;
            }
            .catalog-title {
                font-size: 2.5rem;
                font-weight: 600;
                margin-bottom: 0.75rem;
                letter-spacing: -0.02em;
                color: var(--color-text);
            }
            .catalog-subtitle {
                color: var(--color-muted);
                font-size: 1rem;
                max-width: 600px;
                margin: 0 auto;
            }

            /* Сетка товаров */
            .product-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 2.5rem;
            }

            /* Карточка товара */
            .product-card-luxury {
                border: 1px solid var(--color-border);
                border-radius: 4px; /* Small radius for luxury feel */
                overflow: hidden;
                background: #fff;
                transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
                position: relative;
                display: flex;
                flex-direction: column;
            }
            
            .product-card-luxury:hover {
                border-color: var(--color-accent);
                transform: translateY(-4px);
                box-shadow: 0 12px 30px rgba(0,0,0,0.06);
            }

            .product-image-wrapper {
                position: relative;
                overflow: hidden;
                aspect-ratio: 3/4; /* Portrait ratio */
                background: #f9f9f9;
            }
            
            .product-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.6s ease;
            }
            
            .product-card-luxury:hover .product-image {
                transform: scale(1.05);
            }

            .product-content {
                padding: 1.5rem;
                display: flex;
                flex-direction: column;
                flex-grow: 1;
            }

            .product-brand {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: #999999;
                margin-bottom: 0.5rem;
                font-weight: 600;
            }

            .product-title {
                font-size: 1rem;
                font-weight: 500;
                margin-bottom: 0.5rem;
                line-height: 1.4;
                color: var(--color-text);
            }
            
            .product-title a {
                text-decoration: none;
                color: inherit;
            }
            
            .product-title a:hover {
                text-decoration: underline;
            }

            .product-footer {
                margin-top: auto;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-top: 1rem;
                border-top: 1px solid #f0f0f0;
            }

            .product-price {
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--color-text);
            }

            /* Кнопки */
            .btn-luxury {
                background: var(--color-accent);
                color: #fff;
                border: 1px solid var(--color-accent);
                padding: 10px 20px;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s ease;
                border-radius: 2px;
            }
            
            .btn-luxury:hover {
                background: #333;
                border-color: #333;
            }
            
            .btn-luxury.btn-luxury-outline {
                background: transparent;
                color: var(--color-text);
                border-color: var(--color-border);
            }
            
            .btn-luxury.btn-luxury-outline:hover {
                border-color: var(--color-accent);
                background: #f9f9f9;
            }

            /* Responsive */
            @media (max-width: 992px) {
                .product-grid { grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
            }
            @media (max-width: 768px) {
                .product-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
                .catalog-title { font-size: 2rem; }
            }
            @media (max-width: 480px) {
                .product-grid { grid-template-columns: 1fr; }
            }
        </style>';

        // JavaScript для обработки кнопок (AJAX и уведомления)
        $script = '
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            // Функция показа уведомлений (Toast)
            window.showToast = function(title, message, type = "success") {
                const container = document.querySelector(".toast-container");
                if (!container) return;

                const toastId = "toast-" + Date.now();
                // Minimalist Toast Style
                const toastHTML = `
                <div id="${toastId}" class="show" role="alert" 
                     style="background:#fff; border:1px solid #e5e5e5; box-shadow:0 10px 30px rgba(0,0,0,0.08); 
                            min-width:300px; padding:1rem; margin-bottom:0.5rem; border-radius:4px; animation: slideIn 0.3s ease;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem;">
                        <strong style="font-size:0.9rem;">${title}</strong>
                        <button type="button" class="btn-close" onclick="this.closest(\'.show\').remove()" 
                                style="font-size:0.8rem; cursor:pointer; background:none; border:none;">&times;</button>
                    </div>
                    <div style="font-size:0.85rem; color:#666;">${message}</div>
                </div>`;
                
                container.insertAdjacentHTML("beforeend", toastHTML);
                
                // Auto remove
                setTimeout(() => {
                    const el = document.getElementById(toastId);
                    if(el) {
                        el.style.opacity = "0";
                        el.style.transform = "translateX(20px)";
                        el.style.transition = "all 0.3s";
                        setTimeout(() => el.remove(), 300);
                    }
                }, 3000);
            };

            // 1. AJAX добавление в корзину (Авторизованные)
            document.querySelectorAll(".js-add-to-cart").forEach(btn => {
                btn.addEventListener("click", function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    
                    const originalText = this.textContent;
                    this.textContent = "...";
                    this.disabled = true;

                    const formData = new FormData();
                    formData.append("id", id);

                    fetch("/cart/add", { method: "POST", body: formData })
                        .then(res => {
                            if (res.ok) {
                                showToast("Успешно", `${name} добавлен в корзину`);
                                // Обновляем счетчик в шапке
                                const badge = document.querySelector(".cart-badge");
                                if(badge) {
                                    let count = parseInt(badge.textContent) || 0;
                                    badge.textContent = count + 1;
                                    badge.style.display = "inline-block";
                                }
                            } else {
                                throw new Error("Error");
                            }
                        })
                        .catch(err => {
                            showToast("Ошибка", "Не удалось добавить товар");
                        })
                        .finally(() => {
                            this.textContent = originalText;
                            this.disabled = false;
                        });
                });
            });

            // 2. Обработка кнопки для неавторизованных
            document.querySelectorAll(".btn-need-auth").forEach(btn => {
                btn.addEventListener("click", function() {
                    showToast("Внимание", "Войдите в аккаунт, чтобы добавить товар", "warning");
                });
            });
        });
        
        // Анимация для Toast (добавляем стиль программно, если нет в CSS)
        const styleSheet = document.createElement("style");
        styleSheet.innerText = `@keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }`;
        document.head.appendChild(styleSheet);
        </script>';

        // Сборка контента
        $content = $customStyles . $script . $toastContainer . '
        <section class="container">
            <div class="catalog-header">
                <h2 class="catalog-title">Каталог</h2>
                <p class="catalog-subtitle"></p>
            </div>
            <div class="product-grid">
                '.$itemsHtml.'
            </div>
        </section>';

        return str_replace(['{TITLE}', '{CONTENT}'], [$title, $content], $template);
    }
}