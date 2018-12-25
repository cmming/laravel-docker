创建一个邮件发送的业务类

    创建表
    php artisan make:migration create_email_code_table
    填充表
    php artisan migrate
    生成模型
    php artisan make:model Models/Mail

    创建 控制器
    php artisan make:controller Tool/MailController

    创建一个job

    修改quene.php
        设置队列驱动为数据库模式 默认(sync)

        创建迁移文件
        php artisan queue:table

        执行迁移文件
        php artisan migrate

        创建一个队列
        php artisan make:job jobName

        打开队列的监视命令
        php artisan queue:listen

        创建队列异常的情况
        php artisan queue:failed-table
        php artisan migrate

        重新执行失败的(处理更多异常还有很多中处理方式)
        php artisan queue:retry