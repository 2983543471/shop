<?php

namespace app\index\controller;

use app\common\controller\BaseController;
use app\common\model\Admin;
use app\validate\User;
use think\facade\Session;

class LoginController extends BaseController
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
	 * 注册
	 * @return \think\response\Json
	 */
	public function register()
	{
		if ($this->request->isAjax()) {
			$username = $this->request->post('username', '');
			$password = $this->request->post('password', '');
			$confirm_password = $this->request->post('confirm_password', '');
			if (!$username || !$password || !$confirm_password) {
				return json(['status' => -1, 'message' => '请将信息填写完整']);
			}
			$validate_data = [
				'username'         => $username,
				'password'         => $password,
				'confirm_password' => $confirm_password
			];
			$validate_res = $this->validate($validate_data, 'app\validate\User.register');
			if ($validate_res !== true) {
				return json(['status' => -1, 'message' => $validate_res]);
			}
			$user_string = config('login.user_string');
			$insert_data = [
				'username'    => $username,
				'password'    => md5($password . $user_string),
				'user_string' => $user_string
			];
			$res = $this->admin->insert($insert_data);
			if (!$res) {
				return json(['status' => -1, 'message' => '注册失败']);
			}
			return json(['status' => 1, 'message' => '注册成功，即将跳到首页', 'data' => "{:url('/index/login/second')}"]);
		}
		return view('login/index');
	}

	/**
	 * 登录
	 * @return string|\think\response\Json|\think\response\View
	 */
	public function login()
	{
		if ($this->request->isAjax()) {
			try {
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
					->field('password, user_string')
					->find();
				$md5_password = md5($data['password'] . $user_info['user_string']);
				if ($md5_password != $user_info['password']) {
					return json(['status' => -1, 'message' => '账号或密码错误']);
				}
				Session::set('username', $username);
				Session::set('password', $password);
				return json(['status' => 1, 'message' => '登录成功，即将跳到首页', 'data' => 'http://shop.com/index/index/index']);
			} catch (\Exception $e) {
				return $e->getMessage();
			}
		}
		return view('login/login');
	}
}