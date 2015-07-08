#!/bin/bash/
inDir="/home/bits/p2pClassifier/captures/"

fileList=`find $inDir -name '*.pcap'`
#echo $fileList


dirCnt=0
outDir="/home/bits/pcapDir/"

for file in $fileList 
do
	if [ ! "$(ls -A $outDir$dirCnt/)" ] 
	then
		chmod 777 $file
		mv $file "$outDir$dirCnt/"
	fi

dirCnt=`expr $dirCnt + 1`
#echo $dirCnt
dirCnt=`expr $dirCnt % 15`
#echo $dirCnt
done


