<?php
    require 'common.php';

    if($_GET['debug']) {
        $path = $_GET['debug'];
    } else {
        $path = $_SERVER['REQUEST_URI'];
    }
 
    // this is a lot of nested shit should probably change it up
    $path = addLeadingSlash(removeTrailingSlash(strtolower(rawurldecode($path))));

     // this adds redundant I/O since if no redirect exists it'll just not redirect anyway
    //
    // if(!doesEntryExist($path)) {
    //     returnError('No redirect setup here!');
    // } else {

        $data = explode("\n", file_get_contents($dataFile));
        foreach($data as $line) {
            $entry = explode($separator, $line);
            if(strtolower($entry[0]) == $path) {
                if($logAccess) {
                    $userIP = getAccessIP();
                    logEntry("($userIP) was redirected from ($path) to ($entry[1])");
                }

                header("Location: $entry[1]");
                returnSuccess("Redirecting to $entry[1]");
            }
        }

        http_response_code(404);
        die(file_get_contents('../../index.404.html'));
        //returnError('No redirect setup here!');

    // }
?>