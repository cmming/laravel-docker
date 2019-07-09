### 添加加速器

    curl -sSL https://get.daocloud.io/daotools/set_mirror.sh | sh -s http://f1361db2.m.daocloud.io


### 为 用户添加权限





### 生成镜像

    docker build .


### docker-compose 扩容
     docker-compose up -d --sacle nginx=2 (docker-compose scale nginx=3)
     
### 启动常见的服务

    docker-compose up -d nginx mysql kibana 
    docker-compose up -d nginx mysql php-fpm redis workspace beanstalkd kibana elasticsearch portainer 