<?php

namespace App\Controllers;

class Ui extends BaseController {

    public function index() {
        return view('ui/alert');
    }

    public function badges() {
        return view('ui/badges');
    }

    public function buttons() {
        return view('ui/buttons');
    }

    public function cards() {
        return view('ui/cards');
    }

    public function carousel() {
        return view('ui/carousel');
    }

    public function collapse() {
        return view('ui/collapse');
    }

    public function dropdowns() {
        return view('ui/dropdowns');
    }

    public function jumbotron() {
        return view('ui/jumbotron');
    }

    public function modals() {
        return view('ui/modals');
    }

    public function pagination() {
        return view('ui/pagination');
    }

    public function popoverandtooltip() {
        return view('ui/popoverandtooltip');
    }

    public function progress() {
        return view('ui/progress');
    }

    public function scrollspy() {
        return view('ui/scrollspy');
    }

    public function select2() {
        return view('ui/select2');
    }

    public function sweetalert() {
        return view('ui/sweetalert');
    }

    public function timeline() {
        return view('ui/timeline');
    }

    public function toastr() {
        return view('ui/toastr');
    }

}
