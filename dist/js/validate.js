function general_validate(id,feedback){
    if($(id).val().length > 1) {        
        valid_input(id,feedback);
        return "true";
    }
    else{
        mns = "* Campo requerido";
        invalid_input(id,feedback,mns);
        return "false";
    }
}

function validate_select(id,feedback){
    if($(id).val() == 0) {        
        mns = "* Campo requerido, seleccione una opción";
        invalid_input(id,feedback,mns);
        return "false";
    }
    else{
        valid_input(id,feedback);
        return "true";
    }
} 

function validate_lastname(id,feedback){
    if($(id).val().length < 4) {        
        mns = "* Campo requerido, el apellido debe ser mayor 4 carácteres";
        invalid_input(id,feedback,mns);
        return "false";
    }
    else{
        valid_input(id,feedback);
        return "true";
    }
} 

function validate_name(id,feedback){ 
    
    if($(id)){
    
    if($(id).val().length < 4) {
        mns = "* Campo requerido, el nombre debe ser mayor 4 carácteres";
        invalid_input(id,feedback,mns);
        return "false";
    }
    else{
        valid_input(id,feedback);
        return "true";
    }
    }
    
}

function validate_namenotreq(id,feedback){    
    var val = $(id).val().trim();
    if(val.length < 4) {        
        if(val.length == 0) {
            valid_input(id,feedback);
            return "true";
        }else{
            mns = "* Campo requerido, el nombre debe ser mayor 4 carácteres";
            invalid_input(id,feedback,mns);
            return "false";
        }
    }
    else{
        valid_input(id,feedback);
        return "true";
    }
}


function validate_userrol(id,feedback){
    if ($(id).val() == 0) {                   
        mns = "Selecciona un rol de usuario";        
        invalid_input(id,feedback,mns);
        return "false";
    }
    else{
        valid_input(id,feedback);
        return "true";
    }
}

function validate_sitetype(id,feedback){
    if ($(id).val() == 0) {                   
        mns = "Selecciona un tipo de sitio";        
        invalid_input(id,feedback,mns);
        return "false";
    }
    else{
        valid_input(id,feedback);
        return "true";
    }
}

function validate_confirmpassword(id,feedback,idconf,feedbackconf){
    if($(id).val().length > 5){             
        if ($(id).val() == $(idconf).val()) {            
            valid_input(id,feedback);
            valid_input(idconf,feedbackconf);           
            return "true";
        }
        else{            
            mns = "Las contraseñas no coinciden";        
            invalid_input(id,feedback,mns);            
            invalid_input(idconf,feedbackconf);
            return "false";
        }
    }else{
        $(feedback).html("La contraseña es muy corta");
        $(feedback).css("display","block");
        $(id).removeClass('valid');
        $(id).addClass('invalid');
        return "false";
    }
}

function validate_password(id,feedback,idconf,feedbackconf){
    if($(id).val().length > 5){             
        if ($(id).val() == $(idconf).val()) {  
            valid_input(id,feedback);
            valid_input(idconf,feedbackconf);    
            return "true";
        } 
        else{
            mns = "Las contraseñas no coinciden";        
            invalid_input(id,feedback);
            invalid_input(idconf,feedbackconf,mns);
            return "false";
        }
    }else{            
        mns = "La contraseña es muy corta";        
        invalid_input(id,feedback);
        return "false";
    }
}
 
function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test(email);
}

function validate_email(id,feedback,edit=""){
    if(edit.trim() == $(id).val()){     
        valid_input(id,feedback);
        return "true";
    }else{
        if($(id).val().length > 0){
            if(validateEmail($(id).val())){
                $.ajax({
                    type: "POST", 
                    data: {email:$(id).val()},
                    url: "/Acount/User/validate_email",
                    success: function (response) { 
                        if (response == "false"){                                   
                            mns = "El correo electrónico ya existe en nuestra base de datos";
                            invalid_input(id,feedback,mns);   
                            return "false";
                        }else{
                            valid_input(id,feedback);
                            return "true";
                        }
                    }
                });
            }else{
                mns = "Email invalido";        
                invalid_input(id,feedback,mns);          
                return "false";
            }
        }else{         
            mns = "* Campo requerido";
            invalid_input(id,feedback,mns);
            return "false";
        }
    }
}

function validate_username(id,feedback,edit =""){
    if(edit.trim() == $(id).val()){     
        valid_input(id,feedback);
        return "true";
    }else{
        if($(id).val().length > 3){
            console.log($(id).val().length );
            $.ajax({
                type: "POST", 
                data: {name:$(id).val()},
                url: "/Acount/User/validate_name",
                success: function (response) { 
                    if (response == "true") {  
                        valid_input(id,feedback);
                        return "true";
                    } 
                    else{
                        mns = "El usuario ya existe en nuestra base de datos";
                        invalid_input(id,feedback,mns);
                        return "false";
                    }
                }
            }); 
        }
        else{        
            mns = "El usuario debe ser de almenos 3 caracteres";
            invalid_input(id,feedback,mns);
            return "false";      
        }
    }
}

function validate_phonemask(id,feedback,req = 0) { 
    var phone = $(id).val();      
    var phone = phone.replace(/[\W_]+/g, '');      
    if (phone.length == 10) {                          
        valid_input(id,feedback);
        return "true";        
    }
    else{
        if(req == 1 && phone.length == 0){
            valid_input(id,feedback);
            return "true";
        }else{
            mns = "Teléfono debe ser de 10 díjitos";        
            invalid_input(id,feedback,mns);
            return "false";
        }        
    } 
}


function valid_input(id,feedback){
    $(feedback).css("display","none");
    $(id).removeClass('invalid');
    $(id).addClass('valid');
}


function invalid_input(id,feedback,mns=""){
    $(feedback).html(mns);
    $(feedback).css("display","block");    
    $(id).removeClass('valid');
    $(id).addClass('invalid'); 
} 