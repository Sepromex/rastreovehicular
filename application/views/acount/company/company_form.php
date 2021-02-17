<!-- START: Card Data-->
<div class="row mt-3">        
    <div class="col-xl-12">
        <div class="card">
            <form class="add-contact-form needs-validation configform" id="company_configform" novalidate>
                <input type="hidden" name="conf_companyid" id="conf_companyid" value="<?=(isset($company["id_empresa"]))?$company["id_empresa"]:''?>">
                <div class="card-header d-flex justify-content-between align-items-center">                                
                    <h4 class="card-title">Datos Generales</h4>
                    <div class="align-self-center ml-auto text-center text-sm-right">  
                        <button type="button" class="btn btn-danger" onclick="acount_formtoggle()">Cancelar</button>         
                        <button type="button"  onclick="save_configform()" class="btn btn-success">Editar Empresa</button>
                    </div>
                </div> 

                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="conf_companyname">Razon social</label>
                            <input type="text" class="form-control rounded" id="conf_companyname" name="conf_companyname" value="<?=(isset($company["razon_social"]))?$company["razon_social"]:''?>"  required="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_companyagent">Representante</label>  
                            <input type="text" class="form-control" name="conf_companyagent" id="conf_companyagent" value="<?=(isset($company["representante"]))?$company["representante"]:''?>" required=""> 
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="conf_companyrfc">RFC</label>
                            <input type="text" class="form-control rounded" id="conf_companyrfc" name="conf_companyrfc" value="<?=(isset($company["rfc"]))?$company["rfc"]:''?>" required="">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="conf_companytype">Giro</label>
                            <input type="text" name="conf_companytype" id="conf_companytype" class="form-control" value="<?=(isset($company["giro"]))?$company["giro"]:''?>" required="" >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_companycontactid">Contacto</label> 
                            <select class="form-control" id="conf_companycontactid" name="conf_companycontactid">
                                <option value="0">Selecciona un Contacto</option>
                                <?php $idcontact = (isset($company["id_contacto"]))?$company["id_contacto"]:''; ?>
                                <?php foreach($contactlist as $datacontact): ?>
                                <option <?=($idcontact==$datacontact->id_contacto)?"selected":""?> value="<?=$datacontact->id_contacto?>"><?=$datacontact->nombre?></option>
                                <?php endforeach; ?>
                            </select>
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="conf_companystatus">Estatus</label>
                            <select class="form-control" id="conf_companystatus" name="conf_companystatus">
                                <option value="1">Activo</option> 
                                <option value="0">Inactivo</option> 
                            </select>  
                        </div>
                    </div>                        

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="conf_companyphone" class="col-form-label">Teléfono</label>
                            <input type="text" class="form-control" name="conf_companyphone" id="conf_companyphone" value="<?=(isset($company["telefono"]))?$company["telefono"]:''?>" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="conf_companyemail" class="col-form-label">Correo Electrónico</label>
                            <input type="text" name="conf_companyemail" id="conf_companyemail" class="form-control" value="<?=(isset($company["email"]))?$company["email"]:''?>" required="" >
                        </div>
                    </div> 


                    <div class="form-row mb-2">  
                        <label for="conf_companyaddress">Dirección</label>
                        <input type="text" class="form-control" name="conf_companyaddress" id="conf_companyaddress" value="<?=(isset($company["direccion"]))?$company["direccion"]:''?>"> 
                    </div>

                    <div class="form-row">  
                        <label for="conf_companysub">Colonia</label>
                        <input type="text" class="form-control" name="conf_companysub" id="conf_companysub" value="<?=(isset($company["colonia"]))?$company["colonia"]:''?>">
                    </div>
                            
                    <div class="form-row mt-2">
                        <div class="form-group col-md-6">
                            <label for="conf_companycity">Ciudad</label>
                            <select class="form-control" name="conf_companycity" id="conf_companycity">
                                <option value="0" selected>Selecciona una ciudad</option>
                                <?php $companycity = (isset($company["ciudad"]))?$company["ciudad"]:''; ?>
                                <?php foreach($cities as $city): ?>
                                <option <?=($companycity==$city->nombre)?"selected":""?> value="<?=$city->nombre?>"><?=$city->nombre?></option>
                                <?php endforeach; ?>
                            </select>
                        </div> 
                        <div class="form-group col-md-6">
                            <label for="conf_companystate">Estado</label>
                            <select class="form-control" name="conf_companystate" id="conf_companystate">
                                <option value="0" selected>Selecciona un Estado</option>
                                <?php $compantstate = (isset($company["estado"]))?$company["estado"]:''; ?>
                                <?php foreach($states as $state): ?>
                                <option <?=($compantstate==$state->nombre)?"selected":""?> value="<?=$state->nombre?>"><?=$state->nombre?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div> 
                                         
                </div> 
            </form>
        </div>
    </div>  
</div>