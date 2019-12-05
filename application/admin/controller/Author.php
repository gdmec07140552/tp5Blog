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
		$this->assign('result' , $result);

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
		$data = input();

		if (empty($data['author_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Author')->deleteData(['author_id' => $data['author_id']]);
		if ($result)
		{
			// 删除成则把它下级分类设置成一级分类
			model('Author')->editData(['pid' => $data['author_id']], ['pid' => 0]);
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
		if (empty($data['idArr']))
			return json(['status' => 0, 'msg' => '删除失败']);
		Db::startTrans();
		try {
			$where['author_id'] = ['IN', $data['idArr']];
			model('Author')->deleteData($where);
			// 删除成则把它下级分类设置成一级分类
			foreach ($data['idArr'] as $value) {
				model('Author')->editData(['pid' => $value], ['pid' => 0]);
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
		$author = $input['author_id'];
		unset($input['author_id']);
		// 查找是否有该分类
		$cate = model('Author')->getOneData(['author_id' => $author], 'pid');		
		if (!$cate)
			return json(['status' => 0, 'msg' => '修改失败']);
		Db::startTrans();
		try {
			// 如果把当前分类设置成自己的子分类的话，则把他设置成顶级分类
			if ($author == $input['pid'])
				$input['pid'] = 0;
			model('Author')->editData(['author_id' => $author], $input);
			// 如果是顶级分类修改的话，则把他的下一级分类设置成顶级分类
			if ($cate['pid'] == 0)
				model('Author')->editData(['pid' => $author], ['pid' => 0]);

			Db::commit();
			return json(['status' => 1, 'msg' => '修改成功']);
		} catch (Exception $e) {
			Db::rollback();
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}
}