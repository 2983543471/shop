<?php

namespace app\index\controller;

use app\common\controller\BaseController;
use app\validate\User;

class IndexController extends BaseController
{
	public function index()
	{
		return view();
	}

}