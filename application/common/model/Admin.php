<?php

namespace app\common\model;

use think\Model;

class Admin extends Model
{
	public function find($where = [], $field = '')
	{
		return $this->field($field)->where($where)->select();
	}
}