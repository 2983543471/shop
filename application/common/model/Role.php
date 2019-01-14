<?php

namespace app\common\model;

use think\Model;

class Role extends Model
{

	public function getNameStatus($val)
	{
		$list = $this->role_list();
		foreach ($list as $k => $v) {
			$status = [$v.id => $v.name];
		}
		return $status[$val];
	}

	/**
	 * 角色列表
	 * @return array|null|\PDOStatement|string|\think\Collection
	 */
	public function role_list()
	{
		try {
			return $this->where('status', 1)->select();
		} catch (\Exception $e) {
			return null;
		}
	}


}