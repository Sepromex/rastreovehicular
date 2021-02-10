<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i>  &nbsp; Configurar Usuario
    </h5>     
    <i class="icon-close icons h3" onclick="acount_formtoggle()"></i>     
</div>
<form class="add-contact-form needs-validation" id="user_configform" novalidate>
    <div class="modal-body h-100">  
        <div class="form-row">
            <div class="form-group col-md-4">
                <label><b>ID:</b></label>
                <label id="conf_useridlabel"></label>
                <input type="hidden" name="conf_userid" id="conf_userid">
            </div>  
            <div class="form-group col-md-4"> 
                <label><b>Fecha de creación:</b></label>
                <label id="conf_userfechareg"></label> 
            </div>  
            <div class="form-group col-md-4">
                <label><b>Rol de usuario:</b></label>
                <select class="form-control" name="rolid">
                    <?php foreach($rollist as $rol): ?>
                    <option><?=$rol->rol?></option>
                    <?php endforeach; ?>
                </select>                
            </div>
        </div> 

        <div class="form-row"> 
            <div class="form-group col-md-4">
                <label for="conf_user">Usuario</label>
                <input type="text" class="form-control rounded" id="conf_user" name="conf_user"  required="">
            </div> 
            <div class="form-group col-md-4">
                <label for="conf_username">Nombre</label>
                <input type="text" class="form-control" id="conf_username" name="conf_username"  required="">
            </div> 
            <div class="form-group col-md-4">
                <label for="conf_userlastname">Apellido</label>
                <input type="text" class="form-control rounded" id="conf_userlastname" name="conf_userlastname"  required="">
            </div>    
        </div> 


        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="conf_useremail">Correo</label>
                <input type="email" class="form-control rounded" id="conf_useremail" name="conf_useremail"  required="">
            </div>  
            <div class="form-group col-md-4">
                <label for="conf_userfechainicio">Fecha de Inicio</label>
                <input type="date" class="form-control rounded" id="conf_userfechainicio" name="conf_userfechainicio">
            </div>
            <div class="form-group col-md-4">
                <label for="conf_userfechafin">Fecha de Finalización</label>
                <input type="date" class="form-control rounded" id="conf_userfechafin" name="conf_userfechafin">
            </div>  
        </div>

        <div class="form-row"> 
            <div class="form-group col-md-4">
                <label for="conf_userstatus">Estatus</label>
                <select class="form-control" id="conf_userstatus" name="conf_userstatus"  required="">                     
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>                     
                </select>   
            </div> 
            <div class="form-group col-md-4">
                <label for="conf_userconfirmpassword">Confirma Contraseña</label>
                <input type="text" class="form-control" id="conf_userpassword" name="conf_userconfirmpassword"  required="">
            </div>
            <div class="form-group col-md-4">
                <label for="conf_userpassword">Confirma Contraseña</label>
                <input type="text" class="form-control" id="conf_userconfirmpassword" name="conf_userpassword"  required="">
            </div>
        </div>   
         
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="acount_formtoggle()">Cancelar</button>
        <button type="submit" class="btn btn-primary">Editar Usuario</button>
    </div>
</form>   

<script> 
 
var user_configform = document.getElementById('user_configform');     
user_configform.onsubmit = function(){ 
    $.ajax({
        type: "POST",
        data: $("#user_configform").serialize(),
        url: "/Acount/User/update",
        success: function (response) { 
            if (response == "true") {
                location.reload();

            } else {                            
                alert(response);
            //    $("#confirmpassword").attr('invalid');
            }
            
        }
    }); 
};

function user_formedit(id){
    $.ajax({
        type: "POST",
        data: {id:id},
        url: "/Acount/User/view_userconfig",
        success: function (user) {              
            $("#conf_useridlabel").html(user.id_usuario);
            $("#conf_userid").val(user.id_usuario);
            $("#conf_user").val(user.usuario);            
            $("#conf_username").val(user.nombre);
            $("#conf_userlastname").val(user.apellido);            
            $("#conf_useremail").val(user.email);
            $("#conf_userstatus").val(user.estatus);
            $("#conf_userfechareg").html(user.fecha_reg);
            $("#conf_userpassword").val(user.password); 
            $("#conf_userconfirmpassword").val(user.password); 
            acount_formtoggle(); 
        } 
    });
}

function user_delete(id){
    $.ajax({
        type: "POST",
        data: {id:id},
        url: "/Acount/User/delete",
        success: function (response) {              
            console.log(response); 
            if (response == "true") {
                location.reload(); 
            } else {                            
                alert(response); 
            }
            
        }
    });
} 




</script> 