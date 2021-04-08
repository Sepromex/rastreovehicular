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
                            <button type="button" class="btn btn-primary" onclick="validate_editcontact()">Editar Contacto</button>
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
                                <input type="text" class="form-control rounded" onblur="general_validate('#conf_contactname','#feedback-confcontactname')" id="conf_contactname" name="conf_contactname"  required="">
                                <div class="invalid-feedback" id="feedback-confcontactname"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="conf_contactavailable">Horario</label>
                                <input type="text" class="form-control" onblur="general_validate('#conf_contactailable','#feedback-confcontactailable')" id="conf_contactailable" name="conf_contactailable"  required="">
                                <div class="invalid-feedback" id="feedback-confcontactailable"></div>
                            </div> 
                            <div class="form-group col-md-3">
                                <label for="conf_contactjob">Puesto</label>
                                <input type="text" class="form-control rounded"  id="conf_contactjob" name="conf_contactjob"  required="">                                
                            </div>        
                        </div> 


                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="conf_contactemail">Correo</label>
                                <input type="email" class="form-control rounded" onblur="validate_email('#conf_contactemail','#feedback-confcontactemail')" id="conf_contactemail" name="conf_contactemail"  required="">
                                <div class="invalid-feedback" id="feedback-confcontactemail"></div>
                            </div>  
                            <div class="form-group col-md-4">
                                <label for="conf_contactphone">Telefono</label>
                                <input type="text" class="form-control rounded inputnumber" onblur="validate_phonemask('#conf_contactphone','#feedback-confcontactphone',1)" id="conf_contactphone" name="conf_contactphone" data-masked="" data-inputmask="'mask': '(999) 999-9999'">
                                <div class="invalid-feedback" id="feedback-confcontactphone"></div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="conf_contactcompanyid">Empresa</label>
                                <select class="form-control select-form" onchange="validate_select('#conf_contactcompanyid','#feedback-confcontactcompanyid')" id="conf_contactcompanyid" name="conf_contactcompanyid">
                                    <option value="0">Selecciona una empresa</option>
                                    <?php foreach($companys as $datacompany): ?>
                                    <option value="<?=intval($datacompany->id_empresa)?>"><?=$datacompany->razon_social?></option>                     
                                    <?php endforeach; ?>
                                </select>   
                                <div class="invalid-feedback" id="feedback-confcontactcompanyid"></div>
                            </div> 
                             
                        </div> 


                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="conf_contactuserid">Usuario</label>
                                <select class="form-control select-form" id="conf_contactuserid" name="conf_contactuserid">
                                    <option value="0">Selecciona un usuario</option>
                                    <?php foreach($userlist as $datauser): ?>
                                    <option value="<?=intval($datauser->id_usuario)?>" data-email="<?=$datauser->email?>"><?=$datauser->username?></option>                     
                                    <?php endforeach; ?>
                                </select>   
                            </div>
                        </div> 

                    </div>
                </form>  
            </div> 
        </div>  
    </div> 