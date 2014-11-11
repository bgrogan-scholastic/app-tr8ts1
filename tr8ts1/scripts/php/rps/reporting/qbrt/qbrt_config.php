<?php

    # settings for this occurrence of the Q*Bert app.

    $qbrt_settings = array(
        'sessionname'       =>  'QBRTSESSID',
        'cookielife'        =>  315576000,
        'title'             =>  'Q*Bert',
        'background'        =>  'qbrt.gif',
        'bgcolor'           =>  '#ddeeff',
        'DB_CONNECT_STRING' =>  'oci8://' . getenv('RPS_REPORTS_DB_USERNAME' ) . ':' . getenv('RPS_REPORTS_DB_PASSWORD' ) . '@' . getenv('RPS_REPORTS_DB_CONNECTIONNAME') . '/' . getenv('RPS_REPORTS_DB_DATABASENAME'),
        'semaphore_max'     =>  150
    );

    # The sessionname is the name of the cookie which will be used
    # to store the php session id (overriding the default 'PHPSESSID').
    # That way, the app will have a unique session 'namespace', and not
    # share with other apps which may have opened php sessions.

    # cookie life is in seconds.
    #   0 for a 'session cookie'
    #   315576000 is 10 years.

    # title is a default html document title.  It will usually
    # be replaced with the name of the object instance in frames.

    # semaphore_max is the number of 10ths of a second to wait for
    # the session semaphore file to go away.  It's primarily
    # insurance against infinite loops.
?>
