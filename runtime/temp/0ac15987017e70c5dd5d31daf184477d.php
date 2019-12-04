<?php /*a:4:{s:64:"D:\phpStudy\WWW\tp5Blog\application\admin\view\category\add.html";i:1575345998;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1575088278;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>
            德玛西亚总部
        </title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="shortcut icon" href="/static/admin/images/logo.png" type="image/x-icon" />
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
	<div class="x-body">
		<form class="layui-form" enctype="multipart/form-data">
			<div class="layui-form-item">
				<label class="layui-form-label" for="pid">所属分类</label>
				<div class="layui-input-block" style="width: 300px;">
					<select name="pid" id="pid">
						<option value="0">顶级分类</option>
						<?php foreach($cate as $v): ?>
							<option value="<?php echo htmlentities($v['cate_id']); ?>"><?php echo htmlentities($v['cate_name']); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="link" class="layui-form-label">
					分类名称
				</label>
				<div class="layui-input-inline">
					<input type="text" id="link" value="" name="cate_name" class="layui-input" lay-verify="required">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="sort" class="layui-form-label">
					分类排序
				</label>
				<div class="layui-input-inline">
					<input type="text" id="sort" value="0" name="sort" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux">
					<span class="x-red">越大排在前面最大不能超过255</span>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">是否显示</label>
				<div class="layui-input-block">
					 <input type="radio" name="is_show" checked value="0" title="显示">
					 <input type="radio" name="is_show" value="-1" title="隐藏">
				</div>
			 </div>
			
			<div class="layui-form-item">
				<label for="L_repass" class="layui-form-label">
				</label>
				<button  class="layui-btn" lay-filter="add" lay-submit="">
					确定
				</button>
			</div>
		</form>
	</div>
	<script>
		layui.use(['form','layer'], function(){
			$ = layui.jquery;
		  	var form = layui.form()
		  	,layer = layui.layer;
		

		  //监听提交
		form.on('submit(add)', function(data){
			var cate_name = $("input[name='cate_name']").val();
			if (!cate_name)
			{
				layer.msg('分类名称不能为空', {icon: 5});
				return false;
			}
			// console.log(data['field']);
			// 提交数据到后台
			var _this = parent.layer;
			$.ajax({
				url: "<?php echo url('Category/ajaxAddData'); ?>",
				type: 'post',
				data: data['field'],
				success:function(res){
					if (res['status'] == 1)
					{
						// window.location.href = "<?php echo url('Category/banner_list'); ?>";
						var index = _this.getFrameIndex(window.name);
						_this.close(index);
					} else {
						layer.msg(res['msg'], {inco: 5});
					}
				}
			});
			return false;
		  });
		  
		  
		});
	</script>
</body>

</html>