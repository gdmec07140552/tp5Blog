<?php /*a:4:{s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\banner\add.html";i:1576460053;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1575088278;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
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
				<label for="banner_img" class="layui-form-label">
					<span class="x-red">*</span>轮播图
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
				<img id="LAY_demo_upload" style="width: 112px; height: 80px;" width="400" src="">
			</div>
			<div class="layui-form-item">
				<label for="link" class="layui-form-label">
					链接地址
				</label>
				<div class="layui-input-inline">
					<input type="text" id="link" value="<?php echo url('index'); ?>" name="link_url" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="sort" class="layui-form-label">
					展示排序
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
				<label class="layui-form-label" for="art_id">选择文章</label>
				<div class="layui-input-block">
					<select name="art_id" id="art_id" lay-verify="required">
						<option value="0">请选择文章</option>
						<?php if(is_array($article) || $article instanceof \think\Collection || $article instanceof \think\Paginator): if( count($article)==0 ) : echo "" ;else: foreach($article as $key=>$art): ?>
							<option value="<?php echo htmlentities($art['art_id']); ?>"><?php echo htmlentities($art['art_title']); ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<label for="img_des" class="layui-form-label">
					图片描述
				</label>
				<div class="layui-input-block">
			     	<textarea for="img_des" name="img_des" placeholder="请输入内容" class="layui-textarea"></textarea>
			    </div>
			</div>
			<input type="hidden" name="img_url" value="">
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
				{	var upload_url = "<?php echo '/static/uploads/'; ?>";
					var img_url = upload_url + res['img_url'];
					// 显示图片并记录图片地址
					$('input[name="img_url"]').val(res['img_url']);
			  		$('#LAY_demo_upload').attr('src', img_url);
				} else {
					layer.msg('图片上传失败', {icon: 5});
				}
			}
		});
		

		  //监听提交
		form.on('submit(add)', function(data){
			// console.log(data['field']);
			// var images = $("#banner_img")[0].files[0];
			var img_url = $("input[name='img_url']").val();
			if (!img_url) {
				layer.msg('请上传图片', {icon: 5});
				return false;
			}

			// 提交数据到后台
			var _this = parent.layer;
			$.ajax({
				url: "<?php echo url('Banner/ajaxAddData'); ?>",
				type: 'post',
				data: data['field'],
				success:function(res){
					if (res['status'] == 1)
					{
						// window.location.href = "<?php echo url('Banner/banner_list'); ?>";
						var index = _this.getFrameIndex(window.name);
						_this.close(index);
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