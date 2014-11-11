<?php

    # PHP Session shutdown

    global $qbrt_settings;

    # Twist the little bastard's arm...
    session_write_close();

    if (isset($qbrt_settings['semaphorefile']) && file_exists($qbrt_settings['semaphorefile'])) {
        @unlink($qbrt_settings['semaphorefile']);
    }

?>
