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
    }

    public function index()
    {
        $this->view = View::make('home.index')->with('nav',$this->nav);
    }
}