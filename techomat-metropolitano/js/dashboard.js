function logout() {

    const confirmar = confirm("¿Desea cerrar sesión?");

    if (confirmar) {
        window.location.href = "login.php";
    }

}