#!/usr/bin/env bash

set -x

#Updating repositories
apt-get update -y

#Install additional packages
apt-get install curl nano apt-utils net-tools less dialog -y

#Install MySQL
apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 5072E1F5

echo 'deb http://repo.mysql.com/apt/debian jessie mysql-5.7' >> /etc/apt/sources.list
echo 'deb-src http://repo.mysql.com/apt/debian jessie mysql-5.7' >> /etc/apt/sources.list

apt-get update -y

export DEBIAN_FRONTEND="noninteractive"
echo "mysql-community-server mysql-community-server/root_password password" | debconf-set-selections
echo "mysql-community-server mysql-community-server/root_password_again password" | debconf-set-selections

apt-get install mysql-server  -y

echo "[mysqld]" >> /etc/mysql/my.cnf
echo "sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'" >> /etc/mysql/my.cnf
#echo "sql_mode = ''" >> /etc/mysql/my.cnf
echo "bind-address = '0.0.0.0'" >> /etc/mysql/my.cnf
echo "max_allowed_packet = 256M" >> /etc/mysql/my.cnf
echo "group_concat_max_len = 256M" >> /etc/mysql/my.cnf
#echo "default_time_zone = 'Europe/London'" >> /etc/mysql/my.cnf

#Clean
apt-get autoremove
apt-get clean

#mysqld --initialize-insecure

service mysql start

#Set timezone
mysql_tzinfo_to_sql /usr/share/zoneinfo | mysql -uroot mysql -proot

#Create mysql user
mysql -u root -proot -e "CREATE USER IF NOT EXISTS 'root'@'%' IDENTIFIED BY ''"
mysql -u root -proot -e "GRANT ALL PRIVILEGES ON * . * TO 'root'@'%'"

mysql -u root -proot -e "CREATE USER IF NOT EXISTS 'build'@'%' IDENTIFIED BY 'build'"
mysql -u root -proot -e "GRANT ALL PRIVILEGES ON * . * TO 'build'@'%'"

mysql -u build -pbuild -e "FLUSH PRIVILEGES"