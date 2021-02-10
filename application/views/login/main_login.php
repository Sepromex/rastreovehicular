<!DOCTYPE html>
<html lang="en">
    <!-- START: Head-->
    <head>
        <meta charset="UTF-8">
        <title><?=$custom["title"]?></title>
        <link rel="shortcut icon" href="/dist/images/favicon.ico" />
        <meta name="viewport" content="width=device-width,initial-scale=1"> 

        <!-- START: Template CSS-->
        <link rel="stylesheet" href="/dist/vendors/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/dist/vendors/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="/dist/vendors/jquery-ui/jquery-ui.theme.min.css">
        <link rel="stylesheet" href="/dist/vendors/simple-line-icons/css/simple-line-icons.css">        
        <link rel="stylesheet" href="/dist/vendors/flags-icon/css/flag-icon.min.css"> 

        <!-- END Template CSS-->     

        <!-- START: Page CSS-->   
        <link rel="stylesheet" href="/dist/vendors/social-button/bootstrap-social.css"/>   
        <!-- END: Page CSS-->

        <!-- START: Custom CSS-->
        <link rel="stylesheet" href="/dist/css/main.css">
        <!-- END: Custom CSS-->
    </head>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default">
        <!-- START: Main Content-->
        <div class="container">
            <div class="row vh-100 justify-content-between align-items-center">
                <div class="col-12">
                    <?php $this->load->view($custom["form"]); ?>
                </div>
                <div class="col-12">
                <p style="font-size:15px;" class="my-3 text-muted text-center">Si tiene dudas, comentarios o sugerencias llámenos al <span> (33 38255200) ext. 104 </span>, o bien envíe un email a <span>monitoreo_gps@sepromex.com.mx.</span></p>
                </div>

            </div>
        </div>
        <!-- END: Content-->

        <!-- START: Template JS-->
        <script src="/dist/vendors/jquery/jquery-3.3.1.min.js"></script>
        <script src="/dist/vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="/dist/vendors/moment/moment.js"></script>
        <script src="/dist/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>    
        <script src="/dist/vendors/slimscroll/jquery.slimscroll.min.js"></script>
        <script>
            function login() {
                jQuery.ajax({
                    type: "POST",
                    data: $("#login_form").serialize(),
                    url: "Login/start",
                    success: function (response) {
                        if (response == "true") {
                             window.location.href = "MainMap";
                        } else {                            
                            alert("Error: Usuario o contraseña incorrecto.");
                        }
                    }
                });
            };       
            
            function recuperar() {
                jQuery.ajax({
                    type: "POST",
                    data: $("#login_form").serialize(),
                    url: "/Login/SendRecovery",
                    success: function (response) {
                        console.log(response);
                        if (response == "true") {
                             alert("Te enviamos un correo electrónico de recuperación");
                             window.location.href = "/Login";
                             
                        } else {                            
                            alert("Error: Email no registrado en la DB.");
                        }
                    }
                });
            };
        
        </script>

        <!-- END: Template JS-->  
    </body>
    <!-- END: Body-->
</html>
