#!/usr/bin/python

import os
import sys
import popen2
import string
import socket
import fcntl
import select

class Log(object):
    def __init__(self):
        try:
            self._logfile = open('logs/post_site.log', 'w')
        except IOError:
            self._logfile = None
            self.msg("Log file wasn't opened\n\n")

    def msg(self, msg):
        """This outputs the message to the screen and the log file, if possible"""

        print msg,

        if self._logfile != None:
            self._logfile.write(msg)

    def __del__(self):
        if self._logfile != None:
            self._logfile.close()



def shellCommand(command, log):
    """The Command class runs shell commands and retrieves the output of the command
which can be used by the program"""
    
    # did we get something for command?
    if command == "":
        raise RuntimeError, "No shell command specified"

    # run the command and get the 'pipes' back
    process = popen2.Popen3(command, 1)
    process.tochild.close()
    stdout = process.fromchild
    stderr = process.childerr
    stdoutfd = stdout
    stderrfd = stderr
    makeNonBlocking(stdout.fileno())
    makeNonBlocking(stderr.fileno())
    stdouteof = stderreof = 0

    # get output of command
    while 1:
        # wait for output from command
        ready = select.select([stdoutfd, stderrfd], [], [])

        # is stdout ready with output?
        if stdoutfd in ready[0]:
            data = stdout.read()
            log.msg(data)
            if data == '':
                stdouteof = 1

        # is stderr ready with output
        if stderrfd in ready[0]:
            data = stderr.read()
            log.msg(data)
            if data == '':
                stderreof = 1

        # are both processes empty?
        if stdouteof and stderreof:
            break

    # wait for process to end
    return process.wait()
        

def makeNonBlocking(fd):
    fl = fcntl.fcntl(fd, fcntl.F_GETFL)
    try:
        fcntl.fcntl(fd, fcntl.F_SETFL, fl | os.O_NDELAY)
    except AttributeError:
        fcntl.fcntl(fd, fcntl.F_SETFL, fl | os.FNDELAY)

    
# timepstamp generator
def timestamp():
    import time
    timestamp = time.strftime("Date : %x     Time : %X\n")
    log.msg("Log created - " + timestamp)

# identify root user
def identify(greet):
    if os.getlogin() != "root":
        print "Must be 'root' user to run this program\n"
        sys.exit(1)
    else:
        print greet


# create a global logging instance
log = Log()

# timestamp the log
timestamp()

greet = """This program runs the rsync command which will synchronize
two remote directories; source to destination. This makes the destination
directory match the source directory exactly.\n\n"""

# identify the user and bail if necessary
#identify(greet)
print greet
    
# prompt user to continue
rsp = string.lower(raw_input("Do you wish to post the American Presidency product to the staging server? : "))

if rsp not in ("yes", "y"):
    print "Bye for now"
    sys.exit(1)

# get the source server
srcServer = socket.gethostname() + ".grolier.com"

dstServer = "linuxstage.grolier.com"

# about to post the files to the destination server
log.msg("Posting American Presidency to destination server : %s\n" % dstServer)

print "\nPlease enter the root password for %s\n" % dstServer

err = shellCommand("rsync -azv -e ssh --delete /data/ap/ %s:/data/aptest" % dstServer, log)

# did the process exit successfully?
if err == 0:
    log.msg("\n\nProcess ended successfully\n")
else:
    log.msg("\n\nProcess ended with error number : %s\n" % err)

log.msg("\nDone with process\n")


