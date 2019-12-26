<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Config;

/**
* 通用控制器
*/
class Common extends Controller
{
	/**
     * [down 网站关闭显示页面]
     * @return [type] [description]
     */
    public function down()
    {
        // 推荐文章
        $website = Config::pull('websiteConf');
        $this->assign('title', $website['home_title']);
        if ($website['website_status'] == 0)
        	return $this->redirect('Index/index');
        else
        	return view('index/down');
    }

}