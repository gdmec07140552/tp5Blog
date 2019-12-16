<?php
namespace app\index\controller;

class Index extends Base
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [index 首页显示]
	 * @return [type] [description]
	 */
    public function index()
    {
    	// 获取所有轮播图数据
    	$banner = $this->getBanner();
    	$this->assign('banner', $banner);

    	// 获取多条文章
    	$article = $this->getAllArticle();
    	$this->assign('article', $article);

    	// 显示推荐作者
    	$author = $this->getAuthor();
    	$this->assign('author', $author);

    	$this->assign('title', '德玛西亚文化广场');
        return view('index');
    }

    /**
     * [getBanner 获取所有轮播图数据]
     * @return [type] [description]
     */
    public function getBanner()
    {

    	$banner = redis()->smembers('banner');
    	if (!$banner)
    	{
    		// 取出轮播图
	    	$banner = model('admin/Banner')->getAllData(0, ['is_show' => 0]);
	    	foreach ($banner as $ban) {
	    		redis()->sadd('banner', serialize($ban));
	    	}
	    	// 设置缓存一天
	    	redis()->expire('banner', 86400);
    	} else {
    		foreach ($banner as $key => $value) {
    			$banner[$key] = unserialize($value);
    		}
    	}
    	return $banner;
    }
    /**
     * [getAllArticle 获取多条文章]
     * @param  integer $start [下标开始位置]
     * @param  integer $stop  [显示多少条，-1表示所有]
     * @return [type]         [description]
     */
    public function getAllArticle($start = 0, $stop = -1)
    {
    	// 取出缓存数据
    	$article_id = redis()->lrange('article_id', 0, -1);
    	if (!$article_id)
    	{
    		//取出文章所有
	    	$article = model('admin/Article')->articleAuthor([
	    			'where' => ['m.is_show' => 0],
		    		'order' => ['m.sort' => 'desc', 'm.art_id' => 'desc']
	    		]);
	    	// 清除旧的key值
	    	redis()->del('article_id');
	    	foreach ($article as $key => $value) {
	    		// 添加文章id
	    		redis()->rpush('article_id', $value['art_id']);
	    		$article_key = 'article_' . $value['art_id'];
	    		// 清除旧的key值
	    		redis()->del($article_key);
	    		// 设置文章详细信息
	    		redis()->hmset($article_key, array(
	    				'art_id' => $value['art_id'],
	    				'art_title' => $value['art_title'],
	    				'subtitle' => $value['subtitle'],
	    				'art_img' => $value['art_img'],
	    				'author_id' => $value['author_id'],
	    				'create_time' => $value['create_time'],
	    				'cate_id' => $value['cate_id'],
	    				'inte_id' => $value['inte_id'],
	    				'view' => $value['view'],
	    				'content' => $value['content'],
	    				'author' => $value['author'],
	    				'sex' => $value['sex']
	    			));
	    		// 设置缓存一天
	    		redis()->expire($article_key, 86400);
	    	}
	    	// 设置缓存一天
	    	redis()->expire('article_id', 86400);

	    	// 获取分页数据显示
	    	if ($stop == -1)
	    	{
	    		$result[] = $value;
	    	} else {
	    		if (($key >= $start) && ($key < $stop))
	    			$result[] = $value;
	    	}
    	} else {
    		foreach($article_id as $k=> $val)
    		{
    			// 获取分页数据显示
    			if ($stop == -1)
    			{
    				$result[] = redis()->hgetall('article_' . $val);
    			} else {
    				if (($k >= $start) && ($k < $stop))
    					$result[] = redis()->hgetall('article_' . $val);
    			}
    		}
    	}

    	return $result;
    }

    /**
     * [getAuthor 首页推荐作者]
     * @return [type] [description]
     */
    public function getAuthor()
    {
    	$result = redis()->hgetall('index_top_author');
    	if (!$result)
    	{
    		$author = model('admin/Author')->getAllData(['is_show' => 0], '', 0, ['sort' => 'desc', 'author_id' => 'desc']);
	    	if ($author)
	    	{
	    		// 清除旧数据
	    		$author_key = 'index_top_author';
	    		redis()->del($author_key);
	    		redis()->del('author_id');
	    		// 保存推荐作者信息
	    		redis()->hmset($author_key, array(
	    				'author_id' => $author[0]['author_id'],
	    				'author' => $author[0]['author'],
	    				'head_img' => $author[0]['head_img'],
	    				'sex' => $author[0]['sex'],
	    				'introduction' => $author[0]['introduction'],
	    				'content' => $author[0]['content'],
	    				'create_time' => $author[0]['create_time']
	    			));
	    		// 保存所有作者信息
	    		foreach ($author as $key => $value) {
	    			// 清除旧数据
		    		$author_key = 'author_' . $value['author_id'];
		    		redis()->del($author_key);
		    		// 保存推荐作者信息
		    		redis()->lpush('author_id', $value['author_id']);
		    		redis()->hmset($author_key, array(
		    				'author_id' => $value['author_id'],
		    				'author' => $value['author'],
		    				'head_img' => $value['head_img'],
		    				'sex' => $value['sex'],
		    				'introduction' => $value['introduction'],
		    				'content' => $value['content'],
		    				'create_time' => $value['create_time']
		    			));
		    		// 设置缓存一天
		    		redis()->expire('author_id', 86400);
	    			redis()->expire($author_key, 86400);
	    		}

	    		// 设置缓存一天
	    		redis()->expire($author_key, 86400);

	    		$result = $author[0];
	    	}
    	}

    	return $result;
    }


}
