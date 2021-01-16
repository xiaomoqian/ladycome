<!doctype html>
<html class="x-admin-sm">

<head>
  <meta charset="UTF-8">
  <title>多广财经作者登录</title>
  <meta name="renderer" content="webkit|ie-comp|ie-stand">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport"
    content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="stylesheet" href="{{asset('css/font.css')}}">
  <link rel="stylesheet" href="{{asset('css/login.css')}}">
  <link rel="stylesheet" href="{{asset('css/xadmin.css')}}">
  <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
  <script src="{{asset('lib/layui/layui.js')}}" charset="utf-8"></script>
  <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-bg">

  <div class="login layui-anim layui-anim-up">
    <div class="message">多广财经作者登录</div>
    <div id="darkbannerwrap"></div>

    <form method="post" class="layui-form" action="author_login">
      @csrf
      <input name="username" placeholder="用户名" type="text" lay-verify="required" class="layui-input">
      <hr class="hr15">
      <input name="password" lay-verify="required" placeholder="密码" type="password" class="layui-input">
      <hr class="hr15">
      <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
      <hr class="hr20">
    </form>
  </div>
  <script crossorigin="anonymous" integrity="sha384-JxeMHkcLhRA6LizVveoPjhTJUoWp9vFbKRS0IGO1K9zTlQL6AsWojnoy16iqmep5" src="https://lib.baomitu.com/Cookies.js/1.2.1/cookies.min.js"></script>
  <script>

  </script>
  <!-- 底部结束 -->
</body>

</html>
