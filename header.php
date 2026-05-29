<?php
$pageTitle = $pageTitle ?? '';
$headerType = $headerType ?? 'default';
?>
<header class="header">
    <?php if ($headerType === 'inicial'): ?>
    <div class="logged-header" id="authHeader">
        <div style="display: flex; align-items: center; gap: 15px;">
            <img src="images/UniversalScore.png" alt="UniversalScore Logo" class="logo" style="height: 40px;">
        </div>
        <div class="buttons" id="authButtons">
            <a href="login.html" class="button">Login</a>
            <a href="register.html" class="button">Cadastro</a>
        </div>
        <div id="userSection" style="display: none; align-items: center; gap: 15px; color: white;">
            <span class="logged-user-info">Bem-vindo, <span class="logged-user-name" id="userName"></span>!</span>
            <button class="button" style="background-color: rgb(172, 14, 14);" onclick="logout()">Sair</button>
        </div>
    </div>
    <?php else: ?>
    <div style="display: flex; align-items: center; gap: 15px;">
        <a href="inicial.php" style="text-decoration: none;">
            <img src="images/UniversalScore.png" alt="Logo" class="logo">
        </a>
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
    </div>
    <div style="display: flex; align-items: center; gap: 15px;">
        <span style="color: #aaa;" id="userGreeting"></span>
        <button class="button logout-button" onclick="logout()">Sair</button>
    </div>
    <?php endif; ?>
</header>
