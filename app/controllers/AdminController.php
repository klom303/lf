<?php
/**
 * User: yejialu@prcsteel.com
 * Date: 16-8-26
 * Time: 下午3:41
 */
namespace App\Controllers;

use Frame\Controller;
use Service\View;

class AdminController extends Controller
{
    private $usr;
    private $funcNeedLogin = [];
    public function __construct()
    {
        session_start();
        $this->usr = isset($_SESSION['usr'])?$_SESSION['usr']:null;
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
        $this->view = View::make('admin.login')->withMore(['nav'=>$this->nav]);
    }

    public function logout()
    {
        $_SESSION['usr'] = null;
        header('location:/');
        exit;
    }

    public function postLogin()
    {
        exit(json_encode(['status'=>201,'message'=>'帐号不存在','data'=>null]));
    }

    private function checkLogin()
    {
        if(empty($this->usr)){
            header('location:/login');
            exit;
        }
    }
}