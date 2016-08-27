<?php
/**
 * User: YeJiaLu
 * Date: 2016/3/23
 * Time: 13:56
 */
namespace Frame;

use Service\View;

class Controller
{
    protected $view;
    protected $nav;
    protected $usr;

    public function __construct()
    {
    }

    public function __destruct()
    {
        $view = $this->view;
        if ($view instanceof View) {
            if (isset($view->data)) {
                extract($view->data);
            }
            require $view->view;
        }
    }
}