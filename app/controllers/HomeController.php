<?php
/**
 * User: YeJiaLu
 * Date: 2016/3/22
 * Time: 17:47
 */
namespace App\Controllers;

use Frame\Controller;

class HomeController extends Controller
{
    public function index()
    {
        echo '<div style="margin:0 auto;text-align: center;font-size: 50px;">Welcome</div>';
    }
}