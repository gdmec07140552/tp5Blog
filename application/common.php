<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Request;
use think\facade\Config;
use think\facade\Session;
use think\Validate;
use think\Image;

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
function uploads($imgName = '', $type = 1, $resType = 0, $thumb = false, $width = 300, $height = 300)
{
	// 单张图片上传
	if ($type == 1)
	{
		// 获取表单上传文件 例如上传了001.jpg
		$file = request()->file($imgName);
		// 移动到框架应用根目录/uploads/ 目录下
		$config = Config::pull('blog_config');
		$info = $file->validate(['size' => 1952153225, 'jpg, jpeg, png, gif'])->move($config['upload_url']);
		if ($info)
		{
			// 输出jpg
			// echo $info->getExtension();
			
			// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
			// echo $info->getSaveName();
			
			// 输出 42a79759f284b767dfcb2a0197904287.jpg
			// echo $info->getFilename();
			
			// 生成缩略图
			$thumb_url = '';
			if ($thumb == true)
			{
				$thumb_image_url = $config['upload_url'] . '/' . $info->getSaveName();
				$image = Image::open($thumb_image_url);
				// 按照原图的比例生成一个最大为300*300的缩略图并保存为thumb.png
				$thumb_url = $config['upload_url'] . '/' . date('Ymd') . '/thumb_' . $info->getFilename();
				$image->thumb($width, $height)->save($thumb_url);
				$thumb_url = date('Ymd') . '/thumb_' . $info->getFilename();
			}
			
			if ($resType == 0 )
			{
				return date('Ymd') . '/' . $info->getFilename();
			} else {
				$result = [
					'status' => 1,
					'img_url' => date('Ymd') . '/' . $info->getFilename(),
					'thumb_url' => $thumb_url
				];
				return $result;
			}
		} else {
			if ($resType == 0)
				return $info->getError();
			else
				return array('status' => -1, 'img_url' => $info->getError());
		}
	}
}
