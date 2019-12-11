<?php /*a:4:{s:60:"D:\phpStudy\WWW\tp5Blog\application\admin\view\role\add.html";i:1575976118;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1575088278;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
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
          <a><cite>管理员管理管理</cite></a>
          <a><cite>角色列表</cite></a>
          <a><cite>添加角色</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:0px; font-size: 14px;margin-left: 10px;"  href="javascript:window.history.go(-1);" title="返回上一页"><i class="layui-icon" style="line-height:30px; font-size: 12px !important;">返回上一页</i></a>
    </div>
    <div class="x-body">
            <form action="" method="post" class="layui-form layui-form-pane">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="name" required="" lay-verify="required"
                        autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text" style="width: 80%;">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block">
                        <tbody>
                            <tr>
                                <td>
                                    用户管理
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                        <input name="id[]" type="checkbox" value="2"> 用户停用
                                        <input name="id[]" type="checkbox" value="2"> 用户删除
                                        <input name="id[]" type="checkbox" value="2"> 用户修改
                                        <input name="id[]" type="checkbox" value="2"> 用户改密
                                        <input name="id[]" type="checkbox" value="2"> 用户列表
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    文章管理
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                        <input name="id[]" type="checkbox" value="2"> 文章添加
                                        <input name="id[]" type="checkbox" value="2"> 文章删除
                                        <input name="id[]" type="checkbox" value="2"> 文章修改
                                        <input name="id[]" type="checkbox" value="2"> 文章改密
                                        <input name="id[]" type="checkbox" value="2"> 文章列表
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="layui-form-item layui-form-text" style="width: 80%;">
                    <label for="desc" class="layui-form-label">
                        描述
                    </label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" id="desc" name="desc" class="layui-textarea"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="add">增加</button>
              </div>
            </form>
        </div>    
    <script>
		layui.use(['form','layer','element'], function(){
			$ = layui.jquery;
		  	var form = layui.form()
		  	,layer = layui.layer;
            var lement = layui.element();//面包导航		

			//监听提交
			$('.sendForm').on('click', function(data){
				var art_title = $("input[name='art_title']").val();
				if (!art_title)
				{
					layer.msg('文章标题不能为空', {icon: 5});
					return false;
				}

				// 提交数据到后台
				$.ajax({
						url: "<?php echo url('Role/ajaxAddData'); ?>",
						type: 'post',
						data: $('form').serialize(),
						success:function(res){
							if (res['status'] == 1)
							{
								layer.msg(res['msg'], {icon: 6});
								setTimeout(function(){
									window.location.href = "<?php echo url('Role/list'); ?>";
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