<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i> Nueva Empresa
    </h5>     
    <i class="icon-close icons openside h3"></i>     
</div>

<form class="add-contact-form needs-validation" id="company_newform" novalidate>
    <div class="modal-body h-100">  

        <div class="form-row"> 
            <label for="company_name" class="col-form-label">Razón Social</label>
            <input type="text" name="company_name" id="company_name" class="form-control" required="" > 
        </div> 

        <div class="form-row"> 
            <label for="company_type" class="col-form-label">Giro</label>
            <input type="text" name="company_type" id="company_type" class="form-control" required="" >
        </div>

        <div class="form-row mb-1"> 
            <label for="company_rfc" class="col-form-label">RFC</label>
            <input type="text" name="company_rfc" id="company_rfc" class="form-control" required="" >
        </div> 

        <div class="form-row mb-1"> 
        <label for="company_agent">Representante</label>
            <input type="text" id="company_agent" name="company_agent" class="form-control" required="" >
        </div>  
         
        <div class="form-row mb-1"> 
            <label for="company_contactid">Contacto</label>
            <select class="form-control" id="company_contactid" name="company_contactid">
                <option value="0">Selecciona un Contacto</option>
                <?php foreach($contactlist as $datacontact): ?>
                <option value="<?=$datacontact->id_contacto?>"><?=$datacontact->nombre?></option>
                <?php endforeach; ?>
            </select>        
        </div>

        <div class="form-row mb-1"> 
            <label for="company_phone" class="col-form-label">Teléfono</label>
            <input type="text" class="form-control" name="company_phone" id="company_phone" required="">
        </div>


        <div class="form-row mb-1"> 
            <label for="company_email" class="col-form-label">Correo Electrónico</label>
            <input type="text" name="company_email" id="company_email" class="form-control" required="" >
        </div>

        <div class="form-row mb-1">
            <label for="company_address">Dirección</label>
            <input type="text" class="form-control" id="company_address" name="company_address">
        </div>
 
        <div class="form-row mb-1">
            <label for="company_address">Colonia</label>
            <input type="text" class="form-control" id="company_sub" name="company_sub">
        </div>


        <div class="form-row mb-1">
            <label for="inputState">Estado</label>
            <select class="form-control" id="company_state" name="company_state">
            <option value="0">Selecciona un estado</option>
            <?php foreach($states as $state): ?>
            <option><?=$state->nombre?></option>
            <?php endforeach; ?>
            </select> 
        </div>

        <div class="form-row mb-1">
            <label for="company_city">Municipio</label>
            <select class="form-control" id="company_state" name="company_city">
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