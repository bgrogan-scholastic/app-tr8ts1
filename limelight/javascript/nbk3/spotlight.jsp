<%@ taglib prefix="gi" tagdir="/WEB-INF/tags/com/grolier/common" %>
//this is used by the left hand navigation area to product the correct spotlight link
      /****************************************************
      This allows for two types of spotlights, one that has
      multimedia which requires the Plugins cookie to be present
      and the other allows for a page without multimedia to be present
      *****************************************************************/
      
      function openSpotlight() {
      var PluginsPreference = theCookie.GetCookie("Plugins");
      var spotLight_BasePath = "/spotlight";
      
      var spotLight_FileName = "start.html";
      
      if(PluginsPreference != null) {
      if(PluginsPreference == "Y") {
      /* the user has plugins */
      spotLight_BasePath = spotLight_BasePath + "_plugins";
      }
      }				
      
      var spotLight_Url = "<gi:gi_basehref/>" + "/" + spotLight_BasePath + "/" + spotLight_FileName;
      
      /* send the user to the spotlight */
      location = spotLight_Url;
      }
