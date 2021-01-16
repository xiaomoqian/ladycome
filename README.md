# 部署

## env

```bash
$ cp .env.example .env
```

测试webhook

## 安装

```bash
$ composer  install
$ php artisan key:generate
$ php artisan migrate
$ php artisan admin:install
```

## DEMO数据导入

```bash
$ php artisan d:i
```

## DEMO数据导出
```bash
$ php artisan d:e
```

## 后台登录

http://127.0.0.1:8000/admin 
默认账号密码：admin/admin

## 任务调度配置

```bash
$ crontab -e
```

加入`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`。
