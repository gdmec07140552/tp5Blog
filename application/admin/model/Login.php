<?php
namespace app\admin\model;

use think\Model;
use think\Request;
use think\Db;
use think\Validate;
use think\facade\Session;

class Login extends Model
{
	
	protected $table = 'admin';
	function __construct()
	{
		parent::__construct();
	}


	/**
	 * 用户登录操作
	 * @return [type] [description]
	 */
	public function login_to()
	{
		//验证用户名和密码
		$data = input();
		$check_result = $this->checkData($data);
		if ($check_result != 1)
		{
			return ['status' => -1, 'mess' => $check_result];
		}

		// 根据用户名查找用户信息
		$user = Db::name($this->table)->where(['admin_name' => $data['admin_name']])->find();
		if (!$user) {
			// 根据手机号码查找用户信息
			$user = Db::name($this->table)->where(['phone' => $data['admin_name']])->find();
			if (!$user)
				return ['status' => -1, 'mess' => '用户名错误'];
		}

		//检查用户的密码是否正确
		// 1.取出配置文件中的密码前缀字符串
		$admin_pass = md5Pass($data['admin_pass']);
		if ($admin_pass != $user['admin_pass']) return ['status' => -1 , 'mess' => '密码错误'];
		if ($user['is_show'] == -1) ['status' => -1, 'mess' => '该用户已被禁用'];

		//登录成功保存用户的基本信息
		// 1.保存用户的基本信息
			unset($user['admin_pass']);
			Session::set('user', $user);
		// 2.更新用户的登录数据
			Db::name($this->table)->where('admin_id' , 'eq', $user['admin_id'])->update([
					'last_ip' => $_SERVER['REMOTE_ADDR'],
					'login_num' => $user['login_num'] + 1,
					'last_time' => time()
				]);
		// 3.管理员日志记录
			model('Base')->addLog();
		// 4.保存用户的权限
			$this->setPermission();

		return ['status' => 1, 'data' => Session::get('user')];
	}

	/**
	 * [checkData 验证数据]
	 * @param  [type] $data [验证数据]
	 * @return [type]       [description]
	 */
	protected function checkData($data)
	{
		//验证用户名和密码

		$rule = [
			'admin_name' => 'require',
			'admin_pass' => 'require|length: 4, 20'
		];

		$message = [
			'admin_name.require' => '密码不能为空',
			'admin_pass.require' => '密码不能为空',
			'admin_pass.length' => '密码要4-20位字符之间'
		];

		$validate = Validate::make($rule, $message);
		if (!$validate->check($data))
			return $validate->getError();
		else
			return 1;
	}

	/**
	 * [setPermission 保护用户的权限信息]
	 * @param [type] $user [description]
	 */
	protected function setPermission()
	{
		$user = Session::get('user');
		if ($user['admin_id'] == 1)
		{
			// 超级管理员，大boss给所有权限
			Session::set('auth', 'all');
		} else {
			if ($user['role_id'] > 0)
			{				
				// 获取角色下拥有的权限
				$role = model('Role')->getValue(['role_id' => $user['role_id']], 'auth');
				$idArr = explode(',', $role);
				$where['auth_id'] = ['in', $idArr];
				$auth = model('Auth')->getAllData($where, 'auth_link');
				Session::set('auth', $auth);
			} else {
				Session::set('auth', '');
			}

		}

		return Session::get('auth');
	}


}