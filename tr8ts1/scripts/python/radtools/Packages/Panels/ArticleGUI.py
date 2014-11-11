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
from BaseClasses.xpath import *

class ArticleGUI(GUI):
    def __init__(self, parentWindow, title):
        GUI.__init__(self, parentWindow, title);
        self.__inProcess = false;
        #only display a small border between elements
        self.articleborder = 3;
        self.__xmlData = XPath("/data/rad/supertemplates/xml/asset-types.xml");
        
    def RetrieveTypeFromXML(self, AssetName):
        try:
            query = '/assets/type[@name="' + AssetName + '"]';
            node = self.__xmlData.query(query);
            result = str(node[0].getAttribute("id"));
            return result;
        except QueryException, message:
            Log.instance().add("ArticleGUI::RetrieveTypeFromXML: ==> Tag: " + AssetName + " could not be located in the xml ruleset and will be replaced with nothing", Log.instance().bitMaskWarningAll());
            result = "";
            return result;

    def RetrievePopupSizingfromXML(self, AssetName):
        try:
            query = '/assets/type[@name="' + AssetName + '"]';
            node = self.__xmlData.query(query);
            width = str(node[0].getAttribute("width"));
            height = str(node[0].getAttribute("height"));
            mytuple = (width, height);
            return mytuple;
        except QueryException, message:
            Log.instance().add("ArticleGUI::RetrievePopupSizingfromXML: ==> Tag: " + AssetName + " could not be located in the xml ruleset and will be replaced with nothing", Log.instance().bitMaskWarningAll());
            width = "0";
            height = "0";
            mytuple = (width, height);
            return mytuple;
                
    def CreateRow(self, TextHeader, checkbox1, checkbox1ID, radiobox1, radiobox1ID,
                  textbox1, textbox1ID, textbox2, textbox2ID, checkbox3, checkbox3ID):
        self.flexsizer.AddWindow(wxStaticText(self.panel, -1, TextHeader), 0, 0,
                                 wxALIGN_LEFT | wxALIGN_BOTTOM | wxALL | wxEXPAND ,self.articleborder);
        self.flexsizer.AddWindow(checkbox1, 0,  0,
                                 wxALIGN_CENTER | wxALIGN_BOTTOM | wxALL | wxEXPAND, self.articleborder);
        self.flexsizer.AddWindow(radiobox1, 0, 0,
                                 wxALIGN_CENTER | wxALIGN_BOTTOM | wxALL | wxEXPAND, self.articleborder);
        self.flexsizer.AddWindow(textbox1, 0, 0,
                                 wxALIGN_CENTER | wxALIGN_BOTTOM | wxALL | wxEXPAND, self.articleborder);
        self.flexsizer.AddWindow(textbox2, 0, 0,
                                 wxALIGN_BOTTOM | wxALIGN_BOTTOM | wxALL | wxEXPAND, self.articleborder);
        self.flexsizer.AddWindow(checkbox3, 0, 0,
                                 wxALIGN_CENTER | wxALIGN_BOTTOM | wxALL | wxEXPAND, self.articleborder);

    def __del__(self):
        GUI.__del__(self);

    def load(self):
        featurelist = {"pictures":self.tb12, "maps":self.tb22, "flags":self.tb32,
                       "weblinks":self.tb42, "artwork":self.tb52, "tables":self.tb62,
                       "factboxes":self.tb72, "biblios":self.tb82, "arts":self.tb92,
                       "pfe":self.tb112};
        
        thumbnails = {"pictures":self.tb11, "maps":self.tb21, "flags":self.tb31, "artwork":self.tb51};
       
        radiolist = {"pictures":self.rb1, "maps":self.rb2, "flags":self.rb3,
                     "weblinks":self.rb5, "artwork":self.rb5};
        
        checkboxlist = {"pictures":self.cb11, "maps":self.cb21, "flags":self.cb31,
                        "weblinks":self.cb41, "artwork":self.cb51, "tables":self.cb61,
                        "factboxes":self.cb71, "biblios":self.cb81, "arts":self.cb91,
                        "pfe":self.cb111};
        
        popupcheckboxlist = {"pictures":self.cb13, "maps":self.cb23, "flags":self.cb33,
                             "artwork":self.cb53, "tables":self.cb63, "factboxes":self.cb73,
                             "biblios":self.cb83, "arts":self.cb93};

        #--------- article -------------        
        if DataCloud.instance().hasFeature("article"):
            templatename = DataCloud.instance().getFeature("article").get("templateName");
            #print "Loading article";
            #print templatename;
            #print self.templateKeys;
            if (self.templateDict.has_key(templatename)):
                #add 1 (the default selection is 0);
                idx = self.templateKeys.index(templatename) + 1;
                #print "Setting selection to: " + str(idx);
                self.ddl1.SetSelection(idx);
                
        #--------- browse -------------
        if DataCloud.instance().hasFeature("browselist"):
            browsetype = DataCloud.instance().getFeature("browselist").get("browselist");
            browsetype = browsetype.replace("browselist.include", "");
            #print "Browse type:" + str(browsetype);
            if (browsetype == "alpha"):
                self.ddl2.SetSelection(1);
            elif (browsetype == "heir"):
                self.ddl2.SetSelection(2);
            elif (browsetype == "subject"):
                self.ddl2.SetSelection(3);
        #--------- advanced search -------------
        if DataCloud.instance().hasFeature("quicksearch"):
            pagetype = DataCloud.instance().getFeature("quicksearch").get("advpagetype");
            #print "Pagetype=" + str(pagetype);
            if (pagetype == None or pagetype.find("_popup") == -1):
                #the advanced search is not in a popup
                self.cb103.SetCheckboxValue(0);
            else:
                self.cb103.SetCheckboxValue(1);
        #--------- related assets priorities / checkboxes ----------
        if DataCloud.instance().hasFeature("relatedassets"):
            for x in range (1, 10):
                value = DataCloud.instance().getFeature("relatedassets").get(str(x));
                if value != None:
                    #print str(x), value;
                    value = value.replace(".obj", "");
                    value = value.replace("rel", "");
                    (feat, rb_option) = value.split("_", 2);
                    #print feat, rb_option, x;
                    #print "Feature: " + feat;
                    featurelist.get(feat).SetValue(str(x));
                    rbval = 0;
                    if rb_option == "thumbnail":
                        rbval = 1;
                    if (radiolist.has_key(feat)):
                        radiolist.get(feat).SetSelection(rbval);
                    checkboxlist.get(feat).SetCheckboxValue(1);
        #--------- Get the thumbnails and the popup style ----------
        featurelist = DataCloud.instance().getFeatureNames();
        #print featurelist;
        for f in featurelist:
            if f[0:3] == "rel":
                #print f;
                fname = f.replace("rel", "");
                #print "";
                #print "base feature name: " + fname;
                #print "Feature in question: " + f;
                #print DataCloud.instance().hasFeature(f);
                if DataCloud.instance().hasFeature(f) == true:
                    #print "Feature exists. Does it have pagetype?";
                    if DataCloud.instance().getFeature(f).get("pagetype") != None and DataCloud.instance().getFeature(f).get("pagetype")=="_popup":
                         #check the associated checkbox
                         #print "Yes, it has pagetype.";
                         if (popupcheckboxlist.get(fname) != None):
                             #print "setting checkbox for feature " + fname + " to 1.";
                             popupcheckboxlist.get(fname).SetCheckboxValue(1);
                maxthumbs = DataCloud.instance().getFeature(f).get("max")
                if  maxthumbs != None and thumbnails.get(fname)!=None:
                    #put this number in the associated textbox for thumbnails.
                    thumbnails.get(fname).SetValue(maxthumbs);
                    #print maxthumbs;
        
                    
    #here I look to make sure that you've selected all the correct priorities and amount of thumbnails before we let you continue.
    def performSanityCheck(self):
        status = false;

        #----------- check article template -----------
        articleTemplate = self.ddl1.GetSelection();
        if (articleTemplate == 0 and len(self.templateOptions) > 1):
            Log.instance().add("You haven't selected an article shell", Log.instance().bitMaskCriticalScreen());
            return status;
        #print articleTemplate;
        if (articleTemplate > 0):
            print "Selected template: " + self.templateKeys[articleTemplate - 1];
        else:
            print "no template selected.";
            

        #----------- check browse type ------------------
        browsetype = self.ddl2.GetSelection();
        if (browsetype == 0):
            status = false;
            Log.instance().add("You haven't selected a browse type", Log.instance().bitMaskCriticalScreen());
            return status;
        #print "Browse Type: " + str(browsetype);
        
        #get the number of active checkboxes, and the priority attached to each one
        self.cblist = [self.cb11, self.cb21, self.cb31, self.cb41, self.cb51, self.cb61, self.cb71, self.cb81, self.cb91, self.cb111];
        #priority checkbox list
        self.ptblist = [self.tb12, self.tb22, self.tb32, self.tb42, self.tb52, self.tb62, self.tb72, self.tb82, self.tb92, self.tb112];
        #self.checkedlist = [];
        self.prioritylist = [];
        for cbi in range(0, len(self.cblist)):
            if self.cblist[cbi].GetValue() == 1:
                #print str(cbi+1) + " is checked";
                itemvalue = self.ptblist[cbi].GetValue();
                #print "\tValue:" + itemvalue;
                self.prioritylist.append(itemvalue);
            else:
                #print str(cbi+1) + " is unchecked";
                pass


        self.prioritylist.sort();
        #print self.prioritylist;
        if (len(self.prioritylist) == 0):
                status = false;
                message = "Please select some related assets before continuing.";
                Log.instance().add(message, Log.instance().bitMaskCriticalScreen());
            
        for x in range(1, len(self.prioritylist)+1):
            if str(x) not in self.prioritylist:
                status = false;
                message = "Priority " + str(x) + " has not been selected.";
                Log.instance().add(message, Log.instance().bitMaskCriticalScreen());
                break
            elif self.prioritylist.count(x) > 1:
                message = "Priority " + str(x) + " appears more than once.";
                Log.instance().add(message, Log.instance().bitMaskCriticalScreen());
                break
            else:      
                status = true;

        radioBoxes = [self.rb1, self.rb2, self.rb3, self.rb5];
        textBoxes = [self.tb11, self.tb21, self.tb31, self.tb51];
        for rb in range(0, len(radioBoxes)):
            if (radioBoxes[rb].GetSelection()==1 and textBoxes[rb].GetValue() == "0"):
                Log.instance().add("Radio Box #" + str(rb+1) + " is selected to choose thumbnails, but you have chosen a quantity of 0.", Log.instance().bitMaskCriticalScreen());
                status = false;

        return status;

    def updateDataCloud(self):
        status = false;

        #Check all the priorities
        status = self.performSanityCheck();
        if (status == false):
            return status;

        #-------------- ARTICLE TEMPLATE ---------------------        
        myFeat = Features("article");
        articleTemplate = self.ddl1.GetSelection();
        print  self.templateKeys[articleTemplate - 1];
        myFeat.set("templateName", self.templateKeys[articleTemplate - 1]);
        DataCloud.instance().addFeature(myFeat);
        
        #-------------- BROWSE ---------------------
        myFeat = Features("browselist");
        browsetype = int(self.ddl2.GetSelection());

        if (browsetype==1):
            #alpha browse;
            myFeat.set("browselist", "alphabrowselist.include");
        elif (browsetype==2):
            #heirarchical browse;
            myFeat.set("browselist", "heirbrowselist.include");
        elif (browsetype==3):
            #subject browse
            myFeat.set("browselist", "subjectbrowselist.include");
        DataCloud.instance().addFeature(myFeat);
            
        #-------------- COMMON ---------------------
        myFeat = Features("common");
        myFeat.set("header", "banner.html");
        myFeat.set("footer", "footer.html");
        #get the info about the browse - if we've gotten this far, we have a browse selected.
        if (browsetype==1):
            #alpha browse;
            myFeat.set("browse", "alphabrowse.include");
        elif (browsetype==2):
            #heirarchical browse;
            myFeat.set("browse", "heirbrowse.include");
        elif (browsetype==3):
            #subject browse
            myFeat.set("browse", "subjectbrowse.include");
        #get the information about the advanced search
        advsearch = self.cb103.GetValue();
        DataCloud.instance().addFeature(myFeat);

        #always make sure if there is a quick search feature here, then we load it from the data cloud and add on to it.
        myFeat = None;
        if DataCloud.instance().hasFeature("quicksearch") == false:
            myFeat = Features("quicksearch");
        else:
            myFeat = DataCloud.instance().getFeature("quicksearch");
            
        if (advsearch == 1):
            #it's in a popup
            myFeat.set("advpopupbegin", 'javascript:OpenBlurbWindow(\'');
            myFeat.set("advpopupend", "\', 610, 600, 'advsearch', 'yes');");
            myFeat.set("advpagetype", "_popup");
        DataCloud.instance().addFeature(myFeat);        
        
        #-------------- RELATED ASSETS ---------------------
        myFeat = Features("relatedassets");
        #-------------- PICTURES ---------------------
        if self.cb11.GetValue()==1:
            type = self.rb1.GetStringSelection().lower();
            #add in the related priority, thumbnail/button option.
            myFeat.set(str(self.tb12.GetValue()), "relpictures_" + type + ".obj");

            #set the specific features items;
            sFeat = Features("relpictures");
            sFeat.clear();            
            if (self.rb1.GetSelection()==1):
                sFeat.set("max", str(self.tb11.GetValue()));

            thisType = self.RetrieveTypeFromXML("picture");
            whtuple  = self.RetrievePopupSizingfromXML("picture");
            pwidth = str(whtuple[0]);
            pheight = str(whtuple[1]);
            
            sFeat.set("type", thisType);
            sFeat.set("moreflag", "y");
            #check popup status
            if self.cb13.GetValue()==1:
                #only use if pictures to be displayed in a popup
                sFeat.set("popupbegin", 'javascript:OpenBlurbWindow(\'');
                sFeat.set("popupend", "\', " + pheight + " , " + pwidth + ", '" + thisType + "', 'yes');");
                sFeat.set("pagetype", "_popup");
            DataCloud.instance().addFeature(sFeat);
        else:
            DataCloud.instance().removeFeature("relpictures");
            
        #-------------- MAPS ---------------------
        if self.cb21.GetValue()==1:
            type = self.rb2.GetStringSelection().lower();
            #add in the related priority, thumbnail/button option.
            myFeat.set(str(self.tb22.GetValue()), "relmaps_" + type + ".obj");

            #set the specific features items;
            sFeat = Features("relmaps");
            sFeat.clear();            
            if (self.rb2.GetSelection()==1):
                sFeat.set("max", str(self.tb21.GetValue()));

            thisType = self.RetrieveTypeFromXML("map");
            sFeat.set("type", thisType);
            sFeat.set("moreflag", "y");

            whtuple  = self.RetrievePopupSizingfromXML("map");
            pwidth = str(whtuple[0]);
            pheight = str(whtuple[1]);
            
            #check popup status
            if self.cb23.GetValue()==1:
                #only use if this is to be displayed in a popup
                sFeat.set("popupbegin", 'javascript:OpenBlurbWindow(\'');
                sFeat.set("popupend", "\', " + pheight + " , " + pwidth + ", '" + thisType + "', 'yes');");                
                #sFeat.set("popupend", "\', 680, 500, 'p', 'yes');");
                sFeat.set("pagetype", "_popup");
            DataCloud.instance().addFeature(sFeat);
        else:
            DataCloud.instance().removeFeature("relmaps");
        
        #-------------- FLAGS ---------------------
        if self.cb31.GetValue()==1:
            #retrieve button or thumbnail
            type = self.rb3.GetStringSelection().lower();
            #add in the related priority, thumbnail/button option.
            myFeat.set(str(self.tb32.GetValue()), "relflags_" + type + ".obj");

            #set the specific features items;
            sFeat = Features("relflags");
            sFeat.clear();            
            if (self.rb3.GetSelection()==1):
                sFeat.set("max", str(self.tb31.GetValue()));
            thisType = self.RetrieveTypeFromXML("flag");                
            sFeat.set("type", thisType);
            sFeat.set("moreflag", "y");
            
            whtuple  = self.RetrievePopupSizingfromXML("flag");
            pwidth = str(whtuple[0]);
            pheight = str(whtuple[1]);
            
            #check popup status
            if self.cb33.GetValue()==1:
                #only use if this is to be displayed in a popup
                sFeat.set("popupbegin", 'javascript:OpenBlurbWindow(\'');
                sFeat.set("popupend", "\', " + pheight + " , " + pwidth + ", '" + thisType + "', 'yes');");                
                sFeat.set("pagetype", "_popup");
            DataCloud.instance().addFeature(sFeat);
        else:
            DataCloud.instance().removeFeature("relflags");

        #-------------- WEB LINKS -----------------
        if self.cb41.GetValue()==1:
            #retrieve button or thumbnail
            type = "button";
            sFeat = Features("relweblinks");
            sFeat.clear();            
            #add in the related priority, thumbnail/button option.
            myFeat.set(str(self.tb42.GetValue()), "relweblinks_" + type + ".obj");
            DataCloud.instance().addFeature(sFeat);
        else:
            DataCloud.instance().removeFeature("relweblinks");
        #-------------- ARTWORK ---------------------
        if self.cb51.GetValue()==1:
            #retrieve button or thumbnail
            type = self.rb5.GetStringSelection().lower();
            #add in the related priority, thumbnail/button option.
            myFeat.set(str(self.tb52.GetValue()), "relartwork_" + type + ".obj");

            #set the specific features items;
            sFeat = Features("relartwork");
            sFeat.clear();            
            if (self.rb5.GetSelection()==1):
                sFeat.set("max", str(self.tb51.GetValue()));
            thisType = self.RetrieveTypeFromXML("artwork");                
            sFeat.set("type", thisType);
            sFeat.set("moreflag", "y");

            whtuple  = self.RetrievePopupSizingfromXML("artwork");
            pwidth = str(whtuple[0]);
            pheight = str(whtuple[1]);

            #check popup status
            if self.cb53.GetValue()==1:
                #only use if this is to be displayed in a popup
                sFeat.set("popupbegin", 'javascript:OpenBlurbWindow(\'');
                sFeat.set("popupend", "\', " + pheight + " , " + pwidth + ", '" + thisType + "', 'yes');");
                sFeat.set("pagetype", "_popup");
            DataCloud.instance().addFeature(sFeat);
        else:
            DataCloud.instance().removeFeature("relartwork");

        #-------------- TABLES ---------------
        if self.cb61.GetValue()==1:
            #retrieve button or thumbnail
            type = "button";
            #add in the related priority, thumbnail/button option.
            myFeat.set(str(self.tb62.GetValue()), "reltables_" + type + ".obj");

            #set the specific features items;
            sFeat = Features("reltables");
            sFeat.clear();
            thisType = self.RetrieveTypeFromXML("table");            
            sFeat.set("type", thisType);
            sFeat.set("moreflag", "y");
            
            whtuple  = self.RetrievePopupSizingfromXML("table");
            pwidth = str(whtuple[0]);
            pheight = str(whtuple[1]);
            
            #check popup status
            if self.cb63.GetValue()==1:
                #only use if this is to be displayed in a popup
                sFeat.set("popupbegin", 'javascript:OpenBlurbWindow(\'');
                sFeat.set("popupend", "\', " + pheight + " , " + pwidth + ", '" + thisType + "', 'yes');");
                sFeat.set("pagetype", "_popup");
            DataCloud.instance().addFeature(sFeat);
        else:
            DataCloud.instance().removeFeature("reltables");            
            
        #-------------- FACT BOXES  ---------------
        if self.cb71.GetValue()==1:
            #retrieve button or thumbnail
            type = "button";
            #add in the related priority, thumbnail/button option.
            myFeat.set(str(self.tb72.GetValue()), "relfactboxes_" + type + ".obj");

            #set the specific features items;
            sFeat = Features("relfactboxes");
            sFeat.clear();            
            thisType = self.RetrieveTypeFromXML("factbox");
            sFeat.set("type", thisType);
            sFeat.set("moreflag", "y");

            whtuple  = self.RetrievePopupSizingfromXML("factbox");
            pwidth = str(whtuple[0]);
            pheight = str(whtuple[1]);

            #check popup status
            if self.cb73.GetValue()==1:
                #only use if this is to be displayed in a popup
                sFeat.set("popupbegin", 'javascript:OpenBlurbWindow(\'');
                sFeat.set("popupend", "\', " + pheight + " , " + pwidth + ", '" + thisType + "', 'yes');");
                sFeat.set("pagetype", "_popup");
            DataCloud.instance().addFeature(sFeat);
        else:
            DataCloud.instance().removeFeature("relfactboxes");               
        #-------------- BIBLIOS  ------------------
        if self.cb81.GetValue()==1:
            #retrieve button or thumbnail
            type = "button";
            #add in the related priority, thumbnail/button option.
            myFeat.set(str(self.tb82.GetValue()), "relbiblios_" + type + ".obj");

            #set the specific features items;
            sFeat = Features("relbiblios");
            sFeat.clear();            
            sFeat.set("max", "1");
            thisType = self.RetrieveTypeFromXML("biblio");            
            sFeat.set("type", thisType);
            sFeat.set("moreflag", "y");
            
            whtuple  = self.RetrievePopupSizingfromXML("biblio");
            pwidth = str(whtuple[0]);
            pheight = str(whtuple[1]);
            
            #check popup status
            if self.cb83.GetValue()==1:
                #only use if this is to be displayed in a popup
                sFeat.set("popupbegin", 'javascript:OpenBlurbWindow(\'');
                sFeat.set("popupend", "\', " + pheight + " , " + pwidth + ", '" + thisType + "', 'yes');");
                sFeat.set("pagetype", "_popup");
            DataCloud.instance().addFeature(sFeat);
        else:
            DataCloud.instance().removeFeature("relbiblios");
        #-------------- RELARTS  ------------------
        if self.cb91.GetValue()==1:
            #retrieve button or thumbnail
            type = "button";
            #add in the related priority, thumbnail/button option.
            myFeat.set(str(self.tb92.GetValue()), "relarts_" + type + ".obj");

            #set the specific features items;
            sFeat = Features("relarts");
            sFeat.clear();
            sFeat.set("max", "1");
            thisType = self.RetrieveTypeFromXML("relarts");
            sFeat.set("type", thisType);
            #check popup status
            popstatus = "_fullpage";

            whtuple  = self.RetrievePopupSizingfromXML("relarts");
            pwidth = str(whtuple[0]);
            pheight = str(whtuple[1]);
            
            if self.cb93.GetValue()==1:
                #only use if this is to be displayed in a popup
                sFeat.set("popupbegin", 'javascript:OpenBlurbWindow(\'');
                sFeat.set("popupend", "\', " + pheight + " , " + pwidth + ", '" + thisType + "', 'yes');");
                sFeat.set("pagetype", "_popup");
                popstatus = "_popup";
            DataCloud.instance().addFeature(sFeat);

            #write out the relatedarticles feature. This is also based on RELARTS.
            artFeat = Features("relatedarticles");
            artFeat.set("articleslist", "relatedarticleslist"+popstatus+".include");
            DataCloud.instance().addFeature(artFeat);
        else:
            DataCloud.instance().removeFeature("relarts");
            DataCloud.instance().removeFeature("relatedarticles");
        #-------------- RELPFE  ------------------
        #this should always be set - you always have PFE.
        if self.cb111.GetValue()==1:
            myFeat.set(self.tb112.GetValue(), "relpfe_button.obj");

            sFeat = Features("relpfe");
            sFeat.clear();

            #for graphical, pfe is always in a popup. ADA will ignore this.
            #sFeat.set("popupbegin", 'javascript:OpenBlurbWindow(\'');
            #sFeat.set("popupend", "\', 700, 500, '" + "pfe" + "', 'yes');");
            #sFeat.set("pagetype", "_popup");
            DataCloud.instance().addFeature(sFeat);
            
            
        #------------------END OF RELATED ASSETS -----------------
        #add the related assets feature to the datacloud.
        DataCloud.instance().addFeature(myFeat);
        DataCloud.instance().printFeatures();

        return status;
    
    def _save(self):
        status = self.updateDataCloud();
        if (status == false):
            return status;
        
        DataCloud.instance().add("ArticleGood", "true");
        DataCloud.instance().commit();

        #in the end, Product is the only one who saves this.
        pcode = (DataCloud.instance().value("pcode"));
        if (pcode == None):
            Log.instance().add("There is no product code for this DataCloud.", Log.instance().bitMaskCriticalAll());
            status = false;
            return status;
        DataCloud.instance().save(pcode);

        #do this so if someone re-enters the article gui, it'll load the values that have just been saved to the datacloud.
        DataCloud.instance().addNS("mode", "edit");
        #print "status="+str(status);
        DataCloud.instance().notify(self);
        Log.instance().add("Ready to save information", Log.instance().bitMaskWarningAll());

        
        myTC = TemplateController("article");
        myTC.process();
        return status;
    
    def preview(self, event):
        if (self.performSanityCheck()==true):
            self.updateDataCloud();
            myTC = TemplateController("article", "preview");
            myTC.process();
            print "Article GUI Preview Button Pressed";

    
    def help(self, event):
        self.load();
        os.system("mozilla '/home/qadevWS/python/radtools/Packages/Panels/Help/article.html'");

    def _show(self):
        self.statusbar.SetStatusText("Article");
        #set up all of the controls;
        mainsizer = wxBoxSizer(wxVERTICAL);
        
        #Create IDs for controls, row by row
        [ddl1ID, ddl2ID,
         cb11ID, rb1ID, cb12ID, tb11ID, tb12ID, cb13ID,
         cb21ID, rb2ID, cb22ID, tb21ID, tb22ID, cb23ID,
         cb31ID, rb3ID, cb32ID, tb31ID, tb32ID, cb33ID,
         cb41ID, tb42ID,
         cb51ID, rb5ID, cb52ID, tb51ID, tb52ID, cb53ID,
         cb61ID, tb61ID, tb62ID, cb63ID,
         cb71ID, tb72ID, cb73ID,
         cb81ID, tb82ID, cb83ID,
         cb91ID, tb92ID, cb93ID,
         cb103ID,
         cb111ID, tb112ID]= map(lambda x: wxNewId(), range(44))
        
        radioboxChoices = ["Button", "Thumbnail"];
        radioboxSizes = wxSize(175, 40);
        
        nulltext = wxStaticText(self.panel, -1, "");
        
        #set up the flex sizer header columns
        self.flexsizer = wxFlexGridSizer(11, 6, self.articleborder, self.articleborder);
        staticwin2 = wxStaticText(self.panel, -1, "Available");
        staticwin3 = wxStaticText(self.panel, -1, "Display as");
        staticwin4 = wxStaticText(self.panel, -1, "Thumbnail\nquantity");
        staticwin5 = wxStaticText(self.panel, -1, "Priority");
        staticwin6 = wxStaticText(self.panel, -1, "Popup");
        self.CreateRow("Related asset types", staticwin2, -1, staticwin3, -1, staticwin4, -1, staticwin5, -1, staticwin6, -1);

        #create the constant for the length of the text box max length
        TEXTBOXMAXLENGTH = 1;

        #add the first row of items (Pictures)
        self.cb11 = CheckBox(self.panel, self, cb11ID, "");
        self.rb1 = RadioBox(self.panel, self, rb1ID, "Choose one", radioboxChoices, 1, wxRA_SPECIFY_ROWS)
        self.tb11 = TextBox(self.panel, self, tb11ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY))
        self.tb12 = TextBox(self.panel, self, tb12ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb11.SetMaxLength(TEXTBOXMAXLENGTH);
        self.tb12.SetMaxLength(TEXTBOXMAXLENGTH);
        self.cb13 = CheckBox(self.panel, self, cb13ID, "Page && List");
        self.CreateRow("Pictures", self.cb11, cb11ID, self.rb1, rb1ID, self.tb11, tb11ID, self.tb12, tb12ID, self.cb13, cb13ID);

        #add the second row of items (Maps)
        self.cb21 = CheckBox(self.panel, self, cb21ID, "");
        self.rb2 = RadioBox(self.panel, self, rb2ID, "Choose one", radioboxChoices, 1, wxRA_SPECIFY_ROWS)
        self.tb21 = TextBox(self.panel, self, tb21ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb22 = TextBox(self.panel, self, tb22ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb21.SetMaxLength(TEXTBOXMAXLENGTH);
        self.tb22.SetMaxLength(TEXTBOXMAXLENGTH);
        self.cb23 = CheckBox(self.panel, self, cb23ID, "Page && List");
        self.CreateRow("Maps", self.cb21, cb21ID, self.rb2, rb2ID, self.tb21, tb21ID, self.tb22, tb22ID, self.cb23, cb23ID);

        #add the 3rd row of items (Flags)
        self.cb31 = CheckBox(self.panel, self, cb31ID, "");
        self.rb3 = RadioBox(self.panel, self, rb3ID, "Choose one", radioboxChoices, 1, wxRA_SPECIFY_ROWS)
        self.tb31 = TextBox(self.panel, self, tb31ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb32 = TextBox(self.panel, self, tb32ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb31.SetMaxLength(TEXTBOXMAXLENGTH);
        self.tb32.SetMaxLength(TEXTBOXMAXLENGTH);
        self.cb33 = CheckBox(self.panel, self, cb33ID, "Page && List");
        self.CreateRow("Flags", self.cb31, cb31ID, self.rb3, rb3ID, self.tb31, tb31ID, self.tb32, tb32ID, self.cb33, cb33ID);       

        #add the 5th row (Artwork)
        self.cb51 = CheckBox(self.panel, self, cb51ID, "");
        self.rb5 = RadioBox(self.panel, self, rb5ID, "Choose one", radioboxChoices, 1, wxRA_SPECIFY_ROWS)
        self.tb51 = TextBox(self.panel, self, tb51ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb52 = TextBox(self.panel, self, tb52ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb51.SetMaxLength(TEXTBOXMAXLENGTH);
        self.tb52.SetMaxLength(TEXTBOXMAXLENGTH);
        self.cb53 = CheckBox(self.panel, self, cb53ID, "Page && List");
        self.CreateRow("Artwork", self.cb51, cb51ID, self.rb5, rb5ID, self.tb51, tb51ID, self.tb52, tb52ID, self.cb53, cb53ID);       

        #I deliverately swapped the order of these two rows so I could display
        #all the rows that have thumbnail items before the ones that don't.
        #add the 4th row of items (Web Links)
        self.cb41 = CheckBox(self.panel, self, cb41ID, "");
        self.thumbnails1 = "";
        self.tb42 = TextBox(self.panel, self, tb42ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb42.SetMaxLength(TEXTBOXMAXLENGTH);
        staticwin = wxStaticText(self.panel, -1, "Button only");
        self.CreateRow("Web Links", self.cb41, cb41ID, staticwin, -1, nulltext, -1, self.tb42, tb42ID, nulltext, -1);       

        #add the 6th row of items (Tables)
        self.cb61 = CheckBox(self.panel, self, cb61ID, "");
        self.tb62 = TextBox(self.panel, self, tb62ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb62.SetMaxLength(TEXTBOXMAXLENGTH);
        staticwin = wxStaticText(self.panel, -1, "Button only");
        self.cb63 = CheckBox(self.panel, self, cb63ID, "Page && List");
        self.CreateRow("Tables", self.cb61, cb61ID, staticwin, -1, nulltext, -1, self.tb62, tb62ID, self.cb63, cb63ID);

        #add the 7th row of items (Fact Boxes)
        self.cb71 = CheckBox(self.panel, self, cb71ID, "");
        self.tb72 = TextBox(self.panel, self, tb72ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb72.SetMaxLength(TEXTBOXMAXLENGTH);
        staticwin = wxStaticText(self.panel, -1, "Button only");
        self.cb73 = CheckBox(self.panel, self, cb73ID, "Page && List");
        self.CreateRow("Fact Boxes", self.cb71, cb71ID, staticwin, -1, nulltext, -1, self.tb72, tb72ID, self.cb73, cb73ID);

        #add the 8th row of items (Bibliographies)
        self.cb81 = CheckBox(self.panel, self, cb81ID, "");
        self.tb82 = TextBox(self.panel, self, tb82ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb82.SetMaxLength(TEXTBOXMAXLENGTH);
        staticwin = wxStaticText(self.panel, -1, "Button only");
        self.cb83 = CheckBox(self.panel, self, cb83ID, "Page && List");
        self.CreateRow("Bibliographies", self.cb81, cb81ID, staticwin, -1, nulltext, -1, self.tb82, tb82ID, self.cb83, cb83ID);

        #add the 9th row of items (Related Articles)
        self.cb91 = CheckBox(self.panel, self, cb91ID, "");
        self.tb92 = TextBox(self.panel, self, tb92ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.tb92.SetMaxLength(TEXTBOXMAXLENGTH);    
        staticwin = wxStaticText(self.panel, -1, "Button only");
        self.cb93 = CheckBox(self.panel, self, cb93ID, "List Only");
        self.CreateRow("Related Articles", self.cb91, cb91ID, staticwin, -1, nulltext, -1, self.tb92, tb92ID, self.cb93, cb93ID);        

        #add the 10th row of items (Search)
        self.cb103 = CheckBox(self.panel, self, cb103ID, "Page");
        self.CreateRow("Advanced Search", nulltext, -1, nulltext, -1, nulltext, -1, nulltext, -1, self.cb103, cb103ID);

        #add the 11th row of items (printer friendly)
        self.cb111 = CheckBox(self.panel, self, cb111ID, "");
        self.cb111.SetCheckboxValue(1);
        self.cb111.Enable(0);
        self.tb112 = TextBox(self.panel, self, tb112ID, wxTE_RIGHT, "0", giValidator(DIGIT_ONLY));
        self.CreateRow("Printer Friendly", self.cb111, cb111ID, nulltext, -1, nulltext, -1, self.tb112, tb112ID, nulltext, -1);

       # build mapping of controls into function all dictionary
        articleColleagueMap = { self.cb11 : self._PicturesAvailableChecked,
                                self.rb1  : self._PicturesDisplayHasChanged,
                                self.cb21 : self._MapsAvailableChecked,
                                self.rb2  : self._MapsDisplayHasChanged,
                                self.cb31 : self._FlagsAvailableChecked,
                                self.rb3  : self._FlagsDisplayHasChanged,
                                self.cb41 : self._WebLinksAvailableChecked,
                                self.cb51 : self._ArtworkAvailableChecked,
                                self.rb5  : self._ArtworkDisplayHasChanged,
                                self.cb61 : self._TablesAvailableHasChanged,
                                self.cb71 : self._FactboxesAvailableHasChanged,
                                self.cb81 : self._BibliosAvailableHasChanged,
                                self.cb91 : self._RelArtsAvailableHasChanged
                                };
        self._colleagueMap.update(articleColleagueMap);
        
        #add everyone to a sizer.
        templateheader = "Select a Template:";
        self.templateDict = FeatureTemplateShells("article").getList();
        #self.templateDict = None;
        if (self.templateDict == None):
            self.templateDict = {};
        self.templateOptions = self.templateDict.values();
        self.templateKeys = self.templateDict.keys();
##        print "templateDict";
##        print self.templateDict;
##        print "templateOptions";
##        print self.templateOptions;
##        print "templateKeys";
##        print self.templateKeys;
        self.templateOptions.insert(0, templateheader);
        browseOptions = ["Select a Browse Type:", "Alpha Browse", "Hierarchical Browse", "Subject Browse"];
        self.ddl1 = DropDownList(self.panel, self, ddl1ID, self.templateOptions);
        self.ddl2 = DropDownList(self.panel, self, ddl2ID, browseOptions);
        hsizer= wxBoxSizer(wxHORIZONTAL);
        hsizer.Add(self.ddl1, option = 0, flag =  wxALL | wxALIGN_LEFT,  border = self.articleborder);
        hsizer.Add(self.ddl2, option = 0, flag =  wxALL | wxALIGN_LEFT,  border = self.articleborder);
        mainsizer.Add(hsizer, option = 0, flag =  wxALL | wxALIGN_LEFT,  border = self.articleborder);
        mainsizer.Add(self.flexsizer, option = 1, flag =  wxALL | wxALIGN_LEFT,  border = self.articleborder);
        self.windowsize=wxSize(550, 500);
        #because I'm AR, I move the window to a point on the screen where I can constantly see it.
        self.Move((400,50));
        self.Layout();

        #are we in edit mode? If so, feel free to load up the data from the DataCloud.
        modeType = DataCloud.instance().valueNS("mode");
        print modeType;
        if (modeType != None):
            if (modeType == "edit"):
                print "In edit mode";
                self.load();

        self.InitializeControls();
        return mainsizer;

    def cancel(self, event):
        #GUI.cancel(self, event);
        result = GUI.cancel(self, event);

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


    #here, I turn on and off banks of controls based on whether or not the "Available" checkbox is selected (this is good for new products or even edit mode).
    def InitializeControls(self):
        val = self.cb11.GetValue();
        self.__EnableControls([self.rb1, self.tb11, self.tb12, self.cb13], val);        
        val = self.cb21.GetValue();
        self.__EnableControls([self.rb2, self.tb21, self.tb22, self.cb23], val);
        val = self.cb31.GetValue();
        self.__EnableControls([self.rb3, self.tb31, self.tb32, self.cb33], val);
        val = self.cb41.GetValue();
        self.__EnableControls([self.tb42], val);
        val = self.cb51.GetValue();
        self.__EnableControls([self.rb5, self.tb51, self.tb52, self.cb53], val);
        val = self.cb61.GetValue();
        self.__EnableControls([self.tb62, self.cb63], val);
        val = self.cb71.GetValue();
        self.__EnableControls([self.tb72, self.cb73], val);
        val = self.cb81.GetValue();
        self.__EnableControls([self.tb82, self.cb83], val);
        val = self.cb91.GetValue();
        self.__EnableControls([self.tb92, self.cb93], val);

        
    #################################### SUBJECT / OBSERVER FUNCTIONALITY BEGINS ###########################################
    def update(self):
        #self.statusbar("time to update from the data cloud!");
        mesg = wxMessageDialog(self, "Time to update the Article GUI from the datacloud!","Information", wxCENTER | wxOK | wxICON_INFORMATION);
        mesg.ShowModal();
        
    #################################### COLLEAGUE / MEDIATOR FUNCTIONALITY BEGINS ###########################################

    #I can use this function to Enable or Disable a bank of controls, just by passing it a state.
    #state can be 0/1, true/false. Anything else you pass it, you're playing with fire.
    def __EnableControls(self, controllist, state):
        for x in controllist:
            x.Enable(state);

    def _PicturesAvailableChecked(self, event):
        val = self.cb11.GetValue();
        self.__EnableControls([self.rb1, self.tb11, self.tb12, self.cb13], val);
        #let the thumbnails qty box change only if we've enabled the entire row
        if (val == 1):
            self._PicturesDisplayHasChanged(event);
        
    def _PicturesDisplayHasChanged(self, event):
        val = self.rb1.GetSelection();
        self.__EnableControls([self.tb11], val);
        
    def _MapsAvailableChecked(self, event):
        val = self.cb21.GetValue();
        self.__EnableControls([self.rb2, self.tb21, self.tb22, self.cb23], val);
        #let the thumbnails qty box change only if we've enabled the entire row
        if (val == 1):
            self._MapsDisplayHasChanged(event);
        #Log.instance().add("Enabling/Disabling controls based on Maps: " + str(val), Log.instance().bitMaskCriticalScreen());
        
    def _MapsDisplayHasChanged(self, event):
        val = self.rb2.GetSelection();
        self.__EnableControls([self.tb21], val);

    def _FlagsAvailableChecked(self, event):
        val = self.cb31.GetValue();
        self.__EnableControls([self.rb3, self.tb31, self.tb32, self.cb33], val);
        #let the thumbnails qty box change only if we've enabled the entire row
        if (val == 1):
            self._FlagsDisplayHasChanged(event);
        #Log.instance().add("Enabling/Disabling controls based on Flags: " + str(val));
        
    def _FlagsDisplayHasChanged(self, event):
        val = self.rb3.GetSelection();
        self.__EnableControls([self.tb31], val);

    def _WebLinksAvailableChecked(self, event):
        val = self.cb41.GetValue();
        self.__EnableControls([self.tb42], val);

    def _ArtworkAvailableChecked(self, event):
        val = self.cb51.GetValue();
        self.__EnableControls([self.rb5, self.tb51, self.tb52, self.cb53], val);
        #let the thumbnails qty box change only if we've enabled the entire row
        if (val == 1):
            self._ArtworkDisplayHasChanged(event);

    def _ArtworkDisplayHasChanged(self, event):
        val = self.rb5.GetSelection();
        self.__EnableControls([self.tb51], val);

    def _TablesAvailableHasChanged(self, event):
        val = self.cb61.GetValue();
        self.__EnableControls([self.tb62, self.cb63], val);
        
    def _FactboxesAvailableHasChanged(self, event):
        val = self.cb71.GetValue();
        self.__EnableControls([self.tb72, self.cb73], val);
        
    def _BibliosAvailableHasChanged(self, event):
        val = self.cb81.GetValue();
        self.__EnableControls([self.tb82, self.cb83], val);
        
    def _RelArtsAvailableHasChanged(self, event):
        val = self.cb91.GetValue();
        self.__EnableControls([self.tb92, self.cb93], val);


    #################################### COLLEAGUE / MEDIATOR FUNCTIONALITY ENDS  #############################################    
class ArticleGUIApp(wxApp):
    def OnInit(self):
        DataCloud.instance().load("eas");
        DataCloud.instance().add("ptitle", "Encyclopedia of American Studies");
        DataCloud.instance().addNS("mode", "edit");
        frame = ArticleGUI(NULL, "Article Generator");
        frame.show();
        self.SetTopWindow(frame)
        return true


#---------------------------------------------
# Create and run our main app
#---------------------------------------------
if __name__ == "__main__":
    import DataCloud
    ScreenLogGUI.displayScreenLog();
    app = ArticleGUIApp(0);
    app.MainLoop()

    
