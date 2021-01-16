<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-transform"/>
    <meta name="applicable-device" content="pc,mobile"/>
    <meta name="format-detection" content="telphone=no"/>
    <meta name="baidu-site-verification" content="foa9gkBaMk" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    @foreach($contont['seo'] as $key => $value)
      @if($value['page_type'] == 1)
    <title>{{$value['seo_title']??""}}</title>
    <meta name="description" content="{{$value['seo_desc']??""}}">
    <meta name="keywords" content="{{$value['seo_keywords']??""}}">
      @break
    @endif
  @endforeach
    <!-- Bootstrap -->
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://lib.baomitu.com/Swiper/5.4.5/css/swiper.min.css">
    <link rel="stylesheet" href="{{asset('css/index.css') }}">
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
                  <img src="{{isset($contont['logo']['logo']) && $contont['logo']['logo'] != ""?asset("/storage/".$contont['logo']['logo']):asset("/storage/images/Koala.jpg")}}" alt="">
                </a>
              </div>  
              <!-- menu section -->  
              <div class="collapse navbar-collapse navbar-ex1-collapse"> 
                <ul class="nav navbar-nav navbar-right">  
                  <li><a class="active" href="{{route('index')}}">首页</a></li>
                  <li><a href="{{route('knowledge')}}">知识</a></li>
                  <li><a href="{{route('qa')}}">问答</a></li>
                  <li><a href="{{route('ht')}}">话题</a></li>
                  <li class="navbar-ruzhu hidden-xs"><a href="{{route('help',['type' => 'join'])}}" style="color: #fff !important;">入驻</a></li>
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
    <div class="swiper-container">
      <div class="swiper-wrapper">
          @foreach($contont['rotation'] as $key => $value)
            <div class="swiper-slide">
              <a href="{{$value['url']??""}}" target="_blank">
                <img src="{{$value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg")}}" alt="First slide">
              </a>
            </div>
          @endforeach
      </div>
      <!-- 如果需要分页器 -->
      <div class="swiper-pagination"></div>
    </div>
    <div class="container">
      <div class="container-hot">
        <div class="container-hot__title">热门文章<img src="./image/hot@2x.png" height="10" alt=""></div>
        <ul class="container-hot__box row">

            <?php $a = 0;?>

              @foreach($contont['hotspot'] as $key => $value)
                <?php $a++;?>
                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                  @if($value['knowledge'] == 1)
                     <?php $url = 'wdinfo'?>
                    @elseif($value['knowledge'] == 2)
                    <?php $url = 'zsinfo'?>
                    @elseif($value['knowledge'] == 3)
                    <?php $url = 'htinfo'?>
                  @endif
                  <li><span>{{$a}}</span><a href="{{route($url,['id' => $value['id']])}}">{{$value['title']}}</a></li>
                </div>
                @if($a > 5)
                  @break;
                @endif
              @endforeach
        </ul>
      </div>
      <div class="container-huati hidden-xs">
        <ul class="row">
          <li class="first col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div>
              <h3>话题</h3>
              <p>#热度话题，汇聚此地</p>
            </div>
            <a href="{{route('ht')}}">查看更多<img src="./image/right.png" alt=""></a>
          </li>
          @foreach($contont['tc'] as $key => $value)
            @if($key > 4)
              @break
            @endif
            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="container-huati__item" style="background-image: url('{{$value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg")}}');">
                <a href="{{route('htinfo',['id' => $value['id']])}}" class="container-huati__item--card">
                  <div class="card-header"><img src="./image/huati_icon@2x.png" width="26" height="24" alt=""></div>
                  <span class="card-title">{{$value['name']}}</span>
                  <div class="card-icon">{{\Illuminate\Support\Str::limit($value['seo_desc'],40)}} <b></b></div>
                </a>
              </div>
            </li>
          @endforeach

        </ul>
      </div>
      <div class="container-news">
        <div class="row clearfix">
          <div class="container-news__left col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <img src="./image/news@2x.png" width="100%" alt="">
            <div class="container-news__left--tab">
              <a data-type="created_at" class="active" href="javascript:;">推荐</a>
              <a data-type="reading_volume" href="javascript:;">热门</a>
            </div>
            <div class="container-news__left--box">
              @foreach($contont['science'] as $key => $value)
                <div class="item">
                  <a href="{{route('zsinfo',['id' => $value['id']])}}">
                    <img src="{{$value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg")}}" alt="">
                    <div>
                      <h4>{{$value['title']}}</h4>
                      <p>{{$value['seo_desc']}}</p>
                      <div>
                        <span>{{$value['author_name']}}</span>
                        <span>{{$value['created_at']}}</span>
                      </div>
                    </div>
                  </a>
                </div>
                @endforeach
                <div class="container-news__left--more">
                  <button onclick="handleChangePage()"><span>加载更多</span></button>
                </div>
            </div>
            
          </div>
          <div class="container-news__right hidden-xs col-lg-3 col-md-3 hidden-sm">
            <div class="author">
              <h4>推荐作者</h4>
              <ul>
                @foreach($contont['author'] as $key => $value)
                  <li>
                    <a href="{{route('author',['id' => $value['id']])}}">
                      <div class="author-title">
                        <img class="avatar" src="{{$value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg")}}" alt="">
                        <div class="info">
                          <div class="info-name">{{$value['author_name']}}</div>
                          <div class="info-vip">
                            <img src="./image/vip@2x.png" width="14" height="14" alt="">
                            <span>{{$value['certification_mark']}}</span>
                          </div>
                        </div>
                      </div>
                      <div class="author-info">
                        {{$value['desc']}}
                      </div>
                    </a>
                  </li>
                @endforeach

              </ul>
            </div>
            <div class="question">
              <h4>最新问答</h4>
              <ul>
                @foreach($contont['questions_and_answers'] as $key => $value)
                  <li>
                    <a href="{{route('wdinfo',['id' => $value['id']])}}">
                      {{$value['title']}}
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer">
      <div class="container">
            <div class="container-tip">
              <div class="container-tip__title">{{$contont['help'][7][0]['title']??""}}</div>
              <p>{!! $contont['help'][7][0]['content']??"" !!}</p>
            </div>

              <div class="container-link">
                <span>友情链接</span>
                 @if(isset($contont['help'][6]) && is_array($contont['help'][6]))
                    @foreach($contont['help'][6] as $key => $value)
                      <a target="_blank" href="{{$value['url']}}">{{$value['title']??""}}</a>
                    @endforeach
                 @endif
              </div>
          <div class="container-banquan">
            <p>蕾蔻网  版权所有 © 2019-2021 <a href="https://beian.miit.gov.cn/" target="_blank" rel="nofollow">鄂ICP备17015376号</a></p>
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
<script data-ad-client="ca-pub-7975253643710430" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
      var page = 1
      var orderBy = "created_at"
      var disabled = false
      function handleChangePage() {
        if (disabled) return false
        page += 1
        $.ajax({
          url: '/science.html/'+(page)+'/'+orderBy,
          method: 'GET',
          success(res) {
            if (res.length < 10) {
              disabled = true
              $('.container-news__left--more').css('display', 'none')
              $('.container-news__left--more').remove()
            } else {
              var li = ''
              for(var i = 0; i < res.length; i++) {
                li += "<div class='item'><a href=\"/zhishi/" + res[i].id + ".html\"><img src=\"" + res[i].photo + "\" alt=\"" + res[i].title + "\"><div><h4>" + res[i].title + "</h4><p>" + res[i].seo_desc + "</p><div><span>" + res[i].author_name + "</span><span>" + res[i].created_at + "</span></div></div></a></div>";
              }
              $('.container-news__left--more').remove()
              $('.container-news__left--box').append(li)
              $('.container-news__left--box').append('<div class="container-news__left--more"><button onclick="handleChangePage()"><span>加载更多</span></button></div>')
            }
          }
        })
      };
      $('.container-news__left--tab a').click(function(e) {
        var type = $(this).data().type
        $(this).siblings().removeClass('active')
        $(this).removeClass('active').addClass('active')
        orderBy = type
        page = 1
        $.ajax({
          url: '/science.html/1/'+type,
          method: 'GET',
          success(res) {
            if (res.length < 10) {
              disabled = true
              $('.container-news__left--more').css('display', 'none')
            } else {
              var li = ''
              for(var i = 0; i < res.length; i++) {
                li += "<div class='item'><a href=\"/zhishi/" + res[i].id + ".html\"><img src=\"" + res[i].photo + "\" alt=\"" + res[i].title + "\"><div><h4>" + res[i].title + "</h4><p>" + res[i].seo_desc + "</p><div><span>" + res[i].author_name + "</span><span>" + res[i].created_at + "</span></div></div></a></div>";
              }
              $('.container-news__left--more').remove()
              $('.container-news__left--box').html(li)
              $('.container-news__left--box').append('<div class="container-news__left--more"><button onclick="handleChangePage()"><span>加载更多</span></button></div>')
            }
          }
        })
      })
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
</body>
</html>
