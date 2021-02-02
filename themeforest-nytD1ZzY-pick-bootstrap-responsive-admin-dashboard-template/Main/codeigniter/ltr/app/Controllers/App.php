<?php namespace App\Controllers;

class App extends BaseController
{
	public function index()
	{
		return view('app/calendar');
	}
	public function chat()
	{
		return view('app/chat');
	}
        public function todo()
	{
		return view('app/todo');
	}
        public function mail()
	{
		return view('app/mail');
	}
        public function filemanager()
	{
		return view('app/filemanager');
	}
        public function contactlist()
	{
		return view('app/contactlist');
	}
         public function taskboard()
	{
		return view('app/taskboard');
	}
         public function notes()
	{
		return view('app/notes');
	}
         public function invoicelist()
	{
		return view('app/invoicelist');
	}

	//--------------------------------------------------------------------

}
