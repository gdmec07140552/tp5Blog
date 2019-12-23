<?php
namespace app\admin\model;

/**
* 网站配置
*/
class Conf extends Base
{
	
	protected $table = 'conf';
	function __construct()
	{
		parent::__construct();
		$this->tbale = $this->table;
	}
}