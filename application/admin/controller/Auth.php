<?php
namespace app\admin\controller;

use think\Db;
use think\facade\Request;
/**
* 权限管理
*/
class Auth extends Base
{
	
	function __construct()
	{
		parent::__construct();		
	}

	/**
	 * [list 权限列表]
	 * @return [type] [description]
	 */
	public function list()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();

		$result = model('Auth')->getPage([],'', 0, ['sort' => 'desc', 'auth_id' => 'desc']);
		// 打印树形数据
		$auth = model('Category')->getTree($result, ['auth_name', 'auth_id']);
		// dump($auth);die;

		$this->assign('auth', $auth);
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

		if (empty($input['auth_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Auth')->deleteData(['auth_id' => $input['auth_id']]);
		if ($result)
		{
			// 删除成则把它下级权限设置成一级权限
			model('Auth')->editData(['pid' => $input['auth_id']], ['pid' => 0]);
			// 管理员日志记录
			model('Base')->addLog(3, '权限管理', $input['auth_id']);
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
			$where['auth_id'] = ['IN', $input['idArr']];
			model('Auth')->deleteData($where);
			// 删除成则把它下级权限设置成一级权限
			foreach ($input['idArr'] as $value) {
				model('Auth')->editData(['pid' => $value], ['pid' => 0]);
				// 管理员日志记录
				model('Base')->addLog(3, '权限管理', $value);
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
		$result = model('Auth')->editData(['auth_id' => $input['auth_id']], ['is_show' => $input['is_show']]);
		// 管理员日志记录
			model('Base')->addLog(2, '权限管理', $input['auth_id']);
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
		$result = model('Auth')->editData(['auth_id' => $input['auth_id']], ['sort' => $input['sort']]);
		// 管理员日志记录
			model('Base')->addLog(2, '权限管理', $input['auth_id']);
		if ($result)
			return json(['status' => 1, 'msg' => '修改成功']);
		else
			return json(['status' => 0, 'msg' => '修改失败']);
	}

	/**
	 * 权限管理--添加
	 * @return [type] [description]
	 */
	public function add()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();

		//取出所有的权限
		$auth = model('Auth')->getAllData(
			[],
			'auth_id, auth_name, pid',
			0,
			['sort' => 'desc', 'auth_id' => 'desc']
		);

		//获取controller所有控制名称
		$controller = read_all_dir(__DIR__);
		$this->assign('controller', $controller);

		$result = model('Category')->getTrees($auth, ['auth_name', 'auth_id']);
		$this->assign('auth', $result);

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
		if ($input['pid'] != 0)
			$input['auth_link'] = Request::module() . '/' . $input['cont_name'] . '/' . $input['action_name'];
		else
			$input['auth_link'] = '';
		// 删除cont_name和action_name键值
		unset($input['cont_name']);
		unset($input['action_name']);
		if (empty($input))
			return json(['status' => 0, 'msg' => '添加失败']);
		$result = model('Auth')->insertData($input);
		if ($result) {
			// 管理员日志记录
			model('Base')->addLog(1, '权限管理', $result);

			return json(['status' => 1, 'msg' => '添加成功']);
		} else {
			return json(['status' => 0, 'msg' => '添加失败']);
		}
	}

	/**
	 * 权限管理--编辑
	 * @return [type] [description]
	 */
	public function edit()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();
		
		$result = model('Auth')->getOneData(['auth_id' => input('auth_id')]);
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
		//取出所有的权限
		$auth = model('Auth')->getAllData(
			[],
			'auth_id, auth_name, pid',
			0,
			['sort' => 'desc', 'auth_id' => 'desc']
		);

		//获取controller所有控制名称
		$controller = read_all_dir(__DIR__);
		$this->assign('controller', $controller);

		$list = model('Category')->getTrees($auth, ['auth_name', 'auth_id']);
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
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		$input = input('post.') ? input('post.') : array();
		$auth_id = $input['auth_id'];
		unset($input['auth_id']);
		if ($input['pid'] != 0)
			$input['auth_link'] = Request::module() . '/' . $input['cont_name'] . '/' . $input['action_name'];
		else
			$input['auth_link'] = '';
		// 删除cont_name和action_name键值
		unset($input['cont_name']);
		unset($input['action_name']);
		// 查找是否有该权限
		$cate = model('Auth')->getOneData(['auth_id' => $auth_id], 'pid');		
		if (!$cate)
			return json(['status' => 0, 'msg' => '修改失败']);
		Db::startTrans();
		try {
			// 如果把当前权限设置成自己的子权限的话，则把他设置成顶级权限
			if ($auth_id == $input['pid'])
				$input['pid'] = 0;
			model('Auth')->editData(['auth_id' => $auth_id], $input);
			// 如果是顶级权限修改的话，则把他的下一级权限设置成顶级权限
			if ($cate['pid'] == 0)
				model('Auth')->editData(['pid' => $auth_id], ['pid' => 0]);
			// 管理员日志记录
			model('Base')->addLog(2, '权限管理', $auth_id);

			Db::commit();
			return json(['status' => 1, 'msg' => '修改成功']);
		} catch (Exception $e) {
			Db::rollback();
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}

	public function ajaxGetAction()
	{
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);
		$input = input('get.');
		$actionArr = getClassAction($input['cont_name'], true);
		
		// $html = 'option value="0">选择操作方法</option>';
		// foreach ($actionArr as $value) {
		// 	$html .= '<option value="'. $value .'">'. $value .'</option>';
		// }

		return json($actionArr);
	}
}