/* ===== AUTH FUNCTIONS (Login e Register) ===== */

/**
 * Função de login via banco de dados
 */
function handleLogin() {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (!email || !password) {
        alert("Preencha todos os campos.");
        return;
    }

    const formData = new FormData();
    formData.append("login", email);
    formData.append("senha", password);

    fetch("../usuario_listar.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            setCurrentUser(data.user);
            window.location.replace("../index.php");
        } else {
            alert(data.message);
        }
    })
    .catch(() => alert("Erro ao conectar com o servidor."));
}

/**
 * Função de registro via banco de dados
 */
function handleRegister() {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const cargo = document.getElementById('cargo').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (!name || !email || !cargo || !password || !confirmPassword) {
        alert("Preencha todos os campos.");
        return;
    }

    if (password !== confirmPassword) {
        alert("As senhas não correspondem.");
        return;
    }

    if (password.length < 4) {
        alert("A senha deve ter pelo menos 4 caracteres.");
        return;
    }

    const formData = new FormData();
    formData.append("nome", name);
    formData.append("login", email);
    formData.append("cargo", cargo);
    formData.append("senha", password);

    fetch("../usuarios_incluir.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            setCurrentUser(data.user);
            alert("Cadastro realizado com sucesso! Bem-vindo " + name);
            window.location.replace("../index.php");
        } else {
            alert(data.message);
        }
    })
    .catch(() => alert("Erro ao conectar com o servidor."));
}

/**
 * Inicializa eventos de login
 */
function initLoginForm() {
    const form = document.getElementById('loginForm');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            handleLogin();
        });
    }
}

/**
 * Inicializa eventos de registro
 */
function initRegisterForm() {
    const form = document.getElementById('registerForm');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            handleRegister();
        });
    }
}

// Inicializa ao carregar
document.addEventListener("DOMContentLoaded", () => {
    initLoginForm();
    initRegisterForm();
});


