<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('author')->truncate();
        DB::table('classify')->truncate();

        $author = [
            'user_name' => 'aicaidashixiong',
            'user_password' => bcrypt('1234567890ABC'),
            'author_name' => '爱财大师兄',
            'desc' => '爱理财如命大师兄',
            'certification_mark' => '财经作者',
            'field' => '全能型人才',
            'is_hot' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        DB::table('author')->insert($author);

        $tags = [
            // 问答分类：省钱、贷款、保险、理财、信用卡、赚钱
            [
                'type' => 1,
                'name' => '省钱',
                'photo' => '',
                'seo_title' => '生活省钱小窍门_怎么省钱_有什么好的省钱方法_问答_多广网',
                'seo_keywords' => '省钱小窍门',
                'seo_desc' => '本频道提供生活省钱小窍门介绍，关于生活中怎么省钱、有什么好的省钱方法，欢迎通过本频道进行讨论和沟通。',
                'is_reveal' => 1,
            ],
            [
                'type' => 1,
                'name' => '贷款',
                'photo' => '',
                'seo_title' => '贷款问题大全_贷款口子哪个好_贷款_多广网',
                'seo_keywords' => '贷款问题,贷款口子哪个好,个人小额贷款',
                'seo_desc' => '贷款问答频道提供贷款相关的问题及专家解答，其中包括贷款口子哪个好、小额贷款哪里好贷及各类贷款APP怎么申请等相关的贷款问题大全。，关于生活中怎么省钱、有什么好的省钱方法，欢迎通过本频道进行讨论和沟通。',
                'is_reveal' => 1,
            ],
            [
                'type' => 1,
                'name' => '保险',
                'photo' => '',
                'seo_title' => '买什么保险好又保障_专业保险问答平台_保险_多广网问答',
                'seo_keywords' => '买什么保险好,保险问答平台',
                'seo_desc' => '保险问答频道提供保险相关的问题及解决方法，其中包括:买什么保险好又保障、适合小孩的保险、养老保险、大病保险、社会保险、汽车保险哪家好等保险类的问答大全。',
                'is_reveal' => 1,
            ],
            [
                'type' => 1,
                'name' => '理财',
                'photo' => '',
                'seo_title' => '理财知识问答大全_理财产品有多少种_理财_多广网问答',
                'seo_keywords' => '理财问答,理财知识,理财产品',
                'seo_desc' => '理财问答频道提供理财产品介绍、理财方式有哪些、理财有风险吗、理财app知识及使用方法介绍等所有理财相关的知识汇总。',
                'is_reveal' => 1,
            ],
            [
                'type' => 1,
                'name' => '信用卡',
                'photo' => '',
                'seo_title' => '信用卡问答大全_信用卡使用方法和注意事项_信用卡_多广网问答',
                'seo_keywords' => '信用卡问答,信用卡相关问题,信用卡使用方法,信用卡注意事项',
                'seo_desc' => '信用卡问答频道提供信用卡申请使用及注意事项等相关的问题汇总，其中包含各大银行信用卡的申请、取现、还款、逾期还款等全方位的解答。',
                'is_reveal' => 1,
            ],
            [
                'type' => 1,
                'name' => '赚钱',
                'photo' => '',
                'seo_title' => '赚钱精选问答_多广网问答',
                'seo_keywords' => '赚钱知识,赚钱问答',
                'seo_desc' => '本频道提供赚钱相关的专业知识、问答',
                'is_reveal' => 1,
            ],
            // 知识分类：理财\保险\股票\基金\信用卡\省钱\赚钱
            [
                'type' => 2,
                'name' => '理财',
                'photo' => '',
                'seo_title' => '银行理财知识_基础入门_产品知识_多广网',
                'seo_keywords' => '银行理财知识,银行理财产品知识,银行理财小知识,银行理财基础知识',
                'seo_desc' => '银行理财知识栏目，为您提供银行理财基础知识入门，银行理财产品知识以及银行理财小知识等内容。',
                'is_reveal' => 1,
            ],
            [
                'type' => 2,
                'name' => '保险',
                'photo' => '',
                'seo_title' => '保险门户_保险课堂_保险评测_投保攻略_多广网',
                'seo_keywords' => '保险课堂,保险评测,投保攻略',
                'seo_desc' => '保险频道为您提供保险知识大全，其中包括保险基础知识、保险视频课程、保险评测、保险攻略、投保指南、保险产品资料介绍等内容。',
                'is_reveal' => 1,
            ],
            [
                'type' => 2,
                'name' => '股票',
                'photo' => '',
                'seo_title' => '股票知识_入门基础知识_K线图基础_多广网',
                'seo_keywords' => '股票知识,股票入门基础知识,股票K线图基础知识,股票知识入门,股票基础知识',
                'seo_desc' => '为您提供通俗易懂的股票知识入门，助您快速学习股票K线图基础知识，学习如何股票开户，如何新股中签等各种股票知识入门。',
                'is_reveal' => 1,
            ],
            [
                'type' => 2,
                'name' => '基金',
                'photo' => '',
                'seo_title' => '基金知识_多广网',
                'seo_keywords' => '基金知识,基金百科',
                'seo_desc' => '基金百科栏目提供丰富的基金知识。',
                'is_reveal' => 1,
            ],
            [
                'type' => 2,
                'name' => '信用卡',
                'photo' => '',
                'seo_title' => '信用卡知识_多广网',
                'seo_keywords' => '信用卡知识,信用卡百科',
                'seo_desc' => '希财网信用卡百科栏目提供丰富的信用卡知识。',
                'is_reveal' => 1,
            ],
            [
                'type' => 2,
                'name' => '省钱',
                'photo' => '',
                'seo_title' => '生活省钱技巧_生活中省钱存钱的方法_省钱攻略_多广网',
                'seo_keywords' => '信用卡知识,信用卡百科',
                'seo_desc' => '本频道提供生活省钱方法介绍，其中包括：房产、家居、装修、母婴、育儿、旅游、日常生活等方面的省钱绝招，欢迎关注本栏目探讨省钱攻略。',
                'is_reveal' => 1,
            ],
            [
                'type' => 2,
                'name' => '赚钱',
                'photo' => '',
                'seo_title' => '日常赚钱技巧_生活中赚钱增收的方法_赚钱攻略_多广网',
                'seo_keywords' => '赚钱攻略',
                'seo_desc' => '本频道提供低成本副业赚钱方法介绍，其中包括0成本居家赚钱、业余赚钱、手机赚钱、学生赚钱的方法等，欢迎关注本栏目收获赚钱攻略。',
                'is_reveal' => 1,
            ],
            // 话题分类：信用卡、理财、贷款、股票、保险、房贷
            [
                'type' => 3,
                'name' => '房贷',
                'photo' => '',
                'seo_title' => '房贷资讯_让房贷申请更简单_多广网',
                'seo_keywords' => '房贷',
                'seo_desc' => '怎么申请房贷容易下款，房贷下款后怎么还最划算，怎么计算房贷利率，关注多广网房贷话题，了解房贷最新资讯。',
                'is_reveal' => 1,
            ],
            [
                'type' => 3,
                'name' => '保险',
                'photo' => '',
                'seo_title' => '购买保险注意什么_保险_保险怎么买_多广网',
                'seo_keywords' => '购买保险注意什么',
                'seo_desc' => '在生活中越来越多的人开始购买保险，这时在购买时需要注意很多方面，比如保险的保障范围、投保的年龄要求、投保的时间等，还需要后续理赔的手续，再有就是每年需要支付多少钱，自己的家庭是否能够负担。',
                'is_reveal' => 1,
            ],
            [
                'type' => 3,
                'name' => '股票',
                'photo' => '',
                'seo_title' => '股票_多广网',
                'seo_keywords' => '股票',
                'seo_desc' => '更接底气，更简单，更直白的了解财经知识，让专业知识变得更简单易懂，汇织梦想 财聚人生',
                'is_reveal' => 1,
            ],
            [
                'type' => 3,
                'name' => '贷款',
                'photo' => '',
                'seo_title' => '贷款_多广网',
                'seo_keywords' => '贷款',
                'seo_desc' => '什么情况可以申请贷款，大额贷款的审批条件是什么，需要提交哪些资料，银行关于贷款的最新规定有哪些？关注织梦财经贷款专题，了解贷款行业最新资讯。 ',
                'is_reveal' => 1,
            ],
            [
                'type' => 3,
                'name' => '理财',
                'photo' => '',
                'seo_title' => '投资理财注意什么_理财产品_投资技巧_多广网',
                'seo_keywords' => '投资理财注意什么',
                'seo_desc' => '投资理财可以让自己的财富不断的增加，不过在投资理财时需要注意很多方面，比如理财产品的收益、投资风险、手续费、能否提前赎回等，这些在投资理财时都必须弄清楚，否则后续极易产生纠纷。 ',
                'is_reveal' => 1,
            ],
            [
                'type' => 3,
                'name' => '信用卡',
                'photo' => '',
                'seo_title' => '信用卡用卡常识和小技巧_信用卡资讯追踪_多广网',
                'seo_keywords' => '信用卡',
                'seo_desc' => '怎么申请信用卡才能成功下卡，使用信用卡过程中需要注意什么，如何有效快速提额，关注织梦财经信用卡话题，让你了解更多相关知识，用卡无忧。',
                'is_reveal' => 1,
            ],
        ];
        foreach ($tags as $k => $tag) {
            $tags[$k]['created_at'] = $tags[$k]['updated_at'] = date("Y-m-d H:i:s");
        }

        DB::table("classify")->insert($tags);
    }
}
