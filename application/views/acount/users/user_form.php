<!-- START: Card Data-->
<div class="row mt-3">        
    <div class="col-xl-12">
        <div class="card">
            <form class="add-contact-form needs-validation" id="user_configform" novalidate>
                
                <div class="card-header d-flex justify-content-between align-items-center">                                
                    <h4 class="card-title">Datos Generales</h4>
                    <div class="align-self-center ml-auto text-center text-sm-right">  
                        <button type="button" class="btn btn-danger" onclick="acount_formtoggle()">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="save_configform()">Editar Usuario</button>                        
                    </div>
                </div>

                <div class="card-body">                
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label><b>ID:</b></label>
                            <label id="conf_useridlabel"></label>
                            <input type="hidden" value="<?=(isset($user["id_usuario"]))?$user["id_usuario"]:''?>" name="conf_userid" id="conf_userid">
                        </div>  
                        <div class="form-group col-md-4"> 
                            <label><b>Fecha de creación:</b></label>
                            <label id="conf_userfechareg"></label> 
                        </div>    
                        <div class="form-group col-md-4">
                            <label><b>Rol de usuario:</b></label>
                            <select class="form-control" name="rolid">
                                <?php foreach($rollist as $rol): ?>
                                <option><?=$rol->rol?></option>
                                <?php endforeach; ?>
                            </select>                
                        </div>
                    </div> 
            
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label for="conf_user">Usuario</label>
                            <input type="text" class="form-control rounded" id="conf_user" value="<?=(isset($user["usuario"]))?$user["usuario"]:''?>" name="conf_user"  required="">
                        </div> 
                        <div class="form-group col-md-4">
                            <label for="conf_username">Nombre</label>
                            <input type="text" class="form-control" id="conf_username" name="conf_username"  required="" value="<?=(isset($user["nombre"]))?$user["nombre"]:''?>" >
                        </div> 
                        <div class="form-group col-md-4">
                            <label for="conf_userlastname">Apellido</label>
                            <input type="text" class="form-control rounded" id="conf_userlastname" name="conf_userlastname"  value="<?=(isset($user["apellido"]))?$user["apellido"]:''?>"  required="">
                        </div>    
                    </div> 


                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="conf_useremail">Correo</label>
                            <input type="email" class="form-control rounded" id="conf_useremail" name="conf_useremail" value="<?=(isset($user["email"]))?$user["email"]:''?>"  required="">
                        </div>  
                        <div class="form-group col-md-4">
                            <label for="conf_userfechainicio">Fecha de Inicio</label>
                            <input type="date" class="form-control rounded" id="conf_userfechainicio" name="conf_userfechainicio" value="<?=(isset($user["fecha_inicio"]))?$user["fecha_inicio"]:''?>" >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_userfechafin">Fecha de Finalización</label>
                            <input type="date" class="form-control rounded" id="conf_userfechafin" name="conf_userfechafin" value="<?=(isset($user["fecha_fin"]))?$user["fecha_fin"]:''?>" >
                        </div>  
                    </div>

                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label for="conf_userstatus">Estatus</label>
                            <select class="form-control" id="conf_userstatus" name="conf_userstatus"  required="">                     
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>                     
                            </select>   
                        </div> 
                        <div class="form-group col-md-4">
                            <label for="conf_userconfirmpassword">Confirma Contraseña</label>
                            <input type="text" class="form-control" id="conf_userpassword" name="conf_userconfirmpassword"  required="" value="<?=(isset($user["password"]))?$user["password"]:''?>" >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_userpassword">Confirma Contraseña</label>
                            <input type="text" class="form-control" id="conf_userconfirmpassword" name="conf_userpassword"  value="<?=(isset($user["password"]))?$user["password"]:''?>"  required="">
                        </div>
                    </div>   
                    
                </div>
                
            </form>    
        </div>
    </div>  
</div>


 
