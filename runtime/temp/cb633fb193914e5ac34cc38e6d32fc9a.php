<?php /*a:4:{s:63:"D:\phpStudy\WWW\tp5Blog\application\admin\view\author\list.html";i:1577155228;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1577157592;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;}*/ ?>
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
          <a><cite>作者管理</cite></a>
          <a><cite>作者列表</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><button class="layui-btn" onclick="banner_add('添加作者','<?php echo url("Author/add"); ?>','','')"><i class="layui-icon">&#xe608;</i>添加</button><span class="x-right" style="line-height:40px">共有数据：<?php echo count($result); ?> 条</span></xblock>
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
                            头像
                        </th>
                        <th>
                            昵称
                        </th>
                        <th>
                            性别
                        </th>
                        <th>
                            详情
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
                            <input type="checkbox" value="<?php echo htmlentities($res['author_id'].'--'.$res['head_img']); ?>" name="id_image[]" lay-skin="primary">
                        </td>
                        <td>
                            <input style="width: 50px;" type="text" data-author_id="<?php echo htmlentities($res['author_id']); ?>" value="<?php echo htmlentities($res['sort']); ?>" class="layui-input">  
                            
                        </td>
                        <td>
                            <img style="height: 80px; width: auto;"  src="<?php echo htmlentities($res['head_img']); ?>" width="200" alt="<?php echo htmlentities($res['introduction']); ?>">

                        </td>
                        <td >
                            <?php echo htmlentities($res['author']); ?>
                        </td>
                        <td >
                            <?php if($res['sex']==0): ?>
                                <button type="button" style="padding: 0 10px;" class="layui-btn layui-btn-warm">妹子</button>
                            <?php elseif($res['sex']==1): ?>
                                <button type="button" style="padding: 0 10px;" class="layui-btn layui-btn-danger">渣男</button>
                            <?php else: ?>
                                <button type="button" style="padding: 0 10px;" class="layui-btn layui-btn-disabled">禽兽</button>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="javascript:;">
                                <i class="layui-icon showDetail" data-index="<?php echo htmlentities($k); ?>" style="top: 3px; font-size: 30px;">&#xe60b;</i>
                            </a>
                        </td>
                        <td class="td-status">
                            <span style="background-color: <?php echo $res['is_show']==-1 ? '#C71D23' : '#009688'; ?>" class="layui-btn layui-btn-normal layui-btn-mini" data-author_id="<?php echo htmlentities($res['author_id']); ?>" data-status="<?php echo htmlentities($res['is_show']); ?>">
                                <?php echo $res['is_show']==-1 ? '隐藏' : '显示'; ?>
                            </span>
                        </td>
                        <td class="td-manage">
                            <!-- <a style="text-decoration:none" onclick="banner_stop(this,'10001')" href="javascript:;" title="不显示">
                                <i class="layui-icon">&#xe601;</i>
                            </a> -->
                            <a title="编辑作者" href="javascript:;" onclick="banner_edit('编辑作者','<?php echo url('Author/edit'); ?>?author_id=<?php echo htmlentities($res['author_id']); ?>','4','','')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="banner_del(this, <?php echo htmlentities($res['author_id']); ?>, '<?php echo htmlentities($res['head_img']); ?>')" 
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
        <div id="page" style="text-align: center;"><?php echo $page; ?></div>
    </div>
    <script id="detialHtml" type="text/html">
        <div class="x-body">
            <form class="layui-form">
                <div class="layui-form-item">
                    <label  class="layui-form-label" style="color: #009688;">作者头像：
                    </label>
                    <img id="LAY_demo_upload" style="width: auto; height: 100px;" width="400" src="{{ d.head_img }}">
                </div>
                <div class="layui-form-item">
                    <label for="author" class="layui-form-label" style="color: #009688;">
                        作者名字：
                    </label>
                    <div class="layui-input-inline">
                        <label for="" class="layui-input" style="border: none;">{{ d.author }}</label>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="author" class="layui-form-label" style="color: #009688;">
                        展示顺序：
                    </label>
                    <div class="layui-input-inline">
                        <label for="" class="layui-input" style="border: none;">{{ d.sort }}</label>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="author" class="layui-form-label" style="color: #009688;">
                        作者性别：
                    </label>
                    <div class="layui-input-inline">
                        <label for="" class="layui-input" style="border: none;">
                        {{#  if(d.sex === 0){ }}
                            妹子
                        {{# } }}
                        {{#  if(d.sex === 1){ }}
                            渣男
                        {{# } }}
                        {{#  if(d.sex === 2){ }}
                            禽兽
                        {{# } }}
                        </label>
                    </div>
                 </div>
                <div class="layui-form-item">
                    <label for="author" class="layui-form-label" style="color: #009688;">
                        是否显示：
                    </label>
                    <div class="layui-input-inline">
                        {{#  if(d.is_show === 0){ }}
                            <label for="" class="layui-input" style="border: none;">显示</label> 
                        {{# } }}
                        
                        {{#  if(d.is_show === -1){ }}
                            <label for="" class="layui-input" style="border: none; color: #C71D23;">隐藏</label>       
                        {{# } }}
                    </div>
                 </div>
                <div class="layui-form-item layui-form-text">
                    <label for="introduction" class="layui-form-label" style="color: #009688;">
                        个人简介：
                    </label>
                    <div class="layui-input-block">
                        <textarea for="introduction" name="introduction" disabled class="layui-textarea">{{ d.introduction }}</textarea>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label for="content" class="layui-form-label" style="color: #009688;">
                        个人说明：
                    </label>
                    <div class="layui-input-block">
                        <textarea for="content" name="content" disabled class="layui-textarea">{{ d.content }}</textarea>
                    </div>
                </div>
            </form>
        </div>
    </script>        
    <script>
        layui.use(['laydate','element','laypage','layer', 'laytpl'], function(){
            $ = layui.jquery;//jquery
            laydate = layui.laydate;//日期插件
            lement = layui.element();//面包导航
            laypage = layui.laypage;//分页
            layer = layui.layer;//弹出层
            laytpl = layui.laytpl;

            //以上模块根据需要引入
            layer.ready(function(){ //为了layer.ext.js加载完毕再执行
                layer.photos({
                    photos: '#x-img'
                    ,shift: 3 //0-6的选择，指定弹出图片动画类型，默认随机
                });
            }); 
          
        });

        $('.showDetail').click(function(){
            var data = <?php echo json_encode($result?:''); ?>;
            // console.log(data);
            var index = $(this).data("index");
            var getTpl = document.getElementById('detialHtml').innerHTML;
            laytpl(getTpl).render(data[index], function(html){
                //页面层
                layer.open({
                    title: '详情',
                    type: 1,
                    shadeClose: true,
                    area: ['600px', ''], //宽高
                    content: html
                });
            });
        });

        //批量删除提交
        function delAll () {
            layer.confirm('确认要删除吗？',function(index){
                //捉到所有被选中的，发异步进行删除
                $.ajax({
                    url: "<?php echo url('Author/ajaxDelAllData'); ?>",
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
                    '<?php echo url("Author/ajaxDeleteData"); ?>',
                    {author_id: id, head_img: head_img},
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
                var author_id = _this.data('author_id');
                var is_show = status==0 ? '-1' : '0';
                
                $.get(
                    "<?php echo url('Author/ajaxIsShow'); ?>/is_show/" + is_show+"/author_id/"+author_id,
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
                var author_id = $(this).data('author_id');
                var val = $(this).val();
                $.get(
                    "<?php echo url('Author/ajaxSort'); ?>/author_id/" + author_id + '/sort/' + val,
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