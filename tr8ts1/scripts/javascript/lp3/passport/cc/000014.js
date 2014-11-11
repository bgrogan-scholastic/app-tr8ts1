
  var gameid="000014";
  var States = new Array(10);

  var side;
  var choice = "MO";
  if ("MI" == "MO")
	side = "l";
  else
	side = "r";		   	
  States[0] = new StateData (choice.toLowerCase(), side);

  choice = "NV";
  if ("NE" == "NV")
	side = "l";
  else
	side = "r";		   	
  States[1] = new StateData (choice.toLowerCase(), side);

  choice = "OK";
  if ("OK" == "OK")
	side = "l";
  else
	side = "r";		   	
  States[2] = new StateData (choice.toLowerCase(), side);

  choice = "UT";
  if ("UT" == "UT")
	side = "l";
  else
	side = "r";		   	
  States[3] = new StateData (choice.toLowerCase(), side);

  choice = "LA";
  if ("LA" == "LA")
	side = "l";
  else
	side = "r";		   	
  States[4] = new StateData (choice.toLowerCase(), side);

  choice = "IA";
  if ("IN" == "IA")
	side = "l";
  else
	side = "r";		   	
  States[5] = new StateData (choice.toLowerCase(), side);

  choice = "AR";
  if ("AL" == "AR")
	side = "l";
  else
	side = "r";		   	

  States[6] = new StateData (choice.toLowerCase(), side);

  choice = "NM";
  if ("NJ" == "NM")
	side = "l";
  else
	side = "r";		   	

  States[7] = new StateData (choice.toLowerCase(), side);

  choice = "MN";
  if ("MI" == "MN")
	side = "l";
  else
	side = "r";		   	

  States[8] = new StateData (choice.toLowerCase(), side);

  choice = "CT";
  if ("NY" == "CT")
	side = "l";
  else
	side = "r";		   	
  States[9] = new StateData (choice.toLowerCase(), side);


