<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">App To Do</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">App</li>
                <li class="breadcrumb-item active"><a href="#">Todo</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row row-eq-height">
    <div class="col-12 col-lg-2 mt-3 todo-menu-bar flip-menu pr-lg-0">
        <a href="#" class="d-inline-block d-lg-none mt-1 flip-menu-close"><i class="icon-close"></i></a>
        <div class="card border h-100 todo-menu-section">
            <div class="card-header d-flex justify-content-between align-items-center">  
                <h5 class="mb-0">Tasks</h5>
                <a href="#"  class="bg-primary py-2 px-2 rounded ml-auto text-white" data-toggle="modal" data-target="#newtodo">
                    <i class="icon-plus align-middle text-white"></i> <span>Add New</span>
                </a>
                <!-- Add Todo -->
                <div class="modal fade" id="newtodo">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="icon-pencil"></i> Add Todo
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="icon-close"></i>
                                </button>
                            </div>
                            <form class="add-todo-form">
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

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary add-todo">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Edit Todo -->
                <div class="modal fade" id="edittodo">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="icon-pencil"></i> Edit Todo
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="icon-close"></i>
                                </button>
                            </div>
                            <form class="edit-todo-form">
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

            <ul class="nav flex-column todo-menu">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-todotype="todo-item">
                        <i class="icon-list"></i> All
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-todotype="starred">
                        <i class="icon-star"></i> Starred
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#important" data-todotype="important">
                        <i class="icon-exclamation"></i> Important
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="#completed" data-todotype="completed">
                        <i class="icon-check"></i> Completed
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="#trashed" data-todotype="trashed">
                        <i class="icon-trash"></i> Trashed
                    </a>
                </li>

            </ul>         

        </div>  
    </div>
    <div class="col-12 col-lg-10 mt-3 pl-lg-0">
        <div class="card border h-100 todo-list-section">
            <div class="card-header border-bottom p-1 d-flex">
                <a href="#" class="d-inline-block d-lg-none flip-menu-toggle"><i class="icon-menu"></i></a>
                <input type="text" class="form-control border-0 p-2 w-100 h-100 todo-search" placeholder="Search ...">
            </div>
            <div class="card-body p-0">

                <div class="scrollertodo">
                    <ul class="todo-list">
                        <li class="todo-item starred completed">
                            <label class="chkbox">                                                        
                                <input type="checkbox" checked="checked">
                                <span class="checkmark mt-2"></span>
                            </label>
                            <div class="todo-content">                                                        
                                <h3>Aenean ligula porttitor consequat vitae eleifend enim.</h3>  
                                <p class="text-muted mb-0 font-weight-bold todo-date">June 8, 2020</p>
                                <p class="small-content text-muted mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                            <div class="ml-auto">
                                <i class="icon-star mr-2 font-15"></i> 
                                <i class="icon-exclamation font-15 mr-2"></i>
                            </div>
                            <div>
                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical font-15"></i></a>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                                    <a class="dropdown-item edit-todo" href="#" >Edit</a>
                                    <a class="dropdown-item delete" href="#">Delete</a>                                        
                                </div>
                            </div>                                                          
                        </li>
                        <li class="todo-item important">
                            <label class="chkbox">                                                        
                                <input type="checkbox">
                                <span class="checkmark mt-2"></span>
                            </label>
                            <div class="todo-content">                                                        
                                <h3>In enim justo, rhoncus ut imperdiet a, venenatis vitae justo.</h3>  
                                <p class="text-muted mb-0 font-weight-bold todo-date">May 22, 2020</p>
                                <p class="small-content text-muted mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                            <div class="ml-auto">
                                <i class="icon-star mr-2 font-15"></i> 
                                <i class="icon-exclamation font-15 mr-2"></i>
                            </div>
                            <div>
                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical font-15"></i></a>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                                    <a class="dropdown-item edit-todo" href="#">Edit</a>
                                    <a class="dropdown-item delete" href="#">Delete</a>                                        
                                </div>
                            </div>                                                          
                        </li>
                        <li class="todo-item">
                            <label class="chkbox">                                                        
                                <input type="checkbox">
                                <span class="checkmark mt-2"></span>
                            </label>
                            <div class="todo-content">                                                        
                                <h3>Cras dapibus vivamus elementum semper nisi.</h3>  
                                <p class="text-muted mb-0 font-weight-bold todo-date">May 12, 2020</p>
                                <p class="small-content text-muted mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                            <div class="ml-auto">
                                <i class="icon-star mr-2 font-15"></i> 
                                <i class="icon-exclamation font-15 mr-2"></i>
                            </div>
                            <div>
                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical font-15"></i></a>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                                    <a class="dropdown-item edit-todo" href="#">Edit</a>
                                    <a class="dropdown-item delete" href="#">Delete</a>                                        
                                </div>
                            </div>                                                          
                        </li>
                        <li class="todo-item starred completed">
                            <label class="chkbox">                                                        
                                <input type="checkbox" checked="checked">
                                <span class="checkmark mt-2"></span>
                            </label>
                            <div class="todo-content">                                                        
                                <h3>Donec quam felis ultricies nec, pellentesque eu pretium quis.</h3>  
                                <p class="text-muted mb-0 font-weight-bold todo-date">April 30, 2020</p>
                                <p class="small-content text-muted mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                            <div class="ml-auto">
                                <i class="icon-star mr-2 font-15"></i> 
                                <i class="icon-exclamation font-15 mr-2"></i>
                            </div>
                            <div>
                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical font-15"></i></a>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                                    <a class="dropdown-item edit-todo" href="#">Edit</a>
                                    <a class="dropdown-item delete" href="#">Delete</a>                                        
                                </div>
                            </div>                                                          
                        </li>
                        <li class="todo-item important trashed">
                            <label class="chkbox">                                                        
                                <input type="checkbox">
                                <span class="checkmark mt-2"></span>
                            </label>
                            <div class="todo-content">                                                        
                                <h3>Aenean leo ligula porttitor eu consequat vitae, eleifend ac enis.</h3>  
                                <p class="text-muted mb-0 font-weight-bold todo-date">April 12, 2020</p>
                                <p class="small-content text-muted mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                            <div class="ml-auto">
                                <i class="icon-star mr-2 font-15"></i> 
                                <i class="icon-exclamation font-15 mr-2"></i>
                            </div>
                            <div>
                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical font-15"></i></a>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                                    <a class="dropdown-item edit-todo" href="#">Edit</a>
                                    <a class="dropdown-item delete" href="#">Delete</a>                                        
                                </div>
                            </div>                                                          
                        </li>
                        <li class="todo-item starred completed trashed">
                            <label class="chkbox">                                                        
                                <input type="checkbox" checked="checked">
                                <span class="checkmark mt-2"></span>
                            </label>
                            <div class="todo-content">                                                        
                                <h3>Curabitur ullamcorper ultricies nisi nam eget dui.</h3>  
                                <p class="text-muted mb-0 font-weight-bold todo-date">March 18, 2020</p>
                                <p class="small-content text-muted mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                            <div class="ml-auto">
                                <i class="icon-star mr-2 font-15"></i> 
                                <i class="icon-exclamation font-15 mr-2"></i>
                            </div>
                            <div>
                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-options-vertical font-15"></i></a>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                                    <a class="dropdown-item edit-todo" href="#">Edit</a>
                                    <a class="dropdown-item delete" href="#">Delete</a>                                        
                                </div>
                            </div>                                                          
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>
<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/js/todo.js'); ?>"></script>  
<!-- END: Page JS-->
<?= $this->endSection() ?>