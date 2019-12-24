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
		// 文本类型转换成HTML表单格式
		foreach ($result as $key => $value) {
			$result[$key]['html_content'] = '<input type="hidden" name="conf_id[]" value="'.$value['conf_id'].'">';
			switch ($value['field_type']) {
				case 'input':
						$result[$key]['html_content'] .= '<input type="text" name="conf_content['.$value['conf_id'].']" required  lay-verify="required" placeholder="请输入标题" value="'.$value['conf_content'].'" class="layui-input">';
					break;
				case 'textarea':
						$result[$key]['html_content'] .= '<textarea name="conf_content['.$value['conf_id'].']" placeholder="请输入内容" class="layui-textarea">'.$value['conf_content'].'</textarea>';
					break;
				case 'radio':
						// 获取按钮的属性值
						$typeValue = explode(',', $value['field_value']);
						// 拼接HTML
						$str = '';
						foreach ($typeValue as $k => $val) {
							// 获取按钮的属性和值
							$attrVal = explode('-', $val);
							// 判断是否选中
							$checked = '';
							if ($value['conf_content'] == $attrVal[1])
								$checked = 'checked';
							$str .= '<input type="radio" name="conf_content['.$value['conf_id'].']" value="'.$attrVal[1].'" title="'.$attrVal[0].'" '.$checked.'>';
							
						}
						$result[$key]['html_content'] .= $str;
					break;

				case 'image':
					$result[$key]['html_content'] .= '<img style="width: 112px; height: 80px;" src="/static/uploads/'.$value['conf_content'].'">';
					$result[$key]['html_content'] .= '<input class="image-input" type="hidden" name="conf_content['.$value['conf_id'].']" value="'.$value['conf_content'].'">';
					$result[$key]['html_content'] .= '<input type="file" name="images" data-conf_id="'.$value['conf_id'].'" class="layui-upload-file">';
					break;
				case 'checkbox':
						$typeValue = explode(',', $value['field_value']);
						// 拼接HTML
						$str = '';						
						$checkVal = explode(',', $value['conf_content']);
						foreach ($typeValue as $k => $val) {
							$attrVal = explode('-', $val);
							// 判断是否选中
							$checked = '';
							if (in_array($attrVal[1], $checkVal))
								$checked = 'checked';
							$str .= '<input type="checkbox" name="conf_content['.$value['conf_id'].'][]" title="'.$attrVal[0].'" lay-skin="primary" '.$checked.' value="'.$attrVal[1].'" > ';
						}
						$result[$key]['html_content'] .= $str;
					break;
				default:
					# code...
					break;
			}

		}

		// 生成token
		$token = uniqid();
		Session::set('token', $token);
		$this->assign('token', $token);
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
		$input = input('post.');

		if (empty($input['conf_id']))
			return json(['status' => 0, 'msg' => '删除失败']);
		$result = model('Conf')->deleteData(['conf_id' => $input['conf_id']]);
		if ($result)
		{
			// 删除成则把它的图片从本地删除
			if (($input['conf_content'] != '') && $input['field_type'] == 'image')
				delImage($input['conf_content']);
			// 管理员日志记录
			model('Base')->addLog(3, '网站配置管理', $input['conf_id']);
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
	 * 网站配置--添加
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

		$this->websiteConf();
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
	 * 网站配置--编辑
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

		// 生成token
		$token = uniqid();
		Session::set('token', $token);
		$this->assign('token', $token);

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
		// 检查token令牌
		if (Session::get('token') != input('token'))
			return json(['status' => 0, 'msg' => '非法操作']);
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		$input = input('post.') ? input('post.') : array();
		$conf_id = $input['conf_id'];
		unset($input['conf_id']);
		unset($input['token']);
		unset($input['images']);
		$res = model('Conf')->getOneData(['conf_id' => $conf_id], 'conf_content,field_type');
		if (!$res)
			return json(['status' => 0, 'msg' => '修改失败']);
		$result = model('Conf')->editData(['conf_id' => $conf_id], $input);		
		if ($result)
		{
			//修改成功把旧的图片删除
			if (($res['field_type'] == 'image') && $input['conf_content'] != $res['conf_content'])
				delImage($res['conf_content']);
			// 管理员日志记录
			model('Base')->addLog(2, '网站配置管理', $conf_id);
			return json(['status' => 1, 'msg' => '修改成功']);
		} else {
			return json(['status' => 0, 'msg' => '修改失败']);
		}
	}

	/**
	 * [ajaxAllEditData 批量修改网站配置内容]
	 * @return [type] [description]
	 */
	public function ajaxAllEditData()
	{
		// 检查token令牌
		if (Session::get('token') != input('token'))
			return json(['status' => 0, 'msg' => '非法操作']);
		// 检测用户的基本权限
		if (!permission())
			return json(['status' => 0, 'msg' => '无权限操作']);

		$input = input('post.');
		// 处理配置信息
		Db::startTrans();
		try {
			$conf_content = $input['conf_content'];			
			foreach ($input['conf_id'] as $key => $value) {
				// 判断是否是CheckBox信息
				$data['conf_content'] = $conf_content[$value];
				if (is_array($conf_content[$value]))
					$data['conf_content'] = implode(',', $conf_content[$value]);
				$result = model('Conf')->editData(['conf_id' => $value], $data);
				// 管理员日志记录
				model('Base')->addLog(2, '网站配置管理', $value);	
			}
			Db::commit();
			return json(['status' => 1, 'msg' => '修改成功']);
		} catch (Exception $e) {
			Db::rollback();
			return json(['status' => 0, 'msg' => '修改失败']);
		}
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
		file_put_contents('./blog_conf', $str);
	}
}