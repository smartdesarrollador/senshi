$('.formCard').submit(function (event) {

    event.preventDefault();
    let form = this;

    let id = form.querySelector('.idProducto').value;
    let button = form.querySelector('.btn-comprar');
    let cantidad = form.querySelector('.cantidad').value;
    let idMediaPorcion = form.querySelector('.idMediaPorcion').value;

    let porcionMedio = form.querySelector('.radioMedioMaki').checked;


    let data = new FormData();
    button.disabled = true;

    /*data.append('id', id);*/
    data.append('cantidad', cantidad);
    data.append('action', 'addToCart');

    if (porcionMedio) {
        data.append('id', idMediaPorcion);
    }else{
        data.append('id', id);
    }

    fetch('script/cartAction.php', {
        method: 'POST',
        body: data
    }).then(function (response) {
        if (response.ok) {
            return response.text();
        } else {
            alert("Error de conexión, verifica si tu dispositivo esta conectado a internet");
            window.location.reload();
        }
    }).then(function (response) {
        $('#exampleModal').modal('show');
        button.disabled = false;

    }).catch(function (error) {
        alert("Error de conexión, verifica si tu dispositivo esta conectado a internet");
    });
    console.log();
    return false;
});

mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
    scrollFunction()
};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";

    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
