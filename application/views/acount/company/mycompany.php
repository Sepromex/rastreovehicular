<div class="card-header  justify-content-between align-items-center"> 
    <div class="sub-header   px-md-0 align-self-center d-sm-flex w-100 rounded">
        <div class="w-sm-100 mr-auto">
            <h4 class="card-title">Empresas</h4>                          
        </div>  
    </div>
</div>

<div class="profile-menu theme-background border  z-index-1 p-2">
    <div class="d-sm-flex">
        <div class="align-self-center">
            <?php $this->load->view("acount/company/menu_company"); ?>
        </div>
        <div class="align-self-center ml-auto text-center text-sm-right">           
            <a href="#" class="bg-primary py-2 px-2 rounded ml-auto text-white text-center openside">
                <i class="icon-plus align-middle text-white"></i> 
                <span class="d-none d-xl-inline-block"> Nueva Empresa </span>
            </a> 
        </div>
    </div>
</div> 

<div class="card-body"> 
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
                                <h1 class="display-4 text-uppercase text-white mb-0" id="company_labelname"><?=(isset($company["razon_social"]))?$company["razon_social"]:""?></h1>
                                <h6 class="text-uppercase text-white mb-0" id="company_labeltype"><?=(isset($company["giro"]))?$company["giro"]:""?></h6>
                                <h6 class="text-uppercase text-white mb-0" id="company_labeldate"><?=(isset($company["fecha_reg"]))?$company["fecha_reg"]:""?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>    
    <?php $this->load->view("acount/company/company_form"); ?>
    <?php $this->load->view("acount/company/office_contact_list"); ?>
</div>