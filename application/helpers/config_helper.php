<?php 
//  Vehicles
function vehicle_toption($vehicle_id){
    $data = ["edit_function"   => "vehicle_formedit",
             "delete_function" => "list_delete", 
             "id"              => $vehicle_id];
    return listoption_template2($data);
}

//  Speeds
function speed_toption($speed_id){
    $data = ["edit_function"   => "speed_formedit",
             "delete_function" => "list_delete",
             "id"              => $speed_id];
    return listoption_template($data);
} 

function listoption_template2($data,$items = 0){    
    $edit   = $data["edit_function"]."('".$data["id"]."')";
    $delete = "speed_formedit('".$data["id"]."')";
    
    if($items != 0){
        $edit   = $data["edit_function"].'('.$data["id"].','.$data["id2"].')';        
    }    
        
    $icon = '<div class="my-auto line-h-1 h5 text-center">
                <a class="text-success openside" onclick="'.$edit.'">
                    <i class="icon-pencil"></i>
                </a>
                <a class="text-danger openside" onclick="'.$delete.'">
                    <i class="icon-speedometer"></i>
                </a>
            </div>';
    return $icon; 
}
 
?>