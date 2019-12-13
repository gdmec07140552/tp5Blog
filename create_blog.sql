CREATE TABLE IF NOT EXISTS blog_admin
(
	admin_id tinyint(4) NOT NULL AUTO_INCREMENT,
	admin_name char(20) NOT NULL DEFAULT '' COMMENT '用户名',
	admin_pass char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
	head_img varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
	is_show tinyint(1) NOT NULL DEFAULT '0' COMMENT '0代表正常，-1表示禁用',
	login_num int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
	last_time int(11) NOT NULL DEFAULT '0' COMMENT '最后的登录时间',
	last_ip char(20) NOT NULL DEFAULT '0' COMMENT '最后的登录ip',
	PRIMARY KEY (admin_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员账号' AUTO_INCREMENT=1;
alter table blog_admin ADD COLUMN phone char(20) NOT NULL DEFAULT '' COMMENT '手机号' AFTER head_img;
alter table blog_admin ADD COLUMN email char(40) NOT NULL DEFAULT '' COMMENT '邮箱' AFTER phone;
alter table blog_admin ADD COLUMN role_id smallint(6) NOT NULL DEFAULT '0' COMMENT '角色id' AFTER email;
-- 修改blog_admin表status为is_show
-- alter table blog_admin status is_show tinyint(1)
-- 默认密码：admin888
insert into blog_admin
(
	admin_name, admin_pass, head_img, status, login_num, last_time, last_ip
) values 
(
	'admin',
	'9d3d6ce1daf8ddf49216cce29ebdfcf8',
	'',
	'0',
	'1',
	'1575940628',
	'127.0.0.1'
)

CREATE TABLE IF NOT EXISTS blog_banner
(
	id smallint(6) NOT NULL AUTO_INCREMENT,
	img_url varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
	img_des varchar(255) NOT NULL DEFAULT '' COMMENT '图片描述',
	link_url varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接地址',
	author_id int(11) NOT NULL DEFAULT '0' COMMENT '作者id',
	sort tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序：越大排在前面最大不能超过255',
	is_show tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示：0正常，-1禁用',
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT="banner图" AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS blog_category
(
	cate_id int(11) NOT NULL AUTO_INCREMENT,
	cate_name char(100) NOT NULL DEFAULT '' COMMENT '分类名',
	pid int(11) NOT NULL DEFAULT '0' COMMENT '上级分类id：0代表顶级分类',
	is_show tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示：0正常，-1禁用',
	sort tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序：越大排在前面最大不能超过255',
	PRIMARY KEY (cate_id),
	INDEX idx_pid (pid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章分类' AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS blog_article
(
	art_id int(11) NOT NULL AUTO_INCREMENT,
	art_title varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题',
	subtitle varchar(255) NOT NULL DEFAULT '' COMMENT '文章副标题',
	art_img varchar(255) NOT NULL DEFAULT '' COMMENT '文章封面图',
	author_id int(11) NOT NULL DEFAULT '0' COMMENT '作者id',
	create_time int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
	cate_id int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
	inte_id char(100) NOT NULL DEFAULT '' COMMENT '热门标签',
	is_show tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示：0正常，-1禁用',
	sort tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序：越大排在前面最大不能超过255',
	view int(1) NOT NULL DEFAULT '8888' COMMENT '阅读量',
	content text NOT NULL DEFAULT '' COMMENT '文章内容',
	PRIMARY KEY (art_id),
	INDEX idx_cate_id (cate_id),
	INDEX idx_art_title (art_title),
	INDEX idx_author_id (author_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章' AUTO_INCREMENT=1;
-- ALTER TABLE blog_article ADD COLUMN subtitle varchar(255) NOT NULL DEFAULT '' COMMENT '文章副标题' AFTER art_title;

CREATE TABLE IF NOT EXISTS blog_author
(
	author_id int(11) NOT NULL AUTO_INCREMENT,
	author char(20) NOT NULL DEFAULT '' COMMENT '作者',
	head_img varchar(255) NOT NULL DEFAULT '2' COMMENT '头像',
	sex tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别：0妹子，1渣男，2禽兽',
	introduction char(100) NOT NULL DEFAULT '' COMMENT '简介',
	content varchar(255) NOT NULL DEFAULT '' COMMENT '个人说明',
	is_show tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁言：0正常，-1禁用',
	sort tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序：越大排在前面最大不能超过255',
	create_time int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
	PRIMARY KEY (author_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='作者' AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS blog_admin_log
(
	log_id int(11) NOT NULL AUTO_INCREMENT,
	type tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型：0登录，1添加，2修改，3删除',
	admin_name char(20) NOT NULL DEFAULT '' COMMENT '管理员名字',
	login_ip char(20) NOT NULL DEFAULT '' COMMENT '登录ip地址',
	log_content varchar(255) NOT NULL DEFAULT '' COMMENT '日志内容',
	create_time int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
	PRIMARY KEY (log_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT="日志文件" AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS blog_admin_auth
(
	auth_id smallint(6) NOT NULL AUTO_INCREMENT,
	auth_name char(60) NOT NULL DEFAULT '' COMMENT '权限名称',
	auth_link varchar(255) NOT NULL DEFAULT '' COMMENT '权限',
	is_show tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁言：0正常，-1禁用',
	pid smallint(6) NOT NULL DEFAULT '0' COMMENT '上级分类id：0代表顶级分类',
	sort tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序：越大排在前面最大不能超过255',
	PRIMARY KEY (auth_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限管理' AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS blog_admin_role
(
	role_id smallint(6) NOT NULL AUTO_INCREMENT,
	role_name char(40) NOT NULL DEFAULT '' COMMENT '角色名称',
	auth varchar(255) NOT NULL DEFAULT '' COMMENT '权限id',
	is_show tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁言：0正常，-1禁用',
	sort tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序：越大排在前面最大不能超过255',
	description varchar(255) NOT NULL DEFAULT '' COMMENT '角色描述',
	PRIMARY KEY (role_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT="角色管理" AUTO_INCREMENT=1;

