<?php

namespace app\facade;

use think\Facade;

class IndexController extends Facade
{
	protected static function getFacadeClass()
	{
		return 'app\index\controller\FirstController';
	}

}