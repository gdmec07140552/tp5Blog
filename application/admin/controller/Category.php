<?php
namespace app\admin\controller;

use think\Db;
/**
* 文章分类管理
*/
class Category extends Base
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
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');
		
		$input = input() ? input() : array();

		$result = model('Category')->getPage([],'', 0, ['sort' => 'desc', 'cate_id' => 'desc']);
		// dump($result);
		// 打印树形数据
		$cate = model('Category')->getTree($result);

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
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		$data = input();

		if (empty($data['cate_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Category')->deleteData(['cate_id' => $data['cate_id']]);
		if ($result)
		{
			// 删除成则把它下级分类设置成一级分类
			model('Category')->editData(['pid' => $data['cate_id']], ['pid' => 0]);
			// 管理员日志记录
			model('Base')->addLog(3, '文章分类', $data['cate_id']);
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
		if (empty($data['idArr']))
			return json(['status' => 0, 'msg' => '删除失败']);
		Db::startTrans();
		try {
			$where['cate_id'] = ['IN', $data['idArr']];
			model('Category')->deleteData($where);
			// 删除成则把它下级分类设置成一级分类
			foreach ($data['idArr'] as $value) {
				model('Category')->editData(['pid' => $value], ['pid' => 0]);
				// 管理员日志记录
				model('Base')->addLog(3, '文章分类', $value);
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
		$result = model('Category')->editData(['cate_id' => $input['cate_id']], ['is_show' => $input['is_show']]);
		// 管理员日志记录
			model('Base')->addLog(2, '文章分类', $input['cate_id']);
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
		$result = model('Category')->editData(['cate_id' => $input['cate_id']], ['sort' => $input['sort']]);
		// 管理员日志记录
			model('Base')->addLog(2, '文章分类', $input['cate_id']);
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
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();

		//取出所有的分类
		$cate = model('Category')->getAllData(
				[],
				'cate_id, cate_name, pid',
				0,
				['sort' => 'desc', 'cate_id' => 'desc']
			);

		$result = model('Category')->getTrees($cate);
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
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);
		//添加数据
		$input = input('post.');
		if (empty($input))
			return json(['status' => 0, 'msg' => '添加失败']);
		$result = model('Category')->insertData($input);
		// 管理员日志记录
			model('Base')->addLog(1, '文章分类', $result);
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
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();
		
		$result = model('Category')->getOneData(['cate_id' => input('cate_id')]);
		$this->assign('result', $result);
		// 获取分类数据
		$array = model('Category')->getAllData(
				[],
				'cate_id, cate_name, pid',
				0,
				['sort' => 'desc', 'cate_id' => 'desc']
			);
		$cate = model('Category')->getTrees($array);
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
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		$input = input('post.') ? input('post.') : array();
		$cate_id = $input['cate_id'];
		unset($input['cate_id']);
		// 查找是否有该分类
		$cate = model('Category')->getOneData(['cate_id' => $cate_id], 'pid');		
		if (!$cate)
			return json(['status' => 0, 'msg' => '修改失败']);
		Db::startTrans();
		try {
			// 如果把当前分类设置成自己的子分类的话，则把他设置成顶级分类
			if ($cate_id == $input['pid'])
				$input['pid'] = 0;
			model('Category')->editData(['cate_id' => $cate_id], $input);
			// 如果是顶级分类修改的话，则把他的下一级分类设置成顶级分类
			if ($cate['pid'] == 0)
				model('Category')->editData(['pid' => $cate_id], ['pid' => 0]);
			// 管理员日志记录
			model('Base')->addLog(2, '文章分类', $cate_id);

			Db::commit();
			return json(['status' => 1, 'msg' => '修改成功']);
		} catch (Exception $e) {
			Db::rollback();
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}
}