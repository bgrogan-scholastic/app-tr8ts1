#############################################
# Author: Todd A. Reisel
# Date: 8/30/2004
# Class: GI_LdapChangePasswd
# Purpose: change ldap password
#############################################

import os;
import httplib;
import urllib;
import pwd;
import getpass;
import base64;
import time;
import math;

class GI_LdapChangePasswd:
	def __init__(self):
		self._ldapServer = 'gicauthm.grolier.com';
		self._checkLoginUrl = '/passwd/checkLogin.php';
		self._changePasswdUrl = '/passwd/updatePasswd.php';

                userID = os.getuid();
                self._username = pwd.getpwuid(userID)[0];


	def getTimeToNextExport(self):
	    #get the current time and the minute
	    currentMinute = time.localtime()[4];

	    if currentMinute >= 30:
		#the time is greater than the interval, use 60 minutes.
		return 60 - currentMinute;
	    else:
		return 30 - currentMinute;

	def changePassword(self):
		if self._username == 'root':
			os.system("passwd_original");
		else:
			self._password = getpass.getpass('Please enter your current password: ');

			#base64 encode the password
			self._password = base64.encodestring(self._password);

			#validate current user's password
			paramsDictionary = {};
			paramsDictionary['username'] = self._username;
			paramsDictionary['password'] = self._password;

			params = urllib.urlencode(paramsDictionary);

			headers = {"Content-type": "application/x-www-form-urlencoded", "Accept": "text/plain"};

			#don't use a SSL connection as the solaris python modules don't have it compiled in
			urlConnection = httplib.HTTPConnection(self._ldapServer, 80);

			urlConnection.request("POST", self._checkLoginUrl, params, headers);
			response = urlConnection.getresponse();

			#check to see if the login was good.
			if response.read().find('Login valid') == -1:
				print "The password you entered is not correct, please try again...";
			else:
				self._newPassword = getpass.getpass("Please enter your new password: ");
				self._newPassword = base64.encodestring(self._newPassword);

				if self._newPassword == '':
					print "Please enter a valid password";
				else:
					self._newConfirmPassword = getpass.getpass("Please confirm your new password: ");
					self._newConfirmPassword = base64.encodestring(self._newConfirmPassword);

					if self._newPassword != self._newConfirmPassword:
						print "Your new password and your confirmed password do not match... Try again!";
					else:
						paramsDictionary = {};
						paramsDictionary['username'] = self._username;
						paramsDictionary['currentpw'] = self._password;
						paramsDictionary['newpw'] = self._newPassword;
						
						params = urllib.urlencode(paramsDictionary);
						headers = {"Content-type": "application/x-www-form-urlencoded", "Accept": "text/plain"};
						urlConnection = httplib.HTTPConnection(self._ldapServer, 80);
			
						urlConnection.request("POST", self._changePasswdUrl, params, headers);
						response = urlConnection.getresponse();

						responseData = response.read();
						print responseData;

						if responseData.find('uccess') != -1:
						    print "Your password will get updated in to all the servers in approximately " + str( self.getTimeToNextExport()) + " minutes, passwords are syncronized every 30 minutes";

if __name__ == '__main__':
	myPW = GI_LdapChangePasswd();
	myPW.changePassword();

