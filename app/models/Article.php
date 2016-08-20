<?php
/**
 * User: yejialu@prcsteel.com
 * Date: 16-8-11
 * Time: 下午4:14
 */
namespace App\Models;

use Frame\Controller;
use Frame\Database\DB;

class Article extends Controller
{
    public static function getArticle($id, $fields = null)
    {
        $result = DB::table('articles')->where('id', '=', $id)->select($fields ? $fields : '*');
        if (empty($result)) {
            return false;
        }
        return $result[0];
    }

    public static function getArticleList($offset, $limit , $type = null)
    {
        $db = DB::table('articles');
        if($type){
            $db = $db->where('type','=',$type);
        }
        return $db->limit($offset, $limit)->select(
            ['id', 'title', 'description', 'created_at', 'click_count']
        );
    }

    public static function getArticleTotalNumer()
    {
        $count = DB::table('articles')->select('count(*) as `count`');
        if(empty($count)){
            return false;
        }
        return $count[0]['count'];
    }

    public static function getClickRank()
    {
        return DB::table('articles')->where('status', '=', 1)
            ->orderBy('click_count desc,created_at desc,id desc')
            ->limit(0, 10)
            ->select(['id', 'title']);
    }

    public static function clickIncrement($id, $oldCount)
    {
        return DB::table('articles')->where('id', '=', $id)->update('click_count', $oldCount + 1);
    }

    public static function getTypeList()
    {
        return DB::table('article_type')->select(['id', 'name']);
    }
}