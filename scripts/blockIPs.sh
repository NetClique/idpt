#!/bin/bash
SQLserver=172.25.3.61
mySqlUser=idpt
mySqlPass=deity
mySqlDB=idpt
p2pTable=flow_ensem
botTable=convo_tbl
echo "Flushing Iptables...!"
#iptables -F
for i in $(/sbin/iptables -L -n --line-numbers|grep REJECT|awk '{print $1}'|tac); do /sbin/iptables -D FORWARD $i; done

echo "Executing MySql Command...!"

P2PdbResult=$(mysql --skip-column-names -u$mySqlUser -p$mySqlPass -D$mySqlDB -h$SQLserver -e "SELECT src_ip FROM $p2pTable WHERE class = 'P2P' AND src_ip NOT LIKE '172.16.%' AND src_ip NOT LIKE '172.25.%' GROUP BY  src_ip ORDER BY COUNT(src_ip) DESC LIMIT 20;")

BotDbResult=$(mysql --skip-column-names -u$mySqlUser -p$mySqlPass -D$mySqlDB -h$SQLserver -e "SELECT src_ip FROM $botTable WHERE class = 'bot' AND src_ip NOT LIKE '172.16.%' AND src_ip NOT LIKE '172.25.%' GROUP BY  src_ip ORDER BY COUNT(src_ip) DESC LIMIT 20;")

BotDbLocal=$(mysql --skip-column-names -u$mySqlUser -p$mySqlPass -D$mySqlDB -h$SQLserver -e "SELECT src_ip FROM $botTable WHERE class = 'bot' AND src_ip LIKE '172.16.%' AND src_ip!='172.16.90.30' AND src_ip NOT LIKE '172.25.%' GROUP BY  src_ip ORDER BY COUNT(src_ip) DESC LIMIT 20;")

echo "retrieved queries from MySQL"
	
for ip in $P2PdbResult
do
	/sbin/iptables -I FORWARD -t filter -d $ip -m time --timestart 09:00:00 --timestop 17:00:00 --weekdays Mon,Tue,Wed,Thu,Fri -j REJECT
done

###### no 'for' loop here. Block just based on source port ######
/sbin/iptables -I FORWARD -p tcp -m time --timestart 09:00:00 --timestop 17:00:00 --weekdays Mon,Tue,Wed,Thu,Fri -m multiport --sports 411,412,2323,6347,1214,6346,4662,6881,6889,6699 -j REJECT

for ip in $BotDbLocal
do
        /sbin/iptables -I FORWARD -s $ip -m connlimit --connlimit-above 3 -j REJECT
done

for ip in $BotDbResult
do
	/sbin/iptables -I FORWARD -t filter -d $ip -j REJECT
done

echo "added iptables rules at `date`"

iptables -L -n

echo "~~~~~~~~~~~~~~~~~~~~~~~~~~~~"
