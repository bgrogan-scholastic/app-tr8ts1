# gi_sudo_setup_functions.py
#
# 9/10/04 Dylan Gladstone
#
# Update History
#

import sys

# find out what platform we're running on
def get_platform():
	platform = sys.platform
	if (platform == "sunos5"):
		platform = "solaris"
	else:
		if (platform == "linux2"):
			platform = "linux"
		else:
			platform = "unknown"

	return platform
