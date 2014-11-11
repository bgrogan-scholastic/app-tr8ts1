#file DataCloud.py

#------------------------------------------------------
# Name:        DataCloud
# Author:      Tyrone Mitchell
# Date:        2-6-2003
# Description: This contains the DataCloud class. This class encapsulates 
#  Features and a KeyValuePairs Object.
#------------------------------------------------------

from BaseClasses.SerializeInterface import *
from BaseClasses.subject import *
from BaseClasses.observer import *
import Features
from BaseClasses import KeyValuePairs
import copy
import os



class DataCloud(SerializeInterface, Subject):
    #------------------------------------------------------
    # Name:        __init__
    # Description: basic constructor.
    #------------------------------------------------------
    def __init__(self):
        self.__configsdirectory = "/data/rad/supertemplates/configs";
        self.__fext = ".dc.log";
        self.__features = {};
        self.__keyvaluepairs = KeyValuePairs.KeyValuePairs();
        
        #this will be a list of keyValuePairs that are volatile
        self.__nonSaveableData = KeyValuePairs.KeyValuePairs();
        
        #set up the "committed" datacloud information
        self.__cKVP = KeyValuePairs.KeyValuePairs();
        self.__cfeatures = {};

        #your list of observers
        Subject.__init__(self);

    #------------------------------------------------------
    # Name:        clear
    # Description: removes all the data from the DataCloud, and removes
    #              the saved datacloud from the default directory.
    #------------------------------------------------------
    def clear(self):
        try:
            code = self.value("pcode");
            if code != None:
                file = os.path.join(self.__configsdirectory, code+self.__fext);
                print "Deleting datacloud log file for " + str(code) + " at " + str(file);
                if os.path.exists(file):
                    os.remove(file);
            else:
                print "There is no datacloud loaded! I can't delete the DataCloud Log file";
        except:
            pass;

        #include amnesia to the DataCloud
        self.__features = {};
        self.__keyvaluepairs = KeyValuePairs.KeyValuePairs();
        #this will be a list of keyValuePairs that are volatile
        self.__nonSaveableData = KeyValuePairs.KeyValuePairs();
        self.commit();
        
    #------------------------------------------------------
    # Name:        add
    # Description: allows the user to insert a common (non-feature specific)
    #  value in the DataCloud using a KeyValuePairs object.
    #------------------------------------------------------
    def add(self, key, value):
        self.__keyvaluepairs.insert(key, value);

    #------------------------------------------------------
    # Name:        addNS
    # Description: allows the user to insert a common (non-feature specific)
    #  value in the DataCloud using a Non-Saveable KeyValuePairs object.
    #------------------------------------------------------
    def addNS(self, key, value):
        self.__nonSaveableData.insert(key,value);

    #------------------------------------------------------
    # Name:        removeNS
    # Description: allows the user to remove a common (non-feature specific)
    #  value in the DataCloud using a Non-Saveable KeyValuePairs object.
    #------------------------------------------------------
    def removeNS(self, key):
        self.__nonSaveableData.remove(key);
        
    #------------------------------------------------------
    # Name:        remove
    # Description: removes a value previously stored in the DC's internal KVP
    # object.
    #------------------------------------------------------
    def remove(self, key):
        self.__keyvaluepairs.remove(key);

    #------------------------------------------------------
    # Name:        value
    # Description: returns a value stored into the DC's internal KeyValuePairs object
    #------------------------------------------------------
    def value(self, key):
        return self.__keyvaluepairs.value(key);


    #------------------------------------------------------
    # Name:        valueNS
    # Description: returns a value stored into the DC's internal KeyValuePairs object
    #------------------------------------------------------
    def valueNS(self, key):
        return self.__nonSaveableData.value(key);


    #------------------------------------------------------
    # Name:        save
    # Description: the second parameter is productcode (i.e., "eas".).
    # This parameter is used to help build a full pathname to load and save files.
    #------------------------------------------------------
    def save(self, productcode):
        #make the changes to the real datacloud
        self.commit();
        contents  = self.printFeatures("false");
        #print contents;
        productcode = productcode.rstrip();
        if len(productcode)==0:
            raise IOError, "DataCloud::save ==> productname is null.";
        
        filename = os.path.join(self.__configsdirectory, productcode+self.__fext);
        #print filename;
        try:
            fhandle = open(filename, 'w');
            fhandle.write(contents);
            fhandle.close();
        except IOError, message:
            print "I/O Error: " + str(message);
        except:
            print "Error occurred saving file.";
            
    #------------------------------------------------------
    # Name:        __getKeyValuePair
    # Description: private function used to extract key,value from one 
    #  line of DataCloud data file.
    #------------------------------------------------------
    def __getKeyValuePair(self, dataline):
        tuple = ("","");
        #data definitions
        keyheader = "Key: ";
        valueheader = "\t\t" + "Value: ";
        #get index in string after valueheader marker
        idx = dataline.find(valueheader, 4);
        #get the key and the value, set the tuple, and return;
        thiskey=dataline[len(keyheader):idx];
        thisvalue=dataline[idx+len(valueheader):];
        tuple = (thiskey, thisvalue);
        #print tuple;
        return tuple;

    #------------------------------------------------------
    # Name:        load
    # Description: the second parameter is productcode (i.e., "eas".).
    # This parameter is used to help build a full pathname to load and save files.
    #------------------------------------------------------
    def load(self, productcode):
        #data Definitions
        featureseperator = "------------------------------"; #always 30 characters
        featureheader = "Feature: ";
        nokeys = "No KeyValuePairs";

        #open filename if possible. If not, return blank DataCloud feature to user.
        filename = os.path.join(self.__configsdirectory, productcode+self.__fext);
        #print filename;
        if not (os.path.exists(filename)):
            return singleDataCloud;

        file = open(filename, 'r');
        allLines = file.readlines();


        #the first 4 lines contain basic header information. After this, read the
        #DataCloud's keyValuePairs information. If no info exists, the
        #featureseperator will exist in its place. After that, start reading features.
        allLines = allLines[4:];
        file.close();
        #read the datacloud's KeyValuePairs object into memory
        lineindex = 0;
        while (allLines[lineindex].rstrip() != featureseperator):
            allLines[lineindex] = allLines[lineindex].rstrip();
            (key, value) = self.__getKeyValuePair(allLines[lineindex]);
            lineindex = lineindex + 1;
            singleDataCloud.add(key, value);
        if (allLines[lineindex].rstrip()==featureseperator):
            allLines = allLines[lineindex + 1:];

        #print allLines[0];
        #read all features now.
        for thisline in allLines:
            thisline = thisline.rstrip();     #remove newline character
            if cmp(thisline,nokeys)==0:
                feat = Features.Features(featurename);
                singleDataCloud.addFeature(feat);
                #print "No keys here";            
            elif thisline.find(featureheader)==0:
                featurename = thisline[len(featureheader):];
                feat = Features.Features(featurename);
                #print featurename;
            elif thisline != featureseperator:
                (key, value) = self.__getKeyValuePair(thisline);
                feat.set(key, value);
            else:
                singleDataCloud.addFeature(feat);
                #print "End of feature\n"

        #commit the preview datacloud to the real one.
        self.commit();
        #print "++++++++++++++++++++++++++++++++++++++++++++++++++";
        #print singleDataCloud.__cfeatures;
        #print "++++++++++++++++++++++++++++++++++++++++++++++++++";

        #singleDataCloud.printFeatures();
        #return singleDataCloud;

    def commit(self):
        singleDataCloud.__cKVP = copy.deepcopy(singleDataCloud.__keyvaluepairs);
        singleDataCloud.__cfeatures = copy.deepcopy(singleDataCloud.__features);

    def rollback(self):
        singleDataCloud.__keyvaluepairs = copy.deepcopy(singleDataCloud.__cKVP);
        singleDataCloud.__features = copy.deepcopy(singleDataCloud.__cfeatures);

    #------------------------------------------------------
    # Name:        hasFeature
    # Description: Simple function that checks if your DataCloud has 
    # a featurename that is equal to the one you've passed. Returns 0 if false,1 if true.
    #------------------------------------------------------            
    def hasFeature(self, featurename):
        return self.__features.has_key(featurename);

    #------------------------------------------------------
    # Name:        doFeaturesExist
    # Description: will return true if all the features in your list (passed in) exist.
    #------------------------------------------------------            
    def doFeaturesExist(self, featurelist):
        for f in featurelist:
            if not self.__features.has_key(featurename):
                return false;

        #otherwise, you can return true;
        return true;

    #------------------------------------------------------
    # Name:        getFeature
    # Description: Returns a Features object to the caller if it exists in the DataCloud.
    # otherwise, it returns a new Features object, which you might want to populate.
    #------------------------------------------------------
    def getFeature(self, featurename):
        if (self.hasFeature(featurename)):
            return self.__features[featurename];
        else:
            blankFeature = Features.Features("");
            return blankFeature;

    #------------------------------------------------------
    # Name:        getFeatureNames
    # Description: Simple function returns the feature names to you in a list; you can iterate over them :)
    #------------------------------------------------------            
    def getFeatureNames(self):
        return self.__features.keys();


    #------------------------------------------------------
    # Name:        addFeature
    # Description: Adds a Features object to the DataCloud. A deep copy is made so if 
    # the caller continues to make changes to the object, the changes are reflected
    # in the DataCloud.
    #------------------------------------------------------
    def addFeature(self, Feature):
        self.__features[Feature.getFeatureName()] = copy.deepcopy(Feature);

    #------------------------------------------------------
    # Name:        removeFeature
    # Description: Removes a feature based on feature name, and does it safely.
    #------------------------------------------------------
    def removeFeature(self, featurename):
        if self.__features.has_key(featurename):
            del self.__features[featurename];
        
    #------------------------------------------------------
    # Name:        printFeatures
    # Description: Prints information to screen if second argument is =="true", else  
    # the function will return the output as a string instead. 
    #------------------------------------------------------
    def printFeatures(self, toscreen="true"):
        msg =  "DataCloud information\n";
        msg += "+++++++++++++++++++++\n";
        msg += "DC KeyValuePairs Info:\n"
        msg += "======================\n";
        
        msg = msg+self.__keyvaluepairs.printvalues("false");
        for x in self.__features:
            msg = msg+self.__features[x].printFeatures("false");
        if (toscreen=="true"):
            print msg;
        else:
            return msg;

    #-------------------------------------------------------------
    # Name: getPasswordKeyName(host, username)
    # Description: get the data key based on hostname and value
    #-------------------------------------------------------------
    def getMachinePasswordKeyName(self, host, username):
        return host + "_" + username + "_password";
    
    #-------------------------------------------------------------
    # Name: getMachinePassword(host, username)
    # Description: this function will ask the for the non-stated
    #              password, based on host (ex. qadev) and username
    #-------------------------------------------------------------
    def getMachinePassword(self, host, username):
        return self.valueNS(self.getMachinePasswordKeyName(host, username));

    #-------------------------------------------------------------
    # Name: setMachinePassword(host, username, password)
    # Description: set the password for the machine and username in question
    #              in the non stated data.
    #-------------------------------------------------------------
    def setMachinePassword(self, host, username, password):
        return self.addNS(self.getMachinePasswordKeyName(host, username), password);
    
#this is the DataCloud that is passed back to you in the instance function.
#Everyone should just use this DataCloud for all the features that they want to store.
singleDataCloud = None;

#------------------------------------------------------
# Name:        instance
# Description: will return the singleDataCloud object to you,
# but will be instantiated only once.
#------------------------------------------------------
def instance():
    #print "singleDataCloudType=" + str(type(singleDataCloud));
    global singleDataCloud;
    if singleDataCloud == None:
        singleDataCloud = DataCloud();
    return singleDataCloud;

def main():
    myCloud = instance();

    myFeature = Features.Features("article");
    myFeature.set("browse", "subject");
    myFeature.set("footer", "on");
    myFeature.set("thumbnails", 4);
    myFeature.set("printerfriendly", "on");
    #myFeature.printFeatures();

    mainFeature = Features.Features("media");
    mainFeature.set("quicktime", "true");
    mainFeature.set("flash", "true");
    mainFeature.set("dmaps", "on");
    mainFeature.set("VRML", "not on your life");
    mainFeature.set("RealPlayer", "no");
    mainFeature.set("Windows Media", "yes");
    mainFeature.set("MP3", "no!");
    #mainFeature.printFeatures();

    myCloud.addFeature(myFeature);
    myCloud.addFeature(mainFeature);
    myCloud.printFeatures();

    artFeat = myCloud.getFeature("article");
    artFeat.set("media", "on");
    print artFeat.get("browse");

    artFeat.printFeatures();
    myCloud.printFeatures();

    print "Getting media/quicktime setting";
    print myCloud.getFeature("media").get("quicktime");

    print "Checking for feature dancinghamsters";
    print "Does feature dancinghamsters exist? " + str(myCloud.hasFeature("dancinghamsters"));
    print "Getting feature dancinghamsters";
    nonexistentFeature = myCloud.getFeature("dancinghamsters");
    nonexistentFeature.printFeatures();

    myCloud.add("pcode", "eas");
    myCloud.add("pname", "Encyclopedia of American Studies");
    myCloud.printFeatures();

    myCloud.save("data");
    myCloud.load("data");
    myCloud.clear();
    
if __name__ == "__main__":
    main()




   
