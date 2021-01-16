<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Classify;
use App\Models\FetcheUrl;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use QL\QueryList;

class PostFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'f:p';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '知识采集';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $author = Author::orderBy('id', 'asc')->first();
        $this->licai($author);
        $this->baoxian($author);
        $this->gupiao($author);
        $this->jijin($author);
        $this->xinyongka($author);
        $this->shengqian($author);
        $this->zhuanqian($author);
    }

    public function licai(Author $author)
    {
        $tag = $this->tag('理财');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 124; $i++) {
            if ($i == 1) {
                $url = 'https://www.csai.cn/zhishi/licai/';
            } else {
                $url = "https://www.csai.cn/zhishi/licai_{$i}";
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

        $html = $this->fetchUrlHtml("https://www.csai.cn/baoxian/");
        if (empty($html)) {
            $this->error(date(DATE_RFC3339).":https://www.csai.cn/baoxian/ 内容获取失败");
            return;
        }
        $this->info(date('Y-m-d H:i:s')." 列表页：https://www.csai.cn/baoxian/");
        $this->baoxianlist($author->id, $tag->id, $html);
    }

    public function gupiao(Author $author)
    {
        $tag = $this->tag('股票');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 83; $i++) {
            if ($i == 1) {
                $url = 'https://www.csai.cn/zhishi/stock/';
            } else {
                $url = "https://www.csai.cn/zhishi/stock_{$i}";
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

    public function jijin(Author $author)
    {
        $tag = $this->tag('基金');
        if (empty($tag)) {
            return;
        }

        for ($i = 1; $i <= 299; $i++) {
            if ($i == 1) {
                $url = 'https://www.csai.cn/zhishi/jijin/';
            } else {
                $url = "https://www.csai.cn/zhishi/jijin_{$i}";
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

        for ($i = 1; $i <= 727; $i++) {
            if ($i == 1) {
                $url = 'https://www.csai.cn/zhishi/creditcard/';
            } else {
                $url = "https://www.csai.cn/zhishi/creditcard_{$i}";
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

    public function shengqian(Author $author)
    {
        $tag = $this->tag('省钱');
        if (empty($tag)) {
            return;
        }

        $url = 'https://www.csai.cn/shengqian/';
        $html = $this->fetchUrlHtml($url);
        if (empty($html)) {
            $this->error(date(DATE_RFC3339).":{$url} 内容获取失败");
            return;
        }
        $this->info(date('Y-m-d H:i:s')." 列表页：{$url}");
        $this->list($author->id, $tag->id, $html);
    }

    public function zhuanqian(Author $author)
    {
        $tag = $this->tag('赚钱');
        if (empty($tag)) {
            return;
        }

        $url = 'https://www.csai.cn/zhuanqian/';
        $html = $this->fetchUrlHtml($url);
        if (empty($html)) {
            $this->error(date(DATE_RFC3339).":{$url} 内容获取失败");
            return;
        }
        $this->info(date('Y-m-d H:i:s')." 列表页：{$url}");
        $this->list($author->id, $tag->id, $html);
    }

    public function tag(string $name)
    {
        return Classify::where(['type' => 2, 'name' => $name])->first();
    }

    public function list($authorId, $tagId, $html)
    {
        QueryList::getInstance()
            ->html($html)
            ->find('.pc_list')
            ->htmls()
            ->each(
                function ($html) use ($tagId, $authorId) {
                    $rs = QueryList::getInstance()
                        ->html($html)
                        ->rules(
                            [
                                'img' => ['img', 'attr(src)'],
                                'article' => ['.slt a', 'attr(href)']
                            ]
                        )
                        ->queryData();
                    if (count($rs) == 2) {
                        $this->detail($authorId, $tagId, 'https://www.csai.cn' . $rs['article'], $rs['img']);
                    }
                }
            );
    }

    public function baoxianlist($authorId, $tagId, $html)
    {
        QueryList::getInstance()
            ->html($html)
            ->find('.bxzs-box .yw_itme')
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
                        if (strpos($rs['img'], 'https') !== 0) {
                            $rs['img'] = 'https:' . $rs['img'];
                        }
                        $this->detail($authorId, $tagId, 'https://www.csai.cn' . $rs['article'], $rs['img']);
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
                    'contont' => ['#wenzhang_main', 'html', '-.wzbq_box'],
                ]
            )
            ->queryData();
        $article['seo_title'] = str_replace('-希财网', '_多广网', $article['seo_title']);
        $article['author_id'] = $authorId;
        $article['photo'] = $img;
        $article['knowledge'] = 2;
        $article['classify_id'] = $tagId;
        $article['is_hot'] = rand(0, 1);
        $article['reading_volume'] = rand(100, 10000);
        $article['created_at'] = $article['updated_at'] = date('Y-m-d H:i:s');
        $article['contont'] = preg_replace('|<p style="text-align: center;">如果.*</p>|', '', $article['contont']);
        $article['contont'] = preg_replace('|<p style="text-align: center;">免费.*</p>|', '', $article['contont']);
        $article['contont'] = preg_replace('|<p style="text-align: center;"><a.*</p>|', '', $article['contont']);
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
