<?php
/**
 * Created by PhpStorm.
 * User: voowo
 * Date: 2018/11/25
 * Time: 14:09
 */

namespace app\common\controller;

use think\Controller;

class BaseController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!session('username')) $this->error('请登录后操作', '/admin/login/second');
	}
}