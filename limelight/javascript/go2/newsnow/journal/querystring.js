var queryParams = new Array();

function queryString(name, value) {
  this.name  = name;
  this.value = value;  
}

function parseQueryString() {
  var query    = location.search;
  query        = query.substring(1);
  var tmpQuery = query.split("&");
  var name     = "";
  var value    = "";
  var index    = 0;

  for (i = 0; i < tmpQuery.length; i++) {
    index          = tmpQuery[i].indexOf("=");
    name           = tmpQuery[i].substring(0, index);
    value          = tmpQuery[i].substring(index+1);
    queryParams[i] = new queryString(name, value);
  }
}

function getQueryParameterValue(param) {
  for (i = 0; i < queryParams.length; i++) {
    if (queryParams[i].name == param)
      return queryParams[i].value;
  }
  return "";
}

