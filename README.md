## 基于Swoft构建的Web聊天应用

[![Php Version](https://img.shields.io/badge/php-%3E=7.1-brightgreen.svg?maxAge=2592000)](https://secure.php.net/)
[![Swoole Version](https://img.shields.io/badge/swoole-%3E=4.4.1-brightgreen.svg?maxAge=2592000)](https://github.com/swoole/swoole-src)

![start-http-server](http://pic.ohh.ink/swoft/8.png)


## 简介

本项目是基于Swoft的练手项目，主要使用框架中的Http，WebSocket构建，用于新手熟悉Swoft框架。

## 环境要求

- [PHP 7.1+](https://github.com/php/php-src/releases)
- [Swoole 4.3.4+](https://github.com/swoole/swoole-src/releases)
- [Composer](https://getcomposer.org/)
- [MYSQL 5.7.24+](https://www.mysql.com/cn/downloads/)
- [Redis](https://redis.io/)

## 效果展示
#### 很有意思的登录页
![登录页](http://pic.ohh.ink/swoft/1.png)

#### 登陆首页
##### 用户：程心，好友：三体
![登陆首页](http://pic.ohh.ink/swoft/4.png)
##### 用户：三体，好友：程心
![登陆首页](http://pic.ohh.ink/swoft/5.png)

#### 聊天页面
##### 用户：程心，好友：三体
![登陆首页](http://pic.ohh.ink/swoft/7.png)

## 功能

- 用户登陆退出功能（todo 注册功能）
- 登陆认证中间件
- 同一用户，打开多个窗口，可以实现聊天记录同步接受，即支持多端登陆。
- 好友列表（todo 新增好友功能）
- WebSocket端已支持群聊功能（todo Http端需要做逻辑和界面处理）

## 安装
##### Composer 创建项目
```bash
$ composer 
```
##### 将.env.example复制成.env并配置对应参数
```bash
APP_DEBUG=0
SWOFT_DEBUG=0

REDIS_ONLINE_USER=online-user
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

DATABASE_HOST=192.168.10.10
DATABASE_USERNAME=homestead
DATABASE_PASSWORD=secret
DATABASE_TABLE=swoft
DATABASE_CHARSET=utf8mb4
```
##### 运行数据库迁移命令
```bash
$ php bin/swoft migrate:up
```
##### 添加模拟数据，也可以自己创建，主要是user用户表和friend好友关系表
```sql
# 添加用户
INSERT INTO `user`(`id`, `name`, `username`, `password`, `avatar`, `online`, `created_at`, `updated_at`) VALUES (1, '程心', 'greg001', '2bbff72ba88f1c6a17f43819b09806ac', '/image/avatar2.jpg', 0, NULL, NULL);
INSERT INTO `user`(`id`, `name`, `username`, `password`, `avatar`, `online`, `created_at`, `updated_at`) VALUES (2, '三体', 'oscar001', '2bbff72ba88f1c6a17f43819b09806ac', '/image/avatar1.jpg', 0, NULL, NULL);

# 添加好友关系
INSERT INTO `friend`(`id`, `user_id_a`, `user_id_b`, `created_at`, `updated_at`) VALUES (1, 1, 2, NULL, NULL);
INSERT INTO `friend`(`id`, `user_id_a`, `user_id_b`, `created_at`, `updated_at`) VALUES (2, 2, 1, NULL, NULL);

```
##### 启动WebSocket和Http
```bash
$ php bin/swoft ws:start

# 热更新启动，适合开发使用
$ php swoftcli.phar run -c ws:start
```

## 使用
##### 访问对应地址，这里假设ip为`192.168.10.10`，端口为`18308`，所以访问地址为
```bash
http://192.168.10.10:18308/login
```
##### 注意，要在本机实现两个客户端间的通讯，需要使用两个浏览器，或者开启一个Chrome的匿名模式

## 维护者

[@OhhInk](https://github.com/ouhaohan8023).

## 如何贡献

非常欢迎你的加入! 有任何问题或者想要贡献代码，请提交 issue

## 使用许可

[MIT](LICENSE) © OhhInk
