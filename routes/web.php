<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('index');
//});
//Route::get('/knowledge', function () {
//    return view('knowledge');
//});
//Route::get('/qa', function () {
//    return view('qa');
//});
//Route::get('/zsinfo', function () {
//    return view('zsinfo');
//});
//Route::get('/wdinfo', function () {
//    return view('wdinfo');
//});
//Route::get('/huati-info', function () {
//    return view('huati-info');
//});
//Route::get('/huati', function () {
//    return view('huati');
//});
//Route::get('/search', function () {
//    return view('search');
//});
//Route::get('/auth', function () {
//    return view('author');
//});
//Route::get('/helps', function () {
//    return view('help');
//});

Route::get('/utils', 'UtilsController@utils')->name('utils');
Route::get('/utils/gjj', 'UtilsController@utilsGjj')->name('gjj');
Route::get('/utils/zuhe', 'UtilsController@utilsZuhe')->name('zuhe');
Route::get('/utils/tiqian', 'UtilsController@utilsTiqian')->name('tiqian');
Route::get('/utils/licai', 'UtilsController@utilsLicai')->name('licai');
Route::get('/utils/gongzi', 'UtilsController@utilsGongzi')->name('gongzi');
Route::get('/utils/nzj', 'UtilsController@utilsNzj')->name('nzj');
Route::get('/utils/wxyj', 'UtilsController@utilsWxyj')->name('wxyj');
//Route::get('/utils', function () {
//    return view('utils');
//});
//Route::get('/utils/gjj', function () {
//    return view('utils-gjj');
//});
//Route::get('/utils/zuhe', function () {
//    return view('utils-zuhe');
//});
//Route::get('/utils/tiqian', function () {
//    return view('utils-tiqian');
//});
//Route::get('/utils/licai', function () {
//    return view('utils-licai');
//});
//Route::get('/utils/gongzi', function () {
//    return view('utils-gongzi');
//});
//Route::get('/utils/nzj', function () {
//    return view('utils-nzj');
//});
//Route::get('/utils/wxyj', function () {
//    return view('utils-wxyj');
//});
Route::get('/author/login', function () {
    return view('authorLogin');
});
Route::get('/author/index', function () {
    return view('authorLayout');
});
Route::get('/author/index/zhishi', function () {
    return view('authorZhiShi');
});
Route::get('/author/index/zhishi/add', function () {
    return view('authorZhiShiAdd');
});
Route::get('/author/index/wenda', function () {
    return view('authorWenDa');
});
Route::get('/author/index/wenda/add', function () {
    return view('authorQaAdd');
});
Route::get('/author/index/ht', function () {
    return view('authorHuaTi');
});
Route::get('/author/index/ht/add', function () {
    return view('authorHuaTiAdd');
});
Route::get('info', 'AuthorController@info')->name('info');
Route::get('/', 'IndexController@index')->name('index');

Route::any('zhishi','IndexController@knowledge')->name('knowledge');
Route::any('zhishi/fenlei/{type?}','IndexController@knowledge')->name('fenlei');
Route::get('zhishi/{id?}.html', 'IndexController@zsinfo')->name('zsinfo');

Route::get('wenda', 'IndexController@qa')->name('qa');
Route::any('wenda/fenlei/{type?}','IndexController@qa')->name('wfenlei');
Route::get('wenda/{id?}.html', 'IndexController@wdinfo')->name('wdinfo');

Route::get('huati', 'IndexController@ht')->name('ht');
Route::get('huati/{id?}.html/{orderBy?}', 'IndexController@htinfo')->name('htinfo');
Route::get('huati/info/{id?}.html', 'IndexController@zsinfo')->name('huti');

Route::get('science.html/{page?}/{orderBy?}','IndexController@science')->name('science');
Route::get('about/{type?}', 'IndexController@help')->name('help');
Route::get('author/{id?}.html/{orderBy?}', 'IndexController@author')->name('author');
Route::get('search.html/{title?}', 'IndexController@search')->name('search');

Route::get('site.xml', 'SitemapController@siteMap')->name('siteMap');
Route::get('duoguang/{name?}.xml', 'SitemapController@filesXml')->name('filesXml');
Route::get('download/xml_headiles.xml', 'SitemapController@filesDownload')->name('filesDownload');

Route::get('section.xml', 'SitemapController@siteSection')->name('siteSection');
Route::get('download/xml_section.xml', 'SitemapController@sectionDownload')->name('sectionDownload');

Route::get('section_two.xml', 'SitemapController@siteSectionTwo')->name('siteSectionTwo');
Route::get('download/xml_section_two.xml', 'SitemapController@sectionDownloadTwo')->name('sectionDownloadTwo');

Route::get('login', function () {
    return view('authorLogin');
});

Route::get('sitemap', 'UtilsController@sitemapDownload')->name('sitemap.download');
Route::get('mpsitemap', 'UtilsController@mpsitemapDownload')->name('mpsitemap.download');

