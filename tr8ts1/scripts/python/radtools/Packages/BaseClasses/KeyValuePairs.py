#file KeyValuePairs.py

#------------------------------------------------------
# Name:        KeyValuePairs
# Author:      Tyrone Mitchell
# Date:        2-6-2003
# Description: This class contains the necessary functionality
#  to store key-value pairs in a dictionary. Wrapper class.
#------------------------------------------------------

class KeyValuePairs:
    def __init__(self):
        self.myOptions = {};
        
    def __del__(self):
        self.clear();

    def insert(self, key, value):
        self.myOptions[key] = value;

    def clear(self):
        self.myOptions.clear();

    def remove(self, key):
        if (self.myOptions.has_key(key)):
            del self.myOptions[key];

    def value(self, key):
        if (self.myOptions.has_key(key)):
            return self.myOptions[key];
        else:
            return None;


    def printvalues(self, toscreen="true"):
        msg = "";

        line = "";
        for x in range(0,30):
            line += "-";
        #msg = msg + line + "\n";
        for name in self.myOptions:
            status = "Key: " + name + "\t\tValue: " + str(self.myOptions[name]) + "\n";
            msg = msg + status; 
        msg = msg + line + "\n";
        if (toscreen=="true"):
            print msg;
        
        return msg;

def main():
    kvp = KeyValuePairs();
    kvp.insert("clifford", "dog");
    kvp.insert("snarf", "cat");
    kvp.insert("felix", "cat");
    kvp.printvalues();
    kvp.remove("snarf");
    kvp.remove("house");
    kvp.printvalues();
    print kvp.value("clifford");
    kvp.clear();
    kvp.printvalues();
    kvp.insert("dog", "Clifford");
    kvp.insert("cat", "Snarf");
    kvp.insert("cat", "Felix");
    kvp.printvalues();
    
if __name__ == "__main__":
    main()
