<?php
namespace app\admin\controller;

use think\Db;
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
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

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
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);
		
		$data = input();

		if (empty($data['id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Banner')->deleteData(['id' => $data['id']]);		
		// 删除成功之后先把图片清除
		if (!empty($data['img_url']) && $result['status'] == 1)
			delImage($data['img_url']);
		// 管理员日志记录
		model('Base')->addLog(3, '轮播图', $data['id']);

		return json($result);
	}

	/**
	 * [ajaxDelAllData 删除多条数据]
	 * @return [type] [description]
	 */
	public function ajaxDelAllData()
	{
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		$data = input();

		if (empty($data['id_image']))
			return json(['status' => 0, 'msg' => '删除失败']);
		
		Db::startTrans();
		try {
			// 轮播id和图片地址分离
			foreach ($data['id_image'] as $key => $value) {
				$idImage = explode('--', $value);
				$result = model('Banner')->deleteData(['id' => $idImage['0']]);
				if (!empty($idImage[1]) && $result['status'] == 1)
					delImage($idImage[1]);
				// 管理员日志记录
				model('Base')->addLog(3, '轮播图', $idImage['0']);
			}
			Db::commit();
		} catch (Exception $e) {
			Db::rollback();
		}
		
		return json($result);
	}

	/**
	 * [ajaxIsShow ajax显示隐藏]
	 * @return [type] [description]
	 */
	public function ajaxIsShow()
	{
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		$input = input() ? input() : array();
		$result = model('Banner')->updateOneData(['id' => $input['id']], ['is_show' => $input['is_show']]);
		// 管理员日志记录
		model('Base')->addLog(2, '轮播图', $input['id']);
		if ($result)
			return json(['status' => 1, 'msg' => '修改成功']);
		else
			return json(['status' => 0, 'msg' => '修改失败']);
	}

	/**
	 * [ajaxSort ajax排序]
	 * @return [type] [description]
	 */
	public function ajaxSort()
	{
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		$input = input() ? input() : array();
		$result = model('Banner')->updateOneData(['id' => $input['id']], ['sort' => $input['sort']]);
		// 管理员日志记录
		model('Base')->addLog(2, '轮播图', $input['id']);
		if ($result)
			return json(['status' => 1, 'msg' => '修改成功']);
		else
			return json(['status' => 0, 'msg' => '修改失败']);
	}

	/**
	 * 轮播图--添加
	 * @return [type] [description]
	 */
	public function banner_add()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

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
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

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
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

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
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		// 修改数据
		$result = model('Banner')->saveData();
		return json($result);
	}
}