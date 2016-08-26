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
    }

    public function index()
    {
        $this->view = View::make('other.index')->withMore(['nav'=>$this->nav]);
    }
}