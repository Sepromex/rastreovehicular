<div class="modal-header">
    <h5 class="modal-title">
        <i class="icon-pencil"></i>  &nbsp; Configurar Empresa
    </h5>     
    <i class="icon-close icons h3" onclick="acount_formtoggle()"></i>     
</div> 

<div class="card-body" id="content-form-company">      
    <?php $this->load->view("acount/company/company_form"); ?>
    <?php $this->load->view("acount/company/office_contact_list"); ?>
    <div id="contact_office_id"></div>
</div>