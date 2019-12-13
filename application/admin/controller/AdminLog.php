<?php
namespace app\admin\controller;

use think\Db;
/**
* 管理员管理
*/
class AdminLog extends Base
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

		$result = model('AdminLog')->getPage([],'', 0, ['log_id' => 'desc'], 20);

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

		if (empty($data['log_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('AdminLog')->deleteData(['log_id' => $data['log_id']]);
		if ($result)
		{
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

		$where['log_id'] = ['IN', $data['idArr']];
		$result = model('AdminLog')->deleteData($where);
		if ($result)
			return json(['status' => 1, 'msg' => '删除成功']);
		else
			return json(['status' => 0, 'msg' => '删除失败']);
	}
}