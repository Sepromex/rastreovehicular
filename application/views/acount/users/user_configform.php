<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i>  &nbsp; Configurar Usuario
    </h5>     
    <i class="icon-close icons h3" onclick="acount_formtoggle()"></i>     
</div>

<div class="card-body" id="content-form-company">      
    <?php $this->load->view("acount/users/user_form"); ?>
    <?php $this->load->view("acount/users/vehicle_list"); ?>    
</div> 