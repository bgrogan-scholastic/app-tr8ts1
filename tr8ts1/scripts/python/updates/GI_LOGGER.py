import logging

""" Message levels (lowest to highest):
  DEBUG
  INFO
  WARN
  ERROR
  CRITICAL
  """

#desired format.
formatter = logging.Formatter("%(asctime)s = %(name)s - %(levelname)s - %(message)s")
logger = logging.getLogger("LOG")
logger.setLevel(logging.DEBUG) #default lowest level message to be logged
#console handler
ch = logging.StreamHandler()
ch.setLevel(logging.INFO)
ch.setFormatter(formatter)


#add new handlers
logger.addHandler(ch)

def logMessage(type,msg):
  if type == "error":
    logger.error(msg)
  elif type == "warn":
    logger.warn(msg)
  elif type == "info":
    logger.info(msg)
  elif type == "debug":
    logger.debug(msg)
  else:
    logger.critical(msg)
    
def setFilenameBase(filename):
  #file handler
  #global fh
  fh = logging.FileHandler("%s.log" % (filename))
  fh.setLevel(logging.INFO)
  fh.setFormatter(formatter)
  logger.addHandler(fh)

  dh = logging.FileHandler("%s.debug" % (filename))
  dh.setLevel(logging.DEBUG)
  dh.setFormatter(formatter)
  logger.addHandler(dh)

  eh = logging.FileHandler("%s.error" % (filename))
  eh.setLevel(logging.ERROR)
  eh.setFormatter(formatter)
  logger.addHandler(eh)
