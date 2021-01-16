<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Cache-Control" content="no-transform" />
  <meta name="applicable-device" content="pc,mobile" />
  <meta name="format-detection" content="telphone=no" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  @foreach($seo as $key => $value)
    @if($value['page_type'] == 11)
      <meta name="description" content="{{$value['seo_desc']??""}}">
      <meta name="keywords" content="{{$value['seo_keywords']??""}}">
      <title>{{$value['seo_title']??""}} - 多广</title>
    @break
  @endif
@endforeach
  <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/utils.css') }}">
  <link rel="shortcut icon" href="{{asset('image/favicon.ico')}}" type="image/x-icon">

  <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
  <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
  <!--[if lt IE 9]>
      <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
  <style>
    .mb-1 {
      margin-bottom: 20px !important;
    }

    .ml-2 {
      margin-left: 20px;
    }
  </style>
</head>

<body>
  <header class="row">
    <div class="container">
      <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <!--header section -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('index')}}">
              <img src="{{isset($logo['logo']) && $logo['logo'] != ""?strstr($logo['logo'],'http')?$logo['logo']:asset("/storage/".$logo['logo']):asset("/storage/images/Koala.jpg")}}" alt="">
            </a>
          </div>
          <!-- menu section -->
          <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="{{route('index')}}">首页</a></li>
              <li><a href="{{route('knowledge')}}">知识</a></li>
              <li><a href="{{route('qa')}}">问答</a></li>
              <li><a href="{{route('ht')}}">话题</a></li>
              <li><a class="active" href="/utils">工具</a></li>
              <li class="navbar-ruzhu hidden-xs"><a href="{{route('help',['type' => "join"])}}" style="color: #fff !important;">入驻</a></li>
              <form action="{{route('search')}}" method="get" class="navbar-form navbar-right" role="search">
                <div class="form-group">
                  <input type="text" name="title" class="form-control" placeholder="搜索">
                  <button class="icon" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
              </form>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <div class="container">
    <div class="container-box">
      <div class="row">
        <div class="container-box__content">
          <div class="nav">当前位置：<a href="{{route('index')}}">多广网</a>><a href="/utils">工具</a>>年终奖计算器</div>
          <div class="hd">
            <div class="tool-nav clearfix">
              <a stat-info="jrmall_pc_fangdaical_fangdai" href="/utils" title="房贷计算器">房贷计算器</a>
              <a stat-info="jrmall_pc_fangdaical_fangdai" href="/utils/gjj" title="公积金贷款计算器">公积金贷款计算器</a>
              <a stat-info="jrmall_pc_fangdaical_fangdai" href="/utils/zuhe" title="组合贷款计算器">组合贷款计算器</a>
              <a stat-info="jrmall_pc_fangdaical_fangdai" href="/utils/tiqian" title="提前还款计算器">提前还款计算器</a>
              <a stat-info="jrmall_pc_fangdaical_licai" href="/utils/licai" title="理财收益计算器">理财收益计算器</a>
              <a stat-info="jrmall_pc_fangdaical_gongzi" href="/utils/gongzi" title="工资计算器">工资计算器</a>
              <a stat-info="jrmall_pc_fangdaical_chedai" href="/utils/nzj" title="年终奖计算器" class="active">年终奖计算器</a>
              <a stat-info="jrmall_pc_fangdaical_shenjia" href="/utils/wxyj" title="五险一金计算器">五险一金计算器</a>
            </div>
          </div>
          <div class="container">
            <form style="margin: 20px auto auto auto;max-width:400px;">
              <b style="font-weight: bold;font-size: 20px;">年终奖计算器</b>
              <div class="input-group mb-1">
                <div class="input-group-addon">
                  <span class="input-group-text">城市</span>
                </div>
                <select class="form-control" id="selRepay" onchange="selRepay_onchange();">
                  <option fei="1" value="20-8-10-2-1-0.2-0.3-0.8-12-12-21258-2834-21258-1955" selected="selected">北京</option>
                  <option fei="1" value="22-8-12-2-2-0.2-0.5-0.5-7-12-17817-3536-17817-2020">上海</option>
                  <option fei="1" value="14-8-6.5-2-2-1-0.8-0.5-13-13-12615-2336-24588-1500">深圳</option>
                  <option fei="1" value="14-8-6.5-2-2-1-0.8-0.5-13-13-12303-2461-26565-1550">广州</option>
                  <option fei="1" value="20-8-10-2-2-1-0.5-0.8-11-11-9380-1720-9380-1160">天津</option>
                  <option fei="1" value="20-8-9-2-1-0.5-0.5-0.5-8-8-16200-2628-18200-1770">南京</option>
                  <option fei="1" value="20-8-8-2-1.5-0.5-0.5-0.7-8-8-12994.8-2599-22733.75-1300">武汉</option>
                  <option fei="1" value="14-8-11.5-2-1.5-0.5-0.5-1.2-12-12-12093-2418.6-17302-1860">杭州</option>
                  <option fei="1" value="18-8-6-2-1-1-0.6-0.6-7-7-8832-1178-8832-0">重庆</option>
                  <option fei="1" value="20-8-8-2-2-1-0.5-0.8-8-8-7776-1556-7776-0">济南</option>
                  <option fei="1" value="20-8-7-2-2-1-0.5-0.5-8-8-7572-1514.4-7572-0">西安</option>
                  <option fei="1" value="20-8-7.5-2-2-1-0.6-0.6-7-7-6819-1364-6819-0">成都</option>
                  <option fei="1" value="20-8-8-2-2-1-0.5-1-8-8-16208-2387-15440-0">苏州</option>
                  <option fei="1" value="20-8-6-2-2-1-0.4-0.8-8-8-7611-1522.2-7611-0">南昌</option>
                  <option fei="1" value="20-8-6.5-2-1.5-0.5-0.6-0.5-10-6-3873-774.6-3873-774.6">太原</option>
                  <option fei="1" value="20-8-8-2-8-1-0.5-0.8-11-7-7095-1419-7095-0">石家庄</option>
                </select>
              </div>
              <div class="input-group mb-1">
                <div class="input-group-addon">
                  <span class="input-group-text">税前月薪</span>
                </div>
                <input type="text" class="form-control salary" id="txtRate" value="" />
                <div class="input-group-addon">
                  <span class="input-group-text">元</span>
                </div>
              </div>
              <div class="input-group mb-1">
                <div class="input-group-addon">
                  <span class="input-group-text">税前年终奖</span>
                </div>
                <input type="text" class="form-control nianzhong" id="txtRate" value="" />
                <div class="input-group-addon">
                  <span class="input-group-text">元</span>
                </div>
              </div>
              <div class="mb-1" style="text-align: center;">
                <button type="button" class="btn btn-primary" id="btnCalc" onclick="btnCalc_onclick();" style="display: inline-block;font-weight: 400;text-align: center;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;border: 1px solid transparent;padding: .375rem .75rem;font-size: 1rem;line-height: 1.5;border-radius: .25rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;">计 算</button>
                <button type="button" class="btn btn-warning ml-2" id="btnReset" onclick="btnReset_onclick()" style="display: inline-block;font-weight: 400;text-align: center;vertical-align: middle;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;border: 1px solid transparent;padding: .375rem .75rem;font-size: 1rem;line-height: 1.5;border-radius: .25rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;">重置</button>
              </div>
            </form>
            <form style="margin: 20px auto auto auto;max-width:400px;">
              <b style="font-weight: bold;font-size: 20px;">计算结果</b>
              <div class="input-group mb-1 nianshuihou">
                <div class="input-group-addon">
                  <span class="input-group-text">税后年终奖</span>
                </div>
                <input type="text" disabled class="form-control" id="txtRate" value="" />
                <div class="input-group-addon">
                  <span class="input-group-text">元</span>
                </div>
              </div>
              <div class="input-group mb-1 geshui">
                <div class="input-group-addon">
                  <span class="input-group-text">个人所得税</span>
                </div>
                <input type="text" disabled class="form-control" id="txtRate" value="" />
                <div class="input-group-addon">
                  <span class="input-group-text">元</span>
                </div>
              </div>
            </form>
          </div>
          <div class="container-box__content--body tool-wrap">
            <div class="fd">
              <div class="tool-con">
                <div class="count-box">
                </div>
              </div>
            </div>
          </div>
          <div class="ad">
            @foreach($advert as $key => $value)
              @if($value['type'] == 1 && $value['advert_type'] == '4')
                {!! $value['code'] !!}
              @break
            @endif
          @endforeach
          <!-- 工具广告A -->
          </div>
          <div class="mad" style="padding: 0 15px;">
            @foreach($advert as $key => $value)
              @if($value['type'] == 2 && $value['advert_type'] == '8')
                {!! $value['code'] !!}
              @break
            @endif
          @endforeach
          <!-- 手机工具广告A -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer">
    <div class="container">
      <div class="container-tip">
        <div class="container-tip__title">{{$help[7][0]['title']??""}}</div>
        {!! $help[7][0]['content']??"" !!}
      </div>

      <div class="container-link">
        <span>友情链接</span>
        @if(isset($help[6]) && is_array($help[6]))
        @foreach($help[6] as $key => $value)
        <a target="_blank" href="{{$value['url']}}">{{$value['title']??""}}</a>
        @endforeach
        @endif
      </div>
      <div class="container-banquan">
        <p>多广网 版权所有 © {{$help[8][0]['title']??""}}</p>
        <div>
          <a href="{{route('help',['type' => ""])}}">关于我们</a>
          <a href="{{route('help',['type' => "contact"])}}">联系我们</a>
          <a href="{{route('help',['type' =>"copy"])}}">版权声明</a>
          <a href="{{route('help',['type' =>"job"])}}">加入我们</a>
          <a href="{{route('help',['type' =>"join"])}}">入驻规则</a>
        </div>
      </div>

    </div>
  </div>
  <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
  <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
  <script src="{{asset('js/top.js')}}"></script>
  <script>
    function btnCalc_onclick() {

      //相关参数
      var yueStr = $('#selRepay').val().split('-');
      //工资总数
      var gong = parseFloat($('.salary').val());
      //年终奖
      var nian = parseFloat($(".nianzhong").val())
      var yuedata = {
        yanglaocom: yueStr[0],
        yanglaopre: yueStr[1],
        yiliaocom: yueStr[2],
        yiliaopre: yueStr[3],
        siyecom: yueStr[4],
        siyepre: yueStr[5],
        gongshangcom: yueStr[6],
        shengyucom: yueStr[7],
        gongjicom: yueStr[8],
        gongjipre: yueStr[9],
        shebaoup: yueStr[10],
        shebaodown: yueStr[11],
        gongjiup: yueStr[12],
        gongjidown: yueStr[13],
        gongjicard: gong,
        shebaocard: gong,
      }
      var c = 0
      var g = 0
      if (gong < 3500) {
        //应该纳税额
        c = (nian - (3500 - gong)) / 12
        //年中奖个人所得税
        g = 0
        if (c < 0) {
          g = 0
        } else if (c < 1500) {
          g = (nian - (3500 - gong)) * 0.03
        } else if (c < 4500) {
          g = (nian - (3500 - gong)) * 0.1 - 105
        } else if (c < 9000) {
          g = (nian - (3500 - gong)) * 0.2 - 555
        } else if (c < 35000) {
          g = (nian - (3500 - gong)) * 0.25 - 1005
        } else if (c < 55000) {
          g = (nian - (3500 - gong)) * 0.3 - 2755
        } else if (c < 80000) {
          g = (nian - (3500 - gong)) * 0.35 - 5505
        } else {
          g = (nian - (3500 - gong)) * 0.45 - 13505
        }
      } else {
        //应该纳税额
        c = nian / 12
        //年中奖个人所得税
        g = 0
        if (c < 0) {
          g = 0
        } else if (c < 1500) {
          g = nian * 0.03
        } else if (c < 4500) {
          g = nian * 0.1 - 105
        } else if (c < 9000) {
          g = nian * 0.2 - 555
        } else if (c < 35000) {
          g = nian * 0.25 - 1005
        } else if (c < 55000) {
          g = nian * 0.3 - 2755
        } else if (c < 80000) {
          g = nian * 0.35 - 5505
        } else {
          g = nian * 0.45 - 13505
        }
      }
      if (g < 0) {
        g = 0
      }
      var nianshuihou = nian - g
      $('.nianshuihou input').val(nianshuihou.toFixed(2));
      $('.geshui input').val(g.toFixed(2));
      //填充数据
      //年终奖
    }

    function btnReset_onclick() {
      $(".salary").val('')
      $(".nianzhong").val('')
      $('.geshui input').val('')
      $('.nianshuihou input').val('')
    }
  </script>
  <script>
  function setIframeHeight(iframe) {
	if (iframe) {
		var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
		if (iframeWin.document.body) {
      var height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
      $(iframe).css('height', height)
		}
	}
};


window.onload = function () {
	setIframeHeight(document.getElementById('FF'));
};

var query = location.search.split('=')
if (query.length > 0) {
  if (query[1] == 'xcx') {
    $('header,.footer,.nav,.hd').css('display', 'none')
    $('body,html').css('padding-top', 0)
  }
}


 </script>
</body>

</html>
