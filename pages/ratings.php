<?php $pageTitle = "Avaliações"; include "../header.php"; ?>

    <div class="content-container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#1c1917; font-size:20px; font-weight:500;">Avaliar Produtos</h2>
        </div>

        <div id="pessoaWarning" style="display:none;" class="empty-state">
            <p>Você precisa cadastrar seus dados pessoais antes de avaliar produtos.</p>
            <button class="button" onclick="openPessoaModal()" style="margin-top:15px;">Cadastrar Dados</button>
        </div>

        <div id="ratingsContainer" class="ratings-grid"></div>

        <h2 style="color:#1c1917; font-size:20px; font-weight:500; margin-top:40px;">Minhas Avaliações</h2>
        <div id="myFeedbacksContainer">
            <div class="empty-state" id="emptyFeedbacks">Nenhuma avaliação encontrada.</div>
            <table class="ratings-table" id="feedbacksTable" style="display:none;">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Nota</th>
                        <th>Comentário</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="feedbacksBody"></tbody>
            </table>
        </div>
    </div>

    <div class="overlay" id="pessoaOverlay">
        <div class="modal-box">
            <h2>Cadastrar Dados Pessoais</h2>
            <form id="pessoaForm" class="form">
                <input type="text" id="pessoaNome" placeholder="Nome completo" required>
                <input type="text" id="pessoaCpf" placeholder="CPF (apenas números)" required>
                <input type="date" id="pessoaNascimento" required>
                <input type="text" id="pessoaTelefone" placeholder="Telefone" required>
                <button type="submit">Salvar</button>
            </form>
            <button onclick="closePessoaModal()" style="position:absolute;top:10px;right:10px;background:none;border:none;color:#78716c;font-size:24px;cursor:pointer;">×</button>
        </div>
    </div>

    <div class="overlay" id="ratingOverlay">
        <div class="modal-box">
            <h2>Avaliar: <span id="productNameDisplay"></span></h2>
            <form id="ratingForm" class="form">
                <div class="rating">
                    <input type="radio" name="rate" id="star5" value="5" required>
                    <label for="star5"></label>
                    <input type="radio" name="rate" id="star4" value="4">
                    <label for="star4"></label>
                    <input type="radio" name="rate" id="star3" value="3">
                    <label for="star3"></label>
                    <input type="radio" name="rate" id="star2" value="2">
                    <label for="star2"></label>
                    <input type="radio" name="rate" id="star1" value="1">
                    <label for="star1"></label>
                </div>
                <textarea id="comentario" placeholder="Seu comentário..." rows="3" required></textarea>
                <button type="submit">Enviar Avaliação</button>
            </form>
            <button onclick="closeRatingModal()" style="position:absolute;top:10px;right:10px;background:none;border:none;color:#78716c;font-size:24px;cursor:pointer;">×</button>
        </div>
    </div>

    <script src="../scripts/commonScript.js"></script>
    <script src="../scripts/ratingScript.js"></script>
</body>
</html>
