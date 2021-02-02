<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
    <div class="row">
        <div class="col-12 align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">Product Detail</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Product</li>
                    <li class="breadcrumb-item active"><a href="#">Product Detail</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-5">
                            <img class="img-fluid" alt="product detail" src="<?php echo base_url('dist/images/ecommerce-img1.jpg');?>">
                        </div> 
                        <div class="col-md-12 col-lg-7">
                            <div class="card-body border brd-gray border-top-0 border-right-0 border-left-0">
                                <h3 class="mb-0"><a href="#" class="f-weight-500 text-primary">Flowers Structured Coat</a></h3>
                            </div>
                            <div class="card-body border border-top-0 border-right-0 border-left-0">
                                <div class="clearfix">
                                    <div class="float-left mr-2">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                            <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                            <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                            <li class="list-inline-item"><a href="#"><i class="icon-star"></i></a></li>
                                            <li class="list-inline-item"><a href="#"><i class="icon-star"></i></a></li>
                                        </ul>
                                    </div>
                                    <span>(3 customer reviews)</span>
                                </div>
                            </div>
                            <div class="card-body border brd-gray border-top-0 border-right-0 border-left-0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="float-left">
                                            <h4 class="lato-font body-color mb-0"><del>$398.00  </del></h4>
                                        </div>
                                        <div class="float-left ml-2">
                                            <h4 class="lato-font mb-0 text-danger">$285.00</h4>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body border brd-gray border-top-0 border-right-0 border-left-0">
                                <p class="mb-0" lang="ca">In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.</p>
                            </div>
                            <div class="card-body border brd-gray border-top-0 border-right-0 border-left-0">
                                <div class="d-inline-block">
                                    <p class="dark-color f-weight-600">Size: </p>
                                </div>
                                <div class="d-inline-block">
                                    <label class="chkbox ml-2">S 
                                        <input name="size" value="s" class="size" type="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="chkbox ml-2">LG 
                                        <input name="size" value="lg" class="size" type="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="chkbox ml-2">XL 
                                        <input name="size" value="xl" class="size" type="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                            </div>
                            <div class="card-body border brd-gray border-top-0 border-right-0 border-left-0">
                                <div class="d-inline-block mr-3">
                                    <p class="dark-color f-weight-600">Quantity: </p>
                                </div>
                                <div class="d-inline-block mr-3">
                                    <div class="form-group">
                                        <input type="number" class="form-control" value="1">
                                    </div>
                                </div>
                                <div class="d-inline-block mr-3">
                                    <a href="#" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="font-weight-bold dark-color mb-2">SKU: <span class="body-color font-weight-normal">587458-2017</span></li>
                                    <li class="font-weight-bold dark-color mb-2">Category: <span class="body-color font-weight-normal">Flower Structured Coat</span></li>
                                    <li class="font-weight-bold dark-color mb-2">Tags: <span class="body-color font-weight-normal"> Coat, Women</span></li>
                                    <li class="font-weight-bold dark-color mb-2">Share: 
                                        <a href="#" title="facebook" class="body-color mr-2"><i class="icon-social-facebook"></i></a>
                                        <a href="#" title="facebook" class="body-color mr-2"><i class="icon-social-twitter"></i></a>
                                        <a href="#" title="facebook" class="body-color mr-2"><i class="icon-social-dribbble"></i></a>
                                        <a href="#" title="facebook" class="body-color mr-2"><i class="icon-social-pinterest"></i></a>
                                        <a href="#" title="facebook" class="body-color mr-2"><i class="icon-social-linkedin"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>


        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-pills flex-column flex-sm-row justify-content-center ">
                                <li class="nav-item">
                                    <a class="nav-link body-color h6 mb-0 active" data-toggle="tab" href="#Description" > Description </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link body-color h6 mb-0" data-toggle="tab" href="#Additional"> Additional Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link body-color h6 mb-0" data-toggle="tab" href="#Reviews">Reviews (3)</a>
                                </li>
                            </ul> 
                            <div class="tab-content mt-5" id="myTabContent">
                                <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="pb-3" lang="ca">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec,.</p>
                                            <p lang="ca">In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum.</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="pb-3" lang="ca">Etiam sit ameta orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia.</p>
                                            <p lang="ca">Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Additional" role="tabpanel" aria-labelledby="Additional">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="pb-3" lang="ca">Etiam sit ameta orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia.</p>
                                            <p lang="ca">Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="pb-3" lang="ca">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec,.</p>
                                            <p lang="ca">In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="pb-3" lang="ca">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec,.</p>
                                            <p lang="ca">In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum.</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="pb-3" lang="ca">Etiam sit ameta orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia.</p>
                                            <p lang="ca">Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8 text-center pb-4">
                            <div class="heading">
                                <h3 class="lato-font font-weight-bold"><a href="#" class="theme-color">#releted</a>products</h3>
                                <div class="custom-devider large mx-auto"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="position-relative">
                                <img src="<?php echo base_url('dist/images/ecommerce-img1.jpg');?>" alt="" class="img-fluid">
                                <div class="caption-bg fade bg-transparent text-right">
                                    <div class="d-table w-100 h-100 ">
                                        <div class="d-table-cell align-bottom">
                                            <div class="mb-3">
                                                <a href="#" class="rounded-left bg-white px-3 py-2 text-primary"><i class="icon-heart"></i></a>
                                            </div>
                                            <div class="mb-4">
                                                <a href="#" class="rounded-left bg-white px-3 py-2 text-primary"><i class="icon-bag"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3">
                                <p class="mb-2"><a href="#" class="font-weight-bold text-primary">Flowers Structured Coat</a></p>
                                <div class="clearfix">
                                    <div class="d-inline-block"><del>$398.00  </del></div>
                                    <div class="d-inline-block text-danger pl-2">$285.00</div>
                                    <ul class="list-inline mb-0 mt-2">
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="icon-star"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="position-relative">
                                <img src="<?php echo base_url('dist/images/ecommerce-img2.jpg');?>" alt="" class="img-fluid">
                                <div class="caption-bg fade bg-transparent text-right">
                                    <div class="d-table w-100 h-100 ">
                                        <div class="d-table-cell align-bottom">
                                            <div class="mb-3">
                                                <a href="#" class="rounded-left bg-white px-3 py-2 text-primary"><i class="icon-heart"></i></a>
                                            </div>
                                            <div class="mb-4">
                                                <a href="#" class="rounded-left bg-white px-3 py-2 text-primary"><i class="icon-bag"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3">
                                <p class="mb-2"><a href="#" class="font-weight-bold text-primary">Flowers Structured Coat</a></p>
                                <div class="clearfix">
                                    <div class="d-inline-block"><del>$398.00  </del></div>
                                    <div class="d-inline-block text-danger pl-2">$285.00</div>
                                    <ul class="list-inline mb-0 mt-2">
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="icon-star"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="position-relative">
                                <img src="<?php echo base_url('dist/images/ecommerce-img3.jpg');?>" alt="" class="img-fluid">
                                <div class="caption-bg fade bg-transparent text-right">
                                    <div class="d-table w-100 h-100 ">
                                        <div class="d-table-cell align-bottom">
                                            <div class="mb-3">
                                                <a href="#" class="rounded-left bg-white px-3 py-2 text-primary"><i class="icon-heart"></i></a>
                                            </div>
                                            <div class="mb-4">
                                                <a href="#" class="rounded-left bg-white px-3 py-2 text-primary"><i class="icon-bag"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3">
                                <p class="mb-2"><a href="#" class="font-weight-bold text-primary">Flowers Structured Coat</a></p>
                                <div class="clearfix">
                                    <div class="d-inline-block"><del>$398.00  </del></div>
                                    <div class="d-inline-block text-danger pl-2">$285.00</div>
                                    <ul class="list-inline mb-0 mt-2">
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="icon-star"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="position-relative">
                                <img src="<?php echo base_url('dist/images/ecommerce-img4.jpg');?>" alt="" class="img-fluid">
                                <div class="caption-bg fade bg-transparent text-right">
                                    <div class="d-table w-100 h-100 ">
                                        <div class="d-table-cell align-bottom">
                                            <div class="mb-3">
                                                <a href="#" class="rounded-left bg-white px-3 py-2 text-primary"><i class="icon-heart"></i></a>
                                            </div>
                                            <div class="mb-4">
                                                <a href="#" class="rounded-left bg-white px-3 py-2 text-primary"><i class="icon-bag"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3">
                                <p class="mb-2"><a href="#" class="font-weight-bold text-primary">Flowers Structured Coat</a></p>
                                <div class="clearfix">
                                    <div class="d-inline-block"><del>$398.00  </del></div>
                                    <div class="d-inline-block text-danger pl-2">$285.00</div>
                                    <ul class="list-inline mb-0 mt-2">
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="icon-star"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="icon-star"></i></a></li>
                                    </ul>
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


