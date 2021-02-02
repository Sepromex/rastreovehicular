<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Task Board</h4>
                <a href="#" class="btn btn-primary mt-2" data-toggle="modal" data-target="#addlist">Add List</a>
            </div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">App</li>
                <li class="breadcrumb-item active"><a href="#" >Task Board</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->
<!-- Add List -->
<div class="modal fade" id="addlist">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="icon-pencil"></i> Add List
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="icon-close"></i>
                </button>
            </div>

            <form class="add-list">
                <div class="modal-body">  
                    <div class="form-group">
                        <label for="list-name" class="col-form-label">List Name</label>
                        <input type="text" class="form-control" id="list-name" >
                    </div>
                </div>                                         
                <div class="modal-footer">                                                 
                    <button type="submit" class="btn btn-primary send-email">Add List</button>
                </div>
            </form>


        </div>
    </div>
</div>

<!-- Add List -->
<div class="modal fade" id="editlist">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="icon-pencil"></i> Edit List
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="icon-close"></i>
                </button>
            </div>

            <form class="edit-list">
                <div class="modal-body">  
                    <div class="form-group">
                        <label for="edit-list-name" class="col-form-label">List Name</label>
                        <input type="text" class="form-control" id="edit-list-name" >
                    </div>
                </div>                                         
                <div class="modal-footer">                                                 
                    <button type="submit" class="btn btn-primary send-email">Update List</button>
                </div>
            </form>


        </div>
    </div>
</div>


<!-- Add Task -->
<div class="modal fade" id="addtask">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="icon-pencil"></i> Add Task
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="icon-close"></i>
                </button>
            </div>

            <form class="add-task">
                <div class="modal-body">  
                    <div class="form-group">
                        <label for="task-name" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="task-name" >
                    </div>
                    <div class="form-group">
                        <label for="task-description" class="col-form-label">Description</label>
                        <textarea class="form-control" rows="10" id="task-description"></textarea>
                    </div>
                </div>                                         
                <div class="modal-footer">                                                 
                    <button type="submit" class="btn btn-primary send-email">Add Task</button>
                </div>
            </form>


        </div>
    </div>
</div>

<!-- Add Task -->
<div class="modal fade" id="edittask">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="icon-pencil"></i> Edit Task
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="icon-close"></i>
                </button>
            </div>

            <form class="edit-task">
                <div class="modal-body">  
                    <div class="form-group">
                        <label for="edit-task-name" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="edit-task-name" >
                    </div>
                    <div class="form-group">
                        <label for="edit-task-description" class="col-form-label">Description</label>
                        <textarea class="form-control" rows="10" id="edit-task-description"></textarea>
                    </div>
                </div>                                         
                <div class="modal-footer">    
                    <input type="hidden" id="task-date">
                    <button type="submit" class="btn btn-primary send-email">Edit Task</button>
                </div>
            </form>


        </div>
    </div>
</div>

<!-- START: Card Data-->
<div class="row row-eq-height task-list-row">
    <div class="col-12 col-md-6 col-lg mt-3 task-list-item">
        <div class="card bg-primary-light">
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Todo</h6>   
                <div class="dropdown">
                    <a href="#"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ml-2 icon-arrow-down"></i>
                    </a>                                    

                    <ul class="dropdown-menu dropdown-menu-right border py-0">
                        <li><a class="dropdown-item edit" href="#"><i class="icon-pencil"></i> Rename</a></li>
                        <li><a class="dropdown-item delete" href="#"><i class="icon-trash"></i> Delete</a></li>
                    </ul>
                </div>                               
            </div>
            <div class="card-body"> 
                <div class="task-list">
                    <div class="card my-2 task-card">                            
                        <div class="card-content">
                            <div class="card-body p-4 body-color">
                                <h6 class="mb-3 font-w-600">Remove Houtzdale Location</h6>
                                <div class="task-content mb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="task-date">June 15th, 2020</span></p>                                            
                                <div class="d-flex">
                                    <div class="my-auto line-h-1 h5">
                                        <a class="text-success edit-task" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-task" href="#"><i class="icon-trash"></i></a>                                 
                                    </div>                                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card my-2 task-card">                            
                        <div class="card-content">
                            <div class="card-body p-4 body-color">
                                <h6 class="mb-3 font-w-600 h6">Limit API to logged in users</h6>                                            
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="task-date">May 4th, 2020</span></p>                                            
                                <div class="d-flex">
                                    <div class="my-auto line-h-1 h5">
                                        <a class="text-success edit-task" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-task" href="#"><i class="icon-trash"></i></a>                                  
                                    </div>                                               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#" class="bg-primary w-100 d-block text-center py-2 px-2 mt-3 rounded text-white add-task" data-toggle="modal" data-target="#addtask">
                    <i class="icon-plus align-middle text-white"></i> <span>Add Task</span>
                </a>

            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg mt-3 task-list-item">
        <div class="card bg-primary-light">
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">In progress</h6>  
                <div class="dropdown">
                    <a href="#"  id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ml-2 icon-arrow-down"></i>
                    </a>                                    

                    <ul class="dropdown-menu dropdown-menu-right border py-0">
                        <li><a class="dropdown-item edit" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil" ></i> Rename</a></li>
                        <li><a class="dropdown-item delete" href="#"><i class="icon-trash"></i> Delete</a></li>
                    </ul>
                </div>                                    
            </div>
            <div class="card-body">                                   
                <div class="task-list">
                    <div class="card my-2 task-card">                            
                        <div class="card-content">
                            <div class="card-body p-4 body-color">
                                <h6 class="mb-3 font-w-600">Video not Wokring</h6>
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="task-date">May 15th, 2020</span></p>                                            
                                <div class="d-flex">
                                    <div class="my-auto line-h-1 h5">
                                        <a class="text-success edit-task" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-task" href="#"><i class="icon-trash"></i></a>                                 
                                    </div>                                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card my-2 task-card">                            
                        <div class="card-content">
                            <div class="card-body p-4 body-color">
                                <h6 class="mb-3 font-w-600 h6">Page Performance Issues</h6>                                            
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="task-date">May 4th, 2020</span></p>                                            
                                <div class="d-flex">
                                    <div class="my-auto line-h-1 h5">
                                        <a class="text-success edit-task" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-task" href="#"><i class="icon-trash"></i></a>                                  
                                    </div>                                               
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card my-2 task-card">                            
                        <div class="card-content">
                            <div class="card-body p-4 body-color">
                                <h6 class="mb-3 font-w-600 h6">Post-Launch SEO Audit</h6>                                            
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="task-date">April 4th, 2020</span></p>                                            
                                <div class="d-flex">
                                    <div class="my-auto line-h-1 h5">
                                        <a class="text-success edit-task" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-task" href="#"><i class="icon-trash"></i></a>                                  
                                    </div>                                               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#" class="bg-primary w-100 d-block text-center py-2 px-2 mt-3 rounded text-white add-task" data-toggle="modal" data-target="#addtask">
                    <i class="icon-plus align-middle text-white"></i> <span>Add Task</span>
                </a>
            </div>
        </div>


    </div>
    <div class="col-12 col-md-6 col-lg mt-3 task-list-item">
        <div class="card bg-primary-light">
            <div class="card-header d-flex justify-content-between align-items-center">                               
                <h6 class="card-title">Completed</h6> 
                <div class="dropdown">
                    <a href="#"  id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ml-2 icon-arrow-down"></i>
                    </a>                                    

                    <ul class="dropdown-menu dropdown-menu-right border py-0">
                        <li><a class="dropdown-item edit" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i> Rename</a></li>
                        <li><a class="dropdown-item delete" href="#"><i class="icon-trash"></i> Delete</a></li>
                    </ul>
                </div>    
            </div>
            <div class="card-body">                                   
                <div class="task-list">                                    
                    <div class="card my-2 task-card">                            
                        <div class="card-content">
                            <div class="card-body p-4 body-color">
                                <h6 class="mb-3 font-w-600 h6">Limit API to logged in users</h6>                                            
                                <p class="font-w-500 tx-s-12"><i class="icon-calendar"></i> <span class="task-date">May 4th, 2020</span></p>                                            
                                <div class="d-flex">
                                    <div class="my-auto line-h-1 h5">
                                        <a class="text-success edit-task" href="#" data-toggle="modal" data-target="#edittask"><i class="icon-pencil"></i></a>
                                        <a class="text-danger delete-task" href="#"><i class="icon-trash"></i></a>                                  
                                    </div>                                               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#" class="bg-primary w-100 d-block text-center py-2 px-2 mt-3 rounded text-white add-task" data-toggle="modal" data-target="#addtask">
                    <i class="icon-plus align-middle text-white"></i> <span>Add Task</span>
                </a>
            </div>
        </div>


    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>
<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/js/app-taskboard.js'); ?>"></script>  
<!-- END: Page JS-->
<?= $this->endSection() ?>