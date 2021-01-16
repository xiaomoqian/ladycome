<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Cache-Control" content="no-transform"/>
  <meta name="applicable-device" content="pc,mobile"/>
  <meta name="format-detection" content="telphone=no"/>
  <meta name="description" content="{{$classty->seo_desc??""}}">
  <meta name="keywords" content="{{$classty->seo_keywords??""}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
  <title>{{$classty->name??""}}- 多广</title>

  <!-- Bootstrap -->
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/huati-info.css') }}">
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
            <li><a href="{{route('qa')}}">问答</a></li>
            <li><a class="active" href="{{route('ht')}}">话题</a></li>
            <li><a href="/utils">工具</a></li>
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
        <div class="nav">当前位置：<a href="{{route('index')}}">多广网</a>><a href="{{route('ht')}}">话题</a>><a href="#">{{$classty->name??""}}</a></div>
        <div class="title">
          <img src="{{isset($classty->photo) && $classty->photo != ""?strstr($classty->photo,'http')?$classty->photo:asset("/storage/".$classty->photo):asset("/storage/images/Koala.jpg")}}" width="100" height="100" alt="">
          <div class="title-box">
            <h2>{{$classty->name??""}}</h2>
            <p>{{$classty->seo_desc??""}}</p>
          </div>
        </div>
        <ul class="container-news__left--box">
          <div class="container-news__left--box_tab">
            <a class="{{$orderBy == 'created_at'?"active":""}}" href="{{route('htinfo',['id' => $classty->id,'orderBy' => 'created_at'])}}">最新</a>
            <a class="{{$orderBy == 'reading_volume'?"active":""}}" href="{{route('htinfo',['id' => $classty->id,'orderBy' => 'reading_volume'])}}">精华</a>
          </div>
          @foreach($science as $key => $value)
            <li>
              <a href="{{route('zsinfo',['id' => $value['id']])}}">
                <img src="{{$value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg")}}" alt="">
                <div>
                  <h4>{{$value['title']}}</h4>
                  <div class="da">
                    <p>{{$value['seo_desc']}}</p>
                  </div>
                  <div>
                    <span>{{$value['author_name']}}</span>
                    <span>{{$value['created_at']}}</span>
                  </div>
                </div>
              </a>
            </li>
          @endforeach

        </ul>
        <nav aria-label="Page navigation" style="text-align: center;">
          <ul class="pagination">
{{--            {{$science->links()}}--}}
            {{$science->appends(['id'=>$classty->id])->links()}}
            {{--                <li>--}}
            {{--                  <a href="#" aria-label="Previous">--}}
            {{--                    <span aria-hidden="true">&laquo;</span>--}}
            {{--                  </a>--}}
            {{--                </li>--}}
            {{--                <li><a href="#">1</a></li>--}}
            {{--                <li><a href="#">2</a></li>--}}
            {{--                <li><a href="#">3</a></li>--}}
            {{--                <li><a href="#">4</a></li>--}}
            {{--                <li><a href="#">5</a></li>--}}
            {{--                <li>--}}
            {{--                  <a href="#" aria-label="Next">--}}
            {{--                    <span aria-hidden="true">&raquo;</span>--}}
            {{--                  </a>--}}
            {{--                </li>--}}
          </ul>
        </nav>
      </div>
      <div class="container-news__right hidden-xs col-lg-3 col-md-3 hidden-sm">
        <div class="ad">
          @foreach($advert as $key => $value)
            @if($value['type'] == 1 && $value['advert_type'] == '2')
              {!! $value['code'] !!}
              @break
            @endif
          @endforeach
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
<script src="{{asset('js/top.js')}}"></script>
</body>
</html>
