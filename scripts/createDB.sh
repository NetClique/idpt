#!/bin/bash/

dbname=idpt
dbuser=idpt
pass=deity

echo "CREATE DATABASE idpt;"  | mysql -u$dbuser -p$pass

mysql -u$dbuser -p$pass -D $dbname < idpt.sql 


