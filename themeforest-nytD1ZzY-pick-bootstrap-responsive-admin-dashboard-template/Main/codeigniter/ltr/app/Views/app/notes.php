<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">App Notes</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">App</li>
                <li class="breadcrumb-item active"><a href="#">Notes</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12 col-lg-3 col-xl-2 mb-4 mt-3 pr-lg-0 flip-menu">
        <a href="#" class="d-inline-block d-lg-none mt-1 flip-menu-close"><i class="icon-close"></i></a>
        <div class="card border h-100 mail-menu-section ">
            <div class="media d-block text-center  p-3">
                <a href="#" class="bg-primary w-100 d-block py-2 px-2 rounded text-white" data-toggle="modal" data-target="#addnote">
                    <i class="icon-plus align-middle text-white"></i> <span>Add Note</span>
                </a>
            </div>

            <!-- Add Note -->
            <div class="modal fade" id="addnote">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="icon-pencil"></i> New Note
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="icon-close"></i>
                            </button>
                        </div>

                        <form class="add-note-form">
                            <div class="modal-body">                                               

                                <div class="form-group">
                                    <label for="title" class="col-form-label">Title</label>
                                    <input type="text" class="form-control" id="title">
                                </div>                                                    

                                <div class="form-group">
                                    <label for="description" class="col-form-label">Description</label>
                                    <textarea class="form-control" rows="10" id="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="chkbox">                                                        
                                        <input type="checkbox" class="starred" id="starred">
                                        <span class="checkmark"></span>
                                        Starred
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="chkbox">                                                        
                                        <input type="checkbox" class="important" id="important">
                                        <span class="checkmark"></span>
                                        Important
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-form-label">Label</label>
                                    <select class="form-control" id="type">
                                        <option value="business-note">Business</option>
                                        <option value="private-note">Private</option>
                                        <option value="social-note">Social</option>
                                        <option value="personal-note">Personal</option>
                                        <option value="work-note">Work</option>
                                    </select>
                                </div> 

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary add-todo">Add Note</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Note -->
            <div class="modal fade" id="editnote">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="icon-pencil"></i> Edit Note
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="icon-close"></i>
                            </button>
                        </div>

                        <form class="edit-note-form">
                            <div class="modal-body">                                               

                                <div class="form-group">
                                    <label for="title" class="col-form-label">Title</label>
                                    <input type="text" class="form-control" id="edit-title">
                                </div>                                                    

                                <div class="form-group">
                                    <label for="description" class="col-form-label">Description</label>
                                    <textarea class="form-control" rows="10" id="edit-description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="chkbox">                                                        
                                        <input type="checkbox" class="starred" id="edit-starred">
                                        <span class="checkmark"></span>
                                        Starred
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="chkbox">                                                        
                                        <input type="checkbox" class="important" id="edit-important">
                                        <span class="checkmark"></span>
                                        Important
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-form-label">Label</label>
                                    <select class="form-control" id="edit-type">
                                        <option value="business-note">Business</option>
                                        <option value="private-note">Private</option>
                                        <option value="social-note">Social</option>
                                        <option value="personal-note">Personal</option>
                                        <option value="work-note">Work</option>
                                    </select>
                                </div> 

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" class="note-date"/>
                                <button type="submit" class="btn btn-primary add-todo">Edit Note</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <ul class="list-unstyled inbox-nav  mb-0 mt-2 notes-menu">
                <li class="nav-item"><a href="#" data-notetype="all" class="nav-link active"><i class="icon-envelope pr-2"></i> All Notes</a></li>
                <li class="nav-item"><a href="#" data-notetype="starred" class="nav-link"><i class="icon-star pr-2"></i> Starred</a></li>
                <li class="nav-item"><a href="#" data-notetype="important" class="nav-link"><i class="icon-exclamation pr-2"></i> Important</a></li>                               
            </ul>
            <div class="eagle-divider"></div>
            <div class="card-header py-1 mt-4">                                 
                <h6 class="mb-0">Labels</h6>
            </div>
            <ul class="nav flex-column font-weight-bold mt-3 note-label" id="myTab1" role="tablist">
                <li class="nav-item  px-3">
                    <a class="nav-link text-primary" data-label="business-note" href="#" >
                        <i class="icon-pin"></i> Business
                    </a>
                </li>
                <li class="nav-item  px-3">
                    <a class="nav-link text-danger" data-label="private-note" href="#" >
                        <i class="icon-pin"></i> Private
                    </a>
                </li>
                <li class="nav-item  px-3">
                    <a class="nav-link text-warning" data-label="social-note" href="#">
                        <i class="icon-pin"></i> Social
                    </a>
                </li>
                <li class="nav-item  px-3 ">
                    <a class="nav-link text-success" data-label="personal-note" href="#">
                        <i class="icon-pin"></i> Personal
                    </a>
                </li>
                <li class="nav-item px-3 ">
                    <a class="nav-link text-info" data-label="work-note" href="#">
                        <i class="icon-pin"></i> Work
                    </a>
                </li>

            </ul>

        </div>
    </div>
    <div class="col-12 col-lg-9 col-xl-10 mb-4 mt-3 pl-lg-0">
        <div class="card border  h-100 notes-list-section"> 
            <a href="#" class="d-inline-block d-lg-none flip-menu-toggle border-0"><i class="icon-menu"></i></a>
            <div class="row notes">
                <div class="col-12  col-md-6 col-lg-4 my-3 note business-note all starred" data-type="business-note">
                    <div class="card">                            
                        <div class="card-content">
                            <div class="card-body p-4">
                                <h6 class="mb-3 font-w-600">Remove Houtzdale Location</h6>
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="note-date">June 14th, 2020</span></p> 
                                <div class="note-content mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                <div class="d-flex notes-tool">
                                    <span class="icon-star"></span> 
                                    <span class="icon-exclamation mx-2"></span>    
                                    <span class="dot"></span> 
                                    <div class="ml-auto">
                                        <a class="text-success edit-note" href="#" data-toggle="modal" data-target="#editnote"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-note" href="#"><i class="icon-trash"></i></a>                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12  col-md-6 col-lg-4 my-3 note personal-note all important" data-type="personal-note">
                    <div class="card">                            
                        <div class="card-content">
                            <div class="card-body p-4">
                                <h6 class="mb-3 font-w-600">Video not Wokring</h6>
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="note-date">June 4th, 2020</span></p> 
                                <div class="note-content mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                <div class="d-flex notes-tool">
                                    <span class="icon-star"></span> 
                                    <span class="icon-exclamation mx-2"></span>    
                                    <span class="dot"></span> 
                                    <div class="ml-auto">
                                        <a class="text-success edit-note" href="#" data-toggle="modal" data-target="#editnote"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-note" href="#"><i class="icon-trash"></i></a>                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12  col-md-6 col-lg-4 my-3 note work-note all starred important" data-type="work-note">
                    <div class="card">                            
                        <div class="card-content">
                            <div class="card-body p-4">
                                <h6 class="mb-3 font-w-600">Limit API to logged in users</h6>
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="note-date">May 21st, 2020</span></p> 
                                <div class="note-content mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                <div class="d-flex notes-tool">
                                    <span class="icon-star"></span> 
                                    <span class="icon-exclamation mx-2"></span>    
                                    <span class="dot"></span> 
                                    <div class="ml-auto">
                                        <a class="text-success edit-note" href="#" data-toggle="modal" data-target="#editnote"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-note" href="#"><i class="icon-trash"></i></a>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12  col-md-6 col-lg-4 my-3 note social-note all" data-type="social-note">
                    <div class="card">                            
                        <div class="card-content">
                            <div class="card-body p-4">
                                <h6 class="mb-3 font-w-600">Page Performance Issues</h6>
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="note-date">May 14th, 2020</span></p> 
                                <div class="note-content mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                <div class="d-flex notes-tool">
                                    <span class="icon-star"></span> 
                                    <span class="icon-exclamation mx-2"></span>    
                                    <span class="dot"></span> 
                                    <div class="ml-auto">
                                        <a class="text-success edit-note" href="#" data-toggle="modal" data-target="#editnote"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-note" href="#"><i class="icon-trash"></i></a>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12  col-md-6 col-lg-4 my-3 note private-note all" data-type="private-note">
                    <div class="card">                            
                        <div class="card-content">
                            <div class="card-body p-4">
                                <h6 class="mb-3 font-w-600">Remove Houtzdale Location</h6>
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="note-date">Feb 4th, 2020</span></p> 
                                <div class="note-content mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                <div class="d-flex notes-tool">
                                    <span class="icon-star"></span> 
                                    <span class="icon-exclamation mx-2"></span>    
                                    <span class="dot"></span> 
                                    <div class="ml-auto">
                                        <a class="text-success edit-note" href="#" data-toggle="modal" data-target="#editnote"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-note" href="#"><i class="icon-trash"></i></a>                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12  col-md-6 col-lg-4 my-3 note business-note all" data-type="business-note">
                    <div class="card">                            
                        <div class="card-content">
                            <div class="card-body p-4">
                                <h6 class="mb-3 font-w-600">Post-Launch SEO Audit</h6>
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="note-date">April 20th, 2020</span></p> 
                                <div class="note-content mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                <div class="d-flex notes-tool">
                                    <span class="icon-star"></span> 
                                    <span class="icon-exclamation mx-2"></span>    
                                    <span class="dot"></span> 
                                    <div class="ml-auto">
                                        <a class="text-success edit-note" href="#" data-toggle="modal" data-target="#editnote"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-note" href="#"><i class="icon-trash"></i></a>                                  
                                    </div>
                                </div>
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
<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/quill/quill.min.js'); ?>"></script>  
<script src="<?php echo base_url('dist/js/notes.script.js'); ?>"></script>  
<!-- END: Page JS-->
<?= $this->endSection() ?>