#!/usr/bin/env python

"""This module creates an interface to the Lexile.com SOAP
web service. This is kind of complicated, but it seems to work pretty well.
For whatever reason, Python has difficulty talking to SOAP web services created
by Microsoft's .NET soap system. I did some digging around prototypes and
created this system which uses the ZSI library (amoung others) to get Python
to talk successfully to the web service. I got the basis of this code from this
site:

http://zcologia.com/news/64

The trick was to use the wsdl2py script that gets installed by the ZSI library.
This script creates two files when run against the WDSL source url. You
perform this step in the directory where you wish to create your SOAP script like this:

wsdl2py -u http://www.lexile.com/lexilews/lexileanalyzerws.asmx?wsdl

For this particular case this generates two files:

LexileAnalyzerWS_services.py
LexileAnalyzerWS_services_types.py

These two files are built by the wsdl2py utility specifically to talk to the
WSDL SOAP service specified in the command line. These two files must be
accessable to your program in order to run. 

"""

__VERSION__ = "1.00"
__AUTHOR__  = "Doug Farrell"
__CREATED__ = "March 31, 2006"


import sys
from ZSI import TC
from ZSI.client import Binding

try:
    from LexileAnalyzerWS_services import *
except ImportError:
    print "The file LexileAnalyzerWS_services.py must be in your current directory in order for the lexile module to work."
    sys.exit(-1)
    

class Lexile(object):
    """This class creates the interface to the lexile.come SOAP interface
and allows the user to communicate with the interface to run functions.
Right now the only function supported by the site is the Anaylze function
that does lexile analysis of the passed text.
"""
    def __init__(self, tracefile = None):
        """Constructor for the class
tracefile - this is where messages and output are sent. The default is
for them to be sent nowhere, which is good for runtime, but should be set to
sys.stdout for debugging purposes.
"""
        opts = {'tracefile' : tracefile}
        self._location = LexileAnalyzerWSLocator()
        self._server = self._location.getLexileAnalyzerWSSoap(**opts)

    def Analyze(self, params):
        """This function actually calls the remote SOAP service function
Analyze and passes it the parameters it expects. This function expects
a diction as it's parameter, containing the parameters the SOAP Analyze
function expects in lower case.
"""
        retval = {}
        # make the request
        self._req = AnalyzeSoapIn()
        self._req._username = params["username"]
        self._req._password = params["password"]
        self._req._str = params["str"]
        rsp = self._server.Analyze(self._req)
        # return the results
        retval["Lexile"] = rsp._AnalyzeResult._Lexile
        retval["WordCount"] = rsp._AnalyzeResult._WordCount
        retval["MeanSentenceLength"] = rsp._AnalyzeResult._MeanSentenceLength
        retval["MeanLogWordFrequency"] = rsp._AnalyzeResult._MeanLogWordFrequency
        return retval
    

# some self-test code.
if __name__ == "__main__":
    lexile = Lexile()
    params = {
        "username" : "scholasticadmin",
        "password" : "1720L",
        "str" : "Now is the time for all good men to come to the aid of their country"
        }
    result = lexile.Analyze(params)
    print "Sentence = %s" % params["str"]
    print "Lexile = %s" % result["Lexile"]
    print "WordCount = %s" % result["WordCount"]
    print "MeanSentenceLength = %s" % result["MeanSentenceLength"]
    print "MeanLogWordFrequency = %s" % result["MeanLogWordFrequency"]
    print 
    params = {
        "username" : "scholasticadmin",
        "password" : "1720L",
        "str" : "Four score and seven years ago our fathers brought forth on this continent, a new nation."
        }
    result = lexile.Analyze(params)
    print "Sentence = %s" % params["str"]
    print "Lexile = %s" % result["Lexile"]
    print "WordCount = %s" % result["WordCount"]
    print "MeanSentenceLength = %s" % result["MeanSentenceLength"]
    print "MeanLogWordFrequency = %s" % result["MeanLogWordFrequency"]
