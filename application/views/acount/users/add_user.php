<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i> Nuevo Usuario
    </h5>
     
        <i class="icon-close icons openside h3"></i>
     
</div>
<form class="add-contact-form needs-validation" id="user_newform" novalidate>
    <div class="modal-body h-100">  

        <div class="row"> 
            <label for="user" class="col-form-label">Usuario</label>
            <input type="text" name="user" id="user" class="form-control" required="" > 
        </div> 

        <div class="row"> 
            <label for="name" class="col-form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required="" >
        </div>

        <div class="row"> 
            <label for="lastname" class="col-form-label">Apellido</label>
            <input type="text" name="lastname" id="lastname" class="form-control" required="" >
        </div> 

        <div class="row"> 
            <label for="email" class="col-form-label">Correo electrónico</label>
            <input type="text" name="email" id="email" class="form-control" required="" >
        </div>

        <div class="row"> 
            <label for="rolid" class="col-form-label">Rol de Usuario</label>
            <select class="form-control" name="rolid" required="">
                <?php foreach($rollist as $rol): ?>
                <option value="<?=$rol->id_rol?>"><?=$rol->rol?></option>
                <?php endforeach; ?>                
            </select>            
        </div>


        <div class="row"> 
            <label for="password" class="col-form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required="" >
        </div>

        <div class="row"> 
            <label for="confirmpassword" class="col-form-label">Confirma contraseña</label>
            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" required="" >            
            <div class="invalid-feedback">
                Las contraseñas no coinciden
            </div>
        </div> 
         

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside">Cancelar</button>
        <button type="submit" class="btn btn-primary">Agregar Usuario</button>
    </div>
</form> 
                     
<script>
    var user_form = document.getElementById('user_newform');     
    user_form.onsubmit = function(){ 
         $.ajax({
            type: "POST", 
            data: $("#user_newform").serialize(),
             url: "<?=$include["body"]["add_url"]?>",
            success: function (response) { 
                if (response == "true") {
                    location.reload();                     
                } else {                            
                    alert(response);
                    $("#confirmpassword").attr('invalid');
                }
            }
        }); 
    };
      
</script>