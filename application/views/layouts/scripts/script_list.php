<script> 
(function ($) {    
    "use strict";
    var editor;
  $('#example').editableTableWidget({editor: $('<textarea>')});
  $('#example').DataTable({
    dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],                
    responsive: true,
    ajax: '<?=$include["body"]["table"]?>'
 }); 
 /*$('.skin-square input').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-red',
        increaseArea: '20%' // optional
 }); */
})(jQuery);  

function acount_formtoggle(){
    $('#acount-content').toggleClass('form-hide');
    $('#acount-forms').toggleClass('form-hide');  
}

// Insert New Row
var newelement_form = document.getElementById('<?=$custom["prefix"]?>_newform');     
    newelement_form.onsubmit = function(){ 
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
    };  

// Save Config Form
var configform = document.getElementById('<?=$custom["prefix"]?>_configform');     
    configform.onsubmit = function(){ 
    $.ajax({
        type: "POST",
        data: $("#<?=$custom["prefix"]?>_configform").serialize(),
        url: "<?=$include["body"]["upconf"]?>",
        success: function (response) {             
             if (response == "true") {
                location.reload(); 
            } else {                            
                alert(response);
             }             
        }
    }); 
}; 

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
            $("#conf_companyidlabel").html(contact.id_empresa);
            $("#conf_companyidlabel").html(contact.fecha_reg);            
            $("#conf_companyid").val(contact.id_empresa);
            $("#conf_companyuserid").val(contact.giro);            
            $("#conf_companystatus").val(contact.estatus);
            $("#conf_companyname").val(contact.nombre);
            $("#conf_companyailable").val(contact.horario);
            $("#conf_companyjob").val(contact.puesto);
            $("#conf_companyemail").val(contact.email);            
            $("#conf_companyphone").val(contact.telefono); 
            $("#conf_companylocation").val(contact.ubicacion); 
            $("#conf_companycompanyid").val(contact.id_empresa);   
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
        success: function (company) {        
 
            $("#company_labelname").html(company.razon_social);
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
            $("#conf_companystate").val(company.estado); 

             acount_formtoggle();
        } 
    });
}
</script>