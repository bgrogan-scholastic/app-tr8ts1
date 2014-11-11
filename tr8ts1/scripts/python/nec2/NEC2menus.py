#!/usr/bin/python
"""This program just builds the menu for the menuing system in Cumbre

On the command line please enter the full path to Cumbres
/javascript/common/hmenu path. This will be were the NEC2menus.js file
will be created.
"""

__author__ = "Doug Farrell"
__version__ = "0.0.1"
__date__ = "4/5/2005"

import os
import sys
import getopt
import MySQLdb


hm_array1 = """
/* This is the cumbre Splash Page category menu */
	HM_Array1 = [	
	[200,      // menu width (was 200)
	157,       // left_position
	99,       // top_position
	"#000000",   // font_color
	"#000000",   // mouseover_font_color
	"#9ebc69",   // background_color
	"#c0dd8c",   // mouseover_background_color
	"#c0dd8c",   // border_color
	"#9ebc69",    // separator_color
	0,         // top_is_permanent (was 1)
	0,         // top_is_horizontal
	0,         // tree_is_horizontal
	1,         // position_under (was 1)
	1,         // top_more_images_visible (was 1)
	1,         // tree_more_images_visible (was 1)
	"",    // evaluate_upon_tree_show (was "null")
	"",    // evaluate_upon_tree_hide (was "null")
	,          // right_to_left
	],     // display_on_click

%s

	];
"""
	
hm_array2 = """
/* This is the Splash Page student 'Temas' menu */
	HM_Array2 = [	
	[131,      // menu width (was 200)
	7,       // left_position
	65,    // top_position
	"#ffffff",   // font_color
	"#ffffff",   // mouseover_font_color
	"#401b67",   // background_color
	"#5c57bf",   // mouseover_background_color
	"#e13e1a",   // border_color
	"#401b67",    // separator_color
	0,         // top_is_permanent (was 1)
	0,         // top_is_horizontal
	0,         // tree_is_horizontal
	1,         // position_under (was 1)
	1,         // top_more_images_visible (was 1)
	1,         // tree_more_images_visible (was 1)
	"",    // evaluate_upon_tree_show (was "null")
	"",    // evaluate_upon_tree_hide (was "null")
	,          // right_to_left
	],     // display_on_click

%s

	];
"""

class Database(object):
    """This class defines a resuable database object, yeah, yeah, big deal"""
    
    def __init__(self, host, user, passwd, db):
        """The class constructor, this method initializes the class and connects to the database"""
        try:
            self.__db = MySQLdb.connect(host, user, passwd, db)
            self.__cursor = self.__db.cursor(MySQLdb.cursors.DictCursor)
            print "opened the database on %s" % host
        except MySQLdb.Error, e:
            print "Database error : " + e
            
    def query(self, sql):
        """This method returns a dictionary to the caller containing the requested data"""
        self.__cursor.execute(sql)
        return self.__cursor.fetchall()
            
    def __del__(self):
        try:
            self.__db.close()
            print "closed the database"
        except MySQLdb.BINARY, e:
            print "Database error : " + e
        
    def close(self):
        try:
            self.__db.close()
        except MySQLdb.BINARY, e:
            print "Database error : " + e
        
        
    
def formatData(data, format):
    """This function just formats the data and returns it as one string"""
    retval = ""
    
    # iterate over the data and build the strings from the row
    for row in data:
        retval += (format + ",\n") % row

    # strip off last ',' character
    retval = retval[:retval.rfind(',')]
    return retval


class Usage(object):
    def __init__(self, msg):
        self.msg = msg
    
    
def main(argv=None):
    """This is the main entry point for the program and pulls all the pieces together to produce output"""
    
    if argv is None:
        argv = sys.argv
    try:
        try:
            opts, args = getopt.getopt(argv[1:], "ph", ["path", "help"])
        except getopt.error, msg:
             raise Usage(msg)
            
        # get the parameters from the command line
        if len(args) > 0:
            filepath = args[0]

            # does the directory exist?
            if os.path.exists(filepath) == False:
                raise "Argument filepath %s doesn't exist" % filepath
        else:
            raise "Required filepath argument missing"

        # get a connection to the database
        db = Database(host = "linuxstage.grolier.com", user="nec2", passwd="nec2", db="nec2")

        # do array 1
        data1 = db.query("select * from subject_browse where sb_parent_id='0'and sb_heir_id='0ta' order by sb_seq, sb_thing asc")
        format_hm_array1 = '["%(sb_thing)s", "<gi:gi_basehref/>/page?tn=/browse/browse_cumbre.html&sb_child_id=%(sb_child_id)s&type=0ta",1,0,1]'
        output1 = formatData(data1, format_hm_array1)

        # do array 2
        data2 = db.query("select * from subject_browse where sb_parent_id='0'and sb_heir_id='0tas' order by sb_seq, sb_thing asc")
        format_hm_array2 = '["%(sb_thing)s", "<gi:gi_basehref/>/page?tn=/browse/browse_student.html&sb_child_id=%(sb_child_id)s&type=0tas#browse_##SB_CHILD_ID##",1,0,1]'
        output2 = formatData(data2, format_hm_array2)

        # close database
        db.close()

        # build the output file
        jspFile = file(filepath + "/NEC2menus.jsp", 'w')

        # write the necessary jsp header section
        jspFile.write('<%@ taglib prefix="gi" tagdir="/WEB-INF/tags/com/grolier/common" %>' + "\n")
        
        # write first section
        jspFile.write(hm_array1 % output1)
        print "built menu 1"

        # write second section
        jspFile.write(hm_array2 % output2)
        print "built menu 2"

        # close the file
        jspFile.close()

    except Usage, err:
        print >>sys.stderr, err.msg
        print >>sys.stderr, "for help use --help"
        return 2

if __name__ == "__main__":
    sys.exit(main())
        
