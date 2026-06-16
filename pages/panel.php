<?php $pageTitle = "Painel de Avaliações"; include "../header.php"; ?>

    <div class="content-container">

        <div class="panel-stats-grid">
            <div class="panel-stat-card">
                <span class="panel-stat-label">Total de Avaliações</span>
                <span class="panel-stat-value" id="panelTotalRatings">0</span>
            </div>
            <div class="panel-stat-card">
                <span class="panel-stat-label">Avaliação Média</span>
                <span class="panel-stat-value" id="panelAvgRating">N/A</span>
            </div>
            <div class="panel-stat-card">
                <span class="panel-stat-label">Produtos Avaliados</span>
                <span class="panel-stat-value" id="panelTotalProducts">0</span>
            </div>
            <div class="panel-stat-card">
                <span class="panel-stat-label">Melhor Avaliado</span>
                <span class="panel-stat-value" id="panelBestProduct">-</span>
            </div>
        </div>

        <div class="panel-charts-grid">
            <div class="panel-chart-card">
                <h3>Distribuição por Nota</h3>
                <canvas id="ratingDistChart"></canvas>
            </div>
            <div class="panel-chart-card">
                <h3>Avaliações por Produto</h3>
                <canvas id="productChart"></canvas>
            </div>
        </div>

        <div class="panel-filters">
            <select id="filterProduct">
                <option value="">Todos os Produtos</option>
            </select>
            <select id="filterRating">
                <option value="">Todas as Notas</option>
                <option value="5">5 ⭐</option>
                <option value="4">4 ⭐</option>
                <option value="3">3 ⭐</option>
                <option value="2">2 ⭐</option>
                <option value="1">1 ⭐</option>
            </select>
            <input type="date" id="filterDataInicio" class="panel-date-input" title="Data início">
            <input type="date" id="filterDataFim" class="panel-date-input" title="Data fim">
            <button id="btnExportPdf" class="button" style="padding:8px 16px;font-size:13px;">
                <i class="ti ti-file-type-pdf" style="margin-right:6px;"></i>Exportar PDF
            </button>
        </div>

        <div id="myFeedbacksContainer">
            <div class="empty-state" id="emptyFeedbacks" style="display:none;">Nenhuma avaliação encontrada.</div>
            <table class="ratings-table" id="feedbacksTable">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Avaliador</th>
                        <th>Nota</th>
                        <th>Comentário</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody id="feedbacksBody"></tbody>
            </table>
        </div>
    </div>

    <script src="../scripts/commonScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../scripts/panelScript.js"></script>
</body>
</html>
