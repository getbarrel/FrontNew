<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$view = getForbizView(true);



set_time_limit(0);
ini_set('memory_limit', '-1');


putFullNgramDictDate();
putFilterDicMakeDate();
putAutocompletDicMakeDate();
