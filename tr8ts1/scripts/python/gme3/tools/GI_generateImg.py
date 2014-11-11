#! /usr/bin/python2.3


"""  
	programmer:	Claire Dunn
	date:		3/1/7
	class:		GI_generateImg
	description:	Using existing pictures create a new png with text added
	parameters:	

"""


#Imports

import sys, os

#PIL imports
import Image
import ImageFont
import ImageDraw


class GI_generateImg:

	def __init__(self, fileRead, fileWrite, bgImg):
		"""
		The constructor will gather all the data needed to create the picture
		Also, the information on how to generate filename and where to write file to
	
		"""
		
		self._fRead = fileRead;
		self._fWrite = fileWrite;
		self._bgImg = bgImg;
		
		print "***************************"
		print "GENERATING :" + self._fWrite;
		print "from " + self._fRead + " " + self._bgImg;
		
		self.renderImage();


	def renderImage(self):

		""" Create a new image 
			Use background gif as base image
			Paste another image on top of that
			Write text to image
		"""
		
		im = Image.open(self._bgImg);
		im2  = Image.open(self._fRead);
		layer = Image.new('RGBA', (im.size[0], im.size[1]), (0,0,0,0))
		layer.paste(im, (0,0));
		
		
		p = (im.size[0] - im2.size[0])/2;
		q = (im.size[1] - im2.size[1])/2;

		
		layer.paste(im2,(p,q));
		tlayer = Image.new('RGBA', layer.size, (0,0,0,0))	
		draw = ImageDraw.Draw(tlayer);

		
		layer = Image.composite(tlayer, layer, tlayer)
		layer.save(self._fWrite);
		


