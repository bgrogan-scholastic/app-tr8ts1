
  var gameid="000015";
  var States = new Array(10);

  var side;
  var choice = "MA";
  if ("ME" == "MA")
	side = "l";
  else
	side = "r";		   	
  States[0] = new StateData (choice.toLowerCase(), side);

  choice = "MA";
  if ("MA" == "MA")
	side = "l";
  else
	side = "r";		   	
  States[1] = new StateData (choice.toLowerCase(), side);

  choice = "VT";
  if ("WA" == "VT")
	side = "l";
  else
	side = "r";		   	
  States[2] = new StateData (choice.toLowerCase(), side);

  choice = "MA";
  if ("ME" == "MA")
	side = "l";
  else
	side = "r";		   	
  States[3] = new StateData (choice.toLowerCase(), side);

  choice = "PA";
  if ("PA" == "PA")
	side = "l";
  else
	side = "r";		   	
  States[4] = new StateData (choice.toLowerCase(), side);

  choice = "AR";
  if ("AK" == "AR")
	side = "l";
  else
	side = "r";		   	
  States[5] = new StateData (choice.toLowerCase(), side);

  choice = "KY";
  if ("KY" == "KY")
	side = "l";
  else
	side = "r";		   	

  States[6] = new StateData (choice.toLowerCase(), side);

  choice = "VA";
  if ("VT" == "VA")
	side = "l";
  else
	side = "r";		   	

  States[7] = new StateData (choice.toLowerCase(), side);

  choice = "TX";
  if ("TN" == "TX")
	side = "l";
  else
	side = "r";		   	

  States[8] = new StateData (choice.toLowerCase(), side);

  choice = "NY";
  if ("NY" == "NY")
	side = "l";
  else
	side = "r";		   	
  States[9] = new StateData (choice.toLowerCase(), side);


