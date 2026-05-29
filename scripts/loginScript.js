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

    fetch("../auth_login.php", {
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
 * Função de registro
 */
function handleRegister() {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    // Validações
    if (!name || !email || !password || !confirmPassword) {
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

    const users = getUsers();

    // Verifica se email já existe
    if (users.some(user => user.email.toLowerCase() === email.toLowerCase())) {
        alert("Este email já está cadastrado.");
        return;
    }

    // Cria novo usuário
    const newUser = {
        id: Date.now(),
        name: name,
        email: email,
        password: password,
        createdAt: new Date().toISOString()
    };

    users.push(newUser);
    saveUsers(users);

    // Faz login automático
    setCurrentUser({
        id: newUser.id,
        name: newUser.name,
        email: newUser.email
    });

    alert("Cadastro realizado com sucesso! Bem-vindo " + name);
    window.location.replace("../index.php");
}

/**
 * Define usuário atual na sessão
 */
function setCurrentUser(user) {
    localStorage.setItem("currentUser", JSON.stringify(user));
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


