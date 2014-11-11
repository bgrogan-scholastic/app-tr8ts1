####################################################
# Class: WebServerSuperTemplate
# Author: Tyrone Mitchell
# Date: 2/20/2003
# Purpose: Encompass the reading and writing of supertemplate files
#
####################################################
import DataCloud;
from SuperTemplate import *
import os

class WebServerSuperTemplate(SuperTemplate):
    def __init__(self, fileName, args = []):
        SuperTemplate.__init__(self, fileName, args);
        self.filename = fileName;
        self._xpathptr = args[1];
        self.servertype= args[0];
        
    def _getInputFilePath(self):
        query = '/webservers/server[@type="' + self.servertype + '"]/files/file[@name="' + self.filename + '"]';
        #print query;
        inputnode = self._xpathptr.query(query);
        inputdir = inputnode[0].getAttribute("inputdir");
        inputdir = os.path.join(inputdir, self.filename);
        #print "input="+str(inputdir);
        if (os.path.exists(inputdir)):
            return inputdir;
        else:
            return "";
        
    def _getOutputFilePath(self):
        query = '/webservers/server[@type="' + self.servertype + '"]/files/file[@name="' + self.filename + '"]';
        #print query;
        outputnode = self._xpathptr.query(query);
        outputdir = outputnode[0].getAttribute("outputdir");
        #outputfilename = self.filename.replace("_base", "_" + DataCloud.instance().getFeature("product").get("pcode"));
        outputfilename = self.filename.replace("_base", "_" + DataCloud.instance().value("pcode"));
        #get the product's pcode and substitute it.
        outputdir = os.path.join(outputdir, outputfilename);
        #print "output="+str(outputdir);
        return outputdir;

