/* ===== DASHBOARD FUNCTIONS ===== */

/**
 * Inicializa página de dashboard (index)
 */
function initDashboardPage() {
    const user = getCurrentUser();
    const authButtons = document.getElementById("authButtons");
    const userSection = document.getElementById("userSection");
    const navSection = document.getElementById("navSection");
    const welcomeSection = document.getElementById("welcomeSection");
    const loggedWelcome = document.getElementById("loggedWelcome");

    if (user) {
        if (authButtons) authButtons.style.display = "none";
        if (userSection) userSection.style.display = "flex";
        if (navSection) navSection.style.display = "grid";
        if (welcomeSection) welcomeSection.style.display = "none";
        if (loggedWelcome) loggedWelcome.style.display = "block";

        document.getElementById("userGreeting").textContent = user.name;
        document.getElementById("welcomeName").textContent = user.name;

        const isGestor = user.cargo === "Gestor de Produto";
        const isAtendente = user.cargo === "Atendente";
        const gestorCards = document.querySelectorAll(".gestor-card");
        const panelCards = document.querySelectorAll(".panel-card");

        gestorCards.forEach(c => c.style.display = isGestor ? "flex" : "none");
        panelCards.forEach(c => c.style.display = (isAtendente || isGestor) ? "flex" : "none");

        if (navSection) {
            navSection.classList.toggle("cols-3", isGestor && !isAtendente);
        }
    } else {
        if (authButtons) authButtons.style.display = "flex";
        if (userSection) userSection.style.display = "none";
        if (navSection) navSection.style.display = "none";
        if (welcomeSection) welcomeSection.style.display = "block";
        if (loggedWelcome) loggedWelcome.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", initDashboardPage);
