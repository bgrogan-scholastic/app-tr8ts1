#--------------------------------------------------
# File:   Release.py
# Author: Lori Hongach
# Date:   May 15, 2003
#--------------------------------------------------

import sys
import threading
sys.path.append("/home/qadevWS/python/radtools")
sys.path.append("/home/qadevWS/releasetool")
import os
import time
import utilities
from Packages.BaseClasses.xpath import *
import Log

#------------------------------------------------------
# Name:        Release
# Author:      Lori Hongach
# Date:        May 15, 2003
# Description: This class is responsible for releasing
# a RAD product.
#------------------------------------------------------
class Release:
    
    def __init__(self, pcode):
        
        self.__PCODE               = '##PCODE##'
        self.__UPPERPCODE          = '##UPPERPCODE##'        
        self.__pcode               = pcode
        self.__tarcommand          = 'tar -cvPf '
        
        self.__date                = time.strftime("%m%d%y", time.localtime())
        self.__tarfiles            = os.path.join('/data', 'rad',
                                                  'releasetars')
        self.__templatefiles       = os.path.join('/data', 'rad',
                                                  'supertemplates',
                                                  'release')      
        self.__tarDestination      = os.path.join('/export', 'home', 'release',
                                                  'packages', 'rad')
        self.__xmlDir              = os.path.join('/data', 'rad',
                                                  'supertemplates', 'xml',
                                                  'release/')

        #------------------------------------------------------
        # This variable stores the different commands that need to get
        # run once the tar files have been ftp'd to the destination
        # machines.  This is a dictionary of dictionaries.
        #------------------------------------------------------        
        self.__installInstructions = {}

        #------------------------------------------------------
        # This variable stores the location information (hostname, ip, product)
        # It's a dictionary of dictionaries, with the initial key being the
        # product, then the second dictionary will hold the hostname/ip info
        #------------------------------------------------------        
        self.__selectedLocation    = {}

        #------------------------------------------------------
        # This will list the different product types ie: go, rad, gosrch
        #------------------------------------------------------        
        self.__productTypes = []   

        #------------------------------------------------------
        # This variable is dictionary of a dictionary of list holding all of
        # the file and template names.
        # ie: {'go': {'files': ['go1', 'go2']}, 'rad': {'files': ['eas1',
        # 'eas2'], 'templates': ['/data/eas/config/altproduct',
        # '/data/auth/config/virtualhost_rad']},
        # 'gosrch': {'files': ['gosrch1', 'gosrch2']}}
        #------------------------------------------------------
        self.__packageInfo = {}

        #------------------------------------------------------
        # This variable stores the variable data for each different machine.
        # It is a dictionary of dictionaries, which stores the value.
        # ie: self.__variables['myvar']['gosrch'] = 'mytest'
        #------------------------------------------------------        
        self.__variables           = {}
        self.__log                 = Log.instance()
        
    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   May 16, 2003
    # Name:   execute
    #
    # This is the main function.  It will control the execution
    # process which is involved in releasing a product
    #------------------------------------------------------
    def executeRelease(self, location, passwords, graphicip, adaip):

        self.__location            = location
        self.__passwords           = passwords
        self.__graphicip           = graphicip
        self.__adaip               = adaip

        self.__xmlData  = XPath(self.__xmlDir + "releasedata.xml")
        self.__xmlVariables = XPath(self.__xmlDir + "releasevariables_" + \
                                    self.__pcode + ".xml")

        #------------------------------------------------------
        # Grab and store the correct machine information
        #------------------------------------------------------
        self.determineLocationData()

        #------------------------------------------------------
        # Grab and store the appropriate package information
        #------------------------------------------------------
        self.determinePackageData()

        #------------------------------------------------------
        # Grab and store the appropriate variable values
        #------------------------------------------------------
        self.determineVariableData()

        #------------------------------------------------------
        # Get the installation instructions
        #------------------------------------------------------
        self.determineInstallInstructions()

        #------------------------------------------------------
        # Do the variable substitution
        #------------------------------------------------------
        self.templateVariableSubstitution()

        #------------------------------------------------------
        # Execute local commands
        #------------------------------------------------------
        self.executeLocalCommands()
        
        #------------------------------------------------------
        # Tar files
        #------------------------------------------------------
        self.tarFiles()

        #------------------------------------------------------
        # Ftp files
        #------------------------------------------------------
        self.ftpFiles()

        #------------------------------------------------------
        # Release the new product on the machines
        #------------------------------------------------------
        self.releasePackage()


    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   May 16, 2003
    # Name:   determineLocationData
    #
    # This function will parse through the xml file which holds
    # the location information and store the necessary data
    #------------------------------------------------------
    def determineLocationData(self):

        self.__log.add("RELEASE: Reading location data...")              

        #------------------------------------------------------
        # Parse through the xml file and store the results
        #   self.__location is a dictionary holding all of
        # the machine specfic information.
        #------------------------------------------------------
        locationData    = {}
        datapath        = "/releasedata/locations/"

        for location in self.__xmlData.query(datapath + "*"):
            name = str(location.getAttribute("name"))
            if name == self.__location:
                machineSpecific = datapath + 'location[@name="' + name + '"]/*'
                machines        = self.__xmlData.query(machineSpecific)

                for machine in machines:
                    hostname = str(machine.getAttribute("hostname"))
                    ip       = str(machine.getAttribute("ip"))
                    type     = str(machine.getAttribute("type"))

                    if not self.__selectedLocation.has_key(type):
                        self.__selectedLocation[type] = {}
                        
                    self.__selectedLocation[type]['location'] = name
                    self.__selectedLocation[type]['hostname'] = hostname
                    self.__selectedLocation[type]['ip']       = ip

                    if not type in self.__productTypes:
                        self.__productTypes.append(type)


    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   May 21, 2003
    # Name:   determinePackageData
    #
    # This function will parse through the xml file which holds
    # the package information, store the necessary data,
    # and replace any PCODE variables with the appropriate text
    #------------------------------------------------------
    def determinePackageData(self):

        self.__log.add("RELEASE: Reading package data...")                     

        datapath = "/releasedata/packages/"

        #------------------------------------------------------        
        # Parse through the xml file and store the results
        #------------------------------------------------------        
        for type in self.__xmlData.query(datapath + "*"):
            name = str(type.getAttribute("type"))

            try:
                productSpecific = datapath + 'package[@type="' + name + \
                                  '"]/file/text()'                
                for file in self.__xmlData.query(productSpecific):

                    if not self.__packageInfo.has_key(name):
                        self.__packageInfo[name] = {}

                    if not self.__packageInfo[name].has_key('files'):
                        self.__packageInfo[name]['files'] = []
                                        
                    self.__packageInfo[name]['files'].append(str(file.nodeValue).replace(self.__PCODE, self.__pcode))

            except QueryException:
                pass


            try:
                productSpecific = datapath + 'package[@type="' + name + \
                                  '"]/template/text()'
                for template in self.__xmlData.query(productSpecific):
                    if not self.__packageInfo.has_key(name):
                        self.__packageInfo[name] = {}
                        
                    if not self.__packageInfo[name].has_key('templates'):
                        self.__packageInfo[name]['templates'] = []

                    #------------------------------------------------------
                    # Substitute / with ___ in template name
                    #------------------------------------------------------    
                    template = str(template.nodeValue).replace('/', '___')

                    self.__packageInfo[name]['templates'].append(template.replace(self.__PCODE, self.__pcode))

            except QueryException:
                pass


    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   May 21, 2003
    # Name:   determineVariableData
    #
    # This function will parse through the xml file which holds
    # the variable information, store the approprite name/value pairs
    # in a dictionary
    #------------------------------------------------------
    def determineVariableData(self):

        self.__log.add("RELEASE: Reading variable data...")                   

        #------------------------------------------------------
        # Parse through the xml file and store the results
        #   self.__location is dictionary of lists holding all of
        # the file information per product.
        # ie: 
        #------------------------------------------------------
        datapath = "/releasevariables/"
        
        for variable in self.__xmlVariables.query(datapath + "*"):
            name = str(variable.getAttribute("name"))

            #------------------------------------------------------
            # First, let's initialize the values for each product
            #------------------------------------------------------
            if not self.__variables.has_key(name):
                self.__variables[name] = {}

            #------------------------------------------------------
            # Get the value
            #------------------------------------------------------
            try :
                value = self.__xmlVariables.query(datapath + 'var[@name="' + name + '"]/location[@name="' + self.__location + '"]/text()')[0].nodeValue

                value = value.replace('##SERVER_IP##', self.__graphicip)
                value = value.replace('##SERVER_ADA_IP##', self.__adaip)
                
                for type in self.__productTypes:
                    self.__variables[name][type] = value

            except QueryException:
                pass


    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   May 30, 2003
    # Name:   determineInstallInstructions
    #
    # This function will parse through the xml file which holds
    # the release data and store the different installation commands
    #------------------------------------------------------
    def determineInstallInstructions(self):

        self.__log.add("RELEASE: Reading installation instructions...")

        #------------------------------------------------------
        # Parse through the xml file and store the results
        #   self.__installInstructions is list holding the different
        # commands
        #------------------------------------------------------
        datapath = "/releasedata/installation/"
        
        for variable in self.__xmlData.query(datapath + "type"):
            name = str(variable.getAttribute("value"))

            #------------------------------------------------------
            # First, let's initialize the values for each product
            #------------------------------------------------------
            if not self.__installInstructions.has_key(name):
                self.__installInstructions[name] = []

            #------------------------------------------------------
            # Get the commands
            #------------------------------------------------------
            commands = self.__xmlData.query(datapath + 'type[@value="' + \
                                           name + '"]/*')

            for command in commands:
                try:
                    value = str(command.getAttribute("value"))
                except QueryException:
                    value = ""

                try:
                    wait = str(command.getAttribute("wait"))
                except QueryException:
                    wait = ""

                try:
                    delay = str(command.getAttribute("delay"))
                except QueryException:
                    delay = ""

                #------------------------------------------------------
                # We need to substitute values...
                #  LOCATION, TYPE
                #------------------------------------------------------
                value = value.replace('##LOCATION##', self.__location)
                value = value.replace('##TYPE##', name)
                value = value.replace('##PCODE##', self.__pcode)

                tmpdictionary = {}
                tmpdictionary['command'] = value

                if wait != "":
                    tmpdictionary['wait'] = wait
                if delay != "":    
                    tmpdictionary['delay'] = delay

                self.__installInstructions[name].append(tmpdictionary)


    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   June 19, 2003
    # Name:   executeLocalCommands
    #
    # This function will parse through the xml file which holds
    # the release data and store the different local installation commands
    #------------------------------------------------------
    def executeLocalCommands(self):

        self.__log.add("RELEASE: Executing local commands...")

        #------------------------------------------------------
        # Parse through the xml file and store the results
        #   self.__installInstructions is list holding the different
        # commands
        #------------------------------------------------------
        datapath = "/releasedata/local/command/text()"
        
        #------------------------------------------------------
        # Get the commands
        #------------------------------------------------------
        commands = self.__xmlData.query(datapath)
        for command in commands:
            
            #------------------------------------------------------
            # We need to substitute values...
            #  IP and MYSQL_PASSWORD
            #------------------------------------------------------
            command = str(command.nodeValue)
            command = command.replace('##IP##', self.__selectedLocation['rad']['ip'])
            command = command.replace('##MYSQL_PASSWORD##',
                                  self.__passwords[self.__selectedLocation['rad']['hostname']]['mysql'])
            command = command.replace('##PCODE##', self.__pcode)

            #------------------------------------------------------
            # Execute the command
            #------------------------------------------------------            
            self.__log.add("RELEASE: Executing " + command)
            os.system(command)


    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   May 21, 2003
    # Name:   templateVariableSubstitution
    #
    # Substitute all variables in the templates
    #------------------------------------------------------
    def templateVariableSubstitution(self):

        #------------------------------------------------------
        # Do the variable substitution for each template
        #------------------------------------------------------
        for type in self.__packageInfo:
            if self.__packageInfo[type].has_key('templates'):
                for template in self.__packageInfo[type]['templates']:

                    dir = os.path.join(self.__templatefiles, type,
                                       self.__pcode)

                    if not os.path.isdir(dir):
                        self.__log.add("RELEASE: No such directory: " + dir +
                                       " Template (" + template +
                                       ") will not be included.",
                                       self.__log.bitMaskWarningScreen())
                                       
                    elif not os.path.isfile(os.path.join(dir, template)):
                        self.__log.add("RELEASE: No such file: " + \
                                       os.path.join(dir, template),
                                       self.__log.bitMaskWarningScreen())

                    else:
                        fd = os.open(os.path.join(dir, template), os.O_RDONLY)
                        if (fd):
                            templateData = os.read(fd, 1000000000)

                            #-----------------------------------------------
                            # Do search and replace on the markers
                            #-----------------------------------------------
                            for variablename in self.__variables.keys():
                                templateData = templateData.replace("##" + variablename + "##", self.__variables[variablename][type])

                            templateData = templateData.replace(self.__PCODE, self.__pcode)
                            templateData = templateData.replace(self.__UPPERPCODE, self.__pcode.upper())                                

                            os.close(fd)    

                            #-----------------------------------------------
                            # Store the new template data
                            #-----------------------------------------------
                            tardirectory = os.path.join(self.__tarfiles,
                                                        self.__date, type)
                            if not os.path.isdir(tardirectory):
                                os.makedirs(tardirectory)

                            fd = open(os.path.join(tardirectory, template),
                                      'w')
                            fd.write(templateData)
                            fd.close()

                        else:
                            self.__log.add("RELEASE: Unable to open file: "\
                                           + os.path.join(dir, template) +
                                           ".  Template not included" +
                                           " in release",
                                           self.__log.bitMaskWarningScreen())

        self.__log.add("RELEASE: Variable substitution is completed.")
                        

    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   May 28, 2003
    # Name:   tarFiles
    #
    # Create a tar command for each product type (ie: rad, go, gosrch)
    #------------------------------------------------------
    def tarFiles(self):

        threads  = []
        numloops = range(len(self.__packageInfo.keys()))

        for key in self.__packageInfo:
            if not os.path.isdir(os.path.join(self.__tarfiles, self.__date,
                                              key)):
                os.makedirs(os.path.join(self.__tarfiles, self.__date, key))

            os.chdir(os.path.join(self.__tarfiles, self.__date, key))        
            
            tarcommand = self.__tarcommand + key + '-' + self.__pcode + '-' +\
                         self.__location + '.tar '
            if self.__packageInfo[key].has_key('files'):
                for file in self.__packageInfo[key]['files']:
                    tarcommand = tarcommand + file + ' '
            if self.__packageInfo[key].has_key('templates'):     
                for template in self.__packageInfo[key]['templates']:
                    tarcommand = tarcommand + template + ' '                

            #------------------------------------------------------
            # Create a new thread to execute the actual tarring
            #------------------------------------------------------
            t = threading.Thread(target=self.processCommand(tarcommand))
            threads.append(t)
            threads[len(threads)-1].start()

            self.__log.add("RELEASE: Tarring file: " + tarcommand)
            tarcommand = ""

        for i in numloops:
            threads[i].join()

        self.__log.add("RELEASE: Tarring is completed")
        

    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   May 28, 2003
    # Name:   processCommand
    #
    # Executes command
    #------------------------------------------------------
    def processCommand(self, command):

        os.system(command)


    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   May 29, 2003
    # Name:   ftpFiles
    #
    # Ftp the tar files to the appropriate machines
    #------------------------------------------------------
    def ftpFiles(self):

        #------------------------------------------------------
        # We now have our tar files, and we want to get them
        # to the appropriate place
        #------------------------------------------------------                
        for key in self.__packageInfo:
            os.chdir(os.path.join(self.__tarfiles, self.__date, key))

            tarfile  = key + '-' + self.__pcode + '-' + self.__location + \
                       '.tar'
            ip       = self.__selectedLocation[key]['ip']

            hostname = self.__selectedLocation[key]['hostname']

            #------------------------------------------------------
            # First we need to validate that the destination directory
            # exists
            #------------------------------------------------------
            telnet = utilities.giTelnet(ip, 'release',
                                        self.__passwords[hostname]['release'])
            returnvalue = telnet.command('ls ' + self.__tarDestination)
            for value in returnvalue:
                if value.find("No such file or directory") != -1:
                    returnedvalue = telnet.command("mkdir -p " + \
                                                   self.__tarDestination)
                    break

            telnet.close()    

            #------------------------------------------------------
            # Get the ip address of the box we are going to and open
            # an ftp connection
            #------------------------------------------------------
            self.__log.add("Release: Ftping " + tarfile + " to " + ip)
            ftp = utilities.giFtp(ip, 'release',
                                  self.__passwords[hostname]['release'])
            ftp.cd(self.__tarDestination)
            ftp.binary_put(tarfile)
            ftp.close()

        self.__log.add("RELEASE: Ftping is completed")
        

    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   May 30, 2003
    # Name:   releasePackage
    #
    # Telnet to the machines and install/unpackage the release
    #------------------------------------------------------
    def releasePackage(self):

        #------------------------------------------------------
        # We now have our tar files, and we want to get them
        # to the appropriate place
        #------------------------------------------------------                
        for key in self.__installInstructions:
            tarfile  = key + '-' + self.__pcode + '-' + self.__location + \
                       '.tar'
            ip       = self.__selectedLocation[key]['ip']
            hostname = self.__selectedLocation[key]['hostname']

            #------------------------------------------------------
            # Telnet to the box, and run the install script
            #------------------------------------------------------
            self.__log.add("RELEASE: Installing on " + ip)
            telnet = utilities.giTelnet(ip, 'release',
                                        self.__passwords[hostname]['release'])
            returnvalue = telnet.suroot(self.__passwords[hostname]['root'])

            if returnvalue == '':
                #------------------------------------------------------
                # We succeeded.....so execute the commands
                #------------------------------------------------------
                for entry in self.__installInstructions[key]:
                    self.__log.add("RELEASE: Executing " + entry['command'])
                    if entry.has_key('wait'):
                        print telnet.commandUntil(entry['command'],
                                                  entry['wait'])
                    elif entry.has_key('delay'):
                        print telnet.command(entry['command'],
                                             int(entry['delay']))
                    else:
                        print telnet.command(entry['command'])

            
            telnet.close()
            
        self.__log.add("RELEASE: Releasing is completed")              


    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   June 17, 2003
    # Name:   addRadProduct
    #
    # Creates the variable substitution file for a new rad product
    #------------------------------------------------------
    def addRadProduct(self, port):

        #------------------------------------------------------
        # Read in the generic variable substitution file
        #------------------------------------------------------ 
        fd = os.open(self.__xmlDir + "releasevariables.xml", os.O_RDONLY)
        if (fd):
            data = os.read(fd, 1000000000)        
            os.close(fd)

            #------------------------------------------------------
            # Substitute
            #------------------------------------------------------ 
            data = data.replace('##PCODE##', self.__pcode)
            data = data.replace('##PORT##', port)       
#            data = data.replace('##SERVER_IP##', self.__graphicip)
#            data = data.replace('##SERVER_ADA_IP##', self.__adaip)

            #------------------------------------------------------
            # Write out the new file
            #------------------------------------------------------
            file = open(self.__xmlDir + "releasevariables_" + self.__pcode + \
                        ".xml", 'w')
            file.write(data)
            file.close()

            self.__log.add("RELEASE: Added Variable Substitution file for " +
                           self.__pcode)


    #------------------------------------------------------
    # Author: Lori Hongach
    # Date:   June 17, 2003
    # Name:   removeRadProduct
    #
    # Creates the variable substitution file for a new rad product
    # NOTE: We are not actually currently making use of this function.
    #------------------------------------------------------
    def removeRadPackage(self):

        os.remove(self.__xmlDir + "releasevariables_" + self.__pcode + ".xml")
        self.__log.add("RELEASE: Removed Variable Substitution file for " +
                       self.__pcode)

        

# Create and execute
#passwords = {'linuxstage.grolier.com': {}, 'stage.grolier.com': {},
#             'backstage.grolier.com': {}}
#passwords['linuxstage.grolier.com'] = {'release': '36ptool',
#                                       'root': 'DL*linux3',
#                                       'mysql': 'mysqldba'}
#passwords['backstage.grolier.com'] = {'release': '36ptool',
#                                      'root': 'DB*linux3',
#                                      'mysql': 'mysqldba'}
#passwords['stage.grolier.com'] = {'release': '36ptool', 'root': 'DS*linux3',
#                                  'mysql': 'mysqldba'}

#testRelease =  Release('eas', 'stage', passwords);       
#testRelease.execute()

#testRelease =  Release('eas')
#testRelease.addRadPackage('33')
#testRelease.executeRelease('stage', passwords, '1.1.1.1', '2.2.2.2')    
