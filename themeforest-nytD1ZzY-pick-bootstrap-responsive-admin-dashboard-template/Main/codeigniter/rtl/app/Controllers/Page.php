<?php

namespace App\Controllers;

class Page extends BaseController {

    public function index() {
        return view('page/lockscreen');
    }

    public function login() {
        return view('page/login');
    }

    public function register() {
        return view('page/register');
    }

    public function notfound() {
        return view('page/404');
    }

    public function notfound_menu() {
        return view('page/404-menu');
    }

    public function blank() {
        return view('page/blank');
    }

    public function gallery() {
        return view('page/gallery');
    }

    public function pricing() {
        return view('page/pricing');
    }

    public function contact_us() {
        return view('page/contact-us');
    }

    public function user_profile() {
        return view('page/user-profile');
    }

}
