<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Form Float Input</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Form</li>
                <li class="breadcrumb-item">Float</li>
                <li class="breadcrumb-item active"><a href="#">Input</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row row-eq-height">
    <div class="col-12 mt-3">
        <div class="card h-100">
            <div class="card-header">                               
                <h4 class="card-title">Default</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body py-5">                                   
                    <form class="form-row">                                                                                     
                        <div class="form-group col-sm-6">                                               
                            <input type="text" class="form-control" id="username" value="" onchange="this.setAttribute('value', this.value);">
                            <label class="form-control-placeholder" for="username">Name</label>
                        </div>                                                    
                        <div class="form-group col-sm-6">                                                  
                            <input type="email" class="form-control" id="email" value="" onchange="this.setAttribute('value', this.value);"  >
                            <label class="form-control-placeholder" for="email">Email</label>    
                        </div>                               

                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Inside Label</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body py-5">
                    <form class="form-row">                                                                                     
                        <div class="form-group col-sm-6">                                               
                            <input type="text" class="form-control form-control-lg float-input inside-label" id="username1" value="" onchange="this.setAttribute('value', this.value);">
                            <label class="form-control-placeholder inside" for="username1">Name</label>
                        </div>                                                    
                        <div class="form-group col-sm-6">                                                  
                            <input type="email" class="form-control form-control-lg float-input inside-label" id="email1" value="" onchange="this.setAttribute('value', this.value);" >
                            <label class="form-control-placeholder" for="email1">Email</label>    
                        </div>                               

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Icon</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body py-5">
                    <form class="form-row">                                                                                     
                        <div class="form-group col-sm-6">  
                            <div class="input-group">    
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0" id="basic-addon1"><i class="icon-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="username3" value="" onchange="this.setAttribute('value', this.value);">                                                
                                <label class="form-control-placeholder inside" for="username3">Name</label>
                            </div>
                        </div>                                                    
                        <div class="form-group col-sm-6"> 
                            <div class="input-group">
                                <input type="email" class="form-control" id="email3"  value="" onchange="this.setAttribute('value', this.value);">
                                <label class="form-control-placeholder" for="email3">Email</label> 
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent border-left-0" id="basic-email"><i class="icon-envelope"></i></span>
                                </div>

                            </div>
                        </div>                               

                    </form>

                </div>
            </div>
        </div>
    </div>                    
    <div class="col-12 mt-3">
        <div class="card h-100">
            <div class="card-header">                               
                <h4 class="card-title">Color</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body py-5">                                   
                    <form class="form-row">                                                                                     
                        <div class="form-group input-primary col-sm-3 mb-4">                                               
                            <input type="text" class="form-control" value="" onchange="this.setAttribute('value', this.value);">
                            <label class="form-control-placeholder">Primary</label>
                        </div>                                                    
                        <div class="form-group input-secondary col-sm-3 mb-4">                                                  
                            <input type="text" class="form-control" value="" onchange="this.setAttribute('value', this.value);">
                            <label class="form-control-placeholder">Secondary</label>    
                        </div> 

                        <div class="form-group input-warning col-sm-3 mb-4">                                                  
                            <input type="text" class="form-control" value="" onchange="this.setAttribute('value', this.value);">
                            <label class="form-control-placeholder">Warning</label>    
                        </div>

                        <div class="form-group input-danger col-sm-3 mb-4">                                                  
                            <input type="text" class="form-control" value="" onchange="this.setAttribute('value', this.value);">
                            <label class="form-control-placeholder">Danger</label>    
                        </div>

                        <div class="form-group input-info col-sm-3 mb-4">                                                  
                            <input type="text" class="form-control" value="" onchange="this.setAttribute('value', this.value);">
                            <label class="form-control-placeholder">Info</label>    
                        </div>

                        <div class="form-group input-dark col-sm-3 mb-4">                                                  
                            <input type="text" class="form-control" value="" onchange="this.setAttribute('value', this.value);">
                            <label class="form-control-placeholder">Dark</label>    
                        </div>

                        <div class="form-group input-success col-sm-3 mb-4">                                                  
                            <input type="text" class="form-control" value="" onchange="this.setAttribute('value', this.value);">
                            <label class="form-control-placeholder">Success</label>    
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>                  
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

