<?php

namespace app\index\controller;

use app\common\controller\BaseController;
use app\validate\User;

class IndexController extends BaseController
{
	public function index()
	{
		$username = session('username');
		$password = session('password');


		dump($username, $password);
		return view();
	}
}