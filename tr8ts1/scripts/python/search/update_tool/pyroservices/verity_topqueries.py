import pexpect;
import os;
import Pyro.core;

class Verity_TopQueries(object):
	"""Verity_TopQueries: This class will get the top x queries from verity.
		Several methods are used:
			getQueries() - default, top 50 queries in the last 30 days
			getQueries(maxQueries) - top x queries in the last 30 days

			getQueries(startDate, endDate) - top 50 queries from start to end date
			getQueries(startDate, endDate, maxQueries) - top x queries from start to end date
	"""

	def __init__(self):
		pass;

	def getQueries(self):
		pass;

	def getQueries(self, maxQueries):
		pass;

	def getQueries(self, startDate, endDate):
		pass;

	def getQueries(self, startDate, endDate, maxQueries):
		pass;

class Verity_TopQueriesImpl(Pyro.core.ObjBase, Verity_TopQueries):
	def __init__(self):
		Pyro.core.ObjBase.__init__(self);
		Verity_TopQueries.__init__(self);

if __name__ == "__main__":
	queryAgent = Verity_TopQueries();
