#!/usr/bin/python2.3
"""connectlb - utility to control load balanced applications.

This program requires one parameter:
 - the product authentication name (ie: gme, nec, etc.)

Format:

connectlb.py [options]

Options available:

-n, --name      productname    this is the authentication product name (gme,ea,atb,etc)

-l, --logfile   logfile        this is the basename for all log files (debug, log & error)
			       the .<fileext> is appended to this parameter.

-x, --xmlfile   xmlfile        this is the full path filename for the load balancer xml data.

-h, --help                     prints this help message

Example usage:

./connectlb.py -n nec -l /data/stage/utils/go2/updates/logs/loadbalancer.log

The above command line will post nec's asset information contained in the gonames table
to each of the GO servers.  This will be done interactively with the user and the load
balancers on each of the mirror sites.  Please follow instructions carefully without
skipping any steps.  Thank you.
"""

__version__ = 1.01

"""
revision history:

"""

import sys
import os
import pwd
import time
from LoadBalancer import *

def main():
    """main() -> None

    This is the main entry point for the program and is called as a CGI
    """
    import GI_LOGGER

    # see if the environment is okay to run
    environTest()
    # check the command line parameters
    params = Parameters()
    GI_LOGGER.setFilenameBase(params._getLogFile())
    GI_LOGGER.logMessage("debug","Environment & Parameter Validations Successful ...")

    GI_LOGGER.logMessage("info","Starting Load Balancer Utility")

    goNamesMgr = ProcessManager(params)
    goNamesMgr.go()
    

def environTest():
    """environTest() -> will exit program if not successful

    This function tests the environment to see if things are
    more or less okay to run
    """

    try:

        # do we have a valid PYTHONPATH environment variable?
        if "PYTHONPATH" not in os.environ:
            raise "there is no PYTHONPATH environment variable defined"

        # are we running on a Linux system?
        if "Linux" not in os.uname():
            raise "this tool can only run on a Linux based system"

    except:
        import GI_LOGGER
        msg = "Environment error :", sys.exc_info()[0]
        GI_LOGGER.logMessage("critical",msg) 
        sys.exit()

class ProcessManager(object):
    """This class handles the interaction between all the activities related to a GO Server
    production update.
    """
    def __init__(self, params):
        """ required input:
            Parameter object.
        """
	import GI_LOGGER
	self._params = params
	GI_LOGGER.logMessage("debug","Getting User Data ...")
	# user data
	import User
	debugMsg = "User (%s): Product (%s)" % (User.userInstance._getUsername(), 
						self._params._getProductName())
	GI_LOGGER.logMessage("debug",debugMsg)

    def go(self):
	import GI_LOGGER

	self._dbyLB = LoadBalancer("dby",self._params._getProductName(),
                                   self._params._getXmlFile())
	self._scLB = LoadBalancer("sc",self._params._getProductName(),
                                  self._params._getXmlFile())
	
        action = self.menu()
        # assume all loadbalancers are live
        zero = "on"
        one = "on"
        two = "on"
        three = "on"
	four = "on"

        while ((action != "X") and (action != "x")):
            if action == "1":
	       #present user with current status of all go backend servers
	       #to provide all information to correctly assess whether to continue
	       #with the update or not.
               self._dbyLB.status(self._params._getProductName())
               self._scLB.status(self._params._getProductName())
            elif action == "2":
                #stopping the zero servers
                if ((one == "on") and (two == "on") and (three == "on") and (four == "on")):
                    self._dbyLB.stop(self._params._getProductName(), "0")
                    self._scLB.stop(self._params._getProductName(), "0")
                    self._dbyLB.status(self._params._getProductName())
                    self._scLB.status(self._params._getProductName())
                    zero = "off"
                else:
                    print "Action not permitted.  The (1,2,3,4) servers must be on."
                    GI_LOGGER.logMessage("debug", "Attempting to stop the 0 servers while  other servers are down")

            elif action == "3":
                #starting the zero servers
                self._dbyLB.start(self._params._getProductName(), "0")
                self._scLB.start(self._params._getProductName(), "0")
                self._dbyLB.status(self._params._getProductName())
                self._scLB.status(self._params._getProductName())
                zero = "on"
            elif action == "4":
                #stopping the one servers
                #if (zero == "on"):
                if ((zero == "on") and (two == "on") and (three == "on") and (four == "on")):
                    self._dbyLB.stop(self._params._getProductName(), "1")
                    self._scLB.stop(self._params._getProductName(), "1")
                    self._dbyLB.status(self._params._getProductName())
                    self._scLB.status(self._params._getProductName())
                    one = "off"
                else:
                    print "Action not permitted. The (0,2,3,4) servers must be on."
                    GI_LOGGER.logMessage("debug", "Attempting to stop the 1 servers while other servers are down")
            elif action == "5":
                #starting the one servers
                self._dbyLB.start(self._params._getProductName(), "1")
                self._scLB.start(self._params._getProductName(), "1")
                self._dbyLB.status(self._params._getProductName())
                self._scLB.status(self._params._getProductName())
                one = "on"
            elif action == "6":
                #stopping the two server(s)
                if ((zero == "on") and (one == "on") and (three == "on") and (four == "on")):
                    self._dbyLB.stop(self._params._getProductName(), "2")
                    self._scLB.stop(self._params._getProductName(), "2")
                    self._dbyLB.status(self._params._getProductName())
                    self._scLB.status(self._params._getProductName())
                    two = "off"
                else:
                    print "Action not permitted. The (0,1,3,4) servers must be on."
                    GI_LOGGER.logMessage("debug", "Attempting to stop the 2 servers while other servers are down")
            elif action == "7":
                #starting the two server(s)
                self._dbyLB.start(self._params._getProductName(), "2")
                self._scLB.start(self._params._getProductName(), "2")
                self._dbyLB.status(self._params._getProductName())
                self._scLB.status(self._params._getProductName())
                two = "on"
            elif action == "8":
                #stopping the three server(s)
                if ((zero == "on") and (one == "on") and (two == "on") and (four == "on")):
                    self._dbyLB.stop(self._params._getProductName(), "3")
                    self._scLB.stop(self._params._getProductName(), "3")
                    self._dbyLB.status(self._params._getProductName())
                    self._scLB.status(self._params._getProductName())
                    three = "off"
                else:
                    print "Action not permitted. The (0,1,2,4) servers must be on."
                    GI_LOGGER.logMessage("debug", "Attempting to stop the 2 server(s) while other servers are down")
            elif action == "9":
                #starting the three server(s)
                self._dbyLB.start(self._params._getProductName(), "3")
                self._scLB.start(self._params._getProductName(), "3")
                self._dbyLB.status(self._params._getProductName())
                self._scLB.status(self._params._getProductName())
                three = "on"

            elif action == "10":
                #stopping the four server(s)
                if ((zero == "on") and (one == "on") and (two == "on") and (three == "on")):
                    self._dbyLB.stop(self._params._getProductName(), "4")
                    self._scLB.stop(self._params._getProductName(), "4")
                    self._dbyLB.status(self._params._getProductName())
                    self._scLB.status(self._params._getProductName())
                    four = "off"
                else:
                    print "Action not permitted. The (0,1,2,3) servers must be on."
                    GI_LOGGER.logMessage("debug", "Attempting to stop the 4 server(s) while other servers are down")

            elif action == "11":
                #starting the four server(s)
                self._dbyLB.start(self._params._getProductName(), "4")
                self._scLB.start(self._params._getProductName(), "4")
                self._dbyLB.status(self._params._getProductName())
                self._scLB.status(self._params._getProductName())
                four = "on"


            # what's next?
            action = self.menu()
	
    def menu(self):
        print "   1.  Display Load Balancer Status"
	print "   2.  Stop the Zero (0) Servers"
        print "   3.  Start the Zero (0) Servers"
        print "   4.  Stop the One (1) Servers"
        print "   5.  Start the One (1) Servers"
        print "   6.  Stop the Two (2) Servers"
        print "   7.  Start the Two (2) Servers"
        print "   8.  Stop the Three (3) Servers"
        print "   9.  Start the Three (3) Servers"
        print "   10. Stop the Four (4) Servers"
        print "   11. Start the Four (4) Servers"
	print "   X.  Exit\n"
        ans = raw_input("What would you like to do next? ")
        return ans
  



class Parameters(object):
    """Parameters(object)

    This class gets the command line arguments and does some basic
    validation. It also provides those arguments as properties
    of the class.
    """
    
    def __init__(self):
        """__init__(self) -> None

        Class constructor, parses the command line and pulls parameters from it.
        Those parameters and their values are available as class members.
        """
        import getopt
	import GI_LOGGER

        # get command line arguments
        try:
            opts, args = getopt.getopt(sys.argv[1:], 'n:h:l:x', ['help', 'name=', 'logfile=', 'xmlfile='])
        except getopt.GetoptError:
            help()

        # scan the command line arguments
        for o, a in opts:

            # are we asking for help?
            if o in ["-h", "--help"]:
                help()

            # what is the productname?
            if o in ['-n', '--name']:
                self._productname = a

            # what is the logfile?
            if o in ['-l', '--logfile']:
                self._logfile = a

            # what is the logfile?
            if o in ['-x', '--xmlfile']:
                self._xmlfile = a

        # did we get enough parameters?
        try:
            t = self._productname
	    t = self._logfile
	    t = self._xmlfile
        except:
            msg = "Parameter Error : missing a required command line parameter\n"
            GI_LOGGER.logMessage("error", msg)
            help()

    # set up some properties to get the parameter attributes
    def _getProductName(self): return self._productname
    def _setProductName(self, productname): raise AttributeError, "Can't set the productname attribute"
    def _getLogFile(self): return self._logfile
    def _setLogFile(self, logfile): raise AttributeError, "Can't set the productname attribute"
    def _getXmlFile(self): return self._xmlfile
    def _setXmlFile(self): return self._xmlfile
    productname = property(_getProductName, _setProductName)
    logfile = property(_getLogFile, _setLogFile)
    xmlfile = property(_getXmlFile, _setXmlFile)
    
def help():
    """help() -> exits program after it's called

    Print out the docstring of the module as help to the user
    """
    print __doc__
    sys.exit()


if __name__ == "__main__":
    main()
