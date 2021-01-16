<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-transform"/>
    <meta name="applicable-device" content="pc,mobile"/>
    <meta name="format-detection" content="telphone=no"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>{{$author->author_name??""}} - 多广网</title>

    <!-- Bootstrap -->
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/author.css') }}">
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
                  <li><a href="{{route('ht')}}">话题</a></li>
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
          <div class="container-news__left">
            <!-- PC版作者板块 -->
            <div class="author">
              <div class="left">
                <img src="{{isset($author->photo) && $author->photo != ""?strstr($author->photo,'http')?$author->photo:asset("/storage/".$author->photo):asset("/storage/images/Koala.jpg")}}" alt="" class="avatar">
                <div class="meta">
                  <h2 class="meta-title">{{$author->author_name}}<img src="data:image/png;base64,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" alt=""></h2>
                  <div class="meta-auth">认证：{{$author->certification_mark}}</div>
                  <div class="meta-desc">简介：{{$author->desc}}</div>
                </div>
              </div>
              <div class="right">
                <div><b>{{$count??0}}</b><span>文章</span></div>
                <div><b>{{bcdiv($sum,10000,1)}}万</b><span>阅读量</span></div>
              </div>
            </div>
            <!-- 移动版作者板块 -->
            <div class="m-author">
              <img src="{{isset($author->photo) && $author->photo != ""?strstr($author->photo,'http')?$author->photo:asset("/storage/".$author->photo):asset("/storage/images/Koala.jpg")}}" alt="" class="avatar">
              <div class="meta">
                <h2 class="meta-title">{{$author->author_name}}</h2>
                <div class="meta-right">
                  <div><b>{{$count??0}}</b><span>文章</span></div>
                  <div><b>{{bcdiv($sum,10000,1)}}万</b><span>阅读量</span></div>
                </div>
                <div class="meta-auth">{{$author->certification_mark}} <img src="data:image/png;base64,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" alt=""></div>
              </div>
            </div>
            <div class="container-news__left--tab">
              <a href="{{route('author',['id' => $author->id,'orderBy' => "created_at"])}}" class="{{$orderBy == 'created_at'?"active":""}}">最新</a>
              <a class="{{$orderBy == 'reading_volume'?"active":""}}" href="{{route('author',['id' => $author->id,'orderBy' => "reading_volume"])}}">精华</a>
            </div>
            <ul class="container-news__left--box">
              @foreach($article as $key => $value)
                <li>
                  @if($value['knowledge'] == 1)
                    <?php $url = 'wdinfo'?>
                  @elseif($value['knowledge'] == 2)
                    <?php $url = 'zsinfo'?>
                  @elseif($value['knowledge'] == 3)
                    <?php $url = 'zsinfo'?>
                  @endif
                  <a href="{{route($url,['id' => $value['id']])}}">
                    @if($value['photo'])
                    <img src="{{$value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg")}}" alt="">
                    @endif
                    <div class="right">
                      <h4>{{$value['title']}}</h4>
                      <p>{{$value['seo_desc']}}</p>
                      <div class="meta">
                        <span>{{$author->author_name}}</span>
                        <span>{{$value['created_at']}}</span>
                      </div>
                    </div>
                  </a>
                </li>
              @endforeach
            </ul>
            <nav aria-label="Page navigation" style="text-align: center;">
              <ul class="pagination">
                {{$article->links()}}
              </ul>
            </nav>
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
