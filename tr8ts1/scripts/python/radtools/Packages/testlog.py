import Log;
import FileLog;
import DataCloud;
import os;

if __name__ == "__main__":
	DataCloud.instance().add("pcode", "radtest");
	myLog = Log.instance();

	logFilePath = os.path.join("/data/rad/logs", "radapp-" + DataCloud.instance().value("pcode") + ".log");	
	myLogFile = FileLog.instance(logFilePath);

	Log.instance().add("duh");
	
	myLog.add("hello world");

