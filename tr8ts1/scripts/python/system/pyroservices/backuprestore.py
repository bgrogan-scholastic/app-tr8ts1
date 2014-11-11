import pexpect;
import os;
import Pyro.core;

class BackupRestore(object):
	"""BackupRestore: This class will backup and restore a directory set and allow for multiple versions.
		Several methods are used:
			version = backup(feature, directoryToBackup)
			restore(feature, version, directoryToRestoreTo)
			listBackups(feature = None)
	"""

	def __init__(self):
		self.__backupDirectory = '/data/backup';
		
		#check to see if the backup directory exists?
		if os.path.exists(self.__backupDirectory) == False:
			#backup directory does not exist, create it.
			os.mkdir(self.__backupDirectory);

	def backup(self, feature, directoryToBackup):
		"""backup(feature): This will be used to backup a particular feature.  It's parameters are a feature name and a directory"""
		pass;

	def restore(self, feature, version, directoryToRestoreTo):
		"""restore(feature, version, restoreToDirectory): This will be used to restore a particular feature to the state defined in the version parameter.  It's parameters are a feature name , version and a directory"""
		pass;

	def listBackups(self, feature = None):
		"""listBackups: get a list of all the backups on this system.  By default no start/stop dates are specified"""
		pass;

	def __getNextVersion(self, feature):
		pass;

class BackupRestoreImpl(Pyro.core.ObjBase, BackupRestore):
	def __init__(self):
		Pyro.core.ObjBase.__init__(self);
		BackupRestore.__init__(self);

if __name__ == "__main__":
	backup = BackupRestore();
	print backup.listBackups();
