<?php /*a:7:{s:63:"D:\phpStudy\WWW\tp5Blog\application\index\view\index\index.html";i:1577269105;s:65:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\header.html";i:1577161773;s:62:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\css.html";i:1576289465;s:62:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\nav.html";i:1577174139;s:72:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\right_content.html";i:1577174889;s:65:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\footer.html";i:1577160329;s:69:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\javascript.html";i:1576978799;}*/ ?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="<?php echo isset($website['website_des'])?$website['website_des']:''; ?>">
	<meta name="keywords" content="<?php echo isset($website['website_keywords'])?$website['website_keywords']:''; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php echo htmlentities($title); ?></title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp"/>
	<link rel="icon" type="image/png" href="<?php echo isset($website['home_logo'])?$website['home_logo']:''; ?>">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="icon" sizes="192x192" href="<?php echo isset($website['home_logo'])?$website['home_logo']:''; ?>">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-title" content="Amaze UI"/>
	<link rel="apple-touch-icon-precomposed" href="<?php echo isset($website['home_logo'])?$website['home_logo']:''; ?>">
	<meta name="msapplication-TileImage" content="<?php echo isset($website['home_logo'])?$website['home_logo']:''; ?>">
	<meta name="msapplication-TileColor" content="#0e90d2">
	<link rel="stylesheet" href="/static/home/css/amazeui.min.css">
<link rel="stylesheet" href="/static/home/css/app.css">
</head>
<style>
    #flushPage h2 {
        font-size: 25px;
        margin-top: 10%;
        color: #999;
        text-align: center;
    }
</style>
<body id="blog" style="background: <?php echo isset($website['web_bgcolor'])?$website['web_bgcolor']:'#fff';; ?>">
<!-- nav start -->
<nav class="am-g am-g-fixed blog-fixed blog-nav">
	<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only blog-button" data-am-collapse="{target: '#blog-collapse'}" ><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

	<div class="am-collapse am-topbar-collapse" id="blog-collapse">
		<ul class="am-nav am-nav-pills am-topbar-nav">
			<li class="am-active"><a href="/">首页</a></li>
			<?php foreach($cate as $c): ?>
				<li class="am-dropdown" data-am-dropdown>
					<a class="<?php echo isset($c['son'])?'am-dropdown-toggle':''; ?>" data-am-dropdown-toggle href="<?php echo url('Index/index'); ?>/cate_id/<?php echo htmlentities($c['cate_id']); ?>">
						<?php echo htmlentities($c['cate_name']); if(isset($c['son'])): ?>
							<span class="am-icon-caret-down"></span>
						<?php endif; ?>
					</a>
					<ul class="am-dropdown-content">
						<?php if(isset($c['son'])): if(is_array($c['son']) || $c['son'] instanceof \think\Collection || $c['son'] instanceof \think\Paginator): if( count($c['son'])==0 ) : echo "" ;else: foreach($c['son'] as $key=>$v): ?>
								<li>
									<a href="<?php echo url('Index/index'); ?>/cate_id/<?php echo htmlentities($v['cate_id']); ?>"><?php echo htmlentities($v['cate_name']); ?></a>
								</li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						<?php endif; ?>
					</ul>
				</li>
			<?php endforeach; ?>
			<!-- <li><a href="lw-article.html">标准文章</a></li>
			<li><a href="lw-img.html">图片库</a></li>
			<li><a href="lw-article-fullwidth.html">全宽页面</a></li>
			<li><a href="lw-timeline.html">存档</a></li> -->
		</ul>
		<form class="am-topbar-form am-topbar-right am-form-inline" role="search">
			<div class="am-form-group">
				<input type="text" class="am-form-field am-input-sm" value="<?php echo htmlentities($keyboard); ?>" name="keyboard" placeholder="搜索内容">
			</div>
		</form>
		
	</div>
</nav>
<hr>
<!-- nav end
<!-- banner start -->
<div class="am-g am-g-fixed blog-fixed am-u-sm-centered blog-article-margin">
    <div data-am-widget="slider" class="am-slider am-slider-b1" data-am-slider='{&quot;controlNav&quot;:false}' >
    <ul class="am-slides">
    <?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): if( count($banner)==0 ) : echo "" ;else: foreach($banner as $key=>$b): ?>
      <li>
            <img src="<?php echo htmlentities($b['img_url']); ?>" art="<?php echo htmlentities($b['img_des']); ?>">
            <div class="blog-slider-desc am-slider-desc ">
                <div class="blog-text-center blog-slider-con">
                    <span><a href="" class="blog-color"><?php echo htmlentities($b['art']['author']); ?> &nbsp;</a></span>               
                    <h1 class="blog-h-margin"><a href="<?php echo url('Article/detail'); ?>/art_id/<?php echo htmlentities($b['art']['art_id']); ?>"><?php echo htmlentities($b['art']['art_title']); ?></a></h1>
                    <p><?php echo htmlentities($b['img_des']); ?></p>
                    <span class="blog-bor"><?php echo date('Y/m/d',$b['art']['create_time']); ?></span>
                    <br><br><br><br><br><br><br>                
                </div>
            </div>
      </li>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    </div>
</div>
<!-- banner end -->

<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed" id="html-content">
    <div class="am-u-md-8 am-u-sm-12">
        <div id="flushPage">
        <?php foreach($article as $k => $v): ?>
            <article class="am-g blog-entry-article">
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-img">
                    <img src="<?php echo htmlentities($v['art_img']); ?>" alt="" class="am-u-sm-12">
                </div>
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-text">
                    <span><a href="" class="blog-color"><?php echo htmlentities($v['author']); ?> &nbsp;</a></span>
                    <?php if($v['sex'] == 0): ?>
                        <span> @Beauty &nbsp;</span>
                    <?php endif; if($v['sex'] == 1): ?>
                        <span> @Scumbag &nbsp;</span>
                    <?php endif; if($v['sex'] == 2): ?>
                        <span> @Beast &nbsp;</span>
                    <?php endif; ?>
                    <span><?php echo date('Y/m/d', $v['create_time']); ?></span>
                    <h1><a href="<?php echo url('Article/detail'); ?>/art_id/<?php echo htmlentities($v['art_id']); ?>"><?php echo htmlentities($v['art_title']); ?></a></h1>
                    <p><?php echo htmlentities($v['subtitle']); ?>
                    </p>
                    <p><a href="<?php echo url('Article/detail'); ?>/art_id/<?php echo htmlentities($v['art_id']); ?>" class="blog-continue"><?php echo htmlentities($v['art_title']); ?></a></p>
                </div>
            </article>
        <?php endforeach; if(empty($article)): ?>
            <h2>数据已经加载完了</h2>
        <?php endif; ?>
        </div>
        <?php if( count($article) >= $pagesize ): ?>
            <ul class="am-pagination">
                <li class="am-pagination-prev" style="display: none;">
                    <a class="getPage page-prev" data-page_type="prev" href="javascript:;">
                        &laquo; Prev
                    </a>
                </li>
                <li class="am-pagination-next">
                    <a class="getPage page-next" data-page_type="next" href="javascript:;">
                        Next &raquo;
                    </a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
    <input type="hidden" name="cate_id" value="<?php echo htmlentities($cate_id); ?>">
    <input type="hidden" name="page" value="1">
<!-- right_content start -->
<div class="am-u-md-4 am-u-sm-12 blog-sidebar">
    <div class="blog-sidebar-widget blog-bor">
        <h2 class="blog-text-center blog-title"><span>About Me</span></h2>
        <img style=" border-radius: 100%; height: 200px; width: 200px;" src="<?php echo htmlentities($top_author['head_img']); ?>" alt="<?php echo htmlentities($top_author['author']); ?>" class="blog-entry-img" >
            <p> Admin&nbsp; &nbsp; Beauty &nbsp;</p>
        <p><?php echo htmlentities($top_author['introduction']); ?></p>
    </div>
    <div class="blog-sidebar-widget blog-bor">
        <h2 class="blog-text-center blog-title"><span>Recommend Author</span></h2>
        <img src="<?php echo htmlentities($top_author['head_img']); ?>" alt="<?php echo htmlentities($top_author['author']); ?>" class="blog-entry-img" >
        <?php if($top_author['sex'] == 0): ?>
            <p> Beauty &nbsp;</p>
        <?php endif; if($top_author['sex'] == 1): ?>
            <p> Scumbag &nbsp;</p>
        <?php endif; if($top_author['sex'] == 2): ?>
            <p> Beast &nbsp;</p>
        <?php endif; ?>
        <p><?php echo htmlentities($top_author['introduction']); ?></p>
        <p><?php echo htmlentities($top_author['content']); ?></p>
    </div>
    <div class="blog-sidebar-widget blog-bor">
        <h2 class="blog-text-center blog-title"><span>Contact ME</span></h2>
        <p>
            <a href=""><span class="am-icon-qq am-icon-fw am-primary blog-icon"></span></a>
            <a href=""><span class="am-icon-github am-icon-fw blog-icon"></span></a>
            <a href=""><span class="am-icon-weibo am-icon-fw blog-icon"></span></a>
            <a href=""><span class="am-icon-reddit am-icon-fw blog-icon"></span></a>
            <a href=""><span class="am-icon-weixin am-icon-fw blog-icon"></span></a>
        </p>
    </div>
    <div class="blog-clear-margin blog-sidebar-widget blog-bor am-g ">
        <h2 class="blog-title"><span>TAG cloud</span></h2>
        <div class="am-u-sm-12 blog-clear-padding">
        <a href="" class="blog-tag">amaze</a>
        <a href="" class="blog-tag">妹纸 UI</a>
        <a href="" class="blog-tag">HTML5</a>
        <a href="" class="blog-tag">这是标签</a>
        <a href="" class="blog-tag">Impossible</a>
        <a href="" class="blog-tag">开源前端框架</a>
        </div>
    </div>
    <div class="blog-sidebar-widget blog-bor">
        <h2 class="blog-title"><span>么么哒</span></h2>
        <ul class="am-list">
            <?php foreach($link_article as $link): ?>
                <li>
                    <a href="<?php echo url('Article/detail'); ?>/art_id/<?php echo htmlentities($link['art_id']); ?>"><?php echo htmlentities($link['art_title']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
  
</div>
<!-- riht_content end -->
    
</div>
<!-- content end -->
<footer class="blog-footer">
    <div class="am-g am-g-fixed blog-fixed am-u-sm-centered blog-footer-padding">
        <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
            <h3>Website Introduction</h3>
            <p class="am-text-sm"><?php echo isset($website['web_introduction'])?$website['web_introduction']:''; ?></p>
            <h3>Thank Word</h3>
            <p class="am-text-sm"><?php echo isset($website['thank_word'])?$website['thank_word']:''; ?></p>
        </div>
        <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
            <h3>社交账号</h3>
            <p>
                <a href=""><span class="am-icon-qq am-icon-fw am-primary blog-icon blog-icon"></span></a>
                <a href=""><span class="am-icon-github am-icon-fw blog-icon blog-icon"></span></a>
                <a href=""><span class="am-icon-weibo am-icon-fw blog-icon blog-icon"></span></a>
                <a href=""><span class="am-icon-reddit am-icon-fw blog-icon blog-icon"></span></a>
                <a href=""><span class="am-icon-weixin am-icon-fw blog-icon blog-icon"></span></a>
            </p>
            <h3>Credits</h3>
            <p><?php echo isset($website['website_gredits'])?$website['website_gredits']:''; ?></p>          
        </div>
        <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
              <h1><?php echo isset($website['website_say'])?$website['website_say']:''; ?></h1>
             <h3>Links</h3>
            <p>
                <ul>
                    <li>jQuery</li>
                    <li>Zepto.js</li>
                    <li>Seajs</li>
                    <li>LESS</li>
                    <li>...</li>
                </ul>
            </p>
        </div>
    </div>    
    <div class="blog-text-center"><?php echo isset($website['website_filing'])?$website['website_filing']:''; ?></div>    
  </footer>
</body>
</html>
<script src="/static/home/js/jquery.min.js"></script>
<script src="/static/home/js/amazeui.min.js"></script>
<script src="/static/admin/js/x-layui.js" charset="utf-8"></script>
<script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>

<!-- 获取分页数据 -->
<script>
    layui.use(['layer'], function(){
        layer = layui.layer;
    });
</script>
<script type="text/javascript">
    $(function(){
        $('.getPage').click(function(){
            // 加载图标显示
            var index = layer.load(2, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景,
            });
            var page_type  = $(this).data('page_type');
            // 获取当前页数
            var page = $("input[name='page']").val();
            if (page_type == 'prev')
                page = parseInt(page) - 1;
            else
                page = parseInt(page) + 1;
            var cate_id = $("input[name='cate_id']").val();
            var keyboard = $("input[name='keyboard']").val();
            $.post(
                "<?php echo url('Index/getPageData'); ?>",
                {page: page, cate_id:cate_id, keyboard:keyboard},
                function(data){
                    $('.am-pagination-prev').hide();
                    $('.am-pagination-next').hide();
                    // 锚点定位
                    $("html,body").animate({
                        scrollTop:$("#html-content").offset().top
                    },1000);
                    // 关闭加载
                    layer.close(index);
                    if (data['status'] == 1)
                    { 
                        var html = '';
                        // 记录当前页面页数
                        $("input[name='page']").val(page);
                        for (var i = 0; i < data['res'].length; i++) {
                            html += '<article class="am-g blog-entry-article">';
                                html += '<div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-img">';
                                    html += '<img src="'+data['res'][i]['art_img']+'" alt="" class="am-u-sm-12">';
                                html += '</div>';
                                html += '<div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-text">';
                                    html += '<span><a href="" class="blog-color">'+data['res'][i]['author']+' &nbsp;</a></span>';
                                    if (data['res'][i]['sex'] == 0)
                                        html += '<span> @Beauty &nbsp;</span>';
                                    if (data['res'][i]['sex'] == 1)
                                        html += '<span> @Scumbag &nbsp;</span>';
                                    if (data['res'][i]['sex'] == 2)
                                        html += '<span> @Beast &nbsp;</span>';
                                    html += '<span>'+data['res'][i]['create_time']+'</span>';
                                    html += '<h1><a href="<?php echo url('Article/detail'); ?>/art_id/'+data['res'][i]['art_id']+'">'+data['res'][i]['art_title']+'</a></h1>';
                                    html += '<p>'+data['res'][i]['subtitle']+'</p>';
                                    html += '<p><a href="<?php echo url('Article/detail'); ?>/art_id/'+data['res'][i]['art_id']+'" class="blog-continue">'+data['res'][i]['art_title']+'</a></p></div></article>';
                        }
                        $('#flushPage').html(html);
                        if (page > 1) {
                            $('.am-pagination-prev').show();
                        }
                        //获取分页数量
                        var pagesize = <?php echo $pagesize; ?>;
                        if (data['res'].length == pagesize) {
                            $('.am-pagination-next').show();
                        }
                    } else {
                        var html = '<h2>数据已加载完了</h2>';
                        $('#flushPage').html(html);
                        $('.am-pagination-prev').show();
                    }
                });
        });
    });
</script>