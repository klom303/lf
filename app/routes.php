<?php
/**
 * User: YeJiaLu
 * Date: 2016/3/22
 * Time: 15:09
 */
return [
    '/'=>'HomeController@index',
    '/blog'=>'BlogController@lists',
    '/article'=>'BlogController@detail',
    '/about'=>'AboutController@index',
    '/other'=>'OtherController@index',
    '/login'=>'AdminController@login',
    '/postLogin'=>'AdminController@postLogin',
];