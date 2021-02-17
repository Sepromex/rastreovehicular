<?php if(isset($office_contactlist)): if(is_array($office_contactlist)): ?>
<div class="row mt-3"> 
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h4 class="card-title">Contactos</h4>
            </div>
            <div class="card-body p-0">
                <div class="contacts list">
                <?php foreach($office_contactlist as $ccl): ?>
                    <div class="contact family-contact p-0">                             
                        <div class="contact-content" style="min-width:300px;">
                            <div class="contact-profile col-md-4">                                                   
                                    <div class="contact-info">
                                    <p class="contact-name mb-0"><?=$ccl->nombre?></p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted"><?=$ccl->puesto?></p>
                                    <small class="body-color"><?=$ccl->horario?></small>                                            
                                    </div>
                            </div>
                            <div class="contact-email col-md-3">
                                <p class="mb-0 small">Contacto </p>
                                <p class="user-email"><?=$ccl->email?></p>
                                <p class="user-phone"></p>
                            </div> 
                            <div class="contact-phone col-md-3">
                                <p class="mb-0 small">Teléfono: </p>
                                <p class="user-phone"><?=$ccl->telefono?></p>
                            </div>
                            <div class="line-h-1 h5  col-md-2">
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div> 
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>                 
        </div> 
    </div> 
</div>
<?php endif; endif; ?>
