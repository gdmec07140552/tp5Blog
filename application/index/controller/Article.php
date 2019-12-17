<?php
namespace app\index\controller;

use think\Request;

/**
 * 文章详情
 */
class Article extends Base
{
	function __construct()
	{
		parent::__construct();
	}

	public function detail()
	{
		$art_id = input('art_id');
		//取出缓存数据
		$article = redis()->hgetall('article_' . $art_id);
		if (!$article)
		{
			// 获取文章信息
			$article = $this->getArticle($art_id);
		}
		$this->assign('result', $article);

		// 显示推荐作者
    	$top_author = controller('Index')->getAuthor();
    	$this->assign('top_author', $top_author);

    	// 推荐文章
    	$this->link_article($article['cate_id']);

		$this->assign('title', $article['art_title']);
		return view();
	}

	/**
	 * [getArticle 获取文章信息并保存到Redis]
	 * @param  [type] $art_id [description]
	 * @return [type]         [description]
	 */
	public function getArticle($art_id)
	{
		$article = redis()->hgetall('article_list_' . $art_id);
		if (!$article)
		{
			$article = model('admin/Article')->getDetail(['a.art_id' => $art_id]);
			if ($article)
			{
				// 设置文章详细信息
				model('admin/Article')->setRedis($article['art_id'], $article);

	    		//判断作者的信息是否存在
	    		if (!redis()->exists('author_list_' . $article['author_id']))
	    		{
	    			// 保存推荐作者信息
	    			$article['content'] = $article['cont'];
	    			$article['create_time'] = $article['c_time'];
	    			model('admin/Author')->setRedis('author_id', $article);
	    		}
	    	}
		}
    	return $article;
	}
}