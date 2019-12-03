<?php
namespace app\admin\model;

use think\Db;
use think\Model;
use think\facade\Session;
use think\facade\Config;

/**
* 通用基类
*/
class Base extends Model
{
	
	function __construct()
	{
		parent::__construct();
	}
}