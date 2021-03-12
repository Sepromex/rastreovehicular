<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i>  &nbsp; Configurar Rol de Usuario
    </h5>     
    <i class="icon-close icons h3" onclick="acount_formtoggle()"></i>     
</div> 
 
<div class="card-body" id="content-form-company">
    <!-- START: Card Data-->
    <div class="row mt-3">        
        <div class="col-xl-12">
            <div class="card"> 
                <form class="needs-validation" id="rol_configform" method="POST" novalidate>

                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Datos Generales</h4>
                        <div class="align-self-center ml-auto text-center text-sm-right">  
                            <button type="button" class="btn btn-danger" onclick="acount_formtoggle()">Cancelar</button>         
                            <button type="button" onclick="velidate_form('rol_configform','config')" class="btn btn-success">Editar Rol</button>
                        </div>
                    </div> 
 
                    <div class="card-body">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label><b>ID:</b></label>
                                <label id="conf_rolidlabel"></label>
                                <input type="hidden" id="conf_rolid" name="conf_rolid">                
                            </div>  
                            <div class="form-group col-md-6">
                                <label><b>Fecha de creación:</b></label>
                                <label id="conf_rolfechareg"></label> 
                            </div>  
                        </div> 

                        <div class="form-row"> 
                            <div class="form-group col-md-4">
                                <label for="conf_rolname">Rol</label>
                                <input type="text" class="form-control rounded" id="conf_rolname" name="conf_rolname" required="">
                            </div>  
                            <div class="form-group col-md-2">
                                <label for="conf_userstatus">Estatus</label>
                                <select class="form-control" id="conf_rolstatus" name="conf_rolstatus"  required="">                     
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>                     
                                </select>   
                            </div>  
                            <div class="form-group col-md-6">
                                <label for="conf_roldescription">Descripcion</label>
                                <input type="text" class="form-control" id="conf_roldescription" name="conf_roldescription" required="">
                            </div> 
                        </div> 

                        <div class="form-row"> 
                            <div class="form-group col-md-12 mt-3">
                                <h4>Permisos de acceso</h4>
                            </div>
                        </div> 
                
                        <div class="form-row skin skin-square">                        
                            <div id="accordion2" class="accordion-alt col-md-12 grid" role="tablist"> 
                            <?php $item="0"; foreach($modules as $id_module => $module): ?>
                            <?=($item == "0")?'<div class="form-row">':''?>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <h6 class="mb-0">
                                            <a class="text-uppercase d-block border" data-toggle="collapse" href="#collapse<?=$id_module?>" aria-expanded="false" aria-controls="collapse<?=$id_module?>">
                                                <?=$module["name"]?>
                                            </a>
                                        </h6>
                                        <div id="collapse<?=$id_module?>" class="collapse show" role="tabpanel">
                                            <div class="card-body"> 
                                                <table class="table ">
                                                    <tr>
                                                        <th class="text-center">&nbsp;</th>
                                                        <th class="text-center">
                                                            <p>Insertar</p> 
                                                            <input id="check_insert<?=$id_module?>" onchange="checkbyclass('insert','<?=$id_module?>')" type="checkbox" >                                            
                                                        </th>
                                                        <th class="text-center">
                                                            <p>Editar</p>
                                                            <input id="check_edit<?=$id_module?>" onchange="checkbyclass('edit','<?=$id_module?>')" type="checkbox" >
                                                        </th>
                                                        <th class="text-center">
                                                            <p>Eliminar</p>
                                                            <input id="check_delete<?=$id_module?>" onchange="checkbyclass('delete','<?=$id_module?>')" type="checkbox" >
                                                        </th>
                                                        <th class="text-center">
                                                            <p>Leer</p>
                                                            <input id="check_read<?=$id_module?>" onchange="checkbyclass('read','<?=$id_module?>')" type="checkbox" >
                                                        </th>
                                                    </tr>
                                                    <?php foreach($module["modules"] as $submodule_id => $submodule_name): $idcheck = $id_module.$submodule_id; ?>
                                                    <tr>
                                                        <td><?=$submodule_name?></td>
                                                        <td class="text-center"> 
                                                            <input type="checkbox" value="1" name="rolcheck[<?=$id_module?>][<?=$submodule_id?>][insert]" class="check_insert<?=$id_module?>" id="check_insert<?=$idcheck?>">
                                                        </td>
                                                        <td class="text-center"> 
                                                            <input type="checkbox" value="1" name="rolcheck[<?=$id_module?>][<?=$submodule_id?>][edit]" class="check_edit<?=$id_module?>" id="check_edit<?=$idcheck?>"> 
                                                        </td>
                                                        <td class="text-center"> 
                                                            <input type="checkbox" value="1" name="rolcheck[<?=$id_module?>][<?=$submodule_id?>][delete]" class="check_delete<?=$id_module?>" id="check_delete<?=$idcheck?>">
                                                        </td>
                                                        <td class="text-center"> 
                                                            <input type="checkbox" value="1" name="rolcheck[<?=$id_module?>][<?=$submodule_id?>][read]" class="check_read<?=$id_module?>" id="check_read<?=$idcheck?>">
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?> 
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            <?php $item++; if($item == "2"): echo'</div>'; $item=0; endif; ?>                
                            <?php endforeach; ?>                      
                            </div>      
                        </div> 
                                            
                    </div> 
                </form>
            </div>
        </div>  
    </div>
</div>


<script> 
/*var checkbox = document.querySelector("input[name=checkbox]");
    checkbox.addEventListener( 'change', function() {
    if(this.checked) {
        // Checkbox is checked..
    } else {
        // Checkbox is not checked..
    }
    });

function checkread(clas,id){ 
    console.log(clas);
    if(clas == "read"){        
        if($("#check_insert"+id).is(":checked")){
            console.log("inser check");
            $("#check_read"+id).attr('checked', true);            
        } 
        if($("#rol_configform #check_delete"+id).is(":checked")){        
            $("#rol_configform #check_read"+id).attr('checked', true);
        } 
        if($("#rol_configform #check_edit"+id).is(":checked")){        
            $("#rol_configform #check_read"+id).attr('checked', true);
        } 
    }else{
        if($("#check_"+clas+id).is(":checked")){  
            $("#check_read"+id).attr('checked', true);
        } 
    }
    
}
*/ 
</script> 