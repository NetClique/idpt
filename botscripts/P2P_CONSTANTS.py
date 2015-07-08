PCAPDATADIR = './'
FLOWDATADIR = './'
#SUPERFLOWDATADIR = './jan_superflow/'#not being used
#TRAININGDIR = './training/'#not being used
PCAPFILES = 'PcapInputFiles.txt' #Put path to Dir containing pcaps in PcapInputFiles.txt. No trailing slashses ('/')
TSHARKOPTIONSFILE = 'TsharkOptions.txt'
#FLOWOPTIONS = 'FlowOptions.txt'#those commented out are not in use anymore!
#FLOWOUTFILE = PCAPDATADIR + 'FLOWDATA'
#C_FLOWOUTFILE = PCAPDATADIR + 'COMPLETEFLOWDATA'
FLOWGAP = 1 * 60 * 60
THREADLIMIT = 18
TCP_PROTO = '6'
UDP_PROTO = '17'
UDP_HEADERLENGTH = 8
TCP_HEADERLENGTH = 20
#utility functions
import os
def getCSVFiles(dirname):
	csvfiles = []
	for eachfile in os.listdir(dirname):
		if eachfile.endswith('.csv'):
			csvfiles.append(dirname + eachfile)	
	return csvfiles
