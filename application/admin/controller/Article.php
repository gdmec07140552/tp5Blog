<?php
namespace app\admin\controller;

use think\Db;
/**
* 文章管理
*/
class Article extends Base
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [list 文章列表]
	 * @return [type] [description]
	 */
	public function list()
	{
		$input = input() ? input() : array();
		$result = model('Article')->getPage([],'', 0, ['sort' => 'desc', 'art_id' => 'desc']);
		$this->assign('page' , $result);
		// 获取文章分类
		$cate = model('Category')->getAllData([], 'cate_name, cate_id, pid');
		$array = [];
		foreach ($result as $key => $value) {
			$value['cate'] = model('Category')->getArticleCate($cate, $value['cate_id']);
			$array[] = $value;
		}
		$this->assign('result' , $array);

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
		$input = input('post.');

		if (empty($input['art_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Article')->deleteData(['art_id' => $input['art_id']]);
		if ($result)
		{
			// 删除成则把它的图片从本地删除
			if (!empty($input['art_img']))
				delImage($input['art_img']);
			// 添加管理员日志
			model('Base')->addLog(3, '文章管理', $input['art_id']);
			return json(['status' => 1, 'msg' => '删除成功']);
		} else {
			return json(['status' => 0, 'msg' => '删除失败']);
		}
	}

	/**
	 * [ajaxDelAllData 删除多条数据]
	 * @return [type] [description]
	 */
	public function ajaxDelAllData()
	{
		$input = input('post.');
		if (empty($input['id_image']))
			return json(['status' => 0, 'msg' => '删除失败']);
		Db::startTrans();
		try {
			// 轮播id和图片地址分离
			foreach ($input['id_image'] as $key => $value) {
				$idImage = explode('--', $value);
				$result = model('Article')->deleteData(['art_id' => $idImage['0']]);
				if (!empty($idImage[1]) && $result)
					delImage($idImage[1]);
			}
			// 添加管理员日志
			model('Base')->addLog(3, '文章管理', $idImage['0']);
			Db::commit();
			return json(['status' => 1, 'msg' => '删除成功']);
		} catch (Exception $e) {
			Db::rollback();
			return json(['status' => 0, 'msg' => '删除失败']);
		}
	}

	/**
	 * [ajaxIsShow ajax显示隐藏]
	 * @return [type] [description]
	 */
	public function ajaxIsShow()
	{
		$input = input() ? input() : array();
		$result = model('Article')->editData(['art_id' => $input['art_id']], ['is_show' => $input['is_show']]);
		if ($result) {
			// 添加管理员日志
			model('Base')->addLog(2, '文章管理', $input['art_id']);
			return json(['status' => 1, 'msg' => '修改成功']);
		} else {
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}

	/**
	 * [ajaxSort ajax排序]
	 * @return [type] [description]
	 */
	public function ajaxSort()
	{
		$input = input() ? input() : array();
		$result = model('Article')->editData(['art_id' => $input['art_id']], ['sort' => $input['sort']]);
		if ($result) {
			// 添加管理员日志
			model('Base')->addLog(2, '文章管理', $input['art_id']);
			return json(['status' => 1, 'msg' => '修改成功']);
		} else{
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}

	/**
	 * 文章--添加
	 * @return [type] [description]
	 */
	public function add()
	{
		$input = input() ? input() : array();
		// 获取文章分类
		$cate = model('Category')->getAllData();
		$cateData = model('Category')->getTrees($cate);
		$this->assign('cate', $cateData);

		// 获取作者
		$author = model('Author')->getAllData(['is_show' => 0], 'author_id, author');
		$this->assign('author', $author);

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
		unset($input['images']);
		$input['create_time'] = time();
		// 删除文本编译器中自带的file字段
		unset($input['file']);
		// 处理热门标签
		if (!empty($input['inte_id']))
			$input['inte_id'] = implode(',', $input['inte_id']);
		if (empty($input))
			return json(['status' => 0, 'msg' => '添加失败']);
		$result = model('Article')->insertData($input);
		if ($result){
			// 添加管理员日志
			model('Base')->addLog(1, '文章管理', $result);
			return json(['status' => 1, 'msg' => '添加成功']);
		} else{
			return json(['status' => 0, 'msg' => '添加失败']);
		}
	}

	/**
	 * 文章--编辑
	 * @return [type] [description]
	 */
	public function edit()
	{
		$input = input() ? input() : array();
		
		$result = model('Article')->getOneData(['art_id' => input('art_id')]);
		// 处理热门标签
		if ($result['inte_id'])
			$result['inte_id'] = explode(',', $result['inte_id']);
		else
			$result['inte_id'] = [];
		$this->assign('result', $result);

		// 获取文章分类
		$cate = model('Category')->getAllData([]);
		$cateData = model('Category')->getTrees($cate);
		$this->assign('cate', $cateData);

		// 获取作者
		$author = model('Author')->getAllData(['is_show' => 0], 'author_id, author');
		$this->assign('author', $author);

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
		$art_id = $input['art_id'];
		unset($input['art_id']);
		unset($input['images']);
		unset($input['file']);
		// 处理热门标签
		if (!empty($input['inte_id']))
			$input['inte_id'] = implode(',', $input['inte_id']);
		$res = model('Article')->getOneData(['art_id' => $art_id], 'art_img');
		if (!$res)
			return json(['status' => 0, 'msg' => '修改失败']);
		$result = model('Article')->editData(['art_id' => $art_id], $input);
		// dump($input);die;		
		if ($result)
		{
			//修改成功把旧的图片删除
			if (!empty($input['art_img']) && $input['art_img'] != $res['art_img'])
				delImage($res['art_img']);
			// 添加管理员日志
			model('Base')->addLog(2, '文章管理', $art_id);
			return json(['status' => 1, 'msg' => '修改成功']);
		} else {
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}

	public function detail()
	{
		$input = input() ? input() : array();
		
		$result = model('Article')->getDetail(['a.art_id' => $input['art_id']]);
		// 处理热门标签
		if ($result['inte_id'])
			$result['inte_id'] = explode(',', $result['inte_id']);
		else
			$result['inte_id'] = [];

		// 获取文章分类
		$cate = model('Category')->getAllData([]);
		$result['cate'] = model('Category')->getArticleCate($cate, $result['cate_id'], '>>');

		$this->assign('result', $result);
		//引入js文件
		$this->assign('js_array', ['layui', 'x-admin']);
		return $this->fetch('detail');
	}
}