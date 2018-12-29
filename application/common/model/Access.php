<?php

namespace app\common\model;

use think\Model;

class Access extends Model
{
	/**
	 * 权限列表
	 * @return array|null|\PDOStatement|string|\think\Collection
	 */
	public function accessList()
	{
		try {
			return $this->where('status', 1)->select();
		} catch (\Exception $e) {
			return null;
		}
	}
}