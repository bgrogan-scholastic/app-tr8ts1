#!/usr/bin/python

import urllib2
from listfiles import listFiles

import re

class DB:
    def __init__(self, host="localhost", user="", passwd="", db=""):
        import MySQLdb
        self._con = MySQLdb.Connect(host, user, passwd, db)
        self._cursor = self._con.cursor()

    def query(self, sql=""):
        if sql == "":
            raise "sql statement empty"
        self._cursor.execute(sql)
        data =  self._cursor.fetchall()
        list = []
        for item in data:
            results = {}
            column = 0
            for d in self._cursor.description:
                results[d[0]] = item[column]
                column = column + 1
            list.append(results)
        return list
            

    def __del__(self):
        self._con.close()


class URL:
    """This class just provides an interface to the urllib.urlopen method that
retrieves the contents of a URL address"""
    def __init__(self):
        self._doc = ""

    def get(self, urladdress):
        # build a request object to source server
        req = urllib2.Request(urladdress)

        # open link to the server
        url = urllib2.urlopen(req)

        # return contents of url
        return url.read()


class BuildArticleList:
    def __init__(self, filepath = ""):
        
        # build the list from the file
        if filepath != "":
            pass
        # otherwise, build a complete list from the database
        else :
            db = DB("localhost", "ap", "ap", "ap")
            self._assets = db.query("select product_flag, id, title, type from assets")

    def assets(self):
        return self._assets

class BuildPictureList:
    def __init__(self):
        
        # get the list of matching picture files
        files = listFiles('/data/ap/docs/text/cache', '*.html')

        # create the storage list
        self._assets = []

        # iterate through the list of files
        for file in files:
            map = {}
            # iterate through the lines of the file
            lines = open(file).readlines()
            for line in open(file):
                hits = re.match('<a href="/picturepopup\?productid=(.*?)&assetid=(.*?)&templatename=/article/picturepopup\.html">(.*?)</a>', line)

                # no hits?, try the other pattern...
                if hits == None:
                    hits = re.match('/picturepopup\?productid=(.*?)&assetid=(.*?)&templatename=/article/picturepopup\.html.*?alt="(.*?)" .*?</a>', line)

                # did we get any hits at all?
                if hits != None:
                    map = {'product_flag' : hits.group(1), 'id' : hits.group(2), 'title' : hits.group(3), 'type' : '0mp'}
                    self._assets.append(map)
            
    def assets(self):
        return self._assets


def main():
    print "\nStarting Program\n"

    # create URL object
    url = URL()

    # create list of assets
    assets = []
    
    # create the list of assetid's to iterate through
    assets.extend(BuildArticleList().assets())

    # create and append the list of pictures
    assets.extend(BuildPictureList().assets())

    # iterate through the list
    for asset in assets:

        # is this NOT a picture type?
        if asset["type"] != "0mp":
            # build the url string
            urlstring = "http://linuxdev.grolier.com:1107/article?assetid=%(id)s&templatename=/article/article.html&cache=off" % asset
        
            print "Rebuilding '%(title)s', assetid=%(id)s - " % asset,

            # get contents of url
            doc = url.get(urlstring)

            if doc.find("<!--this is a Article page template-->") != -1:
                print "Built successfully"
            else:
                print "*** ERROR BUILDING ARTICLE ***"

        # otherwise, it is a picture type
        else:
            # build the url string
            urlstring = "http://linuxdev.grolier.com:1107/picturepopup?productid=%(product_flag)s&assetid=%(id)s&templatename=/article/picturepopup.html&cache=off" % asset

            print "Rebuilding '%(title)s', assetid=%(id)s - " % asset,
            
            # get contents of url
            doc = url.get(urlstring)

            # check to see if we got expected contents
            if doc.find("<!--this is a picture popup template-->") != -1:
                print "Built successfully"
            else:
                print "*** ERROR BUILDING PICTURE POPUP ***"

if __name__ == "__main__":
    main()
