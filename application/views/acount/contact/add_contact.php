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
            <input type="text" onblur="general_validate('#contact_name','#feedback-contactname')" name="contact_name" id="contact_name" class="form-control" required="" > 
            <div class="invalid-feedback" id="feedback-contactname"></div>
        </div> 

        <div class="row"> 
            <label for="contact_job" class="col-form-label">Puesto</label>
            <input type="text" name="contact_job" id="contact_job" class="form-control" required="" >            
        </div>
 
        <div class="row"> 
            <label for="contact_email" class="col-form-label">Correo electrónico</label>
            <input type="email" onblur="validate_email('#contact_email','#feedback-contactemail')" name="contact_email" id="contact_email" class="form-control" required="" >
            <div class="invalid-feedback" id="feedback-contactemail"></div>
        </div>

        <div class="row"> 
            <label for="contact_phone" class="col-form-label">Teléfono</label>
            <input type="text" name="contact_phone" onblur="validate_phonemask('#contact_phone','#feedback-contactphone',1)" id="contact_phone" class="form-control inputnumber" data-masked="" data-inputmask="'mask': '(999) 999-9999'" required="" >
            <div class="invalid-feedback" id="feedback-contactphone"></div>
        </div>  


        <div class="row mb-3"> 
            <label for="contact_available" class="col-form-label">Horario</label>
            <input type="text"  onblur="general_validate('#contact_available','#feedback-contactavailable')"  name="contact_available" id="contact_available" class="form-control" required="" >
            <div class="invalid-feedback" id="feedback-contactavailable"></div>
        </div> 
       

        <div class="row form-group"> 
            <label for="contact_companyid">Empresa</label>
            <select class="form-control select-form" id="contact_companyid" name="contact_companyid" onchange="validate_select('#contact_companyid','#feedback-contactcompanyid')">
                <option value="0">Selecciona una empresa</option>
                <?php foreach($companys as $datacompany): ?>
                <option value="<?=$datacompany->id_empresa?>"><?=$datacompany->razon_social?></option>                     
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback" id="feedback-contactcompanyid"></div>    
        </div>
  
        <div class="row form-group"> 
            <label for="contact_userid">Usuario</label>
            <select class="form-control select-form" id="contact_userid" name="contact_userid">
                <?php foreach($userlist as $datauser): ?>
                <option value="<?=$datauser->id_usuario?>" data-email="<?=$datauser->email?>"><?=$datauser->username?></option>                     
                <?php endforeach; ?>
            </select>                    
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside"> Cancelar </button>
        <button type="button" class="btn btn-primary" onclick="validate_contact()"> Agregar Contacto </button>
    </div>

</form>

 