<?php
/**
 * User: yejialu@prcsteel.com
 * Date: 16-8-10
 * Time: 上午10:07
 */
namespace App\Controllers;

use Frame\Controller;
use Frame\Database\DB;
use Service\View;

class BlogController extends Controller
{
    public function lists()
    {
        //文章主体
        $lists = DB::query('select id,title,description,created_at,click_count from articles limit 0, 10');
        //侧边点击排行
        $clickRank = DB::query('select id,title from articles where status = 1 order by click_count desc,created_at desc,id desc limit 10');
        //侧边文章分类
        $typeList = DB::query('select id,name from article_type');

        $this->view = View::make('blog.lists')->withMore([
            'lists'=>$lists,
            'clickRank'=>$clickRank,
            'typeList'=>$typeList
        ]);
    }

    public function detail()
    {
        $id = isset($_GET['id'])?(int)$_GET['id']:0;
        if(!isset($id)){
            exit('404');
        }
        $detail = DB::query('select * from articles where id = ?',[$id]);
        if(empty($detail)){
            exit(404);
        }
        $this->view = View::make('blog.detail')->with('detail',$detail[0]);
    }
}