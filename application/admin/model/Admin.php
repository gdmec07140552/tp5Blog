<?php
namespace app\admin\model;

use think\Validate;
use think\facade\Config;
use think\Db;
/**
* 管理员管理
*/
class Admin extends Base
{
	protected $table = 'admin';
	function __construct()
	{
		parent::__construct();
		$this->table = $this->table;
	}

	public function checkData()
	{
		$input = input('post.');
		// 检查手机是否有效
		if (!checkPhone($input['phone']))
			return ['status' => 0, 'msg' => '手机号码无效'];
		// 检查数据是否有效
		$check = $this->getCheckData($input);
		if ($check != 1)
			return ['status' => 0, 'msg' => $check];
		unset($input['images']);
		unset($input['repass']);
		// 密码加密
		$input['admin_pass'] = md5Pass($input['admin_pass']);

		$result = model('Admin')->insertData($input);
		if ($result)
			return ['status' => 1, 'msg' => $result];
		else
			return ['status' => 0, 'msg' => '添加失败']; 

		// 验证数据
	}

	/**
	 * [getCheckData 数据验证]
	 * @param  [type] $data [验证数据]
	 * @return [type]       [description]
	 */
	public function getCheckData($data)
	{
		$rule = [
			'admin_name' => 'require|length:4, 16',
			'phone' => 'require',
			'email' => 'email',
			'admin_pass' => 'require|length: 4,20',
			'repass' => 'require|confirm:admin_pass'			
		];

		$msg = [
			'admin_name.require' => '名称不能为空',
			'admin_name.length' => '名字必须是4-16个字符',
			'phone|require' => '手机号不能为空',
			'email' => '邮箱格式错误',
			'admin_pass.require' => '密码不能为空',
			'admin_pass.length' => '密码必须是4-20个字符',
			'repass.require' => '确认密码不能为空',
			'repass.confirm' => '两个密码不一致'
		];

		$validate = Validate::make($rule, $msg);
		if (!$validate->check($data))
			return $validate->getError();
		else
			return 1;
	}

	// public function getAdmin()
	// {
	// 	$input = input() ? input() : array();
	// 	return Db::name($this->table)->alias('a')->field('a.*, s.role_name')->join('blog_admin_role s', 's.role_id = a.role_id')->select();
	// }

}