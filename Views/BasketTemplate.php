<?php
namespace Views;

class BasketTemplate extends BaseTemplate
{
    public static function render(array $items, float $total, string $storageType): string
    {
        $template = parent::getTemplate();
        $title = 'Корзина — spin4spin';

        // Контейнер для уведомлений
        $toastContainer = '<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;"></div>';

        $customStyles = '
        <style>
            /* Luxury Minimalist Styles */
            :root {
                --color-border: #e5e5e5;
                --color-text: #111111;
                --color-text-muted: #666666;
                --color-accent: #000000;
                --radius: 4px;
            }

            .basket-header { 
                text-align: left; 
                margin-bottom: 3rem; 
                border-bottom: 1px solid var(--color-border);
                padding-bottom: 1.5rem;
            }
            .basket-title { 
                font-size: 2.5rem; 
                font-weight: 600; 
                color: var(--color-text); 
                margin-bottom: 0.5rem;
                letter-spacing: -0.03em;
            }
            .basket-subtitle { 
                color: var(--color-text-muted); 
                font-size: 1rem; 
            }

            /* Карточка товара в корзине */
            .basket-card {
                border: 1px solid var(--color-border); 
                border-radius: var(--radius); 
                background: #ffffff;
                margin-bottom: 1.5rem; 
                position: relative; 
                overflow: hidden;
                box-shadow: none !important;
                transition: border-color 0.2s;
            }
            .basket-card:hover {
                border-color: #999;
            }
            
            .basket-img { 
                object-fit: cover; 
                height: 100%; 
                width: 100%; 
                min-height: 200px;
                background: #f9f9f9;
            }
            @media (max-width: 768px) { 
                .basket-img { height: 250px; } 
            }

            /* Управление количеством - Строгий стиль */
            .qty-control { 
                display: inline-flex; 
                align-items: center; 
                gap: 0; 
                border: 1px solid var(--color-border);
                border-radius: var(--radius);
            }
            .qty-btn { 
                width: 36px; 
                height: 36px; 
                border: none; 
                background: #fff; 
                color: var(--color-text); 
                border-radius: 0;
                font-weight: 500; 
                cursor: pointer; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                transition: all 0.2s;
                font-size: 1.1rem;
            }
            .qty-btn:hover { background: #f0f0f0; }
            .qty-btn:disabled { background: #f9f9f9; color: #ccc; cursor: not-allowed; }
            .qty-value { 
                font-weight: 600; 
                min-width: 40px; 
                text-align: center; 
                font-size: 0.95rem;
                border-left: 1px solid var(--color-border);
                border-right: 1px solid var(--color-border);
                height: 36px;
                line-height: 36px;
            }

            /* Цены и итоги */
            .price-label { 
                font-size: 0.75rem; 
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: var(--color-text-muted); 
                margin-bottom: 0.25rem; 
            }
            .price-value { 
                font-weight: 500; 
                color: var(--color-text); 
                font-size: 1.1rem;
            }
            .total-value { 
                font-size: 1.25rem; 
                font-weight: 700; 
                color: var(--color-text); 
            }
            .total-value.updating { opacity: 0.5; }

            /* Блок итогов - Минимализм */
            .basket-summary { 
                background: #fff; 
                border-radius: var(--radius); 
                padding: 2rem; 
                border: 1px solid var(--color-border);
            }
            .summary-row { 
                display: flex; 
                justify-content: space-between; 
                padding: 1rem 0; 
                border-bottom: 1px solid var(--color-border); 
            }
            .summary-row:last-child { 
                border-bottom: none; 
                padding-top: 1.5rem; 
                font-size: 1.5rem; 
                font-weight: 700; 
                color: var(--color-text); 
            }

            /* Кнопки - Строгие */
            .btn-custom { 
                background: var(--color-accent); 
                border: 1px solid var(--color-accent); 
                padding: 14px 32px; 
                border-radius: var(--radius); 
                color: #fff; 
                font-weight: 500; 
                text-decoration: none; 
                display: inline-block; 
                transition: all 0.2s ease; 
                width: 100%; 
                text-align: center;
                letter-spacing: 0.02em;
                font-size: 0.95rem;
            }
            .btn-custom:hover { 
                background: #333; 
                border-color: #333; 
                color: #fff; 
                transform: none;
                box-shadow: none;
            }
            .btn-outline-custom { 
                border: 1px solid var(--color-border); 
                color: var(--color-text); 
                padding: 14px 32px; 
                border-radius: var(--radius); 
                font-weight: 500; 
                background: transparent; 
                width: 100%; 
                text-align: center; 
                transition: all 0.2s ease;
                font-size: 0.95rem;
            }
            .btn-outline-custom:hover { 
                background: #f0f0f0; 
                color: var(--color-text); 
                border-color: #999;
                transform: none;
            }
            .basket-actions { 
                display: flex; 
                gap: 1rem; 
                margin-top: 2rem; 
            }
            @media (max-width: 768px) { 
                .basket-actions { flex-direction: column-reverse; } 
            }

            /* Пустая корзина */
            .basket-empty { 
                text-align: center; 
                padding: 6rem 2rem; 
                border: 1px dashed var(--color-border);
                border-radius: var(--radius);
            }
            .basket-empty-icon { font-size: 3rem; margin-bottom: 1.5rem; opacity: 0.3; }
            .basket-empty h3 { font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: var(--color-text); }
            .basket-empty p { color: var(--color-text-muted); margin-bottom: 2rem; }

            .remove-link { 
                color: #999; 
                font-size: 0.85rem; 
                text-decoration: none; 
                font-weight: 500; 
                transition: color 0.2s; 
                margin-top: 1rem;
                display: inline-block;
            }
            .remove-link:hover { color: #000; text-decoration: underline; }

            /* Переключатель хранения */
            .storage-toggle { 
                background: #fff; 
                border: 1px solid var(--color-border);
                border-radius: var(--radius); 
                padding: 1rem 1.5rem; 
                margin-bottom: 2rem; 
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .storage-toggle label { margin: 0 0.75rem; cursor: pointer; font-size: 0.9rem; color: var(--color-text-muted); }
            .storage-toggle input { margin-right: 0.3rem; accent-color: #000; }
            .storage-toggle button {
                font-size: 0.8rem;
                padding: 0.3rem 0.8rem;
                border: 1px solid var(--color-border);
                background: #fff;
                border-radius: 2px;
                cursor: pointer;
            }

            /* Уведомления */
            .toast-custom { 
                border: 1px solid var(--color-border); 
                border-radius: var(--radius); 
                box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
                background: #fff; 
                overflow: hidden; 
                min-width: 300px; 
                animation: slideIn 0.3s ease-out; 
            }
            @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
            .toast-custom.success { border-left: 4px solid #000; }
            .toast-custom.error { border-left: 4px solid #dc3545; }
            .toast-custom .toast-header { background: transparent; border-bottom: 1px solid var(--color-border); padding: 12px 16px; }
            .toast-custom .toast-body { padding: 12px 16px; font-size: 0.9rem; color: #333; }
            
            /* Стили Bootstrap Override */
            .badge { border-radius: 2px; letter-spacing: 0.05em; font-size: 0.7rem; padding: 0.35em 0.6em; font-weight: 600; }
            .badge.bg-primary { background: #000 !important; color: #fff !important; }
        </style>';

        // Запрет кэширования
        $noCacheMeta = '<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">';

        if (empty($items)) {
            $content = $noCacheMeta . $customStyles . $toastContainer . '
            <section class="container py-5">
                <div class="basket-empty">
                    <div class="basket-empty-icon">🛒</div>
                    <h3>Ваша корзина пуста</h3>
                    <p>Перейдите в каталог, чтобы добавить товары.</p>
                    <a href="/products" class="btn btn-custom" style="max-width:200px; margin: 0 auto;">Каталог</a>
                </div>
            </section>';
        } else {
            $itemsHtml = '';
            foreach ($items as $item) {
                $price = number_format($item['product']['price'], 0, '.', ' ');
                $subtotal = number_format($item['subtotal'], 0, '.', ' ');
                
                $itemsHtml .= '
                <div class="card basket-card" id="item-'.$item['product']['id'].'">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="'.htmlspecialchars($item['product']['image']).'"
                                class="basket-img"
                                alt="'.htmlspecialchars($item['product']['name']).'"
                                onerror="this.src=\'https://placehold.co/300x300/f5f5f5/333?text=Image\'">
                        </div>
                        <div class="col-md-6 border-end border-start d-flex flex-column justify-content-center p-4">
                            <h5 class="fw-bold mb-2" style="font-size: 1.1rem;">
                                <a href="/product/'.$item['product']['id'].'" class="text-decoration-none text-dark">
                                    '.htmlspecialchars($item['product']['name']).'
                                </a>
                            </h5>
                            <p class="text-muted small mb-3" style="font-size: 0.85rem; line-height: 1.5;">'.htmlspecialchars($item['product']['description']).'</p>
                            <span class="badge bg-primary" style="background: #eee; color: #333; border: 1px solid #ddd;">'.htmlspecialchars($item['product']['coverage']).'</span>
                        </div>
                        <div class="col-md-3 d-flex flex-column justify-content-between p-4 bg-white">
                            <div>
                                <div class="price-label">Цена за ед.</div>
                                <div class="price-value mb-3">'.$price.' ₽</div>
                                
                                <div class="price-label">Количество</div>
                                <div class="qty-control mb-3">
                                    <button class="qty-btn" data-id="'.$item['product']['id'].'" data-action="dec" '.($item['quantity']<=1?'disabled':'').'>−</button>
                                    <span class="qty-value">'.$item['quantity'].'</span>
                                    <button class="qty-btn" data-id="'.$item['product']['id'].'" data-action="inc">+</button>
                                </div>
                            </div>
                            
                            <div class="border-top pt-3 mt-2">
                                <div class="price-label">Итого</div>
                                <div class="total-value mb-2" id="subtotal-'.$item['product']['id'].'">'.$subtotal.' ₽</div>
                                <a href="/cart/remove?id='.$item['product']['id'].'" class="remove-link" onclick="return confirm(\'Удалить?\')">Удалить</a>
                            </div>
                        </div>
                    </div>
                </div>';
            }

            $totalFormatted = number_format($total, 0, '.', ' ');
            $storageLabel = $storageType === 'session' ? 'Сессия' : 'Куки';

            $content = $noCacheMeta . $customStyles . $toastContainer . '
            <section class="container py-5">
                <div class="basket-header">
                    <h1 class="basket-title">Корзина</h1>
                    <p class="basket-subtitle">'.count($items).' товар(ов)</p>
                </div>
                
                <div class="row g-5">
                    <div class="col-lg-8">
                        '.$itemsHtml.'
                    </div>
                    <div class="col-lg-4">
                        <div class="basket-summary">
                            <h5 class="fw-bold mb-4" style="font-size: 1.2rem;">Детали заказа</h5>
                            
                            <div class="summary-row">
                                <span class="text-muted" style="font-size: 0.9rem;">Сумма</span>
                                <span class="fw-semibold" id="summary-total">'.$totalFormatted.' ₽</span>
                            </div>
                            <div class="summary-row" style="border: none; padding-top: 0;">
                                <span class="text-muted" style="font-size: 0.9rem;">Доставка</span>
                                <span class="fw-semibold text-success">Бесплатно</span>
                            </div>
                            
                            <div class="summary-row" style="margin-top: 1rem;">
                                <span class="fw-bold">Итого</span>
                                <span class="fw-bold" id="summary-total-big">'.$totalFormatted.' ₽</span>
                            </div>

                            <div class="basket-actions">
                                <a href="/cart/clear" class="btn btn-outline-custom" onclick="return confirm(\'Очистить корзину?\')">Очистить</a>
                                <a href="/checkout" class="btn btn-custom">Оформить</a>
                            </div>
                            
                            <div class="storage-toggle mt-4">
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Хранение:</small>
                                    <form method="POST" action="/cart/setStorage" class="d-inline m-0 p-0">
                                        <label class="m-0"><input type="radio" name="type" value="session" '.($storageType==='session'?'checked':'').'> Сессия</label>
                                        <label class="m-0 ms-2"><input type="radio" name="type" value="cookie" '.($storageType==='cookie'?'checked':'').'> Куки</label>
                                        <button type="submit">OK</button>
                                    </form>
                                </div>
                                <small class="text-muted" style="font-size: 0.7rem; text-align: right;">'.$storageLabel.'</small>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <script>
            // Уведомления
            window.showBasketToast = function(title, message, type = "success") {
                const container = document.querySelector(".toast-container");
                const toastId = "toast-" + Date.now();
                const icons = { success: "✅", error: "⚠️" };
                const toastHTML = `
                <div id="${toastId}" class="toast toast-custom ${type} hide" role="alert" data-bs-delay="3000">
                    <div class="toast-header">
                        <strong class="me-auto fw-bold" style="font-size: 0.9rem;">${icons[type] || "ℹ️"} ${title}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">${message}</div>
                </div>`;
                container.insertAdjacentHTML("beforeend", toastHTML);
                const toastEl = document.getElementById(toastId);
                const toast = new bootstrap.Toast(toastEl);
                toastEl.addEventListener("hidden.bs.toast", () => toastEl.remove());
                toast.show();
            };

            // Логика кнопок
            document.querySelectorAll(".qty-btn").forEach(btn => {
                btn.addEventListener("click", async function() {
                    const id = this.dataset.id;
                    const action = this.dataset.action;
                    const qtySpan = this.closest(".qty-control").querySelector(".qty-value");
                    const subtotalEl = document.getElementById("subtotal-" + id);
                    const btns = this.closest(".qty-control").querySelectorAll(".qty-btn");
                    let currentQty = parseInt(qtySpan.textContent) || 1;
                    let newQty = action === "inc" ? currentQty + 1 : currentQty - 1;
                    if (newQty < 1) return;

                    btns.forEach(b => b.disabled = true);
                    if(subtotalEl) subtotalEl.classList.add("updating");

                    try {
                        const formData = new URLSearchParams();
                        formData.append("id", id);
                        formData.append("quantity", newQty);
                        const response = await fetch("/cart/update", {
                            method: "POST",
                            headers: {"Content-Type": "application/x-www-form-urlencoded"},
                            body: formData
                        });
                        if (!response.ok) throw new Error("Ошибка сервера");
                        const data = await response.json().catch(() => null);
                        
                        if (data && data.subtotal !== undefined) {
                            qtySpan.textContent = newQty;
                            subtotalEl.textContent = new Intl.NumberFormat("ru-RU").format(data.subtotal) + " ₽";
                            if (data.total !== undefined) {
                                const totalStr = new Intl.NumberFormat("ru-RU").format(data.total) + " ₽";
                                document.getElementById("summary-total").textContent = totalStr;
                                const bigTotal = document.getElementById("summary-total-big");
                                if(bigTotal) bigTotal.textContent = totalStr;
                            }
                            if (data.count !== undefined) {
                                const badge = document.querySelector(".navbar-nav .badge");
                                if(badge) badge.textContent = data.count;
                            }
                            showBasketToast("Обновлено", "Количество изменено", "success");
                        } else {
                            location.reload();
                        }
                    } catch (err) {
                        console.error(err);
                        showBasketToast("Ошибка", "Не удалось обновить", "error");
                        location.reload();
                    } finally {
                        btns.forEach(b => b.disabled = false);
                        if(subtotalEl) subtotalEl.classList.remove("updating");
                    }
                });
            });
            </script>';
        }
        return str_replace(['{TITLE}', '{CONTENT}'], [$title, $content], $template);
    }
}