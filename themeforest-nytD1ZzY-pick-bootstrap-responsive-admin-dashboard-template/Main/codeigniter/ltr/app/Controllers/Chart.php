<?php namespace App\Controllers;

class Chart extends BaseController
{
	public function index()
	{
		return view('chart/morris');
	}
	public function chartist()
	{
		return view('chart/chartist');
	}
        public function echart()
	{
		return view('chart/echart');
	}
        public function flot()
	{
		return view('chart/flot');
	}
         public function knob()
	{
		return view('chart/knob');
	}
        public function chartjs_bar()
	{
		return view('chart/chartjs-bar');
	}
        public function chartjs_line()
	{
		return view('chart/chartjs-line');
	}
         public function chartjs_area()
	{
		return view('chart/chartjs-area');
	}
         public function chartjs_other()
	{
		return view('chart/chartjs-other');
	}
         public function chartjs_linear()
	{
		return view('chart/chartjs-linear');
	}
        public function sparkline()
	{
		return view('chart/sparkline');
	}
        public function peity()
	{
		return view('chart/peity');
	}
        public function google()
	{
		return view('chart/google');
	}
        public function apex()
	{
		return view('chart/apex');
	}
        public function c3()
	{
		return view('chart/c3');
	}

	//--------------------------------------------------------------------

}
