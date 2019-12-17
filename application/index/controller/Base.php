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
		} else {
			foreach ($result as $key => $value) {
				$result[$key] = unserialize($value);
			}
		}

		$this->assign('cate', $result);
	}

	/**
	 * [link_article 相似文章推荐]
	 * @return [type] [description]
	 */
	public function link_article($cate_id = 0)
	{
		$result = [];
		// 按分类查找
		if ($cate_id > 0)
			$article_id = redis()->lrange('article_cate_id_' . $cate_id, 0, 5);
		else
			$article_id = redis()->lrange('article_id', 0, 5);

		foreach($article_id as $k=> $val)
		{
			$result[] = redis()->hgetall('article_list_' . $val);
		}

		$this->assign('link_article', $result);

		return $result;
	}
}