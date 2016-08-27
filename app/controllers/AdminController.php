<?php
/**
 * User: yejialu@prcsteel.com
 * Date: 16-8-26
 * Time: 下午3:41
 */
namespace App\Controllers;

use App\Models\User;
use Frame\Controller;
use Service\View;

class AdminController extends Controller
{
    private $funcNeedLogin = [];
    public function __construct()
    {
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
}