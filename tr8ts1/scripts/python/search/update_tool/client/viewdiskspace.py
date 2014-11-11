import Pyro;
import Pyro.naming;

class ViewDiskSpace(object):
        def __init__(self):
		Pyro.core.initClient();
		locator = Pyro.naming.NameServerLocator();
		ns = locator.getNS();
		print ns.list("");

        def displayDiskSpace(self):
                pass;

