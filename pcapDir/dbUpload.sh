#!/bin/bash
csvDir="/home/bits/p2pClassifier/csv/"
csvList_ensem=`find $csvDir -name '*ensem.csv' | sort`
csvList_sing=`find $csvDir -name '*single.csv' | sort`

ensem_tbl=flow_ensem
sing_tbl=flow_tbl

mySqlUser=idpt
mySqlPass=deity
mySqlDB=idpt


echo "Uploading Ensem Classifier Result...!"


for csvEnsem in $csvList_ensem
do

if [ -s $csvEnsem ]
then
	echo $csvEnsem

mysql -u$mySqlUser -p$mySqlPass $mySqlDB --local-infile << EOF

LOAD DATA LOCAL INFILE '$csvEnsem' 
INTO TABLE $ensem_tbl FIELDS TERMINATED BY ',' 
(src_ip, src_port, dst_ip, dst_port, proto, src_pkt_cnt, dst_pkt_cnt, src_pktlen_entro, dst_pktlen_entro, src_flow_duration, dst_flow_duration, src_total_bytes, dst_total_bytes, src_min_pkt_size, dst_min_pkt_size, src_max_pkt_size, dst_max_pkt_size, src_avg_pkt_size, dst_avg_pkt_size, class) 
SET flow_id=NULL;
EOF
fi
echo "Deleting File..."
rm $csvEnsem
done


echo "Uploading Single Classifier Result...!"


for csvSing in $csvList_sing
do

if [ -s $csvSing ]
then
        echo $csvSing

mysql -u$mySqlUser -p$mySqlPass $mySqlDB --local-infile << EOF

LOAD DATA LOCAL INFILE '$csvSing' 
INTO TABLE $sing_tbl FIELDS TERMINATED BY ',' 
(src_ip, src_port, dst_ip, dst_port, proto, src_pkt_cnt, dst_pkt_cnt, src_pktlen_entro, dst_pktlen_entro, src_flow_duration, dst_flow_duration, src_total_bytes, dst_total_bytes, src_min_pkt_size, dst_min_pkt_size, src_max_pkt_size, dst_max_pkt_size, src_avg_pkt_size, dst_avg_pkt_size, class) 
SET flow_id=NULL;
EOF
fi
echo "Deleting File..."
rm $csvSing

done

