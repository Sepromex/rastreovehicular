<?php
function  fileby_option($options){  
        $dtableurl   = "/dist/vendors/datatable";
        $datatable   = ["head"   => ["$dtableurl/css/dataTables.bootstrap4.min.css",
                                     "$dtableurl/buttons/css/buttons.bootstrap4.min.css"],            
                        "footer" => ["$dtableurl/js/jquery.dataTables.min.js",
                                    "$dtableurl/js/dataTables.bootstrap4.min.js",
                                    "$dtableurl/jszip/jszip.min.js",
                                    "$dtableurl/pdfmake/pdfmake.min.js",
                                    "$dtableurl/pdfmake/vfs_fonts.js",
                                    "$dtableurl/buttons/js/dataTables.buttons.min.js",
                                    "$dtableurl/buttons/js/buttons.bootstrap4.min.js",
                                    "$dtableurl/buttons/js/buttons.colVis.min.js",
                                    "$dtableurl/buttons/js/buttons.flash.min.js",
                                    "$dtableurl/buttons/js/buttons.html5.min.js",
                                    "$dtableurl/buttons/js/buttons.print.min.js",
                                    "$dtableurl/editor/mindmup-editabletable.js",
                                    "$dtableurl/editor/numeric-input-example.js"],
                        "scripts" => ["layouts/scripts/script_list"]];
        $icheck                 =   ["head"   =>  ["/dist/vendors/icheck/skins/all.css"],            
                                     "footer" =>  ["/dist/vendors/icheck/icheck.min.js"]];

        $allfiles               =   ["datatable" => $datatable, "icheck" => $icheck];  
       
        $return = [];

        foreach($options as $option){
            $return[$option] = $allfiles[$option];            
        }

        return $return;
}


function includefiles($page){
    $opt = [];
    switch($page){
        case "MainMap":
            $head        = ["dist/vendors/quill/quill.snow.css"];
            $body        = ["template" => ["map/map"]];
            $footer      = ["/dist/vendors/quill/quill.min.js","/dist/js/mail.script.js"];
        break;

        // ###### ACOUNT FILES ###### //
        case "Users": 
            $options = ["datatable"]; 
            $body        = ["template" => ["acount/config"],
                            "list"     => "acount/users/user_list",
                            "table"    => "/Acount/User/List",
                            "config"   => "acount/users/user_configform",
                            "add_url"  => "/Acount/User/new",                            
                            "sidebar"  => "acount/users/add_user"]; 
        break;

        case "Rol":
            $options = ["datatable","icheck"];
            $datatable   = "/dist/vendors/datatable";
            $body        = ["template" => ["acount/config"],
                            "list"     => "acount/roles/rol_list",
                            "table"    => "/Acount/Rol/List",
                            "config"   => "acount/roles/rol_configform",
                            "add_url"  => "/Acount/Rol/new",
                            "sidebar"  => "acount/roles/add_rol"];
        break;
        // **** Company files  => Acount/Contact **** //
        case "CompanyList":
            $options = ["datatable","icheck"];
            $body        = ["template" => ["acount/config"],
                            "list"     => "acount/company/company_list", 
                            "table"    => "/Acount/Companys/List",
                            "config"   => "acount/company/company_configform",
                            "add_url"  => "/Acount/Companys/new",
                            "sidebar"  => "acount/company/add_company",
                            "upconf"   => "/Acount/Companys/update",
                            "deleteit" => "/Acount/Companys/delete"]; 
        break; 

        case "MyCompany":
            $options = ["datatable","icheck"];            
            $body        = ["template" => ["acount/config"],  
                            "content"  => "acount/company/mycompany",  
                            "table"    => "/Acount/Companys/List",
                            "config"   => "acount/roles/rol_configform",
                            "add_url"  => "/Acount/Rol/new",
                            "sidebar"  => "acount/roles/add_rol"]; 
        break;

        case "BranchOffice":
            $options = ["datatable","icheck"]; 
            $body        = ["template" => ["acount/config"],
                            "list"     => "acount/company/company_list", 
                            "table"    => "/Acount/Companys/List",
                            "config"   => "acount/roles/rol_configform",
                            "add_url"  => "/Acount/Rol/new",
                            "sidebar"  => "acount/roles/add_rol"]; 
        break;
        // **** Contact files   => Acount/Contact **** //
        case "ContactList":
            $options = ["datatable","icheck"]; 
            $body        = ["template" => ["acount/config"],
                            "list"     => "acount/contact/contact_list", 
                            "table"    => "/Acount/Contact/List",
                            "config"   => "acount/contact/contact_configform",
                            "add_url"  => "/Acount/Contact/new",
                            "sidebar"  => "acount/contact/add_contact",
                            "upconf"   => "/Acount/Contact/update",
                            "deleteit" => "/Acount/Contact/delete"];  
        break;
        // ###### ACOUNT FILES ###### //        
    }

    if(isset($options)){
        if(!isset($head)){ $head = []; }
        if(!isset($footer)){ $footer = []; }
        if(!isset($scripts)){ $scripts = []; }

        $opt = fileby_option($options);  
        foreach($opt as $opts){  
            if(isset($opts["head"])){
                foreach($opts["head"] as $file){ 
                    array_push($head, $file); 
                }
            }
            if(isset($opts["head"])){
                foreach($opts["footer"] as $file){  
                    array_push($footer, $file); 
                }
            } 
            if(isset($opts["scripts"])){
                foreach($opts["scripts"] as $file){  
                    array_push($scripts, $file); 
                }
            } 
        }
    }

    $include = ["head" => $head, "body" => $body, "footer" => $footer, "scripts" => $scripts];    
    return $include;
}

?>