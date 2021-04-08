<!-- START: Card Data-->
<div class="row mt-3">        
    <div class="col-xl-12">
        <div class="card">
            <form method="POST" id="user_configform">
                <div class="card-header d-flex justify-content-between align-items-center">                                
                    <h4 class="card-title">Datos Generales</h4>
                    <div class="align-self-center ml-auto text-center text-sm-right hidde-mobile">  
                        <button type="button" class="btn btn-danger reset_form" data-reset="reset_user" onclick="acount_formtoggle()">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="validate_edituser()">Editar Usuario</button>
                    </div>
                </div>
   
                <div class="card-body">                
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="label-mobile ml4-mobile">
                                <label><b>ID:</b></label>
                                <label id="conf_useridlabel"><?=(isset($user["id_usuario"]))?$user["id_usuario"]:''?></label>
                                <input type="hidden" value="<?=(isset($user["id_usuario"]))?$user["id_usuario"]:''?>" name="conf_userid" id="conf_userid">
                                <input type="hidden" value="<?=(isset($user["id_empresa"]))?$user["id_empresa"]:''?>" name="conf_usercompany" id="conf_usercompany">
                            </div>
                            <div class="label-mobile">
                                <label class="ml-4"><b>Fecha de creación:</b></label>
                                <label id="conf_userfechareg"><?=(isset($user["fechaalta"]))?$user["fechaalta"]:''?></label> 
                            </div>
                            <div class="label-mobile">
                                <label class="ml-4"><b>Fecha inicio:</b></label>
                                <label id="conf_userfechareg"><?=(isset($user["fecha_inicio"]))?$user["fecha_inicio"]:''?></label> 
                                <input type="hidden" value="<?=(isset($user["fecha_inicio"]))?$user["fecha_inicio"]:''?>" name="conf_userfinit" id="conf_userfinit">
                            </div>
                            <div class="label-mobile">
                                <label class="ml-4"><b>Fecha fin:</b></label>
                                <label id="conf_userfechareg"><?=(isset($user["fecha_fin"]))?$user["fecha_fin"]:''?></label> 
                                <input type="hidden" value="<?=(isset($user["fecha_fin"]))?$user["fecha_fin"]:''?>" name="conf_userend" id="conf_userend">
                            </div>
                            <div class="label-mobile">
                                <label class="ml-4"><b>Tipo de usuario:</b></label>
                                <label id="conf_userfechareg"><?=(isset($user["estatus"]))?$user["estatus"]:''?></label>
                            </div> 
                        </div>                        
                    </div> 
            
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="conf_user">Usuario</label>
                            <?php $userdef = (isset($user["usuario"]))?$user["usuario"]:''; ?>
                            <input type="text" onblur="validate_username('#conf_user','#feedback-confuser','<?=$userdef?>')" class="form-control rounded" id="conf_user" value="<?=$userdef?>" name="conf_user">
                            <div class="invalid-feedback" id="feedback-confuser"></div>
                        </div>
                        <div class="form-group col-md-4">                        
                            <label for="conf_username">Nombre</label>
                            <?php $namedef = (isset($user["nombre"]))?$user["nombre"]:''; ?> 
                            <input type="text" onblur="validate_name('#conf_username','#feedback-confusername')" class="form-control" id="conf_username" name="conf_username"  required="" value="<?=$namedef?>" >
                            <div class="invalid-feedback" id="feedback-confusername"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_userrol"><b>Rol de usuario:</b></label>
                            <select class="form-control select-form" name="conf_userrol" id="conf_userrol" onchange="validate_select('#conf_userrol','#feedback-confuserrol')">
                                <option value="0">Selecciona un rol de usuario</option>
                                <?php foreach($rollist as $rol): ?>
                                <option <?=(isset($user["id_rol"]) && $user["id_rol"] == $rol->id_rol)?'selected':''?> value="<?=$rol->id_rol?>"><?=$rol->rol?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback" id="feedback-confuserrol"></div>
                        </div>  
                    </div> 

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="conf_useremail">Correo</label>                            
                            <?php $emaildef = (isset($user["email"]))?$user["email"]:''; ?>
                            <input type="email" class="form-control rounded" id="conf_useremail" name="conf_useremail" value="<?=$emaildef?>"  onblur="validate_email('#conf_useremail','#feedback-confemail','<?=$emaildef?>')" required="">
                            <div class="invalid-feedback" id="feedback-confemail"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_userpassword">Confirma Contraseña</label>
                            <input type="text" onblur="validate_password('#conf_userpassword','#feedback-confpass','#conf_userconfirmpassword','#feedback-confconfirmpass')" class="form-control" id="conf_userpassword" name="conf_userpassword" value="<?=(isset($user["password"]))?$user["password"]:''?>" >
                            <div class="invalid-feedback" id="feedback-confpass"></div>
                        </div> 
                        <div class="form-group col-md-4">
                            <label for="conf_userconfirmpassword">Confirma Contraseña</label>                  
                            <input type="text" onblur="validate_confirmpassword('#conf_userconfirmpassword','#feedback-confconfirmpass','#conf_userpassword','#feedback-confpass')" class="form-control" id="conf_userconfirmpassword" name="conf_userconfirmpassword" value="<?=(isset($user["password"]))?$user["password"]:''?>" >
                            <div class="invalid-feedback" id="feedback-confconfirmpass"></div>
                        </div>
                        
                    </div>

                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label for="conf_userstatus">Estatus</label>
                            <select class="form-control select-form" id="conf_userstatus" name="conf_userstatus">                                
                                <?php foreach($status_list as $st): ?>
                                <option <?=(isset($user["estatus_id"]) && $user["estatus_id"] == $st->ESTATUS)?'selected':''?> value="<?=$st->ESTATUS?>"><?=$st->DESCRIPCION?></option>
                                <?php endforeach; ?>    
                            </select> 
                            <div class="invalid-feedback" id="feedback-confuserstatus"></div>
                        </div>
                        
                    </div> 

                    <div class="form-row show-mobile">
                        <button type="button" class="btn btn-danger reset_form w-100" data-reset="reset_user" onclick="acount_formtoggle()">Cancelar</button>
                        <button type="button" class="btn btn-primary  w-100" onclick="validate_edituser()">Editar Usuario</button>                    
                    </div>
                     
                    
                </div>
                
            </form>    
        </div>
    </div>  
</div> 