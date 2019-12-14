<?php
namespace app\admin\controller;

use think\Db;
use think\facade\Request;
/**
* 角色管理
*/
class Role extends Base
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [list 角色列表]
	 * @return [type] [description]
	 */
	public function list()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();

		$result = model('Role')->getPage([],'', 0, ['sort' => 'desc', 'role_id' => 'desc']);

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
		
		$input = input();

		if (empty($input['role_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Role')->deleteData(['role_id' => $input['role_id']]);
		if ($result)
		{
			// 管理员日志记录
			model('Base')->addLog(3, '角色管理', $input['role_id']);
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

		$input = input('post.');
		if (empty($input['idArr']))
			return json(['status' => 0, 'msg' => '删除失败']);
		Db::startTrans();
		try {
			$where['role_id'] = ['IN', $input['idArr']];
			model('Role')->deleteData($where);
			// 删除成则把它下级角色设置成一级角色
			foreach ($input['idArr'] as $value) {
				// 管理员日志记录
				model('Base')->addLog(3, '角色管理', $value);
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
		$result = model('Role')->editData(['role_id' => $input['role_id']], ['is_show' => $input['is_show']]);
		// 管理员日志记录
			model('Base')->addLog(2, '角色管理', $input['role_id']);
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
		$result = model('Role')->editData(['role_id' => $input['role_id']], ['sort' => $input['sort']]);
		// 管理员日志记录
			model('Base')->addLog(2, '角色管理', $input['role_id']);
		if ($result)
			return json(['status' => 1, 'msg' => '修改成功']);
		else
			return json(['status' => 0, 'msg' => '修改失败']);
	}

	/**
	 * 角色管理--添加
	 * @return [type] [description]
	 */
	public function add()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();

		//取出所有的角色
		$result = model('Auth')->getAllData();
		// 二维数组转四维数组
		$array = model('Category')->arrayMoreToFore($result, ['auth_name', 'auth_id']);
		unset($array[0]);

		$this->assign('result', $array);

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
		// 处理权限id
		if (!empty($input['auth']))
			$input['auth'] = implode(',', $input['auth']);
		if (empty($input))
			return json(['status' => 0, 'msg' => '添加失败']);
		$result = model('Role')->insertData($input);
		if ($result) {
			// 管理员日志记录
			model('Base')->addLog(1, '角色管理', $result);

			return json(['status' => 1, 'msg' => '添加成功']);
		} else {
			return json(['status' => 0, 'msg' => '添加失败']);
		}
	}

	/**
	 * 角色管理--编辑
	 * @return [type] [description]
	 */
	public function edit()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();
		
		$result = model('Role')->getOneData(['role_id' => input('role_id')]);
		// 获取控制器名和操作方法名
		if (!empty($result['auth']))
			$result['auth'] = explode(',', $result['auth']);
		$this->assign('result', $result);

		//取出所有的角色
		$auth = model('Auth')->getAllData();
		// 二维数组转四维数组
		$array = model('Category')->arrayMoreToFore($auth, ['auth_name', 'auth_id']);
		unset($array[0]);

		$this->assign('list', $array);

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
		$role_id = $input['role_id'];
		unset($input['role_id']);
		// 处理权限id
		if (!empty($input['auth']))
			$input['auth'] = implode(',', $input['auth']);
		$result = model('Role')->editData(['role_id' => $role_id], $input);
		if ($result)
		{
			// 管理员日志记录
			model('Base')->addLog(2, '角色管理', $role_id);

			return json(['status' => 1, 'msg' => '修改成功']);
		} else {
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}
}