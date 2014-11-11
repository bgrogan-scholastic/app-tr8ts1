#! /bin/env python
#
# gi_sudo_setup.py
#
# This script links the gi_* sudo scripts to /usr/bin
# 9/10/04 -Dylan T Gladstone
#
# Update History
#

import os, sys
from stat import *
from GI_Listfiles import *
from os import chown,chmod,symlink
from gi_sudo_setup_functions import *
from string import *
from shutil import copyfile

# constants
sudoers_file_path = "/data/techsvs/scripts/shell/system/sudocmds"
sudo_script_path = "/data/techsvs/scripts/shell/system/sudocmds/gi_scripts"

# find out what platform we're running on
platform = get_platform()
if ( platform == "unknown" ):
	sys.exit()

# grab a list of the gi_* sudo scripts
gi_script_list = listFiles(sudo_script_path, 'gi_*', 0, 1)

# create symbolic links to each file to /usr/bin
for gi_script in gi_script_list:

	try:
		chmod(gi_script,0775)	# set execute bits on all scripts
	except:
		print "can't chmod",gi_script

	gi_script_elements = split(gi_script,"/")
	link_dest = "/usr/bin/" + gi_script_elements[len(gi_script_elements)-1]
	try:
		symlink( gi_script, link_dest )
	except:
		print "cannot link:",gi_script,"to",link_dest

# copy the sudoers file 
if ( platform == "solaris" ):
	sourceFile = sudoers_file_path + "/solaris.sudoers"
	destFile = "/usr/local/etc/sudoers"
if ( platform == "linux" ):
	sourceFile = sudoers_file_path + "/linux.sudoers"
	destFile = "/etc/sudoers"
try:
	copyfile( sourceFile, destFile)
except:
	print "can't copy file",sourceFile,"to",destFile
