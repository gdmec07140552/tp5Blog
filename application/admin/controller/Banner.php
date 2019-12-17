<?php
namespace app\admin\controller;

use think\Db;
/**
* 轮播管理
*/
class Banner extends Base
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [list 轮播列表]
	 * @return [type] [description]
	 */
	public function list()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();
		$result = model('Banner')->getPage([],'', 0, ['sort' => 'desc', 'banner_id' => 'desc']);
		$this->assign('page', $result);
		$array = [];
		foreach ($result as $key => $value) {
			$array[] = $value;
		}
		$this->assign('result' , $array);

		//引入js文件
		$this->assign('js_array', ['layui', 'x-layui']);
		return $this->fetch('list');
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
		$data = input('post.');

		if (empty($data['banner_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Banner')->deleteData(['banner_id' => $data['banner_id']]);
		if ($result)
		{
			// 删除成则把它的图片从本地删除
			if (!empty($input['img_url']))
				delImage($input['img_url']);
			// 管理员日志记录
			model('Base')->addLog(3, '轮播管理', $data['banner_id']);
			return json(['status' => 1, 'msg' => '删除成功']);
		} else {
			return json(['status' => 0, 'msg' => '删除失败']);
		}
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

		$data = input('post.');
		if (empty($data['id_image']))
			return json(['status' => 0, 'msg' => '删除失败']);
		Db::startTrans();
		try {
			// 轮播id和图片地址分离
			foreach ($data['id_image'] as $key => $value) {
				$idImage = explode('--', $value);
				$result = model('Banner')->deleteData(['banner_id' => $idImage['0']]);
				if (!empty($idImage[1]) && $result)
					delImage($idImage[1]);
				// 管理员日志记录
				model('Base')->addLog(3, '轮播管理', $idImage['0']);
			}
			Db::commit();
			return json(['status' => 1, 'msg' => '删除成功']);
		} catch (Exception $e) {
			Db::rollback();
			return json(['status' => 0, 'msg' => '删除失败']);
		}
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
		$result = model('Banner')->editData(['banner_id' => $input['banner_id']], ['is_show' => $input['is_show']]);
		// 管理员日志记录
		model('Base')->addLog(2, '轮播管理', $input['banner_id']);
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
		$result = model('Banner')->editData(['banner_id' => $input['banner_id']], ['sort' => $input['sort']]);
		// 管理员日志记录
			model('Base')->addLog(2, '轮播管理', $input['banner_id']);
		if ($result)
			return json(['status' => 1, 'msg' => '修改成功']);
		else
			return json(['status' => 0, 'msg' => '修改失败']);
	}

	/**
	 * 轮播--添加
	 * @return [type] [description]
	 */
	public function add()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');
		$input = input() ? input() : array();

		// 获取文章
		$article = model('Article')->getAllData(['is_show' => 0], 'art_id, art_title');
		$this->assign('article', $article);

		//引入js文件
		$this->assign('js_array', ['layui', 'x-layui']);
		return $this->fetch('add');
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
		$input = input('post.');
		unset($input['images']);
		if (empty($input))
			return json(['status' => 0, 'msg' => '添加失败']);
		$result = model('Banner')->insertData($input);
		if ($result) {
			// 管理员日志记录
			model('Base')->addLog(1, '轮播管理', $result);
			return json(['status' => 1, 'msg' => '添加成功']);
		} else {
			return json(['status' => 0, 'msg' => '添加失败']);
		}
	}

	/**
	 * 轮播--编辑
	 * @return [type] [description]
	 */
	public function edit()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');
		$input = input() ? input() : array();
		
		$result = model('Banner')->getOneData(['banner_id' => input('banner_id')]);
		$this->assign('result', $result);

		// 获取文章
		$article = model('Article')->getAllData(['is_show' => 0], 'art_id, art_title');
		$this->assign('article', $article);

		//引入js文件
		$this->assign('js_array', ['layui', 'x-admin']);
		return $this->fetch('edit');
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

		$input = input('post.') ? input('post.') : array();
		$banner_id = $input['banner_id'];
		unset($input['banner_id']);
		unset($input['images']);
		$res = model('Banner')->getOneData(['banner_id' => $banner_id], 'img_url');
		if (!$res)
			return json(['status' => 0, 'msg' => '修改失败']);
		$result = model('Banner')->editData(['banner_id' => $banner_id], $input);		
		if ($result)
		{
			//修改成功把旧的图片删除
			if (!empty($input['img_url']) && $input['img_url'] != $res['img_url'])
				delImage($res['img_url']);
			// 管理员日志记录
			model('Base')->addLog(2, '轮播管理', $banner_id);
			return json(['status' => 1, 'msg' => '修改成功']);
		} else {
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}
}