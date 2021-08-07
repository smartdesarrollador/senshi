
var input = document.getElementById('hora');
var fecha = document.getElementById('fecha');

var picker = new Picker(input, {
    format: 'HH:mm',
    text: {
        title: 'Escoge un Hora',
        cancel: 'Cancelar',
        confirm: 'OK',
        year: 'Año',
        month: 'Mes',
        day: 'Día',
        hour: 'Hora',
        minute: 'Minuto',
        second: 'Segundo',
        millisecond: 'Milisegundo',
    }
});
var picker2 = new Picker(fecha, {
    format: 'MMMM D, YYYY',
    text: {
        title: 'Escoge una Fecha',
        cancel: 'Cancelar',
        confirm: 'OK',
        year: 'Año',
        month: 'Mes',
        day: 'Día',
        hour: 'Hora',
        minute: 'Minuto',
        second: 'Segundo',
        millisecond: 'Milisegundo'
    },
    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'],
    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre']
});

window.addEventListener("load", function() {

    var dni = document.getElementById("dni");
    var numeroPersonas = document.getElementById("numeroPersonas");
    var telefono = document.getElementById("telefono");

    dni.addEventListener("keypress", soloNumeros, false);
    numeroPersonas.addEventListener("keypress", soloNumeros, false);
    telefono.addEventListener("keypress", soloNumeros, false);



});

//Solo permite introducir numeros.
function soloNumeros(e){
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
        e.preventDefault();
    }
}
