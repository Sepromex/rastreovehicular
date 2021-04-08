<!-- START: Card Data-->
<div class="row mt-3">        
    <div class="col-xl-12">
        <div class="card">
            <form class="add-contact-form needs-validation configform" id="company_configform" novalidate>
                <input type="hidden" name="conf_companyid" id="conf_companyid" value="<?=(isset($company["id_empresa"]))?$company["id_empresa"]:''?>">
                <div class="card-header d-flex justify-content-between align-items-center">                                
                    <h4 class="card-title">Datos Generales</h4>
                    <div class="align-self-center ml-auto text-center text-sm-right">  
                        <button type="button" class="btn btn-danger" onclick="acount_formtoggle()">Cancelar</button>         
                        <button type="button"  onclick="validate_company()" class="btn btn-success">Editar Empresa</button>
                    </div>
                </div> 

                <div class="card-body">
 
                    <div class="form-row mb-2">  
                        <label for="conf_companyaddress"><b>Dirección: </b></label> &nbsp;&nbsp;
                        <div id="conf_userfechareg"> <?=(isset($company["direccion"]))?$company["direccion"]:''?>   <?=(isset($company["colonia"]))?$company["colonia"]:''?>  <?=(isset($company["ciudad"]))?$company["ciudad"]:'';?>  <?=(isset($company["estado"]))?$company["estado"]:'';?> </div> 
                    </div> 

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="conf_companyname">Razon social</label>
                            <input type="text" class="form-control rounded" onblur="general_validate('#conf_companyname','#feedback-confcompanyname')" id="conf_companyname" name="conf_companyname" value="<?=(isset($company["razon_social"]))?$company["razon_social"]:''?>"  required="">
                            <div class="invalid-feedback" id="feedback-confcompanyname"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="conf_companyagent">Representante</label>  
                            <input type="text" class="form-control" name="conf_companyagent" id="conf_companyagent" value="<?=(isset($company["representante"]))?$company["representante"]:''?>" required="">                             
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="conf_companyrfc">RFC</label>
                            <input type="text" class="form-control rounded" onblur="general_validate('#conf_companyrfc','#feedback-confcompanyrfc')" id="conf_companyrfc" name="conf_companyrfc" value="<?=(isset($company["rfc"]))?$company["rfc"]:''?>" required="">
                            <div class="invalid-feedback" id="feedback-confcompanyrfc"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="conf_companytype">Giro</label> 
                            <select class="form-control" onchange="validate_select('#conf_companytype','#feedback-confcompanytype')" name="conf_companytype" id="conf_companytype" required="">                                
                                <option value="0">Seleccione un giro por favor</option>
                                <?php foreach($company_category as $cat): ?>
                                <option value="<?=$cat->id_giro?>" <?=(isset($company["id_giro"]) && $company["id_giro"] == $cat->id_giro)?'selected':''?>><?=$cat->descripcion?></option> 
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback" id="feedback-confcompanytype"></div>
                        </div>                        
                    </div>                        

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="conf_companyphone" class="col-form-label">Teléfono</label>
                            <input type="text" class="form-control inputnumber" name="conf_companyphone" data-masked="" data-inputmask="'mask': '(999) 999-9999'" id="conf_companyphone" value="<?=(isset($company["telefono"]))?$company["telefono"]:''?>" required="">
                            <div class="invalid-feedback" id="feedback-confcompanyphone"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="conf_companyemail" class="col-form-label">Correo Electrónico</label>
                            <input type="text" onblur="validate_email('#conf_companyemail','#feedback-confcompanyemail')" name="conf_companyemail" id="conf_companyemail" class="form-control" value="<?=(isset($company["email"]))?$company["email"]:''?>" required="" >
                            <div class="invalid-feedback" id="feedback-confcompanyemail"></div>
                        </div>
                    </div> 
 
                                         
                </div> 
            </form>
        </div>
    </div>  
</div>

<script>

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