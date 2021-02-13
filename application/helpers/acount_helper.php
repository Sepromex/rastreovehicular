<?php
// USERS
function user_status($type){
    switch($type){
        case "1": $status = "Activo"; break;
        case "0": $status = "Inactivo"; break;
    }
    return $status;
}   
function user_toption($user_id){
    $data = ["edit_function"   => "user_formedit",
             "delete_function" => "user_delete",
             "id"              => $user_id];
    return listoption_template($data);
}  

// ROLES
function rol_status($type){ 
    switch($type){
        case "1": $status = "Activo"; break;
        case "0": $status = "Inactivo"; break;
    }
    return $status;
} 
function rol_toption($rol_id){
    $data = ["edit_function"   => "rol_formedit",
             "delete_function" => "rol_delete",
             "id"              => $rol_id];
    return listoption_template($data);
} 

// COMPANYS 
function company_toption($company_id){
    $data = ["edit_function"   => "company_formedit",
             "delete_function" => "list_delete",
             "id"              => $company_id];
    return listoption_template($data);
}

// CONTACTS 
function contact_toption($contact_id){
    $data = ["edit_function"   => "contact_formedit",
             "delete_function" => "list_delete",
             "id"              => $contact_id];
    return listoption_template($data);
}
?>