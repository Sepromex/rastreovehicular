<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i>  &nbsp; Configurar Contacto
    </h5>     
    <i class="icon-close icons h3" onclick="acount_formtoggle()"></i>     
</div>

<div class="row mt-3"> 
        <div class="col-xl-12">
            <div class="card">
                <form class="add-contact-form needs-validation configform" id="contact_configform" novalidate>
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Información general</h4>
                        <div class="align-self-center ml-auto text-center text-sm-right">           
                            <button type="button" class="btn btn-danger" onclick="acount_formtoggle()">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Editar Contacto</button>
                        </div>
                    </div>

                    <div class="card-body p-0 p-3">                    
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label><b>ID:</b></label>
                                <label id="conf_contactidlabel"></label>
                                <input type="hidden" name="conf_contactid" id="conf_contactid">
                            </div>  
                            <div class="form-group col-md-2"> 
                                <label><b>Fecha de creación:</b></label>
                                <label id="conf_contactfechareg"></label> 
                            </div>  
                            
                        </div> 

                        <div class="form-row">  
                            <div class="form-group col-md-4">
                                <label for="conf_contactname">Nombre</label>
                                <input type="text" class="form-control rounded" id="conf_contactname" name="conf_contactname"  required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="conf_contactavailable">Horario</label>
                                <input type="text" class="form-control" id="conf_contactailable" name="conf_contactailable"  required="">
                            </div> 
                            <div class="form-group col-md-3">
                                <label for="conf_contactjob">Puesto</label>
                                <input type="text" class="form-control rounded" id="conf_contactjob" name="conf_contactjob"  required="">
                            </div>   
                            <div class="form-group col-md-1">
                                <label for="conf_contactstatus">Estatus</label>
                                <select class="form-control" id="conf_contactstatus" name="conf_contactstatus"  required="">                     
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>                     
                                </select>   
                            </div>              
                        </div> 


                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="conf_contactemail">Correo</label>
                                <input type="email" class="form-control rounded" id="conf_contactemail" name="conf_contactemail"  required="">
                            </div>  
                            <div class="form-group col-md-4">
                                <label for="conf_contactphone">Telefono</label>
                                <input type="text" class="form-control rounded" id="conf_contactphone" name="conf_contactphone">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="conf_contactlocation">Ubicación</label> 
                                <select class="form-control" name="conf_contactlocation" id="conf_contactlocation" required="">
                                    <option value="0">Selecciona un estado</option>
                                    <?php foreach($locations as $loc): ?>
                                    <option value="<?=$loc->id_estado?>"><?=$loc->nombre?></option>
                                    <?php endforeach; ?>
                                </select>   
                            </div>  
                        </div> 


                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="conf_contactcompanyid">Empresa</label>
                                <select class="form-control" id="conf_contactcompanyid" name="conf_contactcompanyid">
                                    <option value="0">Selecciona una empresa</option>
                                    <?php foreach($companys as $datacompany): ?>
                                    <option value="<?=$datacompany->id_empresa?>"><?=$datacompany->razon_social?></option>                     
                                    <?php endforeach; ?>
                                </select>   
                            </div> 
                            <div class="form-group col-md-4">
                                <label for="conf_contactoffice">Sucursal</label>
                                <select class="form-control" id="conf_contactoffice" name="conf_contactoffice">
                                    <option value="0">Selecciona una sucursal</option>  
                                </select>   
                            </div>  
                            <div class="form-group col-md-4">
                                <label for="conf_contactuserid">Usuario</label>
                                <select class="form-control" id="conf_contactuserid" name="conf_contactuserid">
                                    <option value="1">Selecciona un usuario</option>
                                    <?php foreach($userlist as $datauser): ?>
                                    <option value="<?=$datauser->id_usuario?>" data-email="<?=$datauser->email?>"><?=$datauser->nombre?></option>                     
                                    <?php endforeach; ?>
                                </select>   
                            </div> 
                        </div> 
                    </div>
                </form>  
            </div> 
        </div>  
    </div> 