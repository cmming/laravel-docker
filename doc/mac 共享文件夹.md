 由于mac 上的文件会存在权限的问题 所以经常要重新为共享文件赋予新的权限
 
 
 chmod -R 777 /Users/chenming/Desktop/php/laravel-docker
 
 chmod -R 777 /home/vagrant/project/project/blog-list/storage/
 
 //修改创建文件的默认选线
 umask 000
 
 
 开启elasticsearch 
 出现内存权限不够
 sudo sysctl -w vm.max_map_count=262144
 
 上述方法修改之后，如果重启虚拟机将失效，所以：
 
 解决办法：
 
 在   /etc/sysctl.conf文件最后添加一行
 
 vm.max_map_count=262144