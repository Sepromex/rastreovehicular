<?php function b_url(){ echo ""; } ?>
<!DOCTYPE html>
<html lang="en">
    <!-- START: Head-->
    <head>
        <meta charset="UTF-8">
        <title>EGWEB</title>
        <link rel="shortcut icon" href="<?=b_url()?>/dist/images/favicon.ico" />
        <meta name="viewport" content="width=device-width,initial-scale=1">         
        <!-- START: Template CSS-->
        <link rel="stylesheet" href="<?=b_url()?>/dist/vendors/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=b_url()?>/dist/vendors/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="<?=b_url()?>/dist/vendors/jquery-ui/jquery-ui.theme.min.css">
        <link rel="stylesheet" href="<?=b_url()?>/dist/vendors/simple-line-icons/css/simple-line-icons.css">        
        <link rel="stylesheet" href="<?=b_url()?>/dist/vendors/flags-icon/css/flag-icon.min.css">        
        <link rel="stylesheet" href="<?=b_url()?>/dist/vendors/materialdesign-webfont/css/materialdesignicons.min.css"> 
        <!-- END Template CSS-->       

        <!-- START: Page CSS-->   
        <link rel="stylesheet" href="<?=b_url()?>/dist/vendors/morris/morris.css"> 
        <link rel="stylesheet" href="<?=b_url()?>/dist/vendors/weather-icons/css/pe-icon-set-weather.min.css">  
        <link rel="stylesheet" href="<?=b_url()?>/dist/vendors/starrr/starrr.css"> 
        <link rel="stylesheet" href="<?=b_url()?>/dist/vendors/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="<?=b_url()?>/dist/vendors/ionicons/css/ionicons.min.css">  
        <!-- END: Page CSS--> 
        <script src="socket.io.js"></script>
        <script>
        const $events = document.getElementById('events');

        const newItem = (content) => {
          const item = document.createElement('li');
          item.innerText = content;
          return item;
        };

        const socket = io();

        socket.on('connect', () => {
          $events.appendChild(newItem('connect'));
        });

    </script>


        <!-- START: Include CSS-->
        <?php if(isset($include["head"])){ foreach($include["head"] as $incl){  ?>
                    <link rel="stylesheet" href="<?=$incl?>" />
        <?php } } ?>
        <!-- END: Include Page CSS-->         

        <!-- START: Custom CSS-->
        <link rel="stylesheet" href="<?=b_url()?>/dist/css/main.css">
        <!-- END: Custom CSS-->

    </head>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default horizontal-menu">

        <!-- START: Pre Loader -->
        <div class="se-pre-con">
            <div class="loader"></div>
        </div>
        <!-- END: Pre Loader-->


        <?php $this->load->view('layouts/header'); ?>
        <?php $this->load->view('layouts/menu'); ?>
        
        
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width" style="max-width:100% !important;">  
            <div id="events"></div>              
                <?php 
                        if(isset($include["body"])){ 
                            foreach($include["body"] as $incl){ 
                                $this->load->view($incl);
                            } 
                        }
                ?>
            </div>

                    

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1" aria-hidden="true">
                        <div class="modal-dialog" role="document" style="position: absolute;right: 0px;top: 0px;margin-top: 0;margin-bottom: 0; height: 100%; width:450px;">                                        
                            <div class="modal-content" style="height: 100%;">
                                <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLongTitle1">Configuración de Vehiculos</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" >
                                <form>
                                                <div class="form-row">
                                                        <label for="inputPassword4">Nombre</label>
                                                        <input type="text" class="form-control" id="inputPassword4" placeholder="Nombre">
                                                    
                                                </div>
                                                <div class="form-row">
                                                        <label for="inputPassword4">Identificador</label>
                                                        <input type="text" class="form-control" id="inputPassword4" placeholder="Identificador">
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputAddress1">Modelo</label>
                                                    <input type="text" class="form-control" id="inputAddress" placeholder="Modelo">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputAddress2">Placas</label>
                                                    <input type="text" class="form-control" id="inputAddress" placeholder="Placas">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputAddress3">Número</label>
                                                    <input type="text" class="form-control" id="inputAddress" placeholder="Número">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputAddress">Detalle</label>
                                                    <input type="text" class="form-control" id="inputAddress" placeholder="Detalle">
                                                </div> 

                                                
                                            </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </div>
                        </div>
                    </div>

        </main>
        <!-- END: Content-->

        <?php $this->load->view('layouts/footer'); ?>

        <!-- START: Template JS-->
        <script src="<?=b_url()?>/dist/vendors/jquery/jquery-3.3.1.min.js"></script>
        <script src="<?=b_url()?>/dist/vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?=b_url()?>/dist/vendors/moment/moment.js"></script>
        <script src="<?=b_url()?>/dist/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>    
        <script src="<?=b_url()?>/dist/vendors/slimscroll/jquery.slimscroll.min.js"></script>
        <!-- END: Template JS-->

        <!-- START: Include CSS-->
        <?php if(isset($include["foot"])){ foreach($include["foot"] as $incl){  ?>                    
                    <script src="<?=$incl?>"></script>
        <?php } } ?>
        <!-- END: Include Page CSS-->     


        <!-- START: APP JS-->
        <script src="<?=b_url()?>/dist/js/app.js"></script>
        <!-- END: APP JS-->


        <!-- START: Page JS-->
        <?php // $this->renderSection('pagescript') ?>


        <!-- START: Page Vendor JS-->
        
        <!-- END: Page Vendor JS-->


        <!-- END: Page JS-->  


    </body>
    <!-- END: Body-->
</html>
