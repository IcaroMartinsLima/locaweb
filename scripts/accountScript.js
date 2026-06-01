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

function openEditModal() {
    const user = getCurrentUser();
    document.getElementById("editName").value = user.name || "";
    document.getElementById("editEmail").value = user.email || "";
    document.getElementById("editCurrentPassword").value = "";
    document.getElementById("editNewPassword").value = "";
    document.getElementById("editConfirmPassword").value = "";
    document.getElementById("editModal").classList.add("active");
}

function closeEditModal() {
    document.getElementById("editModal").classList.remove("active");
}

function updateUser() {
    const user = getCurrentUser();
    if (!user) return;

    const name = document.getElementById("editName").value.trim();
    const email = document.getElementById("editEmail").value.trim();
    const currentPassword = document.getElementById("editCurrentPassword").value;
    const newPassword = document.getElementById("editNewPassword").value;
    const confirmPassword = document.getElementById("editConfirmPassword").value;

    if (!currentPassword) {
        alert("Informe sua senha atual para confirmar as alterações.");
        return;
    }

    if (newPassword && newPassword !== confirmPassword) {
        alert("As novas senhas não correspondem.");
        return;
    }

    if (newPassword && newPassword.length < 4) {
        alert("A nova senha deve ter pelo menos 4 caracteres.");
        return;
    }

    const formData = new FormData();
    formData.append("id", user.id);
    formData.append("nome", name);
    formData.append("login", email);
    formData.append("senha_atual", currentPassword);
    if (newPassword) {
        formData.append("nova_senha", newPassword);
    }

    fetch("../usuario_editar.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                setCurrentUser(data.user);
                alert("Informações atualizadas com sucesso!");
                closeEditModal();
                loadUserInfo();
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert("Erro ao conectar com o servidor."));
}

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

function initAccountPage() {
    loadUserInfo();
    showUserGreeting();

    const modal = document.getElementById("editModal");
    if (modal) {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                closeEditModal();
            }
        });
    }
}

document.addEventListener("DOMContentLoaded", initAccountPage);
