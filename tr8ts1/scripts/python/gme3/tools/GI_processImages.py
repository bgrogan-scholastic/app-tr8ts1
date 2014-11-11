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

	def __init__(self,  file, readDir, writeDir, bgImg, fext, sfx):
		"""
		
		"""
		print "Processing Images";
		self._lst = [];
		self._readDir = readDir;
		self._writeDir = writeDir;
		self._bgImg = bgImg;
		self._fext = fext;
		self._sfx = sfx;
		self.getData(file);
		
	def getData(self, file):
		"""
		_lst[] contains slpids
		"""	
		
		_input  = open(file, 'r');
		for _line in _input.readlines():
			_slpid = _line.rstrip();
			self._lst.append(_slpid);
			
		_input.close()
		
		
		
	def processImage(self):
		"""
		For each asset, call img generator passing file to read, file to write, bgcolor img,
		text to write author, text to write illustrator  
		
		"""
	
		for _line in self._lst:
			slpid = _line;
			_fileRead = self._readDir + slpid;
			_fileWrite = self._writeDir + slpid;
			print "processing ";
			print _fileRead;
			print " and writing to ";
			print _fileWrite;
			
			""" Create an image object passing
				_fileRead, _fileWrite, self._bgImg;
			"""
			GI_generateImg(_fileRead, _fileWrite, self._bgImg);
				

def main():
	print "\n Starting Program\n"
	print "Reading in Format from format file"

	_file = sys.argv[1];
	_readDir = sys.argv[2];
	_writeDir = sys.argv[3];
	_bgImg = sys.argv[4];
	_fext = sys.argv[5];
	_sfx = sys.argv[6];
	
	_imgGen = GI_processImages( _file, _readDir, _writeDir, _bgImg, _fext, _sfx);
	_imgGen.processImage();

	print "\n Exiting Program\n"

if __name__ == "__main__":
	main()
