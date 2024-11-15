document.getElementById('loginForm')?.addEventListener('submit', function(event) {
    event.preventDefault(); 

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    
    const registeredUsers = JSON.parse(localStorage.getItem('users')) || [];
    const user = registeredUsers.find(user => user.username === username && user.password === password);

    if (user) {
        window.location.href = 'dashboard.html';
    } else {
        alert('Usuario o contraseña incorrectos.');
    }
});

document.getElementById('registerForm')?.addEventListener('submit', function(event) {
    event.preventDefault(); 

    const newUsername = document.getElementById('newUsername').value;
    const newPassword = document.getElementById('newPassword').value;

    
    const registeredUsers = JSON.parse(localStorage.getItem('users')) || [];
    const existingUser = registeredUsers.find(user => user.username === newUsername);

    if (existingUser) {
        alert('El usuario ya existe.');
    } else {
       
        registeredUsers.push({ username: newUsername, password: newPassword });
        localStorage.setItem('users', JSON.stringify(registeredUsers));
        alert('Cuenta creada con éxito. Ahora puedes iniciar sesión.');
        window.location.href = 'index.html'; 
    }
});


document.getElementById('loginForm')?.addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const registeredUsers = JSON.parse(localStorage.getItem('users')) || [];
    const user = registeredUsers.find(user => user.username === username && user.password === password);

    if (user) {
        alert('Has iniciado sesión correctamente.');
        setTimeout(() => {
            window.location.href = 'dashboard.html'; 
        }, 2000);
    } else {
        alert('Usuario o contraseña incorrectos.');
    }
});
