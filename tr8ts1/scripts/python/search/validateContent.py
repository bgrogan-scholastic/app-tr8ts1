import Pyro.core;
import Pyro.naming;
import sys;

locator = Pyro.naming.NameServerLocator();
ns = locator.getNS();
uri = ns.resolve('csupd-search_contentbuildvalidation');
obj = Pyro.core.getProxyForURI(uri);

print "/data/search/content validation";
results = obj.validateBuild(sys.argv[1], sys.argv[2], sys.argv[3], 'live');

if results[0] == True:
    print "\tValidation Successful!";
else:
    print "\tValidation Failed!";
    print "\t\tIndex Count: " + str(results[1]);
    print "\t\tFile Count: " + str(results[2]);

print "/data/search_uploads/data/search/content validation";
results = obj.validateBuild(sys.argv[1], sys.argv[2], sys.argv[3], 'upload');

if results[0] == True:
    print "\tValidation Successful!";
else:
    print "\tValidation Failed!";
    print "\t\tIndex Count: " + str(results[1]);
    print "\t\tFile Count: " + str(results[2]);
