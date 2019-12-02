<?php
namespace app\admin\model;

use think\Model;
use think\Request;
use think\Db;
use think\facade\Config;

/**
* 轮播图管理
*/
class Banner extends Model
{
	
	protected $table = 'banner';

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * 添加数据
	 * [addData description]
	 */
	public function addData()
	{
		$data = input();
		$res = $this->insertData([
				'img_url' => $data['img_url'],
				'img_des' => $data['img_des'],
				'link_url' => $data['link_url'],
				'author_id' => $data['author_id'],
				'sort' => $data['sort'],
				'is_show' => $data['is_show']
			]);

		if ($res)
			return ['status' => 1, 'msg' => '添加成功'];
		else
			return ['status' => 0, 'msg' => '添加失败'];
	}

	/**
	 * 修改数据
	 * [saveData description]
	 */
	public function saveData()
	{
		$data = input();
		$id = $data['id'] ? $data['id'] : '';
		unset($data['id']);
		$banner = $this->getOneData(['id' => $id], 'img_url');
		if (!$banner)
		{
			return ['status' => -1, 'msg' => '改数据不存在'];
		}

		// 如果有新的图片上传则删除旧图片
		if (!empty($banner['img_url']) && $banner['img_url'] != $data['img_url'])
		{
			$config = Config::get('blog_config');
			unlink($config['upload_url'] . $banner['img_url']);
		}
		$saveData = [
			'img_url' => $data['img_url'],
			'img_des' => $data['img_des'],
			'link_url' => $data['link_url'],
			'author_id' => $data['author_id'],
			'sort' => $data['sort'],
			'is_show' => $data['is_show']
		];
		$res = $this->updateOneData(['id' => $id], $saveData);

		return ['status' => 1, 'msg' => '修改成功'];
	}

	/**
	 * 获取所有的数据
	 * @return [getAllData] [description]
	 */
	public function getAllData($num = 0)
	{
		if ($num == 0)
			return Db::name($this->table)->order(['sort' =>'desc', 'id' => 'desc'])->select();
		else
			return Db::name($this->table)->order(['sort' =>'desc', 'id' => 'desc'])->limit($num)->select();

	}


	/**
	 * 获取单条数据
	 * @return [type] [description]
	 */
	public function getOneData($where, $fieLd = '')
	{
		if (empty($fieLd))
			return Db::name($this->table)->where($where)->find();
		else
			return Db::name($this->table)->where($where)->value($fieLd);

	}

	/**
	 * 更新数据
	 * @return [type] [description]
	 */
	public function updateOneData($where, $data)
	{	
		$result = Db::name($this->table)->where($where)->update($data);
		if ($result)
			return 1;
		else 
			return 0;
	}

	/**
	 * 添加数据
	 * @return [type] [description]
	 */
	public function insertData($data)
	{	
		return Db::name($this->table)->insertGetId($data);
	}

	/**
	 * 删除数据
	 * @return [type] [description]
	 */
	public function deleteData()
	{
		$data = input();
		// 删除之前先把图片清除
		if (!empty($data['img_url']))
		{
			$config = Config::pull('blog_config');
			unlink($config['upload_url'] . '/' . $data['img_url']);
		}

		$res = Db::name($this->table)->where(['id' => $data['id']])->delete();

		if ($res)
			return ['status' => 1, 'msg' => '删除成功'];
		else
			return ['status' => 0, 'msg' => '删除失败'];
	}
}