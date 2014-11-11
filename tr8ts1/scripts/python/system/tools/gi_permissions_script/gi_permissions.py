#! /usr/bin/env python
# gi_permissions.py
# This will take care of changing the group ownership of files and directories
# on our development servers
# 8/18/04 Dylan Gladstone
#
# Update History
#	8/25/04		added /export/home/plweb (gid: product)
#			changed script to alter </export>/home/*SCCS & </export>/home/*WS
#	8/27/04		wrapped /data tree to handle /data* (ie: data1, data2, etc.)

import os, sys
from stat import *
from GI_Listfiles import *
from os import chown
from gi_permissions_functions import *

# constants
productList = "productlist.conf"

# find out what platform we're running on
platform = sys.platform
if (platform == "sunos5"):
	print "OS:Solaris (",platform,")"
	platform = "solaris"
else:
	if (platform == "linux2"):
		print "OS:Linux (",platform,")"
		platform = "linux"

	else:
		print "OS:Unknown (",platform,")"
		sys.exit()


### /data Tree ###

# search for /data* (8/27/04 DTG)
datadirlist = listFiles("/", 'data*', 0, 1)
for datadir in datadirlist:

	# 1st Level...

	gi_chgrpdir(datadir,524) # product
	gi_chgrpdir(datadir + "/apache",520) # engineering
	gi_chgrpdir(datadir + "/eng",520) # engineering
	gi_chgrpdir(datadir + "/ldapadmin",520) # engineering
	gi_chgrpdir(datadir + "/go", 524) # product
	gi_chgrpdir(datadir + "/stage", 520) # engineering

	# 2nd level...

	# search for product directories
	productListFile = open(productList, 'r')
	productNames = productListFile.readlines()
	productListFile.close()

	# strip the carriage returns

	for product in productNames:
		product = product[:len(product)-1]	# strip off carriage return
		productPath = datadir + "/" + product
		gi_chgrpdir(productPath + "/database", 502) # dba
		gi_chgrpdir(productPath + "/templates", 525) # template
		gi_chgrpdir(productPath + "/database/logs", 524) # product

	# 3rd level...
	gi_chgrpdir(datadir + "/ldapadmin/config/ldapexports.xml",518) # techsvs

	gi_chgrpdir(datadir + "/stats/logs", 520) # engineering

	# 4th level...
	gi_chgrpdir(datadir + "/go/utils/itm-manager/sites.cfg",518) # techsvs

	# special cases #
	gi_chgrpdir(datadir + "/eas/database", 520) # engineering
	gi_chgrpdir(datadir + "/eas-ada/database", 520) # engineering
	gi_chgrpdir(datadir + "/stage", 524) # product
	gi_chgrpdir(datadir + "/stage/utils", 520) # engineering

### /home or /export/home Tree ###

### Solaris ###
if (platform == "solaris"):
	# /export/home/<product>
	for product in productNames:
		product = product[:len(product)-1]	# strip off carriage return
		productPath = "/export/home/"+product
		gi_chgrpdir(productPath, 524) # product
		gi_chgrpdir(productPath + "/delivery", 522) # delivery

	# /export/home/*WS (8/25/04)
	directoriesWS = listFiles("/export/home", '*WS', 0, 1)
	for WSdir in directoriesWS:
		gi_chgrpdir(WSdir, 520) # engineering

	# /export/home/*SCCS (8/25/04)
	directoriesSCCS = listFiles("/export/home", '*SCCS', 0, 1)
	for SCCSdir in directoriesSCCS:
		gi_chgrpdir(SCCSdir, 520) # engineering

	# misc
	gi_chgrpdir("/export/home/release", 524) # product
	gi_chgrpdir("/export/home/plweb", 524) # product
	gi_chgrpdir("/export/home/sccs-scripts", 520) # engineering
	try:
		chmod("/export/home",0777)
	except:
		print "chmod'ing /export/home/ failed"
                                                                                                                             
	### /opt tree ###
	gi_chgrpdir("/opt/httpd/plweb", 520) # engineering
	gi_chgrpdir("/opt/httpd/plweb/bin", 524) # product
	gi_chgrpdir("/opt/httpd/plweb/databases", 524) # product
	gi_chgrpdir("/opt/netscape3.6", 520) # engineering
	gi_chgrpdir("/opt/iplanet4.1", 520) # engineering

### Linux ###
if (platform == "linux"):
	# /home/<product>
	for product in productNames:
		product = product[:len(product)-1]	# strip off carriage return
		productPath = "/home/"+product
		gi_chgrpdir(productPath, 524) # product
		gi_chgrpdir(productPath + "/delivery", 522) # delivery

	# /home/*WS (8/25/04)
	directoriesWS = listFiles("/home", '*WS', 0, 1)
	for WSdir in directoriesWS:
		gi_chgrpdir(WSdir, 520) # engineering

	# /home/*SCCS (8/25/04)
	directoriesSCCS = listFiles("/home", '*SCCS', 0, 1)
	for SCCSdir in directoriesSCCS:
		gi_chgrpdir(SCCSdir, 520) # engineering

	gi_chgrpdir("/home/release", 524) # product
	try:
		chmod("/home",0777)
	except:
		print "chmod'ing /home failed"

	### misc files ###
	try:
		chown("/etc/odbc.ini", 1009, 520) # treisel:engineering
	except:
		print "can't chown /etc/odbc.ini"
	gi_chgrp("/etc/odbc.ini", 520 ) # chmod
	gi_chgrpdir("/usr/lib/perl5/vendor_perl/5.8.0/i386-linux-thread-multi/Apache/grolier", 520) # engineering

### /etc tree ###
gi_chgrpdir("/etc/httpd/conf", 520) # engineering

### misc directories ###
gi_chgrpdir("/home/sccs-scripts", 520) # engineering
gi_chgrpdir("/etc/rad",524) # product

### allow engineering to read log files owned by root:root in /var/log
gi_var_log()

### misc directories ###
gi_chgrpdir("/etc/init.d", 529) # rcscripts

### handle /u0* directories ###
u0xDir = listFiles("/", 'u0*', 1, 1)
for targetFile in u0xDir:
	gi_chgrpdir( targetFile, 502 )

### /data oracle-backup fixes ###
gi_chgrpdir("/data/authdby816", 502)
gi_chgrpdir("/data/backstage", 502)
gi_chgrpdir("/data/bks816", 502)
gi_chgrpdir("/data/eo816", 502)
gi_chgrpdir("/data/nbk4817", 502)
gi_chgrpdir("/data/stg817", 502)
gi_chgrpdir("/data/stg8i", 502)

### misc files ###
gi_chgrp("/opt/httpd/plweb/etc/plweb.conf", 524) # product
