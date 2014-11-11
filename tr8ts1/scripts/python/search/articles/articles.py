#!/bin/python

import os;
import string;

from search.utils.WriteFile import *;

def visitDirectory(args, dir, names):
	pcode = args[0];
	product_id = args[1];

	for x in names:
		filepath = os.path.join(dir, x);
		if os.path.isfile(filepath):
			fp = open(filepath, 'r');
			contents = fp.read(100000000);
			fp.close();

			newcontents = '';
			
			charSetMetaTag = '<meta http-equiv=Content-type content="text/html; charset=UTF-8"/>';
			productIDMetaTag = '<meta name="product_id" content="' + product_id + '"/>';
			productCodeMetaTag = '<meta name="pcode" content="' + pcode + '"/>';

			if string.lower(contents).find( string.lower(charSetMetaTag) ) == -1:
			    #did not find the meta tag, so add it
			    newcontents = newcontents + charSetMetaTag + "\n";

			if string.lower(contents).find( string.lower(productIDMetaTag) ) == -1:
			    #did not find the meta tag, so add it
			    newcontents = newcontents + productIDMetaTag + "\n";

			if string.lower(contents).find( string.lower(productCodeMetaTag) ) == -1:
			    #did not find the meta tag, so add it
			    newcontents = newcontents + productCodeMetaTag + "\n";

			newcontents = newcontents + contents;

			print "Processing: " + filepath;
			fp = open(filepath, 'w');
			fp.write(newcontents);
			fp.close();

if __name__ == '__main__':
	product_id = os.environ['SRCH_PRODUCT_ID'];
	product_code = os.environ['SRCH_PRODUCT_CODE'];

	os.path.walk('/data/search/content/' + product_code + '/text', visitDirectory, [product_code, product_id]);
