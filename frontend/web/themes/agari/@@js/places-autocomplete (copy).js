/*var js = document.createElement("script");

js.type = "text/javascript";
js.src = '';

document.body.appendChild(js); */

  // This example requires the Places library. Include the libraries=places
  // parameter when you first load the API. For example:
  // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

  var placeSearch, autocomplete;
  var componentForm = {
	street_number: 'short_name',
	route: 'long_name',
	locality: 'long_name',
	administrative_area_level_1: 'short_name',
	country: 'long_name',
	postal_code: 'short_name'
  };
  
  var componentForm2 = {
	locality: 'long_name',
	administrative_area_level_1: 'long_name',
	country: 'long_name',
  };
  

  function initAutocomplete() {
	// Create the autocomplete object, restricting the search to geographical
	// location types.
	autocomplete = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */(document.getElementById('search_destination')),
		{types: ['geocode']});

	// When the user selects an address from the dropdown, populate the address
	// fields in the form.
	autocomplete.addListener('place_changed', fillInSearchForm);
  }

  function fillInSearchForm() {
	// Get the place details from the autocomplete object.
	var place = autocomplete.getPlace();
	//console.log('place::'+JSON.stringify(place)); return;
	
	// Get each component of the address from the place details
	// and fill the corresponding field on the form.
	for (var i = 0; i < place.address_components.length; i++) {
	  var addressType = place.address_components[i].types[0];
	  
	  switch(addressType) {
		case 'locality':
			var val = place.address_components[i]['long_name'];
			document.getElementById('search_city').value = val;
			break;
		
		case 'administrative_area_level_1':
			var val = place.address_components[i]['long_name'];
			document.getElementById('search_state').value = val;
			break;
		
		case 'country':
			var val = place.address_components[i]['long_name'];
			var valShortName = place.address_components[i]['short_name'];
			document.getElementById('search_country').value = val;
			document.getElementById('country_sortname').value = valShortName;
			break;
		
		}
	}
  }

  function fillInAddress() {
	// Get the place details from the autocomplete object.
	var place = autocomplete.getPlace();

	for (var component in componentForm) {
	  document.getElementById(component).value = '';
	  document.getElementById(component).disabled = false;
	}

	// Get each component of the address from the place details
	// and fill the corresponding field on the form.
	for (var i = 0; i < place.address_components.length; i++) {
	  var addressType = place.address_components[i].types[0];
	  if (componentForm[addressType]) {
		var val = place.address_components[i][componentForm[addressType]];
		document.getElementById(addressType).value = val;
	  }
	}
  }

  // Bias the autocomplete object to the user's geographical location,
  // as supplied by the browser's 'navigator.geolocation' object.
  function geolocate() {
	if (navigator.geolocation) {
	  navigator.geolocation.getCurrentPosition(function(position) {
		var geolocation = {
		  lat: position.coords.latitude,
		  lng: position.coords.longitude
		};
		var circle = new google.maps.Circle({
		  center: geolocation,
		  radius: position.coords.accuracy
		});
		autocomplete.setBounds(circle.getBounds());
	  });
	}
  }
