<?php
namespace app\admin\model;

/**
* 管理员管理
*/
class Admin extends Base
{
	protected $table = 'admin';
	function __construct()
	{
		parent::__construct();
		$this->table = $this->table;
	}
}