__author__ = "Todd Reisel"
__date__ = "December 30th, 2004"

import sys;
import os.path;

sys.path.append('../..');

from common.utils.GI_Hash import *;
from common.database.GI_DB import *;
from search.utils.WriteFile import *;

class Atlas_Export:
	"""The Atlas_Export class looks at the assets, spots and atlas_hier table in the database and
		generates caption files for each map and spot."""

	def __init__(self):
		"""As part of the initialization of this object, the user will be requested to enter the hostname
			or ip address of the go2-passport server so that the captions can be created from the database
			data."""

		self._contentPath = '/data/search/content/go2/text/atlas';
	
		if (self._contentPath != ''):
			os.system(" rm -rf " + self._contentPath );
			os.system("mkdir -p " + self._contentPath);

		self._databaseServer = '';
		self._myDB = None;

		while self._databaseServer == '':
			#self._databaseServer = raw_input("Please enter the database server for go2-passport (q to quit): ");
			self._databaseServer = 'localhost';

			#the user requested to quit
			if self._databaseServer == 'q':
				sys.exit(0);
			else:
				#test the database server connection
				try:
					self._myDB = GI_DB(self._databaseServer, "go2", "go2", "go2");
					queryResults = self._myDB.query("select count(*) from assets");

				except Exception, message:
					print "The following error occurred: " + str(message);
					sys.exit(0);

	def createAssets(self):
		"""The createAssets function takes no arguments and will create caption files for the top-level
			map assets."""

		queryResults = self._myDB.query("select assets.asset_id, title, type, language, hier_text, keyword from assets left join atlas_hier on assets.asset_id = atlas_hier.h_asset_id left join map_keywords on assets.asset_id=map_keywords.id where assets.type like '0mm%' and language='english'");

		for x in queryResults:
			asset_id = x["asset_id"];
			title = x["title"];
			type = x["type"];
			hier_text = x["hier_text"];
			keyword = x["keyword"];

			#make sure the hierarchy text is not the word None.
			if hier_text == None:
				hier_text = "";

			if keyword == None:
				keyword = "";

			content = """<html lang="en">
<head>
	<meta name="title" content="%s"></meta>
	<meta name="map_title" content="%s"></meta>
	<meta name="assetid" content="%s"></meta>
	<meta name="type" content="%s"></meta>
	<meta name="SBTAXONOMY" content="%s"></meta>
	<meta name="mstype" content="map"></meta>
	<meta name="mkeywords" content="%s"></meta>
	<meta name="skeywords" content=""></meta>
	%s
</head>

<body>
</body>
</html>
""" % (title, title, asset_id, type, hier_text, keyword, title);
			#make sure to write the maps to a maps directory
			self._writeCaption("maps", asset_id, content);

	def createSpots(self):
		"""The createSpots function takes no arguments and will create caption files for all the spots in the database
			where the type is h, c or s.  No browse navigation by spot."""

		queryResults = self._myDB.query("select spots.spot_id, assets.asset_id, assets.type, assets.title, assets.language, spots.title spot_title, spots.spot_type, atlas_hier.hier_text, MKW1.keyword as mkeywords, assets.asset_id, MKW2.keyword as skeywords from assets  left outer join map_keywords as MKW1 on assets.asset_id = MKW1.id left join spots on assets.asset_id = spots.asset_id left outer join map_keywords as MKW2 on spots.spot_id = MKW2.id left outer join atlas_hier on assets.asset_id = atlas_hier.h_asset_id where spots.spot_type in ('h', 'c', 's') and assets.language='english'");

		for x in queryResults:
			spot_id = x["spot_id"];
			asset_id = x["asset_id"];
			title = x["title"];
			type = x["type"];
			spot_type = x["spot_type"];
			spot_title = x["spot_title"];
			hier_text = x["hier_text"];
			mkeywords = x["mkeywords"];
			skeywords = x["skeywords"];


			if hier_text == None:
				hier_text = "";

			if mkeywords == None:
				mkeywords = "";
	
			if skeywords == None:
				skeywords = "";

			content = """<html lang="en">
<head>
	<meta name="title" content="%s (%s)"></meta>
	<meta name="map_title" content="%s"></meta>
	<meta name="spot_title" content="%s"></meta>
	<meta name="spotid" content="%s"></meta>
	<meta name="assetid" content="%s"></meta>
	<meta name="type" content="%s"></meta>
	<meta name="spottype" content="%s"></meta>
	<meta name="mstype" content="spot"></meta>
	<meta name="SBTAXONOMY" content="%s"></meta>
	<meta name="mkeywords" content="%s"></meta>
	<meta name="skeywords" content="%s"></meta>
	%s (%s)
</head>

<body>
</body>
</html>
""" % (title, spot_title, title, spot_title, spot_id, asset_id, type, spot_type, hier_text, mkeywords, skeywords, title, spot_title);
			#make sure to write the spots to the spots directory
			self._writeCaption("spots", spot_id, content);


	def _writeCaption(self, MSType, asset_id, content):
		filename = asset_id + ".html";

		f = WriteFile( os.path.join(self._contentPath, MSType) );
		hashFilename = f.writeFile( os.path.join(self._contentPath, MSType), filename, content);

if __name__ == '__main__':
    exporter = Atlas_Export();
    exporter.createAssets();
    exporter.createSpots();

