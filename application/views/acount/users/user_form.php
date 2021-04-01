<!-- START: Card Data-->
<div class="row mt-3">        
    <div class="col-xl-12">
        <div class="card">
            <form method="POST" id="user_configform">
                <div class="card-header d-flex justify-content-between align-items-center">                                
                    <h4 class="card-title">Datos Generales</h4>
                    <div class="align-self-center ml-auto text-center text-sm-right">  
                        <button type="button" class="btn btn-danger reset_form" data-reset="reset_user" onclick="acount_formtoggle()">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="validate_edituser()">Editar Usuario</button>
                    </div>
                </div>
  
                <div class="card-body">                
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label><b>ID:</b></label>
                            <label id="conf_useridlabel"><?=(isset($user["id_usuario"]))?$user["id_usuario"]:''?></label>
                            <input type="hidden" value="<?=(isset($user["id_usuario"]))?$user["id_usuario"]:''?>" name="conf_userid" id="conf_userid">
                            
                            <label class="ml-4"><b>Fecha de creación:</b></label>
                            <label id="conf_userfechareg"><?=(isset($user["fecha_reg"]))?$user["fecha_reg"]:''?></label> 
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
                            <label for="conf_userlastname">Apellido</label>
                            <?php $lastnamedef = (isset($user["apellido"]))?$user["apellido"]:''; ?>
                            <input type="text" onblur="validate_lastname('#conf_userlastname','#feedback-conflastname')" class="form-control rounded" id="conf_userlastname" name="conf_userlastname"  value="<?=$lastnamedef?>"  required="">                            
                            <div class="invalid-feedback" id="feedback-conflastname"></div>
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
                            <label for="conf_userfechainicio">Fecha de Inicio</label>                            
                            <input type="text" class="form-control rounded" id="conf_userfechainicio" name="conf_userfechainicio" value="<?=(isset($user["fecha_inicio"]))?$user["fecha_inicio"]:''?>" >
                            <div class="valid" id="fecha_desc"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_userfechafin">Fecha de Finalización</label>
                            <input type="text" class="form-control rounded" id="conf_userfechafin" name="conf_userfechafin" value="<?=(isset($user["fecha_fin"]))?$user["fecha_fin"]:''?>" >
                        </div>
                    </div>

                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label for="conf_userstatus">Estatus</label>
                            <select class="form-control" id="conf_userstatus" name="conf_userstatus" onchange="validate_select('#conf_userstatus','#feedback-confuserstatus')">                     
                                <option value="1" <?=(isset($user["estatus"]) && $user["estatus"] == 1)?'selected':''?>>Activo</option>
                                <option value="2" <?=(isset($user["estatus"]) && $user["estatus"] == 2)?'selected':''?>>Inactivo</option>                     
                            </select> 
                            <div class="invalid-feedback" id="feedback-confuserstatus"></div>
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
                            <label for="conf_usersepromex">Usuario Sepromex</label>
                            <select class="form-control select-form" id="conf_usersepromex" name="conf_usersepromex">
                            <option value="0">Selecciona un usuario</option>
                                <?php if(isset($usersep)): foreach($usersep as $us): ?>
                                <option <?=(isset($user["id_sepro"]) && $user["id_sepro"] == $us->id_usuario)?'selected':''?> value="<?=$us->id_usuario?>"><?=$us->nombre?></option>
                                <?php endforeach; endif; ?>
                            </select> 
                            <div class="invalid-feedback" id="feedback-confusersepromex"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_usercompany">Empresa</label>
                            <select class="form-control select-form" id="conf_usercompany" name="conf_usercompany" onchange="validate_select('#conf_usercompany','#feedback-confusercompany');changeselectveh(this.value)">
                                <option value="0">Selecciona una empresa</option>
                                <?php foreach($companylist as $comp): ?>
                                <option <?=(isset($user["id_empresa"]) && $user["id_empresa"] == $comp->id_empresa)?'selected':''?> value="<?=$comp->id_empresa?>"><?=$comp->razon_social?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback" id="feedback-confusercompany"></div>
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
                    
                </div>
                
            </form>    
        </div>
    </div>  
</div> 