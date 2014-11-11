""" User.py
    Singleton Pattern
""" 
import sys
import os
import pwd
import time
import getpass
import MySQLdb
from utils.GI_SSH import SSH

import GI_LOGGER



class User(object):
    """This class interacts and contains information about the user
    """
    def __init__(self):
        """__init__(self) -> None
    
        Class constructor, gets username from system and password from user.
        The results are then available as class members.
        """
        import GI_LOGGER
	GI_LOGGER.logMessage("debug","Getting User Data ...")
	self._username = raw_input("Enter your username: ")
	try:
	    password = getpass.getpass("Enter your Password: ")
	    self._password = password.strip()
	except:
	    msg = "caught an exception trying another method for collecting the password"
            GI_LOGGER.logMessage("debug", msg)

	    password = raw_input("Enter your Password: ")
	    self._password = password.strip()
	    """
	    self._dbUsername = raw_input("Enter the Database username: ")
	    try:
		password = getpass.getpass("Enter the Database password: ")
		self._dbPassword = password.strip()
	    except:
		msg = "caught an exception trying another method for collecting the password"
		GI_LOGGER.logMessage("debug", msg)
    
		password = raw_input("Enter your Database Password: ")
		self._dbPassword = password.strip()
	    """

    #provide access to properties
    def _getUsername(self): return self._username
    def _getPassword(self): return self._password
    def _getDBUsername(self): return self._dbUsername
    def _getDBPassword(self): return self._dbPassword
   
userInstance = User()
   
