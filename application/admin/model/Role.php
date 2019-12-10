<?php
namespace app\admin\model;

/**
* 角色管理
*/
class Role extends Base
{
	protected $table = 'role';
	function __construct()
	{
		parent::__construct();
		$this->table = $this->table;
	}
}