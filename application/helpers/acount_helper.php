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
             "delete_function" => "list_delete",
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
             "delete_function" => "list_delete",
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

// OFFICE
function office_toption($office_id,$company_id){
    $data = ["edit_function"   => "office_formedit",
             "delete_function" => "list_delete",
             "id"              => $office_id,
             "id2"             => $company_id];
    return listoption_template($data,2);
}

// CONTACTS 
function contact_toption($contact_id){
    $data = ["edit_function"   => "contact_formedit",
             "delete_function" => "list_delete",
             "id"              => $contact_id];
    return listoption_template($data);
}
?>