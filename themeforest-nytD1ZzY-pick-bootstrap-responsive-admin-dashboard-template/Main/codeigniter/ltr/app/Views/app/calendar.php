<?= $this->extend('layouts/admin') ?>

<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet" href="<?php echo base_url('dist/vendors/fullcalendar/core/main.min.css'); ?>"> 
<link rel="stylesheet" href='<?php echo base_url('dist/vendors/fullcalendar/daygrid/main.css'); ?>'/>
<link rel="stylesheet" href='<?php echo base_url('dist/vendors/fullcalendar/timegrid/main.css'); ?>'/>
<link rel="stylesheet" href='<?php echo base_url('dist/vendors/fullcalendar/list/main.css'); ?>'/>   
<!-- END: Page CSS-->
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row">
        <div class="col-12 align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">App Calendar</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">App</li>
                    <li class="breadcrumb-item active"><a href="#">Calendar</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row row-eq-height">
        <div class="col-12 col-md-12 mt-3">  
            <div class="card">
                <div class="card-body d-md-flex text-center">
                    <ul class="d-md-flex m-0 pl-0 list-unstyled">
                        <li class="pill cl-personal py-1 px-2 mr-md-2 text-center my-1">
                            Personal
                        </li>

                        <li class="pill cl-professional py-1 px-2 mr-md-2 text-center my-1">
                            Professional
                        </li>
                        <li class="pill cl-work py-1 px-2 mr-md-2 text-center my-1">
                            Work
                        </li>

                        <li class="pill cl-home py-1 px-2 mr-md-2 text-center my-1">
                            Home
                        </li>
                        <li class="pill cl-office py-1 px-2 text-center my-1">
                            Office
                        </li>                                    
                    </ul>
                    <a href="#" class="btn btn-outline-success font-w-600 my-auto text-nowrap ml-auto add-event" data-toggle="modal" data-target="#addevent"><i class="icon-calendar"></i> Add Event</a>

                    <!-- Modal -->
                    <div id="addevent" class="modal fade" role="dialog">
                        <div class="modal-dialog text-left">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">      
                                    <h4 class="modal-title" id="model-header">Add Event</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="start-date" class="">Event Title:</label>
                                                    <div class="d-flex event-title">
                                                        <input id="title"  type="text" placeholder="Enter Title" class="form-control" name="title">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-12">
                                                <div class="form-group start-date">
                                                    <label for="start-date" class="">From:</label>
                                                    <div class="d-flex">
                                                        <input id="start-date" placeholder="Start Date" class="form-control" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-12">
                                                <div class="form-group end-date">
                                                    <label for="end-date" class="">To:</label>
                                                    <div class="d-flex">
                                                        <input id="end-date" placeholder="End Date" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="taskdescription" class="">Event Description:</label>
                                                    <div class="d-flex event-description">
                                                        <textarea id="taskdescription" placeholder="Enter Description" rows="3" class="form-control" name="taskdescription"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="inputColor" class="">Color:</label>

                                                    <input type="color" class="border-0 m-2" id="inputColor" value="#a7f4ec">

                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button id="discard" class="btn btn-outline-primary" data-dismiss="modal">Discard</button>
                                    <button id="add-event" class="btn btn-primary eventbutton">Add Event</button>

                                </div>
                            </div>

                        </div>
                    </div>   




                </div>
            </div>


        </div>
        <div class="col-12 col-md-12 mt-3">
            <div class="card h-100">
                <div class="card-body h-100">
                    <div id='calendar' class="h-100"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Card DATA--> 
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS--><script src="<?php echo base_url('dist/vendors/popper/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/tooltip/tooltip-min.js'); ?>"></script>
<script src="<?php echo base_url('dist/vendors/fullcalendar/core/main.min.js'); ?>"></script>        
<script src='<?php echo base_url('dist/vendors/fullcalendar/interaction/main.js'); ?>'></script>
<script src='<?php echo base_url('dist/vendors/fullcalendar/daygrid/main.js'); ?>'></script>
<script src='<?php echo base_url('dist/vendors/fullcalendar/timegrid/main.js'); ?>'></script>
<script src='<?php echo base_url('dist/vendors/fullcalendar/list/main.js'); ?>'></script>
<script src="<?php echo base_url('dist/vendors/fullcalendar/bundle/moment.min.js'); ?>"></script>  
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="<?php echo base_url('dist/js/calendar.script.js'); ?>"></script>    
<!-- END: Page JS-->
<?= $this->endSection() ?>