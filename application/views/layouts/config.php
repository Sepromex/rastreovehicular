<!-- General Template -->
<div class="row row-eq-height">
    <!-- Lateral Menu -->
    <div class="col-12 col-lg-2 mt-3 todo-menu-bar flip-menu pr-lg-0">
        <div class="card border h-100 contact-menu-section">
            <ul class="nav flex-column contact-menu">
                <?php $this->load->view($include["body"]["config_menu"]); ?>
            </ul>   
        </div>
    </div> 
    
    <!-- General content -->
    <div class="col-12 col-lg-10 mt-3 pl-lg-0">
        <div class="card border h-100"> 
            
            <!-- Content Page -->                                    
            <div class="card-body p-0" id="general-content">
                <?php if(isset($include["body"]["content"])): ?>
                <?php $this->load->view($include["body"]["content"]); ?>            
                <?php endif; ?>
            </div>            
            <div class="card-body form-hide" id="general-forms"></div>            
            <!-- End: Content Page -->

        </div>
    </div>
    <!-- End: General content -->
</div> 
<!-- END: General Template --> 