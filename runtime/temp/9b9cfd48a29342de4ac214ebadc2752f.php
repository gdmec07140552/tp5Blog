<?php /*a:7:{s:63:"D:\phpStudy\WWW\tp5Blog\application\index\view\index\index.html";i:1576487264;s:65:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\header.html";i:1576290265;s:62:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\css.html";i:1576289465;s:62:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\nav.html";i:1576486004;s:72:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\right_content.html";i:1576487072;s:65:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\footer.html";i:1576289507;s:69:"D:\phpStudy\WWW\tp5Blog\application\index\view\common\javascript.html";i:1576289315;}*/ ?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title><?php echo htmlentities($title); ?></title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp"/>
	<link rel="icon" type="image/png" href="/static/home/i/favicon.png">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="icon" sizes="192x192" href="/static/home/i/app-icon72x72@2x.png">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-title" content="Amaze UI"/>
	<link rel="apple-touch-icon-precomposed" href="/static/home/i/app-icon72x72@2x.png">
	<meta name="msapplication-TileImage" content="/static/home/i/app-icon72x72@2x.png">
	<meta name="msapplication-TileColor" content="#0e90d2">
	<link rel="stylesheet" href="/static/home/css/amazeui.min.css">
<link rel="stylesheet" href="/static/home/css/app.css">
</head>
<body id="blog">
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
				<input type="text" class="am-form-field am-input-sm" placeholder="搜索">
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
            <img src="/static/uploads/<?php echo htmlentities($b['img_url']); ?>" art="<?php echo htmlentities($b['img_des']); ?>">
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
<div class="am-g am-g-fixed blog-fixed">
    <div class="am-u-md-8 am-u-sm-12">
        <?php foreach($article as $k => $v): ?>
            <article class="am-g blog-entry-article">
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-img">
                    <img src="/static/uploads/<?php echo htmlentities($v['art_img']); ?>" alt="" class="am-u-sm-12">
                </div>
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-text">
                    <span><a href="" class="blog-color"><?php echo htmlentities($v['author']); ?> &nbsp;</a></span>
                    <?php if($v['sex'] == 0): ?>
                        <span> @妹子 &nbsp;</span>
                    <?php endif; if($v['sex'] == 1): ?>
                        <span> @渣男 &nbsp;</span>
                    <?php endif; if($v['sex'] == 2): ?>
                        <span> @禽兽 &nbsp;</span>
                    <?php endif; ?>
                    <span><?php echo date('Y/m/d', $v['create_time']); ?></span>
                    <h1><a href="<?php echo url('Article/detail'); ?>/art_id/<?php echo htmlentities($v['art_id']); ?>"><?php echo htmlentities($v['art_title']); ?></a></h1>
                    <p><?php echo htmlentities($v['subtitle']); ?>
                    </p>
                    <p><a href="<?php echo url('Article/detail'); ?>/art_id/<?php echo htmlentities($v['art_id']); ?>" class="blog-continue"><?php echo htmlentities($v['art_title']); ?></a></p>
                </div>
            </article>
        <?php endforeach; ?>
        <ul class="am-pagination">
            <li class="am-pagination-prev"><a href="">&laquo; Prev</a></li>
            <li class="am-pagination-next"><a href="">Next &raquo;</a></li>
        </ul>
    </div>
<!-- right_content start -->
<div class="am-u-md-4 am-u-sm-12 blog-sidebar">
    <div class="blog-sidebar-widget blog-bor">
        <h2 class="blog-text-center blog-title"><span>Recommend Author</span></h2>
        <img src="/static/uploads/<?php echo htmlentities($top_author['head_img']); ?>" alt="<?php echo htmlentities($top_author['author']); ?>" class="blog-entry-img" >
        <?php if($top_author['sex'] == 0): ?>
            <p> 妹子 &nbsp;</p>
        <?php endif; if($top_author['sex'] == 1): ?>
            <p> 渣男 &nbsp;</p>
        <?php endif; if($top_author['sex'] == 2): ?>
            <p> 禽兽 &nbsp;</p>
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
            <h3>模板简介</h3>
            <p class="am-text-sm">这是一个使用amazeUI做的简单的前端模板。<br> 博客/ 资讯类 前端模板 <br> 支持响应式，多种布局，包括主页、文章页、媒体页、分类页等<br>嗯嗯嗯，不知道说啥了。外面的世界真精彩<br><br>
            Amaze UI 使用 MIT 许可证发布，用户可以自由使用、复制、修改、合并、出版发行、散布、再授权及贩售 Amaze UI 及其副本。</p>
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
            <p>我们追求卓越，然时间、经验、能力有限。Amaze UI 有很多不足的地方，希望大家包容、不吝赐教，给我们提意见、建议。感谢你们！</p>          
        </div>
        <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
              <h1>我们站在巨人的肩膀上</h1>
             <h3>Heroes</h3>
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
    <div class="blog-text-center">© 2015 AllMobilize, Inc. Licensed under MIT license. Made with love By LWXYFER</div>    
  </footer>
</body>
</html>
<script src="/static/home/js/jquery.min.js"></script>
<script src="/static/home/js/amazeui.min.js"></script>