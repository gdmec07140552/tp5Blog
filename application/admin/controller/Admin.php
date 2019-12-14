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
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();

		$result = model('Admin')->getAllData([]);
		// 获取角色名称
		foreach ($result as $key => $value) {

			if ($value['admin_id'] == 1)
				$result[$key]['role_name'] = "超级管理员";
			if ($value['role_id'] > 0)
				$result[$key]['role_name'] = model('Role')->getValue(['role_id' => $value['role_id']], 'role_name');
		}

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

		if (empty($data['admin_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Admin')->deleteData(['admin_id' => $data['admin_id']]);
		if ($result)
		{
			// 删除成则把它的图片从本地删除
			if (!empty($input['head_img']))
				delImage($input['head_img']);
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
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		$data = input('post.');
		if (empty($data['id_image']))
			return json(['status' => 0, 'msg' => '删除失败']);
		Db::startTrans();
		try {
			foreach ($data['id_image'] as $key => $value) {
				$idImage = explode('--', $value);
				$result = model('Admin')->deleteData(['admin_id' => $idImage['0']]);
				if (!empty($idImage[1]) && $result)
					delImage($idImage[1]);
				// 管理员日志记录
				model('Base')->addLog(3, '管理员管理', $idImage['0']);
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
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();

		//取出所有的角色
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
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		//添加数据
		$input = input('post.');
		if (empty($input))
			return json(['status' => 0, 'msg' => '添加失败']);
		$result = model('Admin')->checkData();
		if ($result['status'] == 1) {
			// 管理员日志记录
				model('Base')->addLog(1, '管理员管理', $result['msg']);
			return json(['status' => 1, 'msg' => '添加成功']);
		} else {
			return json(['status' => 0, 'msg' => $result['msg']]);
		}
	}

	/**
	 * 管理员--编辑
	 * @return [type] [description]
	 */
	public function edit()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();
		
		// 获取管理员数据
		$result = model('Admin')->getOneData(['admin_id' => input('admin_id')]);
		$this->assign('result', $result);
		//取出所有的角色
		$role = model('Role')->getAllData(
				[],
				'role_id, role_name'
			);
		$this->assign('role', $role);

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
		$admin_id = $input['admin_id'];
		unset($input['admin_id']);
		unset($input['images']);
		// 不修改密码则用旧密码
		if (empty($input['admin_pass']))
			unset($input['admin_pass']);
		else
			$input['admin_pass'] = md5Pass($input['admin_pass']);
		unset($input['repass']);
		// 查找是否有该管理员
		$admin = model('Admin')->getOneData(['admin_id' => $admin_id], 'admin_name, head_img');
		if (!$admin)
			return json(['status' => 0, 'msg' => '修改失败']);
		Db::startTrans();
		try {
			model('Admin')->editData(['admin_id' => $admin_id], $input);
			// 管理员日志记录
			model('Base')->addLog(2, '管理员管理', $admin_id);
			//修改成功把旧的图片删除
			if (!empty($input['head_img']) && $input['head_img'] != $admin['head_img'] && !empty($admin['head_img']))
				delImage($admin['head_img']);

			Db::commit();
			return json(['status' => 1, 'msg' => '修改成功']);
		} catch (Exception $e) {
			Db::rollback();
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}

}