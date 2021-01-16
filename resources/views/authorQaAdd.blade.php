<!DOCTYPE html>
<html class="x-admin-sm">

<head>
  <meta charset="UTF-8">
  <title>多广财经作者管理端</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport"
    content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
  <link rel="stylesheet" href="{{asset('/css/font.css')}}">
  <link rel="stylesheet" href="{{asset('/css/xadmin.css')}}">
  <script type="text/javascript" src="{{asset('/lib/layui/layui.js')}}" charset="utf-8"></script>
  <script type="text/javascript" src="{{asset('/js/xadmin.js')}}"></script>
  <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
  <!--[if lt IE 9]>
            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body>
  <div class="layui-fluid">
    <div class="layui-row">
      <form class="layui-form" lay-filter="form">
        <div class="layui-form-item">
          <label for="title" class="layui-form-label">
            <span class="x-red">*</span>问题</label>
          <div class="layui-input-block">
            <input type="text" id="title" name="title" required="" lay-verify="required" autocomplete="off"
              class="layui-input" placeholder="请输入您的问题"></div>
        </div>
        <div class="layui-form-item">
          <label for="title" class="layui-form-label">
            <span class="x-red">*</span>简介</label>
          <div class="layui-input-block">
            <input type="text" id="title" name="title" required="" lay-verify="required" autocomplete="off"
              class="layui-input" placeholder="请输入问题描述"></div>
        </div>
        <div class="layui-form-item">
          <label for="title" class="layui-form-label">
            <span class="x-red">*</span>关键词</label>
          <div class="layui-input-block">
            <input type="text" id="title" name="title" required="" lay-verify="required" autocomplete="off"
              class="layui-input" placeholder="可多个用,分割"></div>
        </div>
        <div class="layui-form-item">
          <label for="content" class="layui-form-label">
            <span class="x-red">*</span>答案</label>
          <div class="layui-input-block">
            <textarea placeholder="请输入答案" class="layui-textarea"></textarea>
          </div>
        </div>
        <div class="layui-form-item">
          <label for="L_repass" class="layui-form-label"></label>
          <button class="layui-btn" lay-filter="add" lay-submit="">确认保存</button>
        </div>
      </form>
    </div>
  </div>
  <script>
    function getUrlParam(name) {
      var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象  
      var r = window.location.search.substr(1).match(reg);  //匹配目标参数   
      if (r != null) return unescape(r[2]); return null; //返回参数值  
    }
    layui.use(['form', 'layer', 'layedit', 'upload'],
      function () {
        $ = layui.jquery;
        var form = layui.form,
          layer = layui.layer,
          layedit = layui.layedit;
        upload = layui.upload;
        layedit.set({
          uploadImage: {
            url: 'http://127.0.0.1:7001/admin/upload/dit' //接口url
          }
        });
        var index = layedit.build('demo');
        //执行实例
        var uploadInst = upload.render({
          elem: '#test1' //绑定元素
          ,url: 'http://127.0.0.1:7001/upload/' //上传接口
          ,done: function (res) {
            //上传完毕回调
            $('input[name="cover"]').val(res.url);
          }
          ,error: function () {
            //请求异常回调
          }
          ,accept: 'file'
          ,size: 51200 //最大允许上传的文件大小
        });
        var id = getUrlParam('id');

        if (id) {
          $.get('http://127.0.0.1:7001/admin/news/find', { id: id }, function (res) {
            form.val('form', {
              title: res.data.title,
              cover: res.data.cover,
              from: res.data.from,
              is_video: res.data.is_video == 1 ? 'on' : '',
              tuijian: res.data.tuijian == 1 ? 'on' : '',
              category_id: res.data.category_id,
            })
            layedit.setContent(index, res.data.content)
          })
        }

        //自定义验证规则
        form.verify();

        //监听提交
        form.on('submit(add)',
          function (data) {
            data.field.content = layedit.getContent(index)
            if (id) {
              data.field.id = id
              $.post('http://127.0.0.1:7001/admin/news/edit', data.field, function (res) {
                //发异步，把数据提交给php
                layer.alert("修改成功", {
                  icon: 6
                }, function () {
                  // 获得frame索引
                  var index = parent.layer.getFrameIndex(window.name);
                  //关闭当前frame
                  parent.layer.close(index);
                });
              })
            } else {
              $.post('http://127.0.0.1:7001/admin/news/add', data.field, function (res) {
                //发异步，把数据提交给php
                layer.alert("增加成功", {
                  icon: 6
                }, function () {
                  // 获得frame索引
                  var index = parent.layer.getFrameIndex(window.name);
                  //关闭当前frame
                  parent.layer.close(index);
                });
              })
            }
            return false;
          });

      });</script>
</body>

</html>
