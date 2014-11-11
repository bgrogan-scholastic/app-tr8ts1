from wxPython.wx import *
import string
import sys
import os
sys.path.append("/home/qadevWS/python/radtools/Packages");
from BaseClasses.Mediator import *
from BaseClasses.observer import Observer
from BaseClasses.GUI import *
from BaseClasses.Colleague import *
from Controls.giValidator import *
from FeatureTemplateShells import *
from Features import *
import Log
from TemplateController import *
import ScreenLogGUI
import DataCloud
import Release
from BaseClasses.xpath import *

class ReleaseGUI(GUI):
    def __init__(self, parentWindow, title):
        GUI.__init__(self, parentWindow, title);
        self.__inProcess = false;
        #only display a small border between elements
        self.articleborder = 3;      self.articleborder = 3;
        self.__xmlData = XPath("/data/rad/supertemplates/xml/release/releasedata.xml");
        self.__myParentWindow = parentWindow;

    def __del__(self):
        GUI.__del__(self);

    def load(self):
        pass

    def preview(self):
        pass

    def help(self):
        pass

    def cancel(self, event):
        result = GUI.cancel(self, event);
        if (result == true):
            if self.__myParentWindow != NULL:
                self.__myParentWindow.Show()
                self.Destroy();
                
    def _ColleagueChanged(self, colleague, event):
        """This method gets called when when of the colleagues has changed.
        This is the central 'clearing' house for all changes and orchestrates
        these changes among the cooperating controls"""
        # don't get recursive on us
        if self.__inProcess != true:
            self.__inProcess = true

            # call the corresponding method directly using a map lookup
	    if self._colleagueMap.has_key(colleague):
                self._colleagueMap[colleague](event)
            self.__inProcess = false
            
    def _show(self):
        #self._locationNames = ["dby", "linuxstage", "more"];
        self._locationNames = ["Select a location"];
        self.statusbar.SetStatusText("Start by selecting a location:");

        node = self.__xmlData.query("/releasedata/locations/*");
        #print node;
        #print str(type(node));
        for x in node:
            name =  x.getAttribute("name");
            self._locationNames.append(name);

        [locationID, rootpassword1ID, rootpassword2ID, rootpassword3ID, releasepassword1ID, goID, mysqlpasswordID, graphicIPID, adaIPID] = map(lambda x:wxNewId(), range(9));

        self.locationddl = DropDownList(self.panel, self, locationID, self._locationNames);
       
        self.rootpassword1 = TextBox(self.panel, self, rootpassword1ID, wxTE_PASSWORD, "");
        self.rootpassword2 = TextBox(self.panel, self, rootpassword2ID, wxTE_PASSWORD, "");
        self.rootpassword3 = TextBox(self.panel, self, rootpassword3ID, wxTE_PASSWORD, "");

        self.releasepassword1 = TextBox(self.panel, self, releasepassword1ID, wxTE_PASSWORD, "");

        self.mysqlpassword =  TextBox(self.panel, self, mysqlpasswordID, wxTE_PASSWORD, "");

        self.graphicIP =  TextBox(self.panel, self, graphicIPID, wxTE_LEFT, "");
        self.adaIP =  TextBox(self.panel, self, adaIPID, wxTE_LEFT, "");
       
        
        self.staticwin1 = wxStaticText(self.panel, -1, "");        
        self.staticwin2 = wxStaticText(self.panel, -1, "your user password");
        self.staticwin3 = wxStaticText(self.panel, -1, "release user password (all machines listed)");
        self.staticwin4 = wxStaticText(self.panel, -1, "machine1                  ");
        self.staticwin5 = wxStaticText(self.panel, -1, "machine2                  ");
        self.staticwin6 = wxStaticText(self.panel, -1, "machine3                  ");
        self.staticwin7 = wxStaticText(self.panel, -1, "MySQL password (all machines):");
        self.staticwin8 = wxStaticText(self.panel, -1, "Graphical IP: ");
        self.staticwin9 = wxStaticText(self.panel, -1, "ADA IP: ");        
        
        self.flexsizer = wxFlexGridSizer(4, 2, 10, 10);
        self.flexsizer.AddWindow(self.staticwin1, 0, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);
        self.flexsizer.AddWindow(self.staticwin2, 0, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);

        self.flexsizer.AddWindow(self.staticwin4, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);
        self.flexsizer.AddWindow(self.rootpassword1, 0, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);
        
        self.flexsizer.AddWindow(self.staticwin5, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);
        self.flexsizer.AddWindow(self.rootpassword2, 0, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);


        self.flexsizer.AddWindow(self.staticwin6, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);
        self.flexsizer.AddWindow(self.rootpassword3, 0, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);

        self.flexsizer.AddWindow(self.staticwin7, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);
        self.flexsizer.AddWindow(self.mysqlpassword, 0, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);

        #staticline = wxStaticLine(self.panel, -1, wxDefaultPosition, wxDefaultSize, style = wxLI_HORIZONTAL);
        self.flexsizer.AddWindow(wxStaticLine(self.panel, -1, wxDefaultPosition, wxDefaultSize, style = wxLI_HORIZONTAL), 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 0);
        self.flexsizer.AddWindow(wxStaticLine(self.panel, -1, wxDefaultPosition, wxDefaultSize, style = wxLI_HORIZONTAL), 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 0);        
        
        self.flexsizer.AddWindow(self.staticwin8, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);
        self.flexsizer.AddWindow(self.graphicIP, 0, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);

        self.flexsizer.AddWindow(self.staticwin9, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);
        self.flexsizer.AddWindow(self.adaIP, 0, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);

        # Added by Lori - 7/8/03
        self.flexsizer.AddWindow(wxStaticLine(self.panel, -1, wxDefaultPosition, wxDefaultSize, style = wxLI_HORIZONTAL), 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 0);
        self.flexsizer.AddWindow(wxStaticLine(self.panel, -1, wxDefaultPosition, wxDefaultSize, style = wxLI_HORIZONTAL), 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 0);
        self.flexsizer.AddWindow(self.staticwin3, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);
        self.flexsizer.AddWindow(self.releasepassword1, 0, 0, wxALIGN_LEFT |  wxALIGN_BOTTOM | wxALL | wxEXPAND, 10);
        

        self.goButton = Button(self.panel, self, goID, "Go!");
        
        ReleaseMap = {self.locationddl : self._locationHasChanged,
                      self.goButton : self._goButtonPressed};

        self._colleagueMap.update(ReleaseMap);
        
        
        #create a sizer for my elements.
        vsizer = wxBoxSizer(wxVERTICAL);

        # Commented out by Lori - 7/8/03
#        hsizer = wxBoxSizer(wxHORIZONTAL);
        vsizer.Add(self.locationddl, option = 0, flag = wxALL | wxALIGN_LEFT, border = self.bordersize);
        vsizer.Add(self.flexsizer, option = 1, flag =  wxALL | wxALIGN_LEFT,  border = self.bordersize);
        vsizer.Add(wxStaticLine(self.panel, -1, wxDefaultPosition, wxSize(300, 1), style = wxLI_HORIZONTAL),  option = 0, flag = wxALL | wxALIGN_LEFT, border = self.bordersize);

        # Commented out by Lori - 7/8/03
#        hsizer.Add(self.staticwin3, option = 0, flag = wxALL | wxALIGN_LEFT, border = self.bordersize);
#        hsizer.Add(self.releasepassword1,  option = 0, flag = wxALL | wxALIGN_LEFT, border = self.bordersize);
#        vsizer.Add(hsizer, option = 1, flag =  wxALL | wxALIGN_LEFT,  border = self.bordersize);
        
        vsizer.Add(self.goButton, option=0, flag = wxALL | wxALIGN_LEFT, border = self.bordersize);
        self.windowsize=wxSize(400, 400);
        self.Layout();
        return vsizer;
    
    def _goButtonPressed(self, event):
        rootMachine1 = self.rootpassword1.GetValue();
        releaseMachine1 = self.releasepassword1.GetValue();
        
        rootMachine2 = self.rootpassword2.GetValue();
        releaseMachine2 = self.releasepassword1.GetValue();

        rootMachine3 = self.rootpassword3.GetValue();
        releaseMachine3 = self.releasepassword1.GetValue();

        mysqlPasswd = self.mysqlpassword.GetValue();

        graphicip = self.graphicIP.GetValue();
        adaip = self.adaIP.GetValue();

        #get the location from the drop down list.
        location = self.locationddl.GetString(self.locationddl.GetSelection());

        if (len(rootMachine1) == 0 or len(rootMachine2) == 0 or len(rootMachine3) == 0 or len(releaseMachine1) == 0):
            mesg = wxMessageDialog(self, "One of the password fields have been left empty. Enter a password, then try again.","Error", wxCENTER | wxOK | wxICON_INFORMATION);
            mesg.ShowModal();
            return
        elif (location!="stage" and (graphicip=="" or adaip == "")):
            mesg = wxMessageDialog(self, "You have to enter an IP address for Graphical and ADA servers for this location.","Error", wxCENTER | wxOK | wxICON_INFORMATION);
            mesg.ShowModal();
            return            
        else:
            takeThat = {
                self.staticwin4.GetLabel(): {"root" : rootMachine1, "release" : releaseMachine1, "mysql" : mysqlPasswd},
                self.staticwin5.GetLabel():  {"root" : rootMachine2, "release" : releaseMachine2, "mysql" : mysqlPasswd},
                self.staticwin6.GetLabel():  {"root" : rootMachine3, "release" :  releaseMachine3, "mysql" : mysqlPasswd}
                };


            #Call the release util's build function here.
            radRelease = Release.Release(DataCloud.instance().value('pcode'))
            radRelease.executeRelease(location, takeThat, graphicip, adaip)
            
            if self.__myParentWindow != NULL:
                self.__myParentWindow.Show()
                self.Destroy();
                
    def _locationHasChanged(self, event):
        if (self.locationddl.GetSelection() == 0):
            return;

        location = self.locationddl.GetString(self.locationddl.GetSelection());

        if (location == "stage"):
            #mask out and clear the graphical and ada servers
            self.graphicIP.Clear();
            self.adaIP.Clear();
            self.graphicIP.Enable(0);
            self.adaIP.Enable(0);
            self.staticwin8.Enable(0);
            self.staticwin9.Enable(0);
        else:
            self.graphicIP.Enable(1);
            self.adaIP.Enable(1);
            self.staticwin8.Enable(1);
            self.staticwin9.Enable(1);
            
        
        query = "/releasedata/locations/location[@name='" + location + "']/machine";
        #print query;
        node = self.__xmlData.query(query);
        #print node;
        machinelist = [];
        for x in node:
            hostname = x.getAttribute("hostname");
            machinelist.append(hostname);
            #print x.getAttribute("ip");
            #print x.getAttribute("rad");
            #print ;

        if (len(machinelist) == 3):
            self.staticwin4.SetLabel(machinelist[0]);
            self.staticwin5.SetLabel(machinelist[1]);
            self.staticwin6.SetLabel(machinelist[2]);
            self.rootpassword1.Clear();
            self.releasepassword1.Clear();
            self.rootpassword2.Clear();
            self.rootpassword3.Clear();
        else:
            self.staticwin4.SetLabel("");
            self.staticwin5.SetLabel("");
            self.staticwin6.SetLabel("");

    
            
    #################################### COLLEAGUE / MEDIATOR FUNCTIONALITY ENDS  #############################################    
class ReleaseGUIApp(wxApp):
    def OnInit(self):
        #DataCloud.instance().load("eas");
        #DataCloud.instance().add("ptitle", "Encyclopedia of American Studies");
        #DataCloud.instance().addNS("mode", "edit");
        frame = ReleaseGUI(NULL, "Release Tool Config");
        frame.show(0);
        self.SetTopWindow(frame)
        return true


#---------------------------------------------
# Create and run our main app
#---------------------------------------------
if __name__ == "__main__":
    import DataCloud
    #ScreenLogGUI.displayScreenLog();
    app = ReleaseGUIApp(0);
    app.MainLoop()
