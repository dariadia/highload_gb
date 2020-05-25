###### 1. Собрать две виртуальные машины с установленным MySQL-сервером.
###### 2. Развернуть репликацию на этих двух серверах.
Собрала. Настроила репликацию по методичке. 
master: 10.0.2.6
slave: 10.0.2.7

server-id = 1
log_bin = mysql-bin.log
binlog_do_db = geekbrains

service mysql-server restart

GRANT REPLICATION SLAVE ON *.* TO 'slave_user'@'%' IDENTIFIED BY 'password';
FLUSH PRIVILEGES;

USE db_onlineshop;
FLUSH TABLES WITH READ LOCK;

UNLOCK TABLES;

server-id = 2
relay-log = mysql-relay-bin.log
log_bin = mysql-bin.log
replicate_do_db = db_geekbrains


CHANGE MASTER TO MASTER_HOST='10.0.2.7', MASTER_USER='slave_user', MASTER_PASSWORD='password',
MASTER_LOG_FILE = 'mysql-bin.000001', MASTER_LOG_POS = 107;
START SLAVE;

SHOW SLAVE STATUS


###### 3*. На двух виртуальных машинах создать два шарда БД. Создать логику общения с ними тестового PHP-скрипта — например, распределение новых пользователей по шардам.
По идее, как-то так, но до конца не сделала.

[{“range”: (0,500), “master”: “MySQL001A”, “slave”: “MySQL001B”},
 {“range”: (501, 1001), “master”: “MySQL002A”, “slave”: “MySQL002B”}]
