<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i>  &nbsp; Configurar Sucursal
    </h5>     
    <i class="icon-close icons h3" onclick="acount_formtoggle()"></i>     
</div> 
 
<div class="card-body" id="content-form-company">      
    <?php $this->load->view("acount/office/office_form"); ?>
    <?php $this->load->view("acount/office/company_contact_list"); ?>
    <div id="contact_office_id"></div> 
</div>