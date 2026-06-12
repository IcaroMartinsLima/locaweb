function initPanelPage() {
    const user = checkLogin();
    if (!user) return;

    if (user.cargo === "Cliente") {
        alert("Acesso restrito a Atendentes e Gestores.");
        window.location.replace("../index.php");
        return;
    }

    showUserGreeting();
    loadAllFeedbacks();
}

function loadAllFeedbacks() {
    fetch("../feedback_listar_todos.php")
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("feedbacksBody");
            const emptyEl = document.getElementById("emptyFeedbacks");

            if (!data.success || !data.feedbacks.length) {
                if (emptyEl) emptyEl.style.display = "block";
                if (tbody) tbody.innerHTML = "";
                return;
            }

            if (emptyEl) emptyEl.style.display = "none";

            let html = "";
            for (const f of data.feedbacks) {
                const stars = "★".repeat(parseInt(f.nota)) + "☆".repeat(5 - parseInt(f.nota));
                html += `
                    <tr>
                        <td>${escapeHtml(f.produto_nome)}</td>
                        <td>${escapeHtml(f.avaliador_nome || "-")}</td>
                        <td>${stars}</td>
                        <td>${escapeHtml(f.observacao)}</td>
                        <td>${f.datahora ? formatDateTime(f.datahora) : "-"}</td>
                    </tr>
                `;
            }
            tbody.innerHTML = html;
        })
        .catch(() => alert("Erro ao carregar avaliações."));
}

document.addEventListener("DOMContentLoaded", initPanelPage);
