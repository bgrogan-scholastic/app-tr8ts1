<?php

    # PHP Session startup

    global $qbrt_settings;
    global $_instance;
    global $_class;

    session_name($qbrt_settings['sessionname']);
    session_set_cookie_params($qbrt_settings['cookielife'], '', $_SERVER['SERVER_NAME']);


    if (isset($_COOKIE[$qbrt_settings['sessionname']])) {
        $qbrt_settings['semaphorefile'] = session_save_path().'/'.$_COOKIE[$qbrt_settings['sessionname']].'.qbrtsemaphore';
    }

    if (isset($_REQUEST['sleep'])) {
        sleep($_REQUEST['sleep']);
    }
    
    while (isset($qbrt_settings['semaphorefile']) && file_exists($qbrt_settings['semaphorefile'])
                            && $qbrt_settings['semaphore_max']) {
        usleep(100000);
        $qbrt_settings['semaphore_max']--;
    }

    if (isset($qbrt_settings['semaphorefile'])) {
        $fp = fopen($qbrt_settings['semaphorefile'], 'a');
        fwrite($fp, "This is the ".$_class."::".$_instance." session semaphore file");
        fclose($fp);
    }
    
    session_start();

    if (!isset($qbrt_settings['semaphorefile'])) {
        $qbrt_settings['semaphorefile'] = session_save_path().'/'.session_name().'.qbrtsemaphore';
        $fp = fopen($qbrt_settings['semaphorefile'], 'w');
        fwrite($fp, "This is the ".$_class."::".$_instance." session semaphore file");
        fclose($fp);
    }
?>
