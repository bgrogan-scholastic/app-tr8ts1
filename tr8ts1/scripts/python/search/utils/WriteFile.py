__author__ = "Todd A. Reisel"
__date__ = "February 7th, 2005"

from common.utils.GI_Hash import *;
import filecmp;
import shutil;

class WriteFile:
	def __init__(self, basedirectory):
		self.giHash = GI_Hash(basedirectory);

	def writeFile(self, basedirectory, filename, contents):
		"""The writeFile method checks to make sure the contents in memory are not the same as on disk.  No sense in updating a file if it has the same information"""
		hashFilename = self.giHash(filename);
		hashDirectoryPath = os.path.split(hashFilename)[0];

		if os.path.exists(hashDirectoryPath) == 0:
			os.system("mkdir -p " + hashDirectoryPath);

		#always write out a temp file
		fd = open(hashFilename + '.tmp', 'w');
		fd.write(contents);
		fd.close();

		if os.path.exists(hashFilename) == False:
			print hashFilename + ": new file - writing to disk";
			shutil.copy(hashFilename + '.tmp', hashFilename);
		else:
			#compare the temp file to the real file
			if filecmp.cmp(hashFilename, hashFilename + '.tmp') == False:
				print hashFilename + ": changed - rewriting to disk";
				shutil.copy(hashFilename + '.tmp', hashFilename);

		os.remove(hashFilename + '.tmp');

		return hashFilename;

