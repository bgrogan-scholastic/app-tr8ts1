import os;

import viewdiskspace;
import executeupdate;

class UpdateTool(object):
	def __init__(self):
		self._answer = None;

	def displayMenu(self):
		while self._answer != 'q':
			os.spawnlp(os.P_WAIT, 'clear', 'clear', '/dev/null')
			print """
Main Menu:
-------------------------------
1) View Current Diskspace
2) Backup/Restore Search
3) Execute Update
4) Display Search Counts

q) quit
-------------------------------""";
			self._answer = raw_input('Please make a selection: ');

			if self._answer == '1':
				ds = viewdiskspace.ViewDiskSpace();
				ds.displayDiskSpace();
				raw_input("Press <enter> to continue: ");

			if self._answer == '2':
				pass;

			if self._answer == '3':
				eu = executeupdate.ExecuteUpdate();
				eu.start();
				raw_input("Press <enter> to continue: ");

if __name__ == '__main__':
	update = UpdateTool();
	update.displayMenu();
