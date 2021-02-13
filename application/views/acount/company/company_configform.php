<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i>  &nbsp; Configurar Empresa
    </h5>     
    <i class="icon-close icons h3" onclick="acount_formtoggle()"></i>     
</div>

<div class="card-body">
     
    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 mt-3">
            <div class="position-relative">
                <div class="background-image-maker py-5"></div>
                <div class="holder-image">
                    <img src="/dist/images/Acount/profile_banner.jpeg" alt="" class="img-fluid d-none">
                </div>
                <div class="position-relative px-3 py-5">
                    <div class="media d-md-flex d-block">
                        <a href="#"><img src="/dist/images/Acount/profile.png" width="100" alt="" class="img-fluid rounded-circle"></a>
                        <div class="media-body z-index-1">
                            <div class="pl-4">
                                <h1 class="display-4 text-uppercase text-white mb-0" id="company_labelname">SEPROMEX</h1>
                                <h6 class="text-uppercase text-white mb-0" id="company_labeltype">Logistica y transporte</h6>
                                <h6 class="text-uppercase text-white mb-0" id="company_labeldate">Logistica y transporte</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>


    
    <div class="row mt-3">        
        <div class="col-xl-12">
            <div class="card">
                <form class="add-contact-form needs-validation configform" id="company_configform" novalidate>
                <input type="hidden" name="conf_companyid" id="conf_companyid">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h4 class="card-title">Datos Generales</h4>
                    <div class="align-self-center ml-auto text-center text-sm-right">  
                        <button type="button" class="btn btn-danger" onclick="acount_formtoggle()">Cancelar</button>         
                        <button type="submit" class="btn btn-success">Editar Contacto</button>
                    </div>
                </div>

                <div class="card-body">                    

                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="conf_companyname">Razon social</label>
                                <input type="text" class="form-control rounded" id="conf_companyname" name="conf_companyname"  required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="conf_companyagent">Representante</label>  
                                <input type="text" class="form-control" name="conf_companyagent" id="conf_companyagent" required=""> 
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="conf_companyrfc">RFC</label>
                                <input type="text" class="form-control rounded" id="conf_companyrfc" name="conf_companyrfc"  required="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="conf_companytype">Giro</label>
                                <input type="text" name="conf_companytype" id="conf_companytype" class="form-control" required="" >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="conf_companycontactid">Contacto</label>
                                <select class="form-control" id="conf_companycontactid" name="conf_companycontactid">
                                    <option value="0">Selecciona un Contacto</option>
                                    <?php foreach($contactlist as $datacontact): ?>
                                    <option value="<?=$datacontact->id_contacto?>"><?=$datacontact->nombre?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div> 
                            <div class="form-group col-md-2">
                                <label for="conf_companystatus">Estatus</label>
                                <select class="form-control" id="conf_companystatus" name="conf_companystatus">
                                    <option value="1">Activo</option> 
                                    <option value="0">Inactivo</option> 
                                </select>  
                            </div>
                        </div>                        

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="conf_companyphone" class="col-form-label">Teléfono</label>
                                <input type="text" class="form-control" name="conf_companyphone" id="conf_companyphone" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="conf_companyemail" class="col-form-label">Correo Electrónico</label>
                                <input type="text" name="conf_companyemail" id="conf_companyemail" class="form-control" required="" >
                            </div>
                        </div> 


                        <div class="form-row mb-2">  
                            <label for="conf_companyaddress">Dirección</label>
                            <input type="text" class="form-control" name="conf_companyaddress" id="conf_companyaddress"> 
                        </div>

                        <div class="form-row">  
                            <label for="conf_companysub">Colonia</label>
                            <input type="text" class="form-control" name="conf_companysub" id="conf_companysub">
                        </div>
                            
                        <div class="form-row mt-2">
                            <div class="form-group col-md-6">
                                <label for="conf_companycity">Ciudad</label>
                                <select class="form-control" name="conf_companycity" id="conf_companycity">
                                    <option value="0" selected>Selecciona una ciudad</option>
                                    <?php foreach($cities as $city): ?>
                                    <option value="<?=$city->nombre?>"><?=$city->nombre?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="conf_companystate">Estado</label>
                                <select class="form-control" name="conf_companystate" id="conf_companystate">
                                    <option value="0" selected>Selecciona un Estado</option>
                                    <?php foreach($states as $state): ?>
                                    <option value="<?=$state->nombre?>"><?=$state->nombre?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>                      
                </div> 

                </form>

            </div>
        </div>  
    </div>

    


    <div class="row mt-3"> 
    <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h4 class="card-title">Contactos</h4>
                    <div class="align-self-center ml-auto text-center text-sm-right">           
                        <a href="#" class="bg-success py-2 px-2 rounded ml-auto text-white text-center openside">
                            <i class="icon-plus align-middle text-white"></i> 
                            <span class="d-none d-xl-inline-block "> Ligar contacto </span>
                        </a> 
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="contacts list">
                        <div class="contact family-contact p-0 "> 
                            <div class="contact-content" style="min-width:300px;">
                                <div class="contact-profile">                                                   
                                    <img class="img-fluid  mr-3 rounded-circle" src="/dist/images/author3.jpg" alt="">
                                    <div class="contact-info">
                                        <p class="contact-name mb-0">Kayla Fail</p>
                                        <p class="contact-position mb-0 small font-weight-bold text-muted">Logística</p>
                                        <small class="body-color">08:00 am - 07:00 pm</small>                                            
                                     </div>
                                </div>
                                <div class="contact-email">
                                    <p class="mb-0 small">Contact </p>
                                    <p class="user-email">michelle.mendoza.c@outlook.com</p>
                                    <p class="user-phone"></p>
                                </div> 
                                <div class="contact-phone">
                                    <p class="mb-0 small">Teléfono: </p>
                                    <p class="user-phone">+1 (020) 123-4567</p>
                                </div>
                                <div class="line-h-1 h5">
                                    <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>

                 
            </div> 
        </div> 
    </div>



    <div class="row mt-3"> 
    <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                               
                    <h4 class="card-title">Sucursales</h4>
                    <div class="align-self-center ml-auto text-center text-sm-right">           
                        <a href="#" class="bg-success py-2 px-2 rounded ml-auto text-white text-center openside">
                            <i class="icon-plus align-middle text-white"></i> 
                            <span class="d-none d-xl-inline-block "> Ligar Sucursal </span>
                        </a> 
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="contacts list">
                        <div class="contact family-contact p-0 "> 
                            <div class="contact-content" style="min-width:300px;">
                                <div class="contact-profile">                                                   
                                    <img class="img-fluid  mr-3 rounded-circle" src="/dist/images/author3.jpg" alt="">
                                    <div class="contact-info">
                                        <p class="contact-name mb-0">Kayla Fail</p>
                                        <p class="contact-position mb-0 small font-weight-bold text-muted">Logística</p>
                                        <small class="body-color">08:00 am - 07:00 pm</small>                                            
                                     </div>
                                </div>
                                <div class="contact-email">
                                    <p class="mb-0 small">Contact </p>
                                    <p class="user-email">michelle.mendoza.c@outlook.com</p>
                                    <p class="user-phone"></p>
                                </div> 
                                <div class="contact-phone">
                                    <p class="mb-0 small">Teléfono: </p>
                                    <p class="user-phone">+1 (020) 123-4567</p>
                                </div>
                                <div class="line-h-1 h5">
                                    <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>

                 
            </div> 
        </div> 
    </div>


    <!-- END: Card DATA-->
</div>
 