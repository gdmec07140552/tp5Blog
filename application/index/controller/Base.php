<?php
namespace app\index\controller;

use think\Controller;

/**
* 基础控制器
*/
class Base extends Controller
{
	
	function __construct()
	{
		parent::__construct();

		// 导航栏数据
		$this->nav();
	}

	/**
	 * [nav 导航栏数据]
	 * @return [type] [description]
	 */
	public function nav()
	{
		// 取出缓存数据
		$result = redis()->lrange('cate', 0 ,-1);
		if (!$result) {
			// 取出所有分类
			$cate = model('admin/Category')->getAllData(['is_show' => 0]);
			// 无限级分类
			$result = model('admin/Category')->getTree($cate, ['cate_name', 'cate_id'], false);

			// 保存分类信息到Redis数据库中
			foreach ($result as $key => $value) {
				// 数据缓存
				redis()->rpush('cate', serialize($value));
			}

			// 设置缓存一天
			redis()->expire('cate', 86400);
		} else {
			foreach ($result as $key => $value) {
				$result[$key] = unserialize($value);
			}
		}

		$this->assign('cate', $result);
	}
}