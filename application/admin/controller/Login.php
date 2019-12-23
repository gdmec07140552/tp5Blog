<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\facade\Config;
use think\facade\Session;

class Login extends Controller
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * 登录页面
	 * @return [type] [description]
	 */
	public function login()
	{		
		//判断用户是否已经登录过了
		if (Session::get('user'))
		{
			$this->redirect('Index/index');
		} else {
			return $this->fetch('login');
		}
	}

	/**
	 * 登录操作
	 * @return [type] [description]
	 */
	public function login_to()
	{
		$result = model('Login')->login_to();

		return $result;
	}

	/**
	 * 退出登录
	 * @return [type] [description]
	 */
	public function logout()
	{
		//清空用户基本信息
		Session::delete('user');
		session_destroy();
		return $this->redirect('Login/login');
	}
}