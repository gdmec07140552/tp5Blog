<?php /*a:4:{s:61:"D:\phpStudy\WWW\tp5Blog\application\admin\view\conf\list.html";i:1577094279;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1577002293;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
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
    <style>
        .layui-upload-button {
            margin-left: 10px;
        }
    </style>
    <div class="x-nav">
        <span class="layui-breadcrumb">
          <a><cite>首页</cite></a>
          <a><cite>系统设置</cite></a>
          <a><cite>网站配置</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock><button class="layui-btn" onclick="banner_add('添加网站配置','<?php echo url("Conf/add"); ?>','','')"><i class="layui-icon">&#xe608;</i>添加</button><span class="x-right" style="line-height:40px">共有数据：<?php echo count($result); ?> 条</span></xblock>
        <form class="layui-form" id="formData" enctype="multipart/form-data">
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>
                            排序
                        </th>
                        <th>
                            配置标题
                        </th>
                        <th>
                            字段名称
                        </th>
                        <th>
                            配置内容
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody id="x-img">
                    <?php foreach($result as $k => $res): ?>
                    <tr>
                        <td>
                            <input style="width: 50px;" type="text" data-conf_id="<?php echo htmlentities($res['conf_id']); ?>" value="<?php echo htmlentities($res['sort']); ?>" class="layui-input updateSort">  
                            
                        </td>
                        <td><?php echo htmlentities($res['conf_title']); ?></td>
                        <td><?php echo htmlentities($res['conf_name']); ?></td>
                        <td class="<?php echo $res['field_type']=='image' ? 'td-image' : ''; ?>" data-index="<?php echo htmlentities($res['conf_id']); ?>"><?php echo $res['html_content']; ?></td>
                        <td class="td-manage">
                            <a title="编辑网站配置" href="javascript:;" onclick="banner_edit('编辑网站配置','<?php echo url('Conf/edit'); ?>?conf_id=<?php echo htmlentities($res['conf_id']); ?>','4','','')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="banner_del(this, <?php echo htmlentities($res['conf_id']); ?>, '<?php echo htmlentities($res['conf_content']); ?>', '<?php echo htmlentities($res['field_type']); ?>')" style="text-decoration:none">
                                <i class="layui-icon">&#xe640;</i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px 0;">
                            <button  class="layui-btn saveForm">确定</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="token" value="<?php echo htmlentities($token); ?>">
        </form>
        <input type="hidden" name="totalNum" value="<?php echo count($result); ?>">
        <input type="hidden" name="td_input" value="">
    </div>   
    <script>
        layui.use(['form','laydate','element','layer','upload'], function(){
            $ = layui.jquery;//jquery
            laydate = layui.laydate;//日期插件
            lement = layui.element();//面包导航
            laypage = layui.laypage;//分页
            layer = layui.layer;//弹出层
            var form = layui.form();
            //图片上传接口
            layui.upload({
                url: '<?php echo url("Common/uploads"); ?>' //上传接口
                ,success: function(res){ //上传成功后的回调
                    
                    if (res['status'] == 1)
                    {  
                        var upload_url = "<?php echo '/static/uploads/'; ?>";
                        var head_img = upload_url + res['img_url'];
                        var index = $("input[name='td_input']").val();
                        $('.td-image').each(function(idx, _this){
                            // 显示图片并记录图片地址
                            if ($(this).data('index') == index) {
                                $(this).find('.image-input').val(res['img_url']);
                                $(this).find('img').attr('src', head_img);
                            }
                        });
                    } else {
                        layer.msg('图片上传失败', {icon: 5});
                    }
                },before:function(input){
                    var index = $(input).data('conf_id');
                    $("input[name='td_input']").val(index);
                }
            });
        });



         /*添加*/
        function banner_add(title,url,w,h){
            x_admin_show(title,url,w,h);
        }

        // 编辑
        function banner_edit (title,url,id,w,h) {
            x_admin_show(title,url,w,h); 
        }
        /*删除*/
        function banner_del(_this,id, conf_content, field_type){
            layer.confirm('确认要删除吗？',function(index){
                //发异步删除数据
                $.post(
                    '<?php echo url("Conf/ajaxDeleteData"); ?>',
                    {conf_id: id, conf_content:conf_content, field_type: field_type},
                    function(res){               
                        if (res['status'] == 1)
                        {
                            var totalNum = $("input[name='totalNum']").val();
                            var str = '共有数据：' + (totalNum-1)+' 条';
                            $("input[name='totalNum']").val(totalNum-1);
                            $('.x-right').text(str);
                            $(_this).parents("tr").remove();
                            layer.msg(res['msg'], {icon:6});
                        } else{
                            layer.msg(res['msg'], {icon: 5});
                        }
                });
            });
        }
    </script>
    <script type="text/javascript">
        $(function(){

            // 排序设置
            $('.updateSort').on('change', function(data){
                var conf_id = $(this).data('conf_id');
                var val = $(this).val();
                $.get(
                    "<?php echo url('Conf/ajaxSort'); ?>/conf_id/" + conf_id + '/sort/' + val,
                    function(res){
                        if (res['status'] == 1)
                        {
                            layer.msg(res['msg'], {icon: 6});
                            window.location.reload();
                        } else {
                            layer.msg(res['msg'], {icon: 5});
                        }
                    });
            });

            // 表单提交数据
            $('.saveForm').on('click', function(event){
                event.preventDefault();
                // 提交数据到后台
                $.ajax({
                    url: "<?php echo url('Conf/ajaxAllEditData'); ?>",
                    type: 'post',
                    data: $('#formData').serialize(),
                    success:function(res){
                        if (res['status'] == 1)
                        {
                            layer.msg(res['msg'], {icon: 6});
                            // setTimeout(function(){window.parent.location.reload();}, 2000);
                        } else {
                            layer.msg(res['msg'], {icon: 5});
                        }
                    }
                });
            });
        });
    </script>
    </body>
</html>