<?php
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_getVariable.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/database/GI_ManifestMiner.php');   

    // Define some classes we'll be using locally


    class FlipXMLFeed {
        private $_language;
        private $_categories = array();
        private $_currentCategoryID;
        private $_currentCategoryNumber = 1;
        private $_errorMessage = "";
       
        public function __construct($inCategoryID, $inLanguage="en"){
            $this->_currentCategoryID = $inCategoryID;
            $this->_language = $inLanguage;

            // Connect to the database
            $db = DB::connect($_SERVER["DB_CONNECT_STRING"]);
	        if (!DB::isError($db)) {
	            // Find all of the categories (themes) in Big Day Bookflix, for this language, ordered by category number.
                $qstring = "select cid CATID, node_title TITLE, seq CATNUM from category_browse where pid in (select cid from category_browse where pid='" . $this->_language . "') order by seq";
                
                $result =& $db->query($qstring);
                if (!DB::isError($result)) {
                    while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                        // Instantiate a CategoryInfo object with the row's data, and save it in our array
                        $this->_categories[$dbrow['CATNUM']] = new CategoryInfo($db, $inLanguage, $dbrow['CATID'], $dbrow['CATNUM'], $dbrow['TITLE']);

                        // Is this the currently requested category?
                        if ($dbrow['CATID'] == $this->_currentCategoryID) {
                            // Yes, set the currently requested category number.
                            $this->_currentCategoryNumber = $dbrow['CATNUM'];
                        }
                    }
                    $result->free();
                }
                else {
                    $this->_errorMessage .= "Error in the category query.\n";
                }
                $db->disconnect();
	        }
	        else {
                $this->_errorMessage .= "Error connecting to database.\n";
	        }

            
        }

        public function outputXML(){
            echo $this->getXML();
            return;

            echo "<pre>\n";
            print_r($this);
            echo "\n</pre>\n";
        }

        public function getXML(){
            if ($this->_errorMessage) {
                return $this->_errorMessage;
            }

            $linkURL = 'p';
            if ($this->_language == 'es') {
                $linkURL = 'sp';
            }



            $outString = '<?xml version="1.0" standalone="yes" ?>' . "\n";
            $outString .= '<flipbook lang="' . $this->_language . '">' . "\n";
            $outString .= "\t" . '<themes count="' . count($this->_categories) . '" currenttheme="' . $this->_currentCategoryNumber . '">' . "\n";

            foreach ($this->_categories as $category) {
                $outString .= "\t\t" . '<theme title="' . $category->getTitle() . '">' . "\n";
                $outString .= "\t\t\t<!-- core -->\n";
                $outString .= "\t\t\t<pair>\n";
                $outString .= "\t\t\t\t<link><![CDATA[/" . $linkURL . "/" . $category->getID() . "/" . $category->getCorePairID() . "]]></link>\n";
                $outString .= "\t\t\t\t<cover><![CDATA[/csimage?product_id=allflix&id=" . $category->getCoreCoverID() . "&skipdb=y]]></cover>\n";
                $outString .= "\t\t\t\t<jacket><![CDATA[/csimage?product_id=allflix&id=" . $category->getCoreJacketID() . "&skipdb=y]]></jacket>\n";
                $outString .= "\t\t\t</pair>\n";


                $outString .= "\t\t\t<!-- tech -->\n";
                $outString .= "\t\t\t<pair>\n";
                $outString .= "\t\t\t\t<link><![CDATA[/" . $linkURL . "/" . $category->getID() . "/" . $category->getTechPairID() . "]]></link>\n";
                $outString .= "\t\t\t\t<cover><![CDATA[/csimage?product_id=allflix&id=" . $category->getTechCoverID() . "&skipdb=y]]></cover>\n";
                $outString .= "\t\t\t\t<jacket><![CDATA[/csimage?product_id=allflix&id=" . $category->getTechJacketID() . "&skipdb=y]]></jacket>\n";
                $outString .= "\t\t\t</pair>\n";



                $outString .= "\t\t</theme>\n";
            }

            $outString .= "\t</themes>\n";
            $outString .= "</flipbook>\n";
            return $outString;
        }
    }

    class CategoryInfo {
        private $_categoryID;
        private $_categoryNumber;
        private $_title;
        private $_corePair;
        private $_techPair;

        public function __construct($inDB, $inLanguage, $inCategoryID, $inCategoryNumber, $inTitle){
            $this->_categoryID = $inCategoryID;
            $this->_categoryNumber = $inCategoryNumber;
            $this->_title = $inTitle;

            // The category needs to find information about its pairs.
            $qstring = "select m.category BDCAT, m.slp_id SLPID, m.uid UID from manifest m, category_browse cb";
            $qstring .= " where cb.pid='" . $inCategoryID . "' and cb.cid = m.slp_id and m.type='0cp'";
            $result =& $inDB->query($qstring);
            if (!DB::isError($result)) {
                while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                    if ($dbrow['BDCAT'] == 'bd_core') {
                        $this->_corePair = new PairInfo($inDB, $inLanguage, $dbrow['SLPID'], $dbrow['UID']);
                    }
                    else if ($dbrow['BDCAT'] == 'bd_tech') {
                        $this->_techPair = new PairInfo($inDB, $inLanguage, $dbrow['SLPID'], $dbrow['UID']);
                    }
                }
            }
        }

        public function getTitle(){
            return $this->_title;
        }

        public function getID(){
            return $this->_categoryID;
        }

        public function getCorePairID(){
            return $this->_corePair->getID();
        }

        public function getTechPairID(){
            return $this->_techPair->getID();
        }

        public function getCoreCoverID(){
            return $this->_corePair->getCoverID();
        }

        public function getCoreJacketID(){
            return $this->_corePair->getJacketID();
        }

        public function getTechCoverID(){
            return $this->_techPair->getCoverID();
        }

        public function getTechJacketID(){
            return $this->_techPair->getJacketID();
        }

    }

    class PairInfo {
        private $_SLPID;
        private $_coverID;
        private $_jacketID;
        

        public function __construct($inDB, $inLanguage, $inSLPID, $inUID){
            $this->_SLPID = $inSLPID;
            $pairMiner = new GI_ManifestMiner($inSLPID, $inUID);
            if (!GI_ManifestMiner::iserror($pairMiner)) {

                // Handle the story
                $stories = $pairMiner->getChildInfo('0tl');
                foreach ($stories as $story) {
                    if ($story['language'] == $inLanguage) {
                        $storyToMine = $story;
                        break;
                    }
                }
                
                // Find the story cover image ID
                $storyMiner = new GI_ManifestMiner($storyToMine['slp_id'], $storyToMine['uid']);
                if (!GI_ManifestMiner::iserror($storyMiner)) {
                    #print_r($storyMiner);
                    $cover = $storyMiner->getChildInfo('0mpjd', 0);
                    $this->_coverID = $cover['slp_id'];
                }
                else {
                    echo "error instantiating story miner\n";
                }

                // Now we want to handle the book
                $books = $pairMiner->getChildInfo('0ta');
                foreach ($books as $book) {
                    if ($book['language'] == $inLanguage) {
                        $bookToMine = $book;
                        break;
                    }
                }

                // Now we want to find the book jacket image ID
                $bookMiner = new GI_ManifestMiner($bookToMine['slp_id'], $bookToMine['uid']);
                if (!GI_ManifestMiner::iserror($bookMiner)) {
                    $jacket = $bookMiner->getChildInfo('0mpjd', 0);
                    $this->_jacketID = $jacket['slp_id'];
                }
                else {
                    echo "error instantiating the book miner\n";
                }

            }
            else {
                echo "error instantiating pair miner\n";
            }
        }


        public function getID(){
            return $this->_SLPID;
        }

        public function getCoverID(){
            return $this->_coverID;
        }

        public function getJacketID(){
            return $this->_jacketID;
        }

    }


    // Main application starts here
	$pair_cat = GI_getvariable('category');
	if (!$language = GI_getvariable('lang')) {
        $language = 'en';
	}

    $myXMLFeed = new FlipXMLFeed($pair_cat, $language);

    $myXMLFeed->outputXML();


?>
