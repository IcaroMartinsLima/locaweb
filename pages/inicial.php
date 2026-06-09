<?php $pageTitle = ""; include "../header.php"; ?>
    <style>
        .index-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #welcomeSection {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hero-section {
            text-align: center;
            padding: 60px 20px 40px;
            width: 100%;
            max-width: 900px;
            animation: fadeIn 0.5s ease-in;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-logo {
            height: 100px;
            width: auto;
            max-width: 100%;
            margin-bottom: 24px;
        }

        .hero-section h1 {
            font-size: 48px;
            color: #1c1917;
            margin-bottom: 16px;
        }

        .hero-section .hero-subtitle {
            font-size: 20px;
            color: #78716c;
            margin-bottom: 12px;
        }

        .hero-section .hero-description {
            font-size: 16px;
            color: #78716c;
            max-width: 600px;
            margin: 0 auto 32px;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .hero-buttons .button {
            min-width: 160px;
        }

        .hero-buttons .button-outline {
            background: transparent;
            border: 2px solid #3730a3;
            color: #3730a3;
        }

        .hero-buttons .button-outline:hover {
            background: #3730a3;
            color: #fff;
        }

        .section-title {
            text-align: center;
            font-size: 32px;
            color: #1c1917;
            margin-bottom: 40px;
        }

        .how-it-works {
            padding: 60px 20px;
            max-width: 900px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .step {
            text-align: center;
            padding: 30px;
        }

        .step-number {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #3730a3;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            margin: 0 auto 16px;
        }

        .step h3 {
            font-size: 20px;
            color: #1c1917;
            margin-bottom: 8px;
        }

        .step p {
            font-size: 14px;
            color: #78716c;
            line-height: 1.5;
        }

        .features-section {
            padding: 60px 20px;
            background: #e8e5df;
            width: 100%;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            max-width: 960px;
            margin: 0 auto;
        }

        .feature-card {
            background: #f8f7f4;
            border-radius: 12px;
            padding: 32px 24px;
            text-align: center;
        }

        .feature-card h3 {
            font-size: 18px;
            color: #3730a3;
            margin-bottom: 8px;
        }

        .feature-card p {
            font-size: 14px;
            color: #78716c;
            line-height: 1.5;
        }

        .cta-section {
            text-align: center;
            padding: 60px 20px;
        }

        .cta-section h2 {
            font-size: 28px;
            color: #1c1917;
            margin-bottom: 12px;
        }

        .cta-section p {
            font-size: 16px;
            color: #78716c;
            margin-bottom: 24px;
        }

        .cta-section .button {
            min-width: 200px;
            font-size: 16px;
            padding: 14px 32px;
        }

        .panel-header {
            text-align: center;
            margin-bottom: 8px;
        }

        .panel-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #78716c;
            margin-bottom: 8px;
            display: block;
        }

        .panel-greeting {
            font-size: 24px;
            font-weight: 500;
            color: #1c1917;
            margin-bottom: 4px;
        }

        .panel-subtitle {
            font-size: 14px;
            color: #78716c;
        }

        .logged-user-name {
            color: #3730a3;
            font-weight: 600;
        }

        .logged-content {
            padding: 48px 20px 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 32px;
            width: 100%;
            max-width: 820px;
            margin: 0 auto;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            width: 100%;
        }

        .dashboard-grid.cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .dash-card {
            display: flex;
            flex-direction: column;
            background: #fff;
            border: 0.5px solid #e8e5df;
            border-radius: 12px;
            text-decoration: none;
            overflow: hidden;
            transition: border-color 0.2s;
        }

        .dash-card:hover {
            border-color: #c7c4be;
        }

        .dash-card-bar {
            height: 2.5px;
            flex-shrink: 0;
        }

        .dash-card-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .dash-card-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .dash-card-title {
            font-size: 13px;
            font-weight: 500;
            color: #1c1917;
            margin: 0;
        }

        .dash-card-desc {
            font-size: 12px;
            color: #78716c;
            margin: 0;
            line-height: 1.4;
        }

        .dash-card-link {
            font-size: 12px;
            font-weight: 500;
            margin-top: 4px;
        }

        @media (max-width: 900px) {
            .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .step {
                padding: 20px;
            }
        }

        @media (max-width: 700px) {
            .dashboard-grid,
            .dashboard-grid.cols-3 {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-section {
                padding: 40px 16px 32px;
            }

            .hero-logo {
                height: 72px;
            }

            .hero-section h1 {
                font-size: 36px;
            }

            .hero-section .hero-subtitle {
                font-size: 18px;
            }

            .section-title {
                font-size: 26px;
                margin-bottom: 32px;
            }

            .how-it-works {
                padding: 40px 16px;
            }

            .features-section {
                padding: 40px 16px;
            }

            .cta-section {
                padding: 40px 16px;
            }

            .cta-section h2 {
                font-size: 24px;
            }
        }

        @media (max-width: 600px) {
            .steps-grid {
                grid-template-columns: 1fr;
            }

            .hero-section {
                padding: 32px 16px 24px;
            }

            .hero-logo {
                height: 56px;
                margin-bottom: 16px;
            }

            .hero-section h1 {
                font-size: 28px;
            }

            .hero-section .hero-subtitle {
                font-size: 16px;
            }

            .hero-section .hero-description {
                font-size: 14px;
                margin-bottom: 24px;
            }

            .hero-buttons .button {
                min-width: 140px;
                font-size: 13px;
                padding: 10px 20px;
            }

            .section-title {
                font-size: 22px;
                margin-bottom: 24px;
            }

            .step {
                padding: 16px;
                gap: 16px;
            }

            .step-number {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .step h3 {
                font-size: 18px;
            }

            .features-grid {
                gap: 16px;
            }

            .feature-card {
                padding: 24px 16px;
            }

            .cta-section .button {
                min-width: 0;
                width: 100%;
                max-width: 280px;
            }

            .dashboard-grid,
            .dashboard-grid.cols-3 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="index-content" id="landingContent">
        <div id="welcomeSection">
            <div class="hero-section">
                <img src="/images/UniversalScore.png" alt="UniversalScore Logo" class="hero-logo">
                <h1>UniversalScore</h1>
                <p class="hero-subtitle">A plataforma de avaliações mais confiável</p>
                <p class="hero-description">
                    Cadastre produtos, avalie com notas e comentários, e acompanhe indicadores
                    detalhados para tomar as melhores decisões.
                </p>
                <div class="hero-buttons">
                    <a href="register.html" class="button">Criar Conta</a>
                    <a href="login.html" class="button button-outline">Entrar</a>
                </div>
            </div>

            <div class="how-it-works">
                <h2 class="section-title">Como Funciona</h2>
                <div class="steps-grid">
                    <div class="step">
                        <div class="step-number">1</div>
                        <h3>Crie sua conta</h3>
                        <p>Cadastre-se gratuitamente em poucos segundos e tenha acesso a todos os recursos da plataforma.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <h3>Adicione produtos</h3>
                        <p>Cadastre os produtos que deseja avaliar com nome, categoria, preço e descrição detalhada.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <h3>Avalie e acompanhe</h3>
                        <p>Dê notas, escreva comentários e acompanhe indicadores como médias, preços e produtos mais avaliados.</p>
                    </div>
                </div>
            </div>

            <div class="features-section">
                <h2 class="section-title">Recursos</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <h3>Produtos</h3>
                        <p>Gerencie seu catálogo de produtos com informações completas e organizadas.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Avaliações</h3>
                        <p>Atribua notas de 1 a 5 estrelas e escreva comentários detalhados sobre cada produto.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Indicadores</h3>
                        <p>Visualize estatísticas como avaliação média, total de produtos e preços mínimo e máximo.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Conta</h3>
                        <p>Acompanhe suas contribuições e gerencie suas informações pessoais com segurança.</p>
                    </div>
                </div>
            </div>

            <div class="cta-section">
                <h2>Pronto para começar?</h2>
                <p>Cadastre-se gratuitamente e comece a avaliar produtos em poucos minutos.</p>
                <a href="register.html" class="button">Criar Conta Gratuita</a>
            </div>
        </div>

        <div class="logged-content" id="loggedWelcome" style="display: none;">
            <div class="panel-header">
                <span class="panel-label">Painel</span>
                <p class="panel-greeting">Bem-vindo, <span id="welcomeName" class="logged-user-name"></span>!</p>
                <p class="panel-subtitle">Escolha um módulo para começar</p>
            </div>
            <div class="dashboard-grid" id="navSection">
                <a href="ratings.php" class="dash-card">
                    <div class="dash-card-bar" style="background: #d97706;"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-icon" style="background: #fffbeb;">
                            <i class="ti ti-star" style="color: #d97706;"></i>
                        </div>
                        <h3 class="dash-card-title">Avaliações</h3>
                        <p class="dash-card-desc">Avaliar produtos e ver avaliações</p>
                        <span class="dash-card-link" style="color: #d97706;">Acessar &rarr;</span>
                    </div>
                </a>
                <a href="indicators.php" class="dash-card">
                    <div class="dash-card-bar" style="background: #059669;"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-icon" style="background: #ecfdf5;">
                            <i class="ti ti-chart-bar" style="color: #059669;"></i>
                        </div>
                        <h3 class="dash-card-title">Indicadores</h3>
                        <p class="dash-card-desc">Ver estatísticas e indicadores</p>
                        <span class="dash-card-link" style="color: #059669;">Acessar &rarr;</span>
                    </div>
                </a>
                <a href="account.php" class="dash-card">
                    <div class="dash-card-bar" style="background: #6d28d9;"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-icon" style="background: #f3e8ff;">
                            <i class="ti ti-user" style="color: #6d28d9;"></i>
                        </div>
                        <h3 class="dash-card-title">Conta</h3>
                        <p class="dash-card-desc">Gerenciar informações da sua conta</p>
                        <span class="dash-card-link" style="color: #6d28d9;">Acessar &rarr;</span>
                    </div>
                </a>
                <a href="product-types.php" class="dash-card gestor-card" style="display:none;">
                    <div class="dash-card-bar" style="background: #0891b2;"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-icon" style="background: #ecfeff;">
                            <i class="ti ti-tags" style="color: #0891b2;"></i>
                        </div>
                        <h3 class="dash-card-title">Tipos de Produto</h3>
                        <p class="dash-card-desc">Gerenciar tipos de produto (Gestor)</p>
                        <span class="dash-card-link" style="color: #0891b2;">Acessar &rarr;</span>
                    </div>
                </a>
                <a href="gestor-products.php" class="dash-card gestor-card" style="display:none;">
                    <div class="dash-card-bar" style="background: #0d9488;"></div>
                    <div class="dash-card-body">
                        <div class="dash-card-icon" style="background: #ccfbf1;">
                            <i class="ti ti-building-warehouse" style="color: #0d9488;"></i>
                        </div>
                        <h3 class="dash-card-title">Produtos (Gestor)</h3>
                        <p class="dash-card-desc">Gerenciar produtos no banco de dados</p>
                        <span class="dash-card-link" style="color: #0d9488;">Acessar &rarr;</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="../scripts/commonScript.js"></script>
    <script src="../scripts/homeScript.js"></script>
</body>
</html>