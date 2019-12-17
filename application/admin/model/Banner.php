<?php
namespace app\admin\model;

/**
* 轮播图管理
*/
class Banner extends Base
{
	
	protected $table = 'banner';

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [setRedis 设置缓存数据]
	 * @param [type] $banner_id [轮播id]
	 * @param [type] $data      [轮播数据]
	 */
	public function setRedis($banner_id, $data)
	{
		// 设置缓存数据的key
		$banner_key = 'banner_list_' . $banner_id;

		// 保存数据
		redis()->hmset($banner_key, [
				'banner_id' => $banner_id,
				'img_url' => $data['img_url'],
				'img_des' => $data['img_des'],
				'link_url' => $data['link_url'],
				'art_id' => $data['art_id'],
				'is_show' => $data['is_show']
			]);

		// 保存轮播图id		
		redis()->rpush('banner_list_id', $banner_id);

		return true;
	}

	/**
	 * [delRedis 删除缓存数据]
	 * @param  [type] $banner_id [轮播id]
	 * @return [type]            [description]
	 */
	public function delRedis($banner_id)
	{
		// 设置缓存数据的key
		$banner_key = 'banner_list_' . $banner_id;
		// 清除轮播数据列表
		redis()->delete($banner_key);
		// 清除轮播数据列表id
		redis()->delete('banner_list_id');

		return true;
	}
}