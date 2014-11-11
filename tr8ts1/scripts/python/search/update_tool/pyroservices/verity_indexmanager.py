import pexpect;
import os;
import Pyro.core;

class Verity_IndexManager(object):
	"""Verity_IndexManager: This class will re-create / reindex a collection/pi
		Several methods are used:
			reindex(repository) - go2media, gii

			reCreateCollection(repository)
			reCreateParametricIndex(repository)

	"""

	def __init__(self):
		self.__reindexScripts = '/home/search/utils/%s/reindex';

	def reindex(self, repository):
		reindexCommand = self.__reindexScripts % repository;
		return reindexCommand;

	def reCreateCollection(self, repository):
		pass

	def reCreateParametricIndex(self, repository):
		pass

class Verity_IndexManagerImpl(Pyro.core.ObjBase, Verity_IndexManager):
	def __init__(self):
		Pyro.core.ObjBase.__init__(self);
		Verity_IndexManager.__init__(self);

if __name__ == "__main__":
	toggler = Verity_IndexManager();
