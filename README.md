# swoole-thinkphp5
swoole1.9.8+thinkphp5.0

如何使用：
1.安装swoole的过程请自行百度

2.修改server目录下server.php中的$cmd为你本地的php安装目录

3.下载源文件后直接命令行执行：
php 项目目录/server/server.php

4.目前只完成了websocket的服务。

5.传输数据格式为json格式,目前接收的参数：
action可看做请求uri 
param 传输数据建议序列化后传输
{"action":"index/index","param":"aaaa"}