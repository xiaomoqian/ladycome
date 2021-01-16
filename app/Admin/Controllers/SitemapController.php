<?php

namespace App\Admin\Controllers;

use App\Jobs\ApiPush;
use App\Models\Article;
use Dcat\Admin\Form;
use Dcat\Admin\Form\StepForm;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Alert;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Table;

class SitemapController
{

    public function index(Content $content)
    {
        return $content
            ->header('站点地图')
            ->description('')
            ->body(
                function (Row $row) {
                    $row->column(
                        6,
                        function (Column $column) {
                            $url = route('sitemap.download');
                            $content = <<<HTML
                                <a href="{$url}" class="btn btn-sm btn-light shadow-none" target="_blank">站点地图下载</a>
HTML;
                            $card = Card::make('站点地图下载', $content);
                            $card->padding('15px 20px');
                            $card->footer('<span class="text-success">每天凌晨自动生成，点击下载即可。</span>');
                            $column->row($card);
                        }
                    );
                    $row->column(
                        6,
                        function (Column $column) {
                            $url = route('mpsitemap.download');
                            $content = <<<HTML
                                <a href="{$url}" class="btn btn-sm btn-light shadow-none" target="_blank">小程序sitemap下载</a>
HTML;
                            $card = Card::make('小程序sitemap下载', $content);
                            $card->padding('15px 20px');
                            $card->footer('<span class="text-success">每天凌晨自动生成，点击下载即可。</span>');
                            $column->row($card);
                        }
                    );
                }
            );
    }

    public function apilist(Content $content)
    {
        return $content
            ->body($this->form())
            ->header('百度链接提交');
    }

    public function form()
    {
        return Form::make(
            null,
            function ($form) {
                $form->title('链接提交');
                $form->action('apilist');
                $form->disableListButton();

                $form->multipleSteps()
                    ->width('950px')
                    ->add(
                        '百度推送API token',
                        function (StepForm $step) {
                            $info = '<i class="fa fa-exclamation-circle"></i>仅输入token，提交站点自动取当前站点。请确保输入框头尾没有任何不可见字符.';
                            $step->html(Alert::make($info)->info());
                            $step->text('token', 'token')->required();
                        }
                    )
                    ->add(
                        '今日更新内容',
                        function (StepForm $step) {
                            $articles = $this->todayArticles();
                            foreach ($articles as $k => $article) {
                                // 1=问答，2=知识文章,3=话题
                                if ($article['knowledge'] == 1) {
                                    $url = trim(config('app.url'), '/')."/zhishi/{$article['id']}.html";
                                    $type = "知识";
                                } elseif ($article['knowledge'] == 2) {
                                    $url = trim(config('app.url'), '/')."/wenda/{$article['id']}.html";
                                    $type = "问答";
                                } else {
                                    $url = trim(config('app.url'), '/')."/huati/{$article['id']}.html";
                                    $type = "话题";
                                }

                                $articles[$k] = [$url, $type];
                            }
                            $table = Table::make(['内容页地址', '内容类别'], $articles);

                            $step->html($table);
                        }
                    )
                    ->done(
                        function () use ($form) {
                            $resource = $form->getResource(0);
                            $data = [
                                'title' => '操作成功',
                                'description' => '已提交成功。',
                                'createUrl' => $resource,
                                'backUrl' => $resource,
                            ];

                            return view('admin::form.done-step', $data);
                        }
                    );
            }
        );
    }

    /**
     * 保存
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store()
    {
        return $this->form()->saving(
            function (Form $form) {
                $resource = $form->getResource(0);
                $form->multipleSteps()->flushStash();
                $token = trim($form->input('token'));
                $baiapi = sprintf('http://data.zz.baidu.com/urls?site=%s&token=%s', config('app.url'), $token);

                $articles = $this->todayArticles();
                $urls = [];
                foreach ($articles as $k => $article) {
                    // 1=问答，2=知识文章,3=话题
                    if ($article['knowledge'] == 1) {
                        $url = trim(config('app.url'), '/')."/zhishi/{$article['id']}.html";
                    } elseif ($article['knowledge'] == 2) {
                        $url = trim(config('app.url'), '/')."/wenda/{$article['id']}.html";
                    } else {
                        $url = trim(config('app.url'), '/')."/huati/{$article['id']}.html";
                    }

                    array_push($urls, $url);
                }

                $ch = curl_init();
                $options = array(
                    CURLOPT_URL => $baiapi,
                    CURLOPT_POST => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POSTFIELDS => implode("\n", $urls),
                    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
                );
                curl_setopt_array($ch, $options);
                $rs = json_decode(curl_exec($ch), true);
                if (isset($rs['error'])) {
                    $data = [
                        'title' => '提交失败',
                        'description' => $rs['message'] ?? '百度返回错误。',
                        'createUrl' => $resource,
                        'backUrl' => $resource,
                    ];

                    return response()->view('step.error-step', $data);
                } else {
                    return response(
                        $form->multipleSteps()
                            ->done()
                            ->render()
                    );
                }
            }
        )->store();
    }

    private function todayArticles()
    {
        return Article::whereBetween('updated_at', [date('Y-m-d 00:00:00'), date('Y-m-d H:i:s')])->get(
            ['id', 'knowledge']
        )->toArray();
    }
}
