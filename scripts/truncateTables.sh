#!/bin/bash

dbUser=idpt
dbPass=deity
dbName=idpt

echo "truncate table flow_tbl"|mysql -u$dbUser -p$dbPass -D $dbName
echo "truncate table flow_ensem"|mysql -u$dbUser -p$dbPass -D $dbName
echo "truncate table convo_tbl"|mysql -u$dbUser -p$dbPass -D $dbName

