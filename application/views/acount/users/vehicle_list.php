<div class="row mt-3"> 
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h4 class="card-title">Vehículos</h4>
            </div> 
            <div class="card-body">                  
                <div class="form-row"> 
                    <div class="form-group col-md-10">
                        <label for="conf_usersepromex">Asignar vehiculos</label>                        
                        <select class="form-control select-form" id="vehicles_company">
                            <option value="0">Selecciona un vehiculo</option>
                            <?php if(isset($vehiclelist)): if(is_array($vehiclelist)): ?>
                                <?php foreach($vehiclelist as $vl): ?>
                                    <option value="<?=$vl->id_vehiculo?>"><?=$vl->vehiculo." ".$vl->placas." ".$vl->modelo?></option>
                                <?php endforeach; ?>
                            <?php endif; endif; ?>
                        </select>
                        <div class="invalid-feedback" id="feedback-confusersepromex"></div>
                    </div>
                    <div class="form-group col-md-2"> 
                        <button type="button" class="btn btn-success mt-4 float-right" onclick="assign_vehicle()">Asignar Vehiculo</button>
                    </div>                     
                </div>                 
            </div>                 
        </div> 
    </div> 
</div> 
 
<?php if(isset($assignedvehicles)): if(is_array($assignedvehicles)): ?>
<div class="row mt-3"> 
    <div class="col-xl-12">
        <div class="card">           
            <div class="card-body p-0">
                <div class="contacts list" id="vehicle_itemslist">
                <?php foreach($assignedvehicles as $vl): //id_vehiculo ?>
                    <div class="contact family-contact p-0">                             
                        <div class="contact-content" style="min-width:300px;">
                            <div class="contact-profile col-md-4">                                                   
                                <div class="contact-info">
                                    <p class="mb-0 small">Vehículo </p>
                                    <p class="contact-name mb-0"><?=$vl->vehiculo?></p>
                                </div>
                            </div>
                            <div class="contact-email col-md-3">
                                <p class="mb-0 small">Placas </p>
                                <p class="user-email"><?=$vl->placas?></p>
                                <p class="user-phone"></p>
                            </div> 
                            <div class="contact-phone col-md-3">
                                <p class="mb-0 small">Modelo: </p>
                                <p class="user-phone"><?=$vl->modelo?></p>
                            </div>
                            <div class="line-h-1 h5  col-md-2">
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div> 
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>                 
        </div> 
    </div> 
</div>
<?php endif; endif; ?>

<script>

function changeselectveh(companyid){    
    if(companyid > 0){
        $("#vehicles_company").empty();
        $.ajax({  
            type: "POST",  
            data: { company_id: companyid},                                
            url: "/Acount/User/uservehicles",
            success: function(response) {                
                var select_input   = document.getElementById("vehicles_company");
                if(response.length>0){                                        
                    $.each(response, function(i, item) {                                                
                        if (item.id != "") {  
                            var option   = document.createElement("option");
                            option.text  = item.vehiculo+' '+item.placas+' '+item.modelo;
                            option.value = item.id_vehiculo;
                            select_input.add(option, select_input[i]);
                        }  
                    });                       
                }else{
                    var option   = document.createElement("option");
                        option.text  = "Selecciona un vehiculo";
                        option.value = "0";
                        select_input.add(option);                        
                }
                $("#vehicles_company").trigger('change'); 
            }
        });  
    } 
}

    function assign_vehicle(){ 
        var id_veh  = $("#vehicles_company").val();
        var user_id = $("#conf_userid").val();
        $.ajax({
        type: "POST",
        data: {id:id_veh, user: user_id},
        url: "/Acount/User/assign_vehicles",
        success: function (response) {  
                if(response.insert == "true"){
                    var v = response.vehicle[0];
                    var template = '<div class="contact family-contact p-0" id="uservehicle'+v.id_vehiculo+'">'+                         
                        '<div class="contact-content" style="min-width:300px;">'+
                            '<div class="contact-profile col-md-4">'+
                                '<div class="contact-info">'+
                                    '<p class="mb-0 small">Vehículo </p>'+
                                    '<p class="contact-name mb-0">'+v.vehiculo+'</p>'+
                                '</div>'+
                            '</div>'+
                            '<div class="contact-email col-md-3">'+
                                '<p class="mb-0 small">Placas </p>'+
                                '<p class="user-email"> '+ v.placas +' </p>'+ 
                            '</div>'+ 
                            '<div class="contact-phone col-md-3">'+
                                '<p class="mb-0 small">Modelo: </p>'+
                                '<p class="user-phone"> '+ v.modelo +' </p>'+
                            '</div>'+
                            '<div class="line-h-1 h5  col-md-2">'+
                                '<a class="text-danger delete-contact" href="#" onclick="delete_uservehicle('+v.id_vehiculo+')"><i class="icon-trash"></i></a>'+
                            '</div>'+ 
                        '</div>'+
                       '</div>';

                    $("#vehicles_company").val("0");
                    $("#vehicles_company").trigger('change');
                    $("#vehicle_itemslist").append(template);
                }
                else{
                    if(response.insert == "2"){
                        alert("El vehiculo ya está asignado al usuario");
                    }else{
                        alert("Ocurrio un error!");
                    }
                }         
            } 
        });
    }

    function delete_uservehicle(id){                      
        jQuery.ajax({
            type: "POST",
            data: {id:id},
            url: "/Acount/User/delete_vechilce",            
            success: function(response) {                        
                if(response == "true"){
                    $("#uservehicle"+id).remove(); 
                }                                                  
                    
            } 
        });
    }
</script>