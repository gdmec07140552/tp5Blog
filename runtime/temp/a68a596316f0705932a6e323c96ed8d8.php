<?php /*a:5:{s:63:"D:\phpStudy\WWW\tp5Blog\application\admin\view\index\index.html";i:1577265316;s:65:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\header.html";i:1577157592;s:62:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\css.html";i:1575341690;s:69:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\javascript.html";i:1575194486;s:66:"D:\phpStudy\WWW\tp5Blog\application\admin\view\common\sidebar.html";i:1576986844;}*/ ?>
	<!-- 头部文件引入 -->
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
	<body>
		<div class="layui-layout layui-layout-admin">
			<div class="layui-header header header-demo">
				<div class="layui-main">
					<a class="logo" href="<?php echo url('Index/index'); ?>"><?php echo isset($website['admin_name'])?$website['admin_name']:''; ?></a>
					<ul class="layui-nav" lay-filter="">
						<li class="layui-nav-item">
							<img src="<?php echo isset($website['admin_logo'])?$website['admin_logo']:''; ?>" class="layui-circle" style="border: 2px solid #A9B7B7;" width="35px" alt="">
						</li>
						<li class="layui-nav-item">
							<a href="javascript:;"><?php echo Session('user')['admin_name']; ?></a>
							<dl class="layui-nav-child"> <!-- 二级菜单 -->
								<dd>
									<a href="">个人信息</a>
								</dd>
								<dd>
									<a href="">切换帐号</a>
								</dd>
								<dd>
									<a href="<?php echo url('Login/logout'); ?>">退出</a>
								</dd>
							</dl>
						</li>
						<li class="layui-nav-item">
							<a href="" title="消息">
								<i class="layui-icon" style="top: 1px;">&#xe63a;</i>
							</a>
						</li>
						<li class="layui-nav-item cleanRedis">
							<a href="javascript:;"  title="清理缓存">
								<i class="layui-icon" style="top: 1px;">&#xe639;</i>
							</a>
						</li>
						<li class="layui-nav-item x-index">
							<a href="/">前台首页</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- 侧边栏文件引入 -->
			<div class="layui-side layui-bg-black x-side">
    <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree site-demo-nav" lay-filter="side">
            <li class="layui-nav-item" style="<?php echo getNav(['Banner'], 0); ?>">
                <a class="javascript:;" href="javascript:;">
                    <i class="layui-icon" style="top: 3px;">&#xe634;</i><cite>轮播管理</cite>
                </a>
                <dl class="layui-nav-child">
                    <dd class="" style="<?php echo getNav(['Banner', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="<?php echo url('Banner/list'); ?>">
                                <cite>轮播图列表</cite>
                            </a>
                        </dd>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item" style="<?php echo getNav(['Category', 'Article'], 0); ?>">
                <a class="javascript:;" href="javascript:;">
                    <i class="layui-icon" style="top: 3px;">&#xe630;</i><cite>文章管理</cite>
                </a>
                <dl class="layui-nav-child">
                    <dd class="" style="<?php echo getNav(['Category', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="<?php echo url('Category/list'); ?>">
                                <cite>分类列表</cite>
                            </a>
                        </dd>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Article', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="<?php echo url('Article/list'); ?>">
                                <cite>文章列表</cite>
                            </a>
                        </dd>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item" style="<?php echo getNav(['Author'], 0); ?>">
                <a class="javascript:;" href="javascript:;">
                    <i class="layui-icon" style="top: 3px;">&#xe630;</i><cite>作者管理</cite>
                </a>
                <dl class="layui-nav-child">
                    <dd class="" style="<?php echo getNav(['Author', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="<?php echo url('Author/list'); ?>">
                                <cite>作者列表</cite>
                            </a>
                        </dd>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item" style="<?php echo getNav(['Question'], 0); ?>">
                <a class="javascript:;" href="javascript:;">
                    <i class="layui-icon" style="top: 3px;">&#xe607;</i><cite>问题管理</cite>
                </a>
                <dl class="layui-nav-child">
                    <dd class="" style="<?php echo getNav(['Question', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="./question-list.html">
                                <cite>问题列表</cite>
                            </a>
                        </dd>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Question', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="./question-del.html">
                                <cite>删除问题</cite>
                            </a>
                        </dd>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item" style="<?php echo getNav(['Product'], 0); ?>">
                <a class="javascript:;" href="javascript:;">
                    <i class="layui-icon" style="top: 3px;">&#xe62d;</i><cite>产品管理</cite>
                </a>
                <dl class="layui-nav-child">
                    <dd class="" style="<?php echo getNav(['Product', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="./welcome.html">
                                <cite>产品列表（待开发）</cite>
                            </a>
                        </dd>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Product', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="./welcome.html">
                                <cite>品牌管理（待开发）</cite>
                            </a>
                        </dd>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Product', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="./welcome.html">
                                <cite>类型管理（待开发）</cite>
                            </a>
                        </dd>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Product', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="./welcome.html">
                                <cite>类型属性（待开发）</cite>
                            </a>
                        </dd>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Product', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="./category.html">
                                <cite>产品分类</cite>
                            </a>
                        </dd>
                    </dd>
                </dl>
            </li>
            
            <li class="layui-nav-item" style="<?php echo getNav(['Order'], 0); ?>">
                <a class="javascript:;" href="javascript:;">
                    <i class="layui-icon" style="top: 3px;">&#xe642;</i><cite>订单管理</cite>
                </a>
                <dl class="layui-nav-child">
                    <dd class="" style="<?php echo getNav(['Order', 'list'], 1); ?>">
                        <dd class="">
                            <a href="javascript:;" _href="./welcome.html">
                                <cite>订单列表（待开发）</cite>
                            </a>
                        </dd>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item"  style="<?php echo getNav(['Comment'], 0); ?>">
                <a class="javascript:;" href="javascript:;">
                    <i class="layui-icon" style="top: 3px;">&#xe606;</i><cite>评论管理</cite>
                </a>
                <dl class="layui-nav-child">
                    <dd class="" style="<?php echo getNav(['Comment', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./comment-list.html">
                            <cite>评论列表</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Comment', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./feedback-list.html">
                            <cite>意见反馈</cite>
                        </a>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item" style="<?php echo getNav(['Member'], 0); ?>">
                <a class="javascript:;" href="javascript:;">
                    <i class="layui-icon" style="top: 3px;">&#xe612;</i><cite>会员管理</cite>
                </a>
                <dl class="layui-nav-child">
                    <dd class="" style="<?php echo getNav(['Member', 'list'], 1); ?>">
                        <a href="javascript:;" _href="member-list.html">
                            <cite>会员列表</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Member', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./member-del.html">
                            <cite>删除会员</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Member', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./member-level.html">
                            <cite>等级管理</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Member', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./member-kiss.html">
                            <cite>积分管理</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Member', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./member-view.html">
                            <cite>浏览记录</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Member', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./member-view.html">
                            <cite>分享记录</cite>
                        </a>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item" style="<?php echo getNav(['Admin', 'Role', 'Auth', 'AdminLog'], 0); ?>">
                <a class="javascript:;" href="javascript:;">
                    <i class="layui-icon" style="top: 3px;">&#xe613;</i><cite>管理员管理</cite>
                </a>
                <dl class="layui-nav-child">
                    <dd class="" style="<?php echo getNav(['Admin', 'list'], 1); ?>">
                        <a href="javascript:;" _href="<?php echo url('Admin/list'); ?>">
                            <cite>管理员列表</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Role', 'list'], 1); ?>">
                        <a href="javascript:;" _href="<?php echo url('Role/list'); ?>">
                            <cite>角色管理</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['AdminCate', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./admin-cate.html">
                            <cite>权限分类</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Auth', 'list'], 1); ?>">
                        <a href="javascript:;" _href="<?php echo url('Auth/list'); ?>">
                            <cite>权限管理</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['AdminLog', 'list'], 1); ?>">
                        <a href="javascript:;" _href="<?php echo url('AdminLog/list'); ?>">
                            <cite>管理员日志</cite>
                        </a>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item" style="<?php echo getNav(['Echart'], 0); ?>">
                <a class="javascript:;" href="javascript:;">
                    <i class="layui-icon" style="top: 3px;">&#xe629;</i><cite>系统统计</cite>
                </a>
                <dl class="layui-nav-child">
                    <dd class="" style="<?php echo getNav(['Echart', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./echarts1.html">
                            <cite>拆线图</cite>
                        </a>
                    </dd>
                    <dd class="">
                        <a href="javascript:;" _href="./echarts2.html">
                            <cite>柱状图</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Echart', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./echarts3.html">
                            <cite>地图</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Echart', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./echarts4.html">
                            <cite>饼图</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Echart', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./echarts5.html">
                            <cite>雷达图</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Echart', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./echarts6.html">
                            <cite>k线图</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Echart', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./echarts7.html">
                            <cite>热力图</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Echart', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./echarts8.html">
                            <cite>仪表图</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['Echart', 'list'], 1); ?>">
                        <a href="http://echarts.baidu.com/examples.html" target="_blank" _href="./welcome.html">
                            <cite>更多案例</cite>
                        </a>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item" style="<?php echo getNav(['System','Conf'], 0); ?>">
                <a class="javascript:;" href="javascript:;">
                    <i class="layui-icon" style="top: 3px;">&#xe614;</i><cite>系统设置</cite>
                </a>
                <dl class="layui-nav-child">
                    <dd class="" style="<?php echo getNav(['Conf', 'list'], 1); ?>">
                        <a href="javascript:;" _href="<?php echo url('Conf/list'); ?>">
                            <cite>网站配置</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['System', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./sys-data.html">
                            <cite>数字字典</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['System', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./sys-shield.html">
                            <cite>屏蔽词</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['System', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./sys-log.html">
                            <cite>系统日志</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['System', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./sys-link.html">
                            <cite>友情链接</cite>
                        </a>
                    </dd>
                    <dd class="" style="<?php echo getNav(['System', 'list'], 1); ?>">
                        <a href="javascript:;" _href="./sys-qq.html">
                            <cite>第三方登录</cite>
                        </a>
                    </dd>
                </dl>
            </li>
            <li class="layui-nav-item" style="height: 30px; text-align: center">
            </li>
        </ul>
    </div>

</div>

			<div class="layui-tab layui-tab-card site-demo-title x-main" lay-filter="x-tab" lay-allowclose="true">
				<div class="x-slide_left"></div>
				<ul class="layui-tab-title">
					<li class="layui-this">
						我的桌面
						<i class="layui-icon layui-unselect layui-tab-close">ဆ</i>
					</li>
				</ul>
				<div class="layui-tab-content site-demo site-demo-body">
					<div class="layui-tab-item layui-show">
						<iframe frameborder="0" src="<?php echo url('Index/welcome'); ?>" class="x-iframe"></iframe>
					</div>
				</div>
			</div>
			<div class="site-mobile-shade">
			</div>
		</div>
		<script type="text/javascript">
			// 清理前端页面的redis缓存
			$(function(){
				layui.use(['layer'], function(){
					$ = layui.jquery;
				  	layer = layui.layer;
				});
				$('.cleanRedis').on('click', function(){
					layer.confirm('您确定要清理缓存数据吗？', {
						btn: ['确定','取消'] //按钮
					}, function(){
						layer.msg('确定', {icon: 6});
						$.get(
							"<?php echo url('Index/cleanRedis'); ?>",
							function(res){
								if (res['status'] == 1)
									layer.msg(res['msg'], {icon: 6});
								else
									layer.msg(res['msg'], {icon: 5});
							});
					});
				});
			});
		</script>
		<!-- <script>
		var _hmt = _hmt || [];
		(function() {
		  var hm = document.createElement("script");
		  hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
		  var s = document.getElementsByTagName("script")[0]; 
		  s.parentNode.insertBefore(hm, s);
		  console.log(s);
		})();
		</script> -->
	</body>
</html>