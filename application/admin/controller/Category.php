<?php
namespace app\admin\controller;

/**
* 文章分类管理
*/
class Category extends Base
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [list 分类列表]
	 * @return [type] [description]
	 */
	public function list()
	{
		$input = input() ? input() : array();

		$result = model('Category')->getAllData('', 0, ['sort' => 'desc', 'cate_id' => 'desc'] , true);
		// dump($result);
		// 打印树形数据
		$cate = model('Category')->getTree($result);

		$this->assign('cate', $cate);
		$this->assign('result' , $result);
		//引入js文件
		$this->assign('js_array', ['layui', 'x-layui']);
		return $this->fetch('list');
	}

	/**
	 * [ajaxDeleteData ajax删除数据]
	 * @return [type] [description]
	 */
	public function ajaxDeleteData()
	{
		$data = input();

		if (empty($data['cate_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Category')->deleteData(['cate_id' => $data['cate_id']]);		
		// 删除成功之后先把图片清除
		if (!empty($data['img_url']) && $result['status'] == 1)
			delImage($data['img_url']);

		return json($result);
	}

	/**
	 * [ajaxDelAllData 删除多条数据]
	 * @return [type] [description]
	 */
	public function ajaxDelAllData()
	{
		$data = input();

		if (empty($data['id_image']))
			return json(['status' => 0, 'msg' => '删除失败']);
		
		Db::startTrans();
		try {
			// 轮播id和图片地址分离
			foreach ($data['id_image'] as $key => $value) {
				$idImage = explode('--', $value);
				$result = model('Category')->deleteData(['cate_id' => $idImage['0']]);
				if (!empty($idImage[1]) && $result['status'] == 1)
					delImage($idImage[1]);

				Db::commit();
			}
		} catch (Exception $e) {
			Db::rollback();
		}
		
		return json($result);
	}

	/**
	 * [ajaxIsShow ajax显示隐藏]
	 * @return [type] [description]
	 */
	public function ajaxIsShow()
	{
		$input = input() ? input() : array();
		$result = model('Category')->updateOneData(['cate_id' => $input['cate_id']], ['is_show' => $input['is_show']]);
		if ($result)
			return json(['status' => 1, 'msg' => '修改成功']);
		else
			return json(['status' => 0, 'msg' => '修改失败']);
	}

	/**
	 * [ajaxSort ajax排序]
	 * @return [type] [description]
	 */
	public function ajaxSort()
	{
		$input = input() ? input() : array();
		$result = model('Category')->updateOneData(['cate_id' => $input['cate_id']], ['sort' => $input['sort']]);
		if ($result)
			return json(['status' => 1, 'msg' => '修改成功']);
		else
			return json(['status' => 0, 'msg' => '修改失败']);
	}

	/**
	 * 文章分类--添加
	 * @return [type] [description]
	 */
	public function add()
	{
		$input = input() ? input() : array();

		//取出所有的分类
		$cate = model('Category')->getAllData(
				'cate_id, cate_name, pid',
				0,
				['sort' => 'desc', 'cate_id' => 'desc']
			);

		$result = model('Category')->getTrees($cate);
		$this->assign('cate', $result);

		//引入js文件
		$this->assign('js_array', ['layui', 'x-layui']);
		return $this->fetch('add');
	}

	/**
	 * [ajaxAddData ajax添加数据]
	 * @return [type] [description]
	 */
	public function ajaxAddData()
	{
		//添加数据
		$input = input('post.');
		if (empty($input))
			return json(['status' => 0, 'msg' => '添加失败']);
		$result = model('Category')->insertData($input);
		if ($result)
			return json(['status' => 1, 'msg' => '添加成功']);
		else
			return json(['status' => 0, 'msg' => '添加失败']);
	}

	/**
	 * 文章分类--编辑
	 * @return [type] [description]
	 */
	public function edit()
	{
		$input = input() ? input() : array();
		
		$result = model('Category')->getOneData(['cate_id' => input('cate_id')]);
		$this->assign('result', $result);
		// 获取分类数据
		$array = model('Category')->getAllData(
				'cate_id, cate_name, pid',
				0,
				['sort' => 'desc', 'cate_id' => 'desc']
			);
		$cate = model('Category')->getTrees($array);
		$this->assign('cate', $cate);

		//引入js文件
		$this->assign('js_array', ['layui', 'x-admin']);
		return $this->fetch('edit');
	}

	/**
	 * [ajaxEidtData ajax修改数据]
	 * @return [type] [description]
	 */
	public function ajaxEidtData()
	{
		$input = input('post.') ? input('post.') : array();
		// 修改数据
		if (empty($input['cate_id']))
			return json(['status' => 0, 'msg' => '修改失败']);
		$cate_id = $input['cate_id'];
		unset($input['cate_id']);
		$result = model('Category')->editData(['cate_id' => $cate_id], $input);
		return json(['status' => 1, 'msg' => '修改成功']);
	}
}