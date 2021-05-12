<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Control Initialization</title>
    <!--<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAvvCDspsox0cIcm7N5XsVFhS6tFE1rR0LV4ryqT8iCO2IKV5WVRQulNHiecDW7ym88gDAMrEGrAt4UQ" type="text/javascript"></script>-->
	<!--<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAjK1Xov_mfHfZmmlIRrNh4RS6tFE1rR0LV4ryqT8iCO2IKV5WVRRuggmx9p6HiLmoeJulFgJrVKX6IQ" type="text/javascript"></script>-->
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAjK1Xov_mfHfZmmlIRrNh4RS6tFE1rR0LV4ryqT8iCO2IKV5WVRRuggmx9p6HiLmoeJulFgJrVKX6IQ" type="text/javascript"></script>

	<script type="text/javascript">
    //<![CDATA[

    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"),
            { size: new GSize(640,320) } );
        map.setCenter(new GLatLng(42.366662,-71.106262), 11);
        var customUI = map.getDefaultUI();
        // Remove MapType.G_HYBRID_MAP
        customUI.maptypes.hybrid = false;
        map.setUI(customUI);
      }
    }
    //]]>
    </script>
  </head>

  <body onload="initialize()" onunload="GUnload()">
    <div id="map_canvas" style="width: 640px; height: 320px"></div>
  </body>
</html>
