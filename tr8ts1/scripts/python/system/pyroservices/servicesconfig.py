
import socket;

class GIPyroServicesConfig(object):
	def __init__(self):
		#get this server's hostname to get additional services if they are specified
		self.__hostname = socket.gethostname();

		self.__commonServices = {
					'diskspace' : ['system.pyroservices.diskspace', 'DiskSpaceImpl'],
					'backuprestore' : ['system.pyroservices.backuprestore', 'BackupRestoreImpl']
		};

		#keep a list of services by servername, this are special services that only exist on certain machines
		self.__servicesByServer = {
			'srcheng0' : {
					'verity_indexmanager' : ['search.update_tool.pyroservices.verity_indexmanager', 'Verity_IndexManagerImpl'],
					'verity_indexstate' : ['search.update_tool.pyroservices.verity_indexstate', 'Verity_IndexStateImpl'],
					'verity_serverstate' : ['search.update_tool.pyroservices.verity_serverstate', 'Verity_ServerStateImpl'],
					'verity_topqueries' : ['search.update_tool.pyroservices.verity_topqueries', 'Verity_TopQueriesImpl']
			},
			'lbsrchdby' : {
					'loadbalancer_toggleserver' : ['system.pyroservices.loadbalanacer_toggleserver', 'LoadBalancert_ToggleServer']
			}
		}

		#the other search engines use the same services
		self.__servicesByServer['srcheng1'] = self.__servicesByServer['srcheng0'];
		self.__servicesByServer['sc-srcheng0'] = self.__servicesByServer['srcheng0'];
		self.__servicesByServer['sc-srcheng1'] = self.__servicesByServer['srcheng0'];

		#sc load balancer same as dby load balancer
		self.__servicesByServer['lbsrchsc'] = self.__servicesByServer['lbsrchdby'];
	
		#create the merged list of services - common services and services that are tied to particular hostnames	
		self.__myServices = self.__commonServices;

		#check to see if there are any services defined for this hostname in the custom services list
		if self.__servicesByServer.has_key( socket.gethostname() ) == True:
			self.__myServices.update(self.__servicesByServer[ socket.gethostname() ]);	

	def getServices(self):
		return self.__myServices;

if __name__ == '__main__':
	config = GIPyroServicesConfig();
	
