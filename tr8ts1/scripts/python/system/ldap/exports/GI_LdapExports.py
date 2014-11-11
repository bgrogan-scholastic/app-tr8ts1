######################################
# Author: Todd A. Reisel
# Date: 08/31/2004
# Class: GI_LdapExports
# Purpose: export ldap information
#	to the various dev/staging
#	and production servers
######################################

import sys;

import utils.GI_XPath;

#import common packages
from system.common.utils.GI_TransformManager import *;

#import ldap export packages
from system.ldap.utils.GI_LdapServersExportList import *;
from GI_DownloadFile import *;
from GI_UploadFile import *;
from GI_LdapUserAccounts import *;
from GI_LdapPosixGroups import *


#import python packages
import getpass;
import ldap;
import time;
import math;
import smtplib;

class GI_LdapExports:
	def __init__(self):

	    #set a flag to see if there were errors
	    self._hasErrors = False;
	    self._errorMessage = 'Please check the log file: /data/techsvs/logs/exports.log on gicauthm.grolier.com (linuxdev), this process had errors....';

	    #open up the ldap config file and get settings
	    self._configFile = utils.GI_XPath.GI_XPath('/data/techsvs/config/ldapexports.xml');
	    
	    #get a list of files to process for each server
	    self._filesToProcess = self._configFile.query('/ldapexports/files_to_process/*');
	    
	    self._limitedServerList = GI_LdapServersExportList().getLimitedServerList();
	    self._completeServerList = GI_LdapServersExportList().getCompleteServerList();
	    
	    self._configAttributes = self._configFile.query('/ldapexports/config');
	    
	    #get the ldap information out of the config file
	    self._ldapUsername = self._configAttributes[0].getAttribute('ldapuser');
	    self._ldapPassword = self._configAttributes[0].getAttribute('ldappassword');
	    self._ldapServer = 'gicauthm.grolier.com';
	    
	    
	    self._ldapurl = "ldap://" + self._ldapServer + "/"
	    self._ldapConnection = ldap.initialize(self._ldapurl)
	    self._ldapConnection.bind_s(self._ldapUsername, self._ldapPassword, ldap.AUTH_SIMPLE);
	    
	    #get a list of unix users
	    myUsers = GI_LdapUserAccounts();
	    
	    #get a list of unix groups
	    myGroups = GI_LdapPosixGroups();
		
	def exportData(self):
		for localityName in self._limitedServerList.keys():
			print "Processing Servers in " + localityName;
			for serverName in self._limitedServerList[localityName].keys():
				serverObject = self._limitedServerList[localityName][serverName];
				server_rootPassword = '';

				#make sure the server has a root password;
				if not serverObject.has_key('rootpassword'):
					#add this message to the email alert!
					print "\t" + serverName + " does not have a password code!";
					print "";
					self._hasErrors = True;
					
				else:
					server_IpAddress = serverObject['ipHostNumber'][0];
					server_commitData = False;
					server_rootPassword = serverObject['rootpassword'][0];

					if serverObject.has_key('exportLdapCommitData'):
					    if serverObject['exportLdapCommitData'][0] == 'Y':
						server_commitData = True;

					print "\tExporting to: " + serverObject['cn'][0];
					
					#download the set of files from this server
					myDownloadManager = GI_DownloadFile(server_IpAddress, 'root', server_rootPassword);

					downloadResult = False;

					for x in self._filesToProcess:
						file_downloadInfo = self._configFile.query('/ldapexports/files_to_process/file[@name="' + x.getAttribute('name') +'"]/download');
						file_uploadInfo = self._configFile.query('/ldapexports/files_to_process/file[@name="' + x.getAttribute('name') +'"]/upload');

						download_srcDir = file_downloadInfo[0].getAttribute('srcdir');
						download_srcName = file_downloadInfo[0].getAttribute('srcname');
						download_destDir = file_downloadInfo[0].getAttribute('destdir');
						download_destName = file_downloadInfo[0].getAttribute('destname');
						download_destName = download_destName.replace("##SERVERNAME##", serverName);

						upload_srcDir = file_uploadInfo[0].getAttribute('srcdir');
						upload_srcName = file_uploadInfo[0].getAttribute('srcname');
						upload_srcName = upload_srcName.replace("##SERVERNAME##", serverName);
						upload_destDir = file_uploadInfo[0].getAttribute('destdir');
						upload_destName = file_uploadInfo[0].getAttribute('destname');


						
						downloadResult = myDownloadManager.getFile(download_srcDir, download_srcName, download_destDir, download_destName);
						if downloadResult == False:
						    #halt processing on this server
						    #print the errors from this object
						    print "\t\tFailed to download: " + os.path.join(download_srcDir, download_srcName);

						    print myDownloadManager.getErrors();
						    self._hasErrors = True;

						    break;
						else:
						    print "\t\tSuccessfully downloaded: " + os.path.join(download_srcDir, download_srcName);

						#get a list of transformations
						file_transformations = self._configFile.query('/ldapexports/files_to_process/file[@name="' + x.getAttribute('name') +'"]/transformations/*');

						fd = open(os.path.join(download_destDir, download_destName), 'r');
						fileContents = fd.read();
						fd.close();

						params = {};
						params['locality'] = localityName;
						params['hostname'] = serverName;
						params['limitedserversinfo'] = self._limitedServerList;
						params['completeserversinfo'] = self._completeServerList;

						myTM = GI_TransformManager(fileContents, params);

						for x in file_transformations:
						    myTM.addTransformation ( x.getAttribute('module') );

						myTM.processTransformations();

						#make sure the upload directory is present, if not, create it.
						if not os.path.exists( upload_srcDir ):
							os.mkdir( upload_srcDir );

						#write out the upload file after its transformations have taken place
						fd = open( os.path.join(upload_srcDir, upload_srcName) , 'w');
						fd.write( myTM.getProcessedContent() );
						fd.close();

					if downloadResult == True:
					    #process the files for uploading
					    
					    uploadResult = True;

					    print "\t\t---------------------";

					    myUploadManager = GI_UploadFile(server_IpAddress, 'root', server_rootPassword);

					    for x in self._filesToProcess:
						file_uploadInfo = self._configFile.query('/ldapexports/files_to_process/file[@name="' + x.getAttribute('name') +'"]/upload');

						upload_srcDir = file_uploadInfo[0].getAttribute('srcdir');
						upload_srcName = file_uploadInfo[0].getAttribute('srcname');
						upload_srcName = upload_srcName.replace("##SERVERNAME##", serverName);
						upload_destDir = file_uploadInfo[0].getAttribute('destdir');
						upload_destName = file_uploadInfo[0].getAttribute('destname');
						upload_autoCommit = file_uploadInfo[0].getAttribute('autocommit');

						uploadResult = myUploadManager.putFile(upload_srcDir, upload_srcName, upload_destDir, upload_destName, upload_autoCommit);
						if uploadResult == False:
						    print "\t\tFailed to upload: " + os.path.join(upload_destDir, upload_destName);
						    print myUploadManager.getErrors();
						    self._hasErrors = True;
						    break;
						else:
						    print "\t\tSuccessfully uploaded: " + os.path.join(upload_destDir, upload_destName);

					    if uploadResult == True:
						print "";
						print "\t\tSuccessfully uploaded all necessary files...";

						if server_commitData == False:
						    print "\t\t\tNot commiting the changes, flag in ldap says not to for this server!";
						else:
						    commitResult = myUploadManager.commit();
						    if commitResult == True:
							print "\t\t\tCommited all files to the remote server";
						    else:
							print "\t\t\tErrors during commit!";
							print myUploadManager.getErrors();
							self._hasErrors = True;


					print "";
		if self._hasErrors == True:
		    #did errors occur in the export, if so email them.
		    self.emailErrors();

	def emailErrors(self):
	    #get the configuration information in the xml file
	    emailSettings = self._configFile.query('/ldapexports/email');

	    emailserver =  emailSettings[0].getAttribute('server');
	    emailfrom = emailSettings[0].getAttribute('from');
	    emailto = emailSettings[0].getAttribute('to');
	    emailsubject = emailSettings[0].getAttribute('subject');
	    
	    #emailserver = '198.181.165.28';
	    #emailfrom = 'treisel@scholasticlibrary.com';
	    #emailto = 'treisel@scholasticlibrary.com';
	    #emailsubject = 'LDAP Exports on Stress1 failed!';
	    
	    msg = '';
	    msg += "Subject: " + emailsubject + "\r\n"
	    msg += "From: " + emailfrom + "\r\n"
	    msg += "To: " + emailto + "\r\n"
	    msg += self._errorMessage + "\n\n"
	    
	    #try and send an email message to everyone about the errors
	    try:
		s = smtplib.SMTP();
		s.connect(emailserver);
		s.sendmail(emailfrom, emailto, msg);
		s.close();
		
	    except smtplib.SMTPException, errordata:
		print str(errordata)+" E-mail error in customer e-mail.\n";
		
	    except Exception, errordata:
		print str(errordata)+" E-mail error in customer e-mail.\n";
				
if __name__ == '__main__':

    myExporter = GI_LdapExports();
    myExporter.exportData();

