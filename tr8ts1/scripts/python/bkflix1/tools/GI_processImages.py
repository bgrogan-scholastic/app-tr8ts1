#! /usr/bin/python2.3


"""  
	programmer:	Claire Dunn
	date:		3/1/9
	class:		GI_processImages	
	description: 	Gets the information needed to generate new images:
					background image, image to overlay, text to write
					new name to generate, where to write it to
		
	parameters:	

"""

#Imports

import sys, os
from GI_generateImg import GI_generateImg

class GI_processImages:

	def __init__(self,  file, format, readDir, writeDir, bgImg, fext, sfx):
		"""
		
		"""
		self._Dict = {};
		self._fDict = {};
		self._lst = [];
		self._authStr="";
		self._illusStr="";
		self._readDir = readDir;
		self._writeDir = writeDir;
		self._bgImg = bgImg;
		self._fext = fext;
		self._sfx = sfx;
		self._Dict = self.getData(file);
		self._fDict = self.getFormat(format);
		

	def getData(self, file):
		"""
		This function loads a dictionary of dictionaries with author/illustrator info
		and slpid as key

		file format:
		type | slpid | author string | illustrator string | match string

		dictionary:
		_dict = {"slp_id":slp_id, "auth": auth, "illus": illus, "match": auth-illus}
		_Dict[slpid] = _dict;
		_lst[] contains slpids
		"""	
		
		_input  = open(file, 'r');
		for _line in _input.readlines():
			_line = _line.rstrip();
			_segs =  _line.split('|');
			_slpid = _segs[0].rstrip();
			self._lst.append(_slpid);
			_dict = {"slp_id":_segs[0].rstrip(), 	
				"auth":_segs[1].rstrip(),
				"illus":_segs[2].rstrip(),
				"match":_segs[3].rstrip()};
			self._Dict[_slpid] = _dict;
			
		_input.close()
		
		return self._Dict;

	def getFormat(self, format):
		"""
		This function loads the formats to be processed in a list

		file format:
		auth | format string
		illus | format string
		match | format string
		"""
		
		_fLst = [];
		_idx = 0;		
		_input = open(format,'r');
		for _line in _input.readlines():
			if (len(_line)> 2):
				_fLst.append(_line.split('|'))
				self._fDict[_fLst[_idx][0]] = _fLst[_idx][1];
				_idx = _idx + 1;
			
		return self._fDict;	

	
	def fillFormat(self, slp_id):
		"""
		This function figures out for each slpid what the illustrator/author strings will be
			1.  If the match field is full, use match format for author, illustrator format is blank
			2.  Otherwise - fill auth format with auth field, illustrator format with illustrator field
		"""
		
		_mydict =  self._Dict[slp_id];
		self._authStr = "";
		self._illusStr = "";		
		if (len(_mydict['match']) > 0):
			self._authStr = self._fDict['both'].replace("##AUTHOR##", _mydict['auth']).rstrip();
		elif (len(_mydict['auth']) > 0):
			self._authStr = self._fDict['auth'].replace("##AUTHOR##", _mydict['auth']).rstrip();
			self._illusStr  = self._fDict['illus'].replace("##ILLUSTRATOR##", _mydict['illus']).rstrip();			
			
		
		
	def processImage(self):
		"""
		For each asset, call img generator passing file to read, file to write, bgcolor img,
		text to write author, text to write illustrator  
		
		"""
	
		for _line in self._lst:
			slpid = _line;
			self.fillFormat(slpid);
			_fileRead = self._readDir + slpid + "." + self._fext;
			_fileWrite = self._writeDir + slpid + self._sfx + "." + self._fext;
			
			""" Create an image object passing
				_fileRead, _fileWrite, self._bgImg; self._authStr, self._illusStr
			"""
			GI_generateImg(_fileRead, _fileWrite, self._bgImg, self._authStr, self._illusStr);
				

def main():
	print "\n Starting Program\n"
	print "Reading in Format from format file"

	_data = sys.argv[1];
	_format = sys.argv[2];
	_readDir = sys.argv[3];
	_writeDir = sys.argv[4];
	_bgImg = sys.argv[5];
	_fext = sys.argv[6];
	_sfx = sys.argv[7];
	
	_imgGen = GI_processImages(_data, _format, _readDir, _writeDir, _bgImg, _fext, _sfx);
	_imgGen.processImage();

	print "\n Exiting Program\n"

if __name__ == "__main__":
	main()
