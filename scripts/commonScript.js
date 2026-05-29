/* ===== COMMON FUNCTIONS ===== */

/**
 * Recupera o usuário atual da sessão
 */
function getCurrentUser() {
    const raw = localStorage.getItem("currentUser");
    return raw ? JSON.parse(raw) : null;
}

/**
 * Recupera todos os usuários
 */
function getUsers() {
    const raw = localStorage.getItem("users");
    if (!raw) return [];
    try {
        const parsed = JSON.parse(raw);
        return Array.isArray(parsed) ? parsed : [];
    } catch (err) {
        return [];
    }
}

/**
 * Salva usuários no localStorage
 */
function saveUsers(arr) {
    localStorage.setItem("users", JSON.stringify(arr));
}

/**
 * Recupera todos os produtos
 */
function getProducts() {
    const raw = localStorage.getItem("products");
    if (!raw) return [];
    try {
        const parsed = JSON.parse(raw);
        return Array.isArray(parsed) ? parsed : [];
    } catch (err) {
        return [];
    }
}

/**
 * Salva produtos no localStorage
 */
function saveProducts(arr) {
    localStorage.setItem("products", JSON.stringify(arr));
}

/**
 * Recupera todas as avaliações
 */
function getRatings() {
    const raw = localStorage.getItem("ratings");
    if (!raw) return [];
    try {
        const parsed = JSON.parse(raw);
        return Array.isArray(parsed) ? parsed : [];
    } catch (err) {
        return [];
    }
}

/**
 * Salva avaliações no localStorage
 */
function saveRatings(arr) {
    localStorage.setItem("ratings", JSON.stringify(arr));
}

/**
 * Escapa HTML para evitar XSS
 */
function escapeHtml(str) {
    return str
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#39;");
}

/**
 * Formata data para formato brasileiro
 */
function formatDate(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('pt-BR');
}

/**
 * Formata data e hora para formato brasileiro
 */
function formatDateTime(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('pt-BR') + " " + date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
}

/**
 * Verifica login e redireciona se necessário
 */
function checkLogin() {
    const user = getCurrentUser();
    if (!user) {
        alert("Você precisa estar logado para acessar esta página.");
        window.location.replace("index.html");
        return null;
    }
    return user;
}

/**
 * Faz logout do usuário
 */
function logout() {
    localStorage.removeItem("currentUser");
    window.location.replace("index.html");
}

/**
 * Mostra saudação do usuário no header
 */
function showUserGreeting() {
    const user = getCurrentUser();
    const greetingElement = document.getElementById("userGreeting");
    if (greetingElement && user) {
        greetingElement.textContent = "Olá, " + user.name + "!";
    }
}

/**
 * Fecha overlay ao clicar fora
 */
function setupOverlayClickHandler(overlayId) {
    const overlay = document.getElementById(overlayId);
    if (overlay) {
        overlay.addEventListener("click", (e) => {
            if (e.target === overlay) {
                overlay.classList.remove("show");
            }
        });
    }
}
