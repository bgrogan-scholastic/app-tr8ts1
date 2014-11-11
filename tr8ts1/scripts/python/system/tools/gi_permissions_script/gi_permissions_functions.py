# gi_permissions_functions.py
# 8/18/04 Dylan Gladstone
#
# Update History
#	8/26/04		added support for linked files and directories

import os, sys
from stat import *
from GI_Listfiles import *
from os import chown,chmod
import string

# change group leaving owner intact
def gi_chgrp( targetFile, groupID ):

	try:

		# get the real file, (traverse links)
		targetFile = os.path.realpath(targetFile)

		if ( os.path.exists(targetFile) ):
			fileStat = os.stat(targetFile)
			chown(targetFile, fileStat[4], groupID)
	
			# if file is a directory set the group S bit
			if ( os.path.isdir(targetFile) ):
				chmod(targetFile,1533)	# (2775 in Octal)
			else: # otherwise make sure it's read / write for the group
				foundSCCS = string.find(targetFile,'/SCCS')
				if ( foundSCCS < 0):
					# if it's not the /SCCS directory
					oldmods = os.stat(targetFile)[ST_MODE]
					newmods = S_IMODE(oldmods)
					# check for user executable
					execheck = newmods & 0100 # look for exe bit
					if (execheck):
						newmods = newmods | 0070	# add g+rwx
					else:
						newmods = newmods | 0060	# add g+rw
					chmod(targetFile,newmods)
	except:
		print "Failed to modify:",targetFile
			
# change the group of a directory recursively
def gi_chgrpdir( targetDir, groupID ):
	if ( os.path.exists(targetDir) ):
		try:
			gi_chgrp(targetDir,groupID)	# change top level dir
		except:
			print "Failed to modify top level directory:",targetDir
		myDirectory = listFiles(targetDir, '*', 1, 1)
		for myFile in myDirectory:
			gi_chgrp(myFile,groupID)

### SPECIAL CASE DIRECTORIES ###

# /var/log
def gi_var_log():
	try:
		if ( os.path.exists("/var/log") ):
			log_files = listFiles("/var/log", '*', 1, 0) # don't need folders here
			for logFile in log_files:
				fileStat = os.stat(logFile)
				uID = fileStat[ST_UID]
				gID = fileStat[ST_GID]
				if ( uID == 0 and (gID == 0 or gID == 1) ):
					chown( logFile, uID, 520 ) # change to engineering group
					mods = fileStat[ST_MODE]
					mods = mods | 0040 # add g+r
					chmod( logFile, mods )
	except:
		print "Failed to modify /var/log"

# /data/lp2/docs/news
def gi_data_lp2_docs_news():
	targetPath = "/data/lp2/docs/news"
	try:
		if ( os.path.exists(targetPath) ):
			files = listFiles(targetPath, '*', 1, 1)
			for file in files:
				# is it a directory?
				if (os.path.isdir(file)):
					chmod(file,1533) # 2775 in Octal
				else:
					chmod(file,0664)
	except:
		print "Failed to modify /data/lp2/docs/news"
