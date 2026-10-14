<?php
namespace Views;

class ServicesTemplate extends BaseTemplate
{
    public static function getTemplate(): string
    {
        $template = parent::getTemplate();
        $title = 'Услуги — spin4spin';

        $customStyles = '
        <style>
            :root {
                --color-text: #111111;
                --color-muted: #666666;
                --color-border: #e5e5e5;
                --color-accent: #000000;
                --color-bg: #ffffff;
                --radius: 4px;
                --font-main: "Inter", sans-serif;
            }
            body { 
                font-family: var(--font-main);
                background: #fff;
            }

            /* Section Headers */
            .section-title {
                font-size: 2.25rem;
                font-weight: 600;
                color: var(--color-text);
                margin-bottom: 0.75rem;
                letter-spacing: -0.02em;
            }
            .section-subtitle {
                color: var(--color-muted);
                font-size: 1rem;
                max-width: 600px;
                margin: 0 auto;
                line-height: 1.6;
            }
            .divider {
                width: 60px;
                height: 2px;
                background: var(--color-accent);
                margin: 20px auto;
            }

            /* Service Cards */
            .service-card {
                border: 1px solid var(--color-border);
                border-radius: var(--radius);
                background: var(--color-bg);
                transition: all 0.2s ease;
                height: 100%;
                text-decoration: none !important;
                display: block;
                position: relative;
                overflow: hidden;
            }
            .service-card:hover {
                border-color: var(--color-accent);
                transform: translateY(-2px);
                box-shadow: none;
            }
            
            /* 🔹 ФОНОВОЕ ИЗОБРАЖЕНИЕ С РАЗМЫТИЕМ */
            .service-card .card-bg-image {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                filter: blur(8px) brightness(0.85);
                transform: scale(1.1);
                z-index: 0;
                opacity: 0.6;
                transition: all 0.3s ease;
            }
            
            .service-card:hover .card-bg-image {
                opacity: 0.7;
                transform: scale(1.15);
            }
            
            /* 🔹 ЦЕНТРИРОВАНИЕ КОНТЕНТА В КАРТОЧКЕ */
            .service-card .card-body {
                position: relative;
                z-index: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 2rem 1.5rem;
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(4px);
                min-height: 100%;
            }
            
            /* УВЕЛИЧЕННЫЕ ИКОНКИ (В 2 РАЗА: 170px) */
            .service-card .icon-box {
                width: 170px;
                height: 170px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 2rem;
                transition: all 0.2s;
            }
            
            .service-card .icon-box img {
                display: block;
                margin: 0 auto;
                width: 100%;
                height: 100%;
                object-fit: contain;
                filter: grayscale(100%);
                transition: all 0.3s;
            }
            
            .service-card:hover .icon-box img {
                transform: scale(1.05);
                filter: grayscale(0%);
            }
            
            .cta-card .icon-box img {
                filter: grayscale(100%) brightness(0) invert(1);
            }
            .cta-card:hover .icon-box img {
                filter: grayscale(0%);
            }
            
            .card-title {
                font-weight: 600;
                color: var(--color-text);
                margin-bottom: 0.5rem;
                font-size: 1.1rem;
                text-align: center;
                width: 100%;
            }
            .card-text {
                color: var(--color-muted);
                line-height: 1.6;
                margin-bottom: 1.5rem;
                font-size: 0.9rem;
                text-align: center;
                width: 100%;
            }
            .btn-custom {
                border: 1px solid var(--color-border);
                color: var(--color-text);
                background: transparent;
                padding: 10px 24px;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                font-weight: 500;
                border-radius: var(--radius);
                transition: all 0.2s;
                display: inline-block;
                text-decoration: none;
            }
            .btn-custom:hover {
                background: var(--color-accent);
                border-color: var(--color-accent);
                color: #fff;
            }

            /* CTA Card (Consultation) */
            .cta-card {
                background: var(--color-accent);
                border-color: var(--color-accent);
            }
            .cta-card:hover { background: #222; }
            .cta-card .icon-box, .cta-card .card-title, .cta-card .card-text { color: #fff; }
            .cta-card .btn-custom {
                border-color: #fff;
                color: #fff;
            }
            .cta-card .btn-custom:hover {
                background: #fff;
                color: #000;
            }

            /* Calculator */
            .calc-card {
                background: #fff;
                border-radius: var(--radius);
                border: 1px solid var(--color-border);
                padding: 2.5rem;
                margin-top: 2rem;
            }
            .calc-header {
                background: transparent;
                color: var(--color-text);
                padding: 0 0 1.5rem;
                margin: 0 0 2rem;
                text-align: center;
                border-bottom: 1px solid var(--color-border);
            }
            .calc-header h3 {
                font-size: 1.5rem;
                font-weight: 600;
                letter-spacing: -0.01em;
            }
            .form-label {
                font-weight: 500;
                color: var(--color-text);
                margin-bottom: 0.5rem;
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
            }
            .form-control, .form-select {
                border: 1px solid var(--color-border);
                border-radius: var(--radius);
                padding: 0.75rem 1rem;
                font-size: 0.95rem;
                background: #fff;
                transition: border-color 0.2s;
            }
            .form-control:focus, .form-select:focus {
                border-color: var(--color-text);
                box-shadow: none;
            }

            /* Term Switch */
            .term-switch {
                display: flex;
                gap: 0.5rem;
                margin-bottom: 1rem;
                padding: 0.25rem;
                background: #fafafa;
                border-radius: var(--radius);
                border: 1px solid var(--color-border);
            }
            .term-switch .form-check { margin: 0; flex: 1; }
            .term-switch .form-check-input { display: none; }
            .term-switch .form-check-label {
                display: block;
                text-align: center;
                padding: 0.6rem 1rem;
                border-radius: 2px;
                cursor: pointer;
                font-weight: 500;
                color: var(--color-muted);
                font-size: 0.85rem;
                transition: all 0.2s;
            }
            .term-switch .form-check-input:checked + .form-check-label {
                background: var(--color-accent);
                color: #fff;
            }

            /* Options Grid */
            .options-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 1rem;
            }
            .option-card {
                border: 1px solid var(--color-border);
                border-radius: var(--radius);
                padding: 1rem;
                transition: border-color 0.2s;
            }
            .option-card:hover { border-color: #999; }
            .form-check-input:checked {
                background-color: var(--color-accent);
                border-color: var(--color-accent);
            }

            /* Button */
            .btn-calc {
                background: var(--color-accent);
                border: 1px solid var(--color-accent);
                padding: 12px 24px;
                border-radius: var(--radius);
                color: #fff;
                font-weight: 600;
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                width: 100%;
                transition: opacity 0.2s;
                cursor: pointer;
            }
            .btn-calc:hover { opacity: 0.85; }

            /* Result Box */
            .result-box {
                background: #fafafa;
                border: 1px solid var(--color-border);
                border-radius: var(--radius);
                padding: 2rem;
                margin-top: 2rem;
                display: none;
                text-align: center;
            }
            .result-value {
                font-size: 2rem;
                font-weight: 700;
                color: var(--color-text);
                line-height: 1.2;
            }
            .result-label {
                font-size: 0.8rem;
                color: var(--color-muted);
                margin-bottom: 0.5rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .btn-result {
                border: 1px solid var(--color-border);
                background: transparent;
                color: var(--color-text);
                padding: 10px 24px;
                font-size: 0.85rem;
                border-radius: var(--radius);
                cursor: pointer;
                transition: all 0.2s;
            }
            .btn-result:hover { background: var(--color-accent); color: #fff; border-color: var(--color-accent); }
            .btn-result-success {
                background: var(--color-accent);
                color: #fff;
                border: 1px solid var(--color-accent);
                padding: 10px 24px;
                font-size: 0.85rem;
                border-radius: var(--radius);
                text-decoration: none;
                display: inline-block;
            }
            .btn-result-success:hover { opacity: 0.85; color: #fff; }

            /* Responsive */
            @media (max-width: 768px) {
                .calc-card { padding: 1.5rem; }
                .section-title { font-size: 1.75rem; }
                .service-card .icon-box {
                    width: 120px;
                    height: 120px;
                }
            }
        </style>';

        $content = $customStyles . '
        <section class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title">Loolbooks-2026</h2>
                <p class="section-subtitle">Новые колеции модных домов и не только</p>
                <div class="divider"></div>
            </div>
            
            <div class="row g-4 justify-content-center">
                <a href="/product/1" class="col-md-6 col-lg-4">
                    <div class="card service-card shadow-none">
                        <div class="card-bg-image" style="background-image: url(\'/assets/images/carhartt1.jpg\');"></div>
                        <div class="card-body text-center">
                            <div class="icon-box">
                                <img src="/assets/images/carhartt1.jpg" alt="Carhartt" onerror="this.src=\'/assets/images/auto.png\'">
                            </div>
                            <h4 class="card-title">Carhartt Spring / Summer 2026 Lookbook</h4>
                            <p class="card-text">Introducing the Spring/Summer 2026 collection, which explores color, texture and print through new camouflage motifs and innovative wash techniques. Meanwhile, rugged outdoor influences and prep-inspired shapes are reimagined through a modern lens.</p>
                            <span class="btn btn-custom">Подробнее</span>
                        </div>
                    </div>
                </a>
                <a href="/product/2" class="col-md-6 col-lg-4">
                    <div class="card service-card shadow-none">
                        <div class="card-bg-image" style="background-image: url(\'/assets/images/balenca1.jpg\');"></div>
                        <div class="card-body text-center">
                            <div class="icon-box">
                                <img src="/assets/images/balenca1.jpg" alt="Balenciaga" onerror="this.src=\'/assets/images/property.png\'">
                            </div>
                            <h4 class="card-title">Balenciaga Fall 2026 Lookbook</h4>
                            <p class="card-text">This collection embodies the multitude of design codes that have been part of my creative vision and research on fashion at Balenciaga for a decade. It combines pieces from 35 different collections with new pieces and garments from my personal wardrobe.</p>
                            <span class="btn btn-custom">Подробнее</span>
                        </div>
                    </div>
                </a>
                <a href="/product/3" class="col-md-6 col-lg-4">
                    <div class="card service-card shadow-none">
                        <div class="card-bg-image" style="background-image: url(\'/assets/images/rick1.jpg\');"></div>
                        <div class="card-body text-center">
                            <div class="icon-box">
                                <img src="/assets/images/rick1.jpg" alt="Rick Owens" onerror="this.src=\'/assets/images/health.png\'">
                            </div>
                            <h4 class="card-title">Rick Owens Collection</h4>
                            <p class="card-text">Moving on to the next chapter, this is my tribute to the creative research and work that me and my teams have done for the past 10 years. It is also my love letter to the most loyal and fashion forward audience.</p>
                            <span class="btn btn-custom">Подробнее</span>
                        </div>
                    </div>
                </a>
                <a href="/product/5" class="col-md-6 col-lg-4">
                    <div class="card service-card shadow-none">
                        <div class="card-bg-image" style="background-image: url(\'/assets/images/travel.svg\');"></div>
                        <div class="card-body text-center">
                            <div class="icon-box">
                                <img src="/assets/images/westwood.jpg" alt="Путешествия" onerror="this.src=\'/assets/images/travel.png\'">
                            </div>
                            <h4 class="card-title">Vivienne Westwood Fall/Winter 2026</h4>
                            <p class="card-text">Dame Vivienne Westwood was an iconic British fashion designer and activist largely responsible for bringing punk and new wave fashion into the mainstream. Known as a "queen of punk," she combined 18th-century tailored historical references with rebellious, eco-conscious, and anti-establishment designs. Her legacy continues through her eponymous labe</p>
                            <span class="btn btn-custom">Подробнее</span>
                        </div>
                    </div>
                </a>
                <div class="col-md-6 col-lg-4">
                    <div class="card service-card cta-card shadow-none">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <div class="icon-box">
                                <img src="/assets/images/5.png" alt="Консультация" onerror="this.src=\'/assets/images/consultation.png\'">
                            </div>
                            <h4 class="card-title">spin4spin</h4>
                            <p class="card-text">Возможность уточнить наличие в магазине и на складе</p>
                            <a href="tel:+79999999999" class="btn btn-custom mt-2">+7 (999) 999-99-99</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
        document.querySelectorAll(\'input[name="termMode"]\').forEach(radio => {
            radio.addEventListener(\'change\', function() {
                const presetSelect = document.getElementById(\'termPresetSelect\');
                const customInput = document.getElementById(\'termCustomInput\');
                if (this.value === \'custom\') {
                    presetSelect.classList.add(\'d-none\');
                    customInput.classList.remove(\'d-none\');
                } else {
                    presetSelect.classList.remove(\'d-none\');
                    customInput.classList.add(\'d-none\');
                }
            });
        });

        document.getElementById("insuranceForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const productSelect = document.getElementById("productType");
            const baseRate = parseFloat(productSelect.options[productSelect.selectedIndex].dataset.rate);
            const objectValue = parseFloat(document.getElementById("objectValue").value) || 0;
            const coverageLevel = parseFloat(document.getElementById("coverageLevel").value);
            
            let termYears = 1, termDiscount = 0;
            const termMode = document.querySelector(\'input[name="termMode"]:checked\').value;
            
            if (termMode === \'preset\') {
                const preset = parseInt(document.getElementById(\'termPresetSelect\').value);
                termYears = preset;
                if (preset === 2) termDiscount = 0.05;
                if (preset === 3) termDiscount = 0.10;
                if (preset === 5) termDiscount = 0.15;
            } else {
                const customValue = parseInt(document.getElementById(\'termCustomValue\').value) || 12;
                const unit = parseInt(document.getElementById(\'termUnit\').value);
                const totalMonths = unit === 1 ? customValue * 12 : customValue;
                termYears = totalMonths / 12;
                if (totalMonths >= 24) termDiscount = 0.05;
                if (totalMonths >= 36) termDiscount = 0.10;
                if (totalMonths >= 60) termDiscount = 0.15;
            }
            
            let optionsTotal = 0;
            if (document.getElementById(\'optRoad\').checked) optionsTotal += 500;
            if (document.getElementById(\'optLegal\').checked) optionsTotal += 1000;
            if (document.getElementById(\'optDiag\').checked) optionsTotal += 1500;
            
            const coverageAmount = objectValue * coverageLevel;
            let premium = coverageAmount * baseRate;
            premium = premium * (1 - termDiscount);
            premium += optionsTotal;
            
            const formatRub = (num) => new Intl.NumberFormat("ru-RU", { style: "currency", currency: "RUB", maximumFractionDigits: 0 }).format(num);
            
            document.getElementById("finalPrice").textContent = formatRub(premium);
            document.getElementById("resObject").textContent = formatRub(objectValue);
            document.getElementById("resCoverage").textContent = (coverageLevel * 100) + "%";
            let termText = termYears % 1 === 0 ? termYears + " год" : termYears.toFixed(1) + " года";
            if (termDiscount > 0) termText += " (−" + (termDiscount * 100) + "%)";
            document.getElementById("resTerm").textContent = termText;
            
            const resultBox = document.getElementById("calcResult");
            resultBox.style.display = "block";
            resultBox.scrollIntoView({ behavior: "smooth", block: "center" });
        });
        </script>';

        return str_replace(['{TITLE}', '{CONTENT}'], [$title, $content], $template);
    }
}