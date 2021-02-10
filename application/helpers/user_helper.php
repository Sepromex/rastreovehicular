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
    $icon = '<div class="my-auto line-h-1 h5 text-center">
                <a class="text-success openside" onclick="user_formedit('.$user_id.')">
                    <i class="icon-pencil"></i>
                </a>
                <a class="text-danger openside" onclick="user_delete('.$user_id.')">
                    <i class="icon-trash"></i>
                </a>
            </div>';    
    return $icon;
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
    $icon = '<div class="my-auto line-h-1 h5 text-center">
                <a class="text-success openside" onclick="rol_formedit('.$rol_id.')">
                    <i class="icon-pencil"></i>
                </a>
                <a class="text-danger openside" onclick="rol_delete('.$rol_id.')">
                    <i class="icon-trash"></i>
                </a>
            </div>';    
    return $icon;
}

?>