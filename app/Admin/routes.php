<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('help', 'HelpController');
    $router->resource('author', 'AuthorController');
    $router->resource('ad', 'AdController');
    $router->resource('article', 'ArticleController');
    $router->resource('classify', 'ClassifyController');
    $router->resource('relay', 'RelayController');
    $router->resource('logo', 'LogoController');
    $router->resource('index', 'PushController');
    $router->resource('sitemap', 'SitemapController');
    $router->resource('seo', 'SeoController');
    $router->get('/a', 'AdController@a');
    $router->get('/cfy', 'ArticleController@cfy');
    $router->get('apilist', 'SitemapController@apilist');
    $router->post('apilist', 'SitemapController@store')->name('apipush');
});

