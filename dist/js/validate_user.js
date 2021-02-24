$("#newuser_username").on('blur',function(){validate_username("#newuser_username","#feedback-newuser_username");});
$("#newuser_email").on('blur',function(){validate_email("#newuser_email","#feedback-newuser_email");});
$("#newuser_password").on('blur',function(){validate_password("#newuser_password","#feedback-newuser_pass","#newuser_confirmpassword","#feedback-newuser_confirmpass");});
$("#newuser_confirmpassword").on('blur',function(){confpass = validate_confirmpassword("#newuser_confirmpassword","#feedback-newuser_confirmpass","#newuser_password","#feedback-newuser_pass");});
$("#newuser_rolid").on('blur',function(){validate_userrol("#newuser_rolid","#feedback-newuser_rolid");});
$("#newuser_lastname").on('blur',function(){validate_lastname("#newuser_lastname","#feedback-newuser_lastname");});
$("#newuser_name").on('blur',function(){validate_name("#newuser_name","#feedback-newuser_name");});

function reset_user(){
    $("#user_newform .form-control").val("");
    $("#newuser_rolid").val("0");
    $("#user_newform .form-control").removeClass("invalid"); 
    $("#user_newform .form-control").removeClass("valid");
    $("#user_newform .invalid-feedback").css("display","none");
} 

function validate_edituser(){     
    var band = 1;
    if($("#conf_user").hasClass('invalid')){ console.log("user invalid"); band = 0; }
    if($("#conf_useremail").hasClass('invalid')){ band = 0;} 
    if($("#conf_userpassword").hasClass('invalid')){ band = 0;} 
    if($("#conf_userconfirmpassword").hasClass('invalid')){ band = 0;}  
    if($("#conf_username").hasClass('invalid')){ band = 0;}
    if($("#conf_userrol").hasClass('invalid')){ band = 0; }
    if($("#conf_usercompany").hasClass('invalid')){ band = 0; }
    if($("#conf_usersepromex").hasClass('invalid')){ band = 0; }

    if(band == 1){
        save_configform();
    }
}


function validate_user(){  
    var username = validate_username("#newuser_username","#feedback-newuser_username");    
    var email    = validate_email("#newuser_email","#feedback-newuser_email");                   
    var password = validate_password("#newuser_password","#feedback-newuser_pass","#newuser_confirmpassword","#feedback-newuser_confirmpass");    
    var confpass = validate_confirmpassword("#newuser_confirmpassword","#feedback-newuser_confirmpass","#newuser_password","#feedback-newuser_pass");    
    var rolid    = validate_userrol("#newuser_rolid","#feedback-newuser_rolid");
    var lastname = validate_lastname("#newuser_lastname","#feedback-newuser_lastname");
    var name     = validate_name("#newuser_name","#feedback-newuser_name");           
    var band = 1;
    if(username == "false"){ band = 0; }
    if(email == "false"){ band = 0; } 
    if(password == "false"){ band = 0; } 
    if(confpass == "false"){ band = 0; } 
    if(rolid == "false"){ band = 0; }
    if(lastname == "false"){ band = 0; }
    if(name == "false"){ band = 0; }
    if(band == 1){
        insert_newrow();
    }
}

function user_formedit(id){
    $.ajax({
        type: "POST",
        data: {id:id},
        url: "/Acount/User/view_userconfig",
        success: function (response) {              
           /* $("#conf_useridlabel").html(user.id_usuario);
            $("#conf_userid").val(user.id_usuario);
            $("#conf_user").val(user.usuario);            
            $("#conf_username").val(user.nombre);
            $("#conf_userlastname").val(user.apellido);            
            $("#conf_useremail").val(user.email);
            $("#conf_userstatus").val(user.estatus);
            $("#conf_userfechareg").html(user.fecha_reg);
            $("#conf_userpassword").val(user.password); 
            $("#conf_userconfirmpassword").val(user.password); */
            $("#acount-forms").html(response);            
            acount_formtoggle(); 
        } 
    });
}

var user_configform = document.getElementById('rol_configform');
if(user_configform){
user_configform.onsubmit = function(){ 
    $.ajax({
        type: "POST",
        data: $("#rol_configform").serialize(),
        url: "/Acount/Rol/update",
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
} 