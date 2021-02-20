<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i> Nuevo Usuario
    </h5>     
    <i class="icon-close icons openside reset_form h3" data-reset="reset_user"></i>     
</div>
<form class="add-contact-form needs-validation" id="user_newform" novalidate>
    <div class="modal-body h-100">  

        <div class="row"> 
            <label for="newuser_username" class="col-form-label">Usuario</label>
            <input type="text" name="user" id="newuser_username" class="form-control" required="" > 
            <div class="invalid-feedback" id="feedback-newuser_username"></div>
        </div> 
 
        <div class="row"> 
            <label for="newuser_name" class="col-form-label">Nombre</label>
            <input type="text" name="name" id="newuser_name" class="form-control" required="" >
            <div class="invalid-feedback" id="feedback-newuser_name"></div>
        </div>

        <div class="row"> 
            <label for="newuser_lastname" class="col-form-label">Apellido</label>
            <input type="text" name="lastname" id="newuser_lastname" class="form-control" required="" >
            <div class="invalid-feedback" id="feedback-newuser_lastname"></div>
        </div> 

        <div class="row"> 
            <label for="newuser_email" class="col-form-label">Correo electrónico</label>
            <input type="email" name="email" id="newuser_email" class="form-control" required="" >
            <div class="invalid-feedback" id="feedback-newuser_email"></div>
        </div>

        <div class="row"> 
            <label for="newuser_rolid" class="col-form-label">Rol de Usuario</label>
            <select class="form-control" name="rolid" id="newuser_rolid" required="">
                <option value="0">Selecciona un rol de usuario</option>
                <?php foreach($rollist AS $datarol): ?> 
                <option value="<?=$datarol->id_rol?>"><?=$datarol->rol?></option>
                <?php endforeach; ?>                
            </select>    
            <div class="invalid-feedback" id="feedback-newuser_rolid"></div>        
        </div>


        <div class="row"> 
            <label for="newuser_password" class="col-form-label">Contraseña</label>
            <input type="text" name="password" id="newuser_password" class="form-control" required="" >
            <div class="invalid-feedback" id="feedback-newuser_pass"></div>
        </div>

        <div class="row"> 
            <label for="confirmpassword" class="col-form-label">Confirma contraseña</label>
            <input type="text" name="confirmpassword" id="newuser_confirmpassword" class="form-control" required="" >            
            <div class="invalid-feedback" id="feedback-newuser_confirmpass"></div>
        </div> 

    </div> 
    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside reset_form" data-reset="reset_user" >Cancelar</button>
        <button type="button" data-function="validate_user" class="btn btn-primary send_form">Agregar Usuario</button>
    </div>
</form>  