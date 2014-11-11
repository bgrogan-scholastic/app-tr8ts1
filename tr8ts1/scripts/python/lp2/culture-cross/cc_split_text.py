
__author__ = "Todd A. Reisel"
__date__ = "August 26, 2004"



""" cc_split_text.py is a script that
    looks in the delivered rdb file for
    all article files and splits them 
   into their chunks (land, people, etc). """


#import the getpath module



import getpath;
import os;
import sys;



class GI_CultureCross:
	""" The GI_CultureCross class is used to split the articles up into their designated chunks: land, people, history, and economy. """
	def __init__(self):
	    #get the contents of the rdb file
	    
	    self._rdbContents = [];
	    self._loadRdbFile();

	    self._articleFields = {};
	    self._articleFields['land']    = ['land', 'land-people', 'land-econ', 'land-hist'];
	    self._articleFields['people']  = ['people', 'land-people', 'people-econ', 'people-hist'];
	    self._articleFields['economy'] = ['econ', 'land-econ', 'people-econ', 'hist-econ'];
	    self._articleFields['history'] = ['hist', 'land-hist', 'people-hist', 'hist-econ'];

	    self._textDirectory = "/data/lp2/docs/text";

	    sys.path.append('/data/lp2/scripts/python/common/utils');
	    from GI_Hash import GI_Hash;

	    self._hash = GI_Hash(self._textDirectory);

	def _loadRdbFile(self):
	    self._rdbFiles = ['/export/home/lp2/delivery/rdb/continents.txt', '/export/home/lp2/delivery/rdb/countrycross.txt', '/export/home/lp2/delivery/rdb/provcross.txt', '/export/home/lp2/delivery/rdb/statecross.txt'];

	    for x in self._rdbFiles:

		fd = open(x, 'r');
		tempContents = fd.read(1000000);
		fd.close();

	        #split the rdb file by carriage returns
		tempSplitContents = tempContents.split('\n');
	    
	        #now split each line by |
		for x in tempSplitContents:
		    thisLine = x.split('|');

		    #make sure we have an id | title
		    if(len(thisLine) >= 2):
			self._rdbContents.append ( thisLine );
		
	    return True;

	def splitArticles(self):
	    print "\tProcessing Articles";

	    #loop through every culture-cross asset
	    for x in self._rdbContents:
		asset_ID = x[0];
		asset_Title = x[1];

		#hash the filename
		filePath = getpath.gethashpath(self._textDirectory, asset_ID + '.html');
	
		try:
		    fd = open(filePath, 'r');
		    articleContents = fd.read(10000000);
		    fd.close();

		    print "\t\tProcessing: " + asset_ID;

		    for chunkName in self._articleFields.keys():
			#loop through each of the possible tag names: land,land-people,land-econ,etc
			#print "\t\t\tLooking for: " + chunkName;

			foundChunk = False;
			
			for possibleGFSectionName in self._articleFields[chunkName]:
			    if foundChunk == False:
				#print "\t\t\t\tSearching for: " + possibleGFSectionName;
				
				startMarker = '<!--gf:' + possibleGFSectionName + '-->';
				startPos = articleContents.find(startMarker);

				if startPos != -1:
				    foundChunk = True;
				    
				    #make sure to not include the starting or ending marker as part of the content.
				    startPos = startPos + len(startMarker);

				    endPos = articleContents.find('<!--/gf:' + possibleGFSectionName + '-->');

				    if endPos != -1:
					#create the article chunk

					chunkFilePath = self._hash(asset_ID + '-' + chunkName + '.html');
					chunkContents = articleContents[startPos:endPos];

			                # get the destination directory inf
					dstPath = os.path.split(chunkFilePath)[0]

			               # does the destination directory exist?
			                if not os.path.exists(dstPath):
						os.makedirs(dstPath)

				     
		
					fd = open(chunkFilePath, 'w');
					fd.write( self.getHtml(chunkContents) );
					fd.close();

				    else:
					print "\t\t\t*** Could not process " + chunkName + " chunk , found gf open tag, no gf close tag";

				    #print "\t\t\t\tProcessed " + chunkName + " article chunk...";
				    #print "";

			if foundChunk == False:
			    print "\t\t\t*** Could not find " + chunkName + " article chunk" + " (ID:" + asset_ID + ") ,     Title:" + asset_Title;

		except IOError, message:
		    print "\t\tCould not find prebuilt article file: " + filePath;

	def getHtml(self, htmlContent):
	    newHtmlContent = """
<html>
<head>
     <title>Culture Cross</title>
</head>
	    
<body bgcolor="white">
""";

            newHtmlContent += self.stripAnchors(htmlContent) + "\n";

	    newHtmlContent += """
</body>
</html>
""";

	    return newHtmlContent;

	
	def stripAnchors(self, inContent):
	    """ <string> stripAnchors(inContent), this function takes a string and removes the html anchors arround it. """
	    myStr = inContent;
	    #convert the string to lowercase
	    tempStr = myStr.lower();

	    anchorStartPos = tempStr.find("<a");

	    while anchorStartPos != -1:
		tagEndPos = tempStr.find(">", anchorStartPos) +1;
		anchorEndPos = tempStr.find("</a>", tagEndPos);

		newStr = myStr[0:anchorStartPos];
		newStr += myStr[tagEndPos:anchorEndPos];
		newStr +=  myStr[anchorEndPos + 4:];
		
		myStr = newStr;
		
		tempStr = newStr.lower();
		anchorStartPos = tempStr.find("<a");
		
	    return myStr;


	def splitFacts(self):
	    print "";
	    print "";
	    print "";

	    print "\tProcessing Facts";

	    self._rdbFile = '/home/lp2/delivery/rdb/gi_lp_manifest.lst';
	    self._factExtension = 'facts';

	    fd = open(self._rdbFile, 'r');
	    contents = fd.read();
	    fd.close();

	    tempContents = contents.split('\n');
	    
	    rdbContents = [];
	    
	    for x in tempContents:
		thisLine = x.split('|');
		
		if len(thisLine) >= 2 and thisLine[5] == '0taf':
		    rdbContents.append( thisLine )

	    #print rdbContents;

	    for facts in rdbContents:
		asset_ID = facts[4];

		newAsset_ID = asset_ID
		#newAsset_ID = asset_ID[0:asset_ID.find('-')];
		#newAsset_ID += '-h';
		

		articleFileName = getpath.gethashpath(self._textDirectory, asset_ID + '.html');
		print "\t\tProcessing: " + asset_ID;

		if os.path.exists(articleFileName) == -1:
		    print "\t\t\tCould not find fact article file: " + articleFileName;
		else:
		    newFactArticleFileName = self._hash(newAsset_ID + '-' + self._factExtension + '.html');


		    try:
			#open up the existing file and get the content
			fd = open(articleFileName, 'r');
			factContents = fd.read();
			fd.close();
			
			#transform the contents
			newFactContents = self.getHtml(factContents);
			
			#write out the new contents
			# get the destination directory inf
			dstPath = os.path.split(newFactArticleFileName)[0]

			# does the destination directory exist?
			if not os.path.exists(dstPath):
				os.makedirs(dstPath)



			fd = open(newFactArticleFileName, 'w');
			fd.write(newFactContents);
			fd.close();
		    
		    except IOError, message:
			print "\t\t\tThe following exception occurred: " + str(message);

if __name__ == '__main__':
    cc = GI_CultureCross();

    #generate chunked article sections
    cc.splitArticles();
    
    #generate chunked sections for facts
    cc.splitFacts();


