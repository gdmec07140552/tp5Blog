<?php
namespace app\admin\model;


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
}