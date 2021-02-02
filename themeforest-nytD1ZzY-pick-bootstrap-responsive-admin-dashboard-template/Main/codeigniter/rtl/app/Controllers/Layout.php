<?php

namespace App\Controllers;

class Layout extends BaseController {

    public function index() {
        $params = $this->getQueryStringParams();
        $data['layout'] = !empty($params['layout']) ? $params['layout'] : '';
        $data['color'] = !empty($params['color']) ? $params['color'] : '';
        return view('layout',$data);
    }

}
