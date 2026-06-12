/* ===== INDICATORS FUNCTIONS ===== */

function renderIndicators() {
    Promise.all([
        fetch("../produto_gestor_listar.php").then(r => r.json()),
        fetch("../feedback_listar_todos.php").then(r => r.json())
    ])
    .then(([prodData, fbData]) => {
        const produtos = prodData.produtos || [];
        const feedbacks = fbData.feedbacks || [];

        document.getElementById("totalProducts").textContent = produtos.length;
        document.getElementById("totalRatings").textContent = feedbacks.length;

        const productRatings = {};
        for (const fb of feedbacks) {
            const pid = fb.produto_id;
            if (!productRatings[pid]) productRatings[pid] = [];
            productRatings[pid].push(parseInt(fb.nota));
        }

        let totalSum = 0, totalCount = 0;
        for (const pid in productRatings) {
            totalSum += productRatings[pid].reduce((a, b) => a + b, 0);
            totalCount += productRatings[pid].length;
        }

        const avg = totalCount > 0 ? (totalSum / totalCount).toFixed(1) : null;
        document.getElementById("avgRating").textContent = avg ? avg + " ⭐" : "N/A";

        let bestPid = null, worstPid = null, mostPid = null;
        let bestAvg = -1, worstAvg = 6, mostCount = 0;

        for (const pid in productRatings) {
            const arr = productRatings[pid];
            const pAvg = arr.reduce((a, b) => a + b, 0) / arr.length;
            if (pAvg > bestAvg) { bestAvg = pAvg; bestPid = pid; }
            if (pAvg < worstAvg) { worstAvg = pAvg; worstPid = pid; }
            if (arr.length > mostCount) { mostCount = arr.length; mostPid = pid; }
        }

        const getProdName = (pid) => {
            const p = produtos.find(x => String(x.produto_id) === String(pid));
            return p ? p.nome : null;
        };

        const bestName = getProdName(bestPid);
        const worstName = getProdName(worstPid);
        const mostName = getProdName(mostPid);

        document.getElementById("bestRated").textContent = bestName ? bestName + " (" + bestAvg.toFixed(1) + ")" : "-";
        document.getElementById("worstRated").textContent = worstName ? worstName + " (" + worstAvg.toFixed(1) + ")" : "-";
        document.getElementById("mostReviews").textContent = mostName ? mostName + " (" + mostCount + ")" : "-";

        renderRecentTable(feedbacks, produtos);
    })
    .catch(() => {
        document.getElementById("totalProducts").textContent = "Erro";
        document.getElementById("totalRatings").textContent = "Erro";
        document.getElementById("avgRating").textContent = "Erro";
    });
}

function renderRecentTable(feedbacks, produtos) {
    const tbody = document.getElementById("ratingsBody");
    if (feedbacks.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #666;">Nenhuma avaliação ainda</td></tr>';
        return;
    }

    const sorted = [...feedbacks].sort((a, b) => new Date(b.datahora) - new Date(a.datahora)).slice(0, 10);

    let html = "";
    for (const fb of sorted) {
        html += `
            <tr>
                <td>${escapeHtml(fb.produto_nome)}</td>
                <td>${escapeHtml(fb.avaliador_nome || "-")}</td>
                <td>${parseInt(fb.nota)} ⭐</td>
                <td>${escapeHtml((fb.observacao || "").substring(0, 50))}${fb.observacao && fb.observacao.length > 50 ? '...' : ''}</td>
                <td>${formatDateTime(fb.datahora)}</td>
            </tr>
        `;
    }

    tbody.innerHTML = html;
}

function initIndicatorsPage() {
    const user = checkLogin();
    if (!user) return;

    if (user.cargo !== "Gestor de Produto") {
        alert("Acesso restrito. Apenas Gestores podem acessar os Indicadores.");
        window.location.replace("../index.php");
        return;
    }

    showUserGreeting();
    renderIndicators();
}

document.addEventListener("DOMContentLoaded", initIndicatorsPage);
