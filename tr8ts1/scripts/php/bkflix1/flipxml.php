<?php
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_getVariable.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/database/GI_ManifestMiner.php');   

	$pair_cat = GI_getvariable('category');
	$bkflixCodes = array();
    $db = NULL;

    # Find a list of bkflix* pcodes in this user's auids cookie.
    if (isset($_COOKIE['auids'])) {
        $subcookies = explode('|', $_COOKIE['auids']);
        foreach ($subcookies as $subcookie) {
            $cookie = explode('>', $subcookie);
            if (!(strpos($cookie[0], 'bkflix') === false)) {
                $pcode = explode('-', $cookie[0]);
                $bkflixCodes[] = $pcode[0];
            }
        }
    }

    /* Connect to the database */
    $db = DB::connect($_SERVER["DB_CONNECT_STRING"]);
	if (!DB::isError($db)) {
	    # Fetch a list of volumes
        $pcodesString = "";
        foreach ($bkflixCodes as $pcode) {
            if ($pcodesString) {
                $pcodesString .= ", ";
            }
            $pcodesString .= "'" . $pcode . "'";
        }

	    $qString = "select volume VOL from volumes where product_id in (" . $pcodesString . ")";
	    #echo "<!-- $qString -->\n";

        $result =& $db->query($qString);
        if (!DB::isError($result)) {
            $volumesString = "";
    		while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
    		    if ($volumesString) {
                    $volumesString .= ", ";
    		    }
                $volumesString .= "'" . $dbrow['VOL'] . "'";
    		}

            $result->free();
        }
        else {
            exit(0);
        }

        #echo "<!-- $volumesString -->";



        #$qString = "select m.title_ascii, m.slp_id SLPID, m.uid UID from manifest m, category_browse cb where cb.pid='" . $pair_cat . "' and cb.cid = m.slp_id and m.type='0p' and m.volume in (" . $volumesString . ")";
        #$qString .= " order by m.title_ascii";

        #$qString = "select pairs.slp_id SLPID, pairs.uid UID from category_browse cb, manifest pairs, manifest books";
        #$qString .= " where cb.pid='" . $pair_cat . "' and cb.cid=pairs.slp_id and pairs.type='0p' and books.puid=pairs.uid";
        #$qString .= " and books.type='0tl' and books.language='en' and pairs.volume in (" . $volumesString . ") order by books.title_ascii";

        $qString = "select m.slp_id SLPID, m.uid UID from manifest m, category_browse cb";
        $qString .= " where cb.pid='" . $pair_cat . "' and cb.cid = m.slp_id and m.type='0p' and m.volume in (" . $volumesString . ")";
        $qString .= " order by m.sort_order";

        #echo "<!-- $qString -->\n";

        $result =& $db->query($qString);

		if (!DB::isError($result)) {
		    echo '<?xml version="1.0" standalone="yes"?>'."\n";
		    echo "<flipbook>\n";
		    echo '<pairs count="' . $result->numRows() . '">' . "\n";

		    $imageType = '0mpjd';

            # We need to process each pair in the category
    		while ($dbrow = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $pairMiner = new GI_ManifestMiner($dbrow['SLPID'], $dbrow['UID']);
            	if (!GI_ManifestMiner::iserror($pairMiner)) {

                    $stories = $pairMiner->getChildInfo('0tl');
                    $spanish = FALSE;
                    foreach ($stories as $story) {
                        if ($story['language'] == 'es') {
                            $spanish = TRUE;
                            #break;
                        }
                        else {
                            # we want to mine the English story for the cover image.
                            $storyToMine = $story;
                        }
                    }

                    if ($spanish) {
                        echo '<pair spanish="y">' . "\n";
                    }
                    else {
                        echo '<pair spanish="n">' . "\n";
                    }

                    echo "<link><![CDATA[/p/" . $pair_cat . "/" . $dbrow['UID'] . "/" . $dbrow['SLPID'] . "]]></link>\n";

                    $storyMiner = new GI_ManifestMiner($storyToMine['slp_id'], $storyToMine['uid']);
                	if (!GI_ManifestMiner::iserror($storyMiner))
	                {
       	                $cover = $storyMiner->getChildInfo($imageType, 0);
                        echo "<cover><![CDATA[/csimage?image=" . $cover['slp_id'] . "." . $cover['fext'] . "]]></cover>\n";
    	            }

                    # Find the English version of the book.
                    $books = $pairMiner->getChildInfo('0ta');

                    foreach ($books as $book) {
                        if ($book['language'] == 'en') {
                            break;
                        }
                    }

                    #echo "\n<!--\n";
                    #print_r($book);
                    #echo "\n-->\n";


                    # Find the jacket for this book
                    $bookMiner = new GI_ManifestMiner($book['slp_id'], $book['uid']);
                	if (!GI_ManifestMiner::iserror($bookMiner))
	                {
    	                $jacket = $bookMiner->getChildInfo($imageType, 0);
                        echo "<jacket><![CDATA[/csimage?image=" . $jacket['slp_id'] . "." . $jacket['fext'] . "]]></jacket>\n";
                        #echo "\n<!--\n";
                        #print_r($bookMiner);
                        #echo "\n-->\n";
                    }

                    echo "</pair>\n";
	            }
            }
            echo "</pairs>\n";
            echo "</flipbook>\n";

            $result->free();
        }
    }

?>
