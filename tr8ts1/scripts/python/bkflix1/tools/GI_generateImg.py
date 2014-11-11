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

	def __init__(self, fileRead, fileWrite, bgImg, authStr, illusStr):
		"""
		The constructor will gather all the data needed to create the picture
		Also, the information on how to generate filename and where to write file to
	
		"""
		
		self._fRead = fileRead;
		self._fWrite = fileWrite;
		self._bgImg = bgImg;
		self._authStr = authStr;
		self._illusStr = illusStr;
		
		print "***************************"
		print "GENERATING :" + self._fWrite;
		print "from " + self._fRead + self._bgImg;
		print "with text " + self._authStr + ", " + self._illusStr;
		
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
		font = ImageFont.truetype("/data/bkflix1/utils/fonts/arialbd.ttf", 15)
		self._authStr = self._authStr.encode('latin-1')
		
		
		""" Get x,y coordinates of where to paste image 
			Center the image with it's text on the background image.
		"""
		
		dim = font.getsize(self._authStr);
		dim2 = font.getsize(self._illusStr);
		t = dim[1] + dim2[1];
		
		
		p = (im.size[0] - im2.size[0])/2;
		q = (im.size[1] - (im2.size[1] + t))/2;

		
		layer.paste(im2,(p,q));
		tlayer = Image.new('RGBA', layer.size, (0,0,0,0))	
		draw = ImageDraw.Draw(tlayer);

		d = (im.size[0] - dim[0])/2;
		q2= im.size[1] - ((im.size[1] - im2.size[1]) / 2);
		"""q2 = q2 + (dim[1]/2);"""
		
		
		"""draw.text((d, im2.size[1] + 20), self._authStr, font = font, fill = "#000000");"""
		draw.text((d, q2), self._authStr, font = font, fill = "#000000");
		
		d = (im.size[0] - dim2[0])/2;
		draw.text((d, q2 + (dim2[1])), self._illusStr, font = font, fill = "#000000");
		layer = Image.composite(tlayer, layer, tlayer)
		layer.save(self._fWrite);
		


