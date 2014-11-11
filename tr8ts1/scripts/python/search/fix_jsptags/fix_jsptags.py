__author__ = "Todd A. Reisel"
__date__ = "January 7, 2005"

import os;
import sys;
from common.utils.GI_Listfiles import *;
import string;

class Fix_JspTags:
	def __init__(self):
		try:
			self._jspDirectory = os.environ["jsp_tags_home"];

			self._fileList = listFiles(self._jspDirectory);
		except KeyError, message:
			print "Could not find environment: " + str(message);
			sys.exit(1);

	def fixTags(self):
		for x in self._fileList:
			fd = open(x, 'r');
			contents = fd.read();
			fd.close();

			newcontents = contents;

			if contents.find('<sameline>') != -1:
				print "Updating " + x + ": this file needs its contents to be on one line";
				startPos = contents.find('<sameline>') + len('<sameline>');
				endPos = contents.find('</sameline>');

				if endPos == -1:
					print "Error, no </sameline> tag found in: " + x;
					sys.exit(1);
				
				newcontents = newcontents[startPos:endPos];
				newcontents = newcontents.replace('\n', '');

				if newcontents != None or newcontents != '':
					fd = open(x, 'w');
					fd.write(newcontents);
					fd.close();
				else:
					print x + " contains no contents in between <sameline> and </sameline>";
					sys.exit(1);
							
if __name__ == '__main__':
	fixer = Fix_JspTags();
	fixer.fixTags();
