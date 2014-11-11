
__author__ = "Todd A. Reisel, modifications by Tyrone Mitchell"
__date__ = "March 14th, 2004"

from common.utils.GI_Transform import *;
from common.utils.GI_SubTemplate import *
import re

class GI_Transform_NewsTemplate(GI_Transform):
	def __init__(self, inputBuffer, params):
		self._params = params;
		GI_Transform.__init__(self, 'NewsTemplate', inputBuffer, params);
		
	def _process(self):

		#this block is pretty go2 specific
		templateType = "/news/feature_archive.html";
		if (self._params['topstory'] != None):
			templateType = "/news/feature.html";
		#this block ends go2 specific stuff
		
		self._params['templatetype'] = templateType;
		
		#this is used in the regular expression
		self.reMetaTagString = "(<meta name=\"template\" content=\"(.*)\"/>)";

		#this is used to replace/add in the content buffer
		self.metatagFormatSubtemplate = "<meta name=\"template\" content=\"##TEMPLATETYPE##\"/>";

		#do the magic replacement.
		st = GI_SubTemplate(self.metatagFormatSubtemplate);
		fullMetaTag = st.toString(self._params,self.metatagFormatSubtemplate);

		matches = re.findall(self.reMetaTagString, self._inputBuffer);
		if (len(matches) == 0):
			#no metatag exists, stick it in the content (maybe in the beginning)
			self._inputBuffer = fullMetaTag + "\n" + self._inputBuffer + "\n";
		else:
			#print "Matches found: " + str(matches);
			#metatag exists, replace it in the content.

			#take the first memorized item and replace it with the new tag that I need.
			oldString = matches[0][0];
			#print "Old:", oldString;
			#print "New:", fullMetaTag			
			self._inputBuffer = self._inputBuffer.replace(oldString, fullMetaTag);

		#set your output buffer, the caller will be able to get the contents to write to the file.
		self._outputBuffer = self._inputBuffer;
		
