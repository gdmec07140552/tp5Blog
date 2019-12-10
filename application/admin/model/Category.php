<?php
namespace app\admin\model;


/**
* 分类管理
*/
class Category extends Base
{	

	protected $table = 'category';
	function __construct()
	{
		parent::__construct();
		$this->table = $this->table;
	}

   /**
    * [getTrees 递归实现无限极分类]
    * @param  [type]  $array [分类数据]
    * @param [array] $[fieldArr] [查询字段]
    * @param  integer $pid   [父ID]
    * @param  integer $level [分类级别]
    * @param  boolean $isStr [是否显示--]
    * @return [type]         [分好类的数组 直接遍历即可 $level可以用来遍历缩进]
    */
	public function getTrees($array, $fieldArr = ['cate_name', 'cate_id'], $pid = 0, $level = 0, $isStr = false)
	{
		//声明静态数组,避免递归调用时,多次声明导致数组覆盖
		static $list = [];
		foreach ($array as $key => $value) {
			//第一次遍历,找到父节点为根节点的节点 也就是pid=0的节点
			if ($value['pid'] == $pid)
			{
				//父节点为根节点的节点,级别为0，也就是第一级
				$value['level'] = $level;
				if ($level > 0 && $isStr == false)
					$value[$fieldArr[0]] = '|' . str_repeat('----', $level) . $value[$fieldArr[0]];
				//把数组放到list中
				$list[] = $value;
				//把这个节点从数组中移除,减少后续递归消耗
				unset($array[$key]);
				//开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
				$this->getTrees($array, $fieldArr, $value[$fieldArr[1]], $level+1);
			}

		}

		return $list;
	}
	
	/**
	 * [getTree 引用算法实现无限极分类]
	 * @param  [type] $array [分类数据]
	 * @param [array] $[fieldArr] [查询字段]
	 * @param [type] $[isMore] [几维数组]
	 * @return [type]        [description]
	 */
	public function getTree($array, $fieldArr = ['cate_name', 'cate_id'], $isMore = true)
	{
		//第一步 构造数据
		$list = [];
		foreach ($array as  $value) {
			$list[$value[$fieldArr[1]]] = $value;
		}
		//第二部 遍历数据 生成树状结构
		$tree = [];
		foreach ($list as $k => $val) {
			if (isset($list[$val['pid']]))
			{
				$list[$val['pid']]['son'][$k] = &$list[$k];
			} else {
				$tree[] = &$list[$k];
			}
		}
		if ($isMore == true)
			return $this->arrayMoreToOne($tree, $fieldArr);
		else 
			return $tree;
	}

	/**
	 * [arrayMoreToOne 多维数组转一位数组]
	 * @param  [type]  &$array [多维数组]
	 * @param [array] $[fieldArr] [查询字段]
	 * @param [string] $str [判断字段]
	 * @param  integer $level  [分类级别]
	 * @param  boolean $isStr  [是否显示--]
	 * @return [type]          [description]
	 */
	public function arrayMoreToOne(&$array, $fieldArr = ['cate_name', 'cate_id'], $str = 'son', $level = 0 , $isStr = true)
	{
		//声明静态数组,避免递归调用时,多次声明导致数组覆盖
		static $list = [];
		foreach ($array as $key => $value) {
			// 判断当前son下面的数据是否为有数据
			if (!empty($array[$key][$str]))
			{
				$newArr = $value[$str];
				// 去除当前son下面的数组，保持一维数组格式
				unset($array[$key][$str]);
				if ($level > 0 && $isStr == true)
					$array[$key][$fieldArr[0]] = '|' . str_repeat('----', $level) . $value[$fieldArr[0]];
				$list[] = $array[$key];
				//开始递归,查找父array后面去添加数组,级别则为原级别+1
				$this->arrayMoreToOne($value[$str], $fieldArr, $str, $level + 1);
			} else {
				if ($level > 0 && $isStr == true)
					$array[$key][$fieldArr[0]] = '|' . str_repeat('----', $level) . $value[$fieldArr[0]];
				$list[] = $array[$key];
			}
		}

		return $list;
	}

	/**
	 * [getArticleCate 获取文章的所属分类]
	 * @param  [type]  $cate     [分类数组]
	 * @param  [type]  $cate_id  [分类id]
	 * @param  string  $show_str [显示格式]
	 * @return [type]            [description]
	 */
	public function getArticleCate($cate, $cate_id, $show_str = '-->')
	{

		$cate_str = '';
		foreach ($cate as $k => $value) {
			if ($cate_id == $value['cate_id']) {
				if ($value['pid'] == 0)
				{
					return $value['cate_name'];
				} else {
					unset($cate[$k]);
					//开始递归,查找父array后面去添加$cate_str
					$cate_str .= $this->getArticleCate($cate, $value['pid'], $show_str) . $show_str . $value['cate_name'];
				}
			}
		}

		return $cate_str;
	}

}