<?php
namespace app\admin\model;


/**
* 分类管理
*/
class Author extends Base
{	

	protected $table = 'author';
	function __construct()
	{
		parent::__construct();
		$this->table = $this->table;
	}

	/**
	 * [setRedis 设置作者信息缓存]
	 * @param [type] $author_id [作者id]
	 * @param [type] $data      [缓存数据]
	 */
	public function setRedis($author_id, $data)
	{
		// 清除旧数据
		$author_key = 'author_list_' . $data['author_id'];
		// 保存所有作者信息
		redis()->lpush('author_id', $data['author_id']);
		redis()->hmset($author_key, array(
				'author_id' => $data['author_id'],
				'author' => $data['author'],
				'head_img' => $data['head_img'],
				'sex' => $data['sex'],
				'introduction' => $data['introduction'],
				'content' => $data['content'],
				'create_time' => $data['create_time']
			));
		return true;
	}
}