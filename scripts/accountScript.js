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
            document.getElementById("userCargo").textContent = u.cargo || "-";
            document.getElementById("createdAt").textContent = formatDate(u.createdAt);
        })
        .catch(err => alert("Erro: " + err.message));
}

function openEditModal() {
    const user = getCurrentUser();
    document.getElementById("editName").value = user.name || "";
    document.getElementById("editEmail").value = user.email || "";
    document.getElementById("editCargo").value = user.cargo || "";
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
    const cargo = document.getElementById("editCargo").value;
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
    formData.append("cargo", cargo);
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
    const password = prompt("Confirme sua senha para excluir a conta:");
    if (!password) return;

    const user = getCurrentUser();
    if (!user) return;

    const formData = new FormData();
    formData.append("id", user.id);
    formData.append("senha", password);

    fetch("../usuario_excluir.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                localStorage.removeItem("currentUser");
                alert("Conta deletada com sucesso.");
                window.location.replace("../index.php");
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert("Erro ao conectar com o servidor."));
}

function loadGestorStats() {
    const user = getCurrentUser();
    if (!user) return;
    Promise.all([
        fetch("../produto_gestor_listar.php?gestor_id=" + user.id).then(r => r.json()),
        fetch("../feedback_listar_todos.php?gestor_id=" + user.id).then(r => r.json())
    ])
    .then(([prodData, fbData]) => {
        const produtos = prodData.produtos || [];
        const feedbacks = fbData.feedbacks || [];

        document.getElementById("gestorTotalProducts").textContent = produtos.length;

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
        document.getElementById("gestorAvgRating").textContent = avg ? avg + " ⭐" : "N/A";

        let bestPid = null, worstPid = null;
        let bestAvg = -1, worstAvg = 6;
        for (const pid in productRatings) {
            const arr = productRatings[pid];
            const pAvg = arr.reduce((a, b) => a + b, 0) / arr.length;
            if (pAvg > bestAvg) { bestAvg = pAvg; bestPid = pid; }
            if (pAvg < worstAvg) { worstAvg = pAvg; worstPid = pid; }
        }

        const bestProd = produtos.find(p => String(p.produto_id) === String(bestPid));
        const worstProd = produtos.find(p => String(p.produto_id) === String(worstPid));
        document.getElementById("gestorBestProduct").textContent = bestProd ? bestProd.nome + " (" + bestAvg.toFixed(1) + ")" : "-";
        document.getElementById("gestorWorstProduct").textContent = worstProd ? worstProd.nome + " (" + worstAvg.toFixed(1) + ")" : "-";
    })
    .catch(() => {
        document.getElementById("gestorTotalProducts").textContent = "Erro";
    });
}

function initAccountPage() {
    loadUserInfo();
    showUserGreeting();

    const user = getCurrentUser();
    if (user && user.cargo === "Gestor de Produto") {
        const statsSection = document.getElementById("statsSection");
        if (statsSection) statsSection.style.display = "block";
        loadGestorStats();
    }

    const editCargo = document.getElementById("editCargo");
    if (editCargo && user && user.cargo !== "Gestor de Produto") {
        editCargo.style.display = "none";
    }

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
