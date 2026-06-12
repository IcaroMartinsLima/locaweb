<?php $pageTitle = "Indicadores"; include "../header.php"; ?>

    <div class="content-container">
        <div class="indicators-grid">
            <div class="indicator-card">
                <h3>Total de Produtos</h3>
                <div class="value" id="totalProducts">0</div>
            </div>
            <div class="indicator-card">
                <h3>Total de Avaliações</h3>
                <div class="value" id="totalRatings">0</div>
            </div>
            <div class="indicator-card">
                <h3>Avaliação Média</h3>
                <div class="value" id="avgRating">N/A</div>
            </div>
            <div class="indicator-card">
                <h3>Melhor Avaliado</h3>
                <div class="value" id="bestRated">-</div>
            </div>
            <div class="indicator-card">
                <h3>Pior Avaliado</h3>
                <div class="value" id="worstRated">-</div>
            </div>
            <div class="indicator-card">
                <h3>Mais Avaliações</h3>
                <div class="value" id="mostReviews">-</div>
            </div>
        </div>

        <h2 style="margin-top: 40px; color: #1c1917;">Avaliações Recentes</h2>
        <table class="ratings-table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Avaliador</th>
                    <th>Nota</th>
                    <th>Comentário</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody id="ratingsBody"></tbody>
        </table>
    </div>

    <script src="../scripts/commonScript.js"></script>
    <script src="../scripts/indicatorsScript.js"></script>
</body>
</html>
