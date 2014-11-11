import sys;
sys.path.append('/data/go2-passport/scripts/python');
import servicesconfig;

import Pyro;
import Pyro.core
import Pyro.naming
import socket

class Server(object):
	"""Server:  used to pool all of the pyro classes together for the search update tool
		Methods available:
			start() - start the pyro server
	"""

	def __init__(self, publishHost = None):
		Pyro.core.initServer();

		#the publishing host can be used if Pyro is run behind a NAT firewall (i.e.: redhat cluster suite)
		if publishHost != None:
			self.__daemon = Pyro.core.Daemon(publishhost = publishHost);
		else:
			self.__daemon = Pyro.core.Daemon();

		#get a reference to the pyro name server
		self.__locator = Pyro.naming.NameServerLocator();
		self.__nameServer = self.__locator.getNS();
		self.__daemon.useNameServer(self.__nameServer);

	def _getModuleName(self, name):
		"""function to make sure the registered name of the object is unique across the network, uses hostname as part of object name"""
		objectName = socket.gethostname() + "-" + name;
		return objectName;

	def _addService(self, myObj, objectName):
		print "Adding service: " + objectName;

		obj = Pyro.core.ObjBase();
		obj.delegateTo(myObj);
		
		#re-create the new entry in the pyro system
		self.__daemon.connectPersistent(obj, self._getModuleName(objectName));

	def start(self):
		#start up the server's objects
		self._start();

		#load all of the available services for this server
	        services = servicesconfig.GIPyroServicesConfig();
		myServices = services.getServices();

		importStatementToCompile = "";
		addStatementToCompile = "";

		for registerName in myServices.keys():
			serviceAttrs = myServices[registerName];
			moduleImport = serviceAttrs[0];		#the module path, example: system.pyroservices.diskspace
			moduleName = serviceAttrs[1];		#the pyro module that gets instantiated, example: DiskSpaceImpl

			#build a list of python imports
			importStatementToCompile += "from " + moduleImport + " import " + moduleName + "\n";
			
			#build a list of calls to the server module so that the pyro module can be created and installed as a valid service
			addStatementToCompile += "self._addService(" + moduleName + "(), \"" + registerName + "\");\n";

		#compile the dynamic code
		compiledStatement = compile(importStatementToCompile + addStatementToCompile, '<string>', 'exec');

		eval(compiledStatement);

		#handle all of the requests
		self.__daemon.requestLoop();

	def _start(self):
		pass;

if __name__ == "__main__":
	svr = Server();

	#start the pyro server	
	svr.start();
