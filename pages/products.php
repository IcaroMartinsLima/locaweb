<?php $pageTitle = "Produtos"; include "../header.php"; ?>

    <div class="content-container">
        <button class="button" id="addProductBtn" style="margin-bottom: 20px;">+ Novo Produto</button>
        <div class="products-grid" id="productsContainer"></div>
    </div>

    <div class="overlay" id="overlay">
        <div class="modal-box">
            <h2>Adicionar Novo Produto</h2>
            <form id="productForm" class="form">
                <input type="text" id="productName" placeholder="Nome do Produto" required>
                <select id="productCategory" required>
                    <option>Selecione Categoria</option>
                    <option>Celular</option>
                    <option>PC</option>
                    <option>Impressora</option>
                </select>
                <input type="number" id="productPrice" step="0.01" placeholder="Preço" required>
                <textarea id="productDescription" placeholder="Descrição" rows="3" required></textarea>
                <button type="submit">Adicionar</button>
            </form>
            <button id="closeModal" style="position: absolute; top: 10px; right: 10px; background: none; border: none; color: #78716c; font-size: 24px; cursor: pointer;">×</button>
        </div>
    </div>

    <script src="../scripts/commonScript.js"></script>
    <script src="../scripts/productScript.js"></script>
</body>
</html>
