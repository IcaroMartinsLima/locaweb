<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="icon" type="image/png" href="/images/UniversalScore.png">
    <title><?= $pageTitle ?><?= $pageTitle ? " - " : "" ?>UniversalScore</title>
</head>
<body>
    <header class="header">
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="/index.php" style="text-decoration: none;">
                <img src="/images/UniversalScore.png" alt="UniversalScore Logo" class="logo">
            </a>
            <?php if ($pageTitle): ?>
                <h1><?= $pageTitle ?></h1>
            <?php endif; ?>
        </div>
        <div style="display: flex; align-items: center; gap: 15px;">
            <div class="buttons" id="authButtons" style="display: none;">
                <a href="login.html" class="button">Login</a>
                <a href="register.html" class="button">Cadastro</a>
            </div>
            <div id="userSection" style="display: none; align-items: center; gap: 15px; color: #1c1917;">
                <span>Bem-vindo, <span id="userGreeting"></span>!</span>
                <button class="button logout-button" onclick="logout()">Sair</button>
            </div>
        </div>
    </header>
