import sys

import Packages.DataCloud;
from Packages.TemplateController import *;

if __name__ == "__main__":
	DataCloud.instance().load("radtest");
	#DataCloud.instance().printFeatures();
	
	tcList = [];
	tcList.append(TemplateController("article"));
	#tcList.append(TemplateController("search"));
	#tcList.append(TemplateController("media"));
	#tcList.append(TemplateController("text"));
	
	for x in tcList:
		x.process();
		print "\n";
		
		
	
	
	
