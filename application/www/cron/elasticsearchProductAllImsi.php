<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView(true);

//function putFilterIndex($index = ES_FILTER_INDEX, $min_gram = 2, $max_gram = 6, $max_ngram_diff = 50)
    $params = [
        'index' => $index,
        'body' => [
            'settings' => [
                'analysis' => [
                    'analyzer' => [
                        'ngram_analyzer' => [
                            'tokenizer' => "ngram_tokenizer",
                            'filter' => [
                                "lowercase",
                                "trim"
                            ]
                        ]
                    ],
                    'tokenizer' => [
                        'ngram_tokenizer' => [
                            'type' => "ngram",
                            'min_gram' => 2,
                            'max_gram' => 6
                        ]
                    ]
                ]
                , 'max_ngram_diff' => 50
            ]
        ]
    ];

print_r($params);
/*
https://stg.barrelmade.co.kr/cron/elasticsearchProductAllImsi


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


//전체 맵핑
*/