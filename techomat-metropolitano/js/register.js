function register() {

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if(name && email && password) {
        alert('Usuario registrado correctamente');
        window.location.href = 'login.html';
    }
    else {
        alert('Complete todos los campos');
    }
}