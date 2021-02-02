<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/account', 'Home::account');
$routes->get('/analytic', 'Home::analytic');
$routes->get('/covid', 'Home::covid');
$routes->get('/crypto', 'Home::crypto');
$routes->get('/ecommerce', 'Home::ecommerce');
$routes->get('/layout', 'Layout::index');
$routes->get('/layout', 'Layout::index');

$routes->get('/app/calendar', 'App::index');
$routes->get('/app/chat', 'App::chat');
$routes->get('/app/todo', 'App::todo');
$routes->get('/app/mail', 'App::mail');
$routes->get('/app/filemanager', 'App::filemanager');
$routes->get('/app/contactlist', 'App::contactlist');
$routes->get('/app/taskboard', 'App::taskboard');
$routes->get('/app/notes', 'App::notes');
$routes->get('/app/invoicelist', 'App::invoicelist');


$routes->get('/chart/morris', 'Chart::index');
$routes->get('/chart/chartist', 'Chart::chartist');
$routes->get('/chart/echart', 'Chart::echart');
$routes->get('/chart/flot', 'Chart::flot');
$routes->get('/chart/knob', 'Chart::knob');
$routes->get('/chart/chartjs-bar', 'Chart::chartjs_bar');
$routes->get('/chart/chartjs-line', 'Chart::chartjs_line');
$routes->get('/chart/chartjs-area', 'Chart::chartjs_area');
$routes->get('/chart/chartjs-other', 'Chart::chartjs_other');
$routes->get('/chart/chartjs-linear', 'Chart::chartjs_linear');
$routes->get('/chart/sparkline', 'Chart::sparkline');
$routes->get('/chart/peity', 'Chart::peity');
$routes->get('/chart/google', 'Chart::google');
$routes->get('/chart/apex', 'Chart::apex');
$routes->get('/chart/c3', 'Chart::c3');

$routes->get('/form/basic', 'Form::index');
$routes->get('/form/layout', 'Form::layout');
$routes->get('/form/validation', 'Form::validation');
$routes->get('/form/elements-switch', 'Form::elements_switch');
$routes->get('/form/elements-checkbox', 'Form::elements_checkbox');
$routes->get('/form/elements-radio', 'Form::elements_radio');
$routes->get('/form/elements-input', 'Form::elements_input');
$routes->get('/form/float-input', 'Form::float_input');
$routes->get('/form/wizard', 'Form::wizard');
$routes->get('/form/upload', 'Form::upload');
$routes->get('/form/mask', 'Form::mask');
$routes->get('/form/dropzone', 'Form::dropzone');
$routes->get('/form/icheck', 'Form::icheck');
$routes->get('/form/cropper', 'Form::cropper');
$routes->get('/form/htmleditor', 'Form::htmleditor');
$routes->get('/form/typehead', 'Form::typehead');
$routes->get('/form/xeditable', 'Form::xeditable');
$routes->get('/form/summernote', 'Form::summernote');

$routes->get('/table/basic', 'Table::index');
$routes->get('/table/layout', 'Table::layout');
$routes->get('/table/datatable', 'Table::datatable');
$routes->get('/table/footable', 'Table::footable');
$routes->get('/table/jsgrid', 'Table::jsgrid');
$routes->get('/table/responsive', 'Table::responsive');
$routes->get('/table/editable', 'Table::editable');

$routes->get('/ui/alert', 'Ui::index');
$routes->get('/ui/badges', 'Ui::badges');
$routes->get('/ui/buttons', 'Ui::buttons');
$routes->get('/ui/cards', 'Ui::cards');
$routes->get('/ui/carousel', 'Ui::carousel');
$routes->get('/ui/collapse', 'Ui::collapse');
$routes->get('/ui/dropdowns', 'Ui::dropdowns');
$routes->get('/ui/jumbotron', 'Ui::jumbotron');
$routes->get('/ui/modals', 'Ui::modals');
$routes->get('/ui/pagination', 'Ui::pagination');
$routes->get('/ui/popoverandtooltip', 'Ui::popoverandtooltip');
$routes->get('/ui/progress', 'Ui::progress');
$routes->get('/ui/scrollspy', 'Ui::scrollspy');
$routes->get('/ui/select2', 'Ui::select2');
$routes->get('/ui/sweetalert', 'Ui::sweetalert');
$routes->get('/ui/timeline', 'Ui::timeline');
$routes->get('/ui/toastr', 'Ui::toastr');

$routes->get('/icon/materialdesign', 'Icon::index');
$routes->get('/icon/font-awesome', 'Icon::font_awesome');
$routes->get('/icon/themify', 'Icon::themify');
$routes->get('/icon/weather', 'Icon::weather');
$routes->get('/icon/simple-line', 'Icon::simple_line');
$routes->get('/icon/flag', 'Icon::flag');
$routes->get('/icon/ionicons', 'Icon::ionicons');
$routes->get('/icon/icofont', 'Icon::icofont');
$routes->get('/icon/linearicons', 'Icon::linearicons');
$routes->get('/icon/crypto', 'Icon::crypto');

$routes->get('/page/lockscreen', 'Page::index');
$routes->get('/page/login', 'Page::login');
$routes->get('/page/register', 'Page::register');
$routes->get('/page/404', 'Page::notfound');
$routes->get('/page/404-menu', 'Page::notfound_menu');
$routes->get('/page/blank', 'Page::blank');
$routes->get('/page/gallery', 'Page::gallery');
$routes->get('/page/pricing', 'Page::pricing');
$routes->get('/page/contact-us', 'Page::contact_us');
$routes->get('/page/user-profile', 'Page::user_profile');

$routes->get('/extra/map-google', 'Extra::index');
$routes->get('/extra/map-vector', 'Extra::map_vector');
$routes->get('/extra/blog-list', 'Extra::blog_list');
$routes->get('/extra/blog-single', 'Extra::blog_single');
$routes->get('/extra/ecommerce-product-list', 'Extra::ecommerce_product_list');
$routes->get('/extra/ecommerce-product-detail', 'Extra::ecommerce_product_detail');
$routes->get('/extra/ecommerce-cart', 'Extra::ecommerce_cart');
$routes->get('/extra/ecommerce-checkout', 'Extra::ecommerce_checkout');
$routes->get('/extra/ecommerce-orders', 'Extra::ecommerce_orders');
$routes->get('/extra/ecommerce-order-view', 'Extra::ecommerce_order_view');
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
