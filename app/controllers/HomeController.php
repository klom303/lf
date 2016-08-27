<?php
/**
 * User: YeJiaLu
 * Date: 2016/3/22
 * Time: 17:47
 */
namespace App\Controllers;

use Frame\Controller;
use Service\View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->nav = 'Home';
        session_start();
        $this->usr = isset($_SESSION['usr'])?$_SESSION['usr']:null;
        View::share('usr',$this->usr);
        View::share('nav',$this->nav);
    }

    public function index()
    {
        $this->view = View::make('home.index');
    }
}