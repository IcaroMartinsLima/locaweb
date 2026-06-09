let clienteId = null;
let selectedProdutoId = null;

function getCurrentUserId() {
    const user = getCurrentUser();
    return user ? user.id : null;
}

function getCurrentUserName() {
    const user = getCurrentUser();
    return user ? user.name : "";
}

function checkPessoa() {
    const usuarioId = getCurrentUserId();
    if (!usuarioId) return;

    const params = new URLSearchParams();
    params.append("usuario_id", usuarioId);

    fetch("../pessoa_verificar.php", {
        method: "POST",
        body: params
    })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.existe) {
                clienteId = data.pessoa.pessoa_id;
                document.getElementById("pessoaWarning").style.display = "none";
                loadProdutos();
                loadFeedbacks();
            } else {
                document.getElementById("pessoaWarning").style.display = "block";
                document.getElementById("ratingsContainer").innerHTML = "";
                document.getElementById("myFeedbacksContainer").innerHTML = '<div class="empty-state">Nenhuma avaliação encontrada.</div>';
            }
        })
        .catch(() => alert("Erro ao verificar dados do cliente."));
}

function openPessoaModal() {
    const user = getCurrentUser();
    if (user && user.name) {
        document.getElementById("pessoaNome").value = user.name;
    }
    document.getElementById("pessoaOverlay").classList.add("show");
}

function closePessoaModal() {
    document.getElementById("pessoaOverlay").classList.remove("show");
    document.getElementById("pessoaForm").reset();
}

function savePessoa(e) {
    e.preventDefault();

    const nome = document.getElementById("pessoaNome").value.trim();
    const cpf = document.getElementById("pessoaCpf").value.trim();
    const nascimento = document.getElementById("pessoaNascimento").value;
    const telefone = document.getElementById("pessoaTelefone").value.trim();
    const usuarioId = getCurrentUserId();

    if (!nome || !cpf || !nascimento || !telefone) {
        alert("Preencha todos os campos.");
        return;
    }

    const params = new URLSearchParams();
    params.append("usuario_id", usuarioId);
    params.append("nome", nome);
    params.append("cpf", cpf);
    params.append("nascimento", nascimento);
    params.append("telefone", telefone);

    fetch("../pessoa_incluir.php", {
        method: "POST",
        body: params
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                clienteId = data.pessoa_id;
                closePessoaModal();
                document.getElementById("pessoaWarning").style.display = "none";
                loadProdutos();
                loadFeedbacks();
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert("Erro ao cadastrar dados pessoais."));
}

function loadProdutos() {
    fetch("../produto_gestor_listar.php")
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById("ratingsContainer");
            if (!data.success || !data.produtos.length) {
                container.innerHTML = '<div class="empty-state">Nenhum produto disponível para avaliação.</div>';
                return;
            }

            let html = "";
            for (const p of data.produtos) {
                html += `
                    <div class="product-rating-card">
                        <h3>${escapeHtml(p.nome)}</h3>
                        <div class="category">${escapeHtml(p.tipo_descricao || "-")}</div>
                        <div class="description">${escapeHtml(p.descricao)}</div>
                        <button class="rate-button" onclick="openRatingForm(${p.produto_id}, '${escapeHtml(p.nome)}')">
                            Avaliar
                        </button>
                    </div>
                `;
            }
            container.innerHTML = html;
        })
        .catch(() => alert("Erro ao carregar produtos."));
}

function loadFeedbacks() {
    if (!clienteId) return;

    fetch("../feedback_listar.php?cliente_id=" + clienteId)
        .then(res => res.json())
        .then(data => {
            const emptyEl = document.getElementById("emptyFeedbacks");
            const table = document.getElementById("feedbacksTable");
            const tbody = document.getElementById("feedbacksBody");

            if (!data.success || !data.feedbacks.length) {
                if (emptyEl) emptyEl.style.display = "block";
                if (table) table.style.display = "none";
                return;
            }

            if (emptyEl) emptyEl.style.display = "none";
            if (table) table.style.display = "";

            let html = "";
            for (const f of data.feedbacks) {
                const stars = "★".repeat(parseInt(f.nota)) + "☆".repeat(5 - parseInt(f.nota));
                html += `
                    <tr>
                        <td>${escapeHtml(f.produto_nome)}</td>
                        <td>${stars}</td>
                        <td>${escapeHtml(f.observacao)}</td>
                        <td>${f.datahora || "-"}</td>
                        <td>
                            <div class="table-actions">
                                <button class="btn-table btn-table-delete" onclick="deleteFeedback(${f.feedback_id})">Excluir</button>
                            </div>
                        </td>
                    </tr>
                `;
            }
            tbody.innerHTML = html;
        })
        .catch(() => alert("Erro ao carregar avaliações."));
}

function openRatingForm(produtoId, produtoNome) {
    selectedProdutoId = produtoId;
    document.getElementById("productNameDisplay").textContent = produtoNome;
    document.getElementById("ratingOverlay").classList.add("show");
}

function closeRatingModal() {
    document.getElementById("ratingOverlay").classList.remove("show");
    document.getElementById("ratingForm").reset();
}

function saveFeedback(e) {
    e.preventDefault();

    const nota = document.querySelector('input[name="rate"]:checked')?.value;
    const observacao = document.getElementById("comentario").value.trim();
    const usuarioId = getCurrentUserId();

    if (!nota) { alert("Selecione uma nota."); return; }
    if (!observacao) { alert("Escreva um comentário."); return; }
    if (!selectedProdutoId) { alert("Nenhum produto selecionado."); return; }
    if (!clienteId) { alert("Cliente não identificado."); return; }

    const params = new URLSearchParams();
    params.append("cliente_id", clienteId);
    params.append("produto_id", selectedProdutoId);
    params.append("nota", nota);
    params.append("observacao", observacao);
    params.append("atualizado_por", usuarioId);

    fetch("../feedback_incluir.php", {
        method: "POST",
        body: params
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeRatingModal();
                loadFeedbacks();
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert("Erro ao conectar com o servidor."));
}

function deleteFeedback(feedbackId) {
    if (!confirm("Tem certeza que deseja excluir esta avaliação?")) return;
    if (!clienteId) return;

    const params = new URLSearchParams();
    params.append("feedback_id", feedbackId);
    params.append("cliente_id", clienteId);

    fetch("../feedback_excluir.php", {
        method: "POST",
        body: params
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                loadFeedbacks();
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert("Erro ao conectar com o servidor."));
}

function initRatingsPage() {
    const user = checkLogin();
    if (!user) return;

    showUserGreeting();
    checkPessoa();

    document.getElementById("ratingForm").addEventListener("submit", saveFeedback);
    document.getElementById("pessoaForm").addEventListener("submit", savePessoa);

    setupOverlayClickHandler("ratingOverlay");
    setupOverlayClickHandler("pessoaOverlay");
}

document.addEventListener("DOMContentLoaded", initRatingsPage);
