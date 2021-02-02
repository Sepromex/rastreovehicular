<?php

namespace App\Controllers;

class Extra extends BaseController {

    public function index() {
        return view('extra/map-google');
    }

    public function map_vector() {
        return view('extra/map-vector');
    }

    public function blog_list() {
        return view('extra/blog-list');
    }

    public function blog_single() {
        return view('extra/blog-single');
    }

    public function ecommerce_product_list() {
        return view('extra/ecommerce-product-list');
    }

    public function ecommerce_product_detail() {
        return view('extra/ecommerce-product-detail');
    }

    public function ecommerce_cart() {
        return view('extra/ecommerce-cart');
    }

    public function ecommerce_checkout() {
        return view('extra/ecommerce-checkout');
    }

    public function ecommerce_orders() {
        return view('extra/ecommerce-orders');
    }

    public function ecommerce_order_view() {
        return view('extra/ecommerce-order-view');
    }

}
