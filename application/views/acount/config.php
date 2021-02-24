<!-- START: Card Data-->
<div class="row row-eq-height">

    <div class="col-12 col-lg-2 mt-3 todo-menu-bar flip-menu pr-lg-0">
        <div class="card border h-100 contact-menu-section">
            <ul class="nav flex-column contact-menu">
                <li class="nav-item">
                    <a class="nav-link h6 <?=($custom['section'] == 'Users')?'active':''?>" href="/Acount/User">
                        <i class="icon-people h4"></i> Usuarios
                    </a>
                </li>               
                <li class="nav-item">
                    <a class="nav-link h6 <?=($custom['section'] == 'Company')?'active':''?>" href="/Acount/Companys">
                        <i class="icon-layers h4"></i> Empresas
                    </a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link h6 <?=($custom['section'] == 'Contact')?'active':''?>" href="/Acount/Contact">
                        <i class="icon-people h4"></i> Contactos
                    </a>
                </li>            
            </ul>   
        </div>
    </div>
 
    <div class="col-12 col-lg-10 mt-3 pl-lg-0">
        <div class="card border h-100">            
        <?php if(isset($include["body"]["list"])): ?>
            <div class="card-body p-0" id="acount-content">
            <!-- End Content -->
            <?php $this->load->view($include["body"]["list"]); ?>
            <!-- End content -->
            </div>
            <div class="card-body form-hide" id="acount-forms">
            <!-- End Content -->                        
            <?php $this->load->view($include["body"]["config"]); ?>
            <!-- End content -->
            </div>
        <?php else: ?>
            <div class="card-body  p-0">
            <!-- End Content -->            
            <?php $this->load->view($include["body"]["content"]); ?>
            <!-- End content -->
            </div>
        <?php endif; ?>
        </div>
    </div>

</div> 
<!-- END: Card DATA --> 