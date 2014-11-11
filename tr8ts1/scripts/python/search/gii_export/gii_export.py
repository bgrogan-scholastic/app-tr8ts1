__author__ = "Todd Reisel"
__date__ = "February 7th, 2005"

import sys;
import os.path;
import math;
import htmlentitydefs
import re, string

sys.path.append('../..');

from common.utils.GI_Hash import *;
from common.database.GI_DB import *;
from search.utils.WriteFile import *;

class Gii_Export:

	def __init__(self):

		self._contentPath = '/data/search/content/go2/text/gii';
	
		self._writeFile = WriteFile(self._contentPath);

		if (self._contentPath != ''):
			os.system("mkdir -p " + self._contentPath);

		self._databaseServer = '';
		self._myDB = None;

		while self._databaseServer == '':
			#self._databaseServer = raw_input("Please enter the database server for go2 (q to quit): ");
			self._databaseServer = 'localhost';

			#the user requested to quit
			if self._databaseServer == 'q':
				sys.exit(0);
			else:
				#test the database server connection
				try:
					self._myDB = GI_DB(self._databaseServer, "go2", "go2", "go2");
					queryResults = self._myDB.query("select count(*) from gii");

				except Exception, message:
					print "The following error occurred: " + str(message);
					sys.exit(0);

			# this pattern matches substrings of reserved and non-ASCII characters
			self._pattern = re.compile(r"[&<>\"\x80-\xff]+")

			# create character map
			self._entity_map = {}

			for i in range(256):
			    self._entity_map[chr(i)] = "&#%d;" % i

			for entity, char in htmlentitydefs.entitydefs.items():
    				if self._entity_map.has_key(char):
				        self._entity_map[char] = "&%s;" % entity


	def createCaptions(self):
		captionCount = 0;

		#create the captions
		chunk = 5000;
		countquery = "select count(*)/%s mycount from gii" % chunk;

		queryNumResults = self._myDB.query(countquery);
		numResults = math.ceil(queryNumResults[0]['mycount']);

		for x in range(1, numResults + 1):
			start = (x * chunk) - chunk;
			end = x * chunk - 1;

			print "Processing gii: %s to %s" % (start, end);
			resultQuery = "select url, url_title, url_desc, filename, go_version from gii limit %s, %s" % (start, chunk);
			queryResults = self._myDB.query(resultQuery);
			for y in queryResults:
				url = y["url"];
				title = y["url_title"];
				url_desc = y["url_desc"];
				filename = y["filename"];
				go_version = '';
				product_navigation = 'GO//GII//Passport';

				if y["go_version"] == 'p':
					go_version = 'passport';
				elif y["go_version"] == 'k':
					go_version = 'kids';
					product_navigation = 'GO//GII//Kids';


				self._writeFile = WriteFile( os.path.join(self._contentPath, go_version) );

				content = self._populateContent(title, url, go_version, product_navigation, url_desc, filename);

				self._writeCaption(go_version, filename, content);
				captionCount = captionCount + 1;

		print "Exported: " + str(captionCount) + " captions";

	def _populateContent(self, title, url, go_version, product_navigation, url_desc, filename): 
		if url_desc != None:
			#make sure the url description does not contain any quotes
			url_desc = url_desc.replace("\"", "&quot;");
		else:
			print url + ": does not have a description filled in";
			url_desc = '';

		content = """<html>
<head>
	<meta name="title" content="%s"></meta>
	<meta name="url" content="%s"></meta>
	<meta name="go_version" content="%s"></meta>
	<meta name="product_navigation" content="%s"></meta>
	<meta name="url_desc" content="%s"></meta>
</head>

<body>
%s
</body>
</html>
""" % (self.escape(title), url, go_version, product_navigation, url_desc, url_desc);
		return content;

	def _writeCaption(self, go_version, filename, content):
		self._writeFile.writeFile( os.path.join(self._contentPath, go_version), filename, content);


	def _checkDbForFile(self, args, dir, names):
		for x in names:
			filePath = os.path.join(dir, x);
			if os.path.isdir(filePath) == True:
				os.path.walk(os.path.join(dir, x), self._checkDbForFile, args);
			else:
				filename = x;
				#check to make sure it still exists in the database
				fileQuery = "select count(*) mycount from gii where filename='%s' and go_version='%s'" % (filename, args);
				result = self._myDB.query(fileQuery);
				if result[0]['mycount'] < 1:
					print os.path.join(dir, filename) + ": is no longer in the database, removing file.";
					os.remove( os.path.join(dir, filename) );


	def cleanUpOldGII(self, dbtable, go_version):
		print "Validating gii files on disk against database for: " + go_version;

		myPath = '';

		if go_version == 'p':
			myPath = os.path.join(self._contentPath, 'passport');
		elif go_version == 'k':
			myPath = os.path.join(self._contentPath, 'kids');

		os.path.walk(myPath, self._checkDbForFile, go_version);

	#used for converting the html entities in the title
	def escape_entity(self, m):
		get = self._entity_map.get;
		return string.join(map(get, m.group()), "")

	def escape(self, string):
	    return self._pattern.sub(self.escape_entity, string)

if __name__ == '__main__':
	exporter = Gii_Export();
	exporter.createCaptions();
	exporter.cleanUpOldGII('gii', 'p');
	exporter.cleanUpOldGII('gii', 'k');


