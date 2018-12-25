<?php
/**
 * Created by PhpStorm.
 * User: voowo
 * Date: 2018/11/25
 * Time: 14:06
 */

namespace app\admin\controller;

use app\common\controller\BaseController;

class IndexController extends BaseController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		return view();
	}

}