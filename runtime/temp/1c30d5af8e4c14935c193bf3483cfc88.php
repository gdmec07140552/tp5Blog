<?php /*a:4:{s:66:"D:\phpStudy\WWW\tp5Blog\application\admin\view\admin_log\list.html";i:1576224079;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1577002293;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
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
    <div class="x-nav">
        <span class="layui-breadcrumb">
          <a><cite>首页</cite></a>
          <a><cite>管理员管理</cite></a>
          <a><cite>管理员日志列表</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><span class="x-right" style="line-height:40px">共有数据：<?php echo count($result); ?> 条</span></xblock>
        <form>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkAll" value="0" lay-skin="primary"> 
                        </th>
                        <th>
                            管理员名字
                        </th>
                        <th>
                            操作内容
                        </th>
                        <th>
                            登录ip
                        </th>
                        <th>
                            时间
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
                            <input type="checkbox" value="<?php echo htmlentities($res['log_id']); ?>" name="idArr[]" lay-skin="primary">
                        </td>
                        <td>
                            <?php echo htmlentities($res['admin_name']); ?>
                        </td>
                        <td class="td-status">
                            <?php echo htmlentities($res['log_content']); ?>
                        </td>
                        <td class="td-status">
                            <?php echo htmlentities($res['login_ip']); ?>
                        </td>
                        <td class="td-status">
                            <?php echo date('Y-m-d H:i:s', $res['create_time']); ?>
                        </td>
                        <td class="td-manage">
                            <a title="删除" href="javascript:;" onclick="banner_del(this, <?php echo htmlentities($res['log_id']); ?>)" 
                            style="text-decoration:none">
                                <i class="layui-icon">&#xe640;</i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </form>
        <input type="hidden" name="totalNum" value="<?php echo count($result); ?>">
        <div id="page" style="text-align: center;"><?php echo $result; ?></div>
    </div>        
    <script>
        layui.use(['laydate','element','laypage','layer'], function(){
            $ = layui.jquery;//jquery
            laydate = layui.laydate;//日期插件
            lement = layui.element();//面包导航
            laypage = layui.laypage;//分页
            layer = layui.layer;//弹出层

        });

        //批量删除提交
        function delAll () {
            layer.confirm('确认要删除吗？',function(index){
                //捉到所有被选中的，发异步进行删除
                $.ajax({
                    url: "<?php echo url('AdminLog/ajaxDelAllData'); ?>",
                    type: 'post',
                    data: $('form').serialize(),
                    success: function(res)
                    {
                        if (res['status'] == 1)
                        {
                            layer.msg(res['msg'], {icon: 6});
                            setTimeout(function(){window.location.reload();}, 2000);
                        } else{
                            layer.msg(res['msg'], {icon: 5});
                        }
                    }
                });
                
            });
        }
       
        /*删除*/
        function banner_del(_this,id){
            layer.confirm('确认要删除吗？',function(index){
                //发异步删除数据
                $.get(
                    '<?php echo url("AdminLog/ajaxDeleteData"); ?>/log_id/'+id,
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

            // 全选和取消
            $("input[name='checkAll']").on('click', function(data){
                var isChecked = $(this).is(':checked');
                
                $("input[name='idArr[]']").each(function(index){
                    //全选
                    isChecked == true ? $(this).prop("checked", true) : $(this).prop("checked", false);
                });
            });

        });
    </script>
    </body>
</html>