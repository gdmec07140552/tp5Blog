<?php
namespace app\admin\controller;

/**
* 轮播图管理页面
*/
class Banner extends Base
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * 轮播图--列表
	 * @return [type] [description]
	 */
	public function banner_list()
	{
		//引入js文件
		$this->assign('js_array', ['layui', 'x-layui']);
		return $this->fetch('banner_list');
	}

	/**
	 * 轮播图--添加
	 * @return [type] [description]
	 */
	public function banner_add()
	{
		//引入js文件
		$this->assign('js_array', ['layui', 'x-layui']);
		return $this->fetch('banner_add');
	}

	/**
	 * 轮播图列表
	 * @return [type] [description]
	 */
	public function banner_edit()
	{
		//引入js文件
		$this->assign('js_array', ['layui', 'x-admin']);
		return $this->fetch('banner_edit');
	}
}