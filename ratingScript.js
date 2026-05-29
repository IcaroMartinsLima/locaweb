/* ===== RATING FUNCTIONS ===== */

let selectedProductId = null;

/**
 * Calcula a média de avaliação de um produto
 */
function calculateAverageRating(productId) {
    const ratings = getRatings();
    const productRatings = ratings.filter(r => r.productId === productId);
    
    if (productRatings.length === 0) return 0;
    const sum = productRatings.reduce((acc, r) => acc + parseInt(r.rating), 0);
    return (sum / productRatings.length).toFixed(1);
}

/**
 * Recupera avaliações de um produto
 */
function getProductRatings(productId) {
    const ratings = getRatings();
    return ratings.filter(r => r.productId === productId);
}

/**
 * Renderiza todos os produtos com estatísticas de avaliações
 */
function renderProducts() {
    const products = getProducts();
    const container = document.getElementById("ratingsContainer");

    if (!container) return;

    if (products.length === 0) {
        container.innerHTML = '<div class="empty-state">Nenhum produto cadastrado ainda.</div>';
        return;
    }

    let html = "";
    for (const product of products) {
        const ratings = getProductRatings(product.id);
        const avgRating = calculateAverageRating(product.id);

        html += `
            <div class="product-rating-card">
                <h3>${escapeHtml(product.name)}</h3>
                <div class="category">${escapeHtml(product.category)}</div>
                
                <div class="rating-stats">
                    <div class="rating-stats-item">
                        <span>Avaliações:</span>
                        <span class="value">${ratings.length}</span>
                    </div>
                    <div class="rating-stats-item">
                        <span>Nota Média:</span>
                        <span class="value">${avgRating} ⭐</span>
                    </div>
                    <div class="rating-stats-item">
                        <span>Preço:</span>
                        <span class="value">R$ ${parseFloat(product.price).toFixed(2)}</span>
                    </div>
                </div>

                <button class="rate-button" onclick="openRatingForm('${product.id}', '${escapeHtml(product.name)}')">
                    Deixar Avaliação
                </button>
            </div>
        `;
    }

    container.innerHTML = html;
}

/**
 * Abre modal para adicionar avaliação
 */
function openRatingForm(productId, productName) {
    selectedProductId = productId;
    document.getElementById("productNameDisplay").textContent = productName;
    document.getElementById("overlay").classList.add("show");
}

/**
 * Adiciona nova avaliação
 */
function addRating() {
    const rating = document.querySelector('input[name="rate"]:checked')?.value || 3;
    const comentario = document.getElementById("comentario").value.trim();

    if (!comentario) {
        alert("Escreva um comentário.");
        return;
    }

    if (!selectedProductId) {
        alert("Erro: Nenhum produto selecionado.");
        return;
    }

    const ratings = getRatings();
    const user = getCurrentUser();

    const newRating = {
        id: Date.now().toString(),
        productId: selectedProductId,
        userId: user.id,
        userName: user.name,
        rating: rating,
        comment: comentario,
        createdAt: new Date().toISOString()
    };

    ratings.push(newRating);
    saveRatings(ratings);

    document.getElementById("ratingForm").reset();
    document.getElementById("overlay").classList.remove("show");
    renderProducts();
}

/**
 * Inicializa página de avaliações
 */
function initRatingsPage() {
    checkLogin();
    showUserGreeting();
    renderProducts();

    const overlay = document.getElementById("overlay");
    const form = document.getElementById("ratingForm");
    const closeBtn = document.getElementById("closeModal");

    if (form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            addRating();
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            form.reset();
            overlay.classList.remove("show");
        });
    }

    setupOverlayClickHandler("overlay");
}

document.addEventListener("DOMContentLoaded", initRatingsPage);
