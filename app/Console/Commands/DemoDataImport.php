<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DemoDataImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'd:i';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '演示数据导入';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $json = file_get_contents(storage_path('articles.json'));
        $articles = json_decode($json, true);
        unset($json);
        DB::table('article')->truncate();
        $current = 0;
        $total = count($articles);
        while ($article = array_shift($articles)) {
            DB::table('article')->insert($article);
            $this->info(sprintf("共%d个，第%d个完成导入", $total, $current + 1));
            $current++;
            unset($article);
        }
    }
}
