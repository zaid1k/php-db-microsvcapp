#! /usr/bin/bash

sudo yum install docker -y
sudo systemctl start docker
sudo curl -L https://github.com/docker/compose/releases/download/1.27.1/docker-compose-$(uname -s)-$(uname -m) -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
