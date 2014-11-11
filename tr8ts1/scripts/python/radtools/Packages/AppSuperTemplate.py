#######################################################################################################################################
# Class: AppSuperTemplate
# Author: Todd A. Reisel
# Date: 2/19/2003
# Purpose: Encompass the reading and writing of supertemplate files
# Derived From: SuperTemplate
#      Implements:
#            string _getInputFilePath(self) - returns the file path that should be used to retrieve the file's contents
#            string _getOutputFilePath(self) - returns the file path that should be used to write the file with the internal contents
#
# Specific Class Methods:
#
# string getTemplateType(self) - look in the xml file, based on feature name and find my template type, (template, includeobject, include, etc)
# string getFeatureName(self) - look at the first part of my filename and return that as the featurename, example: article.html's featurename is: article.
#######################################################################################################################################
from SuperTemplate import *;
from BaseClasses.xpath import *;
import DataCloud;
from Features import *;
import os;

class AppSuperTemplate(SuperTemplate):
	def __init__(self, filename, args = []):
		SuperTemplate.__init__(self, filename, args);
		self.__sproductType = args[0];    #either graphical or ada
		self.__xmlData = args[1];         #the xml data object
		self.__sViewMode = args[2];       #whether or not this is a preview template
		
	def _getInputFilePath(self):
		tempPath = "";
		
		#look in the xml file for the possible locations of the super templates.
		for x in self.__xmlData.query('/rad/directories/directory[@name="supertemplates"]/locations/*'):
			tempPath = self._transFormPath(str(x.getAttribute("dir")));
			tempPath = os.path.join( tempPath, os.path.join(self.__sproductType, os.path.join(os.path.splitext(self._sFileName)[1][1:], self._sFileName)));
			#print tempPath;
			#see if the complete filepath exists, if so , return that, otherwise keep looking.
			if os.path.exists( tempPath ):
				return tempPath;

		#didn't find anything , can't move on.
		errorMesg = "AppSuperTemplate::_getInputFilePath() Could not find file " + str(self._sFileName) + " while looking in path: " + str(tempPath);
		Log.instance().add(errorMesg, Log.instance().bitMaskCriticalAll());
		raise IOError, errorMesg;
		return None;
	 
	def _getOutputFilePath(self):
		#determine the output file path based on the type of template this file is , which is based on the templatetype attribute of the template tag in xml for this file.
		outputFilePath = os.path.join( self.__xmlData.query('/rad/directories/directory[@name="apptemplates"]/locations/location[@name="' + self.getTemplateType() + '"]')[0].getAttribute("dir") , self._sFileName);

	        #perform pcode subsitution, this will replace ##pcode## with the product code specified in the data cloud.
		if self.__sproductType == "ada":
			outputFilePath = outputFilePath.replace("##pcode##", "##pcode##-ada");

		#see if preview mode was specified and if so, write template out as a rad product template.
		if self.__sViewMode == "preview":
			return outputFilePath.replace("##pcode##", "radpreview");
		else:
			return outputFilePath;
		

	######## SPECIFIC FUNCTIONALITY - only available to AppSuperTemplate class ####
	#------------------------------------------------------------------------------
	# Method: getTemplateType
	# Scope: public
	# Parameters : self
	#              as usual self is a reference to this instance of the class.
	# Purpose: look in the xml file for what type of template this feature is.
	#          This will be used to determine output directory.
	#------------------------------------------------------------------------------
	def getTemplateType(self):
              #this determines where the file will get stored based on its type in the xml definition.
	      return self.__xmlData.query('/rad/apptemplates/template[@id="' + self.getFeatureName() + '"]')[0].getAttribute("templatetype");



        #-------------------------------------------------------------------------------
	# Method: getFeatureName
	# Scope: public
	# Parameters: self
	#            as usual self is a reference to this instance of the class.
	# Purpose: using the last part of the filepath: filename : determine the feature name.
	# Return Value: the feature's name based on templatename
        #-------------------------------------------------------------------------------
	def getFeatureName(self):
		
            #get the actual name of the template file, by taking the last piece of information in the complete filepath.
	    tempFeatureName = os.path.split(self._sFileName)[len(os.path.split(self._sFileName))-1];

            #if an underscore exists then the featurename is everything before the _
            #else if a period exists then the featurename is everything before the .
            #if all else fails the feature name is the last piece of info as it is in the complete filepath.
	            
	    if tempFeatureName.find("_") != -1:
		    tempFeatureName = tempFeatureName[0:tempFeatureName.find("_")];
	    elif tempFeatureName.find(".") != -1:
		    tempFeatureName = tempFeatureName[0:tempFeatureName.find(".")];

	    return tempFeatureName;


 
if __name__ == "__main__":
	myFeat = Features("product");
	myFeat.set("pcode", "radtest");
	DataCloud.instance().addFeature(myFeat);

	myXml = XPath("/data/rad/supertemplates/xml/apptemplates.xml");
	myST = AppSuperTemplate("article.html", ["graphical", myXml]);
	print myST.getContents();
	myST.write();
	
