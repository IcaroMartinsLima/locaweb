<?php $pageTitle = "Gestão de Tipos de Produto"; include "../header.php"; ?>

    <div class="content-container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#1c1917; font-size:20px; font-weight:500;">Tipos de Produto</h2>
            <button class="button" onclick="openCreateModal()">+ Novo Tipo</button>
        </div>
        <div id="tiposContainer"></div>
    </div>

    <div class="overlay" id="tipoModal">
        <div class="modal-box">
            <h2 id="tipoModalTitle">Adicionar Tipo de Produto</h2>
            <form id="tipoForm" class="form">
                <input type="hidden" id="editTipoId">
                <input type="text" id="tipoDescricao" placeholder="Descrição do tipo" required>
                <button type="submit" id="tipoModalBtn">Salvar</button>
            </form>
            <button onclick="closeTipoModal()" style="position:absolute;top:10px;right:10px;background:none;border:none;color:#78716c;font-size:24px;cursor:pointer;">×</button>
        </div>
    </div>

    <script src="../scripts/commonScript.js"></script>
    <script src="../scripts/productTypeScript.js"></script>
</body>
</html>
