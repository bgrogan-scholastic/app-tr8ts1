<?php

// define root map if nothing defined
define('ROOTMAP', 'mgwr016');
define('ROOTMAP_NEC', 'mgsp0122');

// define access to the PCODE in the environment
define('PCODE', $_SERVER["PCODE"]);

// for ada work
define('ADA', 'ada');

// various map types
define('ATLAS_GEOPOLITICAL', '0mmg');;
define('ATLAS_HISTORICAL', '0mmh');
define('ATLAS_THEMATIC', '0mmt');
define('ATLAS_EXPLORERS', '0mme');

// define some constants for various options url in the atlas
define('GO_PRODUCT_ID', 'go');
define('PRODUCTID', 'pid');
define('ASSET_ID', 'id');
define('MAP', 'map');

// option url param key/values
define('OPTION', 'op');
define('LATSLONGS', 'll');
define('LOCALDIST', 'ld');
define('GLOBALDIST', 'gd');
define('PRINTERFRIENDLY', 'pf');
define('ASSETLIST', 'al');
define('POI', 'poi');
define('TEMPLATENAME', 'tn');

// spot_id url param key for multiple asset list display from hotspot
define('SPOT_ID', 'spid');
define('SPOT_ID_ONE', 'spid1');
define('SPOT_ID_TWO', 'spid2');

// poi_id url param key poi assets
define('POI_ID', 'poid');

// define some constants for various fields in the map database
define('MAP_PRODUCT_NAME', 'description');
define('MAP_PRODUCT_ID', 'product_id');
define('MAP_ASSET_ID', 'asset_id');
define('MAP_TITLE', 'title');
define('MAP_TYPE', 'type');
define('MAP_SORT_TITLE', 'sort_title');
define('MAP_FEXT', 'fext');
define('MAP_CREDIT', 'credit');
define('MAP_CAPTION_ID', 'caption_id');
define('MAP_ZOOM_ID', 'zoom_id');
define('MAP_SPOT_ID', 'spot_id');
define('MAP_LANGUAGE', 'language');

// define some constants for the assets table
define('ASSETS_ASSET_ID', 'asset_id');
define('ASSETS_TITLE', 'title');
define('ASSETS_TYPE', 'type');
define('ASSETS_SORT_TITLE', 'sort_title');
define('ASSETS_FEXT', 'fext');
define('ASSETS_CREDIT', 'credit');
define('ASSETS_PRODUCT_ID', 'product_id');
define('ASSETS_CAPTION_ID', 'caption_id');
define('ASSETS_ZOOM_ID', 'zoom_id');
define('ASSETS_LANGUAGE', 'language');

// define some constants for the spots table
define('SPOTS_SPOT_ID', 'spot_id');
define('SPOTS_ASSET_ID', 'asset_id');
define('SPOTS_TITLE', 'title');
define('SPOTS_TITLE2', 'title2');
define('SPOTS_SPOT_TYPE', 'spot_type');
define('SPOTS_COORDS', 'coords');
define('SPOTS_LATS', 'lats');
define('SPOTS_LONGS', 'longs');

// relative path to media for maps
define('MAP_DOC_ROOT', '/media');
// offsets into the image information structure
define('MAP_IMAGE_WIDTH', 0);
define('MAP_IMAGE_HEIGHT', 1);
define('MAP_IMAGE_TYPE', 2);
define('MAP_IMAGE_STRING', 3);

// spot_type definitions
define('SPOT_TYPE', 'spot_type');
define('SPOT_TYPE_HOT', 'h');
define('SPOT_TYPE_NAV', 'n');
define('SPOT_TYPE_POI', 'p');
define('SPOT_TYPE_COLD', 'c');

// define the location of the root of all PHP includes
define('SERVER_PHP_INCLUDE_HOME', $_SERVER['PHP_INCLUDE_HOME']);

?>