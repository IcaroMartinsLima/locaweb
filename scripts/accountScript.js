/* ===== ACCOUNT FUNCTIONS ===== */

/**
 * Carrega informações do usuário via banco
 */
function loadUserInfo() {
    const user = checkLogin();
    if (!user) return;

    fetch("../auth_user.php?id=" + user.id)
        .then(res => {
            if (!res.ok) throw new Error("HTTP " + res.status);
            return res.json();
        })
        .then(data => {
            if (!data.success) {
                alert(data.message);
                return;
            }

            const u = data.user;
            document.getElementById("userName").textContent = u.name;
            document.getElementById("userEmail").textContent = u.email;
            document.getElementById("createdAt").textContent = formatDate(u.createdAt);
        })
        .catch(err => alert("Erro: " + err.message));
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
    window.location.replace("../index.php");
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
