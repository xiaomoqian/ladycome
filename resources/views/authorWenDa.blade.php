<!DOCTYPE html>
<html class="x-admin-sm">

<head>
  <meta charset="UTF-8">
  <title>多广财经作者管理后台</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport"
    content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
  <link rel="stylesheet" href="{{asset('/css/font.css')}}">
  <link rel="stylesheet" href="{{asset('/css/xadmin.css')}}">
  <script src="{{asset('/lib/layui/layui.all.js')}}" charset="utf-8"></script>
  <script type="text/javascript" src="{{asset('/js/xadmin.js')}}"></script>
</head>

<body>
  <div class="x-nav">
    <span class="layui-breadcrumb">
      <a href="/">首页</a>
      <a>问答管理</a>
      <a>
        <cite>问答列表</cite></a>
    </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
      onclick="location.reload()" title="刷新">
      <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
    </a>
  </div>
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-body ">
            <form class="layui-form layui-col-space5">
              <div class="layui-input-inline layui-show-xs-block">
                <input type="text" name="username" placeholder="请输入问题" autocomplete="off" class="layui-input">
              </div>
              <div class="layui-input-inline layui-show-xs-block">
                <button class="layui-btn" lay-submit="" lay-filter="sreach">
                  <i class="layui-icon">&#xe615;</i></button>
              </div>
            </form>
          </div>
          <div class="layui-card-header">
            <button class="layui-btn" onclick="xadmin.open('添加问题','/author/index/wenda/add',500,400)">
              <i class="layui-icon"></i>添加问题</button></div>
          <div class="layui-card-body ">
            <table class="layui-table layui-form">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>标题</th>
                  <th>创建时间</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://lib.baomitu.com/babel-polyfill/7.8.3/polyfill.min.js"></script>
<script>
  layui.use(['form'],
    function () {
      var form = layui.form;
      form.render();
      form.on('submit(sreach)', function (data) {
        list(data.field.q);
        return false;
      })
      list()

      function list(id) {
        $.get('http://127.0.0.1:7001/admin/news/list', { id: id }, function (res) {
          var li = ''
          res.data.forEach(item => {
            li += `<tr>
                  <td>${item.id}</td>
                  <td>${item.title}</td>
                  <td>${item.created_at}</td>
                  <td class="td-manage">
                    <a title="查看" onclick="xadmin.open('编辑','/author/index/wenda/add?id=${item.id}')" href="javascript:;">
                      <i class="layui-icon">&#xe63c;</i></a>
                    <a title="删除" onclick="timudel(this,${item.id})" href="javascript:;">
                      <i class="layui-icon">&#xe640;</i></a>
                  </td>
                </tr>`
          })
          $('tbody').html(li)
        })
      }
      
    }
  )
  function timudel(obj,id) {
    console.log(id)
    $.get('http://127.0.0.1:7001/admin/news/del',{id:id},function(res) {
      layer.msg('已删除!', {
          icon: 1,
          time: 1000
      });
      $(obj).parents("tr").remove();
    })
  };
</script>

</html>
