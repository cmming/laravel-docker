安装好 开发环境 

1. 进入工作区域安装 laravel
    
    项目初始化完成后，使用配置nginx的root
    

2. mysql 使用
    使用 phpmyadmin 管理mysql
    docker-compose up -d phpmyadmin
    
    ip:8080
    
    user:default
    
    pwd: secret

    ```
    #mysql 配置远程连接
    docker-compose exec mysql bash // 进入bash
    mysql -uroot -proot // 进入mysql命令行
    
    ALTER USER 'default'@'%' IDENTIFIED WITH mysql_native_password BY 'secret'; // Alter命令更改用户来更改用户密码的加密
    ```
    