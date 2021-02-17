<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i> Nueva Sucursal
    </h5>     
    <i class="icon-close icons openside h3"></i>     
</div>

<form class="add-contact-form needs-validation" id="office_newform" novalidate>
    <div class="modal-body h-100">  

        <div class="form-row"> 
            <label for="office_name" class="col-form-label">Razón Social</label>
            <input type="text" name="office_name" id="office_name" class="form-control" required="" > 
        </div> 

        <div class="form-row mb-1"> 
            <label for="office_rfc" class="col-form-label">RFC</label>
            <input type="text" name="office_rfc" id="office_rfc" class="form-control" required="" >
        </div> 

        <div class="form-row mb-1"> 
        <label for="office_agent">Representante</label>
            <input type="text" id="office_agent" name="office_agent" class="form-control" required="" >
        </div>  
         
        <div class="form-row mb-1"> 
            <label for="office_contactid">Contacto</label>
            <select class="form-control" id="office_contactid" name="office_contactid">
                <option value="0">Selecciona un Contacto</option>
                <?php foreach($contactlist as $datacontact): ?>
                <option value="<?=$datacontact->id_contacto?>"><?=$datacontact->nombre?></option>
                <?php endforeach; ?>
            </select>        
        </div>

        <div class="form-row mb-1"> 
            <label for="office_companyid">Empresa</label>
            <select class="form-control" id="office_companyid" name="office_companyid">
                <option value="0">Selecciona una Empresa</option>
                <?php foreach($companys as $datacompany): ?>
                <option value="<?=$datacompany->id_empresa?>"><?=$datacompany->razon_social?></option>
                <?php endforeach; ?>
            </select>        
        </div>

        <div class="form-row mb-1"> 
            <label for="office_phone" class="col-form-label">Teléfono</label>
            <input type="text" class="form-control" name="office_phone" id="office_phone" required="">
        </div>


        <div class="form-row mb-1"> 
            <label for="office_email" class="col-form-label">Correo Electrónico</label>
            <input type="text" name="office_email" id="office_email" class="form-control" required="" >
        </div>

        <div class="form-row mb-1">
            <label for="office_address">Dirección</label>
            <input type="text" class="form-control" id="office_address" name="office_address">
        </div>
 
        <div class="form-row mb-1">
            <label for="office_address">Colonia</label>
            <input type="text" class="form-control" id="office_sub" name="office_sub">
        </div>


        <div class="form-row mb-1">
            <label for="inputState">Estado</label>
            <select class="form-control" id="office_state" name="office_state">
            <option value="0">Selecciona un estado</option>
            <?php foreach($states as $state): ?>
            <option><?=$state->nombre?></option>
            <?php endforeach; ?>
            </select> 
        </div>

        <div class="form-row mb-1">
            <label for="office_city">Municipio</label>
            <select class="form-control" id="office_state" name="office_city">
            <option value="0">Selecciona un Municipio</option>
            <?php foreach($cities as $city): ?>
            <option><?=$city->nombre?></option>
            <?php endforeach; ?>
            </select> 
        </div>        
        
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside">Cancelar</button>
        <button type="submit" class="btn btn-primary">Agregar Empresa</button>
    </div>
</form> 
                     
 