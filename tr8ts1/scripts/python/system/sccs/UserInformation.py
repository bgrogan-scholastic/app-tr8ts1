##########################################
# Author: Todd Reisel
# Class: UserInformation
# Date: April, 23rd, 2004
# Description: Get a unix user's information
##########################################

import os;
import pwd;
import getpass;

class UserInformation:
	def __init__(self):
		#initialize the username;
		self._username = '';

		#blank out the password;
		self._password = None;

	def getUsername(self):
		userID = os.getuid();
		self._username = pwd.getpwuid(userID)[0];
		
		return self._username;

	def getPassword(self, hostname):
		#check to see if the password already exists
		if self._password == None:
			self._password =  getpass.getpass("Please enter the password for <" + self._username + "> on " + hostname + ": ");
			return self._password;
		else:
			return self._password;

