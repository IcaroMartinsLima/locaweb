let allFeedbacks = [];
let allProducts = [];
let ratingChartInstance = null;
let productChartInstance = null;

function initPanelPage() {
    const user = checkLogin();
    if (!user) return;

    if (user.cargo !== "Atendente") {
        alert("Acesso restrito. Apenas Atendentes podem acessar o Painel de Avaliações.");
        window.location.replace("../index.php");
        return;
    }

    showUserGreeting();
    loadData();
}

function loadData() {
    Promise.all([
        fetch("../feedback_listar_todos.php").then(r => r.json()),
        fetch("../produto_gestor_listar.php").then(r => r.json())
    ])
    .then(([fbData, prodData]) => {
        allFeedbacks = fbData.feedbacks || [];
        allProducts = prodData.produtos || [];
        renderStats();
        renderCharts();
        populateFilters();
        renderTable(allFeedbacks);
    })
    .catch(() => alert("Erro ao carregar dados."));
}

function renderStats() {
    document.getElementById("panelTotalRatings").textContent = allFeedbacks.length;

    let sum = 0;
    for (const fb of allFeedbacks) sum += parseInt(fb.nota);
    const avg = allFeedbacks.length > 0 ? (sum / allFeedbacks.length).toFixed(1) : null;
    document.getElementById("panelAvgRating").textContent = avg ? avg + " ⭐" : "N/A";

    const uniqueProducts = new Set(allFeedbacks.map(fb => fb.produto_id));
    document.getElementById("panelTotalProducts").textContent = uniqueProducts.size;

    const productRatings = {};
    for (const fb of allFeedbacks) {
        const pid = fb.produto_id;
        if (!productRatings[pid]) productRatings[pid] = [];
        productRatings[pid].push(parseInt(fb.nota));
    }

    let bestPid = null, bestAvg = -1;
    for (const pid in productRatings) {
        const arr = productRatings[pid];
        const pAvg = arr.reduce((a, b) => a + b, 0) / arr.length;
        if (pAvg > bestAvg) { bestAvg = pAvg; bestPid = pid; }
    }

    const bestProd = allProducts.find(p => String(p.produto_id) === String(bestPid));
    document.getElementById("panelBestProduct").textContent = bestProd ? bestProd.nome + " (" + bestAvg.toFixed(1) + ")" : "-";
}

function renderCharts() {
    const counts = [0, 0, 0, 0, 0];
    for (const fb of allFeedbacks) {
        const nota = parseInt(fb.nota);
        if (nota >= 1 && nota <= 5) counts[nota - 1]++;
    }

    const ctx1 = document.getElementById("ratingDistChart").getContext("2d");
    if (ratingChartInstance) ratingChartInstance.destroy();
    ratingChartInstance = new Chart(ctx1, {
        type: "bar",
        data: {
            labels: ["1 ⭐", "2 ⭐", "3 ⭐", "4 ⭐", "5 ⭐"],
            datasets: [{
                label: "Avaliações",
                data: counts,
                backgroundColor: ["#ef4444", "#f97316", "#eab308", "#22c55e", "#16a34a"]
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
            }
        }
    });

    const productCounts = {};
    for (const fb of allFeedbacks) {
        const pid = fb.produto_id;
        if (!productCounts[pid]) productCounts[pid] = 0;
        productCounts[pid]++;
    }

    const sorted = Object.entries(productCounts)
        .sort((a, b) => b[1] - a[1])
        .slice(0, 10);

    const labels = sorted.map(([pid]) => {
        const p = allProducts.find(x => String(x.produto_id) === pid);
        return p ? p.nome : "Deletado";
    });
    const data = sorted.map(([, count]) => count);

    const ctx2 = document.getElementById("productChart").getContext("2d");
    if (productChartInstance) productChartInstance.destroy();
    productChartInstance = new Chart(ctx2, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [{
                label: "Avaliações",
                data: data,
                backgroundColor: "#6366f1"
            }]
        },
        options: {
            indexAxis: "y",
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
            }
        }
    });
}

function populateFilters() {
    const productFilter = document.getElementById("filterProduct");

    const added = new Set();
    for (const fb of allFeedbacks) {
        if (!added.has(fb.produto_id)) {
            added.add(fb.produto_id);
            const option = document.createElement("option");
            option.value = fb.produto_id;
            option.textContent = fb.produto_nome;
            productFilter.appendChild(option);
        }
    }

    productFilter.addEventListener("change", applyFilters);
    document.getElementById("filterRating").addEventListener("change", applyFilters);
}

function applyFilters() {
    const productId = document.getElementById("filterProduct").value;
    const rating = document.getElementById("filterRating").value;

    let filtered = [...allFeedbacks];

    if (productId) {
        filtered = filtered.filter(fb => String(fb.produto_id) === productId);
    }

    if (rating) {
        filtered = filtered.filter(fb => parseInt(fb.nota) === parseInt(rating));
    }

    renderTable(filtered);
}

function renderTable(feedbacks) {
    const tbody = document.getElementById("feedbacksBody");
    const emptyEl = document.getElementById("emptyFeedbacks");
    const table = document.getElementById("feedbacksTable");

    if (feedbacks.length === 0) {
        if (emptyEl) emptyEl.style.display = "block";
        if (tbody) tbody.innerHTML = "";
        return;
    }

    if (emptyEl) emptyEl.style.display = "none";

    let html = "";
    for (const fb of feedbacks) {
        const stars = "★".repeat(parseInt(fb.nota)) + "☆".repeat(5 - parseInt(fb.nota));
        html += `
            <tr>
                <td>${escapeHtml(fb.produto_nome)}</td>
                <td>${escapeHtml(fb.avaliador_nome || "-")}</td>
                <td>${stars}</td>
                <td>${escapeHtml(fb.observacao)}</td>
                <td>${fb.datahora ? formatDateTime(fb.datahora) : "-"}</td>
            </tr>
        `;
    }
    tbody.innerHTML = html;
}

document.addEventListener("DOMContentLoaded", initPanelPage);
