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
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/lightpick@latest/css/lightpick.css">        
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


        <script src="<?=base_url()?>/dist/vendors/jquery/jquery-3.3.1.min.js"></script>
        <script src="<?=base_url()?>/dist/vendors/jquery-ui/jquery-ui.min.js"></script>
        


        <script src="<?=base_url()?>/dist/vendors/moment/moment.js"></script>
        <script src="<?=base_url()?>/dist/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?=base_url()?>/dist/vendors/slimscroll/jquery.slimscroll.min.js"></script>
        
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script type="text/javascript" src="https://unpkg.com/lightpick@latest/lightpick.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="<?=base_url()?>/dist/vendors/jquery-inputmask/jquery.inputmask.min.js"></script>
        
         
        <!-- END: Page CSS-->  

        <!-- <script src="socket.io.js"></script> -->
        <script>

       /* const $events = document.getElementById('events');
        const newItem = (content) => {
          const item = document.createElement('li');
          item.innerText = content;
          return item;
        };

        const socket = io();

        socket.on('connect', () => {
          $events.appendChild(newItem('connect'));
        });*/

    </script> 

        <!-- START: Include CSS-->
        <?php if(isset($include["head"])){ foreach($include["head"] as $incl){  ?>
                    <link rel="stylesheet" href="<?php echo base_url().$incl?>" />
        <?php } } ?>
        <!-- END: Include Page CSS-->         

        <!-- START: Custom CSS-->
        <link rel="stylesheet" href="<?=base_url()?>/dist/css/main.css">
        <link rel="stylesheet" href="<?=base_url()?>/dist/css/rv.css">
        <!-- END: Custom CSS-->

    </head>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default horizontal-menu">

        <!-- START: Pre Loader  
        <div class="se-pre-con">
            <div class="loader"></div>
        </div>
          END: Pre Loader-->


        <?php $this->load->view('layouts/header'); ?>
        <?php $this->load->view('layouts/menu'); ?>
        
        
        <!-- START: Main Content-->
        <main>
            <div class="container-fluid site-width" style="max-width:100% !important;">  
            <div id="events"></div>                          
                <?php
                        if(isset($include["body"]["template"])){ 
                            foreach($include["body"]["template"] as $incl){ 
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


        <!-- Start Sidebar  -->
        <div id="settings">
            <div class="sidbarchat p-3" id="sidebar-content">
                <!-- Load sidebar content -->
                <?php 
                    if(isset($include["body"]["sidebar"])): 
                        $this->load->view($include["body"]["sidebar"]);
                    endif;
                ?> 
            </div>
        </div> 
        <!-- End Sidebar -->
         
        <!-- START: Template JS-->
        
        
        

    
        <!-- END: Template JS-->

        <!-- START: Include JS -->
        <?php if(isset($include["footer"])){ foreach($include["footer"] as $incl){  ?>                    
                    <script src="<?php echo base_url().$incl?>"></script>
        <?php } } ?>
        <!-- END: Include JS -->

        <!-- START: APP JS-->
        <script src="<?=base_url()?>/dist/js/app.js"></script>
        
        <!-- END: APP JS--> 
        <?php
            if(isset($include["scripts"])){ foreach($include["scripts"] as $incl){  
                $this->load->view($incl);
            } } 

            if(isset($include["scriptend"]) && is_array($include["scriptend"])){ 
                foreach($include["scriptend"] as $incl){ 
                    $this->load->view($incl);
                }
            }  
        ?>  

        <?php if(isset($include["scriptendfile"])){ foreach($include["scriptendfile"] as $incl){  ?>                    
            <script src="<?php echo base_url().$incl?>"></script>
        <?php } } ?> 


    

    </body>
    <!-- END: Body-->
</html> 