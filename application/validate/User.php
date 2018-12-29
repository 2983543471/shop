<?php
/**
 * Created by PhpStorm.
 * User: voowo
 * Date: 2018/12/11
 * Time: 09:14
 */

namespace app\validate;

use think\Validate;

class User extends Validate
{
	protected $rule = [
		'username'         => 'require',
		'password'         => 'require',
		'confirm_password' => 'require|confirm:password',
		'character'        => 'require|in:1,2,3'
	];

	protected $message = [
		'username.require'         => '名称必须',
		'password.require'         => '密码必须',
		'confirm_password.require' => '重复密码密码必须',
		'confirm_password.confirm' => '两次密码不一样',
		'character.require'        => '角色名称必须选择',
		'character.in'             => '非法角色名称'
	];

	protected $scene = [
		'register' => ['username', 'password', 'confirm_password'],
		'login'    => ['username', 'password'],
		'addAdmin' => ['username', 'password', 'character'],
		'addCharacter' => ['character'],
	];

}