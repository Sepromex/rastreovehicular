<script> 
(function ($) {
    "use strict"; 
    
    if($(".inputnumber")){
        $(".inputnumber").keydown(function(event) {
                if(event.shiftKey)
                {
                        event.preventDefault();
                }

                if (event.keyCode == 46 || event.keyCode == 8)    {
                }
                else {
                        if (event.keyCode < 95) {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                                event.preventDefault();
                        }
                        } 
                        else {
                            if (event.keyCode < 96 || event.keyCode > 105) {
                                event.preventDefault();
                            }
                        }
                    }
        });
    }

    $('[data-masked]').inputmask(); 
    $(".select-form").select2();
    

    if($('.send_form')){
        $('.send_form').on('click', function () {                           	
            var name = $(this).data("function");           
            self[name]();   
        });
    }
 
    if($('.reset_form')){
        $('.reset_form').on('click', function () {                           	
            var name = $(this).data("reset");           
            self[name]();  
        });
    }

    var table_list = '<?=$include["body"]["table"]?>';
    if(table_list){
        if($('#example')){
            $('#example').DataTable({
                dom: 'Bfrtip', 
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ],                
                responsive: true,
                ajax: '<?=$include["body"]["table"]?>'
            });  
        }
    }

})(jQuery);
 
function validate_editcontact(){
    var band = 1;
    var name    = general_validate('#conf_contactname','#feedback-confcontactname');    
    var email   = validate_email('#conf_contactemail','#feedback-confcontactemail');
    var phone   = validate_phonemask('#conf_contactphone','#feedback-confcontactphone',1);
    var horario = general_validate('#conf_contactailable','#feedback-confcontactailable');
    var company = validate_select('#conf_contactcompanyid','#feedback-confcontactcompanyid');
             
    if(name == "false"){ band = 0; }        
    if(email == "false"){ band = 0; }    
    if(phone == "false"){ band = 0; }    
    if(horario == "false"){ band = 0; }    
    if(company == "false"){ band = 0; }   

    if(band == 1){
        save_configform();       
    }
}

function validate_contact(){
    var band = 1;
    var name    = general_validate('#contact_name','#feedback-contactname');
    //var puesto  = general_validate('#contact_job','#feedback-contactjob');
    var email   = validate_email('#contact_email','#feedback-contactemail');
    var phone   = validate_phonemask('#contact_phone','#feedback-contactphone',1);
    var horario = general_validate('#contact_available','#feedback-contactavailable');
    var company = validate_select('#contact_companyid','#feedback-contactcompanyid');
    //var user    = validate_select('#contact_userid','#feedback-contactuserid');
         
    if(name == "false"){ band = 0; }    
    //if(puesto == "false"){ band = 0; }    
    if(email == "false"){ band = 0; }    
    if(phone == "false"){ band = 0; }    
    if(horario == "false"){ band = 0; }    
    if(company == "false"){ band = 0; }
    //if(user == "false"){ band = 0; }       

    if(band == 1){        
        insert_newrow();        
    }            

}


function validate_form(form,type = "config",func = "0"){    
    $("#"+form).addClass('was-validated');    
    if ($("#"+form)[0].checkValidity() === false) {                
        return false;
    }  
    else{                   	
        if(func != "0"){
            console.log(func);
           // self[func](); 
        }else{
            if(type == "new"){insert_newrow();}
            if(type == "config"){ save_configform(); }
        }        
    }    
}  

function validate_company(){
    var band = 1;
    var companytype = validate_select('#conf_companytype','#feedback-confcompanytype');
    var phone = validate_phonemask("#conf_companyphone","#feedback-confcompanyphone",1);
    var category = validate_select('#conf_companytype','#feedback-confcompanytype');

    if($("#conf_companyname").hasClass('invalid')){ band = 0; }
    if($("#conf_companyagent").hasClass('invalid')){ band = 0;} 
    if($("#conf_companyrfc").hasClass('invalid')){ band = 0;}         
    if(companytype == "false"){ band = 0; }    
    if(phone == "false"){ band = 0; }    
    if(category == "false"){ band = 0; }    

    if(band == 1){        
        save_configform();        
    }

}

//Show config form
function general_formtoggle(){
    $('#general-content').toggleClass('form-hide');
    $('#general-forms').toggleClass('form-hide');  
}

//Show config form
function acount_formtoggle(){
    $('#acount-content').toggleClass('form-hide');
    $('#acount-forms').toggleClass('form-hide');  
}

// Insert New Row
function insert_newrow(){
    $.ajax({
        type: "POST", 
        data: $("#<?=$custom["prefix"]?>_newform").serialize(),
            url: "<?=$include["body"]["add_url"]?>",
        success: function (response) { 
            if (response == "true") {
                location.reload();                     
            } else {                            
                alert(response); 
            }
        }
    }); 
}
  

// Save Config Form
function save_configform(){  
    $.ajax({ 
        type: "POST",
        data: $("#<?=$custom["prefix"]?>_configform").serialize(), 
        url: "<?=$include["body"]["upconf"]?>", 
        success: function (response) {             
             if (response == "true") {
                location.reload(); 
            } else {   
                if (response == "true_") {
                    $('#settings').removeClass('active');
                } else {                            
                    alert(response);
                }                          
                
             }             
        }
    }); 
} 
   
// Delete list element
function list_delete(id){
    $.ajax({ 
        type: "POST",
        data: {id:id},
        url: "<?=$include["body"]["deleteit"]?>", 
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

// View Contact Config form
function contact_formedit(id){
    $.ajax({
        type: "POST",
        data: {id:id},
        url: "/Acount/contact/view_contactconfig",
        success: function (contact) { 
            console.log(contact.id_empresa);
            console.log(contact.id_usuario);
            $("#conf_contactid").val(contact.id_contacto);
            $("#conf_contactidlabel").html(contact.id_contacto);
            $("#conf_contactfechareg").html(contact.fecha_reg);
            $("#conf_contactname").val(contact.nombre);
            $("#conf_contactailable").val(contact.horario);
            $("#conf_contactjob").val(contact.puesto);
            $("#conf_contactemail").val(contact.email);
            $("#conf_contactphone").val(contact.telefono);

            //document.getElementById("conf_contactcompanyid").value =  '"'+contact.id_empresa+'"';
            //$("#contact_configform #conf_contactcompanyid option[value='"+contact.id_empresa+"']").attr("selected","true");

            $("#contact_configform #conf_contactcompanyid").val(contact.id_empresa);
            $("#contact_configform #conf_contactcompanyid").change();
            
            //$("#conf_contactcompanyid");

            //document.getElementById("conf_contactuserid").value = contact.id_usuario;

            //$("#contact_configform #conf_contactuserid option[value='"+ contact.id_usuario +"']").prop("selected","true"); 000000001029"
            //var us = 000000001029
            $("#contact_configform #conf_contactuserid").val(contact.id_usuario);
            $("#contact_configform #conf_contactuserid").change(); 
            

            acount_formtoggle();
        } 
    });
}  

// View Company Config Form
function company_formedit(id){
    $.ajax({
        type: "POST",
        data: {id:id},
        url: "/Acount/companys/view_companyconfig",
        success: function (response) {  
            //var company = response.company;
            //var contactofficelist = response.contactofficelist;

            /*$("#company_labelname").html(company.razon_social);
            $("#company_labeltype").html(company.giro);
            $("#company_labeldate").html(company.fecha_reg);                        
            $("#conf_companyid").val(company.id_empresa);
            $("#conf_companyname").val(company.razon_social);
            $("#conf_companytype").val(company.giro);
            $("#conf_companyrfc").val(company.rfc);
            $("#conf_companyagent").val(company.representante);
            $("#conf_companyemail").val(company.email);
            $("#conf_companyphone").val(company.telefono);           
            $("#conf_companystatus").val(company.estatus);
            $("#conf_companycontactid").val(company.id_contacto);            
            $("#conf_companyaddress").val(company.direccion);
            $("#conf_companysub").val(company.colonia);
            $("#conf_companycity").val(company.ciudad);
            $("#conf_companystate").val(company.estado);*/ 

            $("#acount-forms").html(response);
            acount_formtoggle();
        } 
    });
}

function office_formedit(id,company){
    $.ajax({
        type: "POST",
        data: {id:id,id_company:company},
        url: "/Acount/office/view_officeconfig",
        success: function (response) {        
            $("#general-forms").html(response);
            acount_formtoggle();
        } 
    });
} 




function checkbyclass(clas,id){ 
    if($("#check_"+clas+id).is(":checked")){
        $(".check_"+clas+id).each( function() {
            $(this).attr('checked', true);
        });
        if(clas != "read"){
            $(".check_read"+id).each( function() {
                $(this).attr('checked', true);
            });
            $("#check_read"+id).attr('checked', true); 
        }
    }else{
        $(".check_"+clas+id).each( function() {
            $(this).attr('checked', false);
        });
    } 
}

function crean_checkform(){  
    $(".skin-square input:checkbox").each( function() {
            $(this).attr('checked', false);
    });
}
 

function rol_formedit(id){
    $.ajax({
        type: "POST",
        data: {id:id},
        url: "/Acount/Rol/view_rolconfig",
        success: function (response) { 
            crean_checkform();             
            var rol = response.rol;
            $("#conf_rolidlabel").html(rol.id_rol);
            $("#conf_rolid").val(rol.id_rol);
            $("#conf_rolfechareg").html(rol.fecha_reg);
            $("#conf_rolname").val(rol.rol);
            $("#conf_rolstatus").val(rol.estatus);
            $("#conf_roldescription").val(rol.descripcion);   
            

            if(response.access.length>0){
                $.each(response.access, function(i, acs) { 
                    var idcheck =  acs.id_modulo+acs.id_submodulo;                  
                    if(acs.insertar == "1"){                                                
                        $("#check_insert"+idcheck).attr('checked', true);                                                
                    }
                    if(acs.editar == "1"){                                                
                        $("#check_edit"+idcheck).attr('checked', true);                                                
                    }
                    if(acs.eliminar == "1"){                                                
                        $("#check_delete"+idcheck).attr('checked', true);                                                
                    }
                    if(acs.leer == "1"){                                                
                        $("#check_read"+idcheck).attr('checked', true);                                                
                    }   
                });   
            } 

            acount_formtoggle();

        }
    });
}

function edit_vehicle(){
    $.ajax({
        type: "POST", 
        data: $("#vehedit_configform").serialize(),
            url: "/Config/Vehicles/vehicle_update",
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
function vehicle_formedit(id){
    $.ajax({ 
        type: "POST", 
        data: {id:id},
        url: "/Config/Vehicles/vehicle_edit",
        success: function (response) { 
            $("#sidebar-content").html(response); 
            $('#settings').toggleClass('active');
            $('.openside').on('click', function () {
                $('#settings').toggleClass('active');
                return false;
            });            
        }
    });


    /*$.ajax({
        type: "POST",
        data: {id:id},
        url: "/Config/Vehicles/view_vehicleconfig",
        success: function (response) {
            $("#general-forms").html(response);
            general_formtoggle();
        }
    });*/
} 


</script>