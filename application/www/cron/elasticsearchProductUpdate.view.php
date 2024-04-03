<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$view = getForbizView(true);


//ES_INDEX barrel_product
//ES_FILTER_INDEX  barrel_product_filter
//ES_AUTOCOMPLET_INDEX barrel_product_autocomplte
set_time_limit(0);
ini_set('memory_limit', '-1');


putFullNgramDictDate("barrel_product", "update");
putFilterDicMakeDate("barrel_product_filter", "update");
putAutocompletDicMakeDate("barrel_product_autocomplte", "update");
