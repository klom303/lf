<?php
/**
 * User: yejialu@prcsteel.com
 * Date: 16-8-26
 * Time: 上午11:20
 */
namespace App\Controllers;

use Frame\Controller;
use Service\View;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->nav = 'About';
        session_start();
        $this->usr = isset($_SESSION['usr'])?$_SESSION['usr']:null;
        View::share('usr',$this->usr);
        View::share('nav',$this->nav);
    }

    public function index()
    {
        $this->view = View::make('about.index');
    }
}