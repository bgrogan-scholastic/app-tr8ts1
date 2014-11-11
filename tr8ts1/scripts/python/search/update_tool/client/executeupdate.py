import Pyro;
import Pyro.naming;

class ExecuteUpdate(object):
        def __init__(self):

		Pyro.core.initClient();
		locator = Pyro.naming.NameServerLocator();
		ns = locator.getNS();
		print ns.list("");

        def start(self):
		print "Starting the update process";

		#start the update process
	
		#prompt for server
		#	srcheng0	dby or sc
		#	srcheng1	dby or sc
		#backup requested server
		#	validate necessary free diskspace, locally and remotely
		#	on backup complete:
		#		upload content to a temporary directory
		#			on failure, abort update
		#		rebuild collection in temporary location
		#			on failure, abort update
		#		toggle collection/index offline
		#			on failure, abort update
		#		move temporary collection/index to real location
		#		toggle verity server
		#		toggle collection/index online
		#		validate search counts
		#
		#	on backup failure:
		#		abort update
	
                pass;

