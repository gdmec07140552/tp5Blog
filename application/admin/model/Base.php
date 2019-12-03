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
	protected $table = 'banner';
	function __construct()
	{
		parent::__construct();
		$this->table = $this->table;
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
	 * param [num 0获取所有数据]
	 * param [order 排序]
	 * param [page false表示不分页]
	 * pageNum [page 显示分页数据,默认是10条]
	 * @return [type] [description]
	 */
	public function getAllData($num = 0, $order = [], $page = false, $pageNum = 1)
	{
		if ($page)
		{
			$result = Db::name($this->table)->order($order)->limit($num)->paginate($pageNum);
			// dump($result->lastPage());die;
			// 拼接分页总数
			// <ul class="pagination"><li class="disabled"><span>上一页</span></li> </ul>
			if (count($result) > 0)
			{
				$str = '<li class="disabled"><span>总共1页'. $result->total() .'条数据</span></li>';
			}
			$data = [
				'result' => $result,
				'page' => $result->render()
			];
			return $result;
		} else {
			return Db::name($this->table)->limit($num)->order($order)->select();
		}
		// return Db::name('banner')->order($order)->limit($num)->paginate($page);
		// if ($num == 0)
		// {
		// 	return Db::name($this->table)->order($order)->select();
		// 	if (empty($order))
		// 	{

		// 	}
		// } else {
		// 	return Db::name('banner')->order($order)->limit($num)->select()->paginate($page);
		// }

	}
}