<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;

class PushController
{


    public function index(Content $content)
    {
        // 方式1，使用form组建进行页面渲染
        $f = new Form();
        $f->title('百度推送');
        $f->disableCreatingCheck();
        $f->disableResetButton();
        $f->disableViewCheck();
        $f->disableEditingCheck();
        $f->disableListButton();
        $f->action('push');
        $f->text('api', '百度推送地址');
        $f->text('token', '百度推送秘钥');
        $f->text('url', '地址');
//        $f->html("<a class='btn btn-sm btn-primary mallto-next' href='#' target='_blank'>sitemap生成</a> &nbsp;");
        $content->header('百度推送')
            ->description('push')
            ->body($f);

        return  $content;
    }

    public function store(Request $request)
    {
//        $api = 'http://data.zz.baidu.com';
        $token= $request->get('token','');
        $api = $request->get('api','');
        $site = $request->get('url','');
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $api.'/site='.$site."&token=".$token);
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, implode("\n", $urls));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设定是否显示头信息
        curl_setopt($ch, CURLOPT_HEADER, false); //设定是否输出页面内容
        curl_setopt($ch, CURLOPT_NOBODY, false);
        $result = curl_exec($ch);
        curl_close($ch); //get data after login
        $rep = json_decode($result,true);
        if(isset($rep['error'])){
            return response()->json(['message' => $rep['message']]);
        }
        return response()->json(['message' => '推送成功'.$rep['success']??""]);
    }

}
