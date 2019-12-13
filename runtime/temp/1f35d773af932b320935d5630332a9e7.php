<?php /*a:4:{s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\admin\edit.html";i:1576140967;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1575088278;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
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
					<span class="x-red">*</span>管理员头像
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
				<img id="LAY_demo_upload" style="width: 112px; height: 80px;" width="400" src="/static/uploads/<?php echo htmlentities($result['head_img']); ?>">
			</div>
			<div class="layui-form-item">
                <label for="admin_name" class="layui-form-label">
                    <span class="x-red">*</span>登录名
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="admin_name" value="<?php echo htmlentities($result['admin_name']); ?>" name="admin_name" required="" lay-verify="required"
                    autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>将会成为您唯一的登入名
                </div>
            </div>
            <div class="layui-form-item">
                <label for="phone" class="layui-form-label">
                    <span class="x-red">*</span>手机
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="phone" value="<?php echo htmlentities($result['phone']); ?>" name="phone" required="" lay-verify="phone"
                    autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>将会成为您唯一的登入名
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>邮箱
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_email" name="email" value="<?php echo htmlentities($result['email']); ?>" required="" lay-verify="email"
                    autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="role" class="layui-form-label">
                    <span class="x-red">*</span>角色
                </label>
                <div class="layui-input-inline">
	                <select name="role_id">
	                    <option value="0">请选择角色</option>
	                    <?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): if( count($role)==0 ) : echo "" ;else: foreach($role as $key=>$v): ?>
	                    	<option value="<?php echo htmlentities($v['role_id']); ?>" <?php echo $v['role_id']==$result['role_id'] ? 'selected' : ''; ?>><?php echo htmlentities($v['role_name']); ?></option>
	                    <?php endforeach; endif; else: echo "" ;endif; ?>
	                 </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">
                    新密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_pass" name="admin_pass" placeholder="输入新密码" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>6到20个字符
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                    <span class="x-red">*</span>确认密码
                </label>
                <div class="layui-input-inline">
                    <input type="password" id="L_repass" name="repass" placeholder="输入确认密码" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">是否显示</label>
				<div class="layui-input-block">
					 <input type="radio" name="is_show" <?php echo $result['is_show']==0 ? 'checked' : ''; ?> value="0" title="显示">
					 <input type="radio" name="is_show" <?php echo $result['is_show']==-1 ? 'checked' : ''; ?> value="-1" title="隐藏">
				</div>
			 </div>
			<input type="hidden" name="head_img" value="<?php echo htmlentities($result['head_img']); ?>">
			<input type="hidden" name="admin_id" value="<?php echo htmlentities($result['admin_id']); ?>">
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
					var head_img = upload_url + res['img_url'];
					// 显示图片并记录图片地址
					$('input[name="head_img"]').val(res['img_url']);
			  		$('#LAY_demo_upload').attr('src', head_img);
				} else {
					layer.msg('图片上传失败', {icon: 5});
				}
			}
		});

		//监听提交
		form.on('submit(add)', function(data){
			// 提交数据到后台
			var _this = parent.layer;
			$.ajax({
				url: "<?php echo url('Admin/ajaxEidtData'); ?>",
				type: 'post',
				data: data['field'],
				success:function(res){
					if (res['status'] == 1)
					{
						// window.location.href = "<?php echo url('Admin/banner_list'); ?>";
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