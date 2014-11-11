#!/usr/bin/python
import os
import sys
import ConfigParser
#import GI_Listfiles
from common.utils.GI_Listfiles import *

# Initialize a couple of global place holders for data
error_noiniinfo = []
error_nosrcfile = []
errorids = []
media_assets = {}
file_dict = {}

# holder for the various status statments to be printed
status_msg1 = 0
status_msg2 = 0


# added 4-18-05, mergeFiles function to read a bunch of files and merge them together
def mergeFiles():
    """this function reads all the .tab files in the delivery directory and merges them
    into one file.  This output file is the one file that the media grabber will use to
    populate it's dictionary
    """
    #first nuke the file
    os.system("rm media.txt");
    
    homedir = "/home/go2/delivery/rdb/go_names/"
    dirlist = os.listdir(homedir);
    #dirlist = ('go2media_assets.tab', 'go2media_bj.tab', 'go2media_pano.tab', 'go2media_pictures.tab', 'go2media_video.tab');
    for file in dirlist:
        try:
            if file[-3:] == "tab":
                os.system("cat "+homedir+file+" >> media.txt");
        except (KeyError, TypeError, IndexError), diag:
            retval = str(diag)
            print retval;
            sys.exit();


# take input array and make a nice dictionary out of it
def makeDict(config):
    """this fucntion recieves input of an ini file and loops through a list of
    its sections to put together a nice dictionary for us

    returns the dictionary
    """
    dict = {}
    for section in config.sections():
        dict[section] = {}
        for option in config.options(section):
            dict[section][option] = config.get(section, option)
    return dict



# read file into global dict media_assets[]
def getData():
    """this method reads our data file /home/go2/delivery/rdb/go_names/go2media_assets.tab
    and populates our public dictionary with something like this :
    {'mediaid.jpg': ['mediaid', 'field1', 'field2', 'field3', 'field4']}
    """

    # open file
    #f = open('/home/cprahm/go2mediaCHUCKtest.tab', 'r')
    f = open('media.txt', 'r')

    # read the file
    for line in f.readlines():

        # account for comments
        if line[0] != "#" and line.find("|") != -1:
            assets = line.split("|")

            # populate dict with key being asset id(first item in list)
	    try:
		media_assets[assets[0]+'.'+assets[4]] = assets
	    except IndexError, e:
		print "** IndexError ** %s, assets = %s" % (e, assets.__str__())
		sys.exit()

    # close file
    f.close()

    #print media_assets

    
# take multiple inputs/dictionaries and binary object on hard disk    
def getPic(media_asset, file, directories):
    """This function goes and retrieves a media asset based on type, id, extension, and product.
    It also sets a couple of global flags based on if the media asset is not found were we expect
    it to be, ie.. gme brainjam pic is not in /data/go2media/gme/news then we set a flag, and
    print an error to screen along with printing this out to our errorlog.  This type of missing
    asset will need to be found/recreated under go2, and of coarse the tab file from FMP will also
    need to be updated to export all new assets as a go2 asset.

    If we find that go2 already contains an asset, we just print that to screen and skip to the next asset.

    else we get the binary asset
    """

    # use combination of media_asset[] values as a key into our directories dictionary from the .ini file
    if directories.has_key(media_asset[5]+" "+media_asset[6]):
        # try to traverse the directory tree recusively to find the media file
        try:
            src_file = os.path.exists(file_dict[file])
            #print ':',src_file,':', file_dict[file]
            ################################
            #
            # altered 5/24/05 CDP
            # forced dest_file flag so that the media grabber does not check for the existing presence
            #  of the binary, it just copies everything all the time now:(
            #
            ################################
            #dest_file = os.path.exists(directories[media_asset[5]+" "+media_asset[6]]['destdir']+"/"+file)
            dest_file = 0
            #print directories[media_asset[5]+" "+media_asset[6]]['destdir']+"/"+file

            # check to see if the media file even exists where we think it should
            if src_file == 0:
                #print "no such source file "+file+ ", please check error log"
                global status_msg1
                status_msg1 = 1
                error_nosrcfile.append("Tab file has the asset id "+file+" but this file doesn't exist on disk to fetch")
                print "Tab file has the asset id "+file+" but this file doesn't exist on disk to fetch";
                return
            
            # it exists where we think it should now check if go2 has it already
            # go2 already has is, skip and go on to the next asset
            elif dest_file == 1:
                print 'we already have a go2 media asset named '+file+' not copying'
                return
            # go2 doesn't have it, go get it
            elif dest_file == 0:
                #src_file = src_file[0]
                print "copying file :" +file_dict[file]+" "+directories[media_asset[5]+" "+media_asset[6]]['destdir']
                try:
                    os.system("cp "+file_dict[file]+" "+directories[media_asset[5]+" "+media_asset[6]]['destdir'])
                except (IOError), diag:
                    retval = str(diag)
                    print retval
                return
                
                
        # no key in .ini file for this asset, excepting a index, type, and key errors, append to errorids the asset id
        except (KeyError, TypeError, IndexError), diag:
            retval = str(diag)
            # append asset id to errorids
            errorids.append('No file '+media_asset[0]+'.'+media_asset[4]+' in directory structure to fetch, if its a new go2 asset it will need to be created and tab file updated for asset :'+file)
            print 'No file '+media_asset[0]+'.'+media_asset[4]+' in directory structure to fetch, new go2 asset will need to be created and tab file updated for asset :'+file;
            return

    # we don't have a key in the directories dict that matches the delivered tab file, print error
    else:
        #print "don't have ini file info for", media_asset[5], media_asset[6], "on assets id ", media_asset[0]
        global status_msg2
        status_msg2 = 1
        print "don't have ini file info for "+media_asset[5]+' '+media_asset[6]+" on assets id "+media_asset[0];
        error_noiniinfo.append("don't have ini file info for "+media_asset[5]+' '+media_asset[6]+" on assets id "+media_asset[0])
        return

        
def recurseMediaTree():
    """This function uses GI_Listfiles to recurse our go2media directory had mounts to build a dictionary
    list of all possible media assets that we coule fetch off disk
    """
    print "Recursing directory for all media assets. . ."
    files = listFiles('/data/go2media/', patterns='*.*', recurse=1, return_folders=0)
    #print files
        
    print "Building dictionary of media assets. . ."
    for filepath in files:	# files is your list of everything
	head, tail = os.path.split(filepath)
	file_dict[tail] = filepath
 
def writeLog():
    """This function simply prints to our log file the lists arrays that getPic dumps our errors
    into.  We do this because there are a couple different types of errors that we catch, and its
    easier to read the log file if each set of errors is grouped together with a little heading on
    each section.
    """
    f = open('logs/go2_media_grabber.log', 'w')
    f.writelines('\t\tBelow are assets that appear to have either the product or feature mismarked in the tab file\n')
    for line in error_noiniinfo:
        f.writelines(line+'\n')
    
    f.writelines('\t\tassets in tab file that were not found on disk\n')
    for line in errorids:
        f.writelines(line+'\n')
    
            
    f.close()

def writeStatus():
    """This function does two things, first it simply prints some useful messages to the screen, letting
    the person who ran the script if it worked 100% or if there are items then need to attend too.  Second
    if there were some sort of error(s), based on our status flags, we know which message to print on screen
    for the user, and it then calls to write the log file with the corrisponding errors. 
    """
    global status_msg1
    global status_msg2
    if status_msg1 == 0 and status_msg2 == 0:
        print "\n\tThere were NO ERRORS, do the happy dance\n"
    elif status_msg1 == 1 and status_msg2 == 0:
        print "\n\tCheck your go2_media_grabber.log (Error Log) you have items in there you MUST attend to\n"
        writeLog()
    elif status_msg1 == 0 and status_msg2 == 1:
        print "\n\tYou are missing .ini file info, plese check your go2_media_grabber.log file for the product and feature mismatches\n"
        writeLog()
    elif status_msg1 == 1 and status_msg2 == 1:
        print "\n\tCheck your go2_media_grabber.log (Error Log) you have items in there you MUST attend to\n\tand\n\tYou are missing .ini file info, plese check your go2_media_grabber.log file for the product and feature mismatches\n"
        writeLog()


def main():
    # read the tab file data into memory, populates media_assets from .tab file
    getData()

    mergeFiles()
    # read the .ini file, populates dictionaries from .ini file  
    config = ConfigParser.ConfigParser()
    config.readfp(open('go2_media_grabber.ini'))
    directories = makeDict(config)

    # recurse directory structure for certain pattern, create dictionary populates file_dict
    recurseMediaTree()

    # call getpic to either decide to fetch or not fetch files, pass in the tab file key which we've made file.ext,
    #  also passes in the value of that key in the media_assets dict, and the entire directories dict
    for key in media_assets.keys():
        print "calling getPic with "+key;
        getPic(media_assets[key], key, directories)

    #print status for program
    writeStatus()

if __name__ == "__main__":
    main()
