import utils.listfiles;
import os;
import os.path;
import utils.GI_XPath;
import utils.giFtp;
import socket;
import sys;
import exceptions;
import smtplib;

class GI_FindStaticWebLinks:
	def __init__(self, product = 'all'):
	
		self._originalWorkingDirectory = os.getcwd();
		
		#what products should we produce reports for
		self._product = product;

		# what characters should break a sentence.
		self._breakCharacters = [' ', '<', '>', ',', '!', ')', '(', '"', "\n", ']', ';'];

		self._configXml = utils.GI_XPath.GI_XPath('staticWebLinks.xml');

		#get all the products
		self.products = self._configXml.query('/links/products/*');

		#get all the configurations for saving
		self._savingLocations = self._configXml.query('/links/config/savelocations/*');

		self._urls = [];
		
		for x in self.products:
		
			#get the name of the product
			productName = x.getAttribute('name');			

			print "";
			print "Processing " + productName;
			
			#get the features for a product
			features = self._configXml.query('/links/products/product[@name="' + productName + '"]/features/*');

			#loop through all a product's features
			for y in features:
				featureName = y.getAttribute('name');
				print "\t" + featureName;

				#get the directories for a feature
				directories = self._configXml.query('/links/products/product[@name="' + productName + '"]/features/feature[@name="' + featureName + '"]/directories/*');

				for z in directories:
					#what directory will this be looking at, and by what file pattern (*.html)
					directoryLocation = z.getAttribute('location');
					filePattern = z.getAttribute('pattern');
					
					# make sure the directory exists
					if(os.path.exists(directoryLocation) == -1):
						self.emailError("This process was looking for the directory: " + directoryLocation + " and it does not exist");									
					try:
						#make sure this process can get into the directories
						os.chdir(directoryLocation);

						print "\t\tDirectory: " + directoryLocation + "\t\tFile Pattern: " + filePattern;

						self.files = utils.listfiles.listFiles(directoryLocation, filePattern);
	
						#loop through each file found in the directory that matches the specified pattern
						for a in self.files:
							#open the file and get its contents
							fp = open(a, 'r');
							contents = fp.read(1000000);
				
							#expect to find http:// or https://
							startPos = contents.find('http://');
							
							if startPos == -1:
								#make sure to look for https if http can't be found
								startPos = contents.find('https://');
												
							while startPos != -1:
								#all of the break characters will be found after an http:// or https://
								endPoses = [];
								
								# look for all the break characters
								for b in self._breakCharacters:
									ep = contents.find(b, startPos);
									if ep != -1:
										endPoses.append(ep);
								#since scripting can't visually determine where the http:// or https:// line ends
								#	sort the positions of the break characters found and use the closest
								# 	break character found as the end point							
								endPoses.sort();
				
								endPos = endPoses[0];
				
								url = contents[startPos:endPos];
				
								if url != 'http://' and url.find('grolier.com') == -1:
									
									if url[len(url)-1] == '.':
										self._urls.append( productName + "\t" + featureName + "\t" + a + "\t" + url );
										#make sure the ending character is not a ., probably indicates the ending of a sentence.
									else:
										self._urls.append( productName + "\t" + featureName + "\t" + a + "\t" + url );
					
								startPos = contents.find('http://', endPos + 1);

								if startPos == -1:
									#make sure to look for https if http can't be found
									startPos = contents.find('https://', endPos + 1);
													
							fp.close();

					except OSError, message:
						self.emailError(str(message));
				print "";

		#save the results to the necessary locations
		self.saveResults();
		
	def emailError(self, errorMessage):
		#get the configuration information in the xml file
		emailSettings = self._configXml.query('/links/config/email');
		
		emailserver =  emailSettings[0].getAttribute('server');
		emailfrom = emailSettings[0].getAttribute('from');
		emailto = emailSettings[0].getAttribute('to');
		emailsubject = emailSettings[0].getAttribute('subject');
				
		msg = '';
		msg += "Subject: " + emailsubject + "\r\n"
		msg += "From: " + emailfrom + "\r\n"
		msg += "To: " + emailto + "\r\n"
		msg += errorMessage + "\n\n"
		
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

	def saveResults(self):
		print "Saving results";

		contents = '';
		for x in self._urls:
			contents += x + "\n";

		#save it to the various locations on disk, valid methods are: file and ftp.
		for x in self._savingLocations:
			method = x.getAttribute('method');
			
			if method == 'file':
				directory = x.getAttribute('directory');
				filename = x.getAttribute('filename');

				self._saveResults_File(os.path.join(directory, filename), contents);
			elif method == 'ftp':
				servername = x.getAttribute('server');
				username = x.getAttribute('username');
				password = x.getAttribute('password');
				path = x.getAttribute('directory');
				filename = x.getAttribute('filename');

				self._saveResults_Ftp(servername, username, password, contents, path, filename);

	def _saveResults_File(self, filepath, contents):
		#save the results file to disk

		print "Saving File to Disk: " + filepath;

		try:
			fp = open(filepath, 'w');
			fp.write(contents);
			fp.close();

		except IOError, message:
			self.emailError(str(message));

		except OSError, message:
			self.emailError(str(message));

	def _saveResults_Ftp(self, servername, username, password, contents, path, filename):
		try:
			#switch back to the original working directory, so that the local file to be ftped
			#	is saved in the right spot.
			os.chdir(self._originalWorkingDirectory);
						
			fullpath = os.path.join(path, filename);
			print "Ftping file: /tmp/" + filename + " to server: " + servername + " with username: " + username + " and password: " + password + " with filepath: " + fullpath;
			
			#save the file locally first
			fp = open(os.path.join("/tmp", filename), 'w');
			fp.write(contents);
			fp.close();
	
			myFtp = utils.giFtp.giFtp(servername, username, password);
			myFtp.binary_put(os.path.join("/tmp", filename), fullpath);

			os.system("rm " + os.path.join("/tmp", filename));

		except socket.gaierror, message:
			self.emailError('Could not ftp results file: ' + fullpath + ', to server: ' + servername + ' with username: ' + username + ' with password: ' + password + ' ' +  str(message));
		
		except TypeError, message:
			self.emailError('Could not ftp results file: ' + fullpath + ', to server: ' + servername + ' with username: ' + username + ' with password: ' + password + ' ' +  str(message));

		except IOError, message:
			self.emailError('Could not save file on remote ftp server: ' + fullpath + ' on ftp server: ' + servername + ' with username: ' + username + ' with password: ' + password + ' ' +  str(message));

if __name__ == '__main__':
	a = GI_FindStaticWebLinks();
