<?php

namespace app\admin\controller;

use app\common\controller\BaseController;
use app\common\model\Admin;
use app\common\model\AdminRole;
use app\common\model\Role;

class AdminManagementController extends BaseController
{
	protected $admin;
	protected $role;
	protected $admin_role;

	public function __construct(Admin $admin, Role $role, AdminRole $admin_role)
	{
		parent::__construct();
		$this->admin = $admin;
		$this->role = $role;
		$this->admin_role = $admin_role;
	}

	/**
	 * 管理员列表
	 * @return null|\think\response\View
	 */
	public function index()
	{
		try {
			$res = $this->admin->where('status', 1)->field('id,username,is_admin,update_time,create_time')->select();
			return view('admin_management/index', ['list' => $res]);
		} catch (\Exception $e) {
			return null;
		}
	}

	/**
	 * 添加账号和修改会员页面
	 * @return \think\response\View
	 */
	public function addPage()
	{
		try {
			$id = $this->request->param('id', '');
			$res = $this->admin->where('id', $id)->find();
			$role_list = $this->role->role_list();
			return view('admin_management/add_page', [
				'list'      => $res,
				'role_list' => $role_list
			]);
		} catch (\Exception $e) {
			return null;
		}
	}

	/**
	 * 添加账号接口
	 * @return \think\response\Json
	 */
	public function addAdmin()
	{
		try {
			$username = $this->request->post('username', '');
			$password = $this->request->post('password', '');
			$character = $this->request->post('character', '');
			if (!$username || !$password || !$character) {
				return json(['status' => -1, 'message' => '请将信息填写完整']);
			}
			$validate_data = [
				'username'  => $username,
				'password'  => $password,
				'character' => $character
			];
			$validate_res = $this->validate($validate_data, 'app\validate\User.addAdmin');
			if ($validate_res !== true) {
				return json(['status' => -1, 'message' => $validate_res]);
			}
			$user_string = config('login.user_string');
			$admin_data = [
				'username'    => $username,
				'password'    => md5($password . $user_string),
				'user_string' => $user_string,
				'create_time' => time()
			];
			$admin_res = $this->admin->insert($admin_data);
			if (!$admin_res) {
				return json(['status' => -1, 'message' => '添加失败']);
			}
			return json(['status' => 1, 'message' => '添加成功']);
		} catch (\Exception $e) {
			return null;
		}
	}

	public function editAdmin()
	{
		try {
			$admin_id = $this->request->post('username', '', 'intval');
			$role_id = $this->request->post('character', '', 'intval');
			if (!$admin_id || !$role_id) return json(['status' => 0, 'message' => '请将信息填写完整']);
			$data = [
				'admin_id'    => $admin_id,
				'role_id'     => $role_id,
				'create_time' => time()
			];
			$res = $this->admin_role->save($data);
			if (!$res) return json(['status' => 0, 'message' => '修改失败']);
			return json(['status' => 1, 'message' => '修改成功']);
		} catch (\Exception $e) {
			return null;
		}
	}

}