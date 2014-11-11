###############################################################################
# Author: Todd A. Reisel
# Class: XPath
# Date: 1/24/2003
#
# Methods:
#        XPath()                               -constructor
#        XMLNodeList query(string)             -use the xpath statement and return all nodes that match
###############################################################################

#xml imports
from xml.dom.minidom import *;
from xml import xpath;
from queryexception import *;

class XPath:
    #constructor
    def __init__(self, filepath):

        self.__xmlFilePath = filepath;
        self.__xpathObject = None;

        self.__xpathObject = xml.dom.minidom.parse(self.__xmlFilePath);
        
    def query(self, xpathExpression):
		nodeValue = xpath.Evaluate(xpathExpression, self.__xpathObject.documentElement);
		if len(nodeValue) == 0:
                    print "Xpath Expression used for lookup is: " + xpathExpression;
                    raise QueryException, "xml element not found"; 
		
		return nodeValue;

