<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Form Elements</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Form</li>
                <li class="breadcrumb-item">Elements</li>
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
                    <form>
                        <div class="form-group row">                                                  
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="username" placeholder="Username">
                            </div>                                                    
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" disabled="disabled" placeholder="Email">
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Label</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body py-5">
                    <form class="form-row">
                        <div class="form-group col-6">
                            <label for="username1">Username</label>                                                  
                            <input type="text" class="form-control" id="username1" placeholder="Username">                                                    
                        </div>
                        <div class="form-group col-6">
                            <label for="email1">Email</label>                                                   
                            <input type="email" class="form-control" id="email1" placeholder="Email">
                        </div>                                                
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Size</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body py-5">
                    <form class="form-row">
                        <div class="form-group col-4 my-auto">                                                                                          
                            <input type="text" class="form-control form-control-sm" id="username2" placeholder="Username">                                                    
                        </div>
                        <div class="form-group col-4 my-auto">                                                                                       
                            <input type="email" class="form-control" id="email2" placeholder="Email">
                        </div>
                        <div class="form-group col-4 my-auto">                                                                                       
                            <input type="email" class="form-control form-control-lg" id="email3" placeholder="Email">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Types</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body py-5">
                    <form class="form-row">
                        <div class="form-group col-sm-4 mb-3"> 

                            <label for="time">Current time:</label> 
                            <input type="time" class="form-control" id="time"> 
                        </div>
                        <div class="form-group col-sm-4 mb-3"> 
                            <label for="dt">Current date:</label> 
                            <input type="date" class="form-control" id="dt"> 
                        </div>
                        <div class="form-group col-sm-4 mb-3"> 

                            <label for="datetime-local">Current date and time: 
                            </label> 
                            <input type="datetime-local" class="form-control" 
                                   id="datetime-local"> 
                        </div>
                        <div class="form-group col-sm-4 mb-3"> 
                            <label for="week">Current week:</label> 
                            <input type="week" class="form-control" id="week"> 
                        </div>
                        <div class="form-group col-sm-4 mb-3"> 
                            <label for="month">Current month :</label> 
                            <input type="month" class="form-control" id="month"> 
                        </div>
                        <div class="form-group col-sm-4 mb-3">                         

                            <label for="color">color:</label> 
                            <input type="color" class="form-control" id="color"> 
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
                    <form  class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="username">Front Icon</label>
                            <div class="input-group  mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0" id="basic-addon1"><i class="icon-user"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">

                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="email">Icon After</label>
                            <div class="input-group mb-3">                                                
                                <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-email">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent border-left-0" id="basic-email"><i class="icon-envelope"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="email">Icon Both</label>
                            <div class="input-group mb-3"> 
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0" id="basic-email3"><i class="icon-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-email3">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent border-left-0" id="basic-email2"><i class="icon-envelope"></i></span>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

