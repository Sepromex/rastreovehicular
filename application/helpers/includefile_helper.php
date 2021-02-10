<?php
function includefiles($page){
    switch($page){
        case "MainMap":
            $head        = ["dist/vendors/quill/quill.snow.css"];
            $body        = ["template" => ["map/map"]];
            $footer      = ["/dist/vendors/quill/quill.min.js","/dist/js/mail.script.js"];
        break; 
        case "Users":
            $datatable   = "/dist/vendors/datatable";
            $head        = ["$datatable/css/dataTables.bootstrap4.min.css",
					        "$datatable/buttons/css/buttons.bootstrap4.min.css",
                            "/dist/vendors/icheck/skins/all.css"];
            $body        = ["template" => ["acount/config"],
                            "list"     => "acount/users/user_list",
                            "table"    => "/Acount/User/List",
                            "config"   => "acount/users/user_configform",
                            "add_url"  => "/Acount/User/new",                            
                            "sidebar"  => "acount/users/add_user"];
            $footer      = ["$datatable/js/jquery.dataTables.min.js",
                            "$datatable/js/dataTables.bootstrap4.min.js",
                            "$datatable/jszip/jszip.min.js",
                            "$datatable/pdfmake/pdfmake.min.js",
                            "$datatable/pdfmake/vfs_fonts.js",
                            "$datatable/buttons/js/dataTables.buttons.min.js",
                            "$datatable/buttons/js/buttons.bootstrap4.min.js",
                            "$datatable/buttons/js/buttons.colVis.min.js",
                            "$datatable/buttons/js/buttons.flash.min.js",
                            "$datatable/buttons/js/buttons.html5.min.js",
                            "$datatable/buttons/js/buttons.print.min.js",
                            "$datatable/editor/mindmup-editabletable.js",
                            "$datatable/editor/numeric-input-example.js",
                            "/dist/vendors/icheck/icheck.min.js"];
        break;
        case "Rol":
            $datatable   = "/dist/vendors/datatable";
            $head        = ["$datatable/css/dataTables.bootstrap4.min.css",
					        "$datatable/buttons/css/buttons.bootstrap4.min.css",
                            "/dist/vendors/icheck/skins/all.css"];
            $body        = ["template" => ["acount/config"],
                            "list"     => "acount/roles/rol_list",
                            "table"    => "/Acount/Rol/List",
                            "config"   => "acount/roles/rol_configform",
                            "add_url"  => "/Acount/Rol/new",
                            "sidebar"  => "acount/roles/add_rol"];
            $footer      = ["$datatable/js/jquery.dataTables.min.js",
                            "$datatable/js/dataTables.bootstrap4.min.js",
                            "$datatable/jszip/jszip.min.js",
                            "$datatable/pdfmake/pdfmake.min.js",
                            "$datatable/pdfmake/vfs_fonts.js",
                            "$datatable/buttons/js/dataTables.buttons.min.js",
                            "$datatable/buttons/js/buttons.bootstrap4.min.js",
                            "$datatable/buttons/js/buttons.colVis.min.js",
                            "$datatable/buttons/js/buttons.flash.min.js",
                            "$datatable/buttons/js/buttons.html5.min.js",
                            "$datatable/buttons/js/buttons.print.min.js",
                            "$datatable/editor/mindmup-editabletable.js",
                            "$datatable/editor/numeric-input-example.js",
                            "/dist/vendors/icheck/icheck.min.js"];
        break;

        case "Company":
            $datatable   = "/dist/vendors/datatable";
            $head        = ["$datatable/css/dataTables.bootstrap4.min.css",
					        "$datatable/buttons/css/buttons.bootstrap4.min.css",
                            "/dist/vendors/icheck/skins/all.css"];
            $body        = ["template" => ["acount/config"],
                            "list"     => "acount/roles/rol_list",
                            "table"    => "/Acount/Rol/List",
                            "config"   => "acount/roles/rol_configform",
                            "add_url"  => "/Acount/Rol/new",
                            "sidebar"  => "acount/roles/add_rol"];
            $footer      = ["$datatable/js/jquery.dataTables.min.js",
                            "$datatable/js/dataTables.bootstrap4.min.js",
                            "$datatable/jszip/jszip.min.js",
                            "$datatable/pdfmake/pdfmake.min.js",
                            "$datatable/pdfmake/vfs_fonts.js",
                            "$datatable/buttons/js/dataTables.buttons.min.js",
                            "$datatable/buttons/js/buttons.bootstrap4.min.js",
                            "$datatable/buttons/js/buttons.colVis.min.js",
                            "$datatable/buttons/js/buttons.flash.min.js",
                            "$datatable/buttons/js/buttons.html5.min.js",
                            "$datatable/buttons/js/buttons.print.min.js",
                            "$datatable/editor/mindmup-editabletable.js",
                            "$datatable/editor/numeric-input-example.js",
                            "/dist/vendors/icheck/icheck.min.js"];
        break;

    }
    $include = array("head" => $head, "body" => $body, "footer" => $footer);    
    return $include;
}

?>