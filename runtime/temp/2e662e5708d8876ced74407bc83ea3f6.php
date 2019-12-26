<?php /*a:4:{s:63:"D:\phpStudy\WWW\tp5Blog\application\admin\view\author\edit.html";i:1577155098;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1577002293;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>
            信资产
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
		<form class="layui-form">
			<div class="layui-form-item">
				<label for="banner_img" class="layui-form-label">
					<span class="x-red">*</span>作者头像
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
				<img id="LAY_demo_upload" style="width: 112px; height: 80px;" width="400" src="<?php echo htmlentities($result['head_img']); ?>">
			</div>
			<div class="layui-form-item">
				<label for="author" class="layui-form-label">
					作者名字
				</label>
				<div class="layui-input-inline">
					<input type="text" id="author" value="<?php echo htmlentities($result['author']); ?>" placeholder="请输入你的名字" name="author" class="layui-input">
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
				<label class="layui-form-label">作者性别</label>
				<div class="layui-input-block">
					 <input type="radio" name="sex" value="0" <?php echo $result['sex']==0 ? 'checked' : ''; ?> title="妹子">
					 <input type="radio" name="sex" value="1" <?php echo $result['sex']==1 ? 'checked' : ''; ?> title="渣男">
					 <input type="radio" name="sex" value="2" <?php echo $result['sex']==2 ? 'checked' : ''; ?> title="禽兽不如">
				</div>
			 </div>
			<div class="layui-form-item">
				<label class="layui-form-label">是否显示</label>
				<div class="layui-input-block">
					 <input type="radio" name="is_show" <?php echo $result['is_show']==0 ? 'checked' : ''; ?> value="0" title="显示">
					 <input type="radio" name="is_show" <?php echo $result['is_show']==-1 ? 'checked' : ''; ?> value="-1" title="隐藏">
				</div>
			 </div>
			<div class="layui-form-item layui-form-text">
				<label for="introduction" class="layui-form-label">
					个人简介
				</label>
				<div class="layui-input-block">
			     	<textarea for="introduction" name="introduction" placeholder="请输入内容" class="layui-textarea"><?php echo htmlentities($result['introduction']); ?></textarea>
			    </div>
			</div>
			<div class="layui-form-item layui-form-text">
				<label for="content" class="layui-form-label">
					个人说明
				</label>
				<div class="layui-input-block">
			     	<textarea for="content" name="content" placeholder="请输入内容" class="layui-textarea"><?php echo htmlentities($result['content']); ?></textarea>
			    </div>
			</div>
			<input type="hidden" name="head_img" value="<?php echo htmlentities($result['head_img']); ?>">
			<input type="hidden" name="author_id" value="<?php echo htmlentities($result['author_id']); ?>">
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
				// console.log(res);
				if (res['status'] == 1)
				{
					// 显示图片并记录图片地址
					$('input[name="head_img"]').val(res['img_url']);
			  		$('#LAY_demo_upload').attr('src', res['img_url']);
				} else {
					layer.msg('图片上传失败', {icon: 5});
				}
			}
		  });
		

		//监听提交
		form.on('submit(add)', function(data){
			var author = $("input[name=author]").val();
			if (!author)
			{
				layer.msg('用户名不能为空');
				return false;
			}
			var head_img = $("input[name='head_img']").val();
			if (!head_img) {
				layer.msg('请上传图片', {icon: 5});
				return false;
			}

			// 提交数据到后台
			var _this = parent.layer;
			$.ajax({
				url: "<?php echo url('Author/ajaxEidtData'); ?>",
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