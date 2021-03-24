<h5 class="view-subject mb-3"><?=$vehicle["id_veh"]?></h5>
<div class="media mb-5 mt-5">
    <div class="align-self-center">
        <img src="dist/images/map/veh/vehicle.png" alt="" class="img-fluid rounded-circle d-flex mr-3" width="40">
    </div>
    <div class="media-body">
        <h6 class="mb-0 view-author"><?=$vehicle["sistemadesc"]?></h6>  
        <small class="view-date"><?=$vehicle["tipoequipo"]?></small>
    </div>
</div>                                    
<p><?=($vehicle["empresanom"]!="")?"Empresa: ".$vehicle["empresanom"]:""?></p>
<div class="eagle-divider my-3"></div>

<?php ($vehicle["modelo"]!="")?'<p><i class="fa fa-paperclip pr-2"></i> Modelo: '.$vehicle["modelo"].'</p>':''; ?>
<?php ($vehicle["placas"]!="")?'<p><i class="fa fa-paperclip pr-2"></i> Placas: '.$vehicle["placas"].'</p>':''; ?>
<?php ($vehicle["MARCA"]!="")?'<p><i class="fa fa-paperclip pr-2"></i> Marca: '.$vehicle["MARCA"].'</p>':''; ?>
<?php ($vehicle["COLOR"]!="")?'<p><i class="fa fa-paperclip pr-2"></i> Color: '.$vehicle["COLOR"].'</p>':''; ?>
<?php ($vehicle["detalle"]!="")?'<p> '.$vehicle["detalle"].'</p>':''; ?>


<?php $photo = ($vehicle["FOTO"] != "")?$vehicle["FOTO"]:"default.png"; ?>
<div class="row megnify-popup">
    <div class="col-12 col-sm-12 col-xl-12">
        <div class="card eagle-border-light text-center">
            <a class="btn-gallery" href="#">
                <img src="dist/images/map/veh/detail_veh/<?=$photo?>" alt="" class="img-fluid rounded-top"></a>             
        </div>
    </div>
</div> 

<?php /* print_array($vehicle); 
        (
            [num_veh] => 26
            [id_veh] => 26-Portman Telcel
            [ID_SISTEMA] => 26
            [ID_EMPRESA] => 15
            [ID_FLOTILLA] => 0
            [TIPOVEH] => 3
            [ESTATUS] => 99
            [economico] => 26
            [placas] => 
            [modelo] => COLABORADOR 26
            [detalle] =>    
            [MARCA] => 
            [COLOR] => 
            [estatus_desc] => 90 - Utilizado por Sistemas
            *[sistemadesc] => 26-Portman Telcel
            *[empresanom] => SERVICIOS ESPECIALES DE PROTECCION EN MEXICO SA DE CV
            *[tipoequipo] => Spider
        )  */
?>