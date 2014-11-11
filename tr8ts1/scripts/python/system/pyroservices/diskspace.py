
import pexpect
import socket
import os
import Pyro.core
import Pyro.naming

class DiskSpace(object):
	"""DiskSpace: Using pexpect & df -kP, this script will report the disk space of the system.
		Several methods are used:
			getPartitionList() - used to get a listing of all mount file systems
			getPartition("/data") - used to get space information on a specific mount point
			getSize("/data/gme3/docs") - used to get space information about a destination directory, this method traverses the path from right to left to find the nearest mount point and then reports it's size.  In this example the mount point /data is the closest mount point."""

	def __init__(self):
		self.__spawnedProcess = None;
		self.__results = None;
		self.__partitionInfo = {};
		self.__process();

	def __process(self):
		"""Using pexpect this class issues a df -kP (kilobytes & posix output format), parses the resulting data and stores it in a python dictionary"""
		spawnedProcess = pexpect.spawn("df -kP");
		spawnedProcess.expect(pexpect.EOF);
		self.__results = spawnedProcess.before;

		self.__results = self.__results.split('\r\n');

		for partition in self.__results:
			#remove multiple spaces
			while partition.find("  ") != -1:
				partition = partition.replace("  ", " ");

			pInfo = {};
			partitionInfo = partition.split(" ");

			if len(partitionInfo) > 1:
				pInfo['device'] = partitionInfo[0];
				pInfo['size'] = partitionInfo[1];
				pInfo['inuse'] = partitionInfo[2];
				pInfo['available'] = partitionInfo[3]
				pInfo['capacity'] = partitionInfo[4]
				self.__partitionInfo[partitionInfo[5]] = pInfo;

	def getPartitionList(self):
		return self.__partitionInfo;
	
	def getPartition(self, mountpoint):
		return self.__partitionInfo[mountpoint];

	def getSize(self, directory):
		currentPath = directory;
		foundPath = False;

		#start at the end of the path and work backwards until a match is found
		#at the least we are guaranteed to find / as a valid partition match
		while foundPath == False:
			try:
				testPath = self.__partitionInfo[currentPath];
				foundPath = True;
			except KeyError, message:
				#current path is not a true moint point, move to the left.
				foundPath = False;
				currentPath = os.path.split(currentPath)[0];

		print currentPath + ":";
		return self.__partitionInfo[currentPath];

class DiskSpaceImpl(Pyro.core.ObjBase, DiskSpace):
	def __init__(self):
		Pyro.core.ObjBase.__init__(self);
		DiskSpace.__init__(self);
