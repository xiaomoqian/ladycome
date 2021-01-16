<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class DemoDataExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'd:e';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '演示数据导出';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $articles = Article::all()->toArray();

        $json = json_encode($articles, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        file_put_contents(storage_path('articles.json'), $json);
    }
}
