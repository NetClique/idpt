#!/bin/bash/

cd /home/bits/pcapDir/

parallel -j 15 -a inputDir java -jar classifierDump.jar
killall java
#dbUpload.sh
