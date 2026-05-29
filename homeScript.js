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

        document.getElementById("userName").textContent = user.name;
        document.getElementById("welcomeName").textContent = user.name;
    } else {
        if (authButtons) authButtons.style.display = "flex";
        if (userSection) userSection.style.display = "none";
        if (navSection) navSection.style.display = "none";
        if (welcomeSection) welcomeSection.style.display = "block";
        if (loggedWelcome) loggedWelcome.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", initDashboardPage);
