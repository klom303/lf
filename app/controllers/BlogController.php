<?php
/**
 * User: yejialu@prcsteel.com
 * Date: 16-8-10
 * Time: 上午10:07
 */
namespace App\Controllers;

use App\Models\Article;
use Frame\Controller;
use Service\View;
use Service\Page;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->nav = 'Blog';
    }

    public function lists()
    {
        $type = isset($_GET['type']) ? (int)$_GET['type'] : 0;
        //文章主体
        $pageStr = 'p';
        $page = isset($_GET[$pageStr]) ? ((int)$_GET[$pageStr] ? (int)$_GET[$pageStr] : 1) : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $lists = Article::getArticleList($offset, $limit, $type);
        $totalRecord = Article::getArticleTotalNumber($type);
        $paginateStr = Page::paginate($totalRecord, $limit, $page, $pageStr);
        //侧边点击排行
        $clickRank = Article::getClickRank();
        //侧边文章分类
        $typeList = Article::getTypeList();

        $this->view = View::make('blog.lists')->withMore([
            'lists' => $lists,
            'clickRank' => $clickRank,
            'typeList' => $typeList,
            'paginateStr' => $paginateStr,
            'nav' => $this->nav
        ]);
    }

    public function detail()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (!isset($id)) {
            exit('404');
        }
        $detail = Article::getArticle($id);
        if (empty($detail)) {
            exit('404');
        }
        Article::clickIncrement($id, $detail['click_count']);
        $this->view = View::make('blog.detail')->withMore([
            'detail' => $detail,
            'nav' => $this->nav
        ]);
    }
}