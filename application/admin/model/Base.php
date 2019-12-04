<?php
namespace app\admin\model;

use think\Db;
use think\Model;
use think\facade\Session;
use think\facade\Config;

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
	 * @return [type] [description]
	 */
	public function getOneData($where, $fieLd = '')
	{
		if (empty($fieLd))
			return Db::name($this->table)->where($where)->find();
		else
			return Db::name($this->table)->where($where)->value($fieLd);
	}

	/**
	 * [getAllData 获取所有的数据]
	 * param [field 获取字段]
	 * param [num 0获取所有数据]
	 * param [order 排序]
	 * param [page false表示不分页]
	 * param [pageNum 显示分页数据,默认是10条]
	 * param [isTotal 是否显示分页数]
	 * @return [type] [description]
	 */
	public function getAllData($field = '', $num = 0, $order = [], $page = false, $pageNum = 10, $isTotal = false)
	{
		if ($page)
		{
			$result = Db::name($this->table)->field($field)->order($order)->limit($num)->paginate($pageNum);
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
		} else {
			return Db::name($this->table)->limit($num)->field($field)->order($order)->select();
		}

	}

	/**
	 * [editData 修改数据]
	 * @return [type] [description]
	 */
	public function editData($where, $data = [])
	{
		return Db::name($this->table)->where($where)->update($data);
	}

	/**
	 * [deleteData 删除数据]
	 * @return [type] [description]
	 */
	public function deleteData($where)
	{
		return Db::name($this->table)->where($where)->delete();
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
}