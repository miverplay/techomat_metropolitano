function logout() {
    window.location.href = 'login.html';
}

function addProduct() {

    const productName = document.getElementById('productName').value;
    const productCategory = document.getElementById('productCategory').value;
    const productPrice = document.getElementById('productPrice').value;
    const productDescription = document.getElementById('productDescription').value;

    if(productName && productCategory && productPrice && productDescription) {

        const list = document.getElementById('productList');

        const item = document.createElement('li');

        item.className = 'list-group-item';

        item.innerHTML = `
            <strong>${productName}</strong>
            <br>
            Categoría: ${productCategory}
            <br>
            Precio: $${productPrice}
            <br>
            ${productDescription}
        `;

        list.appendChild(item);

        alert('Producto agregado correctamente');

        // Limpiar formulario
        document.getElementById('productName').value = '';
        document.getElementById('productCategory').value = '';
        document.getElementById('productPrice').value = '';
        document.getElementById('productDescription').value = '';

    } else {

        alert('Complete todos los campos');

    }
}