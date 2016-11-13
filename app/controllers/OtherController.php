<?php
/**
 * User: yejialu@prcsteel.com
 * Date: 16-8-26
 * Time: 上午11:33
 */
namespace App\Controllers;

use Frame\Controller;
use Service\View;

class OtherController extends Controller
{
    public function __construct()
    {
        $this->nav = 'Other';
        session_start();
        $this->usr = isset($_SESSION['usr'])?$_SESSION['usr']:null;
        View::share('usr',$this->usr);
        View::share('nav',$this->nav);
    }

    public function index()
    {
        $this->view = View::make('other.index');
    }

    public function healCalculator()
    {
        $this->view = View::make('other.wow.heal_calculator');
    }
}