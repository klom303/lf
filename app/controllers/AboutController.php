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
    }

    public function index()
    {
        $this->view = View::make('about.index')->withMore(['nav'=>$this->nav]);
    }
}