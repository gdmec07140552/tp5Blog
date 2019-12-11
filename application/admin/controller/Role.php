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
		$input = input();

		if (empty($input['role_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Role')->deleteData(['role_id' => $input['role_id']]);
		if ($result)
		{
			// 删除成则把它下级角色设置成一级角色
			model('Role')->editData(['pid' => $input['role_id']], ['pid' => 0]);
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
		$input = input('post.');
		if (empty($input['idArr']))
			return json(['status' => 0, 'msg' => '删除失败']);
		Db::startTrans();
		try {
			$where['role_id'] = ['IN', $input['idArr']];
			model('Role')->deleteData($where);
			// 删除成则把它下级角色设置成一级角色
			foreach ($input['idArr'] as $value) {
				model('Role')->editData(['pid' => $value], ['pid' => 0]);
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
		$input = input() ? input() : array();

		//取出所有的角色
		$result = model('Auth')->getAllData();
		dump($result);
		$this->assign('result', $result);

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
		if ($input['pid'] != 0)
			$input['auth_link'] = Request::module() . '/' . $input['cont_name'] . '/' . $input['action_name'];
		else
			$input['auth_link'] = '';
		// 删除cont_name和action_name键值
		unset($input['cont_name']);
		unset($input['action_name']);
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
		$input = input() ? input() : array();
		
		$result = model('Role')->getOneData(['role_id' => input('role_id')]);
		// 获取控制器名和操作方法名
		if (!empty($result['auth_link']))
		{
			$contAction = explode('/', $result['auth_link']);
			$result['cont_name'] = $contAction[1];
			$result['action_name'] = $contAction[2];
		} else {
			$result['cont_name'] = '';
			$result['action_name'] = '';
		}
		$this->assign('result', $result);
		//取出所有的角色
		$auth = model('Role')->getAllData(
			[],
			'role_id, auth_name, pid',
			0,
			['sort' => 'desc', 'role_id' => 'desc']
		);

		//获取controller所有控制名称
		$controller = read_all_dir(__DIR__);
		$this->assign('controller', $controller);

		$list = model('Category')->getTrees($auth, ['auth_name', 'role_id']);
		$this->assign('auth', $list);

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
		$role_id = $input['role_id'];
		unset($input['role_id']);
		if ($input['pid'] != 0)
			$input['auth_link'] = Request::module() . '/' . $input['cont_name'] . '/' . $input['action_name'];
		else
			$input['auth_link'] = '';
		// 删除cont_name和action_name键值
		unset($input['cont_name']);
		unset($input['action_name']);
		// 查找是否有该角色
		$cate = model('Role')->getOneData(['role_id' => $role_id], 'pid');		
		if (!$cate)
			return json(['status' => 0, 'msg' => '修改失败']);
		Db::startTrans();
		try {
			// 如果把当前角色设置成自己的子角色的话，则把他设置成顶级角色
			if ($role_id == $input['pid'])
				$input['pid'] = 0;
			model('Role')->editData(['role_id' => $role_id], $input);
			// 如果是顶级角色修改的话，则把他的下一级角色设置成顶级角色
			if ($cate['pid'] == 0)
				model('Role')->editData(['pid' => $role_id], ['pid' => 0]);
			// 管理员日志记录
			model('Base')->addLog(2, '角色管理', $role_id);

			Db::commit();
			return json(['status' => 1, 'msg' => '修改成功']);
		} catch (Exception $e) {
			Db::rollback();
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}
}