let editingTipoId = null;

function loadTipos() {
    fetch("../produto_tipo_listar.php")
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById("tiposContainer");
            if (!data.success || !data.tipos.length) {
                container.innerHTML = '<div class="empty-state">Nenhum tipo de produto cadastrado.</div>';
                return;
            }
            let html = '<table><thead><tr><th>ID</th><th>Descrição</th><th>Ações</th></tr></thead><tbody>';
            for (const t of data.tipos) {
                html += `<tr>
                    <td>${t.material_tipo_id}</td>
                    <td>${escapeHtml(t.descricao)}</td>
                    <td>
                        <div class="table-actions">
                            <button class="btn-table btn-table-edit" onclick="editTipo(${t.material_tipo_id}, '${escapeHtml(t.descricao)}')">Editar</button>
                            <button class="btn-table btn-table-delete" onclick="deleteTipo(${t.material_tipo_id})">Excluir</button>
                        </div>
                    </td>
                </tr>`;
            }
            html += '</tbody></table>';
            container.innerHTML = html;
        })
        .catch(() => alert("Erro ao carregar tipos de produto."));
}

function openCreateModal() {
    editingTipoId = null;
    document.getElementById("tipoModalTitle").textContent = "Adicionar Tipo de Produto";
    document.getElementById("tipoModalBtn").textContent = "Salvar";
    document.getElementById("editTipoId").value = "";
    document.getElementById("tipoDescricao").value = "";
    document.getElementById("tipoModal").classList.add("show");
}

function editTipo(id, descricao) {
    editingTipoId = id;
    document.getElementById("tipoModalTitle").textContent = "Editar Tipo de Produto";
    document.getElementById("tipoModalBtn").textContent = "Atualizar";
    document.getElementById("editTipoId").value = id;
    document.getElementById("tipoDescricao").value = descricao;
    document.getElementById("tipoModal").classList.add("show");
}

function closeTipoModal() {
    document.getElementById("tipoModal").classList.remove("show");
    document.getElementById("tipoForm").reset();
}

function saveTipo(e) {
    e.preventDefault();
    const descricao = document.getElementById("tipoDescricao").value.trim();
    if (!descricao) { alert("Informe a descrição."); return; }

    const formData = new FormData();
    formData.append("descricao", descricao);

    const url = editingTipoId ? "../produto_tipo_editar.php" : "../produto_tipo_incluir.php";
    if (editingTipoId) formData.append("id", editingTipoId);

    fetch(url, { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeTipoModal();
                loadTipos();
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert("Erro ao conectar com o servidor."));
}

function deleteTipo(id) {
    if (!confirm("Tem certeza que deseja excluir este tipo de produto?")) return;
    const formData = new FormData();
    formData.append("id", id);
    fetch("../produto_tipo_excluir.php", { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                loadTipos();
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert("Erro ao conectar com o servidor."));
}

function initProductTypePage() {
    const user = checkLogin();
    if (!user) return;
    if (user.cargo !== "Gestor de Produto") {
        alert("Acesso restrito a Gestores de Produto.");
        window.location.replace("../index.php");
        return;
    }
    showUserGreeting();
    loadTipos();

    document.getElementById("tipoForm").addEventListener("submit", saveTipo);
    setupOverlayClickHandler("tipoModal");
}

document.addEventListener("DOMContentLoaded", initProductTypePage);
