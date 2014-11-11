
import sys

sys.path.append("/data/loadtools/scripts/python/common")

from utils.GI_SSH import SSH

ssh = SSH("root", "DC*mintyfresh", "10.60.25.131")

print ssh.command("export TERM=xterm; echo $TERM")
print ssh.command("ipvsadm -l -n -t 10.60.25.131:80")

ssh.close()
