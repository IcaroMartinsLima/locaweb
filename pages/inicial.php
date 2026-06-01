<?php $pageTitle = ""; include "../header.php"; ?>
    <style>
        .index-content {
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 40px;
            min-height: calc(100vh - 100px);
        }

        .welcome-section {
            text-align: center;
            color: #1c1917;
            animation: fadeIn 0.5s ease-in;
        }

        .welcome-logo {
            height: 80px;
            width: auto;
            margin-bottom: 20px;
        }

        .welcome-section h1 {
            font-size: 42px;
            margin-bottom: 10px;
            color: #1c1917;
        }

        .welcome-section p {
            font-size: 18px;
            color: #78716c;
            margin-bottom: 10px;
        }

        .welcome-section .subtitle {
            color: #78716c;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .navigation-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 900px;
        }

        .logged-user-name {
            color: #3730a3;
            font-weight: bold;
        }
    </style>

    <div class="index-content">
        <div class="welcome-section" id="welcomeSection">
            <img src="/images/UniversalScore.png" alt="UniversalScore Logo" class="welcome-logo">
            <h1>UniversalScore</h1>
            <p>A plataforma de avaliações mais confiável</p>
            <p class="subtitle">Faça login para começar</p>
        </div>

        <div class="welcome-section" id="loggedWelcome" style="display: none;">
            <img src="/images/UniversalScore.png" alt="UniversalScore Logo" class="welcome-logo">
            <h1>Bem-vindo, <span id="welcomeName" class="logged-user-name"></span>!</h1>
            <p>Escolha uma opção abaixo para continuar</p>
        </div>

        <div class="navigation-section" id="navSection" style="display: none;">
            <a href="products.php" class="nav-card">
                <h3>Produtos</h3>
                <p>Gerenciar produtos e suas informações</p>
            </a>

            <a href="ratings.php" class="nav-card">
                <h3>Avaliações</h3>
                <p>Avaliar produtos e ver avaliações</p>
            </a>

            <a href="indicators.php" class="nav-card">
                <h3>Indicadores</h3>
                <p>Ver estatísticas e indicadores</p>
            </a>

            <a href="account.php" class="nav-card">
                <h3>Conta</h3>
                <p>Gerenciar informações da sua conta</p>
            </a>
        </div>
    </div>

    <script src="../scripts/commonScript.js"></script>
    <script src="../scripts/homeScript.js"></script>
</body>
</html>