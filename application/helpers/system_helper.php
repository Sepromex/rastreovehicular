<?php
function print_array($array){
    echo "<pre>";    
    print_r($array);
    echo "</pre>";   
}
function base_url(){ 
    //$_SERVER['SERVER_NAME'];
    /*echo $_SERVER['SERVER_NAME']." --- ";
        echo $_SERVER['REQUEST_URI'];*/
        return "/rv";
}

function listoption_template($data,$items = 0){    
    $edit   = $data["edit_function"]."('".$data["id"]."')";
    $delete = $data["delete_function"]."('".$data["id"]."')";
    
    if($items != 0){
        $edit   = $data["edit_function"].'('.$data["id"].','.$data["id2"].')';        
    }    
        
    $icon = '<div class="my-auto line-h-1 h5 text-center">
                <a class="text-success openside" onclick="'.$edit.'">
                    <i class="icon-pencil"></i>
                </a>
                <a class="text-danger openside" onclick="'.$delete.'">
                    <i class="icon-trash"></i>
                </a>
            </div>';
    return $icon; 
}

function generalstatus($type){
    switch($type){
        case "1": $status = "Activo"; break;
        case "0": $status = "Inactivo"; break;
    }
    return $status;
}
function monthtochar($mes){
    $mess = 'Indefinido';
    switch($mes){
        case 1: $mess='Ene'; break;
        case 2: $mess='Feb'; break;
        case 3: $mess='Mar'; break;
        case 4: $mess='Abr'; break;
        case 5: $mess='May'; break;
        case 6: $mess='Jun'; break;
        case 7: $mess='Jul'; break;
        case 8: $mess='Ago'; break;
        case 9: $mess='Sep'; break;
        case 10: $mess='Oct'; break;
        case 11: $mess='Nov'; break;
        case 12: $mess='Dic'; break;
    }
    return $mess;
}

?>