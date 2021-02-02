<?php namespace App\Controllers;

class Icon extends BaseController
{
	public function index()
	{
		return view('icon/materialdesign');
	}
	public function font_awesome()
	{
		return view('icon/font-awesome');
	}
        public function themify()
	{
		return view('icon/themify');
	}
        public function weather()
	{
		return view('icon/weather');
	}
         public function simple_line()
	{
		return view('icon/simple-line');
	}
        public function flag()
	{
		return view('icon/flag');
	}
        public function ionicons()
	{
		return view('icon/ionicons');
	}
        public function icofont()
	{
		return view('icon/icofont');
	}
        public function linearicons()
	{
		return view('icon/linearicons');
	}
        public function crypto()
	{
		return view('icon/crypto');
	}

}
