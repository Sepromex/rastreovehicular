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
</div> <!--  Detalle del vehiculo  --> 

<!--  Busqueda  -->
<div class="card-header border-bottom p-2 d-flex">
    <a href="#" class="d-inline-block d-lg-none flip-menu-toggle"><i class="icon-menu"></i></a>
    <input type="text" class="form-control border-0  w-100 h-100 vehicle-search" placeholder="Search ...">
</div>

<!--  VEHICULO MENU LISTADO  -->
<div class="row m-0 border-bottom theme-border">
        <div class="col-12 px-2 py-3 d-flex mail-toolbar">
            <div class="check d-inline-block mr-3">
                <label class="chkbox">All 
                    <input name="all" value="" type="checkbox" class="checkall">
                    <span class="checkmark"></span>
                </label>
            </div> 

            <!-- Filtrar por Etiquetas -->
            <a href="#" class="ml-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-speedometer"></i></a>
            <div class="dropdown-menu p-0 m-0 dropdown-menu-right bulk-mail-type">
                <a class="dropdown-item" href="#" data-speed="speed-blue">Todas las velocidades</a>
                <a class="dropdown-item" href="#" data-speed="speed-blue"><span class="dot bg-primary"></span> Detenido</a>
                <a class="dropdown-item" href="#" data-speed="speed-green"><span class="dot bg-success"></span> Minima</a>                
                <a class="dropdown-item" href="#" data-speed="speed-yellow"><span class="dot bg-warning"></span> Normal</a>
                <a class="dropdown-item" href="#" data-speed="speed-orange"><span class="dot bg-orange"></span> Regular</a>
                <a class="dropdown-item" href="#" data-speed="speed-red"><span class="dot bg-danger"></span> Máxima</a>
            </div>
            
            <!-- <a href="#" class="bulk-star"><i class="icon-star"></i></a>  
            
            <div>
                <a href="#" class="mr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical"></i></a>
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right mail-bulk-action">
                    <a class="dropdown-item mailread" href="#" ><i class="icon-book-open"></i> Marcar </a>
                    <a class="dropdown-item mailunread" href="#"><i class="icon-notebook"></i> Eliminar </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item delete" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="icon-trash"></i>  Nuevo Sitio </a>
                    <a class="dropdown-item delete" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="icon-trash"></i>  Nueva Ruta </a>
                    <a class="dropdown-item delete" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="icon-trash"></i>  Nueva Geocerca </a>
                </div>
            </div> 
             -->


        </div>
</div>


<div class="scrollertodo">  <!-- LISTADO VEHICULOS -->
    <ul class="mail-app list-unstyled" id="vehicles_list"> 

    <li class="py-1 px-2 mail-item inbox sent starred">
        <div class="d-flex align-self-center align-middle">
            <label class="chkbox">
                <input type="checkbox" >
                <span class="checkmark small"></span>
            </label>
            <div class="mail-content d-md-flex w-100">                                                    
                <span class="car-name">Vehiculo</span>                                                     
                <div class="d-flex mt-3 mt-md-0 ml-auto">

                    <div class="h6 primary mdi mdi-power-plug"></div>
                    
                    <div class="speed-icon">
                        <img style="width:100%;" src="/dist/images/config/vehicles/speed_red.png" alt="">
                    </div>
                    
                    <div class="h6 primary mdi mdi-map-marker"></div>

                    <a href="#" class="ml-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-options-vertical"></i>
                    </a>
                    <!--<div class="dropdown-menu p-0 m-0 dropdown-menu-right"></div>-->
                </div>
            </div>
        </div>
    </li> 

    
        <!-- ITEMS <div id="vehicles_list"></div> --> 
    </ul>
</div> <!-- LISTADO VEHICULOS -->