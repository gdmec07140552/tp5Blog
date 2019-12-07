<?php
namespace app\admin\model;

use think\Db;
use think\Model;
use think\facade\Session;
use think\facade\Config;
use think\db\Where;

/**
* 通用基类
*/
class Base extends Model
{
	protected $table = '';
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [getOneData 获取单挑数据]
	 * @param  [type] $where [查询条件]
	 * @param  string $field [获取字段]
	 * @return [type]        [description]
	 */
	public function getOneData($where, $fieLd = '')
	{
		if (empty($fieLd))
			return Db::name($this->table)->where(new Where($where))->find();
		else
			return Db::name($this->table)->where(new Where($where))->field($fieLd)->find();
	}

	/**
	 * [getValue 获取单条数据]
	 * @param  [type] $where [查询条件]
	 * @param  string $field [获取字段]
	 * @return [type]        [description]
	 */
	public function getValue($where, $field = '')
	{
		return Db::name($this->table)->where(new Where($where))->value($fieLd);
	}

	/**
	 * [getAllData 获取所有的数据]
	 * param [field 获取字段]
	 * param [num 0获取所有数据]
	 * param [order 排序]
	 * param [where 查询条件]
	 * @return [type] [description]
	 */
	public function getAllData($where = [], $field = '', $num = 0, $order = [])
	{
		return Db::name($this->table)->where(new Where($where))->limit($num)->field($field)->order($order)->select();

	}

	/**
	 * [getPage 获取所有的数据]
	 * param [field 获取字段]
	 * param [num 0获取所有数据]
	 * param [order 排序]
	 * param [page false表示不分页]
	 * param [pageNum 显示分页数据,默认是10条]
	 * param [isTotal 是否显示分页数]
	 * @return [type] [description]
	 */
	public function getPage($where = [], $field = '', $num = 0, $order = [], $pageNum = 15, $isTotal = false)
	{

		$result = Db::name($this->table)->where(new Where($where))->field($field)->order($order)->limit($num)->paginate($pageNum);
		// 拼接分页总数
		if (!$result->render())
		{
			$pageHtml = '<ul class="pagination"><li class="disabled"><span>总共'. $result->lastPage() .'页'. $result->total() .'条数据</span></li></ul>';
		} else {
			$ulArray = explode('</ul>', $result->render());
			$pageHtml = $ulArray[0] . '<li class="disabled"><span>总共'. $result->lastPage() .'页'. $result->total() .'条数据</span></li>' . $ulArray[1];
		}
		$data = [
			'result' => $result,
			'page' => $pageHtml
		];
		if ($isTotal == true)
			return $data;
		else
			return $result;

	}

	/**
	 * [editData 修改数据]
	 * @return [type] [description]
	 */
	public function editData($where = [], $data = [])
	{
		return Db::name($this->table)->where(new Where($where))->update($data);
	}

	/**
	 * [deleteData 删除数据]
	 * @return [type] [description]
	 */
	public function deleteData($where = [])
	{
		return Db::name($this->table)->where(new Where($where))->delete();
	}

	/**
	 * [insertData 添加单条数据]
	 * @return [type] [description]
	 */
	public function insertData($data)
	{
		return Db::name($this->table)->insertGetId($data);
	}

	/**
	 * [insertAllData 添加多条数据]
	 * @return [type] [description]
	 */
	public function insertAllData($data)
	{
		return Db::name($this->table)->insertAll($data);
	}

	public function addLog($type = 0, $name = '', $id = 0)
	{
		$user = Session::get('user');
		$content = '';
		if ($type == 0)
			$content = '管理员登录';
		if ($type == 1)
			$content = '添加了' . $name . 'ID为' . $id . '的数据';
		if ($type == 2)
			$content = '编辑了' . $name . 'ID为' . $id . '的数据';
		if ($type == 3)
			$content = '删除了' . $name . 'ID为' . $id . '的数据';
		$data = [
			'admin_name' => $user['admin_name'],
			'type' => $type,
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'log_content' => $content,
			'create_time' => time()
		];

		return Db::name('admin_log')->insertGetId($data);
	}
}