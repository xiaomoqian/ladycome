<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ApiPush implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $url;

    private $articles;

    /**
     * Create a new job instance.
     *
     * @param  string  $url
     * @param  array  $articles
     */
    public function __construct(string $url, array $articles)
    {
        $this->url = $url;
        $this->articles = $articles;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->articles)) {
            return;
        }

        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $this->url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $this->articles),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $rs = curl_exec($ch);
        Log::info("百度推送[{$this->url}]结果：" . $rs);
    }
}
