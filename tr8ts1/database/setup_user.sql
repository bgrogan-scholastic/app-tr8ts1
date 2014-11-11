grant ALL ON *.* TO 'tr8ts1'@'localhost' identified by 'tr8ts1';
grant ALL ON *.* TO 'tr8ts1'@'%' identified by 'tr8ts1';
grant ALL on tr8ts1.* to 'tr8ts1'@'localhost' identified by 'tr8ts1';
grant ALL on tr8ts1.* to 'tr8ts1'@'%' identified by 'tr8ts1';
revoke GRANT OPTION on tr8ts1.* FROM 'tr8ts1';
FLUSH PRIVILEGES;
create database tr8ts1;
