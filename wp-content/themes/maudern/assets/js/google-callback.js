function initMap() {

  var map;
  var mapEl = document.getElementById('shop-map');
  var geolocpoint;
  var icon = 'https://worth-dev.epicea.tech/wp-content/themes/maudern/assets/images/icons/shop_pin.png';

  function reqListener () {

    var stores = JSON.parse(this.responseText);
    stores.forEach(function(store) {

      var contentString = 
      '<div id="content">' +
        '<h5 id="firstHeading" class="firstHeading">' + store.title.rendered + '</h5>' +
        '<p>' + 
          store.acf.address  + '<br>' +
          ((store.acf.postal_code !== '') ? store.acf.postal_code : '') + ' ' + store.acf.city + '<br>' +
          ((store.acf.country !== '') ? store.acf.country : '')  + '<br>' +
          '<br>' + 
          ((store.acf.tel !== '') ? 'Tel .: ' + store.acf.phone : '')  + '<br>' +
          ((store.acf.email !== '') ? 'Email : ' + store.acf.email : '')  + '<br>' +
          ((store.acf.site_url !== '') ? 'Site : ' + store.acf.site_url: '')  + '<br>' +
        '</p>' + 
        '<p>' + 
          'Work time: <br>' + 
          ((store.acf.opening_hours !== '') ? store.acf.opening_hours.replace(/\r\n/g, '<br>') : '') + 
        '</p>' +
      '</div>';

      var infowindow = new google.maps.InfoWindow({
          content: contentString,
          maxWidth: 300
      });
      
      var marker = new google.maps.Marker({
          position: {lat: parseFloat(store.acf.latitude), lng: parseFloat(store.acf.longitude)},
          map: map,
          icon: icon,
          animation: google.maps.Animation.DROP
      });
      marker.addListener('click', function() {
          infowindow.open(map, marker);
      });

      if (geolocpoint) {
        var pos = new google.maps.LatLng(parseFloat(store.acf.latitude), parseFloat(store.acf.longitude));
        store.distance = getDistance(pos, geolocpoint);
        store.distance = parseFloat((store.distance / 1000).toFixed(1));
      }

    });
    

    if (geolocpoint) {
      stores.sort(function (a, b) {
        return a.distance - b.distance;
      });

      html = '';
      stores.forEach(function (store) {
        html += 
        '<div class="store">' + 
          '<div class="title table">' +
            '<h4 class="td">' + store.title.rendered + '</h4> <div class="distance td">à ' + store.distance + 'km</div>' + 
          '</div>' + 
          '<div class="content">' +
            '<p>' + 
            store.acf.address  + '<br>' +
            ((store.acf.postal_code !== '') ? store.acf.postal_code : '') + ' ' + store.acf.city + '<br>' +
            ((store.acf.country !== '') ? store.acf.country : '')  + '<br>' +
            '<br>' + 
            ((store.acf.phone !== '') ? 'Tel .: ' + store.acf.phone : '')  + '<br>' +
            ((store.acf.email !== '') ? 'Email : ' + store.acf.email : '')  + '<br>' +
            ((store.acf.site_url !== '') ? 'Site : ' + store.acf.site_url: '')  + '<br>' +
          '</p>' + 
          '</div>' +
        '</div>';
      });

      document.getElementById('stores-cont').innerHTML = html;

      document.querySelectorAll('.store').forEach(function(store) {
        store.onclick = function () {
          if (store.classList.contains('open')) {
            store.classList.remove('open');
          } else {
            store.classList.add('open');
          }
        }
      });
    }
    
  }
  

    /*var contentString0 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'Tbilisi'+
    '</h5>'+
    '<p> Géorgie, Tbilisi</p>' +
    '<p>'+ 'RUSTAVELI AVENUE N40-40A OLD TBILISI DISTR' +
    '<br/>'+ '<p>RUSTAVELI AVENUE N40-40A OLD TBILISI DISTR</p><p>Tel .: +995 32 2 990 994</p><p>Work time:</p><p>Monday - Saturday:10:00-22:00</p><p>Sunday: 11:00-21:00</p>'+ '</p></div>';
    
    var contentString1 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'Dika Magheru'+
    '</h5>'+
    '<p> Roumanie, Bucuresti </p>' +
    '<p>'+ '34 MAGEROU BLVD SECTOR 1' +
    '<br/>'+ '<p>Tel .: 0213 142 588</p><p>Tel .: 0744 104 249</p><p>Work time:</p><p>Monday - Saturday:</p><p>  10: 00-21: 00</p><p>Sunday: 10: 00-20: 00</p>'+ '</p></div>';
                                
    var contentString2 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'Dika Mall Afi Palace Cotroceni'+
    '</h5>'+
    '<p> Roumanie, Bucuresti </p>' +
    '<p>'+ '4 VASILE MILEA BLVD SECTOR 6' +
    '<br/>'+ '<p>Tel .: 0744 104 249</p><p>Tel .: 0372 941 627</p><p>Work time:</p><p>Monday - Sunday:</p><p>10: 00-22: 00</p>'+ '</p></div>';
                                
    var contentString3 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'Dika Mega Mall'+
    '</h5>'+
    '<p> Roumanie, Bucuresti </p>' +
    '<p>'+ 'Mega Mall , Bd Pierre de Coubertine, nr 3-5, Sector 2' +
    '<br/>'+ '<p>Tel .: 0371 002 453</p><p>Tel .: 0746 203 563</p><p>Work time:</p><p>Monday - Sunday:</p><p>10: 00-22: 00</p>'+ '</p></div>';
                                
    var contentString4 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'Constanta'+
    '</h5>'+
    '<p> Roumanie, Constanta</p>' +
    '<p>'+ '' +
    '<br/>'+ '<p>Bd. Stefan cel mare, nr 14, bloc M4</p><p>	Adresa: Bd. Stefan cel mare, nr. 14, Bl. M4</p><p>	Tel: 0744 766 878</p><p>	Work time: Luni-Vineri 10:00 - 19:00</p><p>	  Sambata  10:00 -15:00</p><p>	  Duminica  Inchis</p>'+ '</p></div>';
                                
    var contentString5 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'SIBIU'+
    '</h5>'+
    '<p> Roumanie, SIBIU</p>' +
    '<p>'+ '16 PIATA MARE STREET' +
    '<br/>'+ '<p>Sibiu, Piata Mare, nr 16, Vis-a-Vis de Turn, Piata Mare</p><p>Tel: 0372 796 983/&nbsp;0726 264 230</p><p>Work time:</p><p>Monday - Saturday:&nbsp;09:00 - 20:00</p><p>Sunday: 09:00 - 19:00</p>'+ '</p></div>';
                                
    var contentString6 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Mall Galleria '+
    '</h5>'+
    '<p> Bulgarie, Burgas</p>' +
    '<p>'+ '6 Yanko Komitov Str.' +
    '<br/>'+ '<p>Tel.: +359 56/ 70 22 27</p><p>Work Time:</p><p>Monday-Sunday</p><p>10:00-21:00</p><p>email: <u style="background-color: initial;"><a href="mailto:Burgas@dika.com">Burgas@dika.com</a></u></p>'+ '</p></div>';
                                
    var contentString7 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Plovdiv'+
    '</h5>'+
    '<p> Bulgarie, Plovdiv</p>' +
    '<p>'+ '18, Alexander Batenberg, Str.' +
    '<br/>'+ '<p>Tel.: +359 32/62 23 43</p><p>Work Time:</p><p>Monday-Saturday</p><p>10:00-21:00</p><p>Sunday</p><p>10:00-20:00</p><p>email: <u style="background-color: initial;"><a href="mailto:Plovdiv@dika.com">Plovdiv@dika.com</a></u></p>'+ '</p></div>';
                                
    var contentString8 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Sliven'+
    '</h5>'+
    '<p> Bulgarie, Sliven</p>' +
    '<p>'+ '29, Hadji Dimitar Blvd.' +
    '<br/>'+ '<p>Tel.:+359 44/66 23 34</p><p>Work Time:</p><p>Monday-Saturday</p><p>10:00-20:00</p><p>Sunday</p><p>Non-working day</p>'+ '</p></div>';
                                
    var contentString9 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'Sliven Outlet'+
    '</h5>'+
    '<p> Bulgarie, Sliven</p>' +
    '<p>'+ 'bul. Stefan Karadzha 30' +
    '<br/>'+ '<p>Tel.:+359 44/50 06 99</p><p>Work Time:</p><p>Monday-Saturday</p><p>10:00-20:00</p><p>Sunday</p><p>10:00-19:00</p><p>email:<u><a href="mailto:sliven.outlet@dika.com">sliven.outlet@dika.com</a></u></p>'+ '</p></div>';
                                
    var contentString10 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Vitosha'+
    '</h5>'+
    '<p> Bulgarie, Sofia</p>' +
    '<p>'+ '65, Vitosha Blvd' +
    '<br/>'+ '<p>Tel.: +359 2/981 81 72</p><p>Work Time:</p><p>Monday-Saturday</p><p>10:00-21:00</p><p>Sunday</p><p>10:00-20:00</p><p>email :<u style="background-color: initial;"><a href="mailto:Sofia.Vitosha@dika.com">Sofia.Vitosha@dika.com</a></u></p>'+ '</p></div>';
                                
    var contentString11 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Mall Serdika'+
    '</h5>'+
    '<p> Bulgarie, Sofia</p>' +
    '<p>'+ '48, Sitniakovo blvd.' +
    '<br/>'+ '<p>Tel.: +359 2/426 27 12</p><p>Work Time:</p><p>Monday-Sunday</p><p>10:00-21:00</p><p>Email :<u style="background-color: initial;"><a href="mailto:Sofia.Serdika@dika.com">Sofia.Serdika@dika.com</a></u></p>'+ '</p></div>';
                                
    var contentString12 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa The Mall'+
    '</h5>'+
    '<p> Bulgarie, Sofia</p>' +
    '<p>'+ '115, Tsarigradsko Shousse blvd' +
    '<br/>'+ '<p>Tel.: +359 2/454 12 32</p><p>Work Time:</p><p>Monday-Sunday</p><p>10:00-21:00</p><p>email : <u style="background-color: initial;"><a href="mailto:Sofia.themall@dika.com">Sofia.Themall@dika.com</a></u></p>'+ '</p></div>';
                                
    var contentString13 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'Sofia Outlet'+
    '</h5>'+
    '<p> Bulgarie, Sofia</p>' +
    '<p>'+ 'ul.Pirotska 20B' +
    '<br/>'+ '<p>Tel: +359 /885 19 66 55</p><p>Work Time:</p><p>Monday-Saturday</p><p>10:00-20:00</p><p>Sunday</p><p>10:00-19:00</p><p>email: <u><a href="mailto:Sofia.Outlet@dika.com">Sofia.Outlet@dika.com</a></u></p>'+ '</p></div>';
                                
    var contentString14 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Veliko Turnovo'+
    '</h5>'+
    '<p> Bulgarie, Veliko Turnovo</p>' +
    '<p>'+ '55, Stefan Stambolov Str.' +
    '<br/>'+ '<p>Tel.:+359 62/62 58 15</p><p>Work Time:</p><p>Monday-Saturday</p><p>10:00-20:00</p><p>Sunday</p><p>10:00-19:00</p><p>email: <u style="background-color: initial;"><a href="mailto:Veliko.Tarnovo@dika.com">Veliko.Tarnovo@dika.com</a></u></p>'+ '</p></div>';
                                
    var contentString15 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Caen'+
    '</h5>'+
    '<p>  France, Caen</p>' +
    '<p>'+ '39, Boulevard Leclerc' +
    '<br/>'+ '<p>Tel .: +33 2 31 23 63 14</p><p>Email: Caen@dika.com</p><p>Work time</p><p>Tuesday - Wednesday:</p><p>10:30-13:00 and 14:00-19:00</p><p>Thursday - Saturday:</p><p>10:00-13:30 and 14:00-19:00</p><p>Monday and Sunday:</p><p>Non-working day</p>'+ '</p></div>';
                                
    var contentString16 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Melun'+
    '</h5>'+
    '<p>  France, Melun</p>' +
    '<p>'+ '44 Rue Saint Aspais' +
    '<br/>'+ '<p>Tel .: +33 1 87 28 00 50</p><p>Email: melun@dika.com</p><p>Work time:</p><p>Tuesday-Saturday:</p><p>10:00 - 19:00</p><p>Monday and Sunday:</p><p> Non-working days</p>'+ '</p></div>';
                                
    var contentString17 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DIKA METZ'+
    '</h5>'+
    '<p>  France, METZ</p>' +
    '<p>'+ '38 rue Serpenoise' +
    '<br/>'+ '<p>Tel .:&nbsp;+33 372480000</p><p>Email: metz@dika.com</p><p>Work time:</p><p>Monday - Saturday:</p><p>  10:00-19:00</p><p>Sunday: Non-Working day</p>'+ '</p></div>';
                                
    var contentString18 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'MONTPELLIER POLYGONE'+
    '</h5>'+
    '<p>  France, Montpellier </p>' +
    '<p>'+ 'C.C. Le Polygone - Cellule n°309' +
    '<br/>'+ '<p>Tel.:&nbsp;+33 467404717</p><p>Email: montpellier@dika.com</p><p>Work hours:</p><p>Monday-Saturday:</p><p>10:00-20:00</p><p>Sunday:</p><p>Non-working day</p>'+ '</p></div>';
                                
    var contentString19 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DIKA NICE'+
    '</h5>'+
    '<p>  France, NICE</p>' +
    '<p>'+ '5 rue de la Liberté' +
    '<br/>'+ '<p>Tel.:&nbsp;+33 483560040</p><p>Email: nice@dika.com</p><p>Work time:</p><p>Monday-Saturday:</p><p> 10:00-19:00</p><p>Sunday:</p><p>Non-working day.</p>'+ '</p></div>';
                                
    var contentString20 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Paris'+
    '</h5>'+
    '<p>  France, Paris 6е</p>' +
    '<p>'+ '108 bis Rue de Rennes' +
    '<br/>'+ '<p>Tel: +33 1 45 44 86 70</p><p>Email: paris.rennes@dika.com</p><p>Work time:</p><p>Monday:</p><p>13:00-19:00</p><p>Tuesday-Saturday:</p><p>10:30-19:00</p><p>Sunday:</p><p>Non-working day.</p>'+ '</p></div>';
                                
    var contentString21 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Pau'+
    '</h5>'+
    '<p>  France, Pau</p>' +
    '<p>'+ '14 Rue Serviez' +
    '<br/>'+ '<p>Tel .: +33 5 59 27 75 74</p><p>Email: pau@dika.com</p><p>Work time:</p><p>Monday and Wednesday:</p><p>10:00-13:00 and 14:00-19:00</p><p>Tuesday and Thursday-Saturday:</p><p>10:00-19:00</p><p>Sunday: Non-working day</p>'+ '</p></div>';
                                
    var contentString22 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Rouen'+
    '</h5>'+
    '<p>  France, Rouen</p>' +
    '<p>'+ '25 Rue Thouret' +
    '<br/>'+ '<p>Tel .: +33 2 35 70 09 41</p><p>Email: rouen@dika.com</p><p>Work time:</p><p>Monday:</p><p>14:00-19:00</p><p>Tuesday-Saturday:</p><p>10:00-13:00 and 14:00-19:00</p><p>Sunday:</p><p>Non-working day</p>'+ '</p></div>';
                               
    var contentString23 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Saint Omer'+
    '</h5>'+
    '<p>  France, Saint Omer</p>' +
    '<p>'+ '40/42 Rue des Clouteries' +
    '<br/>'+ '<p>Tel .: + 33 3 21 38 30 64</p><p>Email: saintomer@dika.com</p><p>Work time</p><p>Monday:</p><p>14:00-19:00</p><p>Tuesday-Saturday:</p><p>9:30-12:30 and 14:00-19:00</p>'+ '</p></div>';
                                
    var contentString24 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Toulon'+
    '</h5>'+
    '<p>  France, Toulon</p>' +
    '<p>'+ '422 Ave Jean Jaures' +
    '<br/>'+ '<p>Tel .: +33 4 94 92 79 64</p><p>Email: toulon@dika.com</p><p>Work time:</p><p>Monday: 12:30-19:00</p><p>Tuesday: 10:00-19:00</p><p>Wednesday:&nbsp;10:00-13:00 and 14:00-19:00</p><p>Thursday-Friday: 10:00 - 19:00</p><p>Saturday: 10:00-13:00 and 14:00-19:00</p><p>Sunday:&nbsp;Non-working day</p>'+ '</p></div>';
                                
    var contentString25 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Toulouse'+
    '</h5>'+
    '<p>  France, TOULOUSE</p>' +
    '<p>'+ '38, Rue Alsace Lorraine' +
    '<br/>'+ '<p>Tel .: + 33 5 61 12 06 35</p><p>Email: toulouse@dika.com</p><p>Work time</p><p>Monday: 10:00-13:00 and 14:00-19:00</p><p>Tuesday - Saturday:</p><p>10:00-19:00</p><p>Sunday:</p><p>Non-working day</p>'+ '</p></div>';
                                
    var contentString26 = '<div id="content">'+
    '<h5 id="firstHeading" class="firstHeading">'+'DiKa Tours'+
    '</h5>'+
    '<p>  France, Tours</p>' +
    '<p>'+ '34 Rue des Halles, 37000 Tours' +
    '<br/>'+ '<p>Tel .: +33 2 47 20 60 12</p><p>Email: tours@dika.com</p><p>Work time</p><p>Monday: 14:00-19:00</p><p>Tuesday and Thursday-Friday:</p><p>10:30-13:00 and 14:00-19:00</p><p>Wednesday and Saturday:</p><p>10:00-19:00</p><p>Sunday:</p><p>Non-working day</p>'+ '</p></div>';
*/

  function showMap() {
    var oReq = new XMLHttpRequest();
    oReq.onload = reqListener;
    oReq.open('get', 'https://worth-dev.epicea.tech/wp-json/wp/v2/store', true);
    oReq.send();

    var defaultCenter = { 
        lat: 46.60099601563263, 
        lng: 2.3324898279628967
    };
    var defaultZoom = 6;

    if (geolocpoint) {
      defaultCenter = geolocpoint;
      defaultZoom = 10;
    }
    
    map = new google.maps.Map(mapEl, {
        disableDefaultUI: true,
        zoom: defaultZoom,
        center: defaultCenter,
        styles: [
            {
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#f5f5f5"
                }
              ]
            },
            {
              "elementType": "labels.icon",
              "stylers": [
                {
                  "visibility": "off"
                }
              ]
            },
            {
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#616161"
                }
              ]
            },
            {
              "elementType": "labels.text.stroke",
              "stylers": [
                {
                  "color": "#f5f5f5"
                }
              ]
            },
            {
              "featureType": "administrative.land_parcel",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#bdbdbd"
                }
              ]
            },
            {
              "featureType": "poi",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#eeeeee"
                }
              ]
            },
            {
              "featureType": "poi",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#757575"
                }
              ]
            },
            {
              "featureType": "poi.park",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#e5e5e5"
                }
              ]
            },
            {
              "featureType": "poi.park",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#9e9e9e"
                }
              ]
            },
            {
              "featureType": "road",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#ffffff"
                }
              ]
            },
            {
              "featureType": "road.arterial",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#757575"
                }
              ]
            },
            {
              "featureType": "road.highway",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#dadada"
                }
              ]
            },
            {
              "featureType": "road.highway",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#616161"
                }
              ]
            },
            {
              "featureType": "road.local",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#9e9e9e"
                }
              ]
            },
            {
              "featureType": "transit.line",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#e5e5e5"
                }
              ]
            },
            {
              "featureType": "transit.station",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#eeeeee"
                }
              ]
            },
            {
              "featureType": "water",
              "elementType": "geometry",
              "stylers": [
                {
                  "color": "#c9c9c9"
                }
              ]
            },
            {
              "featureType": "water",
              "elementType": "labels.text.fill",
              "stylers": [
                {
                  "color": "#9e9e9e"
                }
              ]
            }
          ]
    });

    if (geolocpoint) {
        // Place a marker
        geolocation = new google.maps.Marker({
          position: geolocpoint,
          map: map,
          title: 'Votre position',
          icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
        });
    }
  }

  if (mapEl) { 

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        geolocpoint = new google.maps.LatLng(latitude, longitude);
        showMap();
      });
    } else {
      showMap();
    }



    /*
    var infowindow1 = new google.maps.InfoWindow({
        content: contentString1,
        maxWidth: 300
    });
    
    var marker1 = new google.maps.Marker({
        position: {lat: 44.4459047, lng: 26.0975581},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP
    });
    marker1.addListener('click', function() {
        infowindow1.open(map, marker1);
    });
                                                                
    var infowindow2 = new google.maps.InfoWindow({
        content: contentString2,
        maxWidth: 300
    });
    
    var marker2 = new google.maps.Marker({
        position: {lat: 44.4293472, lng: 26.0532852},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP
    });
    marker2.addListener('click', function() {
        infowindow2.open(map, marker2);
    });
                                                                
    var infowindow3 = new google.maps.InfoWindow({
        content: contentString3,
        maxWidth: 300
    });
    
    var marker3 = new google.maps.Marker({
        position: {lat: 44.4423985, lng: 26.1525885},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP
    });
    
    marker3.addListener('click', function() {
        
    });
                                                                                            
    var infowindow5 = new google.maps.InfoWindow({
        content: contentString5,
        maxWidth: 300
    });
    
    var marker5 = new google.maps.Marker({
        position: {lat: 45.7973317, lng: 24.1503473},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP
    });
    
    marker5.addListener('click', function() {
        infowindow5.open(map, marker5);
    });
                                                                
    var infowindow6 = new google.maps.InfoWindow({
        content: contentString6,
        maxWidth: 300
    });
    
    var marker6 = new google.maps.Marker({
        position: {lat: 42.512851, lng: 27.4542481},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP
    });
    
    marker6.addListener('click', function() {
        infowindow6.open(map, marker6);
    });
                                                                
    var infowindow7 = new google.maps.InfoWindow({
        content: contentString7,
        maxWidth: 300
    });
    
    var marker7 = new google.maps.Marker({
        position: {lat: 42.009269, lng: 24.880208},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP
    });
    
    marker7.addListener('click', function() {
        infowindow7.open(map, marker7);
    });
                                                                
    var infowindow8 = new google.maps.InfoWindow({
        content: contentString8,
        maxWidth: 300
    });

    var marker8 = new google.maps.Marker({
        position: {lat: 42.677157, lng: 26.3185932},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP
    });
    
    marker8.addListener('click', function() {
        infowindow8.open(map, marker8);
    });
                                                                                            
    var infowindow10 = new google.maps.InfoWindow({
        content: contentString10,
        maxWidth: 300
    });
    var marker10 = new google.maps.Marker({
        position: {lat: 42.689812, lng: 23.319506},
        map: map,
        icon: image,
        animation: google.maps.Animation.DROP
    });
    marker10.addListener('click', function() {
        infowindow10.open(map, marker10);
    });
                                                                
    
    var infowindow11 = new google.maps.InfoWindow({
    content: contentString11,
    maxWidth: 300
    });
    var marker11 = new google.maps.Marker({
    position: {lat: 42.6914631, lng: 23.3537868},
    map: map,
    icon: image,
    animation: google.maps.Animation.DROP
    });
    marker11.addListener('click', function() {
    infowindow11.open(map, marker11);
    });
                                                                var infowindow12 = new google.maps.InfoWindow({
    content: contentString12,
    maxWidth: 300
    });
    var marker12 = new google.maps.Marker({
    position: {lat: 42.6604852, lng: 23.3829197},
    map: map,
    icon: image,
    animation: google.maps.Animation.DROP
    });
    marker12.addListener('click', function() {
    infowindow12.open(map, marker12);
    });
                                                                                            var infowindow14 = new google.maps.InfoWindow({
    content: contentString14,
    maxWidth: 300
    });
    var marker14 = new google.maps.Marker({
    position: {lat: 43.085546, lng: 25.637483},
    map: map,
    icon: image,
    animation: google.maps.Animation.DROP
    });
    marker14.addListener('click', function() {
    infowindow14.open(map, marker14);
    });
                                                                var infowindow15 = new google.maps.InfoWindow({
    content: contentString15,
    maxWidth: 300
    });
    var marker15 = new google.maps.Marker({
    position: {lat: 49.1818084, lng: -0.3616732},
    map: map,
    icon: image,
    animation: google.maps.Animation.DROP
    });
    marker15.addListener('click', function() {
    infowindow15.open(map, marker15);
    });
                                                                var infowindow16 = new google.maps.InfoWindow({
    content: contentString16,
    maxWidth: 300
    });
    var marker16 = new google.maps.Marker({
    position: {lat: 48.5388905, lng: 2.6596441},
    map: map,
    icon: image,
    animation: google.maps.Animation.DROP
    });
    marker16.addListener('click', function() {
    infowindow16.open(map, marker16);
    });
                                                                var infowindow17 = new google.maps.InfoWindow({
    content: contentString17,
    maxWidth: 300
    });
    var marker17 = new google.maps.Marker({
    position: {lat: 49.1165331, lng: 6.1749749},
    map: map,
    icon: image,
    animation: google.maps.Animation.DROP
    });
    marker17.addListener('click', function() {
    infowindow17.open(map, marker17);
    });
                                                                var infowindow18 = new google.maps.InfoWindow({
    content: contentString18,
    maxWidth: 300
    });
    var marker18 = new google.maps.Marker({
    position: {lat: 43.6084469, lng: 3.884396},
    map: map,
    icon: image,
    animation: google.maps.Animation.DROP
    });
    marker18.addListener('click', function() {
    infowindow18.open(map, marker18);
    });
                                                                var infowindow19 = new google.maps.InfoWindow({
    content: contentString19,
    maxWidth: 300
    });
    var marker19 = new google.maps.Marker({
    position: {lat: 48.8804712, lng: 2.3922216},
    map: map,
    icon: image,
    animation: google.maps.Animation.DROP
    });
    marker19.addListener('click', function() {
    infowindow19.open(map, marker19);
    });
                                                                var infowindow20 = new google.maps.InfoWindow({
    content: contentString20,
    maxWidth: 300
    });
    var marker20 = new google.maps.Marker({
    position: {lat: 48.8485763, lng: 2.3280552},
    map: map,
    icon: image,
    animation: google.maps.Animation.DROP
    });
    marker20.addListener('click', function() {
    infowindow20.open(map, marker20);
    });
                                                                var infowindow21 = new google.maps.InfoWindow({
    content: contentString21,
    maxWidth: 300
    });
    var marker21 = new google.maps.Marker({
    position: {lat: 43.2970769, lng: -0.3712515},
    map: map,
    icon: image,
    animation: google.maps.Animation.DROP
    });
    marker21.addListener('click', function() {
    infowindow21.open(map, marker21);
    });

    */

    var input = document.getElementById('searchTextField');
    new google.maps.places.Autocomplete(input);
  }

}

function onYouTubeIframeAPIReady() {

    var youtubeEmbedElement = document.getElementById('youtubeEmbed');
    // Get element
    if (youtubeEmbedElement) {

        var player;
        var videoId = youtubeEmbedElement.dataset.videoId;
        var startSeconds = youtubeEmbedElement.dataset.loopStart;
        var endSeconds = youtubeEmbedElement.dataset.loopEnd;

        player = new YT.Player('youtubeEmbed', {
            videoId: videoId, // YouTube Video ID
            playerVars: {
                autoplay: 1, // Auto-play the video on load
                autohide: 1, // Hide video controls when playing
                disablekb: 1,
                controls: 0, // Hide pause/play buttons in player
                showinfo: 0, // Hide the video title
                modestbranding: 1, // Hide the Youtube Logo
                loop: 1, // Run the video in a loop
                fs: 0, // Hide the full screen button
                rel: 0,
                enablejsapi: 1,
                start: startSeconds,
                end: endSeconds,
                mute: 1
            },
            events: {
            onReady: function (e) {
                e.target.mute();
                e.target.playVideo();
            },
            onStateChange: function (e) {
                if (e.data === YT.PlayerState.PLAYING) {
                document.getElementById("youtubeEmbed").classList.add("loaded");
                }

                if (e.data === YT.PlayerState.ENDED) {
                // Loop from starting point
                player.seekTo(startSeconds);
                }
            }
            }
        });
    }
};

var rad = function(x) {
  return x * Math.PI / 180;
};

var getDistance = function(p1, p2) {
  var R = 6378137; // Earth’s mean radius in meter
  var dLat = rad(p2.lat() - p1.lat());
  var dLong = rad(p2.lng() - p1.lng());
  var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(rad(p1.lat())) * Math.cos(rad(p2.lat())) *
    Math.sin(dLong / 2) * Math.sin(dLong / 2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  var d = R * c;
  return d; // returns the distance in meter
};