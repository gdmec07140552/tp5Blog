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
 * param: imgName 图片名称
 * param: $type 1单图片，2多图片
 * param: $type 0返回图片地址， 1返回数组
 * param: $thumb true生成缩略图 false不生成
 * param: $width 缩略图宽度
 * param: $height 缩略图高度
 * @return [array] [返回数组]
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

/**
 * 删除图片
 * param: img_url 图片地址
 * @return [type] [description]
 */
function delImage($img_url)
{
	$config = Config::pull('blog_config');
	unlink($config['upload_url'] . '/' . $img_url);
}

/**
 * [arrayStringToInt 数组中string类型转int]
 * @param  [type] $array [转换数组]
 * @return [type]        [description]
 */
function arrayStringToInt($array)
{
	// foreach ($array as $key => $value) {
	// 	$array[$key] = (int) $value;
	// }
	// return $array;
	$newArr = array_map(function($data){
		return (int) $data;
	}, $array);
	return $newArr;
}

/**
 * [redis 引入Redis缓存]
 * @return [type] [description]
 */
function redis()
{
	$redis = new \think\cache\driver\Redis();
	$redis->connect('127.0.0.1', 6379);
	$redis->auth('kansz');
	return $redis;
}

/**
 * [read_all_dir 读取目录及子目录下所有文件名]
 * @param  [type] $path [读取目录]
 * @return [type]       [description]
 */
function read_all_dir($path = '')
{
	//1、打开要操作目录的目录句柄
	$handler = opendir($path);
	$result = [];
	if ($handler)
	{
		/*其中$file= readdir($handler)每次循环时将读取的文件名赋值给$file ，$file  !== false。一定要用!==，因为如果某个文件名如果叫'0′，或某些被系统认为是代表false，用!=就会停止循环*/
		// 2、循环读取目录下的所有文件
		while( ($file = readdir($handler)) !== false )
		{
			if (!in_array($file, ['.', '..', 'Login.php', 'Base.php'])) {
				$cur_path = $path . DIRECTORY_SEPARATOR . $file;
				// 3、判断是否为目录，递归读取文件
				if (is_dir($cur_path))
				{
					$result[][$file] = read_all_dir($cur_path);
				} else {
					$result[] = basename($file, '.php');
				}
			}

		}
	}
	// 4、关闭目录
	closedir($handler);

	return $result;
}

/**
 * [ajaxGetAction 获取类里面的所有方法和两个类的方法差集]
 * @param  [type]  $controller [类名]
 * @param  boolean $isDiff     [是否返回差集]
 * @return [type]              [description]
 */
function getClassAction($controller, $isDiff = false)
{
	$contArr = get_class_methods(get_class(controller($controller)));
	// $basaeArr = get_class_methods(get_class(new Base));
	$basaeArr = get_class_methods(get_class(controller('Base')));
	$diffArr = array_diff($contArr, $basaeArr);	
	if ($isDiff == true)
		return $diffArr;
	else 
		return $contArr;
}

/**
 * [checkPhone 手机验证]
 * @param  [type] $phone [手机号]
 * @return [type]        [description]
 */
function checkPhone($phone)
{
	if (preg_match("/^1[345789]{9}\d$/", $phone))
		return true;
	else
		return false;
}

/**
* [md5Pass md5密码加密]
* @param  [type] $data [密码]
* @return [type]       [description]
*/
function md5Pass($data)
{
	// 取出配置文件中的密码前缀字符串
	$config = Config::pull('blog_config');
	return md5($config['pass_str'] . $data);
}