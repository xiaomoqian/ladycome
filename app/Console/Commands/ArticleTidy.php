<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class ArticleTidy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'a:t';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '文章内容清洗';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Article::all()->each(function (Article $article) {
            $article->contont = strip_tags($article->contont, '<p><img>');
            $article->contont = str_replace('希财', '多广', $article->contont);
            $article->contont = str_replace('点击查看', '查看', $article->contont);
            $article->contont = str_replace('<p>      投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。</p>', '', $article->contont);
            $article->contont = str_replace('<p style="TEXT-ALIGN: left">      投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小 。</p>', '', $article->contont);
            $article->contont = str_replace('<p style="white-space: normal;">　　投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。</p>', '', $article->contont);
            $article->contont = str_replace('<p style="; ; ; color: rgb(51, 51, 51); line-height: 30px; white-space: normal; widows: 2; font-stretch: normal; font-family: \'microsoft yahei\', 宋体, Arial, Helvetica, sans-serif; orphans: 2; background-color: rgb(255, 255, 255);">投资理财用钱生钱，多广网联合众多专业品牌及优质P2P网贷平台，为您提供预期年化预期收益高风险小的网贷服务（http://www.csai.cn/p2p/），进入栏目了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('<p style="; ; ; color: rgb(51, 51, 51); line-height: 30px; white-space: normal; widows: 2; font-stretch: normal; font-family: \'microsoft yahei\', 宋体, Arial, Helvetica, sans-serif; orphans: 2; background-color: rgb(255, 255, 255);">　　投资理财用钱生钱，多广网联合众多专业品牌，为您提供预期年化预期收益高风险小的优质P2P网贷（http://www.csai.cn/p2p/），点击了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('<p>　　投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——为方便投资者有更多更优的选择，多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。进入栏目了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('p style="; ; white-space: normal; ; widows: 2; font-stretch: normal; line-height: 30px; font-family: \'microsoft yahei\', 宋体, Arial, Helvetica, sans-serif; orphans: 2; color: rgb(51, 51, 51); background-color: rgb(255, 255, 255);">　　投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——为方便投资者有更多更优的选择，多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。进入栏目了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('（http://www.csai.cn/product/jijin-0-3-1.html）', '', $article->contont);
            $article->contont = str_replace('<p>        投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。</p>', '', $article->contont);
            $article->contont = str_replace('<p>      投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。</p>', '', $article->contont);
            $article->contont = str_replace('<p> 　　投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。</p>', '', $article->contont);
            $article->contont = str_replace('<p style="PADDING-BOTTOM: 12px; WIDOWS: 2; TEXT-TRANSFORM: none; BACKGROUND-COLOR: rgb(255,255,255); TEXT-INDENT: 0px; MARGIN: 0px; PADDING-LEFT: 0px; LETTER-SPACING: normal; PADDING-RIGHT: 0px; FONT: 16px/30px \'microsoft yahei\', 宋体, Arial, Helvetica, sans-serif; WHITE-SPACE: normal; ORPHANS: 2; COLOR: rgb(51,51,51); WORD-SPACING: 0px; PADDING-TOP: 12px; -webkit-text-size-adjust: auto; -webkit-text-stroke-width: 0px">　　投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——为方便投资者有更多更优的选择，多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。进入栏目了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('<p style="white-space: normal; color: rgb(51, 51, 51); line-height: 30px; widows: 2; font-stretch: normal; font-family: \'microsoft yahei\', 宋体, Arial, Helvetica, sans-serif; orphans: 2; background-color: rgb(255, 255, 255);">　　投资理财用钱生钱，多广网联合众多专业品牌及优质P2P网贷平台，为您提供预期年化预期收益高风险小的网贷服务（http://www.csai.cn/p2p/），进入栏目了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('<p style="; ; ; color: rgb(51, 51, 51); font-family: \'microsoft yahei\', 微软雅黑, Arial, Helvetica, sans-serif; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);">　　投资理财用钱生钱，多广网联合众多专业品牌及优质P2P网贷平台，为您提供预期年化预期收益高风险小的网贷服务（http://www.csai.cn/p2p/），进入栏目了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('<p style="text-align:left;">　　投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。</p>', '', $article->contont);
            $article->contont = str_replace('<p style="; ; ; color: rgb(51, 51, 51); line-height: 30px; white-space: normal; widows: 2; font-stretch: normal; font-family: \'microsoft yahei\', 宋体, Arial, Helvetica, sans-serif; orphans: 2; background-color: rgb(255, 255, 255);">　　投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——为方便投资者有更多更优的选择，多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。进入栏目了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('<p style="; ; ; color: rgb(51, 51, 51); line-height: 30px; white-space: normal; widows: 2; font-stretch: normal; font-family: \'microsoft yahei\', 宋体, Arial, Helvetica, sans-serif; orphans: 2; background-color: rgb(255, 255, 255);">　　投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——为方便投资者有更多更优的选择，多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。进入栏目了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('<p style="; ; ; color: rgb(51, 51, 51); line-height: 30px; white-space: normal; widows: 2; font-stretch: normal; font-family: \'microsoft yahei\', 宋体, Arial, Helvetica, sans-serif; orphans: 2; background-color: rgb(255, 255, 255);">　　投资理财用钱生钱，多广网联合众多专业品牌及优质P2P网贷平台，为您提供预期年化预期收益高风险小的网贷服务（http://www.csai.cn/p2p/），进入栏目了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('<p>　　投资理财用钱生钱，多广网联合众多专业品牌及优质P2P网贷平台，为您提供预期年化预期收益高风险小的网贷服务（http://www.csai.cn/p2p/），进入栏目了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('<p>       投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。</p>', '', $article->contont);
            $article->contont = str_replace('<p>　　投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。</p>', '', $article->contont);
            $article->contont = str_replace('<p>　　多广网P2P理财超市(‍http://www.csai.cn/p2p/)精选多家知名平台，提供独特的安全保障体系，历史预期年化预期收益8%-14%，一个账户搞定多个平台，为用户提供搜索、导购对比等投资工具，帮助用户挑选合适的理财产品。</p>', '', $article->contont);
            $article->contont = str_replace('<p>　　投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。</p>', '', $article->contont);
            $article->contont = str_replace('<p style="; ; ; color: rgb(51, 51, 51); font-family: \'microsoft yahei\', 微软雅黑, Arial, Helvetica, sans-serif; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);">　　投资理财用钱生钱，资金短缺，急需用钱？多广网帮你忙——为方便投资者有更多更优的选择，多广网联合众多专业品牌，打造资质优秀的P2P网贷平台（http://www.csai.cn/p2p/），让你的资金预期年化预期收益更多，风险更小。进入栏目了解详情：</p>', '', $article->contont);
            $article->contont = str_replace('多广网P2P理财超市(http://www.csai.cn/p2p/)精选多家知名平台，提供独特的安全保障体系，一个账户搞定多个平台，为用户提供导购建议，方便用户选择投资。', '', $article->contont);
            $article->contont = str_replace('<p>　　多广网P2P理财超市(http://www.csai.cn/p2p/)精选多家知名平台，提供独特的安全保障体系，历史预期年化预期收益8%-14%，一个账户搞定多个平台，为用户提供搜索、导购对比等投资工具，帮助用户挑选合适的理财产品。</p>', '', $article->contont);
            $article->contont = str_replace('（www.csai.cn）', '', $article->contont);
            $article->contont = str_replace('(http://www.csai.cn/p2p/)', '', $article->contont);
            $article->contont = str_replace('同程借钱


¥1000~20万
额度范围（元）


查看', '', $article->contont);
            $article->contont = str_replace('

同程借钱


¥1000~20万
额度范围（元）


查看







              ', '', $article->contont);
            $article->contont = str_replace('

小橙花


¥1000~20万
额度范围（元）


查看







', '', $article->contont);
            $article->contont = str_replace('

百信银行


¥500~20万
额度范围（元）


查看





', '', $article->contont);
            $article->contont = str_replace('

借你用


¥500~20万
额度范围（元）


查看







', '', $article->contont);
            $article->contont = str_replace('

招联好期贷


¥2000~5万
额度范围（元）


查看





', '', $article->contont);
            $article->contont = str_replace('

360借条


¥500~20万
额度范围（元）


查看







', '', $article->contont);
            $article->contont = str_replace('

任性贷


¥500~30万
额度范围（元）


查看





', '', $article->contont);
            $article->contont = str_replace('<img class="item_img non_content" src="https://static.csai.cn/csai_cms/dkdh/2020-02/983/20200224102454327.jpg" style="width: 50px;height: 50px;border-radius: 8px;">', '', $article->contont);
            $article->contont = str_replace('<img class="item_img non_content" src="https://static.csai.cn/csai_cms/dkdh/2019-12/259/20191217120400157.jpg" style="width: 50px;height: 50px;border-radius: 8px;">', '', $article->contont);
            $article->contont = str_replace('<img class="item_img non_content" src="https://static.csai.cn/csai_cms/dkdh/2020-02/645/20200221171014595.png" style="width: 50px;height: 50px;border-radius: 8px;">', '', $article->contont);
            $article->contont = str_replace('<img class="item_img non_content" src="https://static.csai.cn/csai_cms/dkdh/2020-04/357/20200426150900396.png" style="width: 50px;height: 50px;border-radius: 8px;">', '', $article->contont);
            $article->contont = str_replace('<img class="item_img non_content" src="https://static.csai.cn/csai_cms/dkdh/2020-05/685/20200527115803996.png" style="width: 50px;height: 50px;border-radius: 8px;">', '', $article->contont);
            $article->contont = str_replace('<img class="item_img non_content" src="https://static.csai.cn/csai_cms/dkdh/2020-07/38/20200702111116731.png" style="width: 50px;height: 50px;border-radius: 8px;">', '', $article->contont);
            $article->contont = str_replace('<img class="item_img non_content" src="https://static.csai.cn/csai_cms/dkdh/2020-07/424/20200727140800801.png" style="width: 50px;height: 50px;border-radius: 8px;">', '', $article->contont);
            $article->contont = str_replace('





贷款产品
更多





', '', $article->contont);
            $article->seo_desc = str_replace('希财', '多广', $article->seo_desc);
            $article->seo_title = str_replace('希财', '多广', $article->seo_title);
            $article->seo_keywords = str_replace('希财', '多广', $article->seo_keywords);
            $article->save();
        });
    }
}
