<!DOCTYPE html>
<html lang="en">
    <!-- START: Head-->
    <head>
        <meta charset="UTF-8">
        <title><?=$custom["title"]?></title>
        <link rel="shortcut icon" href="<?=base_url()?>/dist/images/favicon.ico" />
        <meta name="viewport" content="width=device-width,initial-scale=1">         
        <!-- START: Template CSS-->
        <link rel="stylesheet" href="<?=base_url()?>/dist/vendors/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url()?>/dist/vendors/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?=base_url()?>/dist/vendors/jquery-ui/jquery-ui.theme.min.css">
        <link rel="stylesheet" href="<?=base_url()?>/dist/vendors/simple-line-icons/css/simple-line-icons.css">        
        <link rel="stylesheet" href="<?=base_url()?>/dist/vendors/flags-icon/css/flag-icon.min.css">        
        <link rel="stylesheet" href="<?=base_url()?>/dist/vendors/materialdesign-webfont/css/materialdesignicons.min.css">        
        <!-- END Template CSS-->       
        
        <!-- START: Page CSS-->   
        <link rel="stylesheet" href="<?=base_url()?>/dist/vendors/morris/morris.css"> 
        <link rel="stylesheet" href="<?=base_url()?>/dist/vendors/weather-icons/css/pe-icon-set-weather.min.css">  
        <link rel="stylesheet" href="<?=base_url()?>/dist/vendors/starrr/starrr.css"> 
        <link rel="stylesheet" href="<?=base_url()?>/dist/vendors/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="<?=base_url()?>/dist/vendors/ionicons/css/ionicons.min.css">  

        <style>
    .mail-app li .car-name{
        min-width:120px;
        font-size: .55rem;
    }
    .car-num{
        position: relative;
        top: 10px;
        left: -12px !important;
    }
    .font-tab{ font-size: 1.55rem !important; }
    .padding-tab{ padding: .5rem .6rem !important; }
</style>
        
    </head>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default horizontal-menu">
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width" style="max-width:100% !important;">  
            <div id="events"></div>                          
                <!-------------------    CONTENIDO  ----------------------->


                <!-------------------    CONTENIDO  ----------------------->
            </div>   
        </main>
        <!-- END: Content--> 

         
        <!-- START: Template JS-->
        <script src="<?=base_url()?>/dist/vendors/jquery/jquery-3.3.1.min.js"></script>
        <script src="<?=base_url()?>/dist/vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?=base_url()?>/dist/vendors/moment/moment.js"></script>
        <script src="<?=base_url()?>/dist/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?=base_url()?>/dist/vendors/slimscroll/jquery.slimscroll.min.js"></script> 
        <script src="<?=base_url()?>/dist/js/app.js"></script>
         
         
    </body>
    <!-- END: Body-->
</html> 



<div class="container-fluid "> 
    <!-- START: Card Data-->
    <div class="row">

        <?php  $this->load->view("map/lateral"); ?>

        
        
        <div class="col-10 mt-3" id="fondo" onunload="" onload="xajax_mostrar_vehiculos_act();tiempo_1();tiempo(<? echo (int) $idu;?>,1,1);crear_live(<? echo (int)$idu;?>);xajax_cont_dias();xajax_user_live();load();cache_actualizado();xajax_opciones();">
            <div class="row">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d59725.23520802217!2d-103.3863168!3d20.676608!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2smx!4v1611010700088!5m2!1ses-419!2smx" width="100%" height="690px" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>                            
            </div>
        </div>        
                    
                    
    </div>
</div>                            





<script>

            var timerID = 0;
            var map,marca,marker,sitios;
            var elim_sitio = new Array();
            var makingQuery = false;
            var markersArrays=new Array();
            var directionsService;
            var directionsDisplay;
            var childwindows = new Array();


        function load() { 
            directionsService = new google.maps.DirectionsService();
            directionsDisplay = new google.maps.DirectionsRenderer();
            //alert(directionsService);
            
            var myOptions = {
                    zoom:5,
                    center: new google.maps.LatLng(21.9518,-100.9397),
                    streetViewControl: true,//true= "monito"
                    disableDoubleClickZoom:true,
                    overviewMapControl:true,
                    panControl: true,
                    zoomControl: true,
                    zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.SMALL
                    },
                    scaleControl: true,
                    scaleControlOptions: {
                        position: google.maps.ControlPosition.LEFT_CENTER
                    },
                    mapTypeId:google.maps.MapTypeId.ROADMAP
            };
            
            map=new google.maps.Map(document.getElementById('cont_mapa'),myOptions);
            directionsDisplay.setMap(map);
        }



        //var directionDisplay;
			//var directionsService;
			var map;
			var origin = null;
			var destination = null;
			var inter = null;
			var waypoints = [];
			var markers = [];
			var markers_rutas = [];
			var directionsVisible = false;
			var currentId = 0;
			var uniqueId = function() {
				return ++currentId;
			} 
			function del_punto(idp) {
				for (var i = 0; i < markers_rutas.length; i++) {
					if(markers_rutas[i].id==idp){
						markers_rutas[i].setMap(null);
					}
				}
			}
			function set_inicio(lat,lon){
				origin=new google.maps.LatLng(lat,lon);
				var latlng=new google.maps.LatLng(lat,lon);
				markers.push(new google.maps.Marker({
					position: latlng, 
					map: map,
					icon: "http://maps.google.com/mapfiles/marker" + String.fromCharCode(markers.length + 65) + ".png"
				})); 
			}
			function set_fin(lat,lon){
				destination =new google.maps.LatLng(lat,lon);
				waypoints.push({ location: destination, stopover: true });
				markers.push(new google.maps.Marker({
					position: destination, 
					map: map,
					icon: "http://maps.google.com/mapfiles/marker" + String.fromCharCode(markers.length + 65) + ".png"
				}));
			}
			function set_inter(lat,lon){
				destination =new google.maps.LatLng(lat,lon);
				waypoints.push({ location: destination, stopover: true });
				markers.push(new google.maps.Marker({
					position: destination, 
					map: map,
					icon: "http://maps.google.com/mapfiles/marker" + String.fromCharCode(markers.length + 65) + ".png"
				}));
			}
			function calcRoute() {
				var directionsService = new google.maps.DirectionsService();
				if (origin == null) {
					alert("No hay inicio");
					return;
				}
				if (destination == null) {
					alert("no hay fin");
					return;
				}
				var mode;
				//switch (document.getElementById("mode").value){
				switch ("driving"){
					case "bicycling":
					mode = google.maps.DirectionsTravelMode.BICYCLING;
					break;
					case "driving":
					mode = google.maps.DirectionsTravelMode.DRIVING;
					break;
					case "walking":
					mode = google.maps.DirectionsTravelMode.WALKING;
					break;
				}
				var request = {
					origin: origin,
					destination: destination,
					waypoints: waypoints,
					travelMode: mode,
					optimizeWaypoints: document.getElementById('optimize').checked,
					avoidHighways: document.getElementById('highways').checked,
					avoidTolls: document.getElementById('tolls').checked
				};
				directionsService.route(request, function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) {
						directionsDisplay.setDirections(response);
					}
				});
				clearMarkers();
				directionsVisible = true;
				nC('#directionsPanel').dialog('open');
			}
			  
			function updateMode() {
				if (directionsVisible) {
					calcRoute();
				}
			}
			  
			function clearMarkers() {
				for (var i = 0; i < markers.length; i++) {
					markers[i].setMap(null);
				}
				for (var i = 0; i < markers_rutas.length; i++) {
					markers_rutas[i].setMap(null);
				}
			}
			  
			  function clearWaypoints() {
			    markers = [];
			    origin = null;
			    destination = null;
			    waypoints = [];
			    directionsVisible = false;
			  }
			  
			  function reset() {
				var rendererOptions = {
					draggable: true
				};
			    clearMarkers();
			    clearWaypoints();
			    directionsDisplay.setMap(null);
			    directionsDisplay.setPanel(null);
			    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
			    directionsDisplay.setMap(map);
			    directionsDisplay.setPanel(document.getElementById("directionsPanel"));    
				nC("#fin_ruta").attr("disabled",false);
				nC("#inicio_ruta").attr("disabled",false);
				nC("#r_inicio").html('');
				nC("#r_inter").html('');
				nC("#r_fin").html('');
			  }
			 function clear_ruta(){
				nC("#inicio_ruta").val(0);
				nC("#inter_ruta").val(0);
				nC("#fin_ruta").val(0);
			  }
			function mostrar_inter(){
				if(nC("#intermedios").is(":checked")){
					nC("#los_intermedios").fadeIn('slow');
					if(nC("#fin_ruta").val()!='0,0' && nC("#inicio_ruta").val()!='0,0'){
						//waypoints.pop();
					}
				}
				else{
					nC("#los_intermedios").fadeOut('slow');
				}
			}

			  var cambia_noticia;
			function cambiar_noticia(siguiente){
				cambia_noticia=setTimeout(function(){xajax_mostrar_otros(siguiente);/*xajax_alertas_pendietnes();*/},30000);
			}
			function c_noticia(){
				clearTimeout(cambia_noticia);
			}
			function mandar_ruta(){
				var puntos_ruta = Array();
				var puntos=nC("[name=los_puntos]");
				if(puntos.length>=2){
					for(i=0;i<puntos.length;i++){
						puntos_ruta.push(puntos[i].value);
					}
					xajax_procesar_ruta(puntos_ruta);
				}
				else{
					alert("Se necesitan al menos 2 puntos (inicio y fin)");
				}
			}
        </script>
