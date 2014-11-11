<?php

    require_once($_SERVER['PHP_INCLUDE_HOME'] . '/common/GI_Base/package.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'] . '/common/utils/GI_Hash.php');

/**
 * LP_TextChunk
 *
 * A class for wrangling the 'Culture Cross' chunks of articles
 *
 * 
 */
class LP_TextChunk extends GI_Base{

    /**
     * The contents of the chunk file, or an error message
     */
    protected $_content = "LP_TextChunk content error.";

    /**
     * Hash of lists: The 'official' chunk code is the key, and a list of the html comment
     * tags which would be considered a match
     */
    protected $_codes = array(
                            'land'      =>  array('land', 'land-people', 'land-econ', 'land-hist'),
                            'people'    =>  array('people', 'land-people', 'people-econ', 'people-hist'),
                            'economy'   =>  array('econ', 'land-econ', 'people-econ', 'hist-econ'),
                            'history'   =>  array('hist', 'land-hist', 'people-hist', 'hist-econ')
                            );

    /**
     * The constructor
     *
     * If the file for the desired chunk does not already exist in the
     * CS_DOCS_ROOT directory, create it.
     *
     * @param   var $slpid      The slpid of the main article
     * @param   var $chunkid    The id of the desired chunk
     *
     */
    public function __construct($slpid, $chunkid){

        // First, we need to determine the fully-pathed filename for the chunk file
        $chunkFileName = $slpid . '-' . $chunkid . '.html';
        $hashRoot = $_SERVER['CS_DOCS_ROOT'] . '/text';
        $myHash = new GI_Hash($hashRoot);
        $chunkDir = $hashRoot . '/' . $myHash->hval($chunkFileName);
        $chunkFile = $chunkDir . '/' . $chunkFileName;

        // If this file already exists, just read its contents.
        if (file_exists($chunkFile)){
            $this->_content = file_get_contents($chunkFile);
        }
        else {
            // If the file doesn't exist, we'll need to create it.


            include_once($_SERVER['PHP_INCLUDE_HOME'] . '/common/article/GI_TransText.php');

            // We'll probably need a custom 'detagger' config for Culture Cross, but let's just use the 'article' one for now
            // We have a custom detagger config now: lp_0ta_cc
            $ttParms = array (
                            CS_PRODUCTID    =>  'lp',
                            CS_GTYPE        =>  '0ta',
                            NGO_PRODUCTID   =>  'lp',
                            NGO_GTYPE       =>  'cc',
                            GI_ASSETID      =>  $slpid
                            );

            $myTextAsset = new GI_TransText($ttParms);

            // Was there an error on the fetch?
            if (GI_Base::IsError($myTextAsset)) {
                $this->_content = "GI_TransText error.";
            }
            else {
                // Now we want to chase down the chunk
                if (array_key_exists($chunkid, $this->_codes)) {
                    // look for each chunk which would be a match for this base code.
                    $foundChunk = false;
                    foreach ($this->_codes[$chunkid] as $chunkCode) {
                        $regexPat = "/<!--gf:{$chunkCode}-->(.*?)<!--\/gf:{$chunkCode}-->/s";
                        if (preg_match($regexPat, $myTextAsset->output(), $matches)) {
                            $this->_content = $matches[1];
                            $foundChunk = true;
                            break;
                        }
                    }

                    // Now we want to save the chunk
                    if ($foundChunk) {
                        //If the chunk directory doesn't exist, create it
                        if (!file_exists($chunkDir)){
                            mkdir($chunkDir);
                        }
                        if ($fhand = fopen($chunkFile, 'w')) {
                            fwrite($fhand, $this->_content);
                            fclose($fhand);
                        }
                    }
                }
                else {
                    $this->_content = "LP_TextChunk(): invalid chunk code '{$chunkid}'";
                }
            }
        }
    }


    /**
     * Fetch the object's content data (the chunk or an error message)
     *
     * @return  var Content or error message string
     *
     */
    public function getOutput(){
        return $this->_content;
    }


    /**
     * Output the object's content data (the chunk or an error message)
     */
    public function output(){
        echo $this->getOutput();
    }

}

?>
