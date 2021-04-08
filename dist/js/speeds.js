
function speed_formedit(id){
    $("#sidebar-content").html("");  
    $.ajax({
        type: "POST", 
        data: {id:id},
        url: "/Config/Speeds/view_speedconfig",
        success: function (response) { 
                       
                //Set speed information
              /*  $("#speed_id").val(speed.id_velocidad);
                $("#speed_name").val(speed.nombre,speed.id_velocidad);
                $("#speed_min").val(speed.minima);
                $("#speed_normal").val(speed.normal);
                $("#speed_regular").val(speed.regular);
                $("#speed_max").val(speed.maxima);
                $("#speed_unit").val(speed.unidad);*/
                //Show lateral form
            
                // Show edit button and hide add button              
                
                $("#sidebar-content").html(response);                 
                $('.openside').on('click', function () {
                    $('#settings').toggleClass('active');
                    return false;
                });
                $('#settings').addClass('active');
            
        }
    });
} 

 


    function min_vel(){
        if($("#speed_min").val() >  parseInt($("#speed_normal").val()) ){
            $("#speed_min").val(45);
        } 
    }

    function normal_vel() {  

        if($("#speed_normal").val() > parseInt($("#speed_regular").val()) ){
            $("#speed_normal").val(70);
        }
        
        if($("#speed_normal").val() < parseInt($("#speed_min").val()) ){
            $("#speed_normal").val(70);
        }
    }

    function regular_vel(){     
        if($("#speed_regular").val() > parseInt($("#speed_max").val()) ){
            $("#speed_regular").val(99);
        } 

        if($("#speed_regular").val() < parseInt($("#speed_normal").val()) ){
            $("#speed_regular").val(99);
        } 
    }

    function max_vel(){
        if($("#speed_max").val() > 150 ){
            $("#speed_max").val(100);
        }      
        
        if($("#speed_max").val() < parseInt($("#speed_regular").val()) ){
            $("#speed_max").val(100);
        } 
    }   
