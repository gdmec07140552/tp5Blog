<?php
namespace app\admin\controller;

use think\Db;
use think\facade\Session;
/**
* 网站配置管理
*/
class Conf extends Base
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [list 网站配置列表]
	 * @return [type] [description]
	 */
	public function list()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');

		$input = input() ? input() : array();
		$result = model('Conf')->getAllData([],'', 0, ['sort' => 'desc', 'conf_id' => 'desc']);
		foreach ($result as $key => $value) {
			switch ($value['field_type']) {
				case 'input':
						$result[$key]['conf_content'] = '<input type="text" name="'.$value['conf_name'].'" required  lay-verify="required" placeholder="请输入标题" value="'.$value['conf_content'].'" class="layui-input">';
					break;
				case 'textarea':
						$result[$key]['conf_content'] = '<textarea name="'.$value['conf_name'].'" placeholder="请输入内容" class="layui-textarea">'.$value['conf_content'].'</textarea>';
					break;
				case 'radio':
						// 获取按钮的属性值
						$typeValue = explode(',', $value['field_value']);
						$str = '';
						foreach ($typeValue as $k => $val) {
							// 获取按钮的属性和值
							$attrVal = explode('-', $val);
							$str .= '<input type="radio" name="'.$value['conf_name'].'" value="'.$attrVal[1].'" title="'.$attrVal[0].'">';
							
						}
						$result[$key]['conf_content'] = $str;
					break;

				case 'image':
					$result[$key]['conf_content'] = '<img id="LAY_demo_upload" style="width: 112px; height: 80px;" src="/static/uploads/'.$value['conf_content'].'">';
					$result[$key]['conf_content'] .= '<input type="hidden" name="'.$value['conf_name'].'" value="">';
					$result[$key]['conf_content'] .= '<div class="layui-input-inline" style="margin:10px;">';
					$result[$key]['conf_content'] .= '<div class="site-demo-upbar">';
						$result[$key]['conf_content'] .= '<input type="file" name="images" class="layui-upload-file">';
					$result[$key]['conf_content'] .= '</div></div>';
					break;
				case 'checkbox':
					# code...
					break;
				default:
					# code...
					break;
			}

		}

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
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);
		$data = input('post.');

		if (empty($data['conf_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Conf')->deleteData(['conf_id' => $data['conf_id']]);
		if ($result)
		{
			// 删除成则把它的图片从本地删除
			if (!empty($input['head_img']))
				delImage($input['head_img']);
			// 管理员日志记录
			model('Base')->addLog(3, '网站配置管理', $data['conf_id']);
			return json(['status' => 1, 'msg' => '删除成功']);
		} else {
			return json(['status' => 0, 'msg' => '删除失败']);
		}
	}

	/**
	 * [ajaxSort ajax排序]
	 * @return [type] [description]
	 */
	public function ajaxSort()
	{
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		$input = input() ? input() : array();
		$result = model('Conf')->editData(['conf_id' => $input['conf_id']], ['sort' => $input['sort']]);
		// 管理员日志记录
			model('Base')->addLog(2, '网站配置管理', $input['conf_id']);
		if ($result)
			return json(['status' => 1, 'msg' => '修改成功']);
		else
			return json(['status' => 0, 'msg' => '修改失败']);
	}

	/**
	 * 文章网站配置--添加
	 * @return [type] [description]
	 */
	public function add()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');
		$input = input() ? input() : array();

		// 生成token
		$token = uniqid();
		Session::set('token', $token);
		$this->assign('token', $token);

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
		// 检查token令牌
		if (Session::get('token') != input('token'))
			return json(['status' => 0, 'msg' => '非法操作']);
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		//添加数据
		$input = input('post.');
		unset($input['images']);
		unset($input['token']);
		if (empty($input))
			return json(['status' => 0, 'msg' => '添加失败']);
		$result = model('Conf')->insertData($input);
		// 管理员日志记录
			model('Base')->addLog(1, '网站配置管理', $result);
		if ($result)
			return json(['status' => 1, 'msg' => '添加成功']);
		else
			return json(['status' => 0, 'msg' => '添加失败']);
	}

	/**
	 * 文章网站配置--编辑
	 * @return [type] [description]
	 */
	public function edit()
	{
		// 检测用户的基本权限
		if (!permission())
			return $this->redirect('index/no_permission');
		$input = input() ? input() : array();
		
		$result = model('Conf')->getOneData(['conf_id' => input('conf_id')]);
		$this->assign('result', $result);

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
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		$input = input('post.') ? input('post.') : array();
		$conf_id = $input['conf_id'];
		unset($input['conf_id']);
		unset($input['images']);
		$res = model('Conf')->getOneData(['conf_id' => $conf_id], 'head_img');
		if (!$res)
			return json(['status' => 0, 'msg' => '修改失败']);
		$result = model('Conf')->editData(['conf_id' => $conf_id], $input);		
		if ($result)
		{
			//修改成功把旧的图片删除
			if (!empty($input['head_img']) && $input['head_img'] != $res['head_img'])
				delImage($res['head_img']);
			// 管理员日志记录
			model('Base')->addLog(2, '网站配置管理', $conf_id);
			return json(['status' => 1, 'msg' => '修改成功']);
		} else {
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}
}