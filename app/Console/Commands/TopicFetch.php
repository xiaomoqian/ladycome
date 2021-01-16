<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Classify;
use App\Models\FetcheUrl;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use QL\QueryList;

class TopicFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'f:t';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '话题采集';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $author = Author::orderBy('id', 'asc')->first();
        $this->xinyongka($author);
        $this->licai($author);
        $this->daikuan($author);
        $this->gupiao($author);
        $this->baoxian($author);
        $this->fangdai($author);
    }

    public function xinyongka(Author $author)
    {
        $tag = $this->tag('信用卡');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 170;$i++) {
            $url = "http://m.zhimeng.com.cn/?/explore/ajax/list/tp-topic__sort_type-new__topic_id-32__page-{$i}";
            $html = $this->fetchUrlHtml($url);
            if (!empty($html)) {
                $this->list($author->id, $tag->id, $html);
            } else {
                $this->error(date("Y-m-d H:i:s") . "内容抓取失败：{$url}");
            }
        }
    }

    public function licai(Author $author)
    {
        $tag = $this->tag('理财');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 70;$i++) {
            $url = "http://m.zhimeng.com.cn/?/explore/ajax/list/tp-topic__sort_type-new__topic_id-3873__page-{$i}";
            $html = $this->fetchUrlHtml($url);
            if (!empty($html)) {
                $this->list($author->id, $tag->id, $html);
            } else {
                $this->error(date("Y-m-d H:i:s") . "内容抓取失败：{$url}");
            }
        }
    }

    public function daikuan(Author $author)
    {
        $tag = $this->tag('贷款');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 60;$i++) {
            $url = "http://m.zhimeng.com.cn/?/explore/ajax/list/tp-topic__sort_type-new__topic_id-306__page-{$i}";
            $html = $this->fetchUrlHtml($url);
            if (!empty($html)) {
                $this->list($author->id, $tag->id, $html);
            } else {
                $this->error(date("Y-m-d H:i:s") . "内容抓取失败：{$url}");
            }
        }
    }

    public function gupiao(Author $author)
    {
        $tag = $this->tag('股票');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 40;$i++) {
            $url = "http://m.zhimeng.com.cn/?/explore/ajax/list/tp-topic__sort_type-new__topic_id-25__page-{$i}";
            $html = $this->fetchUrlHtml($url);
            if (!empty($html)) {
                $this->list($author->id, $tag->id, $html);
            } else {
                $this->error(date("Y-m-d H:i:s") . "内容抓取失败：{$url}");
            }
        }
    }

    public function baoxian(Author $author)
    {
        $tag = $this->tag('保险');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 20;$i++) {
            $url = "http://m.zhimeng.com.cn/?/explore/ajax/list/tp-topic__sort_type-new__topic_id-3936__page-{$i}";
            $html = $this->fetchUrlHtml($url);
            if (!empty($html)) {
                $this->list($author->id, $tag->id, $html);
            } else {
                $this->error(date("Y-m-d H:i:s") . "内容抓取失败：{$url}");
            }
        }
    }

    public function fangdai(Author $author)
    {
        $tag = $this->tag('房贷');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 18;$i++) {
            $url = "http://m.zhimeng.com.cn/?/explore/ajax/list/tp-topic__sort_type-new__topic_id-19__page-{$i}";
            $html = $this->fetchUrlHtml($url);
            if (!empty($html)) {
                $this->list($author->id, $tag->id, $html);
            } else {
                $this->error(date("Y-m-d H:i:s") . "内容抓取失败：{$url}");
            }
        }
    }

    public function list($authorId, $tagId, $html)
    {
        QueryList::getInstance()
            ->html($html)
            ->find('.boxys .tent')
            ->htmls()
            ->each(
                function ($html) use ($tagId, $authorId) {
                    $rs = QueryList::getInstance()
                        ->html($html)
                        ->rules(
                            [
                                'img' => ['img', 'attr(src)'],
                                'article' => ['a:eq(0)', 'attr(href)']
                            ]
                        )
                        ->queryData();
                    if (count($rs) == 2 && !empty($rs['article'])) {
                        $this->detail($authorId, $tagId, $rs['article'], $rs['img']);
                    }
                }
            );
    }

    public function detail(int $authorId, int $tagId, string $url, string $img)
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
                    'contont' => ['.case-content', 'html'],
                ]
            )
            ->queryData();
        $article['seo_title'] = str_replace('织梦财经', '多广网', $article['seo_title']);
        $article['author_id'] = $authorId;
        $article['photo'] = $img;
        $article['knowledge'] = 3;
        $article['classify_id'] = $tagId;
        $article['is_hot'] = rand(0, 1);
        $article['reading_volume'] = rand(100, 10000);
        $article['created_at'] = $article['updated_at'] = date('Y-m-d H:i:s');

        if (!empty($article['title']) && !empty($article['contont'])) {
            try {
                DB::table('article')->insert($article);
                $this->info(date('Y-m-d H:i:s')." 采集完成：{$url}");
            } catch (\Exception $e) {
                $this->error(date('Y-m-d H:i:s')." 采集错误：{$url}|{$e->getMessage()}");
            }
        }

        FetcheUrl::insert(
            ['url' => $url]
        );
    }

    public function tag(string $name)
    {
        return Classify::where(['type' => 3, 'name' => $name])->first();
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
