// This sample uses the Autocomplete widget to help the user select a
// place, then it retrieves the address components associated with that
// place, and then it populates the form fields with those details.
// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

let placeSearch, autocomplete;

let componentForm = {
    distrito: 'long_name'
};
google.maps.event.addDomListener(window, 'load', initAutocomplete);
function initAutocomplete() {

    // Create the autocomplete object, restricting the search predictions to
    // geographical location types.
    let options = {
        types: ['geocode'],
        componentRestrictions: {country: "PE"}
    };

    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('direccion'),options);
    // Avoid paying for data that you don't need by restricting the set of
    // place fields that are returned to just the address components.
    /*autocomplete.setFields(['address_component']);*/
    // When the user selects an address from the drop-down, populate the
    // address fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    let place = autocomplete.getPlace();


        document.getElementById('longitud').value = '';
        document.getElementById('latitud').value = '';


    let longitud = place.geometry.location.lng();
    let latitud = place.geometry.location.lat();
    insertarLatYLng(longitud, latitud);

    crearMapa(longitud,latitud);

   document.getElementById('distrito').value = place.address_components[3].long_name;



}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
/*function geolocate() {
  /!*  if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            let geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            let circle = new google.maps.Circle(
                {center: geolocation, radius: position.coords.accuracy});
            autocomplete.setBounds(circle.getBounds());
        });
    }*!/
}*/

function insertarLatYLng(lng, lat) {
    document.getElementById('longitud').value = lng;
    document.getElementById('latitud').value = lat;
}
function crearMapa(lng,lat) {


    //Se crea una nueva instancia del objeto mapa
    let mapElement = document.getElementById('map');

    document.getElementById('map-title').classList.remove('d-none');

    mapElement.style.height = '200px';

    let mapsOptions = {
        zoom: 15,
        streetViewControl: false,
        center: new google.maps.LatLng(lat, lng),

    };
    let map = new google.maps.Map(mapElement,mapsOptions
        );

    //Creamos el marcador en el mapa con sus propiedades
    //para nuestro obetivo tenemos que poner el atributo draggable en true
    //position pondremos las mismas coordenas que obtuvimos en la geolocalización
    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(lat,lng),

    });

    google.maps.event.addListener(marker, 'dragend', function (evt) {
        insertarLatYLng(evt.latLng.lng(),evt.latLng.lat());
    });

}
