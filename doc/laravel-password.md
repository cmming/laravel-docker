## 安全认证

### 依赖包

    composer require laravel/passport
    
    # 迁移数据库
    php artisan migrate
    # 创建生成安全访问令牌所需的加密密钥
    php artisan passport:install