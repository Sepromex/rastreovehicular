<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('dashboard/home');
	}
	public function account()
	{
		return view('dashboard/account');
	}
        public function analytic()
	{
		return view('dashboard/analytic');
	}
        public function covid()
	{
		return view('dashboard/covid');
	}
        public function crypto()
	{
		return view('dashboard/crypto');
	}
        public function ecommerce()
	{
		return view('dashboard/ecommerce');
	}

	//--------------------------------------------------------------------

}
