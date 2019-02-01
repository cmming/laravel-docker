1、   下载elasticsearch-head的源码包

2.

    执行npm install -g grunt-cli 编译源码

    执行npm install 安装服务

    执行grunt server启动服务
    
3.修改 elasticsearch/config/elasticsearch.yml
  http.cors.enabled: true
  http.cors.allow-origin: "*"
