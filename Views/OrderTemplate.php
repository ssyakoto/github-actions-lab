<?php
namespace Views;

class OrderTemplate extends BaseTemplate
{
    public static function render(array $basketItems = [], float $total = 0): string
    {
        $template = parent::getTemplate();
        $title = 'Оформление заказа — spin4spin';
        
        // Flash-уведомление
        $flashHtml = '';
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!empty($_SESSION['flash'])) {
            $flashMessage = $_SESSION['flash'];
            $flashType = $_SESSION['flash_type'] ?? 'success';
            unset($_SESSION['flash']);
            unset($_SESSION['flash_type']);
            $alertClass = $flashType === 'error' ? 'alert-danger' : 'alert-success';
            $flashHtml = '<div class="alert-custom '.$alertClass.'">'.$flashMessage.'</div>';
        }

        // Сводка заказа
        $summaryHtml = '';
        if (!empty($basketItems)) {
            foreach ($basketItems as $item) {
                $subtotal = $item['product']['price'] * $item['quantity'];
                $summaryHtml .= '<div class="summary-item">
                    <span>'.htmlspecialchars($item['product']['name']).' × '.$item['quantity'].'</span>
                    <span>'.number_format($subtotal, 0, '.', ' '). ' ₽</span>
                </div>';
            }
        }
        $summaryHtml .= '<div class="summary-item summary-total">
            <span>Итого</span>
            <span>'.number_format($total, 0, '.', ' '). ' ₽</span>
        </div>';

        $customStyles = '
        <style>
            /* === spin4spin Minimalist Order Styles === */
            :root {
                --color-text: #111111;
                --color-muted: #666666;
                --color-border: #e5e5e5;
                --color-accent: #000000;
                --color-bg-light: #fafafa;
                --font-main: "Inter", sans-serif;
                --radius: 4px;
            }
            body { font-family: var(--font-main); background: #fff; }
            
            .order-wrapper { max-width: 750px; margin: 0 auto; padding: 4rem 1rem; }
            .order-header { text-align: center; margin-bottom: 3rem; border-bottom: 1px solid var(--color-border); padding-bottom: 2rem; }
            .order-title { font-size: 2.25rem; font-weight: 600; letter-spacing: -0.02em; margin: 0; color: var(--color-text); }
            .order-subtitle { color: var(--color-muted); font-size: 0.95rem; margin-top: 0.5rem; }

            /* Summary */
            .order-summary {
                background: var(--color-bg-light);
                border: 1px solid var(--color-border);
                border-radius: var(--radius);
                padding: 1.5rem;
                margin-bottom: 2.5rem;
            }
            .summary-item {
                display: flex;
                justify-content: space-between;
                padding: 0.75rem 0;
                border-bottom: 1px solid var(--color-border);
                font-size: 0.9rem;
                color: var(--color-muted);
            }
            .summary-item:last-child { border-bottom: none; }
            .summary-total {
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--color-text);
                padding-top: 1rem;
                margin-top: 0.5rem;
                border-top: 2px solid var(--color-text);
            }

            /* Form */
            .order-form { display: grid; gap: 1.5rem; }
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
                width: 100%%;
                padding: 0.85rem 1rem;
                border: 1px solid var(--color-border);
                border-radius: var(--radius);
                font-size: 0.95rem;
                background: #fff;
                transition: border-color 0.2s;
                box-sizing: border-box;
            }
            .form-input:focus {
                outline: none;
                border-color: var(--color-text);
            }
            .field-hint { font-size: 0.8rem; color: var(--color-muted); margin-top: 0.4rem; }

            /* Delivery Options */
            .delivery-options { display: flex; gap: 1rem; }
            .delivery-option {
                flex: 1;
                padding: 1rem;
                border: 1px solid var(--color-border);
                border-radius: var(--radius);
                cursor: pointer;
                transition: all 0.2s;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                font-size: 0.9rem;
                font-weight: 500;
                color: var(--color-muted);
                background: #fff;
            }
            .delivery-option:hover { border-color: #999; }
            .delivery-option.active {
                border-color: var(--color-accent);
                background: var(--color-accent);
                color: #fff;
            }
            .delivery-option input { display: none; }

            /* Button */
            .btn-order {
                background: var(--color-accent);
                color: #fff;
                border: none;
                padding: 1rem;
                font-size: 0.9rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border-radius: var(--radius);
                cursor: pointer;
                transition: opacity 0.2s;
                width: 100%%;
                margin-top: 0.5rem;
            }
            .btn-order:hover { opacity: 0.85; }
            .btn-order:disabled { opacity: 0.5; cursor: not-allowed; }

            /* Push Notification */
            .push-notification {
                position: fixed;
                top: 2rem;
                right: 2rem;
                background: #fff;
                border: 1px solid var(--color-border);
                border-left: 3px solid var(--color-accent);
                padding: 1.25rem 1.5rem;
                border-radius: var(--radius);
                box-shadow: 0 8px 30px rgba(0,0,0,0.08);
                z-index: 9999;
                transform: translateX(120%%);
                opacity: 0;
                transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
                max-width: 400px;
            }
            .push-notification.show { transform: translateX(0); opacity: 1; }
            .push-header { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; }
            .push-icon { font-size: 1.25rem; }
            .push-title { font-weight: 600; font-size: 0.95rem; color: var(--color-text); }
            .push-message { font-size: 0.85rem; color: var(--color-muted); line-height: 1.5; }
            .push-close {
                position: absolute;
                top: 0.75rem;
                right: 0.75rem;
                background: none;
                border: none;
                font-size: 1.2rem;
                color: var(--color-muted);
                cursor: pointer;
                line-height: 1;
            }
            .push-close:hover { color: var(--color-text); }

            /* Alert/Flash */
            .alert-custom {
                padding: 1rem;
                border-radius: var(--radius);
                margin-bottom: 1.5rem;
                font-size: 0.9rem;
                border: 1px solid var(--color-border);
            }
            .alert-success { background: #f9f9f9; border-color: #111; color: #111; }
            .alert-danger { background: #fef2f2; border-color: #fecaca; color: #991b1b; }

            /* Field Toggle Animation */
            .field-wrapper { position: relative; overflow: hidden; min-height: 100px; }
            .field-slide { transition: transform 0.3s ease, opacity 0.3s ease; }
            .field-slide.hidden { position: absolute; opacity: 0; pointer-events: none; transform: translateY(10px); width: 100%%; }
            .field-slide.visible { position: relative; opacity: 1; pointer-events: all; transform: translateY(0); }

            @media (max-width: 600px) {
                .delivery-options { flex-direction: column; }
                .push-notification { left: 1rem; right: 1rem; top: 1rem; max-width: none; }
                .order-wrapper { padding: 2rem 1rem; }
            }
        </style>';

        $content = $customStyles . $flashHtml . '
        <!-- Push-уведомление -->
        <div id="pushNotification" class="push-notification" role="alert">
            <div class="push-header">
                <span class="push-icon">✓</span>
                <span class="push-title">Заказ создан</span>
                <button class="push-close" onclick="hidePushNotification()">&times;</button>
            </div>
            <div class="push-message" id="pushMessage">
                Ваш заказ передан в обработку. Менеджер свяжется с вами в ближайшее время.
            </div>
        </div>

        <div class="order-wrapper">
            <div class="order-header">
                <h1 class="order-title">Оформление</h1>
                <p class="order-subtitle">Проверьте детали и подтвердите заказ</p>
            </div>

            <div class="order-summary">
                '.$summaryHtml.'
            </div>

            <form action="/order" method="POST" id="orderForm" class="order-form">
                <div>
                    <label for="fio" class="form-label">ФИО получателя *</label>
                    <input type="text" class="form-input" id="fio" name="fio" placeholder="Иванов Иван Иванович" required>
                </div>

                <div class="field-wrapper">
                    <label class="form-label" id="contactLabel">Email *</label>
                    <div id="emailField" class="field-slide visible">
                        <input type="email" class="form-input" id="email" name="email" placeholder="example@mail.ru" required>
                        <div class="field-hint">Куда отправить подтверждение и чек</div>
                    </div>
                    <div id="addressField" class="field-slide hidden">
                        <input type="text" class="form-input" id="address" name="address" placeholder="г. Москва, ул. Примерная, д. 1, кв. 1">
                        <div class="field-hint">Адрес для курьерской доставки</div>
                    </div>
                </div>

                <div>
                    <label for="phone" class="form-label">Телефон *</label>
                    <input type="tel" class="form-input" id="phone" name="phone" placeholder="+7 (999) 000-00-00" required>
                </div>

                <div>
                    <label class="form-label">Способ получения</label>
                    <div class="delivery-options">
                        <label class="delivery-option active" data-type="email">
                            <input type="radio" name="delivery_type" value="email" checked>
                            <span>📧 Email</span>
                        </label>
                        <label class="delivery-option" data-type="courier">
                            <input type="radio" name="delivery_type" value="courier">
                            <span>🚚 Курьер</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-order" id="submitBtn">Подтвердить заказ</button>
            </form>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const emailRadio = document.querySelector(\'input[name="delivery_type"][value="email"]\');
            const courierRadio = document.querySelector(\'input[name="delivery_type"][value="courier"]\');
            const addressField = document.getElementById("addressField");
            const emailField = document.getElementById("emailField");
            const contactLabel = document.getElementById("contactLabel");
            const addressInput = document.getElementById("address");
            const emailInput = document.getElementById("email");
            const form = document.getElementById("orderForm");
            const submitBtn = document.getElementById("submitBtn");

            function toggleContactField() {
                if (emailRadio.checked) {
                    contactLabel.textContent = "Email *";
                    addressField.classList.remove("visible");
                    addressField.classList.add("hidden");
                    emailField.classList.remove("hidden");
                    emailField.classList.add("visible");
                    addressInput.required = false;
                    emailInput.required = true;
                } else {
                    contactLabel.textContent = "Адрес доставки *";
                    emailField.classList.remove("visible");
                    emailField.classList.add("hidden");
                    addressField.classList.remove("hidden");
                    addressField.classList.add("visible");
                    emailInput.required = false;
                    addressInput.required = true;
                }
            }

            emailRadio.addEventListener("change", toggleContactField);
            courierRadio.addEventListener("change", toggleContactField);

            document.querySelectorAll(".delivery-option").forEach(option => {
                option.addEventListener("click", function() {
                    document.querySelectorAll(".delivery-option").forEach(o => o.classList.remove("active"));
                    this.classList.add("active");
                    this.querySelector("input").checked = true;
                    toggleContactField();
                });
            });

            toggleContactField();

            form.addEventListener("submit", function(e) {
                submitBtn.disabled = true;
                submitBtn.textContent = "Обработка...";
            });

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get("success") === "1") {
                showPushNotification();
                form.reset();
                document.querySelector(\'input[name="delivery_type"][value="email"]\').checked = true;
                document.querySelectorAll(".delivery-option").forEach((o, i) => o.classList.toggle("active", i === 0));
                toggleContactField();
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });

        function showPushNotification() {
            const notification = document.getElementById("pushNotification");
            if (notification) {
                notification.classList.add("show");
                setTimeout(hidePushNotification, 5000);
            }
        }

        function hidePushNotification() {
            const notification = document.getElementById("pushNotification");
            if (notification) notification.classList.remove("show");
        }
        </script>';

        return str_replace(['{TITLE}', '{CONTENT}'], [$title, $content], $template);
    }
}