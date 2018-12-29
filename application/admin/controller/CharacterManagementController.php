<?php

namespace app\admin\controller;

use app\common\controller\BaseController;
use app\common\model\Access;
use app\common\model\Role;
use app\common\model\RoleAccess;

class CharacterManagementController extends BaseController
{
	// 角色
	protected $role;
	// 角色与权限关系
	protected $role_access;
	// 权限
	protected $access;

	public function __construct(Role $role, RoleAccess $role_access, Access $access)
	{
		parent::__construct();
		$this->role = $role;
		$this->role_access = $role_access;
		$this->access = $access;
	}

	/**
	 * 角色列表
	 * @return \think\response\View
	 */
	public function index()
	{
		try {
			$res = $this->role->where('status', 1)->select();
			return view('character_management/index', [
				'list' => $res
			]);
		} catch (\Exception $e) {
			return null;
		}
	}

	/**
	 * 添加角色页面
	 * @return \think\response\View
	 */
	public function addPage()
	{
		return view('character_management/add_page');
	}

	/**
	 * 添加角色接口
	 */
	public function addCharacter()
	{
		try {
			$character = $this->request->post('character', '');
			if (!$character) return json(['status' => -1, '角色名称不能为空']);
			$validate_data = [
				'character' => $character
			];
			$validate = $this->validate($validate_data, 'app\validate\User.addCharacter');
			if ($validate !== true) return json(['status' => -1, 'message' => $validate]);
			$name = $this->role->getNameStatus($character);
			$data = [
				'name'        => $name,
				'create_time' => time()
			];
			$res = $this->role->save($data);
			if ($res != true) return json(['status' => -1, 'message' => '添加角色失败']);
			return json(['status' => 1, 'message' => '添加角色成功']);
		} catch (\Exception $e) {
			return null;
		}
	}

	/**
	 * 编辑角色页面
	 * @return \think\response\View
	 */
	public function editPage()
	{
		try {
			$id = $this->request->param('id', '');
			$res = $this->role->where('id', $id)->field('id,name')->find();
			$access_list = $this->access->accessList();
			$role_list = $this->role->role_list();
			return view('character_management/edit_page', [
				'list'        => $res,
				'access_list' => $access_list,
				'role_list'   => $role_list
			]);
		} catch (\Exception $e) {
			return null;
		}
	}

	/**
	 * 修改和分配权限
	 * @return null|\think\response\Json
	 */
	public function editCharacter()
	{
		try {
			$character = $this->request->post('character', '', 'intval');
			$permission = $this->request->post('permission', '', 'intval');
			if (!$character || $permission == -1) return json(['status' => -1, 'message' => '请将信填写完整']);
			$data = [
				'role_id'     => $character,
				'access_id'   => $permission,
				'create_time' => time()
			];
			$res = $this->role_access->save($data);
			if (!$res) return json(['status' => -1, 'message' => '分配权限失败']);
			return json(['status' => 1, 'message' => '分配权限成功']);
		} catch (\Exception $e) {
			return null;
		}
	}


}