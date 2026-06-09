let editingProdutoId = null;

function loadTiposSelect(selectId, selectedId) {
    fetch("../produto_tipo_listar.php")
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Selecione o tipo</option>';
            if (data.success) {
                for (const t of data.tipos) {
                    const opt = document.createElement("option");
                    opt.value = t.material_tipo_id;
                    opt.textContent = t.descricao;
                    if (selectedId && String(t.material_tipo_id) === String(selectedId)) opt.selected = true;
                    select.appendChild(opt);
                }
            }
        })
        .catch(() => alert("Erro ao carregar tipos de produto."));
}

function loadProdutos() {
    fetch("../produto_gestor_listar.php")
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById("produtosContainer");
            if (!data.success || !data.produtos.length) {
                container.innerHTML = '<div class="empty-state">Nenhum produto cadastrado.</div>';
                return;
            }
            let html = '<table><thead><tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Tipo</th><th>Ações</th></tr></thead><tbody>';
            for (const p of data.produtos) {
                html += `<tr>
                    <td>${p.produto_id}</td>
                    <td>${escapeHtml(p.nome)}</td>
                    <td>${escapeHtml(p.descricao)}</td>
                    <td>${escapeHtml(p.tipo_descricao || "-")}</td>
                    <td>
                        <div class="table-actions">
                            <button class="btn-table btn-table-edit" onclick='editProduto(${p.produto_id}, "${escapeHtml(p.nome)}", "${escapeHtml(p.descricao)}", ${p.produto_tipo_id})'>Editar</button>
                            <button class="btn-table btn-table-delete" onclick="deleteProduto(${p.produto_id})">Excluir</button>
                        </div>
                    </td>
                </tr>`;
            }
            html += '</tbody></table>';
            container.innerHTML = html;
        })
        .catch(() => alert("Erro ao carregar produtos."));
}

function openCreateModal() {
    editingProdutoId = null;
    document.getElementById("produtoModalTitle").textContent = "Adicionar Produto";
    document.getElementById("produtoModalBtn").textContent = "Salvar";
    document.getElementById("editProdutoId").value = "";
    document.getElementById("produtoNome").value = "";
    document.getElementById("produtoDescricao").value = "";
    loadTiposSelect("produtoTipoId");
    document.getElementById("produtoModal").classList.add("show");
}

function editProduto(id, nome, descricao, tipoId) {
    editingProdutoId = id;
    document.getElementById("produtoModalTitle").textContent = "Editar Produto";
    document.getElementById("produtoModalBtn").textContent = "Atualizar";
    document.getElementById("editProdutoId").value = id;
    document.getElementById("produtoNome").value = nome;
    document.getElementById("produtoDescricao").value = descricao;
    loadTiposSelect("produtoTipoId", tipoId);
    document.getElementById("produtoModal").classList.add("show");
}

function closeProdutoModal() {
    document.getElementById("produtoModal").classList.remove("show");
    document.getElementById("produtoForm").reset();
}

function saveProduto(e) {
    e.preventDefault();
    const nome = document.getElementById("produtoNome").value.trim();
    const descricao = document.getElementById("produtoDescricao").value.trim();
    const produto_tipo_id = document.getElementById("produtoTipoId").value;
    if (!nome) { alert("Preencha o nome do produto."); return; }
    if (!descricao) { alert("Preencha a descrição do produto."); return; }
    if (!produto_tipo_id) { alert("Selecione o tipo do produto."); return; }

    const user = getCurrentUser();
    if (!user) { alert("Usuário não autenticado."); return; }

    const params = new URLSearchParams();
    params.append("nome", nome);
    params.append("descricao", descricao);
    params.append("produto_tipo_id", produto_tipo_id);

    params.append("atualizado_por", user.id);

    if (editingProdutoId) {
        params.append("id", editingProdutoId);
    }

    const url = editingProdutoId ? "../produto_gestor_editar.php" : "../produto_gestor_incluir.php";
    fetch(url, { method: "POST", body: params })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeProdutoModal();
                loadProdutos();
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert("Erro ao conectar com o servidor."));
}

function deleteProduto(id) {
    if (!confirm("Tem certeza que deseja excluir este produto?")) return;
    const formData = new FormData();
    formData.append("id", id);
    fetch("../produto_gestor_excluir.php", { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                loadProdutos();
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert("Erro ao conectar com o servidor."));
}

function initGestorProductPage() {
    const user = checkLogin();
    if (!user) return;
    if (user.cargo !== "Gestor de Produto") {
        alert("Acesso restrito a Gestores de Produto.");
        window.location.replace("../index.php");
        return;
    }
    showUserGreeting();
    loadProdutos();

    document.getElementById("produtoForm").addEventListener("submit", saveProduto);
    setupOverlayClickHandler("produtoModal");
}

document.addEventListener("DOMContentLoaded", initGestorProductPage);
