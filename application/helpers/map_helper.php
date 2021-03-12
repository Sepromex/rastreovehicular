<?php

function configentrieby_vehicle($obj,$i){ 
    $return = 0;
    switch($i){        
        case 2: $return = (isset($obj->E1_Act))?$obj->E1_Act:0; break;
        case 3: $return = (isset($obj->E1_Des))?$obj->E1_Des:0; break;
        case 4: $return = (isset($obj->E2_Act))?$obj->E2_Act:0; break;
        case 5: $return = (isset($obj->E2_Des))?$obj->E2_Des:0; break;
        case 6: $return = (isset($obj->E3_Act))?$obj->E3_Act:0; break;
        case 7: $return = (isset($obj->E3_Des))?$obj->E3_Des:0; break;
        case 8: $return = (isset($obj->E4_Act))?$obj->E4_Act:0; break;
        case 9: $return = (isset($obj->E4_Des))?$obj->E4_Des:0; break;
    }
    return $return;     
}


?>
