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

	/**
	 * [websiteConf 网站配置信息]
	 * @return [type] [description]
	 */
	public function websiteConf()
	{
		$conf = model('Conf')->getAllData([], 'conf_name,conf_content');
		$str = '<?php return [';
		foreach ($conf as $key => $value) {
			$str .= "'" . $value['conf_name'] . "' => '" . $value['conf_content']. "',";
		}
		$str .= '];';
		file_put_contents('../config/websiteConf.php', $str);
	}
}