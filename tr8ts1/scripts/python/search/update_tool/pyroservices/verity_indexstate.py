import pexpect;
import os;
import Pyro.core;

class Verity_IndexState(object):
	"""Verity_IndexState: This class will turn on / off a collection used by verity
		Several methods are used:
			listStates() - get a list of all indexes states broken apart by repository (go2media, gii, gme, etc)
			setOff(repository) - respository is go2media, gme3, gii, etc.
			setOn(repository)
			setAllOn(repository) - future function
			setAllOff(repository) - future function
	"""

	def __init__(self):
		pass;

	def listStates(self):
		pass;

	def setOff(self, repository):
		pass;

	def setOn(self, repository):
		pass;

	def setAllOn(self):
		pass;

	def setAllOff(self):
		pass;

class Verity_IndexStateImpl(Pyro.core.ObjBase, Verity_IndexState):
	def __init__(self):
		Pyro.core.ObjBase.__init__(self);
		Verity_IndexState.__init__(self);

if __name__ == "__main__":
	toggler = Verity_IndexState();
	print toggler.listStates();
