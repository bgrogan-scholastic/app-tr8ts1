import pexpect;
import os;
import Pyro.core;

class Verity_ServerState(object):
	"""Verity_ServerState: This class will turn on, off or restart the verity search engine
		Several methods are used:
			currentState() - future function - determine if verity is up and running
			shutdown() - shutdown verity search engine
			startup() - startup verity search engine
			restart() - restart the verity search engine
	"""

	def __init__(self):
		pass;

	def currentState(self):
		#do a ps -ef to check and see if the verity server is running
		pass;

	def shutdown(self):
		pass;

	def startup(self):
		pass;

	def restart(self):
		pass;

class Verity_ServerStateImpl(Pyro.core.ObjBase, Verity_ServerState):
	def __init__(self):
		Pyro.core.ObjBase.__init__(self);
		Verity_ServerState.__init__(self);

if __name__ == "__main__":
	toggler = Verity_ServerState();
	print toggler.currentState();
