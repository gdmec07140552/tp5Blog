<?php /*a:4:{s:60:"D:\phpStudy\WWW\tp5Blog\application\admin\view\auth\add.html";i:1577003879;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1577002293;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
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
        <form class="layui-form" enctype="multipart/form-data">
            <div class="layui-form-item">
                <label for="link" class="layui-form-label">
                    权限名称
                </label>
                <div class="layui-input-inline" style="width: 300px;">
                    <input type="text" id="link" value="" name="auth_name" class="layui-input" placeholder="输入权限名称" lay-verify="required">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" for="pid">所属权限</label>
                <div class="layui-input-block" style="width: 300px;">
                    <select name="pid" id="pid">
                        <option value="0">顶级权限</option>
                        <?php foreach($auth as $v): ?>
                            <option value="<?php echo htmlentities($v['auth_id']); ?>"><?php echo htmlentities($v['auth_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>            
            <div class="layui-form-item">
                <label for="cont_name" class="layui-form-label">
                    控制器名
                </label>
                <div class="layui-input-block" style="width: 300px;">
                    <select name="cont_name" id="cont_name" lay-filter="projectfilter">
                        <option value="0">选择控制器</option>
                        <?php foreach($controller as $con): ?>
                            <option value="<?php echo htmlentities($con); ?>"><?php echo htmlentities($con); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="action_name" class="layui-form-label">
                    操作方法
                </label>
                <div class="layui-input-block" style="width: 300px;">
                    <select name="action_name" id="action_name">
                        <option value="0">选择操作方法</option>
                    </select>
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

        //select 监听获取操作方法
        form.on('select(projectfilter)',function(data){
            if (data['value'] != 0)
            {
                $.get(
                "<?php echo url('Auth/ajaxGetAction'); ?>?cont_name=" + data['value'],
                function(res){
                    // console.log(res);
                    $("#action_name").empty();
                    $("#action_name").append(new Option("选择操作方法", "0"));
                    $.each(res, function(index, item){
                        $("#action_name").append(new Option(item, item));
                    });
                    form.render('select');
                });
            } else {
                $("#action_name").empty();
                $("#action_name").append(new Option("选择操作方法", "0"));
                form.render('select');
            }
            
        });
        //监听提交
        form.on('submit(add)', function(data){
            var auth_name = $("input[name='auth_name']").val();
            if (!auth_name)
            {
                layer.msg('权限名称不能为空', {icon: 5});
                return false;
            }
            // 提交数据到后台
            var _this = parent.layer;
            $.ajax({
                url: "<?php echo url('Auth/ajaxAddData'); ?>",
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