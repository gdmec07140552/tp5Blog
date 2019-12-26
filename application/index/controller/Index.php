<?php
namespace app\index\controller;

use think\facade\Config;

class Index extends Base
{
    const PAGESIZE = 10; //分页数量
	function __construct()
	{
		parent::__construct();
        $this->assign('pagesize', self::PAGESIZE);
	}

	/**
	 * [index 首页显示]
	 * @return [type] [description]
	 */
    public function index()
    {
    	// 获取所有轮播图数据
    	$banner = $this->getBanner();
    	// 获取多条文章
    	$cate_id = input('cate_id') ? input('cate_id') : 0;
        $keyboard = input('keyboard') ? input('keyboard') : '';
    	if ($keyboard) {
            $where[] = ['m.is_show', 'eq', 0];
            $where[] = ['m.art_title', 'like' , '%'.$keyboard.'%'];

            $article = model('admin/Article')->articleAuthor([
                'where' => $where,
                'order' => ['m.sort' => 'desc', 'm.art_id' => 'desc'],
                'limit' => '0,' . self::PAGESIZE
            ]);
        } else {
            $article = $this->getAllArticle(0, self::PAGESIZE, $cate_id);
        }
    	$this->assign('article', $article);
        $this->assign('cate_id', $cate_id);
    	// 获取轮播图对应的文章
    	foreach ($banner as $key => $value) {
    		$banner[$key]['art'] = redis()->hgetall('article_list_' . $value['art_id']);
    	}
    	$this->assign('banner', $banner);

    	// 显示推荐作者
    	$author = $this->getAuthor();
    	$this->assign('top_author', $author);

    	// 推荐文章
    	$this->link_article($cate_id);
        $website = Config::pull('websiteConf');
    	$this->assign('title', $website['home_title']);
        return view('index');
    }

    /**
     * [getBanner 获取所有轮播图数据]
     * @return [type] [description]
     */
    public function getBanner()
    {

    	$banner_id = redis()->lrange('banner', 0, -1);
    	if (!$banner_id)
    	{
    		// 取出轮播图
	    	$banner = model('admin/Banner')->getAllData(['is_show' => 0]);

	    	foreach ($banner as $ban) {
	    		// 保存录播图缓存数据
	    		model('admin/Banner')->setRedis($ban['banner_id'], $ban);
	    	}
    	} else {
    		foreach ($banner_id as $bid) {
    			$banner[] = redis()->hgetall('banner_list_' . $bid);
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
    public function getAllArticle($start = 0, $stop = -1, $cate_id = 0)
    {
    	// 取出缓存数据
    	$article_id = redis()->lrange('article_id', 0, -1);
    	$result = [];
    	if (!$article_id)
    	{
    		// 按条件查询
    		$where['m.is_show'] = 0;
    		if ($cate_id > 0)
    			$where['m.cate_id'] = $cate_id;
	    	$article = model('admin/Article')->articleAuthor([
	    			'where' => $where,
		    		'order' => ['m.sort' => 'desc', 'm.art_id' => 'desc']
	    		]);
	    	// 获取所有文章
	    	$all_article = model('admin/Article')->articleAuthor([
	    			'where' => ['m.is_show' => 0],
		    		'order' => ['m.sort' => 'desc', 'm.art_id' => 'desc']
	    		]);

	    	foreach ($all_article as $val) {
	    		model('admin/Article')->setRedis($val['art_id'], $val);
	    	}
	    	foreach ($article as $key => $value) {
	    		// 获取分页数据显示
		    	if ($stop == -1)
		    	{
		    		$result[] = $value;
		    	} else {
		    		if (($key >= $start) && ($key < $stop))
		    			$result[] = $value;
		    	}
	    	}

	    	
    	} else {
    		// 按分类查找
    		if ($cate_id > 0)
    			$article_id = redis()->lrange('article_cate_id_' . $cate_id, 0, -1);

    		foreach($article_id as $k=> $val)
    		{
    			// 获取分页数据显示
    			if ($stop == -1)
    			{
    				$result[] = redis()->hgetall('article_list_' . $val);
    			} else {
    				if (($k >= $start) && ($k < $stop))
    					$result[] = redis()->hgetall('article_list_' . $val);
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
	    		// 保存推荐作者信息
	    		model('admin/Author')->setRedis('index_top_author', $author[0]);
	    		// 保存所有作者信息
	    		foreach ($author as $key => $value) {
	    			model('admin/Author')->setRedis($value['author_id'], $value);
	    		}

	    		$result = $author[0];
	    	}
    	}

    	return $result;
    }

    /**
     * [getPageData 获取分页数据]
     * @return [type] [description]
     */
    public function getPageData()
    {
        // 获取分页的页数
        $page = (int) input('page');
        $cate_id = input('cate_id');
        $keyboard = input('keyboard');
        $start = ($page -1) * self::PAGESIZE;
        $stop = $page * self::PAGESIZE;
        if ($keyboard)
        {
            if ($cate_id)
                $where[] = ['m.cate_id', 'eq', $cate_id];
            $where[] = ['m.art_title', 'like', '%'.$keyboard.'%'];
            $article = model('admin/Article')->articleAuthor([
                'where' => $where,
                'order' => ['m.sort' => 'desc', 'm.art_id' => 'desc'],
                'limit' => $start.','.$stop
            ]);
        } else {            
            // 取出对应的文章
            $article = $this->getAllArticle($start, $stop, $cate_id);           
        }
        if ($article) {
            foreach ($article as $key => $value) {
                $article[$key]['create_time'] = date('Y/m/d', $value['create_time']);
            }
            return json(['status' => 1, 'res' => $article]);
        } else {
            return json(['status' => 0]);
        }
    }

    


}
