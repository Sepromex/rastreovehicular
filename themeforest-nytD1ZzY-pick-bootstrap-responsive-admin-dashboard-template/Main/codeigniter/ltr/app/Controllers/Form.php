<?php namespace App\Controllers;

class Form extends BaseController
{
	public function index()
	{
		return view('form/basic');
	}
	public function layout()
	{
		return view('form/layout');
	}
        public function validation()
	{
		return view('form/validation');
	}
        public function elements_switch()
	{
		return view('form/elements-switch');
	}
         public function elements_checkbox()
	{
		return view('form/elements-checkbox');
	}
        public function elements_radio()
	{
		return view('form/elements-radio');
	}
        public function elements_input()
	{
		return view('form/elements-input');
	}
         public function float_input()
	{
		return view('form/float-input');
	}
         public function wizard()
	{
		return view('form/wizard');
	}
         public function upload()
	{
		return view('form/upload');
	}
        public function mask()
	{
		return view('form/mask');
	}
        public function dropzone()
	{
		return view('form/dropzone');
	}
        public function icheck()
	{
		return view('form/icheck');
	}
        public function cropper()
	{
		return view('form/cropper');
	}
        public function htmleditor()
	{
		return view('form/htmleditor');
	}
        public function typehead()
	{
		return view('form/typehead');
	}
        public function xeditable()
	{
		return view('form/xeditable');
	}
        public function summernote()
	{
		return view('form/summernote');
	}

	//--------------------------------------------------------------------

}
