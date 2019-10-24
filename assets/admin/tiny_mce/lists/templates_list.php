<?php // this must be the very first line in your PHP file!

// You can't simply echo everything right away because we need to set some headers first!
$output = ''; // Here we buffer the JavaScript code we want to send to the browser.
$delimiter = "\n"; // for eye candy... code gets new lines

$output .= 'var tinyMCETemplateList = new Array(';

//$directory = dirname(__FILE__) . "/../templates"; // Use your correct (relative!) path here

// Since TinyMCE3.x you need absolute image paths in the list...
$abspath = preg_replace('~^/?(.*)/[^/]+$~', '/$1', $_SERVER['SCRIPT_NAME']);

    foreach(glob('*.html') as $file){
        $output .= $delimiter
           . '["'
           . ucwords(utf8_encode(str_replace(array('_','-', '.html'), array(' ',' ', ''), $file)))
           . '", "'
           . utf8_encode("$abspath/$file")
           . '"],';
    }

    $output = substr($output, 0, -1); // remove last comma from array item list (breaks some browsers)
    $output .= $delimiter;




// Finish code: end of array definition. Now we have the JavaScript code ready!
$output .= ');';

// Make output a real JavaScript file!
header('Content-type: text/javascript'); // browser will now recognize the file as a valid JS file

// prevent browser from caching
header('pragma: no-cache');
header('expires: 0'); // i.e. contents have already expired

// Now we can send data to the browser because all headers have been set!
echo $output;

