<?php
namespace app\admin\controller;

class Index extends Base
{
	
	function __construct()
	{
		parent::__construct();
		// 检测用户的基本权限
		// permission();
	}

	/**
	 * 后台首页
	 * @return [type] [description]
	 */
	public function index()
	{
		//引入js文件
		$this->assign('js_array', ['layui', 'x-admin']);
		return $this->fetch('index');
	}

	/**
	 * 后台首页欢迎页
	 * @return [type] [description]
	 */
	public function welcome()
	{
		// dump(Session('user'));
		//引入js文件
		$this->assign('js_array', ['layui', 'x-admin']);
		return $this->fetch('welcome');
	}

	/**
	 * [no_permission 无权限]
	 * @return [type] [description]
	 */
	public function no_permission()
	{
		//引入js文件
		$this->assign('js_array', []);
		return $this->fetch('no_permission');
	}
}