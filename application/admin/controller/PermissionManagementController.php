<?php

namespace app\admin\controller;

use app\common\controller\BaseController;
use app\common\model\Access;

class PermissionManagementController extends BaseController
{
	protected $access;

	public function __construct(Access $access)
	{
		parent::__construct();
		$this->access = $access;
	}

	/**
	 * 权限列表
	 * @return null|\think\response\View
	 */
	public function index()
	{
		try {
			$res = $this->access->where('status', 1)->select();
			return view('permission_management/index', ['list' => $res]);
		} catch (\Exception $e) {
			return null;
		}
	}

	/**
	 * 添加权限页面
	 * @return \think\response\View
	 */
	public function addPage()
	{
		return view('permission_management/add_page');
	}

	/**
	 * 添加权限接口
	 * @return \think\response\Json
	 */
	public function addPermission()
	{
		$title = $this->request->post('title', '');
		$url = $this->request->post('url', '');
		if (!$title || !$url) return json(['status' => -1, 'message' => '请将信息填写完整']);
		$data = [
			'title'       => $title,
			'url'         => $url,
			'create_time' => time()
		];
		$res = $this->access->insert($data);
		if (!$res) return json(['status' => -1, 'message' => '添加权限失败']);
		return json(['status' => 1, 'message' => '添加权限成功']);
	}
}