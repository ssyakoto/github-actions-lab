<?php
namespace Views;

class HomeTemplate extends BaseTemplate
{
    public static function getTemplate(): string
    {
        $template = parent::getTemplate();
        $title = 'Главная — spin4spin';
        
        // Services URL helper
        $servicesUrl = '/services';

        // New Minimalist/Luxury Styles
        // ВНИМАНИЕ: Все символы % заменены на %% для корректной работы sprintf
        $customStyles = '
        <style>
            /* Typography & Base */
            :root {
                --color-text: #111111;
                --color-text-muted: #666666;
                --color-border: #e5e5e5;
                --color-accent: #000000;
                --font-main: "Inter", sans-serif;
            }

            /* Hero Carousel */
            .hero-carousel {
                position: relative;
                background: #f9f9f9;
            }
            .hero-carousel .carousel-item {
                height: 600px;
                background: #000;
            }
            .hero-carousel .carousel-item img {
                width: 100%%;
                height: 100%%;
                object-fit: cover;
                opacity: 0.7; /* Darken image slightly for text readability */
            }
            .hero-caption {
                bottom: 30%%;
                left: 10%%;
                transform: none;
                text-align: left;
                max-width: 600px;
                padding: 2rem;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(5px);
                border-radius: 0;
                box-shadow: none;
            }
            .hero-caption h5 {
                font-size: 3rem;
                font-weight: 700;
                color: var(--color-text);
                margin-bottom: 1rem;
                text-transform: uppercase;
                letter-spacing: -0.02em;
                line-height: 1.1;
            }
            .hero-caption p {
                font-size: 1.1rem;
                color: var(--color-text-muted);
                margin-bottom: 2rem;
                line-height: 1.6;
            }
            
            /* Buttons */
            .btn-luxury {
                background: var(--color-accent);
                color: #fff;
                padding: 1rem 2.5rem;
                font-size: 0.9rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border: none;
                border-radius: 2px;
                text-decoration: none;
                display: inline-block;
                transition: all 0.3s;
            }
            .btn-luxury:hover {
                background: #333;
                color: #fff;
                text-decoration: none;
                transform: none;
            }
            .btn-luxury-outline {
                background: transparent;
                border: 1px solid var(--color-text);
                color: var(--color-text);
                padding: 1rem 2.5rem;
                font-size: 0.9rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border-radius: 2px;
                text-decoration: none;
                display: inline-block;
                transition: all 0.3s;
            }
            .btn-luxury-outline:hover {
                background: var(--color-accent);
                color: #fff;
            }

            /* Features Section */
            .feature-card {
                border: 1px solid var(--color-border);
                background: #fff;
                padding: 2.5rem 2rem;
                text-align: left;
                height: 100%%;
                transition: border-color 0.3s;
                border-radius: 0;
            }
            .feature-card:hover {
                border-color: var(--color-accent);
            }
            .feature-icon {
                font-size: 2rem;
                margin-bottom: 1.5rem;
                color: var(--color-text);
            }
            .feature-card h5 {
                font-size: 1.1rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-bottom: 0.75rem;
                color: var(--color-text);
            }
            .feature-card p {
                color: var(--color-text-muted);
                font-size: 0.95rem;
                line-height: 1.6;
                margin-bottom: 0;
            }

            /* Intro Section */
            .section-intro {
                text-align: center;
                max-width: 800px;
                margin: 0 auto 5rem;
            }
            .section-intro span {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.15em;
                color: var(--color-text-muted);
                display: block;
                margin-bottom: 1rem;
            }
            .section-intro h2 {
                font-size: 2.5rem;
                font-weight: 600;
                color: var(--color-text);
                margin-bottom: 1.5rem;
                letter-spacing: -0.02em;
            }
            .section-intro p {
                font-size: 1.1rem;
                color: var(--color-text-muted);
                line-height: 1.7;
            }

            /* Promo Banner */
            .promo-banner {
                background: var(--color-accent);
                color: #fff;
                padding: 4rem 2rem;
                text-align: center;
                margin: 5rem 0;
                border-radius: 0;
            }
            .promo-banner h4 {
                font-size: 2rem;
                font-weight: 600;
                margin-bottom: 1rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .promo-banner p {
                font-size: 1.1rem;
                opacity: 0.8;
                margin-bottom: 2.5rem;
            }
            .btn-luxury-light {
                background: #fff;
                color: #000;
                padding: 1rem 2.5rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                border: none;
                text-decoration: none;
                transition: opacity 0.3s;
            }
            .btn-luxury-light:hover {
                opacity: 0.9;
                color: #000;
                text-decoration: none;
            }

            /* Footer Note */
            .education-note {
                border-top: 1px solid var(--color-border);
                padding-top: 2rem;
                margin-top: 4rem;
                text-align: center;
                color: var(--color-text-muted);
                font-size: 0.85rem;
            }

            /* Carousel Controls */
            .carousel-control-prev, .carousel-control-next {
                width: 5%%;
                opacity: 0;
                transition: opacity 0.3s;
            }
            .hero-carousel:hover .carousel-control-prev,
            .hero-carousel:hover .carousel-control-next {
                opacity: 1;
            }
            .carousel-indicators {
                bottom: 2rem;
                z-index: 5;
            }
            .carousel-indicators button {
                width: 40px;
                height: 2px;
                border: none;
                background-color: rgba(0,0,0,0.3);
                opacity: 1;
                transition: all 0.3s;
            }
            .carousel-indicators button.active {
                background-color: #000;
                height: 3px;
            }
            
            @media (max-width: 768px) {
                .hero-carousel .carousel-item { height: 500px; }
                .hero-caption {
                    left: 1rem; right: 1rem; bottom: 2rem;
                    background: rgba(255,255,255,0.95);
                    padding: 1.5rem;
                }
                .hero-caption h5 { font-size: 2rem; }
                .section-intro h2 { font-size: 2rem; }
            }
        </style>';

        $content = $customStyles . '
        <!-- Hero Section -->
        <section class="container-fluid p-0 mb-0">
            <div id="mainCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <img src="/assets/images/img1.jpg"
                             onerror="this.src=\'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1920&q=80\'"
                             class="d-block w-100" alt="Automotive">
                        <div class="carousel-caption d-none d-md-block hero-caption">
                            <h5>Concept<br>Store</h5>
                            <p>Первый concept store в городе Кемерово с именитыми дизайнерами</p>
                            <a href="'.$servicesUrl.'" class="btn-luxury">Explore</a>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <img src="/assets/images/img2.jpg"
                             onerror="this.src=\'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1920&q=80\'"
                             class="d-block w-100" alt="Property">
                        <div class="carousel-caption d-none d-md-block hero-caption">
                            <h5>Все новые колекции<br></h5>
                            <p>В наличе в первую неделю выхода во всех размерных таблицах</p>
                            <a href="'.$servicesUrl.'" class="btn-luxury">Explore</a>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="carousel-item">
                        <img src="/assets/images/img3.jpg"
                             onerror="this.src=\'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=1920&q=80\'"
                             class="d-block w-100" alt="Lifestyle">
                        <div class="carousel-caption d-none d-md-block hero-caption">
                            <h5>Reuse Recycle<br>Relove</h5>
                            <p>Повторное использование. Переработка. «Новая любовь.</p>
                            <a href="'.$servicesUrl.'" class="btn-luxury">Explore</a>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </section>

        <!-- Intro Section -->
        <div class="container py-5">
            <div class="section-intro">
                <span>Est. 2020</span>
                <h2>Spin4Spin</h2>
                <p>Spin4Spin — сервис ресейла брендовых предметов гардероба. Идея проекта возникла у Тимофея Хапкина, который работал личным закупщиком для московской модной элиты и хорошо знал бренды и дизайнеров.</p>
            </div>

            <!-- Features Grid -->
            <div class="row g-0 border-top border-bottom mb-5">
                <div class="col-md-4 border-end">
                    <div class="feature-card border-0">
                        <div class="feature-icon">⚡</div>
                        <h5>Оперативность</h5>
                        <p>Доставка в течении 7 дней.</p>
                    </div>
                </div>
                <div class="col-md-4 border-end">
                    <div class="feature-card border-0">
                        <div class="feature-icon">📄</div>
                        <h5>Доставка по всей России</h5>
                        <p>Все службы доставки(Sdeck,Яндекс Дщставка,Авито.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card border-0">
                        <div class="feature-icon">🤝</div>
                        <h5>Сервис</h5>
                        <p>В нашем магазине присутсвуют консультанты которые всегда готовы помочь.</p>
                    </div>
                </div>
            </div>

            <!-- Promo Banner -->
            <div class="promo-banner">
                <h4>Exclusive Online Offer</h4>
                <p>Подпишитесь на рассылку и получите скидку 15% на первый заказ.</p>
                <a href="'.$servicesUrl.'" class="btn-luxury-light">Get Started</a>
            </div>

            <!-- Education Note -->
            <div class="education-note">
                <p class="mb-1"><strong>Educational Project</strong></p>
                <p class="mb-0">
                  Учебный проект • Разработано в «Кемеровском Кооперативном Техникуме»
                </p>
            </div>
        </div>';

        return str_replace(['{TITLE}', '{CONTENT}'], [$title, $content], $template);
    }
}