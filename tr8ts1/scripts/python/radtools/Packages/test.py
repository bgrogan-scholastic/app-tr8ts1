from BaseClasses.searchandreplace import *


def __handleTag(tag):
        print "found this: " + tag
	return tag;

sr = SearchAndReplace('((?:<img src="|<IMG SRC=")(.*?)(\.gif|\.jpg)(.*?">))', __handleTag);
sr.setContents('stuff<img src="/fdsfkdsf.gif" width="100" height="100" alt="jfk&lgj">more stuff');
print sr.getContents();

