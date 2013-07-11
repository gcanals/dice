<?php

require '../vendor/autoload.php';
require '../src/dice/conf/DiceConfigure.php';

//DiceConfigure::autloadRegister();

use \dice\mapper\ConnectionFactory ;
use \dice\mapper\ConnectionException ;
try {
    echo "trying to connect (should be OK)...<br/>";
    ConnectionFactory::makeConnection("TEST");
    echo "connection TEST OK : connected <br />";
} catch (ConnectionException $e) {
    echo $e->getMessage();
}

try {
    echo "trying to connect (should fail)...<br/>";
    ConnectionFactory::makeConnection("TESTFAIL");
    echo "connection TEST OK : connected <br/>";
} catch (ConnectionException $e) {
    echo $e->getMessage();
}

?>
