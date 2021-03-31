<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i><?=($sitet_form==0)?" Editar Sitio de Interés":" Nuevo Sitio de Interés"?> 
    </h5>     
    <i class="icon-close icons openside reset_form h3" onclick="clearMarkers()"></i>     
</div>

<form class="needs-validation" id="edit_mainsite" name="edit_mainsite" method="POST" novalidate >
   
    <div class="modal-body h-100">   
    <?php //print_array($site_type); ?>
        <input type="hidden" value="<?=(isset($site["id_sitio"]))?$site["id_sitio"]:""?>" name="edit_siteid" id="edit_siteid">
        <input type="hidden" name="lat" value="<?=$lat?>" />
	    <input type="hidden" name="lon" value="<?=$lon?>" />
        <!-- <input type="hidden" value="" name="edit_icon" id="edit_icon"> -->
       
        <div class="row mb-2"> 
            <label for="name_site" class="col-form-label text-muted">Nombre</label>
            <input type="text" value="<?=(isset($site["nombre"]))?$site["nombre"]:""?>" name="edit_sitename" id="edit_sitename" class="form-control" required="" >            
            <div class="invalid-feedback" id="feedback-edit_sitename"></div>
        </div>
 
         

        <div class="row mb-2"> 
            <div class="text-muted w-100 mb-2">Tipo</div> 

            <select class="form-control select-form" id="edit_sitetype"  name="edit_sitetype" style="display:block;" required="" >
                <option value="0" data-icon="iconos_sitios/defaul_marker.png"> Todos los sitios </option>   
                <?php $sitetype = (isset($site["id_tipo"]))?$site["id_tipo"]:0;  foreach($site_type as $s): ?>
                <option value="<?=$s->id_tipo?>"  <?=($sitetype==$s->id_tipo)?"selected":""?> data-icon="<?=$s->imagen?>"> <?=$s->descripcion?></option>
                <?php endforeach; ?>
            <select>
            <div class="invalid-feedback" id="feedback-edit_sitetype"></div>

        </div> 
        
        <div class="row mb-2"> 
            <label for="edit_sitecontact" class="col-form-label text-muted">Contacto</label>
            <input type="text" value="<?=(isset($site["contacto"]))?$site["contacto"]:""?>" name="edit_sitecontact" id="edit_sitecontact" class="form-control" required="" >            
            <div class="invalid-feedback" id="feedback-edit_sitecontact"></div>
        </div>         
 
        <div class="row mb-2"> 
            <label for="name_site" class="col-form-label text-muted">Teléfono Uno</label>
            <input type="text" value="<?=(isset($site["tel1"]))?$site["tel1"]:""?>" data-masked="" data-inputmask="'mask': '(999) 999-9999'" name="edit_sitephone" id="edit_sitephone" class="form-control inputnumber" required="" >            
            <div class="invalid-feedback" id="feedback-edit_sitephone"></div>
        </div>   
         

        <div class="row mb-2"> 
            <label for="name_site" class="col-form-label text-muted">Teléfono Dos</label>
             <input type="text" value="<?=(isset($site["tel2"]))?$site["tel2"]:""?>" data-masked="" data-inputmask="'mask': '(999) 999-9999'" name="edit_sitephone2" id="edit_sitephone2" class="form-control inputnumber" required="" >            
             <div class="invalid-feedback" id="feedback-edit_sitephone2"></div>
        </div>


        <div class="row mb-2"> 
            <div class="text-muted w-100 mb-2">Latitud</div>
            <div class="d-block h5 small"><?=$lat?></div>
        </div>

        <div class="row mb-2"> 
            <div class="text-muted w-100 mb-2">Longitud </div>
            <div class="d-block h5 small"><?=$lon?></div>
        </div>
                

    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-danger openside" onclick="clearMarkers()">Cancelar</button>
        <?php if($sitet_form==0): ?>
        <button type="button" class="btn btn-primary" onclick="edit_site()">Editar Sitio</button>
        <?php else: ?>
        <button type="button" class="btn btn-primary" onclick="savenew_site()">Agregar sitio</button>
        <?php endif; ?>
    </div>

</form>  

<script>
 
function formatStateedit (state) {
  if (!state.id) {
    return state.text;
  }
  var baseUrl = "/dist/images/map/site_type/";  
  var icon = state.element.dataset.icon;
  //console.log(icon);  
  
  var icon = baseUrl+icon.substr(14);

   var $state = $(
    '<span><img src="' + icon + '" class="img-flag" /> ' + state.text +  '</span>'
  );

  return $state;  
};

$('#edit_sitetype').select2({
  templateResult: formatStateedit
});
 

$("#edit_sitename").on('blur',function(){validate_name("#edit_sitename","#feedback-edit_sitename"); });
$("#edit_sitetype").on('change',function(){validate_sitetype("#edit_sitetype","#feedback-edit_sitetype",0,1);});
$("#edit_sitecontact").on('blur',function(){validate_namenotreq("#edit_sitecontact","#feedback-edit_sitecontact",0,1);});
$("#edit_sitephone").on('blur',function(){validate_phonemask("#edit_sitephone","#feedback-edit_sitephone",1);});
$("#edit_sitephone2").on('blur',function(){validate_phonemask("#edit_sitephone2","#feedback-edit_sitephone2",1);});

 
$('[data-masked]').inputmask();    
 
$(".inputnumber").keydown(function(event) {
    if(event.shiftKey){ event.preventDefault(); }
    if (event.keyCode == 46 || event.keyCode == 8){ }
    else {
            if (event.keyCode < 95) {
            if (event.keyCode < 48 || event.keyCode > 57) {
                    event.preventDefault();
            }
            } 
            else {
                if (event.keyCode < 96 || event.keyCode > 105) {
                    event.preventDefault();
                }
            }
        }
});
    

 
</script>