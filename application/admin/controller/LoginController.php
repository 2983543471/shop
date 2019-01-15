<?php

namespace app\admin\controller;

use app\common\model\Admin;
use app\validate\User;
use think\Controller;
use think\facade\Session;

class LoginController extends Controller
{
	protected $user;
	protected $admin;

	public function __construct(User $user, Admin $admin)
	{
		parent::__construct();
		$this->user = $user;
		$this->admin = $admin;
	}

	/**
	 * 登录页面
	 * @return \think\response\View
	 */
	public function second()
	{
		return view('login/login');
	}

	/**
	 * 登录接口
	 * @return string|\think\response\Json
	 */
	public function login()
	{
		try {
			if (session('username')) return json(['status' => 0, 'message' => '请勿重复登录']);
			$username = $this->request->post('username', '');
			$password = $this->request->post('password', '');
			$data = [
				'username' => $username,
				'password' => $password
			];
			$validate_res = $this->validate($data, 'app\validate\User.login');
			if ($validate_res !== true) {
				return json(['status' => -1, 'message' => $validate_res]);
			}
			$user_info = $this
				->admin
				->where('username', $data['username'])
				->field('password, user_string, id')
				->find();
			$md5_password = md5($data['password'] . $user_info['user_string']);
			if ($md5_password != $user_info['password']) return json(['status' => -1, 'message' => '账号或密码错误']);
			$value = base64_encode($user_info['id'] . '|' . $_SERVER['REMOTE_ADDR']);
			setcookie('token', $value, time() + 300, '/');
			Session::set('id', $user_info['id']);
			Session::set('username', $username);
			return json(['status' => 1, 'message' => '登录成功，即将跳到首页', 'data' => 'http://shop.com/admin/index/index']);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * 退出登录
	 */
	public function loginOut()
	{
		Session::clear();
		$this->redirect('/admin/index/index');
	}
}