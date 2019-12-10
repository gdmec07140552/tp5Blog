<?php
namespace app\admin\controller;

class Common extends Base
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * 图片上传
	 * patten: imgName 图片名称
	 * patten: $type 1单图片，2多图片
	 * patten: $type 0返回图片地址， 1返回数组
	 * patten: $thumb true生成缩略图 false不生成
	 * patten: $width 缩略图宽度
	 * patten: $height 缩略图高度
	 * @return [type] [description]
	 */
	public function uploads()
	{

		$result = uploads('images', 1, 1);

		return json($result);
	}
}