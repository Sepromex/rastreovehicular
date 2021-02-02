<?php namespace App\Controllers;

class Table extends BaseController
{
	public function index()
	{
		return view('table/basic');
	}
	public function layout()
	{
		return view('table/layout');
	}
        public function datatable()
	{
		return view('table/datatable');
	}
        public function footable()
	{
		return view('table/footable');
	}
         public function jsgrid()
	{
		return view('table/jsgrid');
	}
        public function responsive()
	{
		return view('table/responsive');
	}
        public function editable()
	{
		return view('table/editable');
	}

}
