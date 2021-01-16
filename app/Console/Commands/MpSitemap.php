<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class MpSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpsitemap:gen';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '小程序站点地图生成';

    protected $filePath;

    public function __construct()
    {
        parent::__construct();
        $this->filePath = public_path('mpsitemap.txt');
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        file_exists($this->filePath) ? $this->append() : $this->new();
    }

    /**
     * 追加sitemap
     */
    private function append()
    {
        $timeStart = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $timeEnd = date('Y-m-d 23:59:59', strtotime('-1 day'));

        $content = file_get_contents($this->filePath);

        Author::whereBetween('created_at', [$timeStart, $timeEnd])
            ->select('id')
            ->get()
            ->each(function (Author $author) use (&$content) {
                $content .= "pages/author/author?id={$author->id}\n";
            });

        Article::whereBetween('created_at', [$timeStart, $timeEnd])
            ->select(['id', 'knowledge'])
            ->each(function (Article $article) use (&$content) {
                switch ($article->knowledge) { // 1=问答，2=知识文章,3=话题'
                    case "1":
                        $content .= "pages/zsinfo/zsinfo?id={$article->id}&type=wd\n";
                        break;
                    case "2":
                        $content .= "pages/zsinfo/zsinfo?id={$article->id}&type=zs\n";
                        break;
                    case "3":
                        $content .= "pages/htinfo/htinfo?id={$article->id}\n";
                        break;
                    default:
                        //
                }
            });

        file_put_contents($this->filePath, $content);
    }

    /**
     * 新建sitemap
     */
    private function new()
    {
        $initContent = "pages/index/index\n".
            "pages/huati/huati\n".
            "pages/zhishi/zhishi\n".
            "pages/wenda/wenda\n".
            "pages/tool/tool?id=fd\n".
            "pages/tool/tool?id=gjj\n".
            "pages/tool/tool?id=zhdk\n".
            "pages/tool/tool?id=tqhk\n".
            "pages/tool/tool?id=gz\n".
            "pages/tool/tool?id=lcsy\n".
            "pages/tool/tool?id=nzj\n".
            "pages/tool/tool?id=wxyj\n";

        Author::select('id')->get()->each(function (Author $author) use (&$initContent) {
            $initContent .= "pages/author/author?id={$author->id}\n";
        });
        Article::select(['id', 'knowledge'])->each(function (Article $article) use (&$initContent) {
            switch ($article->knowledge) { // 1=问答，2=知识文章,3=话题'
                case "1":
                    $initContent .= "pages/zsinfo/zsinfo?id={$article->id}&type=wd\n";
                    break;
                case "2":
                    $initContent .= "pages/zsinfo/zsinfo?id={$article->id}&type=zs\n";
                    break;
                case "3":
                    $initContent .= "pages/htinfo/htinfo?id={$article->id}\n";
                    break;
                default:
                    //
            }
        });

        file_put_contents($this->filePath, $initContent);
    }
}
