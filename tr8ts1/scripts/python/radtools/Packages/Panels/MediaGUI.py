from wxPython.wx import *
import string
import sys
sys.path.append("/home/qadevWS/python/radtools/Packages")
from BaseClasses.Mediator import *
from BaseClasses.observer import Observer
from BaseClasses.GUI import *
from BaseClasses.Colleague import *
from Controls.giValidator import *
from Controls.DropDownList import *

import Log
from Features import *
from TemplateController import *;
from BaseClasses.PreviewBrowserCommands import *
import ScreenLogGUI

class MediaGUI(GUI):
    def __init__(self, parentWindow, title):
        GUI.__init__(self, parentWindow, title, wxSize(500,100))
        
        self.__inProcess = false

        # Initialize our default values
        self.__mediatitleTuple = ["mediatitle", "blank.include"]
        self.__mediacreditsTuple = ["mediacredits", "blank.include"]
        self.__numcolsTuple = ["numcols", "3"]
        self.__totalthumbsTuple = ["totalthumbs", "9"]
        
        #time to get our saved settings.
        #see what the status of the datacloud is?
        if DataCloud.instance().hasFeature("media") == false:
            #initialize the datacloud elements
            self.__saveDataCloudElements();
        else:
            Log.instance().add("Media feature already exists in datacloud, loading the values from the datacloud")

            myFeature = DataCloud.instance().getFeature("media")
            self.__mediatitleTuple[1] = myFeature.get(self.__mediatitleTuple[0])
            self.__mediacreditsTuple[1] = myFeature.get(self.__mediacreditsTuple[0])

            # if there's a media feature, I'm going to just assume there is also
            # already a medialist feature, and not check for it specifically

            myFeature = DataCloud.instance().getFeature("medialist")
            self.__numcolsTuple[1] = myFeature.get(self.__numcolsTuple[0])
            self.__totalthumbsTuple[1] = myFeature.get(self.__totalthumbsTuple[0])
                

    def __del__(self):
        GUI.__del__(self);

    def load(self):
        pass;
    
    def cancel(self, event):
        #print "Media GUI Cancel Button Pressed";
        GUI.cancel(self, event);

    def _save(self):
        self.__saveDataCloudElements()

        #commit the datacloud....
        DataCloud.instance().commit()

        #save the data cloud to disk
        DataCloud.instance().save(DataCloud.instance().value("pcode"))

        #notify everyone the data has changed.
        DataCloud.instance().notify(self)

        # 4/23/2003: Get password
        self.passwordCheck()

        #generating the media templates
        myTC = TemplateController("media")
        myTC.process()

        return true


    def preview(self, event):
        #save internal gui state to the datacloud....
        self.__saveDataCloudElements();

        # 4/23/2003: Get password
        self.passwordCheck()

        #generate the media preview templates
        myTC = TemplateController("media", "preview");
        myTC.process();

        #rollback the datacloud to get back the original dbname
        DataCloud.instance().rollback();
        
    def help(self, event):
        os.system("mozilla '/home/qadevWS/radtools/Packages/Panels/Help/media.html'");
    
    def __saveDataCloudElements(self):
        # save media feature
        myFeature = Features("media")
        myFeature.set(self.__mediatitleTuple[0], self.__mediatitleTuple[1])
        myFeature.set(self.__mediacreditsTuple[0], self.__mediacreditsTuple[1])
        DataCloud.instance().addFeature(myFeature)

        # save the medialist feature
        myFeature = Features("medialist")
        myFeature.set(self.__numcolsTuple[0], self.__numcolsTuple[1])
        myFeature.set(self.__totalthumbsTuple[0], self.__totalthumbsTuple[1])
        DataCloud.instance().addFeature(myFeature)

        # 5/6/2003: save the same values to the 'maplist' feature
        myFeature = Features("maplist")
        myFeature.set(self.__numcolsTuple[0], self.__numcolsTuple[1])
        myFeature.set(self.__totalthumbsTuple[0], self.__totalthumbsTuple[1])
        DataCloud.instance().addFeature(myFeature)
        

        
    def _show(self):
        #create a Validator that'll only filter for digits.
        self.v1 = giValidator(DIGIT_ONLY);

        # create the ids for each element in the panel
        [mediatitleID, mediacreditsID, numcolsID, totalthumbsID] = map(lambda x: wxNewId(), range(4));

        self.statusbar.SetStatusText("Media");
        
        # Set up the media controls
        mediasizer = wxBoxSizer(wxVERTICAL)
        mediasizer.Add(wxStaticText(self.panel, -1, "Media", wxDefaultPosition, wxDefaultSize), option = 0, flag = wxALL, border = self.bordersize)
        self.mediatitleBox = CheckBox(self.panel, self, mediatitleID, "Display Title from Database")
        self.mediacreditsBox = CheckBox(self.panel, self, mediacreditsID, "Display Credits from Database")
        mediasizer.Add(self.mediatitleBox, option = 0, flag =  wxALL,  border = self.bordersize);
        mediasizer.Add(self.mediacreditsBox, option = 0, flag =  wxALL,  border = self.bordersize);

        # initial media values/settings
        if self.__mediatitleTuple[1] == "blank.include":
            self.mediatitleBox.SetCheckboxValue(0)
        else:
            self.mediatitleBox.SetCheckboxValue(1)

        if self.__mediacreditsTuple[1] == "blank.include":
            self.mediacreditsBox.SetCheckboxValue(0)
        else:
            self.mediacreditsBox.SetCheckboxValue(1)

        # set up the medialist controls
        medialistsizer = wxBoxSizer(wxVERTICAL)
        medialistsizer.Add(wxStaticText(self.panel, -1, "Media List", wxDefaultPosition, wxDefaultSize), option = 0, flag = wxALL, border = self.bordersize);

        numcolsSizer = wxBoxSizer(wxHORIZONTAL)
        self.numcolsBox = TextBox(self.panel, self, numcolsID, wxTE_RIGHT, self.__numcolsTuple[1], giValidator(DIGIT_ONLY), wxSize(25, -1));
        numcolsSizer.Add(self.numcolsBox, option = 0, flag =  wxALL,  border = self.bordersize);        
        numcolsSizer.Add(wxStaticText(self.panel, -1, "Number of Columns"), option = 0, flag = wxALL, border = 20);
        medialistsizer.Add(numcolsSizer, option = 0, flag = wxTE_LEFT ,  border = 20)

        totalthumbsSizer = wxBoxSizer(wxHORIZONTAL)
        self.totalthumbsBox = TextBox(self.panel, self, totalthumbsID, wxTE_RIGHT, self.__totalthumbsTuple[1], giValidator(DIGIT_ONLY), wxSize(25, -1));
        totalthumbsSizer.Add(self.totalthumbsBox, option = 0, flag =  wxALL,  border = self.bordersize);        
        totalthumbsSizer.Add(wxStaticText(self.panel, -1, "Total Thumbnails"), option = 0, flag = wxALL, border = 20);
        medialistsizer.Add(totalthumbsSizer, option = 0, flag = wxTE_LEFT ,  border = 20)

        # Now let's build our 'Colleague map' for mediation
        MediaColleagueMap = {
                                 self.mediatitleBox : self._mediatitleCall,
                                 self.mediacreditsBox : self._mediacreditsCall,
                                 self.numcolsBox : self._numcolsCall,
                                 self.totalthumbsBox : self._totalthumbsCall
                                 }

        self._colleagueMap.update(MediaColleagueMap)

        mainsizer = wxBoxSizer(wxHORIZONTAL);

        mainsizer.Add(mediasizer, option = 0, flag = wxALL | wxALIGN_CENTER, border = 20);
        mainsizer.Add(medialistsizer, option = 0, flag = wxALL | wxALIGN_CENTER, border = 20);

        #because I'm AR, I move the window to a point on the screen where I can constantly see it.
        self.Move((100,250));
       
        return mainsizer;


    # 3/23/2003: If the 'relmaps' feature exists, call the getPassword() method
    # in the GUI base class
    def passwordCheck(self):
        if DataCloud.instance().hasFeature("relmaps") == true:
            foo = self.getPassword("qadev")


# This is the mediator action.
    def _ColleagueChanged(self, colleague, event):
        # Let's avoid recursion
        if self.__inProcess != true:
            self.__inProcess = true

            if self._colleagueMap.has_key(colleague):
                self._colleagueMap[colleague](event)
            else:
                dlg = wxMessageDialog(self, "MediaGUI._ColleagueChanged()", "Message box", wxOK | wxCENTRE, wxDefaultPosition);
                dlg.ShowModal();

        self.__inProcess = false

#----------------------------------------------------------
# Mediation functions
#----------------------------------------------------------

    def _mediatitleCall(self, event):
        if self.mediatitleBox.GetValue() == 1:
            self.__mediatitleTuple[1] = "mediatitle.include"
        else:
            self.__mediatitleTuple[1] = "blank.include"

    def _mediacreditsCall(self, event):
        if self.mediacreditsBox.GetValue() == 1:
            self.__mediacreditsTuple[1] = "mediacredits.include"
        else:
            self.__mediacreditsTuple[1] = "blank.include"

    def _numcolsCall(self, event):
        self.__numcolsTuple[1] = self.numcolsBox.GetValue()


    def _totalthumbsCall(self, event):
        self.__totalthumbsTuple[1] = self.totalthumbsBox.GetValue()



#######################################################
#
#  Standalone test
#
#######################################################

class MediaGUIApp(wxApp):
    def OnInit(self):
        frame = MediaGUI(NULL, "Media Generator");
        frame.show();
        self.SetTopWindow(frame)
        return true

if __name__ == "__main__":
        #load the data cloud
	import DataCloud
	DataCloud.instance().load("eas");

	#---------------------------------------------
	# Create and run our main app
	#---------------------------------------------
        ScreenLogGUI.displayScreenLog();
        app = MediaGUIApp(0);
	app.MainLoop()

