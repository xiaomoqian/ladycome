<?php

namespace App\Http\Controllers;


//todo 补充其他模块
use App\Models\Article;
use Carbon\Carbon;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Spatie\Sitemap\SitemapGenerator;

class SitemapController extends Controller
{

    public function siteMap()
    {
         $xml_headlines = file_get_contents("xml_headlines.xml");
        if(!$xml_headlines){
            throw new Exception('请稍后重试');
        }
        return response($xml_headlines)->header('Content-Type', 'text/xml');
    }

    protected  function handles($siteMap,$page = 1){
        $data = Article::whereIn('knowledge',[Article::KNOWLEDGE_SCIENCE,Article::KNOWLEDGE_Q_A])
            ->offset(($page - 1) * 1000)
            ->limit(1000)
            ->orderBy('created_at','desc')
            ->get()->toArray();
        if(!$data){
            return $siteMap;
        }
        //创建xml文件
//        self::files($data,base_path()."/xml_{$page}.xml",'');
        self::files($data,public_path("xml_{$page}.xml"),'');
        $time = date("Y-m-d");

        $siteMap[] = '  <url>';
        $siteMap[] = "    <loc>".trim(config("app.url"),"/")."/duoguang/xml_{$page}.xml"."</loc>";
        $siteMap[] = "    <lastmod>".$time."</lastmod>";
        $siteMap[] = "  </url>";
        return self::handles($siteMap,$page + 1);
    }

    protected function files($data,$path,$xml = ''){
        $xml .= '<?xml version="1.0" encoding="utf-8" ?>'."\n";
        $xml .= '<DOCUMENT>'."\n";
        $xml .= self::xml($data);
        $xml .= '</DOCUMENT>';
        file_put_contents($path,$xml);
        return true;
    }

    protected function xml($data){
        $xml = '';
        foreach ($data as $key => $value){
            $xml .= '<item>'."\n";
            $xml .= '<key>'.$value['id']."</key>"."\n";
            $xml .= '<query>'.$value['title']."</query>"."\n";
            if ($value['knowledge'] == Article::KNOWLEDGE_SCIENCE) {  //知识
                $xml .= '<display_type>kg</display_type>'."\n";
                $url = trim(config('app.url'), '/')."/zhishi/{$value['id']}.html";
            } elseif ($value['knowledge'] == Article::KNOWLEDGE_Q_A) { //问答
                $xml .= '<display_type>1</display_type>'."\n";
                $url = trim(config('app.url'), '/')."/wenda/{$value['id']}.html";
            }
            $xml .= '<title>'.$value['title'].'</title>'."\n";
            $photo = $value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg");
            $xml .= '<image>'.$photo.'</image>'."\n";
            $xml .= '<url>'.$url.'</url>'."\n";
            $xml .= '<answer>'.$value['seo_keywords'].'</answer>'."\n";
            $xml .= '<abs>'.$value['seo_desc'].'</abs>'."\n";
            $xml .= '<modify_time>'.time().'</modify_time>'."\n";
            $xml .= '</item>'."\n";
        }
        return $xml;
    }

    public function filesXml($name)
    {
//        $url = base_path()."/{$name}.xml";
        $a = file_get_contents(public_path("{$name}.xml"));
        return response($a)->header('Content-Type', 'text/xml');
    }
    
    public function filesDownload()
    {
        return response()->download(public_path("xml_headiles.zip"));
    }
     
   public function siteSection()
    {
        $xml_headlines = file_get_contents("xml_section.xml");
        if(!$xml_headlines){
            throw new Exception('请稍后重试');
        }
        return response($xml_headlines)->header('Content-Type', 'text/xml');

    }

    public function sectionDownload()
    {
        return response()->download(public_path("xml_section.zip"));
    }
    
        public function siteSectionTwo()
    {
        $xml_headlines = file_get_contents("xml_section_two.xml");
        if(!$xml_headlines){
            throw new Exception('请稍后重试');
        }
        return response($xml_headlines)->header('Content-Type', 'text/xml');

    }

    public function sectionDownloadTwo()
    {
        return response()->download(public_path("xml_section_two.zip"));
    }
    
}