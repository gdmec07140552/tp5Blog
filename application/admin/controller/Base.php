<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\facade\Config;
use think\facade\Session;
use think\Db;

class Base extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		// 获取网站配置信息
		$website = Config::pull('websiteConf');
		$this->assign('website', $website);
		// 判断用户是否已经登录
		if (!Session::get('user'))
		{
			return $this->redirect('Login/login');
		}
	}
}