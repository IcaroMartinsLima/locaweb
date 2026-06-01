<?php $pageTitle = "Minha Conta"; include "../header.php"; ?>

    <div class="content-container">
        <div class="account-section">
            <h2>Informações Pessoais</h2>
            <div class="account-info">
                <div class="info-item">
                    <label>Nome:</label>
                    <span class="value" id="userName"></span>
                </div>
                <div class="info-item">
                    <label>Email:</label>
                    <span class="value" id="userEmail"></span>
                </div>
                <div class="info-item">
                    <label>Cargo:</label>
                    <span class="value" id="userCargo"></span>
                </div>
                <div class="info-item">
                    <label>Data de Cadastro:</label>
                    <span class="value" id="createdAt"></span>
                </div>
            </div>
        </div>

        <div class="account-section">
            <h2>Minhas Estatísticas</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="label">Produtos Cadastrados</span>
                    <span class="value" id="userProducts">0</span>
                </div>
                <div class="stat-item">
                    <span class="label">Avaliações Feitas</span>
                    <span class="value" id="userRatings">0</span>
                </div>
            </div>
        </div>

        <div class="account-section">
            <h2>Editar Informações</h2>
            <div class="section-buttons">
                <button class="btn-primary" onclick="openEditModal()">Editar Nome, Email ou Senha</button>
            </div>
        </div>

        <div class="account-section danger-zone">
            <h2>Zona de Perigo</h2>
            <div class="danger-zone-warning">
                <span>Esta ação não pode ser desfeita. Sua conta e todos os dados serão permanentemente deletados.</span>
            </div>
            <div class="section-buttons">
                <button class="btn-danger" onclick="deleteAccount()">Deletar Minha Conta</button>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="editModal">
        <div class="modal-content">
            <h3>Editar Informações</h3>
            <input type="text" class="modal-input" id="editName" placeholder="Nome">
            <input type="email" class="modal-input" id="editEmail" placeholder="Email">
            <select class="modal-input" id="editCargo">
                <option value="">Selecione seu cargo</option>
                <option value="Cliente">Cliente</option>
                <option value="Atendente">Atendente</option>
                <option value="Gestor de Produto">Gestor de Produto</option>
            </select>
            <input type="password" class="modal-input" id="editCurrentPassword" placeholder="Senha Atual (obrigatório)" required>
            <input type="password" class="modal-input" id="editNewPassword" placeholder="Nova Senha (deixe em branco para manter)">
            <input type="password" class="modal-input" id="editConfirmPassword" placeholder="Confirmar Nova Senha">
            <div class="modal-buttons">
                <button onclick="updateUser()">Salvar</button>
                <button onclick="closeEditModal()">Cancelar</button>
            </div>
        </div>
    </div>

    <script src="../scripts/commonScript.js"></script>
    <script src="../scripts/accountScript.js"></script>
</body>
</html>
