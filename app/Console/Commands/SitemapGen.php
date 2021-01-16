<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Sitemap;
use Spatie\Sitemap\Tags\Url;
use ZanySoft\Zip\Zip;

class SitemapGen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:gen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成Sitemap';

    /**
     * @var int
     */
    protected $countPerPage = 30000;

    /**
     * @var array
     */
    protected $files = [
        'sitemap.xml',
        'tool_sitemap.xml',
        'about_sitemap.xml',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(0);

        $wendaTotal = Article::where('knowledge', 1)->count();
        $zhishiTotal = Article::where('knowledge', 2)->count();
        $huatiTotal = Article::where('knowledge', 3)->count();

        $this->createIndex($wendaTotal, $zhishiTotal, $huatiTotal);
        $this->tools();
        $this->about();

        $this->pageAndDetail($wendaTotal, 'wenda', 1);
        $this->pageAndDetail($zhishiTotal, 'zhishi', 2);
        $this->pageAndDetail($huatiTotal, 'huati', 3);

        $this->zip();
    }

    private function pageAndDetail(int $typeTotal, string $type, int $typeCode)
    {
        // 列表页
        $total = ceil($typeTotal / 10);
        $listCount = ceil($total / $this->countPerPage);
        for ($i = 1; $i <= $listCount; $i++) {
            $sitemap = \Spatie\Sitemap\Sitemap::create();
            $sitemap->add(Url::create("$type"));
            // i = 1 时 1 => 40000
            // i = 2 时 40001 => 80000
            $start = ($i - 1) * $this->countPerPage + 1;
            $end = $i * $this->countPerPage <= $total ? $i * $this->countPerPage : $total;
            for ($j = $start; $j<= $end; $j++) {
                $sitemap->add(Url::create("{$type}_$j"));
            }
            $file = "{$type}_list_{$i}_sitemap.xml";
            $sitemap->writeToFile(public_path($file));
            $this->files[] = $file;
            unset($sitemap);
        }

        // 详情页
        $detailPage = 1;
        Article::where('knowledge', $typeCode)->chunk(
            $this->countPerPage,
            function ($articles) use (&$detailPage, $type) {
                $sitemap = \Spatie\Sitemap\Sitemap::create();
                foreach ($articles as $article) {
                    $sitemap->add(Url::create("{$type}/{$article->id}.html")->setPriority(1));
                }
                $file = "{$type}_{$detailPage}_sitemap.xml";
                $sitemap->writeToFile(public_path($file));
                $this->files[] = $file;
                unset($sitemap);
                $detailPage++;
            }
        );
    }

    /**
     * 索引页
     *
     * @param  int  $wendaTotal  问答文章总数
     * @param  int  $zhishiTotal  知识文章总数
     * @param  int  $huatiTotal  话题文章总数
     */
    private function createIndex(int $wendaTotal, int $zhishiTotal, int $huatiTotal)
    {
        $index = SitemapIndex::create();

        $wendaTotalPage = ceil($wendaTotal / 10);
        $listCount = ceil($wendaTotalPage / $this->countPerPage);
        for ($i = 1; $i <= $listCount; $i++) {
            $index->add(Sitemap::create("wenda_list_{$i}_sitemap.xml"));
        }
        $detailCount = ceil($wendaTotal / $this->countPerPage);
        for ($i = 1; $i <= $detailCount; $i++) {
            $index->add(Sitemap::create("wenda_{$i}_sitemap.xml"));
        }

        $zhishiTotalPage = ceil($zhishiTotal / 10);
        $listCount = ceil($zhishiTotalPage / $this->countPerPage);
        for ($i = 1; $i <= $listCount; $i++) {
            $index->add(
                Sitemap::create("zhishi_list_{$i}_sitemap.xml")
            );
        }
        $detailCount = ceil($zhishiTotal / $this->countPerPage);
        for ($i = 1; $i <= $detailCount; $i++) {
            $index->add(
                Sitemap::create("zhishi_{$i}_sitemap.xml")
            );
        }

        $huatiTotalPage = ceil($huatiTotal / 10);
        $listCount = ceil($huatiTotalPage / $this->countPerPage);
        for ($i = 1; $i <= $listCount; $i++) {
            $index->add(
                Sitemap::create("huati_list_{$i}_sitemap.xml")
            );
        }
        $detailCount = ceil($huatiTotal / $this->countPerPage);
        for ($i = 1; $i <= $detailCount; $i++) {
            $index->add(
                Sitemap::create("huati_{$i}_sitemap.xml")
            );
        }

        $index->add('tool_sitemap.xml');
        $index->add('about_sitemap.xml');

        $index->writeToFile(public_path('sitemap.xml'));
    }

    private function tools()
    {
        \Spatie\Sitemap\Sitemap::create()
            ->add(Url::create('tool/fangdai'))
            ->add(Url::create('tool/gjj'))
            ->add(Url::create('tool/zuhedai'))
            ->add(Url::create('tool/tiqianhuankuan'))
            ->add(Url::create('tool/gongzi'))
            ->add(Url::create('tool/licai'))
            ->add(Url::create('tool/nzj'))
            ->add(Url::create('tool/wxyj'))
            ->writeToFile(public_path('tool_sitemap.xml'));
    }

    private function about()
    {
        \Spatie\Sitemap\Sitemap::create()
            ->add(Url::create('about'))
            ->add(Url::create('about/contact'))
            ->add(Url::create('about/copy'))
            ->add(Url::create('about/job'))
            ->add(Url::create('about/join'))
            ->writeToFile(public_path('about_sitemap.xml'));
    }

    private function zip()
    {
        $zipFile = public_path('sitemap.zip');
        if (!file_exists($zipFile)) {
            @unlink($zipFile);
        }
        $zip = Zip::create($zipFile);
        foreach ($this->files as $k => $file) {
            $zip->add(public_path($file));
        }
        $zip->close();
    }
}
