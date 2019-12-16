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
			$article = $this->getArticle();
		} else {
			// 获取作者的信息
			$author = redis()->hgetall('author_' . $article['author_id']);
			$this->assign('author', $author);
		}

		$this->assign('result', $article);

		// 显示推荐作者
    	$top_author = controller('Index')->getAuthor();
    	$this->assign('top_author', $top_author);

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
		$article = model('admin/Article')->getDetail(['a.art_id' => $art_id]);
		if ($article)
		{
			// 缓存文章信息
			redis()->del('article_', $art_id);
			$article_key = 'article_' . $art_id;
			// 设置文章详细信息
			redis()->rpush('article_id', $art_id);
    		redis()->hmset($article_key, array(
    				'art_id' => $article['art_id'],
    				'art_title' => $article['art_title'],
    				'subtitle' => $article['subtitle'],
    				'art_img' => $article['art_img'],
    				'author_id' => $article['author_id'],
    				'create_time' => $article['create_time'],
    				'cate_id' => $article['cate_id'],
    				'inte_id' => $article['inte_id'],
    				'view' => $article['view'],
    				'content' => $article['content'],
    				'author' => $article['author'],
    				'sex' => $article['sex']
    			));

    		//判断作者的信息是否存在
    		if (!exists('author_' . $article['author_id']))
    		{
    			// 保存推荐作者信息
		    		redis()->lpush('author_id', $article['author_id']);
		    		redis()->hmset($author_key, array(
		    				'author_id' => $article['author_id'],
		    				'author' => $article['author'],
		    				'head_img' => $article['h_img'],
		    				'sex' => $article['sex'],
		    				'introduction' => $article['introduction'],
		    				'content' => $article['cont'],
		    				'create_time' => $article['c_time']
		    			));
    		}
    	}
    	return $article;
	}
}