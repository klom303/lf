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

class BlogController extends Controller
{
    public function lists()
    {
        $type = isset($_GET['type']) ? (int)$_GET['type'] : 0;
        //文章主体
        $lists = Article::getArticleList(0, 10 ,$type);
        //侧边点击排行
        $clickRank = Article::getClickRank();
        //侧边文章分类
        $typeList = Article::getTypeList();

        $this->view = View::make('blog.lists')->withMore([
            'lists' => $lists,
            'clickRank' => $clickRank,
            'typeList' => $typeList
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
        $this->view = View::make('blog.detail')->with('detail', $detail);
    }
}