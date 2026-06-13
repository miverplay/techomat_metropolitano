function login() {

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if(email === 'admin@test.com' && password === '123456') {

        window.location.href = 'admin.php';

    }

    else if(email === 'vendedor@test.com' && password === '123456') {

        window.location.href = 'vendedor.html';

    }

    else if(
        (email === 'usuario1@test.com' && password === '123456') ||
        (email === 'usuario2@test.com' && password === '123456') ||
        (email === 'usuario3@test.com' && password === '123456')
    ) {

        window.location.href = 'dashboard.html';

    }

    else {

        alert('Correo o contraseña incorrectos');

    }

}