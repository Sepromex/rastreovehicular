<!-- START: Main Menu-->
<div class="sidebar">
    <div class="site-width">
        <!-- START: Menu-->
        <ul id="side-menu" class="sidebar-menu">
            <li class="dropdown"><a href="#"><i class="icon-home mr-1"></i> Dashboard</a>                  
                <ul>
                    <li><a href="<?php echo site_url('/');?>"><i class="icon-rocket"></i> Dashboard</a></li>
                    <li><a href="<?php echo site_url('/account');?>"><i class="icon-layers"></i> Account</a></li>
                    <li><a href="<?php echo site_url('/analytic');?>"><i class="icon-grid"></i> Analytic</a></li>
                    <li><a href="<?php echo site_url('/covid');?>"><i class="icon-earphones"></i> COVID</a></li>
                    <li><a href="<?php echo site_url('/crypto');?>"><i class="icon-support"></i> Crypto</a></li>
                    <li><a href="<?php echo site_url('/ecommerce');?>"><i class="icon-briefcase"></i> Ecommerce</a></li>
                </ul>
            </li>
            <li class="dropdown"><a href="#"><i class="icon-organization mr-1"></i> Layout</a>
                <ul>
                    <li class="dropdown"><a href="#"><i class="icon-options"></i>Horizontal</a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('/layout?layout=horizontal-menu');?>"><i class="icon-energy"></i> Light</a></li>
                            <li><a href="<?php echo site_url('/layout?layout=horizontal-menu&color=semi-dark');?>"><i class="icon-disc"></i> Semi Dark</a></li>
                            <li><a href="<?php echo site_url('/layout?layout=horizontal-menu&color=dark');?>"><i class="icon-frame"></i> Dark</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><i class="icon-options-vertical"></i>Vertical</a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('/layout?layout=vertical-menu');?>"><i class="icon-energy"></i> Light</a></li>
                            <li><a href="<?php echo site_url('/layout?layout=vertical-menu&color=semi-dark');?>"><i class="icon-disc"></i> Semi Dark</a></li>
                            <li><a href="<?php echo site_url('/layout?layout=vertical-menu&color=dark');?>"><i class="icon-frame"></i> Dark</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><i class="icon-grid"></i>Compact Menu</a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('/layout?layout=compact-menu');?>"><i class="icon-energy"></i> Light</a></li>
                            <li><a href="<?php echo site_url('/layout?layout=compact-menu&color=semi-dark');?>"><i class="icon-disc"></i> Semi Dark</a></li>
                            <li><a href="<?php echo site_url('/layout?layout=compact-menu&color=dark');?>"><i class="icon-frame"></i> Dark</a></li>
                        </ul>
                    </li>

                </ul>
            </li>
            <li class="dropdown"><a href="#"><i class="icon-layers mr-1"></i> Web Apps</a>                  
                <ul>
                    <li><a href="<?php echo site_url('/app/calendar');?>"><i class="icon-calendar"></i> Calendar</a></li>
                    <li><a href="<?php echo site_url('/app/chat');?>"><i class="icon-speech"></i> Chats</a></li>
                    <li><a href="<?php echo site_url('/app/todo');?>"><i class="icon-support"></i> Todo</a></li> 
                    <li><a href="<?php echo site_url('/app/mail');?>"><i class="icon-envelope"></i>Mailapp</a></li>
                    <li><a href="<?php echo site_url('/app/filemanager');?>"><i class="icon-folder"></i> File Manager</a></li>
                    <li><a href="<?php echo site_url('/app/contactlist');?>"><i class="icon-people"></i> Contact List</a></li>
                    <li><a href="<?php echo site_url('/app/taskboard');?>"><i class="icon-event"></i> Task Board</a></li>
                    <li><a href="<?php echo site_url('/app/notes');?>"><i class="icon-tag"></i> Notes</a></li> 
                    <li><a href="<?php echo site_url('/app/invoicelist');?>"><i class="icon-book-open"></i> Invoices</a></li>
                </ul>                   
            </li>

            <li class="dropdown"><a href="#"><i class="icon-cursor mr-1"></i> Elements</a>                 
                <ul>
                    <li class="dropdown"><a href="#"><i class="icon-chart"></i>Charts</a>                                
                        <ul class="sub-menu">                                    
                            <li><a href="<?php echo site_url('/chart/morris');?>"><i class="icon-energy"></i> Morris Chart</a></li>
                            <li><a href="<?php echo site_url('/chart/chartist');?>"><i class="icon-disc"></i> Chartist js</a></li>
                            <li><a href="<?php echo site_url('/chart/echart');?>"><i class="icon-frame"></i> eCharts</a></li>
                            <li><a href="<?php echo site_url('/chart/flot');?>"><i class="icon-fire"></i> Flot Chart</a></li>
                            <li><a href="<?php echo site_url('/chart/knob');?>"><i class="icon-shuffle"></i> Knob Chart</a></li>
                            <li class="dropdown"><a href="#" class="d-flex align-items-center"><i class="icon-control-pause"></i> Charts js</a>                                          
                                <ul class="sub-menu">
                                    <li><a href="<?php echo site_url('/chart/chartjs-bar');?>"><i class="icon-energy"></i> Bar charts</a></li>
                                    <li><a href="<?php echo site_url('/chart/chartjs-line');?>"><i class="icon-disc"></i> Line charts</a></li>
                                    <li><a href="<?php echo site_url('/chart/chartjs-area');?>"><i class="icon-frame"></i> Area charts</a></li>
                                    <li><a href="<?php echo site_url('/chart/chartjs-other');?>"><i class="icon-fire"></i> Doughnut, Pie, Polar charts</a></li>
                                    <li><a href="<?php echo site_url('/chart/chartjs-linear');?>"><i class="icon-shuffle"></i> Linear scale</a></li>                                                                        
                                </ul>                                           
                            </li>
                            <li><a href="<?php echo site_url('/chart/sparkline');?>"><i class="icon-graph"></i> Sparkline Chart</a></li>                            
                            <li><a href="<?php echo site_url('/chart/peity');?>"><i class="icon-pie-chart"></i> Peity Chart</a></li>   
                            <li><a href="<?php echo site_url('/chart/google');?>"><i class="icon-drawer"></i> Google Charts</a></li>
                            <li><a href="<?php echo site_url('/chart/apex');?>"><i class="icon-magnet"></i> Apex Charts</a></li>
                            <li><a href="<?php echo site_url('/chart/c3');?>"><i class="icon-hourglass"></i> C3 Charts</a></li>
                        </ul>                               
                    </li> 
                    <li class="dropdown"><a href="#"><i class="icon-film"></i>Form</a>                              
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('/form/basic');?>"><i class="icon-disc"></i> Basic Form</a></li>
                            <li><a href="<?php echo site_url('/form/layout');?>"><i class="icon-cursor-move"></i> Form Layout</a></li>
                            <li><a href="<?php echo site_url('/form/validation');?>"><i class="icon-star"></i> Form Validation</a></li>
                            <li class="dropdown"><a href="#" class="d-flex align-items-center"><i class="icon-film"></i> Form Elements</a>                                          
                                <ul class="sub-menu">
                                    <li><a href="<?php echo site_url('/form/elements-switch');?>"><i class="icon-energy"></i> Switch</a></li>
                                    <li><a href="<?php echo site_url('/form/elements-checkbox');?>"><i class="icon-disc"></i> Checkbox</a></li>
                                    <li><a href="<?php echo site_url('/form/elements-radio');?>"><i class="icon-frame"></i> Radio</a></li>
                                    <li><a href="<?php echo site_url('/form/elements-input');?>"><i class="icon-fire"></i> Input</a></li>                                       
                                </ul>                                           
                            </li>
                            <li><a href="<?php echo site_url('/form/float-input');?>"><i class="icon-symbol-male"></i> Float Input</a></li>
                            <li><a href="<?php echo site_url('/form/wizard');?>"><i class="icon-loop"></i> Form Wizards</a></li>
                            <li><a href="<?php echo site_url('/form/upload');?>"><i class="icon-pin"></i> Form Uploads</a></li>
                            <li><a href="<?php echo site_url('/form/mask');?>"><i class="icon-check"></i> Form Mask</a></li>                            
                            <li><a href="<?php echo site_url('/form/dropzone');?>"><i class="icon-present"></i> Form Dropzone</a></li>
                            <li><a href="<?php echo site_url('/form/icheck');?>"><i class="icon-briefcase"></i> Icheck Controls</a></li>
                            <li><a href="<?php echo site_url('/form/cropper');?>"><i class="icon-hourglass"></i> Image Cropper</a></li>
                            <li><a href="<?php echo site_url('/form/htmleditor');?>"><i class="icon-graduation"></i> HTML5 Editor</a></li>
                            <li><a href="<?php echo site_url('/form/typehead');?>"><i class="icon-puzzle"></i> Form Typehead</a></li>                            
                            <li><a href="<?php echo site_url('/form/xeditable');?>"><i class="icon-cloud-upload"></i> Xeditable</a></li>
                            <li><a href="<?php echo site_url('/form/summernote');?>"><i class="icon-ghost"></i> Summernote</a></li>
                        </ul>  
                    </li>
                    <li class="dropdown"><a href="#"><i class="icon-menu"></i>Tables</a>                               
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('/table/basic');?>"><i class="icon-grid"></i> Table Basic</a></li>
                            <li><a href="<?php echo site_url('/table/layout');?>"><i class="icon-layers"></i> Table Layout</a></li>
                            <li><a href="<?php echo site_url('/table/datatable');?>"><i class="icon-docs"></i> Datatable</a></li>
                            <li><a href="<?php echo site_url('/table/footable');?>"><i class="icon-wallet"></i> Footable</a></li>
                            <li><a href="<?php echo site_url('/table/jsgrid');?>"><i class="icon-folder"></i> Jsgrid</a></li>
                            <li><a href="<?php echo site_url('/table/responsive');?>"><i class="icon-control-pause"></i> Table Responsive</a></li>                            
                            <li><a href="<?php echo site_url('/table/editable');?>"><i class="icon-pencil"></i> Editable Table</a></li>
                        </ul>   
                    </li>
                </ul>                   
            </li>
            <li class="dropdown"><a href="#"><i class="icon-magnet mr-1"></i> UI Component</a>                  
                <ul>
                    <li class="dropdown"><a href="#"><i class="icon-screen-desktop"></i>UI Elements</a>                              
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('/ui/alert');?>"><i class="icon-bell"></i> Alerts</a></li>
                            <li><a href="<?php echo site_url('/ui/badges');?>"><i class="icon-badge"></i> Badges</a></li>
                            <li><a href="<?php echo site_url('/ui/buttons');?>"><i class="icon-control-play"></i> Buttons</a></li>
                            <li><a href="<?php echo site_url('/ui/cards');?>"><i class="icon-layers"></i> Cards</a></li>
                            <li><a href="<?php echo site_url('/ui/carousel');?>"><i class="icon-picture"></i> Carousel</a></li>                           
                            <li><a href="<?php echo site_url('/ui/collapse');?>"><i class="icon-arrow-up"></i> Collapse</a></li>
                            <li><a href="<?php echo site_url('/ui/dropdowns');?>"><i class="icon-arrow-down"></i> Dropdowns</a></li>                          
                            <li><a href="<?php echo site_url('/ui/jumbotron');?>"><i class="icon-screen-desktop"></i> Jumbotron</a></li>
                            <li><a href="<?php echo site_url('/ui/modals');?>"><i class="icon-frame"></i> Modal</a></li> 
                            <li><a href="<?php echo site_url('/ui/pagination');?>"><i class="icon-docs"></i> Pagination</a></li>  
                            <li><a href="<?php echo site_url('/ui/popoverandtooltip');?>"><i class="icon-pin"></i> Popover &amp; Tooltip</a></li>
                            <li><a href="<?php echo site_url('/ui/progress');?>"><i class="icon-graph"></i> Progress</a></li>
                            <li><a href="<?php echo site_url('/ui/scrollspy');?>"><i class="icon-shuffle"></i> Scrollspy</a></li>
                            <li><a href="<?php echo site_url('/ui/select2');?>"><i class="icon-wallet"></i> Select2</a></li>
                            <li><a href="<?php echo site_url('/ui/sweetalert');?>"><i class="icon-fire"></i> Sweet Alert</a></li>
                            <li><a href="<?php echo site_url('/ui/timeline');?>"><i class="icon-graduation"></i> Timeline</a></li>
                            <li><a href="<?php echo site_url('/ui/toastr');?>"><i class="icon-layers"></i> Toastr</a></li>
                        </ul>                              
                    </li>
                    <li class="dropdown"><a href="#"><i class="icon-badge"></i>Icons</a>                            
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('/icon/materialdesign');?>"><i class="icon-star"></i> Material Icon</a></li>
                            <li><a href="<?php echo site_url('/icon/font-awesome');?>"><i class="icon-screen-tablet"></i> Font-awesome</a></li>
                            <li><a href="<?php echo site_url('/icon/themify');?>"><i class="icon-plane"></i> Themify Icon</a></li>
                            <li><a href="<?php echo site_url('/icon/weather');?>"><i class="icon-drawer"></i> Weather Icon</a></li>
                            <li><a href="<?php echo site_url('/icon/simple-line');?>"><i class="icon-map"></i> Simple Line Icon</a></li>
                            <li><a href="<?php echo site_url('/icon/flag');?>"><i class="icon-flag"></i> Flag Icon</a></li>
                            <li><a href="<?php echo site_url('/icon/ionicons');?>"><i class="icon-rocket"></i> Ionicons Icon</a></li>
                            <li><a href="<?php echo site_url('/icon/icofont');?>"><i class="icon-fire"></i> Icofont Icon</a></li>    
                            <li><a href="<?php echo site_url('/icon/linearicons');?>"><i class="icon-list"></i> Linear</a></li>
                            <li><a href="<?php echo site_url('/icon/crypto');?>"><i class="icon-diamond"></i> Crypto</a></li>
                        </ul>                                 
                    </li>
                </ul>                 
            </li>
            <li class="dropdown"><a href="#"><i class="icon-doc mr-1"></i> Pages</a>                  
                <ul>
                    <li class="dropdown"><a href="#"><i class="icon-book-open"></i>Other Pages</a>                               
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('/page/lockscreen');?>"><i class="icon-lock"></i> Lockscreen</a></li>
                            <li><a href="<?php echo site_url('/page/login');?>"><i class="icon-login"></i> login</a></li>
                            <li><a href="<?php echo site_url('/page/register');?>"><i class="icon-direction"></i> Register</a></li>
                            <li><a href="<?php echo site_url('/page/404');?>"><i class="icon-crop"></i> 404 Page</a></li>
                            <li><a href="<?php echo site_url('/page/404-menu');?>"><i class="icon-layers"></i> 404 Page With Menu</a></li>
                            <li><a href="<?php echo site_url('/page/blank');?>"><i class="icon-frame"></i> Blank Page</a></li>
                            <li><a href="<?php echo site_url('/page/gallery');?>"><i class="icon-layers"></i> Gallery</a></li>
                            <li><a href="<?php echo site_url('/page/pricing');?>"><i class="icon-wallet"></i> Pricing</a></li>
                            <li><a href="<?php echo site_url('/page/contact-us');?>"><i class="icon-wrench"></i> Contact us</a></li>
                        </ul>                               
                    </li>
                    <li><a href="<?php echo site_url('/page/user-profile');?>"><i class="icon-user"></i>Profile Pages</a></li>
                </ul>                   
            </li>
            <li class="dropdown"><a href="#"><i class="icon-support mr-1"></i> Extras</a>                   
                <ul>
                    <li class="dropdown"><a href="#"><i class="icon-map"></i>Map</a>                               
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('/extra/map-google');?>"><i class="icon-map"></i> Google Map</a></li>
                            <li><a href="<?php echo site_url('/extra/map-vector');?>"><i class="icon-vector"></i> Vector Map</a></li>

                        </ul>                               
                    </li>
                    <li class="dropdown"><a href="#"><i class="icon-pencil"></i>Blog</a>                               
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('/extra/blog-list');?>"><i class="icon-plus"></i> Blog List</a></li>
                            <li><a href="<?php echo site_url('/extra/blog-single');?>"><i class="icon-tag"></i> Blog Post</a></li>                            
                        </ul>                               
                    </li>  
                    <li class="dropdown"><a href="#"><i class="icon-bag"></i>Ecommerce</a>                                 
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('/extra/ecommerce-product-list');?>"><i class="icon-grid"></i> Products List</a></li>
                            <li><a href="<?php echo site_url('/extra/ecommerce-product-detail');?>"><i class="icon-plus"></i> Product Detail</a></li>
                            <li><a href="<?php echo site_url('/extra/ecommerce-cart');?>"><i class="icon-badge"></i> Cart</a></li>
                            <li><a href="<?php echo site_url('/extra/ecommerce-checkout');?>"><i class="icon-plus"></i> Checkout</a></li>
                            <li><a href="<?php echo site_url('/extra/ecommerce-orders');?>"><i class="icon-basket"></i> Orders</a></li>
                            <li><a href="<?php echo site_url('/extra/ecommerce-order-view');?>"><i class="icon-equalizer"></i> Order View</a></li>                           

                        </ul>                               
                    </li>
                </ul>                    
            </li>
        </ul>
        <!-- END: Menu-->
        <ol class="breadcrumb bg-transparent align-self-center m-0 p-0 ml-auto">
            <li class="breadcrumb-item"><a href="#">Application</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>
<!-- END: Main Menu-->