import sys
import os
from BaseClasses.fileutils import *
from BaseClasses.searchandreplace import *
from BaseClasses.xpath import *
import DataCloud
import Log
import FileLog
sys.path.append("/home/qadevWS/python/radtools")
sys.path.append("/home/qadevWS/releasetool/")
import utilities
import telnetlib
xmlDirectory = "productsetup";
_fullXMLPath = "/product" + xmlDirectory + "/steps/"
myXMLPath = _fullXMLPath + '/step[@key="'+str(step.getAttribute("key"))+'"]/commands/'
myTelnetClient = None


try:
        myTelnetClient = utilities.giTelnet(hostname,username,password)
        returnValue = None;
        #loop through the commands.
        for cmd in __xmlData.query(myXMLPath+"*"):
                mymessage = _transformPath(str(cmd.getAttribute("message")))
                print mymessage;
                instruction = _transformPath(str(cmd.getAttribute("instruction")))
                if instruction == "su -":
                        newpassword = _window.getPassword(hostname)
                        returnValue = str(myTelnetClient.suroot(newpassword))
                        print returnValue;
                        if returnValue.find("Password: not received") < 0:
                                print _transformPath(str(cmd.getAttribute("errmessage")))
                                if _transformPath(str(cmd.getAttribute("onerror"))) == "stop":
                                        break
                        else:
                                err = "ERROR Occurred connecting to " + hostname + " Unable to Continue"
                                print err
                                break
                        #_log.add(err)
                else:
                        until = str(cmd.getAttribute("wait"))
                        if until != "":
                                returnValue = str(myTelnetClient.commandUntil(instruction,until))
                        else:
                                returnValue = str(myTelnetClient.command(instruction))
                        if returnValue != "['$ ']":
                                print _transformPath(str(cmd.getAttribute("errmessage")))
                                if _transformPath(str(cmd.getAttribute("onerror"))) == "stop":
                                        break

                        print returnValue
                        #_log.add(str(returnValue))

except Exception:
        Log.instance().add("Telnet to "+hostname+" failed", Log.instance().bitMaskCriticalAll())
        myTelnetClient.close()
