<?php

ini_set('memcache.sess_locking', '1');
session_id("foo");

$start1 = microtime(true);
session_start();
$_SESSION["a"] = "b";
session_write_close();
$end1 = microtime(true);

$start2 = microtime(true);
session_start();
session_write_close();
$end2 = microtime(true);

echo '<xmp>';

echo "Time to open / close session:".round($end1 - $start1, 3)."\n";
echo "Time to open / close session:".round($end2 - $start2, 3)."\n";
