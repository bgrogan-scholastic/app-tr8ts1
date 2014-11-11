#file Features.py

#------------------------------------------------------
# Name:        Features
# Author:      Tyrone Mitchell
# Date:        2-6-2003
# Description: The Feature object holds a name of a feature,
# and a KeyValuePairs object containing options.
# 
#------------------------------------------------------

from BaseClasses import KeyValuePairs
from BaseClasses import SerializeInterface


class Features(SerializeInterface.SerializeInterface):
    #------------------------------------------------------
    # Name:        __init__
    # Description: simple constructor
    #------------------------------------------------------
    def __init__(self, featurename):
        self.__features = {};
        self.__featurename = featurename;
        self.keyvaluepairs = KeyValuePairs.KeyValuePairs();

    #------------------------------------------------------
    # Name:        __del__
    # Description: simple descructor
    #------------------------------------------------------
    def __del__(self):
        self.features = {};
        self.__featurename = "";
        self.keyvaluepairs.clear();

    #------------------------------------------------------
    # Name:        clear
    # Description: simply clear the features
    #------------------------------------------------------
    def clear(self):
        self.keyvaluepairs.clear();
        
    #return the name of this feature
    #------------------------------------------------------
    # Name:        getFeatureName
    # Description: returns the stored name of this Feature to the caller.
    #------------------------------------------------------
    def getFeatureName(self):
        return self.__featurename;

    #------------------------------------------------------
    # Name:        get
    # Description: returns the value the the key for this feature.
    #------------------------------------------------------
    def get(self, key):
        if self.__featurename not in self.__features:
            return None;
        else:
            return self.__features[self.__featurename].value(key);

    #------------------------------------------------------
    # Name:        set
    # Description: sets a key and value for this feature.
    #------------------------------------------------------
    def set(self, key, value):
        self.keyvaluepairs.insert(key, value);
        self.__features[self.__featurename] = self.keyvaluepairs;

    #------------------------------------------------------
    # Name:        save
    # Description: unimplemented
    #------------------------------------------------------
    def save(self, filename):
        pass

    #------------------------------------------------------
    # Name:        load
    # Description: unimplemented
    #------------------------------------------------------
    def load(self, filename):
        pass

    #------------------------------------------------------
    # Name:        printFeatures
    # Description: Prints information to screen if second argument is =="true", else  
    # the function will return the output as a string instead. 
    #------------------------------------------------------
    def printFeatures(self, toscreen="true"):
        msg = "Feature: " + self.__featurename + "\n";

        if (self.__features.has_key(self.__featurename)):
            value = self.__features[self.__featurename].printvalues(toscreen);
            msg += str(value);
        else:
            status = "No KeyValuePairs\n";
            msg = msg + status;

        if (toscreen=="true"):
            print msg;
        else:
            return msg;

   
def main():
    myFeature = Features("article");
    myFeature.set("browse", "subject");
    myFeature.set("footer", "on");
    myFeature.set("thumbnails", 4);
    myFeature.set("printerfriendly", "on");
    myFeature.printFeatures();

if __name__ == "__main__":
    main()
