<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAvvCDspsox0cIcm7N5XsVFhS6tFE1rR0LV4ryqT8iCO2IKV5WVRQulNHiecDW7ym88gDAMrEGrAt4UQ"
      type="text/javascript"></script>-->
<!--<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAvvCDspsox0cIcm7N5XsVFhSD6fwXvyiVv52eBtZsNLpj7UPYtxQ3ajMFGTQXxAE-duIYN_EZu-JIMg"
      type="text/javascript"></script>-->
<!--<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;false=true&amp;key=ABQIAAAAjK1Xov_mfHfZmmlIRrNh4RS6tFE1rR0LV4ryqT8iCO2IKV5WVRRuggmx9p6HiLmoeJulFgJrVKX6IQ" type="text/javascript"></script>--> <!--www.sepromex.com.mx-->
<!--<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAjK1Xov_mfHfZmmlIRrNh4RR0aDMuaRqYj2Z6f2o1nHwVv9XrYxTQjD25Jb_61omuLoMIvaI58zu63Q" type="text/javascript"></script>--> <!--http://egweb.seprosat.mx-->
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAjK1Xov_mfHfZmmlIRrNh4RQ5CEXRpWs9mIsCiSd5qkw2giD0jRSaMjjFkrJg-DCOiu8iJaSwhy8HSQ" type="text/javascript"></script> <!--http://egweb.seprosat.com.mx     -->
<script>
    function load() {
      if (GBrowserIsCompatible()) {
		client = new GStreetviewClient();
        map = new GMap2(document.getElementById("cont_mapa"));
		var customUI = map.getDefaultUI();
		map.setUI(customUI);
		map.setCenter(new GLatLng(21.9518, -100.9397), 5);
		map.enableContinuousZoom();
		var icono = new GIcon();
   		icono.image = "./img/inicio.png";
	    icono.iconSize = new GSize(15, 16);
   		icono.iconAnchor = new GPoint(15, 16);
		marca = new GMarker(new GLatLng(0,0),icono);
		map.addOverlay(marca);
      }
    }
</script>
</head>
<body id="fondo" onload="load();" onunload="GUnload()">
<center>

    <div id="cont_mapa" style="width:596px; height:460px;"></div>
 
</center>
</body>
</html>