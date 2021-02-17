<!-- START: Card Data-->
<div class="row mt-3">        
    <div class="col-xl-12">
        <div class="card">
            <form class="add-contact-form needs-validation configform" id="office_configform" novalidate>

                <input type="hidden" name="conf_officeid" id="conf_officeid" value="<?=(isset($office["id_sucursal"]))?$office["id_sucursal"]:''?>">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h4 class="card-title">Datos Generales</h4>
                    <div class="align-self-center ml-auto text-center text-sm-right">  
                        <button type="button" class="btn btn-danger" onclick="acount_formtoggle()">Cancelar</button>         
                        <button type="button" class="btn btn-success" onclick="save_configform()">Editar Sucursal</button>
                    </div>
                </div> 

                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="conf_officename">Razon social</label>
                            <input type="text" class="form-control rounded" id="conf_officename" name="conf_officename" value="<?=(isset($office["razon_social"]))?$office["razon_social"]:''?>"  required="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_officeagent">Representante</label>  
                            <input type="text" class="form-control" name="conf_officeagent" id="conf_officeagent" value="<?=(isset($office["representante"]))?$office["representante"]:''?>" required=""> 
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="conf_officerfc">RFC</label>
                            <input type="text" class="form-control rounded" id="conf_officerfc" name="conf_officerfc" value="<?=(isset($office["rfc"]))?$office["rfc"]:''?>" required="">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="conf_officetype">Empresa</label>
                            <select class="form-control" id="conf_officecompanyid" name="conf_officecompanyid">
                                <option value="0">Selecciona una Empresa</option>
                                <?php $idcompany = (isset($office["id_empresa"]))?$office["id_empresa"]:''; ?>
                                <?php foreach($companys as $datacompany): ?>
                                <option <?=($idcompany==$datacompany->id_empresa)?"selected":""?> value="<?=$datacompany->id_empresa?>"><?=$datacompany->razon_social?></option>
                                <?php endforeach; ?>
                            </select> 
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_officecontactid">Contacto</label> 
                            <select class="form-control" id="conf_officecontactid" name="conf_officecontactid">
                                <option value="0">Selecciona un Contacto</option>
                                <?php $idcontact = (isset($office["id_contacto"]))?$office["id_contacto"]:''; ?>
                                <?php foreach($contactlist as $datacontact): ?>
                                <option <?=($idcontact==$datacontact->id_contacto)?"selected":""?> value="<?=$datacontact->id_contacto?>"><?=$datacontact->nombre?></option>
                                <?php endforeach; ?>
                            </select> 
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="conf_officestatus">Estatus</label>
                            <select class="form-control" id="conf_officestatus" name="conf_officestatus">
                                <option value="1">Activo</option> 
                                <option value="0">Inactivo</option> 
                            </select>  
                        </div>
                    </div>                        

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="conf_officephone" class="col-form-label">Teléfono</label>
                            <input type="text" class="form-control" name="conf_officephone" id="conf_officephone" value="<?=(isset($office["telefono"]))?$office["telefono"]:''?>" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="conf_officeemail" class="col-form-label">Correo Electrónico</label>
                            <input type="text" name="conf_officeemail" id="conf_officeemail" class="form-control" value="<?=(isset($office["email"]))?$office["email"]:''?>" required="" >
                        </div>
                    </div> 


                    <div class="form-row mb-2">  
                        <label for="conf_officeaddress">Dirección</label>
                        <input type="text" class="form-control" name="conf_officeaddress" id="conf_officeaddress" value="<?=(isset($office["direccion"]))?$office["direccion"]:''?>"> 
                    </div>

                    <div class="form-row">  
                        <label for="conf_officesub">Colonia</label>
                        <input type="text" class="form-control" name="conf_officesub" id="conf_officesub" value="<?=(isset($office["colonia"]))?$office["colonia"]:''?>">
                    </div>
                            
                    <div class="form-row mt-2">
                        <div class="form-group col-md-6">
                            <label for="conf_officecity">Ciudad</label>
                            <select class="form-control" name="conf_officecity" id="conf_officecity">
                                <option value="0" selected>Selecciona una ciudad</option>
                                <?php $officecity = (isset($office["ciudad"]))?$office["ciudad"]:''; ?>
                                <?php foreach($cities as $city): ?>
                                <option <?=($officecity==$city->nombre)?"selected":""?> value="<?=$city->nombre?>"><?=$city->nombre?></option>
                                <?php endforeach; ?>
                            </select>
                        </div> 
                        <div class="form-group col-md-6">
                            <label for="conf_officestate">Estado</label>
                            <select class="form-control" name="conf_officestate" id="conf_officestate">
                                <option value="0" selected>Selecciona un Estado</option>
                                <?php $officestate = (isset($office["estado"]))?$office["estado"]:''; ?>
                                <?php foreach($states as $state): ?>
                                <option <?=($officestate==$state->nombre)?"selected":""?> value="<?=$state->nombre?>"><?=$state->nombre?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div> 
                                         
                </div> 
            </form>
        </div>
    </div>  
</div>


<script>

</script>