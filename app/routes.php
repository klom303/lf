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
    '/logout'=>'AdminController@logout',
    '/postLogin'=>'AdminController@postLogin',
    '/manage'=>'AdminController@blogList',
    '/deleteArticle'=>'AdminController@deleteArticle',
    '/editArticle'=>'AdminController@editArticle',
    '/postEditArticle'=>'AdminController@postEditArticle',
    '/createArticle'=>'AdminController@createArticle',
    '/postCreateArticle'=>'AdminController@postCreateArticle',
];