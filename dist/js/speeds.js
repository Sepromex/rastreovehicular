(function ($) {
    "use strict"; 
   

    if($("#speed_min")){
        $("#speed_min").blur(function() {          
            if($("#speed_min").val() >  parseInt($("#speed_normal").val()) ){
                $("#speed_min").val(10);
            } 
        }); 
    }

    if($("#speed_normal")){
        $("#speed_normal").blur(function() {  
            if($("#speed_normal").val() > parseInt($("#speed_regular").val()) ){
                $("#speed_normal").val(45);
            } 
        }); 
    }
    
    if($("#speed_regular")){
        $("#speed_regular").blur(function() {         
            if($("#speed_regular").val() > parseInt($("#speed_max").val()) ){
                $("#speed_regular").val(65);
            } 
        });
    }

    if($("#speed_max")){
        $("#speed_max").blur(function() {         
            if($("#speed_max").val() > 150 ){
                $("#speed_max").val(85);
            } 
        });
    }   
 

})(jQuery);

function speed_formedit(id){
    $.ajax({
        type: "POST", 
        data: {id:id},
        url: "/Config/Speeds/view_speedconfig",
        success: function (speed) { 
                       
                //Set speed information
                $("#speed_id").val(speed.id_velocidad);
                $("#speed_name").val(speed.nombre,speed.id_velocidad);
                $("#speed_min").val(speed.minima);
                $("#speed_normal").val(speed.normal);
                $("#speed_regular").val(speed.regular);
                $("#speed_max").val(speed.maxima);
                $("#speed_unit").val(speed.unidad);
                //Show lateral form
                $('#settings').toggleClass('active');
                // Show edit button and hide add button
                $("#btn_addspeed").addClass('form-hide');
                $("#btn_editpeed").removeClass('form-hide');         
            
        }
    });
} 

function reset_speed(){
    $("#btn_addspeed").removeClass('form-hide');
    $("#btn_editpeed").addClass('form-hide'); 

    $("#speed_id").val(0);
    $("#speed_name").val("");
    $("#speed_min").val(10);
    $("#speed_normal").val(65);
    $("#speed_regular").val(45);
    $("#speed_max").val(150);
    $("#speed_unit").val("km/h");
}