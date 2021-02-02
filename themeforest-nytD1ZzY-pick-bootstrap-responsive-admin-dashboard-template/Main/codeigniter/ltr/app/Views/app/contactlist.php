<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">App Contact List</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">App</li>
                <li class="breadcrumb-item active"><a href="#">Contact List</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row row-eq-height">
    <div class="col-12 col-lg-2 mt-3 todo-menu-bar flip-menu pr-lg-0">
        <a href="#" class="d-inline-block d-lg-none mt-1 flip-menu-close"><i class="icon-close"></i></a>
        <div class="card border h-100 contact-menu-section">
            <div class="card-header d-flex justify-content-between align-items-center"> 

                <a href="#"  class="bg-primary py-2 px-2 rounded ml-auto text-white w-100 text-center" data-toggle="modal" data-target="#newcontact">
                    <i class="icon-plus align-middle text-white"></i> <span class="d-none d-xl-inline-block">Add New Contact</span>
                </a>
                <!-- Add Contact -->
                <div class="modal fade" id="newcontact">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="icon-pencil"></i> Add Contact
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="icon-close"></i>
                                </button>
                            </div>
                            <form class="add-contact-form">
                                <div class="modal-body">                                               

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="contact-name">
                                                <label for="contact-name" class="col-form-label">Name</label>
                                                <input type="text" id="contact-name" class="form-control" required="" >                                                                           
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="contact-email">
                                                <label for="contact-email" class="col-form-label">Email</label>
                                                <input type="text" id="contact-email" class="form-control" required="">                                                                          
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="contact-occupation">
                                                <label for="contact-occupation" class="col-form-label">Occupation</label>
                                                <input type="text" id="contact-occupation" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="contact-phone">
                                                <label for="contact-phone" class="col-form-label">Phone</label>
                                                <input type="text" id="contact-phone" class="form-control">                                                                           
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="contact-location">
                                                <label for="contact-location" class="col-form-label">Location</label>
                                                <input type="text" id="contact-location" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary add-todo">Add Contact</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Edit Contact -->
                <div class="modal fade" id="editcontact">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="icon-pencil"></i> Edit Contact
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="icon-close"></i>
                                </button>
                            </div>
                            <form class="edit-contact-form">
                                <div class="modal-body">                                               

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="contact-name">
                                                <label for="edit-contact-name" class="col-form-label">Name</label>
                                                <input type="text" id="edit-contact-name" class="form-control" required="" >                                                                           
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="contact-email">
                                                <label for="edit-contact-email" class="col-form-label">Email</label>
                                                <input type="text" id="edit-contact-email" class="form-control" required="">                                                                          
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="contact-occupation">
                                                <label for="edit-contact-occupation" class="col-form-label">Occupation</label>
                                                <input type="text" id="edit-contact-occupation" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="contact-phone">
                                                <label for="edit-contact-phone" class="col-form-label">Phone</label>
                                                <input type="text" id="edit-contact-phone" class="form-control">                                                                           
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="contact-location">
                                                <label for="edit-contact-location" class="col-form-label">Location</label>
                                                <input type="text" id="edit-contact-location" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <input type="hidden"  id="edit-date">
                                    <button type="submit" class="btn btn-primary add-todo">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <ul class="nav flex-column contact-menu">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-contacttype="contact">
                        <i class="icon-list"></i> All
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-contacttype="family-contact">
                        <i class="icon-people"></i> Family
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-contacttype="friend-contact">
                        <i class="icon-user-follow"></i> Friends
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="#" data-contacttype="office-contact">
                        <i class="icon-check"></i> Office
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="#" data-contacttype="business-contact">
                        <i class="icon-layers"></i> Business
                    </a>
                </li>

            </ul>         

        </div>  
    </div>
    <div class="col-12 col-lg-10 mt-3 pl-lg-0">
        <div class="card border h-100 contact-list-section">
            <div class="card-header border-bottom p-1 d-flex">
                <a href="#" class="d-inline-block d-lg-none flip-menu-toggle"><i class="icon-menu"></i></a>
                <input type="text" class="form-control border-0 p-2 w-100 h-100 contact-search" placeholder="Search ...">
                <a href="#" class="list-style search-bar-menu border-0 active"><i class="icon-list"></i></a>
                <a href="#" class="grid-style search-bar-menu"><i class="icon-grid"></i></a>
            </div>
            <div class="card-body p-0">

                <div class="contacts list">
                    <div class="contact family-contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-1.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">Kayla Fail</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">Chief Executive Officer</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">kf@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">Washington</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div>
                        </div>
                    </div>
                    <div class="contact friend-contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-2.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">Margarita Metts</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">Marketing Coordinator</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">mm@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">Franklin</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div>
                        </div>
                    </div>
                    <div class="contact family-contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-3.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">Shirley Vu</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">Medical Assistant</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">sv@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">Arlington</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div>
                        </div>
                    </div>
                    <div class="contact friend-contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-4.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">Josef Mellott</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">Web Developer</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">jm@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">Centerville</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div>
                        </div>
                    </div>
                    <div class="contact office-contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-5.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">Twanna Lenhart</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">Web Designer</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">tl@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">Lebanon</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div>
                        </div>
                    </div>
                    <div class="contact family-contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-6.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">Eustolia Ashburn</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">President of Sales</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">ea@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">Clinton</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div>
                        </div>
                    </div>
                    <div class="contact business-contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-7.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">Rolanda Cusumano</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">Project Manager</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">rc@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">Springfield</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div>
                        </div>
                    </div>
                    <div class="contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-8.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">Morris Thibeau</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">Account Executive</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">mt@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">Georgetown</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div>
                        </div>
                    </div>
                    <div class="contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-14.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">Nisha Fraise</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">Nursing Assistant</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">nf@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">Fairview</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div>
                        </div>
                    </div>
                    <div class="contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-10.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">Brendon Schebler</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">Librarian</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">bs@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">Greenville</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div>
                        </div>
                    </div>
                    <div class="contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-11.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">John Schebler</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">Librarian</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">js@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">London</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
                            </div>
                        </div>
                    </div>
                    <div class="contact"> 
                        <div class="contact-content">
                            <div class="contact-profile">                                                   
                                <img src="<?php echo base_url('dist/images/contact-13.jpg'); ?>" alt="avatar" class="user-image img-fluid">
                                <div class="contact-info">
                                    <p class="contact-name mb-0">Emily Halk</p>
                                    <p class="contact-position mb-0 small font-weight-bold text-muted">Librarian</p>
                                </div>
                            </div>
                            <div class="contact-email">
                                <p class="mb-0 small">Email: </p>
                                <p class="user-email">eh@mail.com</p>
                            </div>
                            <div class="contact-location">
                                <p class="mb-0 small">Location: </p>
                                <p class="user-location">Missouri</p>
                            </div>
                            <div class="contact-phone">
                                <p class="mb-0 small">Phone: </p>
                                <p class="user-phone">+1 (020) 123-4567</p>
                            </div>
                            <div class="line-h-1 h5">
                                <a class="text-success edit-contact" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                <a class="text-danger delete-contact" href="#"><i class="icon-trash"></i></a>                                 
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
<script src="<?php echo base_url('dist/js/app.contactlist.js'); ?>"></script>  
<!-- END: Page JS-->
<?= $this->endSection() ?>