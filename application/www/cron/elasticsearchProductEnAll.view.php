<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$view = getForbizView(true);



set_time_limit(0);
ini_set('memory_limit', '-1');

putGlobalIndex();
putGlobalMapping();
putGlobalDicMake();


//전체 맵핑