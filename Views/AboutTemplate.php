<?php
namespace Views;

class AboutTemplate extends BaseTemplate
{
    public static function getTemplate(): string
    {
        $template = parent::getTemplate();
        $title = 'О компании — spin4spin';
        
        $customStyles = '
        <style>
            /* Подключение шрифта Inter для стиля spin4spin */
            @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap");

            :root {
                --color-primary: #000000;
                --color-secondary: #666666;
                --color-border: #e5e5e5;
                --color-bg-light: #f9f9f9;
                --font-main: "Inter", sans-serif;
            }

            .about-wrapper {
                font-family: var(--font-main);
                color: var(--color-primary);
                max-width: 1200px;
                margin: 0 auto;
                padding: 4rem 1rem;
            }

            /* Hero Section */
            .about-hero {
                text-align: center;
                margin-bottom: 5rem;
                border-bottom: 1px solid var(--color-border);
                padding-bottom: 4rem;
            }

            .about-tag {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.15em;
                color: var(--color-secondary);
                margin-bottom: 1rem;
                display: block;
            }

            .about-title {
                font-size: 3.5rem;
                font-weight: 500;
                line-height: 1.1;
                margin-bottom: 1.5rem;
                letter-spacing: -0.02em;
            }

            .about-text {
                font-size: 1.1rem;
                color: var(--color-secondary);
                max-width: 650px;
                margin: 0 auto;
                line-height: 1.6;
            }

            /* Features Grid */
            .features-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 2rem;
                margin-bottom: 5rem;
            }

            .feature-item {
                text-align: left;
                padding: 2rem 0;
                border-top: 1px solid var(--color-primary);
            }

            .feature-icon {
                font-size: 1.5rem;
                margin-bottom: 1rem;
                display: block;
            }

            .feature-title {
                font-size: 1rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .feature-desc {
                font-size: 0.9rem;
                color: var(--color-secondary);
                line-height: 1.5;
            }

            /* Contact Block */
            .contact-section {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
                margin-bottom: 4rem;
                align-items: center;
            }

            .contact-info h3 {
                font-size: 2rem;
                font-weight: 400;
                margin-bottom: 1.5rem;
            }

            .contact-link {
                font-size: 1.25rem;
                color: var(--color-primary);
                text-decoration: none;
                border-bottom: 1px solid var(--color-primary);
                padding-bottom: 2px;
                transition: opacity 0.3s;
            }

            .contact-link:hover {
                opacity: 0.6;
                text-decoration: none;
            }

            .btn-minimal {
                display: inline-block;
                margin-top: 1.5rem;
                padding: 1rem 2.5rem;
                background: var(--color-primary);
                color: #fff;
                text-decoration: none;
                font-size: 0.9rem;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                transition: all 0.3s;
            }

            .btn-minimal:hover {
                background: #333;
                color: #fff;
            }

            /* Map */
            .map-container {
                width: 100%;
                height: 450px;
                background: var(--color-bg-light);
                filter: grayscale(100%); /* Карта в ч/б для стиля */
                transition: filter 0.3s;
            }
            
            .map-container:hover {
                filter: grayscale(0%);
            }

            .footer-note {
                text-align: center;
                margin-top: 4rem;
                font-size: 0.8rem;
                color: #999;
                text-transform: uppercase;
                letter-spacing: 0.1em;
            }

            /* Responsive */
            @media (max-width: 992px) {
                .features-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
                .about-title {
                    font-size: 2.5rem;
                }
            }

            @media (max-width: 768px) {
                .contact-section {
                    grid-template-columns: 1fr;
                    gap: 2rem;
                }
                .features-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>';

        $content = $customStyles . '
        <div class="about-wrapper">
            <!-- Hero -->
            <section class="about-hero">
                <span class="about-tag">Est. 2020</span>
                <h1 class="about-title">О компании</h1>
                <p class="about-text">
                    Spin4Spin — сервис ресейла брендовых предметов гардероба. Идея проекта возникла у Тимофея Хапкина, который работал личным закупщиком для московской модной элиты и хорошо знал бренды и дизайнеров.Сначала все вещи хранились в квартире Хапкина, но со временем коллекция выросла и потребовала большего пространства. Один из клиентов помог Хапкину расширить бизнес. После переезда в отдельное помещение проект стал популярным среди любителей моды, рэперов и поп-исполнителей В 2020 году Spin4Spin выпустил два ролика о гармонии человека и природы. Источником вдохновения для видео стал слоган проекта «Reuse. Recycle. Relove» — «Повторное использование. Переработка. «Новая любовь»
                </p>
            </section>

            <!-- Advantages -->
            <section class="features-grid">
                <div class="feature-item">
                    <span class="feature-icon">⚡</span>
                    <h4 class="feature-title">Оперативность</h4>
                    <p class="feature-desc">Доставка в течении 7 дней.</p>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">📄</span>
                    <h4 class="feature-title">Доставка по всей России</h4>
                    <p class="feature-desc">Все службы доставки(Sdeck,Яндекс Дщставка,Авито.</p>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">🤝</span>
                    <h4 class="feature-title">Сервис</h4>
                    <p class="feature-desc">В нашем магазине присутсвуют консультанты которые всегда готовы помочь.</p>
                </div>
            </section>

            <!-- Contact -->
            <section class="contact-section">
                <div class="contact-info">
                    <h3>Связаться с нами</h3>
                    <p style="color: #666; margin-bottom: 1.5rem;">
                        Подбор индивидуального тарифа — бесплатно.<br>
                        Наши эксперты готовы ответить на любые вопросы.
                    </p>
                    <a href="tel:+79999999999" class="contact-link">+7 (999) 999-99-99</a>
                    <br>
                    <a href="mailto:info@spin4spin.com" class="contact-link" style="font-size: 1rem; border: none; color: #999;">info@spin4spin.com</a>
                    <br>
                    <a href="#" class="btn-minimal">Заказать звонок</a>
                </div>
                <div class="map-box">
                    <!-- Карта с ч/б фильтром в CSS -->
                    <iframe src="https://yandex.ru/map-widget/v1/?ll=37.617635%2C55.755814&z=10" width="100%" height="450" frameborder="0" style="border:0;"></iframe>
                </div>
            </section>

            <!-- Footer Note -->
            <div class="footer-note">
                Учебный проект • Разработано в «Кемеровском Кооперативном Техникуме»
            </div>
        </div>';

        return str_replace(['{TITLE}', '{CONTENT}'], [$title, $content], $template);
    }
}