<?php
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common//GI_Constants.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/article/GI_MediaAsset.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_Hash.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_getVariable.php');

    $image = GI_getvariable('image');

    # Make sure that the filename only contains legal characters.
    if (preg_match("/^[\w.-]+$/", $image)) {
        $splitter = explode('.', $image);
        $id = $splitter[0];
        $ext = $splitter[1];

        # Where should the image reside?
        $imagePath = GI_hashFilename($image, "/data/bkflix1/docs/media");

        # Is the file there?
        if (!file_exists($imagePath)) {
            # Fetch the file from the content server
            $pictureParms = array(
                CS_PRODUCTID    =>  GI_PCODE_BKFLIX,
                CS_ASSETID      =>  $id,
                'fext'          =>  $ext
            );

            $pictureAsset = new GI_MediaAsset($pictureParms);

            if (GI_Base::isError($pictureAsset)) {
                echo "<p>Unable to fetch image</p>";
                exit(0);
            }

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

    }
?>
