###############################################################################
# Author: Todd A. Reisel
# Class: SearchAndReplace
# Date: 2/5/2003
#
# Methods:
#        Tags(regexPattern, callbackFunction)  -constructor
#        process();	                       - find/hand off <pattern>
#        setContents(contents);                   - set the contents to work with
#        getContents();                             - get the contents after substitution
###############################################################################

#regular expressions;
import re;
import Log;


class SearchAndReplace:
    
    #constructor
    def __init__(self, regexPattern, functionCallback):

	#save and initialize parameters needed.       
	self.__sregexPattern = regexPattern;
	self.__functionCallback = functionCallback;
        self.__sContents = "";
 
    def setContents(self, contents):
	#this defines the contents that will get searched and replaced.
        self.__sContents = contents;

    def getContents(self, ignoreEmpty = 0):
	#this will perform the search and replace actions.
        #print "In SearchAndReplace::getContents-->" + self.__sContents;
        return self.__process(ignoreEmpty);

    def __process(self, ignoreEmpty):
        tempContents = self.__sContents;
        #using regular expressions find all occurances of the pattern
        matchesFound= re.findall(self.__sregexPattern, tempContents);

        #for each match of the pattern call the function reference that was passed in during contstruction of the object.
        for matchFound in matchesFound:
#            print matchFound;
            try:
                tempContents = re.sub(re.escape(matchFound), self.__functionCallback(matchFound).rstrip(), tempContents);
            except AttributeError, message:
                #the tag did not exist, so replace it with nothing and move on.
                tempContents = re.sub(re.escape(matchFound), "", tempContents);

                if ignoreEmpty == 0:
                    Log.instance().add("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~", Log.instance().bitMaskWarningAll());
                    Log.instance().add(str(message), Log.instance().bitMaskWarningAll());
                    Log.instance().add("This is probably because I can't find a match for "+ matchFound, Log.instance().bitMaskWarningAll());
                    print "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~";
                    raise AttributeError, message;

        return tempContents;

#run test harness
if __name__ == "__main__":
    def getData(matchFound):
        return "hello world";

    t = SearchAndReplace("\$\$[a-z]*\$\$", getData);
    t.setContents("do: $$tag$$");
    print t.getContents();


