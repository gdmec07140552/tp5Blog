<?php /*a:4:{s:61:"D:\phpStudy\WWW\tp5Blog\application\admin\view\conf\edit.html";i:1577157917;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1577157592;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
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
	<div class="x-body">
		<form class="layui-form" enctype="multipart/form-data">
			<div class="layui-form-item">
				<label for="conf_title" class="layui-form-label">
					配置标题
				</label>
				<div class="layui-input-inline">
					<input type="text" id="conf_title" placeholder="请输入配置标题" name="conf_title" value="<?php echo htmlentities($result['conf_title']); ?>" class="layui-input" lay-verify="required">
				</div>
				<div class="layui-input-inline">
					<span class="x-red">*</span>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="conf_name" class="layui-form-label">
					字段名称
				</label>
				<div class="layui-input-inline">
					<input type="text" id="conf_name" placeholder="请输入字段名称" name="conf_name" value="<?php echo htmlentities($result['conf_name']); ?>" class="layui-input" lay-verify="required">
				</div>
				<div class="layui-input-inline">
					<span class="x-red">*</span>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="sort" class="layui-form-label">
					展示顺序
				</label>
				<div class="layui-input-inline">
					<input type="text" id="sort" value="<?php echo htmlentities($result['sort']); ?>" name="sort" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux">
					<span class="x-red">越大排在前面最大不能超过255</span>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="conf_content" class="layui-form-label">
					配置内容
				</label>
				<div class="layui-input-block">
			     	<textarea id="conf_content" name="conf_content" placeholder="请输入字段的值" class="layui-textarea" lay-verify="required"><?php echo htmlentities($result['conf_content']); ?></textarea>
			    </div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">字段类型</label>
				<div class="layui-input-block">
					 <input type="radio" name="field_type" <?php echo $result['field_type']=='input' ? 'checked' : ''; ?> lay-filter="field_type" value="input" title="输入框">
					 <input type="radio" name="field_type" <?php echo $result['field_type']=='textarea' ? 'checked' : ''; ?> lay-filter="field_type" value="textarea" title="文本框">
					 <input type="radio" name="field_type" <?php echo $result['field_type']=='radio' ? 'checked' : ''; ?> lay-filter="field_type" value="radio" title="单选按钮">
					 <input type="radio" name="field_type" <?php echo $result['field_type']=='image' ? 'checked' : ''; ?> lay-filter="field_type" value="image" title="图片">
					 <input type="radio" name="field_type" <?php echo $result['field_type']=='checkbox' ? 'checked' : ''; ?> lay-filter="field_type" value="checkbox" title="多选框">
				</div>
			 </div>
			<div class="layui-form-item radio_checkbax" style="<?php if($result['field_type']=='input'||$result['field_type']=='textarea'||$result['field_type']=='image'){echo 'display: none;';}?>">
				<label for="field_value" class="layui-form-label">
					配置规则
				</label>
				<div class="layui-input-block">
			     	<textarea id="field_value" name="field_value" placeholder="规则说明：（单选按钮和多选框的格式：女-0,男-1）" class="layui-textarea"><?php echo htmlentities($result['field_value']); ?></textarea>
			    </div>
			</div>
			<div class="select_image" style="<?php echo $result['field_type']!='image' ? 'display :  none;':''; ?>">
				<div class="layui-form-item">
					<label for="banner_img" class="layui-form-label">
						上传图片
					</label>
					<div class="layui-input-inline">
					  <div class="site-demo-upbar">
						<input type="file" name="images" class="layui-upload-file" id="banner_img">
					  </div>
					</div>
				</div>
				<div class="layui-form-item">
					<label  class="layui-form-label">缩略图
					</label>
					<img id="LAY_demo_upload" style="width: 112px; height: 80px;" width="400" src="<?php echo $result['field_type']=='image' ? htmlentities($result['conf_content']) : ''; ?>">
				</div>
			</div>	
			<div class="layui-form-item layui-form-text">
				<label for="conf_tips" class="layui-form-label">
					配置说明
				</label>
				<div class="layui-input-block">
			     	<textarea id="conf_tips" name="conf_tips" placeholder="请输入配置说明" class="layui-textarea"><?php echo htmlentities($result['conf_tips']); ?></textarea>
			    </div>
			</div>
			<input type="hidden" name="token" value="<?php echo htmlentities($token); ?>">
			<input type="hidden" name="conf_id" value="<?php echo htmlentities($result['conf_id']); ?>">
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
		layui.use(['form','layer','upload'], function(){
			$ = layui.jquery;
		  	var form = layui.form()
		  	,layer = layui.layer;

		//图片上传接口
		layui.upload({
			url: '<?php echo url("Common/uploads"); ?>' //上传接口
			,success: function(res){ //上传成功后的回调
				if (res['status'] == 1)
				{
					// 显示图片并记录图片地址
					$('textarea[name="conf_content"]').val(res['img_url']);
			  		$('#LAY_demo_upload').attr('src', res['img_url']);
				} else {
					layer.msg('图片上传失败', {icon: 5});
				}
			}
		});

		// 图片选中显示
		form.on('radio(field_type)', function(data){
			$('.select_image').hide();
			$('.radio_checkbax').hide();
			if (data['value'] == 'image')
				$('.select_image').show();
			if (data['value'] == 'radio' || data['value'] == 'checkbox')
				$('.radio_checkbax').show();
		});
		
		  //监听提交
		form.on('submit(add)', function(data){
			// 提交数据到后台
			var _this = parent.layer;
			$.ajax({
				url: "<?php echo url('Conf/ajaxEidtData'); ?>",
				type: 'post',
				data: data['field'],
				success:function(res){
					if (res['status'] == 1)
					{
						layer.msg(res['msg'], {icon: 6});
						setTimeout(function(){window.parent.location.reload();}, 2000);
						
					} else {
						layer.msg(res['msg'], {icon: 5});
					}
				}
			});
				return false;
		  	});		  
		});
	</script>
</body>

</html>