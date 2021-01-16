<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Sitemap;
use Spatie\Sitemap\Tags\Url;
use ZanySoft\Zip\Zip;

class SitemapSectionTwo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:sectiontwo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成Sitemap头条区间数据';

    protected $files = [];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $siteMap = [];
        $siteMap[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $siteMap[] = '<DOCUMENT>';
        $siteMap[] = '<sitemapindex>';
//        $siteMap[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $siteMap = self::handles($siteMap,1);
//        $siteMap[] = '</urlset>';
        $siteMap[] = '</sitemapindex>';
        $siteMap[] = '</DOCUMENT>';
        $this->zip();
        file_put_contents(public_path("xml_section_two.xml"),$siteMap);
    }

    protected  function handles($siteMap,$page = 1){
        $data = Article::whereIn('knowledge',[Article::KNOWLEDGE_SCIENCE,Article::KNOWLEDGE_Q_A])
            ->where('id','>=','80369')
            ->where('id','<=','80592')
            ->offset(($page - 1) * 1000)
            ->limit(1000)
            ->orderBy('created_at','desc')
            ->get()->toArray();
        if(!$data){
            return $siteMap;
        }
        $index = SitemapIndex::create();
        //创建xml文件
        $file = "section_two_{$page}.xml";
        self::files($data,public_path($file),'');
        $index->add(
            Sitemap::create($file)
        );
        $this->files[] = $file;

        $time = date("Y-m-d");

        $siteMap[] = '  <sitemap>';
        $siteMap[] = "    <loc>".trim(config("app.url"),"/")."/duoguang/section_two_{$page}.xml"."</loc>";
        $siteMap[] = "    <lastmod>".$time."</lastmod>";
        $siteMap[] = "  </sitemap>";
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
            $xml .= '<key><![CDATA['.$value['id']."]]></key>"."\n";
            $xml .= '<display>'."\n";
            // $xml .= '<![CDATA['.$value['title']."]]>"."\n";
            $value['seo_keywords'] = str_replace(';','，',$value['seo_keywords']);
            $value['seo_keywords'] = str_replace('；','，',$value['seo_keywords']);
            $seo_keywords = explode("，", $value['seo_keywords']);
            foreach ($seo_keywords as $k => $v){
                // $xml .= '<aliaskey><![CDATA['.$v."]]></aliaskey>"."\n";
                $xml .= '<aliaskey>'.$v."</aliaskey>"."\n";
            }
            // $xml .= '<aliaskey><![CDATA['.$value['seo_keywords']."]]></aliaskey>"."\n";
            $xml .= '<type><![CDATA[finance]]></type>'."\n";
            if ($value['knowledge'] == Article::KNOWLEDGE_SCIENCE) {  //知识
                $url = trim(config('app.url'), '/')."/zhishi/{$value['id']}.html";
            } elseif ($value['knowledge'] == Article::KNOWLEDGE_Q_A) { //问答
                $url = trim(config('app.url'), '/')."/wenda/{$value['id']}.html";
            }
            $xml .= '<subtype><![CDATA[article]]></subtype>'."\n";
            // $xml .= '<gid><![CDATA['.$value['id'].']]></gid>'."\n";
            $xml .= '<url><![CDATA['.$url.']]></url>'."\n";
            $xml .= '<title><![CDATA['.$value['title'].']]></title>'."\n";
            $photo = $value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg");
             $xml .= ' <source><![CDATA[多广网]]></source>'."\n";
           
            $xml .= '<cover_img><![CDATA['.$photo.']]></cover_img>'."\n";
            // $xml .= '<short_answer><![CDATA['.$value['seo_keywords'].']]></short_answer>'."\n";
            if(!empty($value['short_answer'])){
                 $xml .= '<short_answer>'.$value['short_answer'].'</short_answer>'."\n";
            }
                        $seo_desc = explode('
',$value['seo_desc']);
            foreach ($seo_desc as $ke => $desc){
                $xml .= '<abs><![CDATA['.$desc.']]></abs>'."\n";
            }
            // $xml .= '<abs><![CDATA['.$value['seo_desc'].']]></abs>'."\n";
            $xml .= '<create_time><![CDATA['.strtotime($value['created_at']).']]></create_time>'."\n";
            $xml .= '<modify_time><![CDATA['.strtotime($value['updated_at']).']]></modify_time>'."\n";
            $xml .= '<specialized><![CDATA[common]]></specialized>'."\n";
            $xml .= '<best_doc><![CDATA[Y]]></best_doc>'."\n";
            $xml .= '<authorize><![CDATA[Y]]></authorize>'."\n";
            $xml .= '</display>'."\n";
            $xml .= '</item>'."\n";
        }
        return $xml;
    }

    private function zip()
    {
        $zipFile = public_path('xml_section_two.zip');
        if (!file_exists($zipFile)) {
            @unlink($zipFile);
        }
        $zip = Zip::create($zipFile);
        foreach ($this->files as $k => $file) {
            $zip->add(public_path($file));
        }
        $zip->close();
//        foreach ($this->files as $k => $file) {
//            @unlink(public_path($file));
//        }
    }
}
