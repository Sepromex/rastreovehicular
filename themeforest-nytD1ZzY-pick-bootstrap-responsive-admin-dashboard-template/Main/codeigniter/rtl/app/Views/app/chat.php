<?= $this->extend('layouts/admin') ?>



<?= $this->section('content') ?>
   <!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 ml-auto"><h4 class="mb-0">App Chat</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">App</li>
                    <li class="breadcrumb-item active"><a href="#">Chat</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="chat-screen">
        <a href="#" class="chat-contact round-button d-inline-block d-lg-none"><i class="icon-menu"></i></a>
        <a href="#" class="chat-profile d-inline-block d-lg-none"><img class="img-fluid  rounded-circle" src="<?php echo base_url('dist/images/team-3.jpg');?>" width="30" alt=""></a>
        <div class="row row-eq-height">
            <div class="col-12 col-lg-4 col-xl-3 mt-lg-3 pl-lg-0">
                <div class="card border h-100 chat-contact-list">
                    <div class="card-header d-flex justify-content-between align-items-center"> 
                        <ul class="nav nav-tabs pr-0" id="tabs-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active font-weight-bold" id="tabs-day-tab" data-toggle="tab" href="#tabs-day" role="tab" aria-controls="tabs-day" aria-selected="true">Chat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" id="tabs-week-tab" data-toggle="tab" href="#tabs-week" role="tab" aria-controls="tabs-week" aria-selected="false">Contacts</a>
                            </li>

                        </ul>
                        <a href="#"  class="bg-primary py-1 px-2 rounded mr-auto text-white" data-toggle="modal" data-target="#newcontact">
                            <span class="d-xl-inline-block">Add New</span>
                        </a>
                        <!-- The Modal -->
                        <div class="modal" id="newcontact">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="icon-user-follow"></i> Add Friends
                                        </h5>
                                        <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
                                            <i class="icon-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">                                               
                                        <form>
                                            <div class="form-group">
                                                <label for="emails" class="col-form-label">Name</label>
                                                <input type="text" class="form-control" id="name">
                                            </div>                                                    
                                            <div class="form-group">
                                                <label for="emails" class="col-form-label">Email addresses</label>
                                                <input type="text" class="form-control" id="emails">
                                            </div>
                                            <div class="form-group">
                                                <label for="emails" class="col-form-label">Phone</label>
                                                <input type="text" class="form-control" id="phone">
                                            </div>
                                            <div class="form-group">
                                                <label for="message" class="col-form-label">Message</label>
                                                <textarea class="form-control" id="message"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tabs-day" role="tabpanel" aria-labelledby="tabs-day-tab">
                            <ul class="nav flex-column chat-menu pr-0" id="myTab" role="tablist">
                                <li class="nav-item active px-3">
                                    <a class="nav-link online-status green" data-toggle="tab" href="#tab1" role="tab" aria-selected="true">
                                        <div class="media d-block d-flex text-right py-2">
                                            <img class="img-fluid ml-3 rounded-circle" src="<?php echo base_url('dist/images/author2.jpg');?>" alt="">
                                            <div class="media-body align-self-center mt-0 color-primary d-flex">
                                                <div class="message-content"> <b class="mb-1 font-weight-bold d-flex">Harry Jones</b>
                                                    How are you? ... 
                                                    <br>
                                                    <small class="body-color">23 hours ago</small></div>
                                                <div class="new-message mr-auto bg-primary text-white">3</div>

                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item  px-3">
                                    <a class="nav-link online-status green" data-toggle="tab" href="#tab2" role="tab" aria-selected="false">
                                        <div class="media d-block d-flex text-right py-2">
                                            <img class="img-fluid  ml-3 rounded-circle" src="<?php echo base_url('dist/images/author3.jpg');?>" alt="">
                                            <div class="media-body align-self-center mt-0 color-primary d-flex">
                                                <div class="message-content"> <b class="mb-1 font-weight-bold d-flex">Daniel Taylor</b>
                                                    I am waiting ... 
                                                    <br>
                                                    <small class="body-color">14 hours ago</small></div>
                                                <div class="new-message mr-auto bg-primary text-white">1</div>

                                            </div>
                                        </div> 
                                    </a>
                                </li>
                                <li class="nav-item  px-3">
                                    <a class="nav-link online-status yellow" data-toggle="tab" href="#tab3" role="tab" aria-selected="false">
                                        <div class="media d-block d-flex text-right py-2">
                                            <img class="img-fluid ml-3 rounded-circle" src="<?php echo base_url('dist/images/author.jpg');?>" alt="">
                                            <div class="media-body align-self-center mt-0">
                                                <b class="mb-1 font-weight-bold">Charlotte </b><br>
                                                video <i class="fa fa-file-video-o"></i>
                                            </div>
                                        </div> 
                                    </a>
                                </li>
                                <li class="nav-item  px-3">
                                    <a class="nav-link online-status yellow" data-toggle="tab" href="#tab4" role="tab" aria-selected="false">
                                        <div class="media d-block d-flex text-right py-2">
                                            <img class="img-fluid  ml-3 rounded-circle" src="<?php echo base_url('dist/images/author7.jpg');?>" alt="">
                                            <div class="media-body align-self-center mt-0">
                                                <b class="mb-1 font-weight-bold">Jack Sparrow</b><br>
                                                tour pictures <i class="fa fa-photo"></i>
                                            </div>
                                        </div> 
                                    </a>
                                </li>
                                <li class="nav-item px-3">
                                    <a class="nav-link online-status yellow" data-toggle="tab" href="#tab5" role="tab" aria-selected="false">
                                        <div class="media d-block d-flex text-right py-2">
                                            <img class="img-fluid  ml-3 rounded-circle" src="<?php echo base_url('dist/images/author6.jpg');?>" alt="">
                                            <div class="media-body align-self-center mt-0">
                                                <b class="mb-1 font-weight-bold">Bhaumik</b><br>
                                                Lorem Ipsum has been the industry ...
                                            </div>
                                        </div> 
                                    </a>
                                </li>
                                <li class="nav-item px-3">
                                    <a class="nav-link online-status yellow" data-toggle="tab" href="#tab6" role="tab" aria-selected="false">
                                        <div class="media d-block d-flex text-right py-2">
                                            <img class="img-fluid  ml-3 rounded-circle" src="<?php echo base_url('dist/images/author8.jpg');?>" alt="">
                                            <div class="media-body align-self-center mt-0">
                                                <b class="mb-1 font-weight-bold">Wood Walton</b><br>
                                                Aldus PageMaker including versions ...
                                            </div>
                                        </div> 
                                    </a>
                                </li>
                            </ul>                                                    
                        </div>
                        <div class="tab-pane fade" id="tabs-week" role="tabpanel" aria-labelledby="tabs-week-tab">
                            <ul class="nav flex-column chat-menu pr-0" id="myTab1" role="tablist">
                                <li class="nav-item active px-3">
                                    <a class="nav-link" data-toggle="tab" href="#tab1" role="tab" aria-selected="true">
                                        <div class="media d-block d-flex text-right py-3">
                                            <img class="img-fluid  ml-3 rounded-circle" src="<?php echo base_url('dist/images/author2.jpg');?>" alt="">
                                            <div class="media-body align-self-center mt-0">
                                                <b class="mb-1 font-weight-bold">Harry Jones</b><br>
                                                Managing Partner at MDD
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item px-3">
                                    <a class="nav-link" data-toggle="tab" href="#tab2" role="tab" aria-selected="false">
                                        <div class="media d-block d-flex text-right py-3">
                                            <img class="img-fluid ml-3 rounded-circle" src="<?php echo base_url('dist/images/author3.jpg');?>" alt="">
                                            <div class="media-body align-self-center mt-0">
                                                <b class="mb-1 font-weight-bold">Daniel Taylor</b><br>
                                                Freelance Web Developer
                                            </div>
                                        </div> 
                                    </a>
                                </li>
                                <li class="nav-item px-3">
                                    <a class="nav-link" data-toggle="tab" href="#tab3" role="tab" aria-selected="false">
                                        <div class="media d-block d-flex text-right py-3">
                                            <img class="img-fluid ml-3 rounded-circle" src="<?php echo base_url('dist/images/author.jpg');?>" alt="">
                                            <div class="media-body align-self-center mt-0">
                                                <b class="mb-1 font-weight-bold">Charlotte </b><br>
                                                Co-Founder &amp; CEO at Pi
                                            </div>
                                        </div> 
                                    </a>
                                </li>
                                <li class="nav-item px-3">
                                    <a class="nav-link" data-toggle="tab" href="#tab4" role="tab" aria-selected="false">
                                        <div class="media d-block d-flex text-right py-3">
                                            <img class="img-fluid  ml-3 rounded-circle" src="<?php echo base_url('dist/images/author7.jpg');?>" alt="">
                                            <div class="media-body align-self-center mt-0">
                                                <b class="mb-1 font-weight-bold">Jack Sparrow</b><br>
                                                Managing Partner at MDD
                                            </div>
                                        </div> 
                                    </a>
                                </li>
                                <li class="nav-item px-3">
                                    <a class="nav-link" data-toggle="tab" href="#tab5" role="tab" aria-selected="false">
                                        <div class="media d-block d-flex text-right py-3">
                                            <img class="img-fluid ml-3 rounded-circle" src="<?php echo base_url('dist/images/author6.jpg');?>" alt="">
                                            <div class="media-body align-self-center mt-0">
                                                <b class="mb-1 font-weight-bold">Bhaumik</b><br>
                                                Managing Partner at MDD
                                            </div>
                                        </div> 
                                    </a>
                                </li>

                            </ul>
                        </div>                                
                    </div>  
                </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-6 mt-3 pl-lg-0 pr-lg-0">
                <div class="card border h-100 rounded-0">
                    <div class="card-body p-0">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                <ul class="nav flex-column chat-menu pr-0" id="myTab3" role="tablist">
                                    <li class="nav-item active px-3 px-md-1 px-xl-3">                                               
                                        <div class="media d-block d-flex text-right py-2">
                                            <img class="img-fluid  ml-3 rounded-circle" src="<?php echo base_url('dist/images/team-3.jpg');?>" width="54" alt="">
                                            <div class="media-body align-self-center mt-0  d-flex">
                                                <div class="message-content"> <h6 class="mb-1 font-weight-bold d-flex">Harry Jones</h6>
                                                    typing ... 
                                                    <br>
                                                </div>
                                                <div class="call-button mr-auto">
                                                    <a href="#" class="call h4 mb-0" data-toggle="modal" data-target="#call1"><i class="icon-phone"></i></a>
                                                    <a href="#" class="video-call h4 mb-0" data-toggle="modal" data-target="#call1"><i class="icon-camrecorder"></i></a>
                                                </div>
                                            </div>
                                        </div>                                               
                                    </li>
                                </ul>
                                <!-- The Modal -->
                                <div class="modal" id="call1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">

                                            <div class="modal-body p-0">                                               
                                                <ul class="nav flex-column chat-menu pr-0">
                                                    <li class="nav-item active px-3 py-4">                                               
                                                        <div class="media d-block d-flex text-right py-3">
                                                            <img class="img-fluid ml-3 rounded-circle" src="<?php echo base_url('dist/images/author2.jpg');?>" alt="">
                                                            <div class="media-body align-self-center mt-0  d-flex">
                                                                <div class="message-content"> <h6 class="mb-1 font-weight-bold d-flex">Harry Jones</h6>
                                                                    calling ... 
                                                                    <br>
                                                                </div>
                                                                <div class="call-button mr-auto">
                                                                    <a href="#" class="call h4" data-toggle="modal" data-target="#call1"><i class="icon-phone"></i></a>
                                                                    <a href="#" class="video-call ml-2 h4 bg-danger"  data-dismiss="modal"><i class="icon-close"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>                                               
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>



                                <div class="scrollerchat p-3">   

                                    <div class="media d-flex  mb-4">                                                    
                                        <div class="ml-4"><a href="#"><img src="<?php echo base_url('dist/images/author2.jpg');?>" alt="" class="img-fluid rounded-circle" /></a></div>
                                        <div class="p-3 ml-auto speech-bubble">
                                            Hello John, how can I help you today ?
                                        </div>
                                    </div>
                                    <div class="media d-flex mb-4">
                                        <div class="p-3 mr-auto speech-bubble alt">
                                            Hi, I want to buy a new shoes.
                                        </div>
                                        <div class="mr-4 thumb-img"><a href="#"><img src="<?php echo base_url('dist/images/author3.jpg');?>" alt="" class="img-fluid rounded-circle" /></a></div>

                                    </div>
                                    <div class="media d-flex mb-4">                                                    
                                        <div class="ml-4"><a href="#"><img src="<?php echo base_url('dist/images/author2.jpg');?>" alt="" class="img-fluid rounded-circle" /></a></div>
                                        <div class="p-3 ml-auto speech-bubble">
                                            Shipment is free. You'll get your shoes tomorrow!<br/>
                                            <img src="<?php echo base_url('dist/images/shoes.jpg');?>" alt="" width="300" class="img-fluid mt-2" />
                                        </div>
                                    </div>

                                    <div class="media d-flex mb-4">
                                        <div class="p-3 mr-auto speech-bubble alt">
                                            Wow that's great!
                                        </div>
                                        <div class="mr-4 thumb-img"><a href="#"><img src="<?php echo base_url('dist/images/author3.jpg');?>" alt="" class="img-fluid rounded-circle" /></a></div>

                                    </div>
                                    <div class="media d-flex mb-4">
                                        <div class="p-3 mr-auto speech-bubble alt">
                                            Ok. Thanks for the answer. Appreciated.<br/>
                                            <div class='embed-container mt-2'><iframe src='https://player.vimeo.com/video/66140585' class="border-0" allowFullScreen></iframe></div>
                                        </div>
                                        <div class="mr-4 thumb-img"><a href="#"><img src="<?php echo base_url('dist/images/author3.jpg');?>" alt="" class="img-fluid rounded-circle" /></a></div>

                                    </div>
                                    <div class="media d-flex mb-4">

                                        <div class="ml-4"><a href="#"><img src="<?php echo base_url('dist/images/author2.jpg');?>" alt="" class="img-fluid rounded-circle" /></a></div>
                                        <div class="p-3 ml-auto speech-bubble">
                                            You are welcome!
                                        </div>
                                    </div>

                                </div>
                                <div class="border-top theme-border px-2 py-3 d-flex position-relative chat-box">
                                    <input type="text" class="form-control ml-2" placeholder="Type message here ..." />                                               
                                    <a href="#" class="p-2 mr-2 rounded line-height-21 bg-primary text-white"><i class="icon-cursor align-middle"></i></a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-3 mt-lg-3 pr-lg-0">
                <div class="card border h-100 chat-user-profile">
                    <ul class="nav flex-column pr-0">
                        <li class="nav-item active px-3">                                               
                            <div class="media d-block d-flex text-right py-2">                                                   
                                <div class="media-body align-self-center mt-0  d-flex">
                                    <div class="message-content my-1"> <h6 class="mb-1 font-weight-bold d-flex">Harry Jones</h6>
                                        Lead Web Developer - I can fix anything
                                        <br>
                                    </div>                                                       
                                </div>
                            </div>                                               
                        </li>
                    </ul> 
                    <img class="img-fluid" src="<?php echo base_url('dist/images/team-3.jpg');?>" alt="">
                    <div class="px-3 py-4">
                        <b>Display Name</b>
                        <p>Harry</p>
                        <b>Local time</b>
                        <p>3:40AM</p>
                        <b>Email Address</b>
                        <p>harry@example.com</p>
                    </div>
                    <div class="d-flex outline-badge-primary border-0 mt-1">
                        <div class="w-50 text-center p-3"><a href="#" class="font-weight-bold">View Profile <i class="fas fa-arrow-right"></i></a></div>
                        <div class="w-50 text-center p-3 border-right"><a href="#" class="text-danger font-weight-bold">Logout <span class="icon-logout"></span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Card DATA-->
<?= $this->endSection() ?>
