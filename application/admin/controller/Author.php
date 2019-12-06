<?php
namespace app\admin\controller;

use think\Db;
/**
* 文章分类管理
*/
class Author extends Base
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [list 分类列表]
	 * @return [type] [description]
	 */
	public function list()
	{
		$input = input() ? input() : array();
		$result = model('Author')->getPage([],'', 0, ['sort' => 'desc', 'author_id' => 'desc']);
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
		$data = input('post.');

		if (empty($data['author_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Author')->deleteData(['author_id' => $data['author_id']]);
		if ($result)
		{
			// 删除成则把它的图片从本地删除
			if (!empty($input['head_img']))
				delImage($input['head_img']);
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
		$data = input('post.');
		if (empty($data['id_image']))
			return json(['status' => 0, 'msg' => '删除失败']);
		Db::startTrans();
		try {
			// 轮播id和图片地址分离
			foreach ($data['id_image'] as $key => $value) {
				$idImage = explode('--', $value);
				$result = model('Author')->deleteData(['author_id' => $idImage['0']]);
				if (!empty($idImage[1]) && $result)
					delImage($idImage[1]);
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
		$input = input() ? input() : array();
		$result = model('Author')->editData(['author_id' => $input['author_id']], ['is_show' => $input['is_show']]);
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
		$input = input() ? input() : array();
		$result = model('Author')->editData(['author_id' => $input['author_id']], ['sort' => $input['sort']]);
		if ($result)
			return json(['status' => 1, 'msg' => '修改成功']);
		else
			return json(['status' => 0, 'msg' => '修改失败']);
	}

	/**
	 * 文章分类--添加
	 * @return [type] [description]
	 */
	public function add()
	{
		$input = input() ? input() : array();

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
		//添加数据
		$input = input('post.');
		unset($input['images']);
		$input['create_time'] = time();
		if (empty($input))
			return json(['status' => 0, 'msg' => '添加失败']);
		$result = model('Author')->insertData($input);
		if ($result)
			return json(['status' => 1, 'msg' => '添加成功']);
		else
			return json(['status' => 0, 'msg' => '添加失败']);
	}

	/**
	 * 文章分类--编辑
	 * @return [type] [description]
	 */
	public function edit()
	{
		$input = input() ? input() : array();
		
		$result = model('Author')->getOneData(['author_id' => input('author_id')]);
		$this->assign('result', $result);

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
		$input = input('post.') ? input('post.') : array();
		$author_id = $input['author_id'];
		unset($input['author_id']);
		unset($input['images']);
		$res = model('Author')->getOneData(['author_id' => $author_id], 'head_img');
		if (!$res)
			return json(['status' => 0, 'msg' => '修改失败']);
		$result = model('Author')->editData(['author_id' => $author_id], $input);		
		if ($result)
		{
			//修改成功把旧的图片删除
			if (!empty($input['head_img']) && $input['head_img'] != $res['head_img'])
				delImage($res['head_img']);
			return json(['status' => 1, 'msg' => '修改成功']);
		} else {
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}
}