#!/usr/bin/python

# get some CGI stuff out of the way right now
print "Content-type: text/html\n"

"""This program runs the entire show for the update portion of the
update process. It gets the parameters passed by process.php and
executes the necessary stuff to rsync directories on the live machines.
"""

import sys
import os
import cgi
import cgitb; cgitb.enable()

import anobind
from Ft.Xml import InputSource

sys.path.append("/data/loadtools/scripts/python/common/utils")
import GI_SSH

# set up the fieldstorage of parameters
FieldStorage = cgi.FieldStorage()


class Data(object):
  """This class contains the initialized data to run the show"""
  
  def __init__(self):
    # get the parameters passed from process.php
    self.__params = {}

    if FieldStorage.has_key("username"):
      self.__params["username"] = FieldStorage["username"].value
    else:
      self.__params["username"] = ""

    if FieldStorage.has_key("password"):
      self.__params["password"] = FieldStorage["password"].value
    else:
      self.__params["password"] = ""

    if FieldStorage.has_key("product"):
      self.__params["product"] = FieldStorage["product"].value
    else:
      self.__params["product"] = ""

    if FieldStorage.has_key("location"):
      self.__params["location"] = FieldStorage["location"].value
    else:
      self.__params["location"] = ""

    if FieldStorage.has_key("feature"):
      self.__params["feature"] = FieldStorage["feature"].value
    else:
      self.__params["feature"] = ""

    if FieldStorage.has_key("backend"):
      self.__params["backend"] = FieldStorage["backend"].value

    # get the xml structure in place
    srcFactory = InputSource.DefaultFactory
    try:
      src = srcFactory.fromStream(open("/data/loadtools/config/update_process/" + self.__params["product"] + ".xml"), "urn:bogus")
    except:
      logMessage("<h2>Failed to open configuration file %s.xml</h2>" % self.__params["product"])

    # build the xml object from the xml configuration file
    self.__xml = anobind.binder().read_xml(src)

    # get the relevant xml data in place in the params
    self.__xml

    # iterate through the servers
    for server in self.__xml.update.servers.server:

        # did we match up the location we are looking for
        if server.location == self.__params["location"]:
            self.__params["server"] = server.name.text_content()

            # is the location a load balanced server?
            self.__params["loadbalanced"] = "no"
            if server.system.loadbalanced == "yes":
                self.__params["loadbalanced"] = "yes"
                
                # iterate through the backend server list
                for backend in server.system.backend:

                    # did we match the backend server?
                    if backend.name == self.__params["backend"]:
                        self.__params["ssh"] = backend.ssh.text_content()
                        self.__params["rsync"] = backend.rsync.text_content()
                    else:
                        logMessage("No matching backend server found")

            # break out of initial loop
            break;

    # get the feature paths
    for feature in self.__xml.update.features.feature:

        # did we find the matching feature?
        if feature.name == self.__params["feature"]:

            paths = []
            for path in feature.path:
                paths.append(path.text_content())

            self.__params["paths"] = paths
            break

  # define the params property
  def __getParams(self): return self.__params
  def __setParams(self, value): raise "Can't set attribute params"
  params = property(__getParams, __setParams)


  # define the xml property
  def __getXML(self): return self.__xml
  def __setXML(self, value): raise "Can't set attribute xml"
  xml = property(__getXML, __setXML)


def rsyncDirectories(params):
    """This function just calls the singular version multiple times based
on the contents of the params field 'paths'"""

    # build local params dictionary
    p = {}
    p["username"] = params["username"]
    p["password"] = params["password"]
    p["server"] = params["server"]
    p["loadbalanced"] = params["loadbalanced"]

    # is this a load balanced system?
    if p["loadbalanced"] == "yes":
        p["ssh"] = params["ssh"]
        p["rsync"] = params["rsync"]

    # iterate over the path list
    for path in params["paths"]:
        p["srcDir"] = path
        p["dstDir"] = path
        rsyncDirectory(p)
        


def rsyncDirectory(params):
    """This function will synchronize two directories using and "rsync -av -e ssh" 
command to do the heavy lifting. This command is run via an pexpect child object.
The source and destination directory don't have to have the same relative structure
"""
    # get the pexpect module only when this function is called
    import pexpect

    # try and execute the command
    try:
        logMessage("Begin Transfer")
        
        # are we doing a transfer to a backend server?
        if params.has_key("loadbalanced") == True and params["loadbalanced"] == "yes":
          cmd = pexpect.spawn("rsync -vzr -e 'ssh -p %(ssh)s' --port=%(rsync)s %(srcDir)s/ %(username)s@%(server)s:%(dstDir)s" % params)
          
        # otherwise, nope, just a regular server
        else:
          cmd = pexpect.spawn("rsync -vzr -e ssh %(srcDir)s/ %(username)s@%(server)s:%(dstDir)s" % params)

        print cmd
        #return
        index = cmd.expect(["authenticity", "[Pp]assword: ", "unknown host"], timeout=60)

        pattern = "] \#|] \$|]\#|]\$"

        # did it respond with 'authenticity'?
        if index == 0:
            print "<br>Authenticating the user"
            cmd.sendline("yes")
            cmd.expect("[Pp]assword:")
            cmd.sendline(params["password"])
            while cmd.expect("\n") == 0:
              logMessage(cmd.before + "\n")

        # otherwise, looking for password
        elif index == 1:
            cmd.sendline(params["password"])
            while cmd.expect("\n") == 0:
              logMessage(cmd.before + "\n")

        # otherwise, problem with ssh connection for this user
        elif index == 2:
            logMessage("<br>Contact the system administrator, problem with your user account<br>")

    except pexpect.EOF, message:
        logMessage(cmd.before)
        logMessage("Files transferred<br><br>")

    except pexpect.TIMEOUT, message:
        logMessage("<br><h2>TIMEOUT Error message : %s</h2><br>" % str(message))


def logMessage(msg):
    """Prints a useful HTML log message"""
    print msg.replace("\n", "<br>\n")
    sys.stdout.flush()


    
def isLoadBalanced(data):
    """Determine if the location is loadbalanced or not"""
    if data.params["loadbalanced"] == "yes":
        return True
    else:
        return False


def setBackendServerState(active, data):
    """This function turns a backend server "on" or "off" as far as the
load balancer is concerned"""
    pass


def update(data):
  """This function actually runs the file transfer process"""

  # is server a backend server?
  if isLoadBalanced(data):
      setBackendServerState(False, data)

  # rsync the directories defined
  rsyncDirectories(data.params)

  # is server a backend server?
  if isLoadBalanced(data):
      setBackendServerState(True, data)

def toggle(data):
	pass


def status(data):
	print "<br>Status of backend servers<br>"
	#ssh = GI_SSH.SSH(data.params["username"], data.params["password"], data.params["server"])
	ssh = GI_SSH.SSH("root", "DC*mintyfresh", "10.60.25.131")
	rsp = ssh.command("export TERM=xterm; ipvsadm -l -n -t 10.60.25.131:80")
	rsp = rsp.replace("\n", "<br>\n")
	rsp = rsp.replace(" ", "&nbsp;")
	print rsp
	ssh.close()
	


def main():
  # beginning of the page
  startHTML = """
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

  <html>
    <head>
      <title>log</title>
      <link rel="stylesheet" type="text/css" href="/css/update_process.css">
    </head>

    <body class="monospace">
      Log of update activity
      <hr>
  """

  # end of the page
  endHTML = """</body>
  </html>
  """

  # start of page
  print startHTML

  # process page
  try:
		# initialize the data structure
    data = Data()

    # have we been told by the process section to run?
    if FieldStorage.has_key("process") and FieldStorage["process"].value == "update":
      # run the update process
      logMessage("Begin file Transfer<br>")

      # update selected site
      update(data)

    # toggle the state of the selected backend server and do a status update
    elif FieldStorage.has_key("process") and FieldStorage["process"].value == "toggle_backend":
      print "<br>toggling backend<br>"

    # print the status of the backend servers
    elif FieldStorage.has_key("process") and FieldStorage["process"].value == "status":
      print "<br>Status of backend servers<br>"

  finally:
    # end of page
    print endHTML
  


# start of actual program
if __name__ == "__main__":
  main()
