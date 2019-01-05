安装好 开发环境 

扩展工具
yum install perl gcc* make kernel kernel-devel -y

VBoxLinuxAdditions.run

磁盘映射

        vi /etc/rc.local #开启
        
        sudo mount -t vboxsf uBuntuSharePath /pcshare
        mount -t vboxsf laravel-docker /home/vagrant
        
        给文件夹授权
        

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
    docker-compose build --no-cache mysql
    docker-compose exec mysql bash // 进入bash
    mysql -uroot -proot // 进入mysql命令行
    
    ALTER USER 'default'@'%' IDENTIFIED WITH mysql_native_password BY 'secret'; // Alter命令更改用户来更改用户密码的加密
    ```
    
    
3. 进入工作区
    
    ```
     #重新构建容器 修改完配置文件后 重新 打包
     docker-compose build workspace
     docker-compose exec workspace bash
     #更改时区 workspace TZ
    ```
    
4. 系统维护模式
    ```
    php artisan down #关闭 
    php artisan up  #开启
    ```
    
5. 创建model
    ```
    php artisan make:model Models/Test #推荐
    ```
