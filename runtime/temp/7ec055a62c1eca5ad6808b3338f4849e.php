<?php /*a:4:{s:66:"D:\phpStudy\WWW\tp5Blog\application\admin\view\article\detail.html";i:1577265762;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1577157592;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo isset($website['admin_title'])?$website['admin_title']:''; ?></title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="<?php echo isset($website['admin_logo'])?$website['admin_logo']:''; ?>" type="image/x-icon" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <!-- css样式文件引入 -->
        <link rel="stylesheet" href="/static/admin/css/x-admin.css" media="all">
<!-- <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> -->
        <!-- js文件引入 -->
        <!-- 判断js文件是否需要引入 -->
<?php if (in_array('layui', $js_array)): ?>
	<script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
<?php endif; if (in_array('x-admin', $js_array)): ?>
	<script src="/static/admin/js/x-admin.js"></script>
<?php endif; if (in_array('x-layui', $js_array)): ?>
	<script src="/static/admin/js/x-layui.js" charset="utf-8"></script>
<?php endif; ?>
<script src="/static/js/jquery.min.js"></script>
    </head>
    <body>
    <div class="x-nav">
        <span class="layui-breadcrumb">
          <a><cite>首页</cite></a>
          <a><cite>文章管理</cite></a>
          <a><cite>文章列表</cite></a>
          <a><cite>文章详情</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:0px; font-size: 14px;margin-left: 10px;"  href="javascript:window.history.go(-1);" title="返回上一页"><i class="layui-icon" style="line-height:30px; font-size: 12px !important;">返回上一页</i></a>
    </div>
    <div class="x-body">
    	<form class="layui-form" enctype="multipart/form-data">
			<div class="layui-form-item">
				<label  class="layui-form-label" style="color: #009688;">文章图片：
				</label>
				<img id="LAY_demo_upload" style="width: auto; height: 200px;" width="400" src="<?php echo htmlentities($result['art_img']); ?>">
			</div>
			<div class="layui-form-item">
                <label for="author" class="layui-form-label" style="color: #009688;">
                    文章标题：
                </label>
                <div class="layui-input-inline" style="width: 80%;">
                    <label class="layui-input" style="border: none;padding-left: 0px;"><?php echo htmlentities($result['art_title']); ?></label>
                </div>
            </div>
			<div class="layui-form-item">
                <label for="author" class="layui-form-label" style="color: #009688;">
                    副标题：
                </label>
                <div class="layui-input-inline" style="width: 80%;">
                    <label class="layui-input" style="border: none;padding-left: 0px;"><?php echo htmlentities($result['subtitle']); ?></label>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="author" class="layui-form-label" style="color: #009688;">
                    文章作者：
                </label>
                <div class="layui-input-inline" style="width: 80%;">
                    <label class="layui-input" style="border: none;padding-left: 0px;"><?php echo htmlentities($result['author']); ?></label>
                </div>
            </div>	
			<div class="layui-form-item">
                <label for="author" class="layui-form-label" style="color: #009688;">
                    文章分类：
                </label>
                <div class="layui-input-inline" style="width: 80%;">
                    <label class="layui-input" style="border: none;padding-left: 0px;"><?php echo htmlentities($result['cate']); ?></label>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="author" class="layui-form-label" style="color: #009688;">
                    阅读量：
                </label>
                <div class="layui-input-inline" style="width: 80%;">
                    <label class="layui-input" style="border: none;padding-left: 0px;"><?php echo htmlentities($result['view']); ?></label>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="author" class="layui-form-label" style="color: #009688;">
                    展示顺序：
                </label>
                <div class="layui-input-inline" style="width: 80%;">
                    <label class="layui-input" style="border: none;padding-left: 0px;"><?php echo htmlentities($result['sort']); ?></label>
                </div>
            </div>		
			<div class="layui-form-item">
				<label class="layui-form-label" style="color: #009688;">是否显示：</label>
				<div class="layui-input-block">
					 <input type="radio" name="is_show" <?php echo $result['is_show']==0 ? 'checked' : ''; ?> value="0" title="显示">
					 <input type="radio" name="is_show" <?php echo $result['is_show']==-1 ? 'checked' : ''; ?> value="-1" title="隐藏">
				</div>
			 </div>
			<div class="layui-form-item">
                <label for="author" class="layui-form-label" style="color: #009688;">
                    发布时间：
                </label>
                <div class="layui-input-inline" style="width: 80%;">
                    <label class="layui-input" style="border: none;padding-left: 0px;"><?php echo date('Y-m-d H:i:s', $result['create_time']); ?></label>
                </div>
            </div>	
			<div class="layui-form-item">
				<label class="layui-form-label" style="color: #009688;">热门标签：</label>
				<div class="layui-input-block">
					<input type="checkbox" name="inte_id[]" value="1" <?php echo in_array(1, $result['inte_id'])?'checked':''; ?> title="妹子">
					<input type="checkbox" name="inte_id[]" value="2" <?php echo in_array('2', $result['inte_id'])?'checked':''; ?> title="鸡汤文"> 
					<input type="checkbox" name="inte_id[]" value="3" <?php echo in_array(3, $result['inte_id'])?'checked':''; ?> title="趣味"> 
					<input type="checkbox" name="inte_id[]" value="4" <?php echo in_array('4', $result['inte_id'])?'checked':''; ?> title="户外拍摄"> 
				</div>
			 </div>
			<div class="layui-form-item layui-form-text">
				<label for="content" class="layui-form-label">
					文章内容
				</label>
				<div class="layui-input-block" style="width: 80%;">
			     	<textarea id="content" style="display: none;" disabled class="layui-textarea"><?php echo !empty($result['content']) ? htmlentities($result['content']) : ''; ?></textarea>
			    </div>
			</div>
		</form>
	</div>     
    <script>
		layui.use(['element','layedit'], function(){
            var lement = layui.element();//面包导航
            var layedit = layui.layedit;//富文本编辑器
            var index = layedit.build('content');		  		  
		});
	</script>
</body>

</html>