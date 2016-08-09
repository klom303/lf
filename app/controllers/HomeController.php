<?php
/**
 * User: YeJiaLu
 * Date: 2016/3/22
 * Time: 17:47
 */
namespace App\Controllers;

use Frame\Controller;
use Frame\Database\DB;
use Service\View;

class HomeController extends Controller
{
    public function index()
    {
        echo '<div style="margin:0 auto;text-align: center;font-size: 50px;">Welcome</div>';
    }

    public function blog()
    {
        $lists = DB::query('select id,title,description,created_at from articles');
        $this->view = View::make('home.index')->with('lists',$lists);
    }

    public function detail()
    {
        $id = (int)$_GET['id'];
        if(!isset($id)){
            exit('404');
        }
        $detail = DB::query('select * from articles where id = ?',[$id]);
        if(empty($detail)){
            exit(404);
        }
        $this->view = View::make('article.detail')->with('detail',$detail[0]);
    }
}