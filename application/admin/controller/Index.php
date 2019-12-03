<?php
namespace app\admin\controller;

class Index extends Base
{
	
	function __construct()
	{
		parent::__construct();
		
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
}