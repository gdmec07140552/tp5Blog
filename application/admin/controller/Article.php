<?php
namespace app\admin\controller;

use think\Db;
/**
* 文章分类管理
*/
class Article extends Base
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

		$result = model('Article')->getPage([],'', 0, ['sort' => 'desc', 'cate_id' => 'desc']);
		// dump($result);
		// 打印树形数据
		$cate = model('Article')->getTree($result);

		$this->assign('cate', $cate);
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

		if (empty($data['cate_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Article')->deleteData(['cate_id' => $data['cate_id']]);
		if ($result)
		{
			// 删除成则把它下级分类设置成一级分类
			model('Article')->editData(['pid' => $data['cate_id']], ['pid' => 0]);
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
			$where['cate_id'] = ['IN', $data['idArr']];
			model('Article')->deleteData($where);
			// 删除成则把它下级分类设置成一级分类
			foreach ($data['idArr'] as $value) {
				model('Article')->editData(['pid' => $value], ['pid' => 0]);
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
		$result = model('Article')->editData(['cate_id' => $input['cate_id']], ['is_show' => $input['is_show']]);
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
		$result = model('Article')->editData(['cate_id' => $input['cate_id']], ['sort' => $input['sort']]);
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

		//取出所有的分类
		$cate = model('Article')->getAllData(
				[],
				'cate_id, cate_name, pid',
				0,
				['sort' => 'desc', 'cate_id' => 'desc']
			);

		$result = model('Article')->getTrees($cate);
		$this->assign('cate', $result);

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
		if (empty($input))
			return json(['status' => 0, 'msg' => '添加失败']);
		$result = model('Article')->insertData($input);
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
		
		$result = model('Article')->getOneData(['cate_id' => input('cate_id')]);
		$this->assign('result', $result);
		// 获取分类数据
		$array = model('Article')->getAllData(
				[],
				'cate_id, cate_name, pid',
				0,
				['sort' => 'desc', 'cate_id' => 'desc']
			);
		$cate = model('Article')->getTrees($array);
		$this->assign('cate', $cate);

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
		$cate_id = $input['cate_id'];
		unset($input['cate_id']);
		// 查找是否有该分类
		$cate = model('Article')->getOneData(['cate_id' => $cate_id], 'pid');		
		if (!$cate)
			return json(['status' => 0, 'msg' => '修改失败']);
		Db::startTrans();
		try {
			// 如果把当前分类设置成自己的子分类的话，则把他设置成顶级分类
			if ($cate_id == $input['pid'])
				$input['pid'] = 0;
			model('Article')->editData(['cate_id' => $cate_id], $input);
			// 如果是顶级分类修改的话，则把他的下一级分类设置成顶级分类
			if ($cate['pid'] == 0)
				model('Article')->editData(['pid' => $cate_id], ['pid' => 0]);

			Db::commit();
			return json(['status' => 1, 'msg' => '修改成功']);
		} catch (Exception $e) {
			Db::rollback();
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}
}