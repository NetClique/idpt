#!/bin/bash
mysqluser=idpt
pass=deity
dbname=idpt
mysqltable=convo_tbl

clear
echo "Started at `date` ..."
cd /home/bits/botscripts
mv "/home/bits/p2pClassifier/classifiedCaptures"/* "./pcaps/"
chown bits:bits ./pcaps/*
pcap_dir="./pcaps"

if [ "$(ls -A $pcap_dir)" ]
then 
############# This entire thing below is within 'then' statement  ########################
	nCPU=18 #enter the number of CPU cores to be used for parallel processing of pcaps
	echo "Bot feature extraction begins"
	python FilterPackets.py  ## remember to set no. of MAX threads in P2Pconstants.py file
	#cat *.csv > combined.csv  # combining all pcap.csv into one file
	#rm *pcap.csv		## deleting all pcap.csv files
	ls *.csv > inputfile
	#size=`wc -c /home/bits/botscripts/combined.csv |awk '{print $1}'`
	#echo "Size of combined.csv is $size"

	parallel  -j $nCPU -a inputfile python sort_csv.py
	parallel  -j $nCPU -a inputfile python convo.py
	rm ./pcaps/*	#get rid of all pcap files. 

	echo "feature extraction ends"
	featurefile=`find . -name "*convos"|sort|xargs cat >> features.csv`
	tuplefile=`find . -name "*tuple"|sort|xargs cat >> tuples.csv`
	cat header features.csv > botfeatures.arff
	echo "removing all old files (inputfile *pcap.csv, *convos, *tuple)"
	rm inputfile *pcap.csv *convos *tuple

	java -Xmx9g -jar botclassifier.jar
	echo "classified file is tested.arff"
	# remove its header
	sed '1,14d' tested.arff>temp
	sed -i 's/p2pbox/benign/g' temp 	#renaming p2pbox to benign 
	sed -i 's/botnet/bot/g' temp 	#renaming botnet to bot
	paste -d, tuples.csv temp > classified_tuples.csv ## concatenating tuples.csv with tested_bn.arff. Entries now have labels

	inputfile=`find /home/bits/botscripts/ -type f -name classified_tuples.csv`
	echo "uploading classified_tuples.csv to database"
	echo $inputfile
	mysql -u$mysqluser -p$pass $dbname << EOF
    LOAD DATA INFILE '$inputfile'
    INTO TABLE $mysqltable
    FIELDS TERMINATED BY ','
    (src_ip, dst_ip, duration, total_payload, payload_sent, payload_recvd, total_packets, packets_sent, packets_recvd, compression_ratio, primewave_payload, ft_payload_1, ft_payload_2, ft_payload_3, primewave_iat, ft_iat_1, ft_iat_2, ft_iat_3, class)
    SET convo_id=NULL;
EOF

	rm temp *.csv *.arff
############# This entire thing above is within 'then' statement  ########################
else 
	echo "Pcaps Dir is empty ... terminating"
fi

cd /home/bits/

echo "Finished at `date` !"
echo "*****************************************************************************************************************"
