<?php /*a:4:{s:63:"D:\phpStudy\WWW\tp5Blog\application\admin\view\banner\list.html";i:1577155534;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1577157592;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
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
    <div class="x-nav">
        <span class="layui-breadcrumb">
          <a><cite>首页</cite></a>
          <a><cite>轮播管理</cite></a>
          <a><cite>轮播列表</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><button class="layui-btn" onclick="banner_add('添加轮播图','<?php echo url("Banner/add"); ?>','600','630')"><i class="layui-icon">&#xe608;</i>添加</button><span class="x-right" style="line-height:40px">共有数据：<?php echo count($result); ?> 条</span></xblock>
        <form>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkAll" value="0" lay-skin="primary"> 
                        </th>
                        <th>
                            排序
                        </th>
                        <th>
                            缩略图
                        </th>
                        <th>
                            链接
                        </th>
                        <th>
                            描述
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
                            <input type="checkbox" value="<?php echo htmlentities($res['banner_id'].'--'.$res['img_url']); ?>" name="id_image[]" lay-skin="primary">
                        </td>
                        <td>
                            <input style="width: 50px;" type="text" data-banner_id="<?php echo htmlentities($res['banner_id']); ?>" value="<?php echo htmlentities($res['sort']); ?>" class="layui-input">  
                            
                        </td>
                        <td>
                            <img style="height: 80px; width: auto;" src="<?php echo htmlentities($res['img_url']); ?>" width="200" alt="<?php echo htmlentities($res['img_des']); ?>">
                        </td>
                        <td >
                            <?php echo htmlentities($res['link_url']); ?>
                        </td>
                        <td >
                            <?php echo htmlentities($res['img_des']); ?>
                        </td>
                        <td class="td-status">
                            <span style="background-color: <?php echo $res['is_show']==-1 ? '#C71D23' : '#009688'; ?>" class="layui-btn layui-btn-normal layui-btn-mini" data-banner_id="<?php echo htmlentities($res['banner_id']); ?>" data-status="<?php echo htmlentities($res['is_show']); ?>">
                                <?php echo $res['is_show']==-1 ? '隐藏' : '显示'; ?>
                            </span>
                        </td>
                        <td class="td-manage">
                            <!-- <a style="text-decoration:none" onclick="banner_stop(this,'10001')" href="javascript:;" title="不显示">
                                <i class="layui-icon">&#xe601;</i>
                            </a> -->
                            <a title="编辑" href="javascript:;" onclick="banner_edit('编辑','<?php echo url('Banner/edit'); ?>?banner_id=<?php echo htmlentities($res['banner_id']); ?>','4','600','630')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="banner_del(this, <?php echo htmlentities($res['banner_id']); ?>, '<?php echo htmlentities($res['img_url']); ?>')" 
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
        <div id="page"></div>
    </div>        
    <script>
        layui.use(['laydate','element','laypage','layer'], function(){
            $ = layui.jquery;//jquery
            laydate = layui.laydate;//日期插件
            lement = layui.element();//面包导航
            laypage = layui.laypage;//分页
            layer = layui.layer;//弹出层

          //以上模块根据需要引入

            layer.ready(function(){ //为了layer.ext.js加载完毕再执行
                layer.photos({
                    photos: '#x-img'
                    ,shift: 3 //0-6的选择，指定弹出图片动画类型，默认随机
                });
            }); 
          
        });

        //批量删除提交
        function delAll () {
            layer.confirm('确认要删除吗？',function(index){
                //捉到所有被选中的，发异步进行删除
                $.ajax({
                    url: "<?php echo url('Banner/ajaxDelAllData'); ?>",
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
        function banner_edit (title,url,banner_id,w,h) {
            x_admin_show(title,url,w,h); 
        }
        /*删除*/
        function banner_del(_this,banner_id, img_url){
            layer.confirm('确认要删除吗？',function(index){
                //发异步删除数据
                $.post(
                    '<?php echo url("Banner/ajaxDeleteData"); ?>',
                    {banner_id: banner_id, img_url: img_url},
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
                var banner_id = _this.data('banner_id');
                var is_show = status==0 ? '-1' : '0';
                
                $.get(
                    "<?php echo url('Banner/ajaxIsShow'); ?>/is_show/" + is_show+"/banner_id/"+banner_id,
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

            // 排序设置
            $('.layui-input').on('change', function(data){
                var banner_id = $(this).data('banner_id');
                var val = $(this).val();
                $.get(
                    "<?php echo url('Banner/ajaxSort'); ?>/banner_id/" + banner_id + '/sort/' + val,
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
        });
    </script>
    </body>
</html>