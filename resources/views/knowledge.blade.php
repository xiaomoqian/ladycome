<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-transform"/>
    <meta name="applicable-device" content="pc,mobile"/>
    <meta name="format-detection" content="telphone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    @foreach($seo as $key => $value)
      @if($value['page_type'] == 2)
        <meta name="description" content="{{$value['seo_desc']??""}}">
        <meta name="keywords" content="{{$value['seo_keywords']??""}}">
        <title>{{$value['seo_title']??"知识"}} - 蕾蔻网</title>
      @break
    @endif
  @endforeach
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->

    <!-- Bootstrap -->
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/knowledge.css') }}">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
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
                  <li><a class="active" href="{{route('knowledge')}}">知识</a></li>
                  <li><a href="{{route('qa')}}">问答</a></li>
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
            <div class="m-category">
              @foreach($label as $key => $value)
                <a href="{{route('fenlei',['type' => $value['id']])}}">{{$value['name']}}</a>
              @endforeach
            </div>
            <div class="nav">当前位置：<a href="{{route('index')}}">多广网</a>><a href="{{route('knowledge')}}">知识广场</a><span>>{{$lable_name??""}}</span></div>
            <img src="./image/news@2x.png" width="100%" alt="">
            <ul class="container-news__left--box">
              @foreach($science as $key => $value)
                <li>
                  <a href="{{ route('zsinfo',['id' => $value->id]) }}">
                    @if($value->photo)
                      <img src="@if(strstr($value->photo,'http'))
                      {{ $value->photo }}
                      @else
                      {{ asset('storage/' . $value->photo) }}
                      @endif" alt="{{ $value->title }}" />
                    @endif
                  </a>
                  <div>
                    <h4><a href="{{ route('zsinfo',['id' => $value->id]) }}">{{ $value->title }}</a></h4>
                    <p><a href="{{ route('zsinfo',['id' => $value->id]) }}">{{ $value->seo_desc }}</a></p>
                    <div>
                      @foreach($value->label as $v)
                        <b data-href="#"><a href="{{route('fenlei',['type' => $v['id']])}}">{{ $v['name'] }}</a></b>
                      @endforeach
                    </div>
                    <div>
                      <span>{{$value->author_name}}</span>
                      <span>{{$value->created_at}}</span>
                    </div>
                  </div>
                  
                </li>
              @endforeach
            </ul>

            <nav aria-label="Page navigation" style="text-align: center;">
              <ul class="pagination">
                {{$science->links()}}

              </ul>
            </nav>
          </div>
          <div class="container-news__right hidden-xs col-lg-3 col-md-3 hidden-sm">
            <div class="author">
              <h4>分类标签</h4>
              <ul>
                @foreach($label as $key => $value)
                  <li>
                    <a href="{{route('fenlei',['type' => $value['id']])}}">
                      {{$value['name']}}
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
            <div class="ad" style="margin-top: 20px;">
              @foreach($advert as $key => $value)
                @if($value['type'] == 1 && $value['advert_type'] == '2')
                   {!! $value['code'] !!}
                @break
              @endif
            @endforeach
              <!-- 右侧广告A -->
            </div>
            <div class="question">
              <h4>热门知识</h4>
              <ul>
                @foreach($hot_seience as $key => $value)
                  <li>
                    <a href="{{route('zsinfo',['id' => $value['id']])}}">
                      <img src="{{$value['photo']!= ""?strstr($value->photo,'http')?$value->photo:asset("/storage/".$value->photo):asset("/storage/images/Koala.jpg")}}" alt="">
                      <h6>{{$value['title']}}</h6>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
            <div class="ad" style="margin-top: 20px;">
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
          <p>{!! $help[7][0]['content']??"" !!}</p>
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
    <script src="{{asset('js/top.js')}}"></script>
    <script data-ad-client="ca-pub-7975253643710430" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?5ddbac02a571d52eded26941373e5257";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
  </body>
</html>
