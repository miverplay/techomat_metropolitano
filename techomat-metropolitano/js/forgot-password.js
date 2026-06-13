function recoverPassword() {

    const email = document.getElementById('recoveryEmail').value;

    if(email) {
        alert('Se ha enviado un enlace de recuperación');
    }
    else {
        alert('Ingrese un correo');
    }
}