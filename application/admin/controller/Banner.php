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
		$input = input() ? input() : array();

		$result = model('Banner')->getAllData();
		$this->assign('result', $result);

		//引入js文件
		$this->assign('js_array', ['layui', 'x-layui']);
		return $this->fetch('banner_list');
	}

	/**
	 * [ajaxDeleteData ajax删除数据]
	 * @return [type] [description]
	 */
	public function ajaxDeleteData()
	{
		$result = model('Banner')->deleteData();
		return json($result);
	}

	/**
	 * [ajaxIsShow ajax显示隐藏]
	 * @return [type] [description]
	 */
	public function ajaxIsShow()
	{
		$result = model('Banner')->updateOneData(['id' => $input['id']], ['is_show' => $input['is_show']]);
			return json($result);
	}

	/**
	 * 轮播图--添加
	 * @return [type] [description]
	 */
	public function banner_add()
	{
		$input = input() ? input() : array();

		//引入js文件
		$this->assign('js_array', ['layui', 'x-layui']);
		return $this->fetch('banner_add');
	}

	/**
	 * [ajaxAddData ajax添加数据]
	 * @return [type] [description]
	 */
	public function ajaxAddData()
	{
		//添加数据
		$result = model('Banner')->addData();
		return json($result);
	}

	/**
	 * 轮播图--编辑
	 * @return [type] [description]
	 */
	public function banner_edit()
	{
		$input = input() ? input() : array();
		
		$result = model('Banner')->getOneData(['id' => input('id')]);
		$this->assign('result', $result);

		//引入js文件
		$this->assign('js_array', ['layui', 'x-admin']);
		return $this->fetch('banner_edit');
	}

	/**
	 * [ajaxEidtData ajax修改数据]
	 * @return [type] [description]
	 */
	public function ajaxEidtData()
	{
		// 修改数据
		$result = model('Banner')->saveData();
		return json($result);
	}
}