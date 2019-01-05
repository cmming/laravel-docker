#/bin/sh

# install some tools
sudo yum install -y git vim gcc glibc-static telnet bridge-utils net-tools

#install docker ce
sudo yum remove docker docker-common docker-selinux docker-engine

sudo yum install -y yum-utils device-mapper-persistent-data lvm2

sudo yum-config-manager --add-repo https://mirrors.aliyun.com/docker-ce/linux/centos/docker-ce.repo

sudo yum makecache fast

sudo yum install docker-ce

# 开机自启
sudo systemctl enable docker

sudo systemctl start docker


# install docker compose
yum -y install epel-release python-pip

pip install --upgrade pip

pip install docker-compose