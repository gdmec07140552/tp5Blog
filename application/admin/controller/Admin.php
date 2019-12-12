<?php
namespace app\admin\controller;

use think\Db;
/**
* 管理员管理
*/
class Admin extends Base
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [list 管理员列表]
	 * @return [type] [description]
	 */
	public function list()
	{
		$input = input() ? input() : array();

		$result = model('Admin')->getPage([],'', 0);

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

		if (empty($data['admin_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Admin')->deleteData(['admin_id' => $data['admin_id']]);
		if ($result)
		{
			// 删除成则把它下级管理员设置成一级管理员
			model('Admin')->editData(['pid' => $data['admin_id']], ['pid' => 0]);
			// 管理员日志记录
			model('Base')->addLog(3, '管理员管理', $data['admin_id']);
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
			$where['admin_id'] = ['IN', $data['idArr']];
			model('Admin')->deleteData($where);
			// 删除成则把它下级管理员设置成一级管理员
			foreach ($data['idArr'] as $value) {
				model('Admin')->editData(['pid' => $value], ['pid' => 0]);
				// 管理员日志记录
				model('Base')->addLog(3, '管理员管理', $value);
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
		$result = model('Admin')->editData(['admin_id' => $input['admin_id']], ['is_show' => $input['is_show']]);
		// 管理员日志记录
			model('Base')->addLog(2, '管理员管理', $input['admin_id']);
		if ($result)
			return json(['status' => 1, 'msg' => '修改成功']);
		else
			return json(['status' => 0, 'msg' => '修改失败']);
	}

	/**
	 * 管理员--添加
	 * @return [type] [description]
	 */
	public function add()
	{
		$input = input() ? input() : array();

		//取出所有的管理员
		$role = model('Role')->getAllData(
				[],
				'role_id, role_name'
			);
		$this->assign('role', $role);

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
		$result = model('Admin')->insertData($input);
		// 管理员日志记录
			model('Base')->addLog(1, '管理员管理', $result);
		if ($result)
			return json(['status' => 1, 'msg' => '添加成功']);
		else
			return json(['status' => 0, 'msg' => '添加失败']);
	}

	/**
	 * 管理员--编辑
	 * @return [type] [description]
	 */
	public function edit()
	{
		$input = input() ? input() : array();
		
		$result = model('Admin')->getOneData(['admin_id' => input('admin_id')]);
		$this->assign('result', $result);
		// 获取管理员数据
		$array = model('Admin')->getAllData(
				[],
				'admin_id, cate_name, pid',
				0,
				['sort' => 'desc', 'admin_id' => 'desc']
			);
		$cate = model('Admin')->getTrees($array);
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
		$admin_id = $input['admin_id'];
		unset($input['admin_id']);
		// 查找是否有该管理员
		$cate = model('Admin')->getOneData(['admin_id' => $admin_id], 'pid');		
		if (!$cate)
			return json(['status' => 0, 'msg' => '修改失败']);
		Db::startTrans();
		try {
			// 如果把当前管理员设置成自己的子管理员的话，则把他设置成顶级管理员
			if ($admin_id == $input['pid'])
				$input['pid'] = 0;
			model('Admin')->editData(['admin_id' => $admin_id], $input);
			// 如果是顶级管理员修改的话，则把他的下一级管理员设置成顶级管理员
			if ($cate['pid'] == 0)
				model('Admin')->editData(['pid' => $admin_id], ['pid' => 0]);
			// 管理员日志记录
			model('Base')->addLog(2, '管理员管理', $admin_id);

			Db::commit();
			return json(['status' => 1, 'msg' => '修改成功']);
		} catch (Exception $e) {
			Db::rollback();
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}
}