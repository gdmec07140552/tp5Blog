<?php /*a:4:{s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\admin\list.html";i:1577154489;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1577002293;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
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
          <a><cite>管理员列表</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><button class="layui-btn" onclick="banner_add('添加管理员','<?php echo url("Admin/add"); ?>','','')"><i class="layui-icon">&#xe608;</i>添加</button><span class="x-right" style="line-height:40px">共有数据：<?php echo count($result); ?> 条</span></xblock>
        <form>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkAll" value="0" lay-skin="primary"> 
                        </th>
                        <th>
                            管理员头像
                        </th>
                        <th>
                            管理员名
                        </th>
                        <th>
                            角色
                        </th>
                        <th>
                            手机号
                        </th>
                        <th>
                            邮箱
                        </th>
                        <th>
                            显示状态
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
                        <?php if($res['admin_id']!=1): ?>
                            <input type="checkbox" value="<?php echo htmlentities($res['admin_id'].'--'.$res['head_img']); ?>" name="id_image[]" lay-skin="primary">
                        <?php endif; ?>
                        </td>
                        <td>
                            <img style="height: 80px; width: auto;"  src="<?php echo htmlentities($res['head_img']); ?>" width="200" alt="<?php echo htmlentities($res['admin_name']); ?>">

                        </td>
                        <td>
                            <?php echo htmlentities($res['admin_name']); ?>
                        </td>
                        <td>
                            <?php if($res['admin_id']==1): ?>
                                <label style="color: #009688 !important;"><?php echo htmlentities($res['role_name']); ?></label>
                            <?php else: ?>
                                <?php echo htmlentities($res['role_name']); ?>
                            <?php endif; ?>
                        </td>
                        
                        <td>
                            <?php echo htmlentities($res['phone']); ?>
                        </td>
                        <td>
                            <?php echo htmlentities($res['email']); ?>
                        </td>
                        <td class="td-status">
                            <span style="background-color: <?php echo $res['is_show']==-1 ? '#C71D23' : '#009688'; ?>" class="layui-btn layui-btn-normal layui-btn-mini" data-admin_id="<?php echo htmlentities($res['admin_id']); ?>" data-status="<?php echo htmlentities($res['is_show']); ?>">
                                <?php echo $res['is_show']==-1 ? '隐藏' : '显示'; ?>
                            </span>
                        </td>
                        <td class="td-manage">
                            <!-- <a style="text-decoration:none" onclick="banner_stop(this,'10001')" href="javascript:;" title="不显示">
                                <i class="layui-icon">&#xe601;</i>
                            </a> -->
                            <a title="编辑管理员" href="javascript:;" onclick="banner_edit('编辑管理员','<?php echo url('Admin/edit'); ?>?admin_id=<?php echo htmlentities($res['admin_id']); ?>','4','','')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <?php if($res['admin_id']!=1): ?>
                                <a title="删除" href="javascript:;" onclick="banner_del(this, <?php echo htmlentities($res['admin_id']); ?>, '<?php echo htmlentities($res['head_img']); ?>')" 
                                style="text-decoration:none">
                                    <i class="layui-icon">&#xe640;</i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </form>
        <input type="hidden" name="totalNum" value="<?php echo count($result); ?>">
        <div id="page" style="text-align: center;"></div>
    </div>        
    <script>
        layui.use(['laydate','element','laypage','layer'], function(){
            $ = layui.jquery;//jquery
            laydate = layui.laydate;//日期插件
            lement = layui.element();//面包导航
            laypage = layui.laypage;//分页
            layer = layui.layer;//弹出层
          
            laypage({
            cont: 'page'
            ,pages: 2
            ,first: 1
            ,last: 2
            ,prev: '<em><</em>'
            ,next: '<em>></em>'
          }); 
        });

        //批量删除提交
        function delAll () {
            layer.confirm('确认要删除吗？',function(index){
                //捉到所有被选中的，发异步进行删除
                $.ajax({
                    url: "<?php echo url('Admin/ajaxDelAllData'); ?>",
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
         /*添加*/
        function banner_add(title,url,w,h){
            x_admin_show(title,url,w,h);
        }

        // 编辑
        function banner_edit (title,url,id,w,h) {
            x_admin_show(title,url,w,h); 
        }
        /*删除*/
        function banner_del(_this,id, head_img){
            layer.confirm('确认要删除吗？',function(index){
                //发异步删除数据
                $.post(
                    '<?php echo url("Admin/ajaxDeleteData"); ?>',
                    {admin_id: id, head_img: head_img},
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
            // 显示隐藏
            $('.layui-btn-mini').on('click', function(data){
                var _this = $(this);
                var status = _this.data('status');
                var admin_id = _this.data('admin_id');
                var is_show = status==0 ? '-1' : '0';
                
                $.get(
                    "<?php echo url('Admin/ajaxIsShow'); ?>/is_show/" + is_show+"/admin_id/"+admin_id,
                    function(res){
                        if (res['status'] == 1)
                        {
                            // 显示状态
                            if (status == 0)
                            {
                                _this.data('status', -1);
                                _this.css('background-color', '#C71D23');
                            } else {
                                _this.data('status', 0);
                                _this.css('background-color', '#009688');
                            }
                        } else {
                            layer.msg(res['msg'], {icon: 5});
                        }
                });
            });

            // 全选和取消
            $("input[name='checkAll']").on('click', function(data){
                var isChecked = $(this).is(':checked');
                
                $("input[name='id_image[]']").each(function(index){
                    //全选
                    isChecked == true ? $(this).prop("checked", true) : $(this).prop("checked", false);
                });
            });

        });
    </script>
    </body>
</html>