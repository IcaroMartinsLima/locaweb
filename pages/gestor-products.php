<?php $pageTitle = "Gestão de Produtos"; include "../header.php"; ?>

    <div class="content-container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#1c1917; font-size:20px; font-weight:500;">Produtos</h2>
            <button class="button" onclick="openCreateModal()">+ Novo Produto</button>
        </div>
        <div id="produtosContainer"></div>
    </div>

    <div class="overlay" id="produtoModal">
        <div class="modal-box">
            <h2 id="produtoModalTitle">Adicionar Produto</h2>
            <form id="produtoForm" class="form">
                <input type="hidden" id="editProdutoId">
                <input type="text" id="produtoNome" placeholder="Nome do produto" required>
                <input type="text" id="produtoDescricao" placeholder="Descrição do produto" required>
                <select id="produtoTipoId" required>
                    <option value="">Selecione o tipo</option>
                </select>
                <button type="submit" id="produtoModalBtn">Salvar</button>
            </form>
            <button onclick="closeProdutoModal()" style="position:absolute;top:10px;right:10px;background:none;border:none;color:#78716c;font-size:24px;cursor:pointer;">×</button>
        </div>
    </div>

    <script src="../scripts/commonScript.js"></script>
    <script src="../scripts/gestorProductScript.js"></script>
</body>
</html>
