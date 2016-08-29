<?php
/**
 * User: yejialu@prcsteel.com
 * Date: 16-8-11
 * Time: 下午4:14
 */
namespace App\Models;

use Frame\Database\DB;
use Frame\Model;

class Article extends Model
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
        $sql = 'select `articles`.`id`,`articles`.`title`,`articles`.`description`,`articles`.`created_at`,';
        $sql.='`articles`.`click_count`,`article_type`.`name` from `articles` left join `article_type`';
        $sql.=' on `articles`.type = `article_type`.`id` ';
        $binds = [];
        if($type){
            $sql.= 'where `articles`.`type` = ? ';
            $binds[] = $type;
        }
        $sql.=' order by created_at desc ,id desc';
        $sql.=" limit {$offset},{$limit} ;";
        return DB::query($sql,$binds);
    }

    public static function getArticleTotalNumber($type = 0)
    {
        $count = DB::table('articles');
        if($type){
            $count->where('type','=',$type);
        }
        $count = $count->select('count(*) as `count`');
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

    public static function deleteArticle($id)
    {
        return DB::table('articles')->where('id','=',$id)->delete();
    }

    public static function updateArticle($id,array $fields)
    {
        return DB::table('articles')->where('id','=',$id)->update($fields);
    }

    public static function createArticle(array $fields)
    {
        return DB::table('articles')->insert($fields);
    }
}