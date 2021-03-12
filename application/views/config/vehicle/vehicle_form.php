<!-- START: Card Data-->
<div class="row mt-3">        
    <div class="col-xl-12">
        <div class="card">
            <form method="POST" id="veh_configform">
                <div class="card-header d-flex justify-content-between align-items-center">                                
                    <h4 class="card-title">Datos Generales</h4>
                    <div class="align-self-center ml-auto text-center text-sm-right">  
                        <button type="button" class="btn btn-danger reset_form" data-reset="reset_user" onclick="general_formtoggle()">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="velidate_form('veh_configform')">Editar Vehiculo</button>
                    </div>
                </div>
 
                <div class="card-body">     
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label><b>ID:</b></label>
                            <label id="conf_vehidlabel"><?=(isset($vehicle["id_vehiculo"]))?$vehicle["id_vehiculo"]:''?></label>
                            <input type="hidden" value="<?=(isset($vehicle["id_vehiculo"]))?$vehicle["id_vehiculo"]:''?>" name="conf_vehid" id="conf_vehid">
                            
                            <label class="ml-4"><b>Fecha de creación:</b></label>
                            <label id="conf_vehfechareg"><?=(isset($vehicle["fecha_reg"]))?$vehicle["fecha_reg"]:''?></label> 
                        </div>   
                    </div> 


                    <div class="form-row">
                        <div class="form-group col-md-4">  
                            <label for="conf_vehname" class="col-form-label">Vehiculo</label>
                            <input type="text" value="<?=(isset($vehicle["vehiculo"]))?$vehicle["vehiculo"]:''?>" name="conf_vehname" id="conf_vehname" class="form-control" required="" >
                        </div>  
                        <div class="form-group col-md-4">                        
                            <label for="conf_vehmodel" class="col-form-label">Modelo</label>
                            <input type="text" value="<?=(isset($vehicle["modelo"]))?$vehicle["modelo"]:''?>" name="conf_vehmodel" id="conf_vehmodel" class="form-control" required="" >
                        </div> 
                        <div class="form-group col-md-4">
                            <label for="conf_vehplate" class="col-form-label">Placas</label>
                            <input type="text" value="<?=(isset($vehicle["placas"]))?$vehicle["placas"]:''?>" name="conf_vehplate" id="conf_vehplate" class="form-control" required="" >            
                        </div>    
                    </div> 


                    <div class="form-row">
                        <div class="form-group col-md-4">  
                            <label for="conf_vehcompany">Empresa</label>
                            <select class="form-control select-form" id="conf_vehcompany" name="conf_vehcompany" required="">                
                                <?php foreach($companylist as $comp): ?>
                                <option <?=(isset($vehicle["id_empresa"]) && $vehicle["id_empresa"] == $comp->id_empresa)?'selected':''?> value="<?=$comp->id_empresa?>"><?=$comp->razon_social?></option>
                                <?php endforeach; ?>
                            </select>
                        </div> 
                        <div class="form-group col-md-4">                        
                            <label for="conf_vehstatus">Estatus</label>
                            <select class="form-control select-form" id="conf_vehstatus" name="conf_vehstatus" required="">                
                                <?php foreach($statuslist as $statusid => $status): ?>
                                <option <?=(isset($vehicle["estatus"]) && $vehicle["estatus"] == $statusid)?"selected":""?> value="<?=$statusid?>"><?=$status?></option>
                                <?php endforeach; ?>
                            </select>
                        </div> 
                        <div class="form-group col-md-4">
                            <label for="conf_vehidsepro" class="col-form-label">ID Sepromex</label>
                            <input type="text" value="<?=(isset($vehicle["id_sepro"]))?$vehicle["id_sepro"]:''?>" name="conf_vehidsepro" id="conf_vehidsepro" class="form-control">            
                        </div>    
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">  
                            <label for="conf_vehdetail" class="col-form-label">Detalle</label>
                            <textarea name="conf_vehdetail" id="conf_vehdetail" class="form-control"><?=(isset($vehicle["detalle"]))?$vehicle["detalle"]:""?></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_vehgroup" class="col-form-label">Grupo</label>
                            <input type="text" value="<?=(isset($vehicle["id_grupo"]))?$vehicle["id_grupo"]:""?>" name="conf_vehgroup" id="conf_vehgroup" class="form-control">
                        </div>    
                    </div> 

                </div>                
            </form>    
        </div>
    </div>  
</div> 