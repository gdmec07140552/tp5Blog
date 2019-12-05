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
}