import os;
import sys;
import re;

sys.path.append("/\search\scripts\python");

class GI_ProductNavigation:
    def __init__(self):
        self._productNavigationPaths = {};

        #atb rules
        self._productNavigationPaths['ama'] = {};
        self._productNavigationPaths['ama']['0ta'] = 'AMA//Articles ;; GO//Articles//AMA';
        self._productNavigationPaths['ama']['0taz'] = 'AMA//Articles ;; GO//Articles//AMA';

        #atb rules
        self._productNavigationPaths['atb'] = {};
        self._productNavigationPaths['atb']['0ta'] = 'ATB//Articles ;; GO//Articles//ATB';
        self._productNavigationPaths['atb']['b'] = self._productNavigationPaths['atb']['0ta'];
        self._productNavigationPaths['atb']['t'] = self._productNavigationPaths['atb']['0ta'];
        self._productNavigationPaths['atb']['h'] = self._productNavigationPaths['atb']['0ta'];

        #ea3 rules
        self._productNavigationPaths['ea'] = {};
        self._productNavigationPaths['ea']['0ta'] = 'EA//Articles ;; GO//Articles//EA';
        self._productNavigationPaths['ea']['t'] = self._productNavigationPaths['ea']['0ta'];

        #eas rules
        self._productNavigationPaths['eas'] = {};
        self._productNavigationPaths['eas']['0ta'] = 'EAS//Articles ;; GO//Articles//EAS';
        
        #gme3 rules
        self._productNavigationPaths['gme'] = {};
        self._productNavigationPaths['gme']['0ta'] = 'GME//Articles ;; GO//Articles//GME';
        self._productNavigationPaths['gme']['0taf'] = self._productNavigationPaths['gme']['0ta'];
        self._productNavigationPaths['gme']['0tat'] = self._productNavigationPaths['gme']['0ta'];

        self._productNavigationPaths['gme']['0mp'] = 'GME//Media';
        self._productNavigationPaths['gme']['0mf'] = self._productNavigationPaths['gme']['0mp'];
        self._productNavigationPaths['gme']['0mm'] = self._productNavigationPaths['gme']['0mp'];
        self._productNavigationPaths['gme']['0msa'] = self._productNavigationPaths['gme']['0mp'];
        self._productNavigationPaths['gme']['0msm'] = self._productNavigationPaths['gme']['0mp'];
        self._productNavigationPaths['gme']['0ua'] = self._productNavigationPaths['gme']['0mp'];
        self._productNavigationPaths['gme']['0uc'] = self._productNavigationPaths['gme']['0mp'];
        self._productNavigationPaths['gme']['0ud'] = self._productNavigationPaths['gme']['0mp'];
        self._productNavigationPaths['gme']['0up'] = self._productNavigationPaths['gme']['0mp'];
        self._productNavigationPaths['gme']['0uv'] = self._productNavigationPaths['gme']['0mp'];
        
        #nbk3 rules
        self._productNavigationPaths['nbk'] = {};
        self._productNavigationPaths['nbk']['0ta'] = 'NBK//Articles ;; GO//Articles//NBK';
        self._productNavigationPaths['nbk']['0taf'] = self._productNavigationPaths['nbk']['0ta'];

	#these are ancillary added materials that don't get globally searched
        self._productNavigationPaths['nbk']['0tae'] = 'NBK//Articles';
        self._productNavigationPaths['nbk']['0tai'] = self._productNavigationPaths['nbk']['0tae'];
        self._productNavigationPaths['nbk']['0taj'] = self._productNavigationPaths['nbk']['0tae'];
        self._productNavigationPaths['nbk']['0tap'] = self._productNavigationPaths['nbk']['0tae'];
        self._productNavigationPaths['nbk']['0taw'] = self._productNavigationPaths['nbk']['0tae'];
        self._productNavigationPaths['nbk']['0tax'] = self._productNavigationPaths['nbk']['0tae'];
        self._productNavigationPaths['nbk']['0tay'] = self._productNavigationPaths['nbk']['0tae'];

        self._productNavigationPaths['nbk']['0ma'] = 'NBK//Media';
        self._productNavigationPaths['nbk']['0mp'] = self._productNavigationPaths['nbk']['0ma'];

        self._productNavigationPaths['nbk']['0tdnd'] = 'NBK//News';
        self._productNavigationPaths['nbk']['0tdne'] = self._productNavigationPaths['nbk']['0tdnd'];
        self._productNavigationPaths['nbk']['0tdng'] = self._productNavigationPaths['nbk']['0tdnd'];
        self._productNavigationPaths['nbk']['0tdni'] = self._productNavigationPaths['nbk']['0tdnd'];
        self._productNavigationPaths['nbk']['0tdnk'] = self._productNavigationPaths['nbk']['0tdnd'];
        self._productNavigationPaths['nbk']['0tdnl'] = self._productNavigationPaths['nbk']['0tdnd'];
        self._productNavigationPaths['nbk']['0tdnn'] = self._productNavigationPaths['nbk']['0tdnd'];
        self._productNavigationPaths['nbk']['0tdnr'] = self._productNavigationPaths['nbk']['0tdnd'];
        self._productNavigationPaths['nbk']['0tdns'] = self._productNavigationPaths['nbk']['0tdnd'];
        self._productNavigationPaths['nbk']['0tdnt'] = self._productNavigationPaths['nbk']['0tdnd'];
        self._productNavigationPaths['nbk']['0tdnw'] = self._productNavigationPaths['nbk']['0tdnd'];
        
        #nbps2 rules
        self._productNavigationPaths['nbps'] = {};
        self._productNavigationPaths['nbps']['t'] = 'NBPS//Articles ;; GO//Articles//NBPS';
        self._productNavigationPaths['nbps']['g'] = 'NBPS//Articles ;; NBPS//Biographies ;; GO//Articles//NBPS';
        self._productNavigationPaths['nbps']['j'] = 'NBPS//Projects';
        self._productNavigationPaths['nbps']['r'] = 'NBPS//Articles';
        self._productNavigationPaths['nbps']['s'] = 'NBPS//Articles';
        self._productNavigationPaths['nbps']['z'] = 'NBPS//Articles';

        self._productNavigationPaths['nbps']['n'] = 'NBPS//News';
        self._productNavigationPaths['nbps']['u'] = self._productNavigationPaths['nbps']['n'];

        #lp2 rules
        self._productNavigationPaths['lp'] = {};
        self._productNavigationPaths['lp']['0ta'] = 'LP//Articles ;; GO//Articles//LP';
        self._productNavigationPaths['lp']['0taf'] = 'LP//Articles ;; GO//Articles//LP';
        self._productNavigationPaths['lp']['0tax'] = 'LP//Articles';
        self._productNavigationPaths['lp']['0tdn'] = 'LP//News';

        #nec2 rules - also delimited by set (cumbre vs. student)
        self._productNavigationPaths['nec'] = {};
        self._productNavigationPaths['nec']['0ta'] = 'NEC//Articles ;; GO//Articles//NEC';
        self._productNavigationPaths['nec']['0tas'] = 'NEC//Articles//Student ;; GO//Articles//NEC';
        self._productNavigationPaths['nec']['0tasp'] = 'NEC//Articles//Student ;; GO//Articles//NEC';

        self._productNavigationPaths['nec']['0mm'] = 'NEC//Media';
        self._productNavigationPaths['nec']['0mf'] = self._productNavigationPaths['nec']['0mm'];
        self._productNavigationPaths['nec']['0mp'] = self._productNavigationPaths['nec']['0mm'];
        self._productNavigationPaths['nec']['0mpl'] = self._productNavigationPaths['nec']['0mm'];
        self._productNavigationPaths['nec']['0msa'] = self._productNavigationPaths['nec']['0mm'];

        #atlas rules - this could also be broken down to the
        #different types of maps (historical, etc.) and the different 
        #types of spots (search spot, hot spot, navigational spot, 
        #etc).
        self._productNavigationPaths['atlas'] = {};
        self._productNavigationPaths['atlas']['map'] = 'GO//Atlas//Maps ;; LP//Atlas ;; GO//Media//Maps';	#go atlas is shared with lp and go media
        self._productNavigationPaths['atlas']['spot'] = 'GO//Atlas//Spots';

        #go media rules
        self._productNavigationPaths['media'] = {};
        self._productNavigationPaths['media']['0mf'] = 'GO//Media//Flags';
        self._productNavigationPaths['media']['0mp'] = 'GO//Media//Illustrations';
        self._productNavigationPaths['media']['0ma'] = 'GO//Media//Illustrations';
        self._productNavigationPaths['media']['0up'] = 'GO//Media//Panoramas';
        self._productNavigationPaths['media']['0uv'] = 'GO//Media//Videos';
        
        #gii rules
        self._productNavigationPaths['gii'] = {};
        self._productNavigationPaths['gii']['kids'] = 'GO//GII//Kids';
        self._productNavigationPaths['gii']['passport'] = 'GO//GII//Passport';

        #newsnow rules
        self._productNavigationPaths['newsnow'] = {};
        self._productNavigationPaths['newsnow']['kids'] = 'GO//NewsNow//Kids';
        self._productNavigationPaths['newsnow']['passport'] = 'GO//NewsNow//Passport';

        #magazine rules
        self._productNavigationPaths['magazines'] = {};
        self._productNavigationPaths['magazines']['kids'] = 'GO//Magazines//Kids';
        self._productNavigationPaths['magazines']['passport'] = 'GO//Magazines//Passport';
        
    def process(self, product, assetType):
        return self._productNavigationPaths[product][assetType];

#initialize the product navigation tree, once
giProductNavigation = GI_ProductNavigation();


class GI_PrepareContent:
    def __init__(self, directory, args):
        self._directory = directory;
        self._args = args;

    def process(self):
        print "Processing: " + str(self._args);
        os.path.walk(self._directory, self._visitDirectory, self._args);
           
    def _visitDirectory(self, args, dirname, files):
        for name in files:
            fullname = os.path.join(dirname, name);
        
            #make sure it's a file        
            if not os.path.isdir(fullname) and fullname.endswith('.html'):
                #look for asset type meta tag
                #determine product code (based on directory name)
                #populate product_navigation field
            
                #open existing content file
                fd = open( fullname, 'r' );
                content = fd.read(300000);
                fd.close();
    
                product = args[0];
                metaTag = args[1];
                
                #find the asset type parameter in the content,
                #accounts for all different kinds of spacing as well.
                assetTypes = re.findall("<meta name=[\"|]" + metaTag + "[\"|] content=[\"|]([0-9A-Za-z]*)\"[\/>| \/>]", content);

		assetType = None;

                try:
			assetType = assetTypes[0];
		except IndexError, message:
			print fullname + " has invalid content";
			pass;

                #determine the meta tag information that should be
                #generated for this asset based on it's source product 
                #and asset type
                try:
                    metaTag = '<meta name="product_navigation" content="%s"/>' % giProductNavigation.process(product, assetType);
		    if content.find('<meta name="product_navigation"') == -1:
			content = metaTag + content + "\n";
		    else:
			#meta tag already exists, replace it
			startpos = content.find('<meta name="product_navigation');
			endpos = content.find('/>', startpos);

			newcontent = content[0:startpos];
			newcontent += metaTag;
			newcontent += content[endpos+2:];

			content = newcontent;

		    fp = open(fullname, 'w');
		    fp.write(content);
		    fp.close();

                except KeyError, message:
                    print str(assetType) + " is missing";
                                    
if __name__ == '__main__':
    directoryPath = sys.argv[1];
    product_id = sys.argv[2];
    meta_field = sys.argv[3];

    prepareContent = GI_PrepareContent(directoryPath, [product_id, meta_field]);
    prepareContent.process();


