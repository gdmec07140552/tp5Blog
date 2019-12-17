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
		->field('a.*,s.author,s.head_img,s.sex,s.introduction,s.content cont,s.create_time c_time')
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
				->field('m.*, s.author,s.head_img,s.sex,s.introduction,s.content cont,s.create_time c_time')
				->join('blog_author s', 's.author_id = m.author_id')
				->where($where['where'])
				->limit($where['limit'])
				->order($where['order'])
				->select();
	}

	/**
	 * [setRedis 设置文章数据缓存]
	 * @param [type] $art_id [文章id]
	 * @param [type] $data   [缓存数据]
	 */
	public function setRedis($art_id, $data)
	{
		$article_key = 'article_list_' . $data['art_id'];
		// 添加文章id
	    redis()->rpush('article_id', $data['art_id']);
	    // 记录文章分类
	    redis()->rpush('article_cate_id_' . $data['cate_id'], $data['art_id']);

		// 设置文章详细信息
		redis()->hmset($article_key, array(
				'art_id' => $data['art_id'],
				'art_title' => $data['art_title'],
				'subtitle' => $data['subtitle'],
				'art_img' => $data['art_img'],
				'author_id' => $data['author_id'],
				'create_time' => $data['create_time'],
				'cate_id' => $data['cate_id'],
				'inte_id' => $data['inte_id'],
				'view' => $data['view'],
				'content' => $data['content'],
				'author' => $data['author'],
				'sex' => $data['sex'],
				'head_img' => $data['head_img'],
				'introduction' => $data['introduction'],
				'cont' => $data['cont'],
				'c_time' => $data['c_time'],
			));

		return true;
	}


}