import Places from 'places.js'
// import Map from './js/modules/map.js'

// Map.init()


let inputAddress=document.querySelector('#property_adress')
if (inputAddress !== null){
    let place = Places({
        container: inputAddress
})
    place.on('change', e=>{
      document.querySelector('#property_city').value=e.suggestion.city
      document.querySelector('#property_postal_code').value=e.suggestion.postcode 
      document.querySelector('#property_lat').value=e.suggestion.latlng.lat
      document.querySelector('#property_lng').value=e.suggestion.latlng.lng
    })
}

let $ = require('jquery')
require('./styles/css/app.css');
require('./styles/css/leafleat.css');
require('select2')

// $('select').select2();

$('#contactButton').click(e=>{
    console.log('hello')
    e.preventDefault()
    $('#contactForm').slideDown();
    $('#contactButton').slideUp()
})

document.querySelectorAll('[data-delete]').forEach(a =>{
    a.addEventListener('click', e =>{
        e.preventDefault()
        fetch(a.getAttribute('href'),{
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({'_token': a.dataset.token})
        })  .then(response=>response.json())
            .then(data =>{
                if(data.success){
                    a.parentNode.parentNode.removeChild(a.parentNode)
                }else{
                    alert(data.error)
                }
            })
            .catch(e => alert(e))
    })
})

// start the Stimulus application
import './bootstrap';
