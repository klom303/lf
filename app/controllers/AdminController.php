<?php
/**
 * User: yejialu@prcsteel.com
 * Date: 16-8-26
 * Time: 下午3:41
 */
namespace App\Controllers;

use App\Models\Article;
use App\Models\User;
use Frame\Controller;
use Service\Page;
use Service\View;

class AdminController extends Controller
{
    private $funcNeedLogin = ['blogList','deleteArticle','editArticle','postEditArticle','createArticle'];
    public function __construct()
    {
        $this->nav = 'Admin';
        session_start();
        $this->usr = isset($_SESSION['usr'])?$_SESSION['usr']:null;
        View::share('usr',$this->usr);
        View::share('nav',$this->nav);
        if(in_array(__FUNCTION__,$this->funcNeedLogin)){
            $this->checkLogin();
        }
    }

    public function login()
    {
        if($this->usr){
            header('location:/');
            exit;
        }
        $this->view = View::make('admin.login');
    }

    public function logout()
    {
        $_SESSION['usr'] = null;
        header('location:/');
        exit;
    }

    public function postLogin()
    {
        if(!isset($_POST['username'])||!isset($_POST['password'])){
            exit(json_encode(['status'=>201,'message'=>'invalid params','data'=>null]));
        }
        if(empty($_POST['username'])){
            exit(json_encode(['status'=>201,'message'=>'请输入账号','data'=>null]));
        }
        if(empty($_POST['password'])){
            exit(json_encode(['status'=>202,'message'=>'请输入密码','data'=>null]));
        }
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $user = User::getLogin($username,$password);
        if(false===$user){
            exit(json_encode(['status'=>203,'message'=>'帐号或密码错误','data'=>null]));
        }
        $_SESSION['usr'] = $user;
        exit(json_encode(['status'=>200,'message'=>'success','data'=>null]));
    }

    private function checkLogin()
    {
        if(empty($this->usr)){
            header('location:/login');
            exit;
        }
    }

    public function blogList()
    {
        $type = isset($_GET['type']) ? (int)$_GET['type'] : 0;
        $pageStr = 'p';
        $page = isset($_GET[$pageStr]) ? ((int)$_GET[$pageStr] ? (int)$_GET[$pageStr] : 1) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $lists = Article::getArticleList($offset, $limit, $type);
        $totalRecord = Article::getArticleTotalNumber($type);
        $paginateStr = Page::paginate($totalRecord, $limit, $page, $pageStr);

        $typeList = Article::getTypeList();
        $this->view = View::make('admin.blogList')->withMore([
            'lists'=>$lists,
            'paginateStr'=>$paginateStr,
            'typeList'=>$typeList,
            'type'=>$type
        ]);
    }

    public function deleteArticle()
    {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if (!isset($id)) {
            exit('404');
        }
        if(false===Article::deleteArticle($id)){
            exit(json_encode(['status'=>201,'message'=>'删除失败','data'=>null]));
        }
        exit(json_encode(['status'=>200,'message'=>'success','data'=>null]));
    }

    public function editArticle()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (!isset($id)) {
            exit('404');
        }
        $detail = Article::getArticle($id);
        if (empty($detail)) {
            exit('404');
        }
        $typeList = Article::getTypeList();
        $this->view = View::make('admin.edit')->withMore([
            'article'=>$detail,
            'typeList'=>$typeList
        ]);
    }

    public function postEditArticle()
    {
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if (!isset($id)) {
            exit(json_encode(['status'=>201,'message'=>'missing id','data'=>null]));
        }
        $type = isset($_POST['type']) ? (int)$_POST['type'] : 0;
        if (empty($type)) {
            exit(json_encode(['status'=>201,'message'=>'请选择类型','data'=>null]));
        }
        $title = stripslashes(addslashes(trim($_POST['title'])));
        if(empty($title)){
            exit(json_encode(['status'=>202,'message'=>'标题不能为空','data'=>null]));
        }
        $description = stripslashes(addslashes(trim($_POST['description'])));
        $content = $_POST['content'];
        if(empty($title)){
            exit(json_encode(['status'=>203,'message'=>'正文不能为空','data'=>null]));
        }
        $result = Article::updateArticle($id,[
            'title'=>$title,
            'type'=>$type,
            'description'=>$description,
            'content'=>$content]
        );
        if(false===$result){
            exit(json_encode(['status'=>204,'message'=>'更新失败','data'=>null]));
        }
        exit(json_encode(['status'=>200,'message'=>'success','data'=>null]));
    }

    public function createArticle()
    {
        $typeList = Article::getTypeList();
        $this->view = View::make('admin.create')->withMore([
            'typeList'=>$typeList
        ]);
    }

    public function postCreateArticle()
    {
        $title = stripslashes(addslashes(trim($_POST['title'])));
        if(empty($title)){
            exit(json_encode(['status'=>202,'message'=>'标题不能为空','data'=>null]));
        }
        $type = isset($_POST['type']) ? (int)$_POST['type'] : 0;
        if (empty($type)) {
            exit(json_encode(['status'=>201,'message'=>'请选择分类','data'=>null]));
        }
        $description = stripslashes(addslashes(trim($_POST['description'])));
        $content = $_POST['content'];
        if(empty($title)){
            exit(json_encode(['status'=>203,'message'=>'正文不能为空','data'=>null]));
        }
        $result = Article::createArticle([
                'title'=>$title,
                'type'=>$type,
                'description'=>$description,
                'content'=>$content,
                'created_at'=>date('Y-m-d H:i:s')]
        );
        if(false===$result){
            exit(json_encode(['status'=>204,'message'=>'添加失败','data'=>null]));
        }
        exit(json_encode(['status'=>200,'message'=>'success','data'=>null]));
    }
}