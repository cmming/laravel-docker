#/bin/sh

# install some tools
sudo yum install -y git vim gcc glibc-static telnet bridge-utils net-tools

# install docker
curl -fsSL get.docker.com -o get-docker.sh
sh get-docker.sh

# start docker service
sudo groupadd docker
sudo usermod -aG docker vagrant
sudo systemctl start docker

systemctl enable docker

rm -rf get-docker.sh

#install docker-compose

sudo yum -y install epel-release

sudo yum -y install python-pip

sudo pip install --upgrade pips

sudo pip install docker-compose