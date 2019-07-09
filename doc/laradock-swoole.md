## Laradock 使用 Swoole

> 采用 Swoole的方式启动服务

### 安装扩展

    WORKSPACE_INSTALL_SWOOLE = true
    
    docker-compose build workspace
    
    docker-compose up -d workspace
    
    # 检测是否安装成功插件
    php -m | grep swoole

    
### 修改nginx 的配置


```
map $http_upgrade $connection_upgrade {
    default upgrade;
    ''      close;
}

 upstream laravels {
     # Connect IP:Port
     server workspace:1215 weight=5 max_fails=3 fail_timeout=30s;
     keepalive 16;
 }

server {

    listen 80;
    #listen 80 default_server;
    #listen [::]:80 default_server ipv6only=on;

    # For https
    # listen 443 ssl default_server;
    # listen [::]:443 ssl default_server ipv6only=on;
    # ssl_certificate /etc/nginx/ssl/default.crt;
    # ssl_certificate_key /etc/nginx/ssl/default.key;

    server_name localhost;
    root /var/www/public;
    index index.php index.html index.htm;

    #location / {
    #    try_files $uri $uri/ /index.php$is_args$args;
    #}

    #location ~ \.php$ {
    #    try_files $uri /index.php =404;
    #    fastcgi_pass php-upstream;
    #    fastcgi_index index.php;
    #    fastcgi_buffers 16 16k;
    #    fastcgi_buffer_size 32k;
    #    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    #    #fixes timeouts
    #    fastcgi_read_timeout 600;
    #    include fastcgi_params;
    #}

    location = /index.php {
         # Ensure that there is no such file named "not_exists"
         # in your "public" directory.
         try_files /not_exists @swoole;
     }

    location / {
        try_files $uri $uri/ @swoole;
    }

    location @swoole {
        set $suffix "";

        if ($uri = /index.php) {
            set $suffix ?$query_string;
        }

        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header SERVER_PORT $server_port;
        proxy_set_header REMOTE_ADDR $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection $connection_upgrade;

        # IF https
        # proxy_set_header HTTPS "on";

        #proxy_pass http://127.0.0.1:1215$suffix;
        proxy_pass http://laravels$suffix;
    }

    location ~ /\.ht {
        deny all;
    }

    location /.well-known/acme-challenge/ {
        root /var/www/letsencrypt/;
        log_not_found off;
    }
}


```


    
    
### 开启服务 

    发布配置文件
    php artisan vendor:publish --tag=laravel-swoole
    
    修改项目中的env 文件  为 swoole 修改配置
    #指定 swoole 代理的host
    SWOOLE_HTTP_HOST=workspace
    SWOOLE_HTTP_DAEMONIZE=true
    

    docker-compse exec workspace bash 
    
    php artisan swoole:http start
    
    
    
    