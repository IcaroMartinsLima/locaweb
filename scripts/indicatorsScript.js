/* ===== INDICATORS FUNCTIONS ===== */

/**
 * Renderiza todos os indicadores
 */
function renderIndicators() {
    const products = getProducts();
    const ratings = getRatings();

    // Total de produtos
    document.getElementById("totalProducts").textContent = products.length;

    // Total de avaliações
    document.getElementById("totalRatings").textContent = ratings.length;

    // Avaliação média geral
    if (ratings.length > 0) {
        const avgRating = (ratings.reduce((acc, r) => acc + parseInt(r.rating), 0) / ratings.length).toFixed(1);
        document.getElementById("avgRating").textContent = avgRating + " ⭐";
    } else {
        document.getElementById("avgRating").textContent = "N/A";
    }

    // Maior e menor preço
    if (products.length > 0) {
        const prices = products.map(p => parseFloat(p.price));
        const maxPrice = Math.max(...prices);
        const minPrice = Math.min(...prices);
        document.getElementById("maxPrice").textContent = "R$ " + maxPrice.toFixed(2);
        document.getElementById("minPrice").textContent = "R$ " + minPrice.toFixed(2);
    } else {
        document.getElementById("maxPrice").textContent = "-";
        document.getElementById("minPrice").textContent = "-";
    }

    // Produto mais avaliado
    if (products.length > 0) {
        let maxRatings = 0;
        for (const product of products) {
            const productRatings = ratings.filter(r => r.productId === product.id);
            maxRatings = Math.max(maxRatings, productRatings.length);
        }
        document.getElementById("mostRated").textContent = maxRatings;
    }

    // Renderizar tabela de avaliações recentes
    const tbody = document.getElementById("ratingsBody");
    if (ratings.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #666;">Nenhuma avaliação ainda</td></tr>';
        return;
    }

    // Ordena por data (mais recentes primeiro)
    const sortedRatings = [...ratings].sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt)).slice(0, 10);

    let html = "";
    for (const rating of sortedRatings) {
        const product = products.find(p => p.id === rating.productId);
        const productName = product ? escapeHtml(product.name) : "Produto deletado";

        html += `
            <tr>
                <td>${productName}</td>
                <td>${escapeHtml(rating.userName)}</td>
                <td>${rating.rating} ⭐</td>
                <td>${escapeHtml(rating.comment.substring(0, 50))}${rating.comment.length > 50 ? '...' : ''}</td>
                <td>${formatDateTime(rating.createdAt)}</td>
            </tr>
        `;
    }

    tbody.innerHTML = html;
}

/**
 * Inicializa página de indicadores
 */
function initIndicatorsPage() {
    checkLogin();
    showUserGreeting();
    renderIndicators();
}

document.addEventListener("DOMContentLoaded", initIndicatorsPage);
