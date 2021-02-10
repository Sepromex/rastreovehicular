<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i> Nuevo Rol de Usuario
    </h5> 
    <i class="icon-close icons openside h3"></i>     
</div>
<form class="add-contact-form needs-validation" id="rol_newform" novalidate>
    <div class="modal-body h-100">  

        <div class="row"> 
            <label for="rol_name" class="col-form-label">Rol</label>
            <input type="text" name="rol_name" id="rol_name" class="form-control" required="" >
        </div>

        <div class="row"> 
            <label for="rol_description" class="col-form-label">Descripción</label>
            <textarea name="rol_description" id="rol_description" class="form-control" required="" ></textarea>
        </div>  

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside">Cancelar</button>
        <button type="submit" class="btn btn-primary">Agregar Rol</button>
    </div>
</form> 
                     
<script>
    var user_form = document.getElementById('rol_newform');     
    user_form.onsubmit = function(){ 
         $.ajax({
            type: "POST",
            data: $("#rol_newform").serialize(),
            url: "<?=$include["body"]["add_url"]?>",
            success: function (response) { 
                if (response == "true") {
                    location.reload();                     
                } else {                            
                    alert(response); 
                }
            }
        }); 
    };
      
</script>