#!/usr/bin/python2.2
from os import path
import string
import sys
import smtplib

#sys.argv[1] should be the from
#sys.argv[2] should be the comma-seperated to list (no spaces)
#sys.argv[3] should be the subject in quotes
#sys.argv[4] should be the message in quotes


fromaddr = sys.argv[1];
toaddrs  = sys.argv[2];
subject = sys.argv[3];
message = sys.argv[4];


#the to list should look something like this:
#['x@y.com', 'x@y.net']
toaddrs = toaddrs.strip();
toaddrs = toaddrs.replace(" ", "");
toaddrs  = toaddrs.split(",")


# Add the From: and To: headers at the start!
msg = ("From: %s\r\nTo: %s\r\nSubject: %s\r\n\r\n" % (fromaddr, toaddrs, subject))
msg = msg + message;
print "Message length is " + `len(msg)`
print msg;

server = smtplib.SMTP('tc982.grolier.com')
server.set_debuglevel(1)
try:
    status = 0;
    server.sendmail(fromaddr, toaddrs, msg)
except smtplib.SMTPRecipientsRefused:
    print "No one got the email";
    status = -1;
except smtplib.SMTPHeloError:
    print "Server didn't reply to the HELO greeting";
    status = -2;    
except smtplib.SMTPSenderRefused:
    print "Server Didn't accept 'from' header";
    status = -3;
except smtplib.SMTPDataError:
    print "Unexpected error code (other than a refusal of a recipient)";
    status = -4;
except Exception:
    print "Something bad happened, I have no idea what it is.";
    status = -5;

server.quit()
sys.exit(status);
