#!/usr/bin/python
"""GI_Listfiles - recursive directory listing with pattern matching

This module provides a function which will recursively traverse a directory
and return a list of files that match a user defined pattern.
"""

import os.path, fnmatch

def listFiles(root, patterns='*', recurse=1, return_folders=0):
    """listFiles(root, patterns='*', recurse=1, return_folders=0) -> list of files

    This function will recursively traverse a directory (if recurse == 1)
    and return the list of files that match the pattern passed in. The
    pattern can be a semi-colon ';' separated list of patterns. The return
    value is a list containing complete filepaths that match the input parameters
    """
    # Expand patterns from semicolon-separated string to list
    pattern_list = patterns.split(';')

    # collect input and output arguments into one bunch
    class Bunch:
        def __init__(self, **kwds): self.__dict__.update(kwds)
        
    arg = Bunch(recurse=recurse, pattern_list=pattern_list, return_folders=return_folders, results=[])

    def visit(arg, dirname, files):
        # Append to arg.results all relevant files (and perhaps folders)
        for name in files:
            fullname = os.path.normpath(os.path.join(dirname, name))
            if arg.return_folders or os.path.isfile(fullname):
                for pattern in arg.pattern_list:
                    if fnmatch.fnmatch(name, pattern):
                        arg.results.append(fullname)
                        break
        # block recursion if recursion was disallowed
        if not arg.recurse : files[:] = []

    os.path.walk(root, visit, arg)

    return arg.results


def main():
    """ main() -> None

    This is the entry point for the self contained unit test code
    for this module
    """
    
    print "\nRecursive list of files in current directory\n"
    files = listFiles(os.getcwd(), "*")
    for file in files:
        print file

if __name__ == "__main__":
    main()
