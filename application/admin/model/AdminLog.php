<?php
namespace app\admin\model;

/**
* 权限管理
*/
class AdminLog extends Base
{
	
	protected $table = 'admin_log';
	function __construct()
	{
		parent::__construct();
		$this->table = $this->table;
	}
}