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

	public function getDetail($where = [])
	{

		// $sql = 'select a.* from blog_article a left join blog_author s on s.author_id=a.author_id where a.art_id=6';
		// return Db::query($sql);
		return Db::name($this->table)->alias('a')->field('a.*,s.author')->join('blog_author s', 's.author_id = a.author_id')->where($where)->find();
	}
}