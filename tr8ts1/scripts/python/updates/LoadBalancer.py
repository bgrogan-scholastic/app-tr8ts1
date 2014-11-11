""" LoadBalancer.py
"""
import sys
import os
import pwd
import time
import MySQLdb
from utils.GI_SSH import SSH
from amara import binderytools

class LoadBalancer(object):
  
    def __init__(self, lbid, productid, xmlfile):
        """Required parameters to constructor:

        host         hostname of this loadbalancer (ie. lbdby.grolier.com)
        configfile   full path to config file for backend servers.
        """
	import GI_LOGGER
	import User
	self.__lbid = lbid
	self.__servers = []
	self.__handlers = {}
        
        ### Read the xml config file and initialize member variables.
	# get the xml structure in place
	try:
	    self.__xml = binderytools.bind_file(xmlfile)
	except:
	    GI_LOGGER.logMessage("critical", "Failed to open configuration file lb-save.xml")
	    sys.exit()
	
	# iterate through load balancers looking for relevant data
	for balancer in self.__xml.update.loadbalancers.loadbalancer:
	    if balancer.id == self.__lbid:
		self.__lbhost = balancer.host
		print self.__lbhost
		try:
		    GI_LOGGER.logMessage("debug", "User (%s) Logging In..." % (User.userInstance._getUsername()))
		    GI_LOGGER.logMessage("info", "Connecting to (%s) load balancer..." % (self.__lbid))
		    
		    self.__lbConnection = SSH(User.userInstance._getUsername(), User.userInstance._getPassword(), self.__lbhost)
		    GI_LOGGER.logMessage("info", "... Connected.")
		except:
		    GI_LOGGER.logMessage("error", "Unable to Connect:  Invalid username/password provided.  \nPlease restart from beginning")
		    sys.exit()
		# through products & sets
		for product in balancer.product:
		    if product.id == productid:
			for set in product.set:
			    # Instantiate BackEndServer classes
			    for backend in set.backend:
				# instantiate a new backend server and add its data from xml & load into dictionary
				server = BackEndServer()
				server.setProperty("product", product.id)
				server.setProperty("set", set.id)
				server.setProperty("id", backend.id)
				server.setProperty("ssh", backend.ssh.xml_text_content())
				server.setProperty("rsync", backend.rsync.xml_text_content())
				server.setProperty("http", backend.http.xml_text_content())
				server.setProperty("mysql", backend.mysql.xml_text_content())
				server.setProperty("vpnhost", backend.vpnhost.xml_text_content())
				server.setProperty("httphost", backend.httphost.xml_text_content())
				server.setProperty("dbname", backend.dbname.xml_text_content())
				server.setProperty("title", backend.title.xml_text_content())
				# Add it to my servers list
				self.__servers.append(server)

    def start(self, product, set):
        """ server = serverid you wish to start (ie. go0, gme0, go1, gme1, etc)
                     This id must correspond with the id in the config file
        """
        import GI_LOGGER
        GI_LOGGER.logMessage("info", "Starting the %s (%s) servers" % (product, set))
        for server in self.__servers:
	    if (product == server.getValue("product")) and (set == server.getValue("set")):
		rsp = self.__lbConnection.command("sudo ipvsadm -a -t %s:http -r %s -m" % (server.getValue("httphost"),
											   server.getValue("id")))
	    else:
		pass

    def stop(self, product, set):
        """ server = serverid you wish to stop (ie. go0, gme0, go1, gme1, etc)
                     This id must correspond with the id in the config file
        """
        import GI_LOGGER
        GI_LOGGER.logMessage("info", "Stopping the %s (%s) servers" % (product, set))
        for server in self.__servers:
	    if (product == server.getValue("product")) and (set == server.getValue("set")):
		rsp = self.__lbConnection.command("sudo ipvsadm -d -t %s:http -r %s" % (server.getValue("httphost"),
											   server.getValue("id")))
	    else:
		pass
	
    def status(self, product):
        """ Log status of all backend servers for the input product and set (0 through n)"""
	import re
        import GI_LOGGER
	
	status = "\nCURRENT STATUS FOR THE %s SERVERS\n" % (product)
        for server in self.__servers:
	    if product == server.getValue("product"):
		rsp = self.__lbConnection.command("sudo ipvsadm -l -t %s:http" % (server.getValue("httphost")))
		if re.search(server.getValue("id"), rsp) != None:
		    status += "%s is live\n" % (server.getValue("title"))
		else:
		    status += "%s is down\n" % (server.getValue("title"))
	    else:
		pass

        GI_LOGGER.logMessage("info", status)
	
    def addHandler(self, baseHandler):
	self.__handlers[baseHandler.getId(), baseHandler]
                
class BackEndServer(object):
    """This class handles the interaction with the load balancer and one set of backend servers.  
    It will handle the stopping, starting and status retrieval for any load balanced product.  
    """
    def __init__(self):
        """ required parameters:
            serverid ->  this instance's identifier.
        """
	import GI_LOGGER
	self.__properties = {}
	

    def setProperty(self, name, value):
	""" This function provides a means to add new server information.
	"""
	self.__properties[name] = value

    def getValue(self, name):
	return self.__properties[name]

class BaseHandler(object):
    def __init__(self, id):
	#Examples for id:  db, rsync, ssh, etc.
	self.__id = id
	
    def connect(self, server):
	print "This method should handle the connections to the remote servers"
	return
    
    def disconnect(self, server):
	print "This method should handle disconnecting from remove servers"
	return
    
    def action(self, server):
	print "This method does all the work"
	return
    
    def getId(self):
	return self.__id

# test method

if __name__ == "__main__":
    lb = LoadBalancer("dby", "go")
    lb.status("go", "0")
    lbsc = LoadBalancer("sc", "go")
    lbsc.status("go", "1")
    lbgme = LoadBalancer("dby","gme")
    lbgme.status("gme", "0")
    lbgme.status("gme", "1")
    lbsc.stop("go", "0")
    lbsc.start("go", "0")
    
