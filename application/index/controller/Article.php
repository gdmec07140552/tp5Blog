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

	/**
	 * [detail 文章详情]
	 * @return [type] [description]
	 */
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
		// 获取文章点击量
    	$article['view'] = $this->setView($art_id);
		$this->assign('result', $article);

		// 显示推荐作者
    	$top_author = controller('Index')->getAuthor();
    	$this->assign('top_author', $top_author);

    	// 推荐文章
    	$this->link_article($article['cate_id']);

    	// 上下篇文章推荐
    	$this->getPrevNext($art_id);

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

	/**
	 * [setView 文章阅读量累加]
	 * @param [type] $art_id [description]
	 */
	public function setView($art_id)
	{
		// 文章的阅读量增加
		redis()->hincrby('article_list_' . $art_id, 'view',1);
		$view = redis()->hget('article_list_' . $art_id, 'view');
		return $view;
	}

	/**
	 * [getPrevNext 上下篇文章推荐]
	 * @param  [type] $art_id [当前文章id]
	 * @return [type]         [description]
	 */
	public function getPrevNext($art_id)
	{
		// 所有文章id
		$idArr = redis()->lrange('article_id', 0, -1);
		foreach ($idArr as $key => $value) {
			// 判断当前文章的下标
			if ($value == $art_id)
			{
				// 获取文章总数
				$total = count($idArr) - 1;
				if ($total == 0)
				{
					// 只有一张文章时
					$result['prev'] = 0;
					$result['next'] = 0;
				} else {
					switch ($key) {
						case 0:
							// 下标为0的文章
							$result['prev'] = 0;
							$result['next'] = $idArr[$key+1];
							break;
						case $total:
							// 最后一篇文章
							$result['prev'] = $idArr[$key-1];
							$result['next'] = 0;
							break;
						default:
							$result['prev'] = $idArr[$key-1];
							$result['next'] = $idArr[$key+1];
							break;
					}
				}
			}
		}
		$this->assign('prevNext', $result);
	}

}