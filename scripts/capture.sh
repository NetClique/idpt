#!/bin/bash
echo "Starting at" $(date)
sudo dumpcap -i eth3 -b filesize:50000 -s 150 -f "ip and not (net 74.125.0.0/16 || net 31.13.0.0/16 || host 54.239.32.8 || host 54.239.34.40 || host 178.236.7.18 || host 163.53.76.55 || host 163.53.76.21 || host 163.53.77.55 || host 163.53.77.22 || host 212.82.102.24 || host 77.238.184.24 || host 98.138.253.109 || host 98.137.236.24 || host 74.6.50.24 || host 106.10.212.24 || host 206.190.36.45 ||host 172.16.0.30 || net 216.58.0.0/16 || net 173.192.82.0/25 || net 173.194.52.0/25 || arp)" -w /home/bits/p2pClassifier/captures/trace.pcap
echo "Ended at" $(date)
echo "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~"
