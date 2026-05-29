/* ===== ACCOUNT FUNCTIONS ===== */

/**
 * Carrega informações do usuário
 */
function loadUserInfo() {
    const user = checkLogin();
    if (!user) return;

    const users = getUsers();
    const fullUser = users.find(u => u.id === user.id);

    if (!fullUser) {
        alert("Erro ao carregar informações do usuário.");
        return;
    }

    document.getElementById("userName").textContent = fullUser.name;
    document.getElementById("userEmail").textContent = fullUser.email;
    document.getElementById("createdAt").textContent = formatDate(fullUser.createdAt);

    // Contar avaliações e produtos do usuário
    const ratings = getRatings();
    const products = getProducts();

    const userRatings = ratings.filter(r => r.userId === user.id);
    const userProducts = products.filter(p => p.userId === user.id);

    document.getElementById("userRatings").textContent = userRatings.length;
    document.getElementById("userProducts").textContent = userProducts.length;
}

/**
 * Abre modal para alterar senha
 */
function openChangePasswordModal() {
    document.getElementById("changePasswordModal").classList.add("active");
}

/**
 * Fecha modal de alterar senha
 */
function closeChangePasswordModal() {
    document.getElementById("changePasswordModal").classList.remove("active");
    document.getElementById("currentPassword").value = "";
    document.getElementById("newPassword").value = "";
    document.getElementById("confirmPassword").value = "";
}

/**
 * Altera a senha do usuário
 */
function changePassword() {
    const user = getCurrentUser();
    const users = getUsers();
    const userIndex = users.findIndex(u => u.id === user.id);

    if (userIndex === -1) {
        alert("Erro ao encontrar usuário.");
        return;
    }

    const currentPassword = document.getElementById("currentPassword").value;
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (!currentPassword || !newPassword || !confirmPassword) {
        alert("Preencha todos os campos.");
        return;
    }

    if (users[userIndex].password !== currentPassword) {
        alert("Senha atual incorreta.");
        return;
    }

    if (newPassword !== confirmPassword) {
        alert("As novas senhas não correspondem.");
        return;
    }

    if (newPassword.length < 4) {
        alert("A nova senha deve ter pelo menos 4 caracteres.");
        return;
    }

    users[userIndex].password = newPassword;
    saveUsers(users);

    alert("Senha alterada com sucesso!");
    closeChangePasswordModal();
}

/**
 * Deleta a conta do usuário
 */
function deleteAccount() {
    const confirmDelete = confirm("Tem certeza que deseja deletar sua conta? Esta ação é irreversível.");
    if (!confirmDelete) return;

    const user = getCurrentUser();
    const users = getUsers();
    const filteredUsers = users.filter(u => u.id !== user.id);

    saveUsers(filteredUsers);
    localStorage.removeItem("currentUser");

    alert("Conta deletada com sucesso.");
    window.location.replace("index.html");
}

/**
 * Inicializa página de conta
 */
function initAccountPage() {
    loadUserInfo();
    showUserGreeting();

    // Setup modal close button
    const modal = document.getElementById("changePasswordModal");
    if (modal) {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                closeChangePasswordModal();
            }
        });
    }
}

document.addEventListener("DOMContentLoaded", initAccountPage);
