<?php

namespace app\admin\controller;

use app\common\controller\BaseController;

class AdminManagementController extends BaseController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		return view('admin_management/index');
	}

	public function addPage()
	{
		return view('admin_management/addPage');
	}

	public function addAdmin()
	{

	}

}