#!/usr/bin/python
"""distribute - utility to distribute assets for the content server

This utility program distributes delivered assets (pictures, sounds, etc.)
to the new hash algoritm path for the Content Server. Optionally, it will
update the Content Server database with entries for those assets.

This program expects two parameters:
1 - the product authentication name (ie: gme, nec, etc.)
2 - the source directory from which to copy files to the Content Server

Format:

distribute.py [options]

Options available:

-n, --name      productname    this is the authentication product name

-s, --src       directory      this is the source directory

-d --database   yes/no         should these files be entered as asset into the database or not? Default is yes

-h, --help                     prints this help message

Example usage:

./distribute.py -d yes -n nec -s /home/nec/delivery/timelines

The above command line will copy all the asset files from /home/nec/delivery/timelines
to the corrent Content Server directory. It will also create/update an
entry in the Content Server database to track this asset file as well as
create/update entries in the assets table database.
"""

__version__ = 1.01

"""
revision history:
6-17-2005  dkf changed the _copyFile() method of my class to use the
copy() method of shutil rather than copyfile(). Trying to avoid timestamp
problem where a file doesn't get distributed.
"""

import sys
import os
import pwd
import time

def main():
    """main() -> None

    This is the main entry point for the program and is called as a CGI
    """
    
    # see if the environment is okay to run
    environTest()

    # check the command line parameters
    params = Parameters()

    # create a Content Server object
    cs = ContentServer(params)

    # iterate over the files in the source directory and enter them into the Content Server
    for filename in os.listdir(params.directory):

        # is the file not a directory?
        if not os.path.isdir(filename):

            # insert the file into the content server
            cs.insert(filename)



class Asset(object):
    """Asset(object)
    
    This class provides a handy place to store and deal with asset information:
    
    assetid        assetid of the asset
    path           path to the asset file
    filename       filename of the asset file
    fext           file extension of the asset file
    """
    def __init__(self, path, filename):
        basename, fext = os.path.splitext(filename)
        self._filename = filename
        self._path = path
        self._assetid = basename
        self._fext = fext[1:]

    def _getFilename(self): return self._filename
    def _setFilename(self, value): raise AttributeError, "Can't set the filename attribute"
    filename = property(_getFilename, _setFilename)

    def _getAssetid(self): return self._assetid
    def _setAssetid(self, value): raise AttributeError, "Can't set the assetid attribute"
    assetid = property(_getAssetid, _setAssetid)

    def _getPath(self): return self._path
    def _setPath(self, value): raise AttributeError, "Can't set the path attribute"
    path = property(_getAssetid, _setAssetid)

    def _getFilepath(self): return "%s/%s" % (self._path, self._filename)
    def _setFilepath(self, value): raise AttributeError, "Can't set the filepath attribute"
    filepath = property(_getFilepath, _setFilepath)

    def _getFext(self): return self._fext
    def _setFext(self, value): raise AttributeError, "Can't set the fext attribute"
    fext = property(_getFext, _setFext)
      


class ContentServer(object):
    """ContentServer(object)
    
    This class provides the interface to the Content Server itself.
    The code in this class is dependant on the Content Server running
    on this machine as localhost. The primary responsibilities of this class
    are to copy a file to a destination and update/create asset records
    in the Content Server database
    """
    def __init__(self, params):
        """__init__(self, params) -> None

        Class constructor method, initializes information about the Content Server
        """

        # get the hashing algorithm
        from utils.GI_Hash import GI_Hash

        # save the class parameters
        self._productname = params.productname
        self._database    = params.database
        self._directory   = params.directory

        # create the hash object
        self._hash = GI_Hash('/data/cs/docs/%s/assets' % self._productname)

        # create an instance of the database connection
        import MySQLdb
        self._db = MySQLdb.connect(host   = 'localhost', \
                                   user   = 'cs', \
                                   passwd = 'cs', \
                                   db     = 'cs')

        # get a cursor into the database
        self._cursor = self._db.cursor()

        # setup the field lookup dictionary
        self._fields = {}
        

    def insert(self, filename):
        """insert(self, filename) -> None
        
        This method does two things; it copies the file intact from the
        source directory to the destination directory. And it makes/updates an entry
        in the database table 'assets' of the content server.
        """
        status = ""

        # create an asset object from the filename
        asset = Asset(self._directory, filename)
        
        # copy the file to the content server
        status = self._copyFile(asset)

        # are we updating the database?
        if self._database:
            # update/create an entry in the content server's database
            status1 = self._updateDB(asset)

            # if any database message?
            if status1 != "" and status != "":
                status += ", " + status1
            else:
                status += status1

        # is there any status text to print?
        if status != "":
            print status

        
    def __del__(self):
        self._db.close()


    def _copyFile(self, asset):
        """_copyFile(self, asset) -> status message of operation

        This method copies the file from one directory to another.
        It also creates the necessary directory path for the file to be copied to.
        """
        # get the file copying utilities
        import shutil
        import filecmp

        retval = ""

        # get destination filepath
        dstFilepath = self._hash(asset.filename)

        # does the file exist?
        if os.path.exists(dstFilepath):

            # build the source filepath
            filepath = asset.filepath
            
            # are the files different?
            if not filecmp.cmp(filepath, dstFilepath):

                # get the destination directory info
                dstPath = os.path.split(dstFilepath)[0]

                # does the destination directory exist?
                if not os.path.exists(dstPath):
                    os.makedirs(dstPath)
                    #os.makedirs(dstPath, mode=0775)

                # try and remove and then copy the file
                try:
                    # does the file exist?
                    print "dstFilepath = " + dstFilepath
                    if os.path.isfile(dstFilepath):
                        # remove the file
                        os.remove(dstFilepath)
                        
                    # copy the file from source to destination
                    shutil.copy(filepath, dstFilepath)
                except (OSError, IOError), msg:
                    print "* ERROR * file copy %s failed" % filepath
                    print "Error message : %s" % msg
                    sys.exit(-1)

                # ensure mode of file okay
                #os.chmod(dstFilepath, 0775)

                # print status
                retval = "assetid %s (filename = %s) copied to %s" % (asset.assetid, asset.filename, dstPath)

        # otherwise, file doesn't exist so copy it
        else:
            # get the destination directory info
            dstPath = os.path.split(dstFilepath)[0]

            # does the destination directory exist?
            if not os.path.exists(dstPath):
                os.makedirs(dstPath)

            # copy the file from source to destination
            shutil.copy2(asset.filepath, dstFilepath)

            # print status
            retval = "assetid %s (filename = %s) copied to %s" % (asset.assetid, asset.filename, dstPath)

        # return results
        return retval


    def _updateDB(self, asset):
        """_updateDB(self, asset) -> status message of operation

        This method updates the database based on the passed in filename. It
        tries to determine if a record exists, if so it will update it. If not, it will
        create it.
        """
        retval = ""
        
        # create sql statement
        sql = "SELECT * FROM assets WHERE productid='%s' AND assetid='%s'" % (self._productname, asset.assetid)

        # try and do some database work
        try:
            
            # did we get any records back from the query?
            if self._cursor.execute(sql) >= 1:

                # get the one assetid record
                data = self._cursor.fetchone()

                # get the modification date
                database_mdate = data[self.fields['mdate']]

                # get the modification date of the asset file
                filename_mdate = os.path.getmtime("%s/%s" % (self._directory, asset.filename))

                # is the file newer than the database record?
                if time.gmtime(filename_mdate) > time.gmtime(database_mdate.gmticks()):

                    # update the database record
                    timestamp = time.strftime("%Y-%m-%d %H:%M:%S", time.gmtime(os.path.getmtime("%s/%s" % (self._directory, asset.filename))))
                    sql =  "UPDATE assets SET mdate='%s' WHERE productid='%s' AND assetid='%s'" % (timestamp, self._productname, asset.assetid)

                    # execute the query
                    self._cursor.execute(sql)

                    # build the status string
                    retval = "database record updated for assetid = %s" % asset.assetid

            # otherwise, nope, so create a record for the asset
            else:

                # create the sql INSERT statement
                sql =  "INSERT INTO assets(productid, "
                sql += "assetid, fext, cdate, mdate, status) "
                sql += "VALUES('%(productid)s', '%(assetid)s', '%(fext)s', "
                sql += "'%(cdate)s', '%(mdate)s', '%(status)s')"

                # build the dictionary of values to insert
                fields = {}
                fields['productid'] = self._productname
                fields['assetid'] = asset.assetid
                fields['fext'] = asset.fext
                timestamp = time.strftime("%Y-%m-%d %H:%M:%S", time.gmtime(os.path.getmtime("%s/%s" % (self._directory, asset.filename))))
                fields['cdate'] = timestamp
                fields['mdate'] = timestamp
                fields['status'] = 'active'
                sql = sql % fields

                # execute the query
                self._cursor.execute(sql)

                # build the status string
                retval = "database record created for assetid = %s" % asset.assetid
                
        # handle the error and exit the program
        except:
            import traceback
            
            traceback.print_exc()
            
            print "\n*** Database Error on assetid = %s ***\n" % assetid
            sys.exit(-1)

        # return the status string
        return retval



    def _getFields(self):
        """_getFields(self) -> dictionary of fields in dataset
        This method builds a fieldname lookup dictionary for a dataset
        """

        # has the field dictionary been initialized?
        if len(self._fields) == 0:

            column = 0

            # loop through the description field building dictionary
            for d in self._cursor.description:
                self._fields[d[0]] = column
                column += 1

        return self._fields
        
    def _setFields(self, value):
        """Raises an AtributeError if called, essently making the property read-only"""
        raise AttributeError, "Can't set the fields attribute"

    fields = property(_getFields, _setFields)


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

        # are we running as root?
	# 
	# changed 8/24/04  no longer needed after LDAP installation - DKF
	#
        #if 'root' != pwd.getpwuid(os.getuid())[0]:
        #    raise "current user is not root"
        
        # does this system have mysql installed?
        try:
            import MySQLdb
        except ImportError:
            raise "the python MySQL module isn't available on this system"

        # were we able to connect to the content server database?
        db = MySQLdb.connect(host = "localhost", user="cs", passwd="cs", db="cs")
        
    except:
        print "Environment error :", sys.exc_info()[0]
        sys.exit()


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

        # get command line arguements
        try:
            opts, args = getopt.getopt(sys.argv[1:], 'd:n:s:h', ['help', 'name=', 'src=', 'database='])
        except getopt.GetoptError:
            help()

        # scan the command line arguments
        for o, a in opts:

            # are we asking for help?
            if o in ["-h", "--help"]:
                help()

            # what is the directory?
            if o in ['-s', '--src']:

                # does the directory exist?
                try:
                    f = open(a)
                    f.close()
                except IOError:
                    print "Directory %s doesn't exist" % a
                    sys.exit()

                self._directory = a

            # what is the productname?
            if o in ['-n', '--name']:
                self._productname = a

            # are we inserting the asset in the database?
            self._database = True
            if o in ['-d', '--database']:

                # did we get a yes or a no?
                a = a.lower()
                if a in ['yes', 'no']:
                    if a == 'yes':
                        self._database = True
                    else:
                        self._database = False
            

        # did we get enough parameters?
        try:
            t = self._directory
            t = self._productname
        except:
            print "Parameter Error : missing a required command line parameter\n"
            help()

    # set up some properties to get the parameter attributes
    def _getDirectory(self): return self._directory
    def _setDirectory(self, directory): raise AttributeError, "Can't set the directory attribute"
    directory = property(_getDirectory, _setDirectory)

    def _getProductName(self): return self._productname
    def _setProductName(self, productname): raise AttributeError, "Can't set the productname attribute"
    productname = property(_getProductName, _setProductName)
    
    def _getDatabase(self): return self._database
    def _setDatabase(self, productname): raise AttributeError, "Can't set the database attribute"
    database = property(_getDatabase, _setDatabase)
    
        
def help():
    """help() -> exits program after it's called

    Print out the docstring of the module as help to the user
    """
    print __doc__
    sys.exit()


if __name__ == "__main__":
    main()
