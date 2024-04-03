<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView(true);

putFilterIndex();
putFilterIndexMapping();
putFilterDicMake();


print_r($params);
/*
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$view = getForbizView(true);


set_time_limit(0);
ini_set('memory_limit', '-1');
putFullMixedIndex();
putFullMapping();
putFullNgramDict();

putFilterIndex();
putFilterIndexMapping();
putFilterDicMake();

putAutocompletIndex();
putAutocompletIndexMapping();
putAutocompletDicMake();

*/
//전체 맵핑