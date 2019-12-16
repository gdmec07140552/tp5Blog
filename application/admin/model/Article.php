<?php
namespace app\admin\model;

use think\Db;
/**
* 分类管理
*/
class Article extends Base
{	

	protected $table = 'article';
	function __construct()
	{
		parent::__construct();
		$this->table = $this->table;
	}

	/**
	 * [getDetail 获取单条文章信息]
	 * @param  [type] $where [查询条件]
	 * @return [type]        [description]
	 */
	public function getDetail($where = [])
	{

		// $sql = 'select a.* from blog_article a left join blog_author s on s.author_id=a.author_id where a.art_id=6';
		// return Db::query($sql);
		return Db::name($this->table)
		->alias('a')
		->field('a.*,s.author,s.head_img h_img,s.sex,s.introduction,s.content cont,s.create_time c_time')
		->join('blog_author s', 's.author_id = a.author_id')
		->where($where)
		->find();
	}

	/**
	 * [articleAuthor 获取多条文章信息]
	 * @param  [type] $where [条件]
	 * @return [type]        [description]
	 */
	public function articleAuthor($where)
	{
		$where['where'] = empty($where['where'])?'':$where['where'];
		$where['limit'] = empty($where['limit'])?0:$where['limit'];
		$where['order'] = empty($where['order'])?'':$where['order'];
		
		return Db::name($this->table)
				->alias('m')
				->field('m.*, s.author, s.sex')
				->join('blog_author s', 's.author_id = m.author_id')
				->where($where['where'])
				->limit($where['limit'])
				->order($where['order'])
				->select();
	}


}