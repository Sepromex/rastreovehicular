<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
    <!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 ml-auto"><h4 class="mb-0">Form Validation</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Form</li>
                    <li class="breadcrumb-item active"><a href="#">Validation</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">                               
                    <h4 class="card-title">Custom styles</h4>                                
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">                                           
                            <div class="col-12">
                                <form class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">First name</label>
                                            <input type="text" class="form-control" id="validationCustom01" placeholder="First name" value="" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">Last name</label>
                                            <input type="text" class="form-control" id="validationCustom02" placeholder="Last name" value="" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustomUsername">Username</label>
                                            <div class="input-group">

                                                <input type="text" class="form-control" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please choose a username.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom03">City</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="City" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid city.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom04">State</label>
                                            <input type="text" class="form-control" id="validationCustom04" placeholder="State" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid state.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationCustom05">Zip</label>
                                            <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid zip.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <div class="chkbox"> 
                                                <input name="cchk" class="form-check-input" value=""  id="invalidCheck" type="checkbox" required>
                                                <label class="form-check-label"  for="invalidCheck">Agree to terms and conditions</label>  
                                                <div class="invalid-feedback">
                                                    You must agree before submitting.
                                                </div>
                                                <span class="checkmark"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Submit form</button>
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
                    <h4 class="card-title">Browser defaults</h4>                                
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">                                           
                            <div class="col-12">
                                <form>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault01">First name</label>
                                            <input type="text" class="form-control" id="validationDefault01" placeholder="First name" value="" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault02">Last name</label>
                                            <input type="text" class="form-control" id="validationDefault02" placeholder="Last name" value="" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustomUsername">Username</label>
                                            <div class="input-group">

                                                <input type="text" class="form-control" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required="">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please choose a username.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault03">City</label>
                                            <input type="text" class="form-control" id="validationDefault03" placeholder="City" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationDefault04">State</label>
                                            <input type="text" class="form-control" id="validationDefault04" placeholder="State" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationDefault05">Zip</label>
                                            <input type="text" class="form-control" id="validationDefault05" placeholder="Zip" required>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="form-check">
                                            <div class="chkbox"> 
                                                <input name="cchk" class="form-check-input" value=""  id="invalidCheck2" type="checkbox" required>
                                                <label class="form-check-label"  for="invalidCheck2">Agree to terms and conditions</label>  
                                                <div class="invalid-feedback">
                                                    You must agree before submitting.
                                                </div>
                                                <span class="checkmark"></span>
                                            </div>

                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Submit form</button>
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
                    <h4 class="card-title">Server side</h4>                                
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">                                           
                            <div class="col-12">
                                <form>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationServer01">First name</label>
                                            <input type="text" class="form-control is-valid" id="validationServer01" placeholder="First name" value="" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationServer02">Last name</label>
                                            <input type="text" class="form-control is-valid" id="validationServer02" placeholder="Last name" value="" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustomUsername">Username</label>
                                            <div class="input-group">

                                                <input type="text" class="form-control is-invalid" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required="">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please choose a username.
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationServer03">City</label>
                                            <input type="text" class="form-control is-invalid" id="validationServer03" placeholder="City" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid city.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationServer04">State</label>
                                            <input type="text" class="form-control is-invalid" id="validationServer04" placeholder="State" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid state.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationServer05">Zip</label>
                                            <input type="text" class="form-control is-invalid" id="validationServer05" placeholder="Zip" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid zip.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">


                                            <div class="chkbox"> 
                                                <input name="cchk" class="form-check-input is-invalid" value=""  id="invalidCheck2" type="checkbox" required>
                                                <label class="form-check-label"  for="invalidCheck2">Agree to terms and conditions</label>  
                                                <div class="invalid-feedback">
                                                    You must agree before submitting.
                                                </div>
                                                <span class="checkmark"></span>
                                            </div>


                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Submit form</button>
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
                    <h4 class="card-title">Supported elements</h4>                                
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">                                           
                            <div class="col-12">
                                <form class="was-validated">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input" id="customControlValidation1" required>
                                        <label class="custom-control-label" for="customControlValidation1">Check this custom checkbox</label>
                                        <div class="invalid-feedback">Example invalid feedback text</div>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="customControlValidation2" name="radio-stacked" required>
                                        <label class="custom-control-label" for="customControlValidation2">Toggle this custom radio</label>
                                    </div>
                                    <div class="custom-control custom-radio mb-3">
                                        <input type="radio" class="custom-control-input" id="customControlValidation3" name="radio-stacked" required>
                                        <label class="custom-control-label" for="customControlValidation3">Or toggle this other custom radio</label>
                                        <div class="invalid-feedback">More example invalid feedback text</div>
                                    </div>

                                    <div class="form-group">
                                        <select class="custom-select" required>
                                            <option value="">Open this select menu</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <div class="invalid-feedback">Example invalid custom select feedback</div>
                                    </div>

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="validatedCustomFile" required>
                                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                        <div class="invalid-feedback">Example invalid custom file feedback</div>
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
                    <h4 class="card-title">Tooltip</h4>                                
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">                                           
                            <div class="col-12">
                                <form class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip01">First name</label>
                                            <input type="text" class="form-control" id="validationTooltip01" placeholder="First name" value="" required>
                                            <div class="valid-tooltip">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationTooltip02">Last name</label>
                                            <input type="text" class="form-control" id="validationTooltip02" placeholder="Last name" value="" required>
                                            <div class="valid-tooltip">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustomUsername">Username</label>
                                            <div class="input-group">

                                                <input type="text" class="form-control" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required="">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                </div>
                                                <div class="invalid-tooltip">
                                                    Please choose a unique and valid username.
                                                </div>
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationTooltip03">City</label>
                                            <input type="text" class="form-control" id="validationTooltip03" placeholder="City" required>
                                            <div class="invalid-tooltip">
                                                Please provide a valid city.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationTooltip04">State</label>
                                            <input type="text" class="form-control" id="validationTooltip04" placeholder="State" required>
                                            <div class="invalid-tooltip">
                                                Please provide a valid state.
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationTooltip05">Zip</label>
                                            <input type="text" class="form-control" id="validationTooltip05" placeholder="Zip" required>
                                            <div class="invalid-tooltip">
                                                Please provide a valid zip.
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Submit form</button>
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
