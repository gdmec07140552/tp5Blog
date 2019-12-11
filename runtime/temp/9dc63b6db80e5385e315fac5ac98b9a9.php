<?php /*a:4:{s:63:"D:\phpStudy\WWW\tp5Blog\application\admin\view\article\add.html";i:1575945313;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1575088278;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
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
    <div class="x-nav">
        <span class="layui-breadcrumb">
          <a><cite>首页</cite></a>
          <a><cite>文章管理</cite></a>
          <a><cite>文章列表</cite></a>
          <a><cite>添加文章</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:0px; font-size: 14px;margin-left: 10px;"  href="javascript:window.history.go(-1);" title="返回上一页"><i class="layui-icon" style="line-height:30px; font-size: 12px !important;">返回上一页</i></a>
    </div>
    <div class="x-body">
		<form class="layui-form" enctype="multipart/form-data">
			<div class="layui-form-item">
				<label for="banner_img" class="layui-form-label">
					<span class="x-red">*</span>封面图片
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
					文章标题
				</label>
				<div class="layui-input-inline" style="width: 50%;">
					<input type="text" id="link" value="" placeholder="输入文章标题" name="art_title" class="layui-input" lay-verify="required">
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<label for="subtitle" class="layui-form-label">
					副标题
				</label>
				<div class="layui-input-block" style="width: 50%;">
			     	<textarea id="subtitle" name="subtitle" lay-verify="required" placeholder="请输入内容" class="layui-textarea"></textarea>
			    </div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label" for="cate_id">文章分类</label>
				<div class="layui-input-block" style="width: 400px;">
					<select name="cate_id" id="cate_id">
						<option value="0">请选择</option>
						<?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): if( count($cate)==0 ) : echo "" ;else: foreach($cate as $key=>$list): ?>
							<option value="<?php echo htmlentities($list['cate_id']); ?>"><?php echo htmlentities($list['cate_name']); ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label for="view" class="layui-form-label">
					阅读量
				</label>
				<div class="layui-input-inline">
					<input type="text" id="view" value="8888" name="view" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label for="sort" class="layui-form-label">
					展示顺序
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
				<label class="layui-form-label" for="author_id">选择作者</label>
				<div class="layui-input-block" style="width: 400px;">
					<select name="author_id" id="author_id">
						<option value="0">请选择</option>
						<?php foreach($author as $v): ?>
							<option value="<?php echo htmlentities($v['author_id']); ?>"><?php echo htmlentities($v['author']); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">热门标签</label>
				<div class="layui-input-block">
					<input type="checkbox" name="inte_id[]" value="1" title="妹子">
					<input type="checkbox" name="inte_id[]" value="2" title="鸡汤文"> 
					<input type="checkbox" name="inte_id[]" value="3" title="趣味"> 
					<input type="checkbox" name="inte_id[]" value="4" title="户外拍摄"> 
				</div>
			 </div>
			<div class="layui-form-item layui-form-text">
				<label for="content" class="layui-form-label">
					文章内容
				</label>
				<div class="layui-input-block" style="width: 80%;">
			     	<textarea id="content" name="content" placeholder="请输入内容" class="layui-textarea"></textarea>
			    </div>
			</div>
			<input type="hidden" name="art_img" value="">
			<div class="layui-form-item">
				<label for="L_repass" class="layui-form-label">
				</label>
				<button  class="layui-btn sendForm">
					确定
				</button>
			</div>
		</form>
	</div>     
    <script>
		layui.use(['form','layer','upload','element','layedit'], function(){
			$ = layui.jquery;
		  	var form = layui.form()
		  	,layer = layui.layer;
            var lement = layui.element();//面包导航
            var layedit = layui.layedit;//富文本编辑器
            layedit.build('content');

		  	//图片上传接口
			layui.upload({
				url: '<?php echo url("Common/uploads"); ?>' //上传接口
				,success: function(res){ //上传成功后的回调
					// console.log(res);
					if (res['status'] == 1)
					{	var upload_url = "<?php echo '/static/uploads/'; ?>";
						var art_img = upload_url + res['img_url'];
						// 显示图片并记录图片地址
						$('input[name="art_img"]').val(res['img_url']);
				  		$('#LAY_demo_upload').attr('src', art_img);
					} else {
						layer.msg('图片上传失败', {icon: 5});
					}
				}
			});			

			//监听提交
			$('.sendForm').on('click', function(data){
				var art_title = $("input[name='art_title']").val();
				if (!art_title)
				{
					layer.msg('文章标题不能为空', {icon: 5});
					return false;
				}
				var subtitle = $("textarea[name='subtitle']").val();
				if (!subtitle)
				{
					layer.msg('文章副标题不能为空', {icon: 5});
					return false;
				}
				var art_img = $("input[name='art_img']").val();
				if (!art_img) {
					layer.msg('请上传图片', {icon: 5});
					return false;
				}

				// 提交数据到后台
				$.ajax({
						url: "<?php echo url('Article/ajaxAddData'); ?>",
						type: 'post',
						data: $('form').serialize(),
						success:function(res){
							if (res['status'] == 1)
							{
								layer.msg(res['msg'], {icon: 6});
								setTimeout(function(){
									window.location.href = "<?php echo url('Article/list'); ?>";
								}, 2000);
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