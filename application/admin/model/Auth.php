<?php
namespace app\admin\model;

/**
* 权限管理
*/
class Auth extends Base
{
	
	protected $table = 'admin_auth';
	function __construct()
	{
		parent::__construct();
		$this->table = $this->table;
	}
}