<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><span class="h4 my-auto">Form Upload</span></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item" aria-current="page">Form</li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Upload</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="row">
            <div class="col-12 col-md-6 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Default Bootstrap file upload</h4>
                    </div>
                    <div class="card-body">


                        <div class="custom-file overflow-hidden  mb-5">
                            <input id="customFile" type="file" class="custom-file-input">
                            <label for="customFile" class="custom-file-label">Choose file</label>
                        </div>
                        <!-- End -->

                        <h6 class="text-center mb-4 text-muted">
                            Or a custom button that launches file browser
                        </h6>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload" class="file-upload btn btn-primary btn-block"><i class="fa fa-upload mr-2"></i>Browse primary ...<input id="fileUpload" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload1" class="file-upload btn btn-secondary btn-block"><i class="fa fa-upload mr-2"></i>Browse secondary ...<input id="fileUpload1" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload2" class="file-upload btn btn-warning btn-block"><i class="fa fa-upload mr-2"></i>Browse warning ...<input id="fileUpload2" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload3" class="file-upload btn btn-danger btn-block"><i class="fa fa-upload mr-2"></i>Browse danger ...<input id="fileUpload3" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload4" class="file-upload btn btn-info btn-block"><i class="fa fa-upload mr-2"></i>Browse info ...<input id="fileUpload4" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload5" class="file-upload btn btn-dark btn-block"><i class="fa fa-upload mr-2"></i>Browse dark ...<input id="fileUpload5" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload61" class="file-upload btn btn-success btn-block"><i class="fa fa-upload mr-2"></i>Browse success ...<input id="fileUpload61" type="file">
                                </label>
                            </div>
                        </div>                                       
                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6 mt-3">

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Rounded</h4>
                    </div>
                    <div class="card-body">


                        <div class="custom-file overflow-hidden rounded-pill mb-5">
                            <input id="customFile1" type="file" class="custom-file-input rounded-pill">
                            <label for="customFile1" class="custom-file-label rounded-pill">Choose file</label>
                        </div>
                        <!-- End -->

                        <h6 class="text-center mb-4 text-muted">
                            Or a custom button that launches file browser
                        </h6>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload21" class="file-upload btn btn-primary btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse primary ...<input id="fileUpload21" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload22" class="file-upload btn btn-secondary btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse secondary ...<input id="fileUpload22" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload23" class="file-upload btn btn-warning btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse warning ...<input id="fileUpload23" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload24" class="file-upload btn btn-danger btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse danger ...<input id="fileUpload24" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload25" class="file-upload btn btn-info btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse info ...<input id="fileUpload25" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload26" class="file-upload btn btn-dark btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse dark ...<input id="fileUpload26" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload27" class="file-upload btn btn-success btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse success ...<input id="fileUpload27" type="file">
                                </label>
                            </div>
                        </div>                                       
                    </div>
                </div>

            </div>  
            <div class="col-12 col-md-6 mt-3">

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Outline</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload6" class="file-upload btn btn-outline-primary btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse primary ...<input id="fileUpload6" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload7" class="file-upload btn btn-outline-secondary btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse secondary ...<input id="fileUpload7" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload8" class="file-upload btn btn-outline-warning btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse warning ...<input id="fileUpload8" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload9" class="file-upload btn btn-outline-danger btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse danger ...<input id="fileUpload9" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload11" class="file-upload btn btn-outline-info btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse info ...<input id="fileUpload11" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload12" class="file-upload btn btn-outline-dark btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse dark ...<input id="fileUpload12" type="file">
                                </label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="fileUpload14" class="file-upload btn btn-outline-success btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse success ...<input id="fileUpload14" type="file">
                                </label>
                            </div>
                        </div>                                       
                    </div>
                </div>

            </div> 
            <div class="col-12 col-md-6 mt-3">

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">                               
                        <h4 class="card-title">Size</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="fileUpload13" class="file-upload btn btn-primary btn-sm px-4 rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse primary ...<input id="fileUpload13" type="file">
                                </label>
                            </div>
                            <div class="col-12">
                                <label for="fileUpload15" class="file-upload btn btn-secondary px-4 rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse secondary ...<input id="fileUpload15" type="file">
                                </label>
                            </div>
                            <div class="col-12">
                                <label for="fileUpload16" class="file-upload btn btn-warning btn-lg px-4 rounded-pill shadow"><i class="fa fa-upload mr-2"></i>Browse warning ...<input id="fileUpload16" type="file">
                                </label>
                            </div>

                        </div>                                       
                    </div>
                </div>

            </div>    
        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

