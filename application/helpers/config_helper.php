<?php 
//  Vehicles
function vehicle_toption($vehicle_id){
    $data = ["edit_function"   => "vehicle_formedit",
             "delete_function" => "list_delete",
             "id"              => $vehicle_id];
    return listoption_template($data);
}

//  Speeds
function speed_toption($speed_id){
    $data = ["edit_function"   => "speed_formedit",
             "delete_function" => "list_delete",
             "id"              => $speed_id];
    return listoption_template($data);
}
 
?>