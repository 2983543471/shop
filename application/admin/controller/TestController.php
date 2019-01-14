<?php

namespace app\admin\controller;

use app\common\controller\BaseController;

class TestController extends BaseController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function first()
	{
		return view('test/test1');
	}

	public function second()
	{
		return view('test/test2');
	}

	public function third()
	{
		return view('test/test3');
	}

	public function fourth()
	{
		return view('test/test4');
	}

	public function fifth()
	{
		return view('test/test5');
	}
}