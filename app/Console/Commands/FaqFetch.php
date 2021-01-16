<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Classify;
use App\Models\FetcheUrl;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use QL\QueryList;

class FaqFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'f:f';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '问答采集';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $author = Author::orderBy('id', 'asc')->first();
        $this->shengqian($author);
        $this->daikuan($author);
        $this->baoxian($author);
        $this->licai($author);
        $this->xinyongka($author);
        $this->zhuanqian($author);
    }

    public function shengqian(Author $author)
    {
        $tag = $this->tag('省钱');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 124; $i++) {
            if ($i == 1) {
                $url = 'https://www.csai.cn/wenda/shengqian';
            } else {
                $url = "https://www.csai.cn/wenda/shengqian/28-1-{$i}.html";
            }
            $html = $this->fetchUrlHtml($url);
            if (empty($html)) {
                $this->error(date(DATE_RFC3339).":{$url} 内容获取失败");
                continue;
            }
            $this->info(date('Y-m-d H:i:s')." 列表页：{$url}");
            $this->list($author->id, $tag->id, $html);
        }
    }

    public function daikuan(Author $author)
    {
        $tag = $this->tag('贷款');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 2022; $i++) {
            if ($i == 1) {
                $url = 'https://www.csai.cn/wenda/daikuan';
            } else {
                $url = "https://www.csai.cn/wenda/daikuan/2268-1-{$i}.html";
            }
            $html = $this->fetchUrlHtml($url);
            if (empty($html)) {
                $this->error(date(DATE_RFC3339).":{$url} 内容获取失败");
                continue;
            }

            $this->info(date('Y-m-d H:i:s')." 列表页：{$url}");
            $this->list($author->id, $tag->id, $html);
        }
    }

    public function baoxian(Author $author)
    {
        $tag = $this->tag('保险');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 1676; $i++) {
            if ($i == 1) {
                $url = 'https://www.csai.cn/wenda/baoxian';
            } else {
                $url = "https://www.csai.cn/wenda/baoxian/2266-1-{$i}.html";
            }
            $html = $this->fetchUrlHtml($url);
            if (empty($html)) {
                $this->error(date(DATE_RFC3339).":{$url} 内容获取失败");
                continue;
            }

            $this->info(date('Y-m-d H:i:s')." 列表页：{$url}");
            $this->list($author->id, $tag->id, $html);
        }
    }

    public function licai(Author $author)
    {
        $tag = $this->tag('理财');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 1451; $i++) {
            if ($i == 1) {
                $url = 'https://www.csai.cn/wenda/licai';
            } else {
                $url = "https://www.csai.cn/wenda/licai/2265-1-{$i}.html";
            }
            $html = $this->fetchUrlHtml($url);
            if (empty($html)) {
                $this->error(date(DATE_RFC3339).":{$url} 内容获取失败");
                continue;
            }

            $this->info(date('Y-m-d H:i:s')." 列表页：{$url}");
            $this->list($author->id, $tag->id, $html);
        }
    }

    public function xinyongka(Author $author)
    {
        $tag = $this->tag('信用卡');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 1018; $i++) {
            if ($i == 1) {
                $url = 'https://www.csai.cn/wenda/xinyongka';
            } else {
                $url = "https://www.csai.cn/wenda/xinyongka/2267-1-{$i}.html";
            }
            $html = $this->fetchUrlHtml($url);
            if (empty($html)) {
                $this->error(date(DATE_RFC3339).":{$url} 内容获取失败");
                continue;
            }

            $this->info(date('Y-m-d H:i:s')." 列表页：{$url}");
            $this->list($author->id, $tag->id, $html);
        }
    }

    public function zhuanqian(Author $author)
    {
        $tag = $this->tag('赚钱');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 18; $i++) {
            if ($i == 1) {
                $url = 'https://www.csai.cn/wenda/zhuanqian';
            } else {
                $url = "https://www.csai.cn/wenda/zhuanqian/33-1-{$i}.html";
            }
            $html = $this->fetchUrlHtml($url);
            if (empty($html)) {
                $this->error(date(DATE_RFC3339).":{$url} 内容获取失败");
                continue;
            }

            $this->info(date('Y-m-d H:i:s')." 列表页：{$url}");
            $this->list($author->id, $tag->id, $html);
        }
    }

    public function tag(string $name)
    {
        return Classify::where(['type' => 1, 'name' => $name])->first();
    }

    public function list($authorId, $tagId, $html)
    {
        QueryList::getInstance()
            ->html($html)
            ->find('.qbwt_list')
            ->htmls()
            ->each(
                function ($html) use ($tagId, $authorId) {
                    preg_match_all('|<a\shref="(/wenda/\d+\.html)"|', $html, $matches);
                    if (!empty($matches[1]) && $urls = array_unique($matches[1])) {
                        foreach ($urls as $uri) {
                            $this->detail($authorId, $tagId, "https://www.csai.cn".$uri);
                        }
                    }
                }
            );
    }

    public function detail(int $authorId, int $tagId, string $url)
    {
        if (FetcheUrl::where('url', $url)->exists()) {
            $this->warn(date("Y-m-d H:i:s")."已采集过：{$url}");
            return;
        }

        $html = $this->fetchUrlHtml($url);
        $query = QueryList::getInstance();
        $article = $query->html($html)
            ->rules(
                [
                    'title' => ['h1', 'text'],
                    'seo_title' => ['head title', 'text'],
                    'seo_keywords' => ['head meta[name=keywords]', 'attr(content)'],
                    'seo_desc' => ['head meta[name=description]', 'attr(content)'],
                    'contont' => ['.wd_cn', 'html', '-h2 -.bor_bott -#jjzt -#jjjg'],
                ]
            )
            ->queryData();
        $article['seo_title'] = str_replace('-希财网', '_多广网', $article['seo_title']);
        $article['author_id'] = $authorId;
        $article['knowledge'] = 1;
        $article['classify_id'] = $tagId;
        $article['is_hot'] = rand(0, 1);
        $article['reading_volume'] = rand(100, 10000);
        $article['created_at'] = $article['updated_at'] = date('Y-m-d H:i:s');
        try {
            DB::table('article')->insert($article);
            $this->info(date('Y-m-d H:i:s')." 采集完成：{$url}");
        } catch (\Exception $e) {
            $this->error(date('Y-m-d H:i:s')." 采集错误：{$url}|{$e->getMessage()}");
        }

        FetcheUrl::insert(
            ['url' => $url]
        );
    }

    public function fetchUrlHtml(string $url)
    {
        $opts = [
            'http' => [
                'method' => "GET",
                'timeout' => 60000,
            ]
        ];

        return file_get_contents($url, false, stream_context_create($opts));
    }
}
