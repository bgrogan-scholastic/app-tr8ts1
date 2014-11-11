#! /usr/bin/env python
#
# gi_directoryCheck
# 
# Scan the /etc/passwd file, create any home directories that are missing
# and ensure that the umask is set to 002
#
# 8/31/04 Dylan Gladstone
#
# Update History

import sys
import os
import string
import shutil
from os import chown,chmod
from GI_Listfiles import *
from gi_directoryCheck_functions import *
from stat import *

# find out what platform we're running on
platform = sys.platform
if (platform == "sunos5"):
	print "OS:Solaris (",platform,")"
	platform = "solaris"
	skel = "/etc/skel"
else:
	if (platform == "linux2"):
		print "OS:Linux (",platform,")"
		platform = "linux"
		skel = "/etc/skel" # set skeleton directory for new homes

	else:
		print "OS:Unknown (",platform,")"
		sys.exit()


# read in the list of home directories to exclude
productFile = open("productlist.conf", 'r')
productList = productFile.readlines()
productFile.close()
# trim carriage return from product names
products = []
for product in productList:
	products.append(product[:-1])

# read in the passwd file
passwdFile = open("/etc/passwd", 'r')
userAccounts = passwdFile.readlines()
passwdFile.close()

# trim the list off up to and including the separator "+"
count = 0
for user in userAccounts:
	userFields = string.split(user,':')
	if userFields[0] == '+':
		trash = count + 1
	count = count + 1
	
userAccounts = userAccounts[trash:]

for user in userAccounts:
	# split the string into fields
	userFields = string.split(user,':')

	# make sure it's not a product directory
	if ( not products.__contains__(userFields[0]) ):
		# do they have a home directory?
		if ( not os.path.isdir(userFields[5])):
			if (userFields[5] != "/dev/null"):
				# create the directory
				print "create directory for:",userFields[0]
				# copy over the skeleton dir files
				try:
					shutil.copytree(skel, userFields[5])
				except:
					print "copytree failed"
				# fix the umask, or add it
				fixUmask(userFields[5],platform)
				# chown the directory to the right user / group
				try:
					chown(userFields[5],int(userFields[2]),int(userFields[3]))
				except:
					print "chown'ing",userFields[5],"failed"
				homeFiles = listFiles(userFields[5],'*',1,1)	
				for files in homeFiles:
					if ( not os.path.islink(files) ):
						try:
							chown(files,int(userFields[2]),int(userFields[3]))
						except:
							print "chown'ing",files,"failed."

		# if they have a home directory, chown it and check the umask settings
		if (userFields[5] != "/dev/null"):

			try:
				fixUmask(userFields[5],platform)
				chown(userFields[5],int(userFields[2]),int(userFields[3]))

				# set the group sticky bit
				mods = S_IMODE(os.stat(userFields[5])[ST_MODE])
				mods = mods | 1024 # 2000 in octal
				chmod(userFields[5],mods)

				homeFiles = listFiles(userFields[5],'*',1,1)
				for files in homeFiles:
					if ( not os.path.islink(files) ):
						chown(files,int(userFields[2]),int(userFields[3]))
			except:
				print "Chowning & setting umask for",userFields[5],"failed."
	else:
		print "user:",userFields[0],"is a product"
