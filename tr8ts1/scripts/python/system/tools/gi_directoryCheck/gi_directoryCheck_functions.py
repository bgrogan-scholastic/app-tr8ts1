# gi_directoryCheck functions
#

import sys
import os
import string
import shutil
from os import chown,rename
from GI_Listfiles import *
from gi_directoryCheck_functions import *
from string import *

# open the shell info file
shellFiles = open("shells.conf",'r')
shells = shellFiles.readlines()
shellFiles.close()

### fixUmask(targetDir, platform) ###
# scan the shell startup files as defined in "shells.conf".  If a file exists
# 	and has a umask statement in it, change the umask to 002.  If the file doesn't exist,
#	create it and add the umask statement.
# targetDir = user's home directory
# platform = solaris or linux
#####################################

def fixUmask(targetDir, platform):
	for record in shells:

		fields = string.split(record,':')
		shell = fields[0]
		startups = string.split(fields[1],',')
		umaskCmd = fields[2]

		# if we're running on solaris, add the "local.*" files to the startup scripts
		if ( platform == "solaris" ):
			startups.append("local.cshrc")
			startups.append("local.login")
			startups.append("local.profile")

		# scan any existing startup files for umask assignments
		for starts in startups:
			prefPath = targetDir + "/" + starts
			if ( os.path.exists(prefPath) ):
				umaskLineFound = 0	# flag: 0 = not found, 1 = found and altered, 2 = found and Ok
				prefFile = open(prefPath, 'r')
				prefLines = prefFile.readlines()
				prefFile.close()

				lineCount = 0
				for i in range(len(prefLines)):
					testLine = lower(prefLines[i])
					index = find(testLine,"umask")
					if index >= 0:
						# if the umask isn't right, then fix it
						if ( testLine != umaskCmd ):
							prefLines[i] = umaskCmd 
							umaskLineFound = 1 # found & altered
						else:
							umaskLineFound = 2 # found and it checked out
                                                                                                                             
				if ( umaskLineFound == 0 ):
					# no line was found, so add it.
					prefLines.append(umaskCmd)

				if ( umaskLineFound != 2 ):
					# prepare to alter the file
					# make a backup copy
					rename( prefPath, targetDir + "/" + "backup-" + starts )
					# then write out the modified file
					try:
						newPrefFile = open(prefPath, 'w')
						for line in prefLines:
							newPrefFile.writelines(line)
						newPrefFile.close()
					except:
						print "Can't create:",prefPath

			# file doesn't exist, so create it
			else:
				try:
					newPrefFile = open(prefPath, 'w')
					newPrefFile.writelines(umaskCmd)
					newPrefFile.close()
				except:
					print "Can't create:",prefPath
