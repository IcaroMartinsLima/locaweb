<?php $pageTitle = "Painel de Avaliações"; include "../header.php"; ?>

    <div class="content-container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#1c1917; font-size:20px; font-weight:500;">Todas as Avaliações</h2>
        </div>

        <div id="myFeedbacksContainer">
            <div class="empty-state" id="emptyFeedbacks">Nenhuma avaliação encontrada.</div>
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
    <script src="../scripts/panelScript.js"></script>
</body>
</html>
