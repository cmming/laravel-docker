$ vagrant init      # 初始化

$ vagrant up        # 启动虚拟机
$ vagrant halt      # 关闭虚拟机
$ vagrant reload    # 重启虚拟机
$ vagrant ssh       # SSH 至虚拟机
$ vagrant suspend   # 挂起虚拟机
$ vagrant resume    # 唤醒虚拟机
$ vagrant status    # 查看虚拟机运行状态
$ vagrant destroy   # 销毁当前虚拟机


#box管理命令
$ vagrant box list    # 查看本地box列表
$ vagrant box add     # 添加box到列表

$ vagrant box remove  # 从box列表移除 


#vagrant 的同步文件配置无法生效解决办法
vagrant plugin install vagrant-vbguest


# 为用户 vagrant 添加docker 权限
sudo gpasswd -a vagrant docker

# 退出
logout



1. 创建一个快照
    vagrant snapshot take "Name"
2. 查看快照列表
    vagrant snapshot list
3. 从指定快照中恢复
    vagrant snapshot go "Name"
4. 删除一个快照
    vagrant snapshot delete "Name"

















