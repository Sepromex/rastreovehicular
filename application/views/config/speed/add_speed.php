
<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i> Nueva Configuración 
    </h5>     
    <i class="icon-close icons openside reset_form h3" data-reset="reset_speed"></i>     
</div> 

<form class="needs-validation" id="veh_configform" method="POST" novalidate>
    <input type="hidden" name="speed_id" id="speed_id" value="<?=(isset($veh_id))?$veh_id:0?>">
    <div class="modal-body h-100">    
        
        <div class="form-row">            
            <h6><?=(isset($veh_id))?"Vehiculo: ".$veh_id:""?></h6>
        </div>

    
        <div class="form-row  mb-3">
            <div class="form-group col-md-2">                
                <div class="input-group-prepend">                         
                    <img style="width:70%;" src="/dist/images/config/vehicles/speed_blue.png" alt="">
                </div>
            </div>
            <div class="form-group col-md-10">            
                <label for="newv_model" class="col-form-label">Vehiculo Detenido</label>
            </div>    
        </div>



       

        <div class="form-row">            
            <label for="speed_min" class="col-form-label">Mínima</label>             
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="input-group-prepend">                         
                    <img style="width:70%;" src="/dist/images/config/vehicles/speed_green.png" alt="">
                </div> 
            </div>
            <div class="form-group col-md-10">            
                <input type="number" onblur="min_vel()" value="<?=(isset($speed["vel1"]))?$speed["vel1"]:'45'?>" name="speed_min" id="speed_min" class="form-control inputnumber" required="" > 
            </div>       
        </div> 

                
        <div class="form-row">            
            <label for="speed_normal" class="col-form-label">Normal</label>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="input-group-prepend">                         
                    <img style="width:70%;" src="/dist/images/config/vehicles/speed_yellow.png" alt="">
                </div>
            </div>
            <div class="form-group col-md-10">            
                <input type="number" onblur="normal_vel()" value="<?=(isset($speed["vel2"]))?$speed["vel2"]:'70'?>" name="speed_normal" id="speed_normal" class="form-control inputnumber" required="" > 
            </div>  
        </div>
        
        
        <div class="form-row">            
            <label for="speed_regular" class="col-form-label">Regular</label>            
        </div>       
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="input-group-prepend">                         
                    <img style="width:70%;" src="/dist/images/config/vehicles/speed_orange.png" alt="">
                </div>
            </div>
            <div class="form-group col-md-10">            
                <input type="number"  onblur="regular_vel()"  value="<?=(isset($speed["vel3"]))?$speed["vel3"]:'99'?>" name="speed_regular" id="speed_regular" class="form-control inputnumber" required="" > 
            </div>    
        </div>  
               
        
        <div class="form-row">            
            <label for="speed_max" class="col-form-label">Máxima</label>          
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <div class="input-group-prepend">                         
                    <img style="width:70%;" src="/dist/images/config/vehicles/speed_red.png" alt="">
                </div>
            </div>
            <div class="form-group col-md-10">            
                <input type="number" onblur="max_vel()"  value="<?=(isset($speed["vel3"]))?$speed["vel3"]:'100'?>" name="speed_max" id="speed_max" class="form-control inputnumber" required="" > 
            </div>             
        </div> 
 
           
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside reset_form">Cancelar</button>
        <!-- <button type="button" id="btn_addspeed" class="btn btn-primary" onclick="validate_form('speed_newform','new')">Agregar Velocidad</button> -->
        <button type="button" id="btn_editpeed" class="btn btn-primary" onclick="validate_form('veh_configform','config')">Editar Velocidad</button>
    </div>
</form>  
<script>
 
   

    
 

    
    
 
</script>