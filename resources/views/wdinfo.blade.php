<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-transform"/>
    <meta name="applicable-device" content="pc,mobile"/>
    <meta name="format-detection" content="telphone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="{{$qa['seo_desc']??""}}">
    <meta name="keywords" content="{{$qa['seo_keywords']??""}}">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>{{$qa['title']??""}} - 多广</title>

    <!-- Bootstrap -->
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://lib.baomitu.com/Swiper/5.4.5/css/swiper.min.css">    
    <link rel="stylesheet" href="{{asset('css/info.css') }}">
    <link rel="shortcut icon" href="{{asset('image/favicon.ico')}}" type="image/x-icon">

    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
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
                  <li><a class="active" href="{{route('qa')}}">问答</a></li>
                  <li><a href="{{route('ht')}}">话题</a></li>
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
      <div class="container-news">
        <div class="row">
          <div class="container-news__left col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="container-news__left--box">
              <div class="nav">当前位置：<a href="{{route('index')}}">多广网</a>><a href="{{route('qa')}}">问答</a>><a href="#">{{$qa['title']??""}}</a></div>
              <h3>{{$qa['title']??""}}</h3>
              <p class="author">
                <a href="{{route('author',['id' => $qa['author_id']??""])}}">{{$qa['author_name']??""}}</a>
                {{$qa['created_at']??""}}
              </p>
               <!--<div class="desc">{{substr($qa['seo_desc'],0,79)."........."??""}}</div>-->
              <div class="desc">{{$qa['seo_desc']??""}}</div>
              <div class="content">
                <!-- 答案 -->
                {!! $qa['contont']??"" !!}
              </div>
              <div class="tags">
                <!-- 问答分类 -->
                @if(isset($qa['label']))
                  @foreach($qa['label'] as $k => $val)
                    <span><a href="{{route('wfenlei',['type' => $val['id']])}}">{{$val['name']}}</a></span>
                    {{-- <span>{{$val['name']}}</span> --}}
                  @endforeach
                @endif


              </div>
              <div class="ad">
              @if(isset($advert))
                @foreach($advert as $key => $value)
                  @if($value['type'] == 1 && $value['advert_type'] == '1')
                    {!! $value['code'] !!}
                  @break
                @endif
              @endforeach
                @endif
                <!-- 详情广告A -->
              </div>
              <div class="mad">
                <?php if(!isset($advert)) $advert = [];?>
                @foreach($advert as $key => $value)
                    @if($value['type'] == 2 && $value['advert_type'] == '6')
                      {!! $value['code'] !!}
                    @break
                  @endif
                @endforeach
                <!-- 手机详情广告A -->
              </div>
              <div class="tuijian">
                <div class="title"><span>相关问答</span></div>
                <ul>
                  @if(isset($relevant))
                    @foreach($relevant as $key => $value)
                      <li><a href="{{route('wdinfo',['id' => $value['id']])}}">{{$value['title']??""}}</a></li>
                    @endforeach
                  @endif

                </ul>
              </div>
              <div class="ad mad">
                @foreach($advert as $key => $value)
                  @if($value['type'] == 2 && $value['advert_type'] == '7')
                    {!! $value['code'] !!}
                  @break
                @endif
              @endforeach
                <!-- 手机详情广告B -->
              </div>
            </div>
          </div>
          <div class="container-news__right hidden-xs col-lg-3 col-md-3 hidden-sm">
            <div class="question">
              <h4>最新问答</h4>
              <ul>
                @if(isset($xin_qa))
                  @foreach($xin_qa as $key => $value)
                    <li>
                      <a href="{{route('wdinfo',['id' => $value['id']])}}">
                        <img src="{{$value['photo']!= ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg")}}" alt="">
                        <h6>{{$value['title']??""}}</h6>
                      </a>
                    </li>
                  @endforeach
                @endif

              </ul>
            </div>
            <div class="ad-silder">
              @foreach($advert as $key => $value)
                @if($value['type'] == 1 && $value['advert_type'] == '2')
                  {!! $value['code'] !!}
                @break
              @endif
            @endforeach
              <!-- 右侧广告A -->
            </div>
            
            <div class="question">
              <h4>热门问答</h4>
              <ul>
                @if(isset($hot_qa))
                  @foreach($hot_qa as $key => $value)
                    <li>
                      <a href="{{route('wdinfo',['id' => $value['id']])}}">
                        <img src="{{$value['photo']!= ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg")}}" alt="">
                        <h6>{{$value['title']??""}}</h6>
                      </a>
                    </li>
                  @endforeach
                @endif

              </ul>
            </div>
            <div class="ad">
              @foreach($advert as $key => $value)
                @if($value['type'] == 1 && $value['advert_type'] == '3')
                  {!! $value['code'] !!}
                @break
              @endif
            @endforeach
              <!-- 右侧广告B -->
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
          <p>多广网  版权所有 © {{$help[8][0]['title']??""}}</p>
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
    <script src="https://lib.baomitu.com/Swiper/5.4.5/js/swiper.min.js"> </script>
    <script src="{{asset('js/top.js')}}"></script>
    <script type="module">
      import Swiper from 'https://lib.baomitu.com/Swiper/5.4.5/js/swiper.esm.browser.bundle.min.js'
      var mySwiper = new Swiper ('.swiper-container', {
        autoplay: true, // 垂直切换选项
        loop: true, // 循环模式选项
        
        // 如果需要分页器
        pagination: {
          el: '.swiper-pagination',
        }
      })
    </script>
<script>
(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https') {
        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
    }
    else {
        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?5ddbac02a571d52eded26941373e5257";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<script data-ad-client="ca-pub-7975253643710430" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</body>
</html>
