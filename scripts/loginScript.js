/* ===== AUTH FUNCTIONS (Login e Register) ===== */

/**
 * Função de login
 */
function handleLogin() {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (!email || !password) {
        alert("Preencha todos os campos.");
        return;
    }

    const users = getUsers();
    
    // Cria usuário de teste na primeira execução
    if (users.length === 0) {
        users.push({
            id: 1,
            name: "Usuário Teste",
            email: "meuemail@gmail.com",
            password: "1234",
            createdAt: new Date().toISOString()
        });
        saveUsers(users);
    }

    const user = users.find(u => u.email.toLowerCase() === email.toLowerCase() && u.password === password);

    if (user) {
        setCurrentUser({
            id: user.id,
            name: user.name,
            email: user.email
        });
        window.location.replace("index.html");
    } else {
        alert("Credenciais inválidas.");
    }
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
    window.location.replace("index.html");
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
function getUsers() {
    const raw = localStorage.getItem("users");
    if (!raw) return [];

    try {
        const parsed = JSON.parse(raw);
        return Array.isArray(parsed) ? parsed : [];
    } catch (err) {
        console.warn("JSON inválido no localStorage, resetando.", err);
        return [];
    }
}

function setCurrentUser(user) {
    localStorage.setItem("currentUser", JSON.stringify(user));
}

const form = document.getElementById('loginForm');

form.addEventListener('submit', (e) => {
    e.preventDefault();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    const users = getUsers();
    
    // Adiciona usuário de teste se não existir
    if (users.length === 0) {
        users.push({
            id: 1,
            name: "Usuário Teste",
            email: "meuemail@gmail.com",
            password: "1234",
            createdAt: new Date().toISOString()
        });
        localStorage.setItem("users", JSON.stringify(users));
    }

    const user = users.find(u => u.email.toLowerCase() === email.toLowerCase() && u.password === password);

    if (user) {
        setCurrentUser({
            id: user.id,
            name: user.name,
            email: user.email
        });
        window.location.replace("index.html");
    } else {
        alert("Credenciais inválidas.");
    }
});


