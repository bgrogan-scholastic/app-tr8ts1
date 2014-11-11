
import pexpect
import socket
import os
import Pyro.core
import Pyro.naming

class LoadBalancer_ToggleServer(object):
	"""LoadBalancer_ToggleServer: used to toggle servers on/off as necessary"""

	def __init__(self):
		pass;

class LoadBalancer_ToggleServerImpl(Pyro.core.ObjBase, LoadBalancer_ToggleServer):
	def __init__(self):
		Pyro.core.ObjBase.__init__(self);
		LoadBalancer_ToggleServer.__init__(self);
