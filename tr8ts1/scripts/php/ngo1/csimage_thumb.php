<?php
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common//GI_Constants.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_MediaAsset.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_Hash.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_getVariable.php');
	require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_ThumbGen.php');

    $pictureAsset = new GI_ThumbGen($_GET['productid'],$_GET['slpid'], $_GET['fext'], 'jpg');

    if (GI_Base::isError($pictureAsset)) {
                echo "<p>Unable to fetch image</p>";
                exit(0);
            }

         switch(strtolower($ext)) {
            case 'jpg':
                $imageType = 'jpeg';
                break;
            case 'gif':
                $imageType = 'gif';
                break;
            case 'png':
                $imageType = 'png';
                break;
            default:
                $imageType = 'jpeg';
        }
    
        header("Content-type: image/" . $imageType);
        readfile($imagePath);
 ?>
