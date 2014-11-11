<?php
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_CollectiveHandler.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_BinaryAsset.php');

/**
 * Class for picking bits out of a *FLIX Pair Collective
 *
 * @author  R.E. Dye <rdye@scholastic.com>
 */
class PairCollectiveHandler extends GI_CollectiveHandler{

    /**
     * Constructor
     *
     * Takes two optional parameters.
     * If only one paramter is supplied, it should be the filename of the XML file.
     * If two parameters are supplied, the first should be the asset id of the XML file
     * on the content server, and the second should be the code of the product that
     * owns the XML file asset.
     *
     * @param   string  $inFilenameAssetID      File name or asset id
     * @param   string  $inPcode                Product code
     */
    public function __construct($inFilenameAssetID="", $inPcode=""){
        // Invoke the parent constructor
        parent::__construct($inFilenameAssetID, $inPcode);
    }


    /**
     * Determine if the pair has a book in the specified language
     *
     * @param   string  $inLanguage     'es' or 'en' for now.
     * @return  boolean     Has it or not.
     */
    public function hasBook($inLanguage){
        $outResult = false;
        foreach ($this->_collective->books->book as $book) {
            if ($book['language'] == $inLanguage) {
                $outResult = true;
            }
        }
        return $outResult;
    }


    /*
     * Determine if the pair has a story in the specified language
     *
     * @param   string  $inLanguage     'es' or 'en' for now.
     * @return  boolean     Has it or not.
     */
    public function hasStory($inLanguage){
        $outResult = false;
        foreach ($this->_collective->stories->story as $story){
            if ($story['language'] == $inLanguage) {
                $outResult = true;
                break;
            }
        }
        return $outResult;
    }


    /**
     * Get the id of the pair's book, by language
     *
     * @param   string  $inLanguage     Desired book language
     *
     * @return  string      Book ID (or '')
     */
    public function getBookId($inLanguage='en'){
        $outResult = "";

        foreach ($this->_collective->books->book as $book){
            if ($book['language'] == $inLanguage) {
                $outResult = $book->id;
                break;
            }
        }

        return $outResult;
    }


    /**
     * Fetch the lesson plan ID for the pair, if any
     *
     * For now, the language parameter doesn't do anything.  I have a feeling that
     * this function will need re-working (along with the 0cp spec), for Big Day.
     *
     * @param   string  $inLanguage     Desired language (default is English)
     * @return  string  lesson plan ID or ""
     */
    public function getLessonPlanId($inLanguage='en'){

        return $this->_collective->lessonplan->id;

    }




    /**
     * Find the title for the pair's story for the specified language
     * (default language is English)
     *
     * @param   string  $inLanguage     (optional) which language version to fetch title of
     * @return  string      Story title (or '')
     */
    public function getStoryTitle($inLanguage='en'){
        $outResult = "";
        foreach ($this->_collective->stories->story as $story){
            if ($story['language'] == $inLanguage) {
                $outResult = $story->title;
                break;
            }
        }
        return $outResult;
    }


    /**
     * Find the video id for a story, by language and highlighting option
     *
     * Find the ID for one of the pair's videos by specifying language, and if highlighting
     * ('read along') is 'y' or 'n'
     * default language is English
     * default highlighting is 'y'.
     *
     * @param   string  $inLanguage     Desired language
     * @param   string  $highlighting   read-along on?
     * @return  string      Video ID or ''.
     */
    public function getVideoId($inLanguage='en', $highlighting='y'){
        $outResult = "";

        foreach ($this->_collective->stories->story as $story){
            if ($story['language'] == $inLanguage) {
                if ($highlighting == 'n') {
                    $outResult = $story->video->id;
                }
                else {
                    $outResult = $story->video_highlighting->id;
                }
                break;
            }
        }

        return $outResult;
    }


    /**
     * Get the flipbook id for a book, by language
     * default language is English
     *
     * @param   string  $inLanguage     Desired language
     * @return  string      Flipbook ID or ''
     */
    public function getFlipbookId($inLanguage='en'){
        $outResult = "";
        foreach ($this->_collective->books->book as $book){
            if ($book['language'] == $inLanguage) {
                $outResult = $book->flipbook->id;
                break;
            }
        }
        return $outResult;
    }


    /**
     * Fetch the id of this pair's book jacket image
     *
     * @param   string  $inLanguage Which book version's jacket to fetch
     *                  Default is English
     * @return  string  Jacket id (or '').
     *
     */
    public function getBookJacketId($inLanguage='en'){
        $outResult = '';

        foreach ($this->_collective->books->book as $book) {
            if ($book['language'] == $inLanguage) {
                $outResult = $book->image->id;
                break;
            }
        }
        return $outResult;
    }


    /**
     * Fetch the id of this pair's story cover image
     *
     * @param   string  $inLanguage Which story version's cover to fetch
     *                  Default is English
     * @return  string  cover id (or '').
     *
     */
    public function getStoryCoverId($inLanguage='en'){
        $outResult = "";

        foreach ($this->_collective->stories->story as $story){
            if ($story['language'] == $inLanguage) {
                $outResult = $story->image->id;
                break;
            }
        }
        return $outResult;
    }


    /**
     * Fetch the Author Name (title) for a story, by language
     *
     * @param   string  $inLanguage     Which story version to use (default is English)
     *
     * @return  string      Author's name (or '')
     */
    public function getAuthorName($inLanguage='en'){
        $outResult = "";
        foreach ($this->_collective->stories->story as $story){
            if ($story['language'] == $inLanguage) {
                $outResult = $story->author->title;
                break;
            }
        }
        return $outResult;
    }


    /**
     * Fetch the Author id for a story, by language
     *
     * @param   string  $inLanguage     Which story version to use (default is English)
     *
     * @return  string      Author ID (or '')
     */
    public function getAuthorId($inLanguage='en'){
        $outResult = "";
        foreach ($this->_collective->stories->story as $story){
            if ($story['language'] == $inLanguage) {
                $outResult = $story->author->id;
                break;
            }
        }
        return $outResult;
    }


    /**
     * Fetch the Author photo Id for a given story, by story language
     *
     * If there is no author photo, use the story cover for that language.
     *
     * @param   string  $inLanguage     Which story version (default is English)
     *
     * @return  string      image id (author photo or story cover), or ''
     */
    public function getAuthorPhotoId($inLanguage='en'){
        $outResult = "";
        foreach ($this->_collective->stories->story as $story){
            if ($story['language'] == $inLanguage) {
                if ($imageId = $story->author->image->id) {
                    $outResult = $imageId;
                }
                else {
                    $outResult = $story->image->id;
                }
                break;
            }
        }
        return $outResult;
    }


    /**
     * Fetch the author bio narration ID for a given story, by story language
     *
     * @param   string  $inLanguage     Which story version (default is English)
     *
     * @return  string      Author narration ID (or '')
     */
    public function getAuthorAudioId($inLanguage='en'){
        $outResult = "";
        foreach ($this->_collective->stories->story as $story){
            if ($story['language'] == $inLanguage) {
                $outResult = $story->author->audio->id;
                break;
            }
        }
        return $outResult;
    }


    /**
     * Fetch the id of the Word Match Game, if any, for this pair by language
     *
     * @param   string  $inLanguage     Which book version's Word Match game to find
     *                                  default is English
     * @return  sring       The game ID, or empty string if none
     */
    function getWMGameId($inLanguage='en'){
        $outResult = "";

        foreach ($this->_collective->books->book as $book){
            if ($book['language'] == $inLanguage) {
                $outResult = $book->game->id;
                break;
            }
        }

        return $outResult;
    }

    /**
     * Fetch the id of the Sequence Game, if any, for this pair by language
     *
     * @param   string  $inLanguage     Which story version's Sequence game to find
     *                                  default is English
     * @return  sring       The game ID, or empty string if none
     */
    function getSQGameId($inLanguage='en'){
        $outResult = "";

        foreach ($this->_collective->stories->story as $story){
            if ($story['language'] == $inLanguage) {
                $outResult = $story->game->id;
                break;
            }
        }

        return $outResult;
    }

    /**
     * Fetch the id of the Fact or Fiction Game, if any, for this pair by language
     *
     * @param   string  $inLanguage     Which book version's Fact or Fiction game to find
     *                                  default is English
     * @return  sring       The game ID, or empty string if none
     */
    function getFFGameId($inLanguage='en'){
        $outResult = "";
        if ($this->_collective->games){
            foreach ($this->_collective->games->game as $game){
                if ($game['language'] == $inLanguage) {
                    $outResult = $game->id;
                    break;
                }
            }
        }

        return $outResult;
    }








}


?>
