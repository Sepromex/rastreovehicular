<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Form Layouts</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Form</li>
                <li class="breadcrumb-item active"><a href="#">Layouts</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12 col-lg-6 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Horizontal Form</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">                                           
                        <div class="col-12">
                            <form>
                                <div class="form-group row">
                                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="username" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                                    </div>
                                </div>                                                
                                <div class="form-group row">
                                    <div class="col-sm-2">Checkbox</div>
                                    <div class="col-sm-10">

                                        <label class="chkbox"> Example checkbox
                                            <input name="gridCheck1" value="gridCheck1" class="form-check-input" type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Sign in</button>   <button type="submit" class="btn btn-outline-warning">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Horizontal Form With Icon</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">                                           
                        <div class="col-12">
                            <form>
                                <div class="row">
                                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">  
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0" id="basic-addon11"><i class="icon-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <label for="username" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">  
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0" id="basic-email1"><i class="icon-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-email">
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <label for="username" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">  
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0" id="basic-password1"><i class="icon-options"></i></span>
                                            </div>
                                            <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-password">
                                        </div>

                                    </div>
                                </div>                                                                                           
                                <div class="form-group row">
                                    <div class="col-sm-2">Checkbox</div>
                                    <div class="col-sm-10">

                                        <label class="chkbox"> Example checkbox
                                            <input name="gridCheck1" value="gridCheck1" class="form-check-input" type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Sign in</button>   <button type="submit" class="btn btn-outline-warning">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Vertical Form</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">                                           
                        <div class="col-12">
                            <form>
                                <div class="form-group">
                                    <label for="username1">Username</label>                                                  
                                    <input type="text" class="form-control" id="username1" placeholder="Username">                                                    
                                </div>
                                <div class="form-group">
                                    <label for="email1">Email</label>                                                   
                                    <input type="email" class="form-control" id="email1" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword31">Password</label>                                                    
                                    <input type="password" class="form-control" id="inputPassword31" placeholder="Password">                                                   
                                </div>                                                
                                <div class="form-group"> 
                                    <label class="chkbox"> Example checkbox
                                        <input name="gridCheck1" value="gridCheck1" class="form-check-input" type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>                                                  
                                </div>
                                <div class="form-group">                                                  
                                    <button type="submit" class="btn btn-primary">Sign in</button>   <button type="submit" class="btn btn-outline-warning">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Vertical Form With Icon</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">                                           
                        <div class="col-12">
                            <form>
                                <label for="username">Username</label>
                                <div class="input-group  mb-3">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0" id="basic-addon1"><i class="icon-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Username" >

                                </div>

                                <label for="email">Email</label>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0" id="basic-email"><i class="icon-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" placeholder="Email" >
                                </div>




                                <label for="username">Password</label>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0" id="basic-password"><i class="icon-options"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Password">
                                </div>

                                <div class="form-group">                                                    
                                    <label class="chkbox"> Example checkbox
                                        <input name="gridCheck1" value="gridCheck1" class="form-check-input" type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="form-group">

                                    <button type="submit" class="btn btn-primary">Sign in</button>   <button type="submit" class="btn btn-outline-warning">Reset</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">                               
                <h4 class="card-title">Multi Column Form</h4>                                
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">                                           
                        <div class="col-12">
                            <form>
                                <div class="form-row">
                                    <div class="col-6 mb-3">
                                        <label for="username">First Name</label>

                                        <input type="text" class="form-control" placeholder="First Name">

                                    </div>
                                    <div class="col-6 mb-3"> 
                                        <label for="email">Last Name</label>                                               
                                        <input type="email" class="form-control" placeholder="Last Name">
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label for="username">City</label>

                                        <input type="text" class="form-control" placeholder="City">

                                    </div>
                                    <div class="col-6 mb-3"> 
                                        <label for="email">State</label>                                               
                                        <input type="email" class="form-control" placeholder="State">
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label for="username">Phone</label>

                                        <input type="text" class="form-control" placeholder="Phone">

                                    </div>
                                    <div class="col-6 mb-3"> 
                                        <label for="email">Mobile</label>                                               
                                        <input type="email" class="form-control" placeholder="Mobile">
                                    </div>


                                    <div class="col-12">

                                        <button type="submit" class="btn btn-primary">Sign in</button>   <button type="submit" class="btn btn-outline-warning">Reset</button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

