<!-- Title -->
<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i> Nuevo Contacto
    </h5>
    <i class="icon-close icons openside h3"></i>     
</div>

<!-- Form --> 
<form class="add-contact-form needs-validation newform" id="contact_newform" novalidate>
    <div class="modal-body h-100">  

        <div class="row"> 
            <label for="contact_name" class="col-form-label">Nombre</label>
            <input type="text" name="contact_name" id="contact_name" class="form-control" required="" > 
        </div> 

        <div class="row"> 
            <label for="contact_job" class="col-form-label">Puesto</label>
            <input type="text" name="contact_job" id="contact_job" class="form-control" required="" >
        </div>
 
        <div class="row"> 
            <label for="contact_email" class="col-form-label">Correo electrónico</label>
            <input type="email" name="contact_email" id="contact_email" class="form-control" required="" >
        </div>

        <div class="row"> 
            <label for="contact_phone" class="col-form-label">Teléfono</label>
            <input type="text" name="contact_phone" id="contact_phone" class="form-control" required="" >
        </div> 

        <div class="row"> 
            <label for="contact_available" class="col-form-label">Horario</label>
            <input type="text" name="contact_available" id="contact_available" class="form-control" required="" >
        </div> 

         
        <div class="row form-group"> 
            <label for="contact_location" class="col-form-label">Ubicación</label>
            <select class="form-control" name="contact_location" id="contact_location" required="">
            <option value="0">Selecciona un estado</option>
            <?php foreach($locations as $loc): ?>
                <option value="<?=$loc->id_estado?>"><?=$loc->nombre?></option>
            <?php endforeach; ?>
            </select>            
        </div>

        <div class="row form-group"> 
            <label for="contact_companyid">Empresa</label>
            <select class="form-control" id="contact_companyid" name="contact_companyid">
                <option value="0">Selecciona una empresa</option>
                <?php foreach($companys as $datacompany): ?>
                <option value="<?=$datacompany->id_empresa?>"><?=$datacompany->razon_social?></option>                     
                <?php endforeach; ?>
            </select>            
        </div>

        <div class="row form-group"> 
            <label for="contact_office">Sucursal</label>
            <select class="form-control" id="contact_office" name="contact_office">
                <option value="0">Selecciona una sucursal</option>  
            </select>               
        </div>

        <div class="row form-group"> 
            <label for="contact_userid">Usuario</label>
            <select class="form-control" id="contact_userid" name="contact_userid">
                <option value="1">Selecciona un usuario</option>
                <?php foreach($userlist as $datauser): ?>
                <option value="<?=$datauser->id_usuario?>" data-email="<?=$datauser->email?>"><?=$datauser->nombre?></option>                     
                <?php endforeach; ?>
            </select>        
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside">Cancelar</button>
        <button type="submit" class="btn btn-primary"> Agregar Contacto </button>
    </div>

</form>  