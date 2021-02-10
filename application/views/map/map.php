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
<div class="container-fluid "> 
    <!-- START: Card Data-->
    <div class="row">

        <div class="col-2 mt-3">
            <div class="card">
                <!-- ##### TABS ##### -->
                <div class="card-header">                                   
                    <div class="row m-auto">
                        <div class="col-12 col-lg-12 col-xl-12 pr-lg-0 flip-menu ">                                                    
                            <ul class="list-unstyled nav inbox-nav  mb-0 mail-menu" style="margin-top:0px !important;">
                                <li class="nav-item" style="padding: 5px 2px !important;">
                                    <a href="#" data-mailtype="inbox" class="nav-link padding-tab active"> 
                                        <i class="mdi mdi-car font-tab"></i> 
                                        <span class="ml-auto badge badge-pill badge-success bg-success car-num"><?=count($vehicle_list)?></span>
                                    </a>
                                </li>
                                <li class="nav-item" style="padding: 5px 2px !important;">
                                    <a href="#" data-mailtype="sent" class="nav-link padding-tab">
                                        <i class="mdi mdi-map-marker font-tab"></i>
                                        <span class="ml-auto badge badge-pill badge-success bg-success car-num">9</span>
                                    </a>
                                </li> 
                                <li class="nav-item"  style="padding: 5px 2px !important;">
                                    <a href="#" data-mailtype="sent" class="nav-link padding-tab">
                                        <i class="mdi mdi-map-marker-circle font-tab"></i>
                                        <span class="ml-auto badge badge-pill badge-success bg-success car-num">10</span>
                                    </a>
                                </li>                                
                            </ul> 
                        </div>
                    </div>
                </div>
                <!-- END TABS -->

                <!-- ####### VEHICULOS LIST##############  -->
                <div class="card-body p-0">                    
                    <!-- VER VEHICULO -->
                    <div class="view-email">
                                <div class="card-body">
                                    <a href="#" class="bg-primary float-left mr-3  py-1 px-2 rounded text-white back-to-email" >
                                        Back
                                    </a>
                                    <h5 class="view-subject mb-3">Mail Subject</h5>
                                    <div class="media mb-5 mt-5">
                                        <div class="align-self-center">
                                            <img src="dist/images/author1.jpg" alt="" class="img-fluid rounded-circle d-flex mr-3" width="40">
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mb-0 view-author">Jeanette R. Brooks</h6>  
                                            <small class="view-date">Today at 10:31 Pm</small>
                                        </div>
                                    </div>                                    
                                    <p>VehiculoT</p>
                                    <div class="eagle-divider my-3"></div>
                                    <p><i class="fa fa-paperclip pr-2"></i> Información del vehiculo</p>
                                    <div class="row megnify-popup">                                        
                                        <div class="col-12 col-sm-12 col-xl-12">
                                            <div class="card eagle-border-light text-center">
                                                <a class="btn-gallery" href="dist/images/post2.jpg"><img src="dist/images/post2.jpg" alt="" class="img-fluid rounded-top"></a>
                                                <div class="card-body py-2">
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>

                    <!-- Busqueda -->
                    <div class="card-header border-bottom p-2 d-flex">
                                    <a href="#" class="d-inline-block d-lg-none flip-menu-toggle"><i class="icon-menu"></i></a>
                                    <input type="text" class="form-control border-0  w-100 h-100 mail-search" placeholder="Search ...">
                    </div>         


                    <!--  VEHICULO MENU LISTADO-->
                    <div class="row m-0 border-bottom theme-border">
                            <div class="col-12 px-2 py-3 d-flex mail-toolbar">
                                <div class="check d-inline-block mr-3">
                                    <label class="chkbox">All
                                        <input name="all" value="" type="checkbox" class="checkall">
                                        <span class="checkmark"></span>
                                    </label>
                                </div> 

                                <!-- Filtrar por Etiquetas -->
                                <a href="#" class="ml-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-bell"></i></a>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-right bulk-mail-type">
                                    <a class="dropdown-item" href="#" data-mailtype="business-mail" ><span class="dot bg-primary"></span>  Motocicleta </a>
                                    <a class="dropdown-item" href="#" data-mailtype="private-mail"><span class="dot bg-danger"></span> Automovil </a>
                                    <a class="dropdown-item" href="#" data-mailtype="personal-mail"><span class="dot bg-success"></span> Truck </a>
                                    <a class="dropdown-item" href="#" data-mailtype="social-mail"><span class="dot bg-warning"></span> Custodios </a>
                                </div>
                                
                                <a href="#" class="bulk-star"><i class="icon-star"></i></a>  
                                
                                <div>
                                    <a href="#" class="mr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical"></i></a>
                                    <div class="dropdown-menu p-0 m-0 dropdown-menu-right mail-bulk-action">
                                        <a class="dropdown-item mailread" href="#" ><i class="icon-book-open"></i> Marcar </a>
                                        <a class="dropdown-item mailunread" href="#"><i class="icon-notebook"></i> Eliminar </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete" href="#"  data-toggle="modal" data-target="#exampleModalCenter"><i class="icon-trash"></i>  Nuevo Sitio </a>
                                        <a class="dropdown-item delete" href="#"  data-toggle="modal" data-target="#exampleModalCenter"><i class="icon-trash"></i>  Nueva Ruta </a>
                                        <a class="dropdown-item delete" href="#"  data-toggle="modal" data-target="#exampleModalCenter"><i class="icon-trash"></i>  Nueva Geocerca </a>
                                    </div>
                                </div> 


                            </div>
                    </div>


                    <div class="scrollertodo">  <!-- LISTADO VEHICULOS -->
                        <ul class="mail-app list-unstyled">                        
                            <!-- ITEMS -->
                            <!--
                                <i class="mdi mdi-speedometer"></i>
                                <i class="mdi mdi-power-standby"></i>
                                <i class="mdi mdi-power-plug-off"></i>
                                <i class="mdi mdi-power-plug"></i>
                                <i class="mdi mdi-map-marker"></i>
                                <i class="mdi mdi-map-marker-off"></i>
                                <i class="mdi mdi-car-pickupr"></i>
                                <i class="mdi mdi-car-pickupr"></i>
                                <i class="mdi mdi-camera-timer"></i>
                                mdi mdi-gauge-empty
                            -->                            
                            <?php foreach($vehicle_list as $v){ ?>
                            <?php if($v->ID_VEH != ""){ ?>
                            <li class="py-1 px-2 mail-item inbox sent starred">
                                <div class="d-flex align-self-center align-middle">
                                    <label class="chkbox">
                                        <input type="checkbox" >
                                        <span class="checkmark small"></span>
                                    </label>
                                    <div class="mail-content d-md-flex w-100">                                                    
                                        <span class="car-name"><?=$v->ID_VEH?></span>                                                     
                                        <div class="d-flex mt-3 mt-md-0 ml-auto">

                                            <div class="h6 primary mdi mdi-power-plug"></div>
                                            <div class="h6 primary mdi mdi-speedometer"></div>
                                            <div class="h6 primary mdi mdi-map-marker"></div>

                                            <a href="#" class="ml-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-options-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                                                <a class="dropdown-item single-read" href="#" ><i class="icon-book-open"></i> Marcar </a>
                                                <a class="dropdown-item single-unread" href="#"  data-toggle="modal" data-target="#exampleModalCenter"><i class="icon-notebook"></i> Editar </a>                                                
                                                <a class="dropdown-item single-read" href="#" ><i class="icon-book-open"></i> Configurar </a>
                                                <a class="dropdown-item single-delete" href="#"><i class="icon-trash"></i> Eliminar </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li> 
                            <?php } } ?>
                            <!--ITEMS  -->
                        </ul>
                    </div> <!-- LISTADO VEHICULOS -->

                </div>

            </div>  <!-- End card-->              
        </div> <!-- END col-2 -->


        <div class="col-10 mt-3">
            <div class="row">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d59725.23520802217!2d-103.3863168!3d20.676608!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2smx!4v1611010700088!5m2!1ses-419!2smx" width="100%" height="690px" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>                            
            </div>
        </div>        
                    
                    
    </div>
</div>                            