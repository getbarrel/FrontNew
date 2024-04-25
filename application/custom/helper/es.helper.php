<?php
defined('FORBIZ_BASEURL') OR exit('No direct script access allowed');
//define('ES_HOST', "106.10.38.50:9200"); //local dev
//define('ES_HOST', "10.41.0.203:9200"); //front
//define('ES_HOST', "10.41.167.100:9200"); //made

define('ES_INDEX', "barrel_product"); //배럴 상품 목록
define('ES_FILTER_INDEX', "barrel_product_filter"); //배럴 상품 필터 목록
define('ES_AUTOCOMPLET_INDEX', "barrel_product_autocomplte"); //배럴 상품 자동 완성 목록
define('ES_BARREL_NORI_ANALYZER', "forbiz_nori_analyzer");
define('ES_MIN_SEARCH_SIZE', 10); //검색 최소 사이즈
define('ES_SEARCH_SIZE', 5000); //검색 최대 사이즈

define('ES_INDEX_EN', "barrel_product_grobal"); //영문 상품 목록
define('ES_FILTER_INDEX_EN', "barrel_product_filter_grobal"); //영문 상품 필터 목록
define('ES_AUTOCOMPLET_INDEX_EN', "barrel_product_autocomplte_grobal"); //영문 자동완성 목록

ini_set('memory_limit', '-1');



/**
 * compose elasticsearch 접속 하는 함수
 * @staticvar type $client
 * @return type
 */
function getEsClient()
{
    static $client = null;

    if ($client === null) {
        $client = \Elasticsearch\ClientBuilder::create()
            ->setHosts([ES_HOST])
            ->build();
    }

    return $client;
}


/* 자모분해 */

function utf8_strlen($str)
{
    return mb_strlen($str, 'UTF-8');
}

function utf8_charAt($str, $num)
{
    return mb_substr($str, $num, 1, 'UTF-8');
}

function utf8_ord($ch)
{
    $len = strlen($ch);
    if ($len <= 0)
        return false;
    $h = ord($ch{0});
    if ($h <= 0x7F)
        return $h;
    if ($h < 0xC2)
        return false;
    if ($h <= 0xDF && $len > 1)
        return ($h & 0x1F) << 6 | (ord($ch{1}) & 0x3F);
    if ($h <= 0xEF && $len > 2)
        return ($h & 0x0F) << 12 | (ord($ch{1}) & 0x3F) << 6 | (ord($ch{2}) & 0x3F);
    if ($h <= 0xF4 && $len > 3)
        return ($h & 0x0F) << 18 | (ord($ch{1}) & 0x3F) << 12 | (ord($ch{2}) & 0x3F) << 6 | (ord($ch{3}) & 0x3F);
    return false;
}

function linear_hangul($str)
{
    $cho = array("ㄱ", "ㄲ", "ㄴ", "ㄷ", "ㄸ", "ㄹ", "ㅁ", "ㅂ", "ㅃ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅉ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ");
    $jung = array("ㅏ", "ㅐ", "ㅑ", "ㅒ", "ㅓ", "ㅔ", "ㅕ", "ㅖ", "ㅗ", "ㅘ", "ㅙ", "ㅚ", "ㅛ", "ㅜ", "ㅝ", "ㅞ", "ㅟ", "ㅠ", "ㅡ", "ㅢ", "ㅣ");
    $jong = array("", "ㄱ", "ㄲ", "ㄳ", "ㄴ", "ㄵ", "ㄶ", "ㄷ", "ㄹ", "ㄺ", "ㄻ", "ㄼ", "ㄽ", "ㄾ", "ㄿ", "ㅀ", "ㅁ", "ㅂ", "ㅄ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅊ", "ㅋ", " ㅌ", "ㅍ", "ㅎ");
    $result = "";
    for ($i = 0; $i < utf8_strlen($str); $i++) {
        $code = utf8_ord(utf8_charAt($str, $i)) - 44032;
        if ($code > -1 && $code < 11172) {
            $cho_idx = $code / 588;
            $jung_idx = $code % 588 / 28;
            $jong_idx = $code % 28;
            $result .= $cho[$cho_idx] . $jung[$jung_idx] . $jong[$jong_idx];
        } else {
            $result .= utf8_charAt($str, $i);
        }
    }
    return $result;
}
/* 자모분해END */

/**
 * 한글 형태소 nori 형태로 단어 토큰을 만듬
 * 사전 만들기 
 * @param type $text
 * @return type
 */
function getEsNoriMorpheme($text, $index = ES_INDEX, $analyzer = ES_BARREL_NORI_ANALYZER)
{
    if ($text) {
        $params = [
            'index' => $index,
            'body' => [
                'analyzer' => $analyzer,
                'text' => $text
            ]
        ];
        $data = getEsClient()->indices()->analyze($params);
    } else {
        $data = [];
    }
    return (empty($data['tokens']) ? [] : array_column($data['tokens'], 'token'));
}

/**
 * ngram 형태의 인덱스 생성
 * test 
 * 기본 형태 인덱스
 * @param type $index
 * @return type
 */
function putNgramIndex($index = ES_INDEX, $min_gram = 2, $max_gram = 6, $max_ngram_diff = 50)
{
    resetIndex($index);
    $params = [
        'index' => $index,
        'body' => [
            'settings' => [
                'analysis' => [
                    'analyzer' => [
                        'forbiz_analyzer' => [
                            "tokenizer" => "forbiz_tokenizer"
                        ]
                    ],
                    'tokenizer' => [
                        'forbiz_tokenizer' => [
                            'type' => 'ngram',
                            "min_gram" => $min_gram,
                            "max_gram" => $max_gram
                        ]
                    ]
                ]
                , 'max_ngram_diff' => $max_ngram_diff
            ]
        ]
    ];
    return getEsClient()->indices()->create($params);
}

function putEDgramIndex($index = ES_INDEX, $min_gram = 2, $max_gram = 6, $max_ngram_diff = 50)
{

    resetIndex($index);
    $params = [
        'index' => $index,
        'body' => [
            'settings' => [
                'analysis' => [
                    'analyzer' => [
                        'edge_analyzer' => [
                            'tokenizer' => "edge_ngram_tokenizer",
                            'filter' => [
                                "lowercase",
                                "trim",
                                "edge_filter_front"
                            ]
                        ],
                        'edge_analyzer_back' => [
                            'tokenizer' => "edge_ngram_tokenizer",
                            'filter' => [
                                "lowercase",
                                "trim",
                                "edge_filter_back"
                            ]
                        ],
                        'ngram_analyzer' => [
                            'tokenizer' => "ngram_tokenizer",
                            'filter' => [
                                "lowercase",
                                "trim"
                            ]
                        ],
                    ],
                    'tokenizer' => [
                        'edge_ngram_tokenizer' => [
                            'type' => "edgeNGram",
                            'min_gram' => 2,
                            'max_gram' => 20,
                            'token_chars' => [
                                "letter",
                                "digit",
                                "punctuation",
                                "symbol"
                            ]
                        ],
                        'ngram_tokenizer' => [
                            'type' => "ngram",
                            'min_gram' => 2,
                            'max_gram' => 10
                        ],
                    ],
                    'filter' => [
                        'edge_filter_front' => [
                            "type" => "edgeNGram",
                            "min_gram" => 2,
                            "max_gram" => 20,
                            "side" => "front"
                        ],
                        'edge_filter_back' => [
                            "type" => "edgeNGram",
                            "min_gram" => 2,
                            "max_gram" => 20,
                            "side" => "back"
                        ]
                    ]
                ]
                , 'max_ngram_diff' => $max_ngram_diff
            ]
        ]
    ];
    return getEsClient()->indices()->create($params);
}

function putEDMapping($index = ES_INDEX, $properties = [])
{
    $indexParams['index'] = $index;

    // Index Settings
    $indexParams['body']['settings']['number_of_shards'] = 3;
    $indexParams['body']['settings']['number_of_replicas'] = 2;

    $properties = [
        "gid" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "ngram_analyzer"
        ],
        "text" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "ngram_analyzer"
        ],
    ];

    //Index Mapping
    $myTypeMapping = array(
        '_source' => array(
            'enabled' => true
        ),
        'properties' => $properties
    );

    $indexParams['body'] = $myTypeMapping;

    // Create the index    
    return getEsClient()->indices()->putMapping($indexParams);
}

function putFullMapping2($index = ES_INDEX, $properties = [])
{
    $indexParams['index'] = $index;

    // Index Settings
    $indexParams['body']['settings']['number_of_shards'] = 3;
    $indexParams['body']['settings']['number_of_replicas'] = 2;

    $properties = [
        "gid" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "edge_analyzer"
        ],
    ];

    //Index Mapping
    $myTypeMapping = array(
        '_source' => array(
            'enabled' => true
        ),
        'properties' => $properties
    );

    $indexParams['body'] = $myTypeMapping;

    // Create the index    
    return getEsClient()->indices()->putMapping($indexParams);
}

/**
 * nori 한글 형태소 
 * 사용은 일단 유보... 
 * $stoptags []
 * E	어미
 * IC	감탄사
 * J	조사
 * MAG	부사
 * MAJ	접속 부사
 * MM	결정자
 * NA	알려지지 않음
 * NNB	종속 명사 (명사 뒤)
 * NNBC	종속 명사
 * NNG	명사
 * NNP	고유 명사
 * NP	대명사
 * NR	숫자
 * SC	분리기 (· / :)
 * SE	생략
 * SF	구두점 (?!.)
 * SH	한자
 * SL	외국어
 * SN	번호
 * SP	공백
 * SSC	닫는 괄호
 * SSO	여는 괄호
 * SY	다른 상징
 * UNA	알 수 없는
 * UNKNOWN	알 수 없는
 * VA	형용사
 * VCN	부정 부호
 * VCP	긍정적 부호
 * VSV	알 수 없는
 * VV	동사
 * VX	보조 동사 또는 형용사
 * XPN	접두사
 * XR	뿌리
 * XSA	형용사 접미사
 * XSN	명사 접미사
 * XSV	동사 접미사
 * @param type $index
 */
//"SH", "SP", "SSC", "SSO", "IC", "SF"
function putNoriIndex($index = ES_INDEX, $stoptags = ["E"])
{

    $params = [
        'index' => $index,
        'body' => [
            'settings' => [
                'analysis' => [
                    'analyzer' => [
                        'forbiz_nori_analyzer' => [
                            "tokenizer" => "forbiz_nori_tokenizer",
                            "filter" => [
                                "nori_posfilter",
                                "nori_readingform"
                            ]
                        ]
                    ],
                    'tokenizer' => [
                        'forbiz_nori_tokenizer' => [
                            'type' => 'nori_tokenizer',
                            "decompound_mode" => "mixed"
                        ]
                    ],
                    'filter' => [
                        'nori_posfilter' => [
                            'type' => 'nori_part_of_speech',
                            'stoptags' => $stoptags
                        ]
                    ]
                ]
            ]
        ]
    ];

    return getEsClient()->indices()->create($params);
}

/**
 * 실제 사용할 복합 인덱스
 * 기본검색, 자모, 초성, 자동완성
 * javacafe_jamo 한글자모
 * javacafe_chosung 초성
 * javacafe_eng2kor 영한
 * javacafe_kor2eng 한영오타
 * javacafe_spell 한글 스펠링
 * @param type $index
 * @param type $min_gram
 * @param type $max_gram
 * @param type $max_ngram_diff
 * @param type $stoptags
 * @return type
 */
function putFullMixedIndex($index = ES_INDEX, $min_gram = 1, $max_gram = 30, $max_ngram_diff = 50, $stoptags = ["E", "SH", "SP", "XPN", "XSA", "XSN", "XSV", "SSC", "SSO", "J", "NR", "SN", "SE", "IC", "SF"])
{
    resetIndex($index);
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
                        ],
                        'ngram_code_analyzer' => [
                            'tokenizer' => "ngram_code_tokenizer",
                            'filter' => [
                                "lowercase",
                                "trim"
                            ]
                        ],
                        'edge_analyzer' => [
                            'tokenizer' => "edge_ngram_tokenizer",
                            'filter' => [
                                "lowercase",
                                "trim",
                                "edge_filter_front"
                            ]
                        ],
                        'edge_analyzer_back' => [
                            'tokenizer' => "edge_ngram_tokenizer",
                            'filter' => [
                                "lowercase",
                                "trim",
                                "edge_filter_back"
                            ]
                        ],
                        'forbiz_spell_analyzer' => [
                            'tokenizer' => "standard",
                            'filter' => [
                                'lowercase',
                                "trim"
                            ]
                        ]
                    ],
                    'tokenizer' => [
                        'ngram_tokenizer' => [
                            'type' => "ngram",
                            'min_gram' => $min_gram,
                            'max_gram' => $max_gram
                        ],
                        'ngram_code_tokenizer' => [
                            'type' => "ngram",
                            'min_gram' => 3,
                            'max_gram' => 10
                        ],
                        'edge_ngram_tokenizer' => [
                            'type' => "edgeNGram",
                            'min_gram' => 2,
                            'max_gram' => 10,
                            'token_chars' => [
                                "letter",
                                "digit",
                                "punctuation",
                                "symbol"
                            ]
                        ]
                    ],
                    'filter' => [
                        'edge_filter_front' => [
                            "type" => "edgeNGram",
                            "min_gram" => 2,
                            "max_gram" => 10,
                            "side" => "front"
                        ],
                        'edge_filter_back' => [
                            "type" => "edgeNGram",
                            "min_gram" => 2,
                            "max_gram" => 10,
                            "side" => "back"
                        ],
                        'forbiz_filter' => [
                            "type" => "lowercase"
                        ]
                    ]
                ]
                , 'max_ngram_diff' => $max_ngram_diff
            ]
        ]
    ];
    return getEsClient()->indices()->create($params);
}

/**
 * 실제 사용할 맵핑
 * 기본검색, 자모, 초성, 자동완성
 * @param type $index
 * @param array $properties
 * @return type
 */
function putFullMapping($index = ES_INDEX, $properties = [])
{
    $indexParams['index'] = $index;

    // Index Settings
    $indexParams['body']['settings']['number_of_shards'] = 3;
    $indexParams['body']['settings']['number_of_replicas'] = 2;

    $properties = [
        "serachword" => [
            "type" => "keyword"
        ],
        "serachwordStandard" => [
            "type" => "text",
            "boost" => 50,
            "analyzer" => "forbiz_spell_analyzer"
        ],
        "serachNgram" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "ngram_analyzer"
        ],
        "serachEDgram" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "edge_analyzer"
        ],
        "serachEDgramBack" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "edge_analyzer_back"
        ],
        "pid" => [
            "type" => "text",
            "boost" => 1,
            "analyzer" => "ngram_code_analyzer"
        ],
        "gid" => [
            "type" => "text",
            "boost" => 1,
            "analyzer" => "ngram_code_analyzer"
        ]
    ];

    //Index Mapping
    $myTypeMapping = array(
        '_source' => array(
            'enabled' => true
        ),
        'properties' => $properties
    );

    $indexParams['body'] = $myTypeMapping;

    // Create the index    
    return getEsClient()->indices()->putMapping($indexParams);
}

/**
 * 텍스트 기본 필터
 * @param type $pullText
 * @return type
 */
function filterText($pullText = "")
{
    $pullText = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $pullText);
    $pullText = explode(" ", $pullText);
    $pullText = array_unique($pullText);
    $pullText = implode("", $pullText);
    return $pullText;
}

/**
 * 전체 상품
 * @param type $index
 */
function putFullNgramDict($index = ES_INDEX)
{
    $view = getForbiz();
    $rows = $view->qb
            ->select("p.id")
            ->select("p.pname")
            ->select("p.search_keyword")
            ->select("p.add_info")
            ->select("g.gname")
            ->select("g.gid")
            ->from(TBL_SHOP_PRODUCT . " as p")
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . " as po", "po.pid = p.id")
            ->join(TBL_INVENTORY_GOODS . " as g", "po.option_gid = g.gid")
            ->where('p.state', 1) // 판매중 1 일시품절 0 판매중지 2 판매예정 4 판매종료 5
            ->where('p.disp', 1) // 노출함 1 노출안함 0
            ->notLike('p.pname', '테스트')
            ->exec()->getResultArray();

    $idx = 1;
    foreach ($rows as $key => $val) {
        $pullTextSpace = $pullText = strip_tags($val['pname'] . $val['add_info'] . $val['search_keyword'] . $val['gname']);
        $pullText = filterText($pullText);

        $params['body'][] = [
            'index' => [
                '_id' => $idx++,
                '_index' => $index
        ]];
        $params['body'][] = [
            'pid' => $val['id']
            , 'gid' => $val['gid']
            , 'serachNgram' => $pullText
            , 'serachwordStandard' => strip_tags($val['pname'])
            , 'serachword' => $pullTextSpace
            , 'serachEDgram' => $pullTextSpace
            , 'serachEDgramBack' => $pullTextSpace
        ];
    }


    getEsClient()->bulk($params);
}

/**
 * 크론용 당일 날짜별로 넣음
 * @param type $index
 */
function putFullNgramDictDate($index = ES_INDEX, $mode = "crate")
{
    $view = getForbiz();
    $sdate = date('Y-m-d', strtotime('-1 day'));
    $edate = date('Y-m-d 23:59:59');

    if ($mode == "crate") {
        $view->qb->betweenDate('p.regdate', $sdate, $edate);
    } else {
        $view->qb->betweenDate('p.editdate', $sdate, $edate);
    }

    $rows = $view->qb
            ->select("p.id")
            ->select("p.pname")
            ->select("p.search_keyword")
            ->select("p.add_info")
            ->select("g.gname")
            ->select("g.gid")
            ->from(TBL_SHOP_PRODUCT . " as p")
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . " as po", "po.pid = p.id")
            ->join(TBL_INVENTORY_GOODS . " as g", "po.option_gid = g.gid")
            ->exec()->getResultArray();

    $index_info = getEsClient()->cat()->indices(['index' => $index]);
    $org_idx = $idx = $index_info[0]['docs.count'] ?? 0;
    $idx++; //시작전에 한개더 추가

    foreach ($rows as $key => $val) {
        $pullTextSpace = $pullText = strip_tags($val['pname'] . $val['add_info'] . $val['search_keyword'] . $val['gname']);
        $pullText = filterText($pullText);

        $params['body'][] = [
            'index' => [
                '_id' => $idx++,
                '_index' => $index
        ]];
        $params['body'][] = [
            'pid' => $val['id']
            , 'gid' => $val['gid']
            , 'serachNgram' => $pullText
            , 'serachwordStandard' => strip_tags($val['pname'])
            , 'serachword' => $pullTextSpace
            , 'serachEDgram' => $pullTextSpace
            , 'serachEDgramBack' => $pullTextSpace
        ];
    }

    if (count($rows) > 0) {
        getEsClient()->bulk($params);
    }
}

function putFullNgramDictUpdate($index = ES_INDEX, $sdate = null, $edate = null)
{
    if (!$sdate) {
        $sdate = date("Y-m-d 00:00:00");
    }
    if (!$edate) {
        $edate = date("Y-m-d 23:59:59");
    }

    $view = getForbiz();
    $rows = $view->qb
            ->select("p.id")
            ->select("p.pname")
            ->select("p.search_keyword")
            ->select("g.gname")
            ->select("p.add_info")
            ->select("g.gid")
            ->from(TBL_SHOP_PRODUCT . " as p")
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . " as po", "po.pid = p.id")
            ->join(TBL_INVENTORY_GOODS . " as g", "po.option_gid = g.gid")
            ->betweenDate('p.editdate', $sdate, $edate)
            ->exec()->getResultArray();
    foreach ($rows as $key => $val) {

        $option = [
            'index' => $index,
            'size' => 1,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            'term' => [
                                'pid' => $val['id']
                            ]
                        ],
                        'filter' => [
                            'term' => [
                                'gid' => $val['gid']
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $data = getEsClient()->search($option);
        $doc_id = null; //update 할 es index id
        if ($data['hits']['total']['value'] > 0) {
            foreach ($data['hits']['hits'] as $es_key => $es_val) {
                if ($es_val['_source']['pid'] == $val['id'] && $es_val['_source']['gid'] == $val['gid']) {
                    $doc_id = $es_val['_id'];
                }
            }
            if ($doc_id !== null) {
                $pullTextSpace = $pullText = strip_tags($val['pname'] . $val['add_info'] . $val['search_keyword'] . $val['gname']);
                //$pullText = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $pullText);
                $pullText = filterText($pullText);
                $params['body'][] = [
                    'index' => [
                        '_id' => $doc_id,
                        '_index' => $index
                ]];
                $params['body'][] = [
                    'pid' => $val['id']
                    , 'gid' => $val['gid']
                    , 'serachNgram' => $pullText
                    , 'serachwordStandard' => strip_tags($val['pname'])
                    , 'serachword' => $pullTextSpace
                    , 'serachEDgram' => $pullTextSpace
                    , 'serachEDgramBack' => $pullTextSpace
                ];
            }
        }
    }
    getEsClient()->bulk($params);
}

/**
 * 검색 결과 리튼
 *  *  검색 옵션
  must : bool must 절에 지정된 모든 쿼리가 일치하는 document를 조회
  should : bool should 절에 지정된 모든 쿼리 중 하나라도 일치하는 document를 조회
  must_not : bool must_not 절에 지정된 모든 쿼리가 모두 일치하지 않는 document를 조회
  filter : must와 같이 filter 절에 지정된 모든 쿼리가 일치하는 document를 조회하지만, Filter context에서 실행되기 때문에 score를 무시합니다.
  terms 쿼리는 배열에 나열된 키워드 중 하나와 일치하는 document를 조회합니다.
 * 
 * @param type $searchText
 * @param type $searchSize
 * @param type $index
 * @return type
 */
function getSearchResult($searchText, $searchSize = ES_SEARCH_SIZE, $index = ES_INDEX)
{
    $originText = strtolower($searchText);
    $searchText = explode(' ', $searchText);
    foreach ($searchText as $key => $value) {
        if (!$value) {
            unset($searchText[$key]);
        }
    }

    $result = [
        'total' => 0
        , 'pid' => []
    ];


    $params = [
        'index' => $index,
        'size' => $searchSize,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['term' => ['gid' => $originText]],
                        ['term' => ['pid' => $originText]],
                        ['term' => ['serachwordStandard' => $originText]], //원본 그대로 검색어 풀매칭                        
                        ['term' => ['serachNgram' => filterText($originText)]], //공백 특문제거 해서 ngram                                                
                        ['term' => ['serachEDgram' => $originText]],
                        ['term' => ['serachEDgramBack' => $originText]],
                    ],
                    "minimum_should_match" => 1
                    , "boost" => 1
                ]
            ]
        ]
    ];

    $data = getEsClient()->search($params);

    if ($data['hits']['total']['value'] > 0) {
        foreach ($data['hits']['hits'] as $key => $val) {
            $arr[] = $val['_source']['pid'];
        }

        $result['pid'] = array_values(array_unique($arr));
        $result['total'] = count($result['pid']);
    }

    return $result;
}

function getSearchResultGlobal($searchText, $searchSize = ES_SEARCH_SIZE, $index = ES_INDEX_EN)
{
    $originText = strtolower($searchText);
    $searchText = explode(' ', $searchText);
    foreach ($searchText as $key => $value) {
        if (!$value) {
            unset($searchText[$key]);
        }
    }

    $result = [
        'total' => 0
        , 'pid' => []
    ];


    $params = [
        'index' => $index,
        'size' => $searchSize,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['term' => ['gid' => $originText]],
                        ['term' => ['pid' => $originText]],
                        ['term' => ['serachNgram' => filterText($originText)]], //공백 특문제거 해서 ngram                                                
                        ['term' => ['serachNgramAuto' => $originText]],
                        ['term' => ['serachword' => $originText]],
                    ],
                    "minimum_should_match" => 1
                    , "boost" => 1
                ]
            ]
        ]
    ];


    $data = getEsClient()->search($params);
    
    if ($data['hits']['total']['value'] > 0) {
        foreach ($data['hits']['hits'] as $key => $val) {
            $arr[] = $val['_source']['pid'];
        }

        $result['pid'] = array_values(array_unique($arr));
        $result['total'] = count($result['pid']);
    }

    return $result;
}

/**
 * 자모 검색 자동완성 
 * @param type $searchText
 * @param type $searchSize
 * @param type $index
 * @return type
 */
function getJamo($searchText, $searchSize = ES_MIN_SEARCH_SIZE, $index = ES_INDEX)
{
    $params = [
        'index' => $index,
        'size' => $searchSize,
        'body' => [
            'query' => [
                'term' => ['serachJamoNgram' => linear_hangul($searchText)
                ]
            ]
        ]
    ];

    return getEsClient()->search($params);
}

/**
 * 옵션 필터 검색 인덱스
 * @param type $index
 * @param type $min_gram
 * @param type $max_gram
 * @param type $max_ngram_diff
 * @param type $stoptags
 * @return type
 */
function putFilterIndex($index = ES_FILTER_INDEX, $min_gram = 2, $max_gram = 6, $max_ngram_diff = 50)
{
    resetIndex($index);
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
                            'min_gram' => $min_gram,
                            'max_gram' => $max_gram
                        ]
                    ]
                ]
                , 'max_ngram_diff' => $max_ngram_diff
            ]
        ]
    ];
    return getEsClient()->indices()->create($params);
}

/**
 * 
 * @param type $index
 * @param array $properties
 * @return type
 */
function putFilterIndexMapping($index = ES_FILTER_INDEX, $properties = [])
{
    $indexParams['index'] = $index;

    // Index Settings
    $indexParams['body']['settings']['number_of_shards'] = 2;
    $indexParams['body']['settings']['number_of_replicas'] = 5;

    $properties = [
        "pid" => [
            "type" => "keyword"
        ],
        "filter_id" => [
            "type" => "keyword"
        ],
        "filter_type" => [
            "type" => "keyword"
        ],
        "color_size" => [
            "type" => "keyword"
        ],
        "size" => [
            "type" => "integer"
        ],
        "price" => [
            "type" => "integer"
        ]
    ];

    //Index Mapping
    $myTypeMapping = array(
        '_source' => array(
            'enabled' => true
        ),
        'properties' => $properties
    );

    $indexParams['body'] = $myTypeMapping;

    // Create the index    
    return getEsClient()->indices()->putMapping($indexParams);
}

/**
 * 필터 데이터 삽입
 * @param type $index
 */
function putFilterDicMake($index = ES_FILTER_INDEX)
{
    $view = getForbiz();


	$sql = "SELECT p.id, p.sellPrice, pf.idx, sp.price, pf.filter_type, pf.filter_code, sp.mall_ix FROM shop_product_filter_relation as pfr JOIN shop_product as p on p.id = pfr.pid JOIN shop_product_filter as pf on pf.idx = pfr.filter_idx LEFT JOIN shop_product_search_price as sp on p.id = sp.pid WHERE sp.mall_ix ='".MALL_IX."'";

   $rows = $view->qb->exec($sql)->getResultArray();

    /*$rows = $view->qb
            ->select("p.id")
            ->select("p.sellPrice")
            ->select("pf.idx")
            ->select("sp.price")
            ->select("pf.filter_type")
            ->select("pf.filter_code")
            ->from(TBL_SHOP_PRODUCT_FILTER_RELATION . " as pfr")
            ->join(TBL_SHOP_PRODUCT . " as p", "p.id = pfr.pid")
            ->join(TBL_SHOP_PRODUCT_FILTER . " as pf", "pf.idx = pfr.filter_idx")
            ->join(TBL_SHOP_PRODUCT_SEARCH_PRICE . " as sp", "p.id = sp.pid", 'left')
            ->where('sp.mall_ix', MALL_IX)
            ->exec()->getResultArray();*/


    $idx = 1;
    foreach ($rows as $key => $val) {
        $size = null;
        $price = $val['price'];

        if (!$price || $price <= 0) {
            //검색 가격이 0원이거나 없을 경우에는 sellPrice
            $price = $val['sellPrice'];
        }

        if (is_numeric($val['filter_code'])) {
            $size = $val['filter_code']; //숫자는 숫자컬럼으로
        }
        $params['body'][] = [
            'index' => [
                '_id' => $idx++,
                '_index' => $index
        ]];
        $params['body'][] = [
            'pid' => $val['id']
            , 'price' => $price
            , 'filter_id' => $val['idx']
            , 'filter_type' => $val['filter_type']
            , 'color_size' => $val['filter_code']
            , 'size' => $size
        ];
    }
    getEsClient()->bulk($params);
}

/**
 * 크론용 필터 데이터 삽입
 * @param type $index
 */
function putFilterDicMakeDate($index = ES_FILTER_INDEX, $mode = "crate")
{
    $view = getForbiz();
    $sdate = date('Y-m-d', strtotime('-1 day'));
    $edate = date('Y-m-d 23:59:59');

    if ($mode == "crate") {
        $view->qb->betweenDate('p.regdate', $sdate, $edate);
    } else {
        $view->qb->betweenDate('p.editdate', $sdate, $edate);
    }

    $rows = $view->qb
            ->select("p.id")
            ->select("p.sellPrice")
            ->select("pf.idx")
            ->select("sp.price")
            ->select("pf.filter_type")
            ->select("pf.filter_code")
            ->from(TBL_SHOP_PRODUCT_FILTER_RELATION . " as pfr")
            ->join(TBL_SHOP_PRODUCT . " as p", "p.id = pfr.pid")
            ->join(TBL_SHOP_PRODUCT_FILTER . " as pf", "pf.idx = pfr.filter_idx")
            ->join(TBL_SHOP_PRODUCT_SEARCH_PRICE . " as sp", "p.id = sp.pid", 'left')
            ->exec()->getResultArray();

    $index_info = getEsClient()->cat()->indices(['index' => $index]);
    $org_idx = $idx = $index_info[0]['docs.count'] ?? 0;
    $idx++; //시작전에 한개더 추가
    foreach ($rows as $key => $val) {
        $size = null;
        $price = $val['price'];

        if (!$price || $price <= 0) {
            //검색 가격이 0원이거나 없을 경우에는 sellPrice
            $price = $val['sellPrice'];
        }

        if (is_numeric($val['filter_code'])) {
            $size = $val['filter_code']; //숫자는 숫자컬럼으로
        }
        $params['body'][] = [
            'index' => [
                '_id' => $idx++,
                '_index' => $index
        ]];
        $params['body'][] = [
            'pid' => $val['id']
            , 'price' => $price
            , 'filter_id' => $val['idx']
            , 'filter_type' => $val['filter_type']
            , 'color_size' => $val['filter_code']
            , 'size' => $size
        ];
    }
    if (count($rows) > 0) {
        getEsClient()->bulk($params);
    }
}

function getFilterOptionCount($pid, $index = ES_FILTER_INDEX, $searchSize = ES_SEARCH_SIZE)
{


    $result = [
        'total' => 0
        , 'pid' => []
    ];

    $params = [
        'index' => $index,
        'size' => $searchSize,
        'body' => [
            'aggs' => [
                'color_agg' => [
                    'terms' => [
                        'field' => 'filter_id'
                    ]
                ]
            ],
            'query' => [
                'bool' => [
                    "filter" => [
                        "terms" => [
                            "pid" => $pid
                        ]
                    ]
                ]
            ]
        ]
    ];

    $data = getEsClient()->search($params);

    if ($data['hits']['total']['value'] > 0) {
        foreach ($data['hits']['hits'] as $key => $val) {
            $arr[] = $val['_source']['pid'];
        }

        $result['pid'] = array_values(array_unique($arr));
        $result['total'] = count($result['pid']);

        if (isset($data['aggregations'])) {
            foreach ($data['aggregations']['color_agg']['buckets'] as $key => $val) {
                $result['filter_option'][$key]['key'] = $val['key'];
                $result['filter_option'][$key]['value'] = $val['doc_count'];
            }
        } else {
            $result['filter_option'][0]['key'] = 0;
            $result['filter_option'][0]['value'] = 0;
        }
        //print_r($data['aggregations']);
    } else {
        $result['filter_option'][0]['key'] = 0;
        $result['filter_option'][0]['value'] = 0;
    }

    return $result;
}

/**
 *  [filterCid] => 
  [filterBrands] =>
  [filterDeliveryFree] =>
  [filterInsideText] =>
  [filterText] =>  검색 내 검색 필터 검색어
  [product_filter] =>  shop_product_filter  idx 값이 배열로 들어옴
  [sprice] => 10000  //최소값
  [eprice] => 50000   //최대값  max 9999999
 * @param type $filter_idx_list
 */
function getSearchFilterResult($filter = [], $searchSize = ES_SEARCH_SIZE, $index = ES_FILTER_INDEX)
{

    if (!empty($filter['product_filter'])) {
        $filter_idx_list = json_decode(urldecode($filter['product_filter']), true);
    } else {
        $filter_idx_list = [];
    }

    $result = [
        'total' => 0
        , 'pid' => []
    ];

    $serachFiled = [];

    if (isset($filter_idx_list) && $filter_idx_list) {
        $serachFiled[] = ['terms' =>
            ['filter_id' =>
                $filter_idx_list
            ]
        ];
    }

    //상품 검색 시작값이 있으면 시작값 셋 없으면 0
    if (isset($filter['sprice']) && $filter['sprice']) {
        $sprice = $filter['sprice'];
    } else {
        $sprice = 0;
    }

    //상품 검색 맥스값이 있으면 맥스값 셋 없으면 0
    if (isset($filter['eprice']) && $filter['eprice']) {
        $eprice = $filter['eprice'];
    } else {
        $eprice = 0;
    }

    //$serachFiled = [];
    //시작 맥스 둘중 하나만 0 이상이면 검색    
    if ($sprice > 0 || $eprice > 0) {
        $serachFiled[]['range'] = ['price' => ["gte" => $sprice, "lte" => $eprice]];
    }

    //옵션 타입만 뽑음
    $params = [
        'index' => $index,
        'size' => $searchSize,
        'body' => [
            'query' => [
                'bool' => [
                    'must' => [
                        $serachFiled
                    ],
                    "filter" => [
                        "terms" => [
                            "pid" => $filter["es_pid"]
                        ]
                    ]
                ]
            ]
        ]
    ];

    $data = getEsClient()->search($params);
    $option_arr = [];
    if ($data['hits']['total']['value'] > 0) {
        foreach ($data['hits']['hits'] as $key => $val) {
            $arr[] = ['pid' => $val['_source']['pid']
                , 'type' => $val['_source']['filter_type']
                , 'color_size' => $val['_source']['color_size']
                , 'price' => $val['_source']['price']
            ];
        }
        $option_arr = filter_array_data($arr, filter_idx_to_colum($filter_idx_list));
    }
    $result['pid'] = array_values(array_unique($option_arr));
    $result['total'] = count($result['pid']);
    return $result;
}

/**
 * 필터 패널 값 하드코딩
 * @param type $arr
 * @return boolean
 */
function filter_idx_to_colum($arr)
{

    $data["clothing"] = [2, 3, 4, 5, 6, 7, 8];
    $data["shoes"] = [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 32, 33];
    $data["acc"] = [23, 24, 25];
    $data["color"] = [34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48];

    $find_key = [];
    foreach ($arr as $id) {
        foreach ($data as $k => $v) {
            if (array_search($id, $v) !== false) {
                $find_key[$k] = true;
            }
        }
    }
    return count($find_key);
}

/**
 * 겹치는 옵션에서 교집합 PID 값 리턴
 * @param type $arr
 * @return type
 */
function filter_array_data($arr, $arr_cnt = 1)
{

    $result = [];
    foreach ($arr as $key => $val) {
        $data[$val['pid']][] = $val['type'];
    }

    foreach ($data as $key => $val) {
        if (count(array_unique($val)) >= $arr_cnt) {
            $result[] = $key;
        }
    }
    return $result;
}

/**
 * 
 */
function putAutocompletIndex($index = ES_AUTOCOMPLET_INDEX, $min_gram = 2, $max_gram = 10, $max_ngram_diff = 50, $stoptags = ["E", "SH", "SP", "XPN", "XSA", "XSN", "XSV", "SSC", "SSO", "J", "NR", "SN", "SE", "IC", "SF"])
{
    resetIndex($index);
    $params = [
        'index' => $index,
        'body' => [
            'settings' => [
                'analysis' => [
                    'analyzer' => [
                        'forbiz_nori_analyzer' => [
                            'tokenizer' => "forbiz_nori_tokenizer",
                            'filter' => [
                                "nori_posfilter",
                                "nori_readingform"
                            ]
                        ],
                        'ngram_analyzer' => [
                            'tokenizer' => "ngram_tokenizer",
                            'filter' => [
                                "lowercase",
                                "trim"
                            ]
                        ],
                        'ngram_jamo_analyzer' => [
                            'tokenizer' => "ngram_jamo_tokenizer",
                            'filter' => [
                                "lowercase",
                                "trim"
                            ]
                        ],
                        'edge_ngram_analyzer' => [
                            'tokenizer' => "edge_ngram_tokenizer",
                            'filter' => [
                                "lowercase",
                                "trim",
                                "edge_ngram_filter_front"
                            ]
                        ],
                        'edge_ngram_analyzer_back' => [
                            'tokenizer' => "edge_ngram_tokenizer",
                            'filter' => [
                                "lowercase",
                                "trim",
                                "edge_ngram_filter_back"
                            ]
                        ],
                        'chosung_index_analyzer' => [
                            'tokenizer' => "keyword",
                            'filter' => [
                                "javacafe_chosung_filter",
                                'lowercase',
                                "trim",
                                "edge_ngram_filter_front"
                            ]
                        ],
                        'chosung_index_analyzer_back' => [
                            'tokenizer' => "keyword",
                            'filter' => [
                                "javacafe_chosung_filter",
                                'lowercase',
                                "trim",
                                "edge_ngram_filter_back"
                            ]
                        ],
                        'chosung_search_analyzer' => [
                            'tokenizer' => "keyword",
                            'filter' => [
                                "javacafe_chosung_filter",
                                'lowercase',
                                "trim"
                            ]
                        ],
                        'jamo_index_analyzer' => [
                            'tokenizer' => "keyword",
                            'filter' => [
                                "javacafe_jamo_filter",
                                'lowercase',
                                "trim",
                                'edge_ngram_filter_front'
                            ]
                        ],
                        'jamo_search_analyzer' => [
                            'tokenizer' => "keyword",
                            'filter' => [
                                "javacafe_jamo_filter",
                                'lowercase',
                                "trim"
                            ]
                        ],
                        'forbiz_spell_analyzer' => [
                            'tokenizer' => "standard",
                            'filter' => [
                                "javacafe_spell",
                                'lowercase',
                                "trim"
                            ]
                        ]
                    ],
                    'tokenizer' => [
                        'forbiz_nori_tokenizer' => [
                            'type' => "nori_tokenizer",
                            'decompound_mode' => "mixed"
                        ],
                        'ngram_tokenizer' => [
                            'type' => "ngram",
                            'min_gram' => $min_gram,
                            'max_gram' => $max_gram
                        ],
                        'ngram_jamo_tokenizer' => [
                            'type' => "ngram",
                            'min_gram' => 1,
                            'max_gram' => 20
                        ],
                        'edge_ngram_tokenizer' => [
                            'type' => "edgeNGram",
                            'min_gram' => 2,
                            'max_gram' => 10,
                            'token_chars' => [
                                "letter",
                                "digit",
                                "punctuation",
                                "symbol"
                            ]
                        ]
                    ],
                    'filter' => [
                        'nori_posfilter' => [
                            'type' => 'nori_part_of_speech',
                            'stoptags' => $stoptags
                        ],
                        'edge_ngram_filter_front' => [
                            "type" => "edgeNGram",
                            "min_gram" => 2,
                            "max_gram" => 10,
                            "side" => "front"
                        ],
                        'edge_ngram_filter_back' => [
                            "type" => "edgeNGram",
                            "min_gram" => 2,
                            "max_gram" => 10,
                            "side" => "back"
                        ],
                        'javacafe_chosung_filter' => [
                            'type' => 'javacafe_chosung'
                        ],
                        'javacafe_jamo_filter' => [
                            'type' => 'javacafe_jamo'
                        ]
                    ]
                ]
                , 'max_ngram_diff' => $max_ngram_diff
            ]
        ]
    ];
    return getEsClient()->indices()->create($params);
}

/**
 * 자동완성용 맵핑
 * @param type $index
 * @param type $min_gram
 * @param type $max_gram
 * @param type $max_ngram_diff
 * @param type $stoptags
 * @return type
 */
function putAutocompletIndexMapping($index = ES_AUTOCOMPLET_INDEX, $properties = [])
{
    $indexParams['index'] = $index;

    // Index Settings
    $indexParams['body']['settings']['number_of_shards'] = 3;
    $indexParams['body']['settings']['number_of_replicas'] = 2;

    $properties = [
        "serachword" => [
            "type" => "keyword",
            "copy_to" => ["suggest"]
        ],
        "suggest" => [
            "type" => "completion",
            "analyzer" => "forbiz_spell_analyzer"
        ],
        "serachwordStandard" => [
            "type" => "keyword",
            "boost" => 10
        ],
        "serachJamoNgram" => [
            "type" => "text",
            "boost" => 5,
            "analyzer" => "ngram_jamo_analyzer"
        ],
        "chosungSerachword" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "chosung_index_analyzer",
            "search_analyzer" => "chosung_search_analyzer"
        ],
        "chosungSerachwordBack" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "chosung_index_analyzer_back",
            "search_analyzer" => "chosung_search_analyzer"
        ],
        "jamoSerachword" => [
            "type" => "text",
            "boost" => 5,
            "analyzer" => "jamo_index_analyzer",
            "search_analyzer" => "jamo_search_analyzer"
        ]
    ];

    //Index Mapping
    $myTypeMapping = array(
        '_source' => array(
            'enabled' => true
        ),
        'properties' => $properties
    );

    $indexParams['body'] = $myTypeMapping;

    // Create the index    
    return getEsClient()->indices()->putMapping($indexParams);
}

function putAutocompletDicMake($index = ES_AUTOCOMPLET_INDEX)
{
    $view = getForbiz();
    $rows = $view->qb
            ->select("p.pname")
            ->from(TBL_SHOP_PRODUCT . " as p")
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . " as po", "po.pid = p.id")
            ->join(TBL_INVENTORY_GOODS . " as g", "po.option_gid = g.gid")
            ->exec()->getResultArray();
    $idx = 1;
    foreach ($rows as $key => $val) {
        $pullTextSpace = $pullText = strip_tags($val['pname']);
        $pullText = filterText($pullText);

        $params['body'][] = [
            'index' => [
                '_id' => $idx++,
                '_index' => $index
        ]];
        $params['body'][] = [
            'serachword' => $pullTextSpace
            , 'serachJamoNgram' => linear_hangul($pullText)
            , 'serachwordStandard' => strip_tags($val['pname'])
            , 'chosungSerachword' => $pullTextSpace
            , 'chosungSerachwordBack' => $pullTextSpace
            , 'jamoSerachword' => $pullText
        ];
    }
    getEsClient()->bulk($params);
}

/**
 * 자동완성 단어 크론용
 * @param type $index
 */
function putAutocompletDicMakeDate($index = ES_AUTOCOMPLET_INDEX, $mode = "crate")
{
    $view = getForbiz();
    $sdate = date('Y-m-d', strtotime('-1 day'));
    $edate = date('Y-m-d 23:59:59');
    if ($mode == "crate") {
        $view->qb->betweenDate('p.regdate', $sdate, $edate);
    } else {
        $view->qb->betweenDate('p.editdate', $sdate, $edate);
    }
    $rows = $view->qb
            ->select("p.pname")
            ->from(TBL_SHOP_PRODUCT . " as p")
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . " as po", "po.pid = p.id")
            ->join(TBL_INVENTORY_GOODS . " as g", "po.option_gid = g.gid")
            ->exec()->getResultArray();
    $index_info = getEsClient()->cat()->indices(['index' => $index]);
    $org_idx = $idx = $index_info[0]['docs.count'] ?? 0;
    $idx++; //시작전에 한개더 추가
    foreach ($rows as $key => $val) {
        $pullTextSpace = $pullText = strip_tags($val['pname']);
        $pullText = filterText($pullText);

        $params['body'][] = [
            'index' => [
                '_id' => $idx++,
                '_index' => $index
        ]];
        $params['body'][] = [
            'serachword' => $pullTextSpace
            , 'serachJamoNgram' => linear_hangul($pullText)
            , 'serachwordStandard' => strip_tags($val['pname'])
            , 'chosungSerachword' => $pullTextSpace
            , 'chosungSerachwordBack' => $pullTextSpace
            , 'jamoSerachword' => $pullText
        ];
    }
    if (count($rows) > 0) {
        getEsClient()->bulk($params);
    }
}

function getAutocomplet($searchText, $searchSize = ES_MIN_SEARCH_SIZE, $index = ES_AUTOCOMPLET_INDEX)
{
    $result = [];
    if ($searchText) {


        $originText = $searchText;
        $searchText = explode(' ', $searchText);
        foreach ($searchText as $key => $value) {
            if (!$value) {
                unset($searchText[$key]);
            }
        }

        $params = [
            'index' => $index,
            'size' => 120,
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            ['term' => ['serachJamoNgram' => linear_hangul(filterText($originText))]], //자모분해해서 검색
                            ['term' => ['jamoSerachword' => $originText]], //자체 자모분해 프론트색인
                            ['term' => ['serachwordStandard' => $originText]], //원본 그대로 검색어 풀매칭
                            ['term' => ['chosungSerachword' => $originText]], //초성 
                            ['term' => ['chosungSerachwordBack' => $originText]] //초성 역색인
                        ],
                        "minimum_should_match" => 1
                    ]
                ]
            ]
        ];

        $data = getEsClient()->search($params);

        if ($data['hits']['total']['value'] > 0) {
            $i = 0;
            foreach ($data['hits']['hits'] as $key => $val) {
                $arr[] = $val['_source']['serachword'];
            }


            $keyword = array_values(array_unique($arr));


            foreach ($keyword as $key => $val) {
                $result[$key]['value'] = $val;
                $result[$key]['label'] = highlights($val, $originText);
                $result[$key]['id'] = $key;
                $i++;
                if ($i > 9) {
                    break;
                }
            }
        }
    }

    return $result;
}

function highlights($text = '', $keyword = '')
{
    if (strlen($text) > 0 && strlen($keyword) > 0) {
        $text = str_replace($keyword, "<span style=\"color:red;\">$keyword</span>", $text);
    }
    return $text;
}

function keywordHightlight($keyword, $word, $class)
{
    if ($keyword) { // $keyword가 존재하면 
        $pattern = '/' . $keyword . '/i';
        $replacement = '<span class="' . $class . '" style="background-color:#FFFD42;">\0</span>';
        $str = preg_replace($pattern, $replacement, $word, -1); // preg_replace(패턴, 바꿀단어, 입력한단어, 
    } else { // $keyword가 존재하지 않으면
        $str = $word; // 하이라이트 없이 입력
    }
    return $str; // 결과 값을 리턴해준다.
}

/**
 * 결과내검색
 * 반드시 pid 배열로 들어온다
 * @param type $pid
 */
function getMoreSearchResult($pid = [], $searchText, $searchSize = ES_SEARCH_SIZE, $index = ES_INDEX)
{
    $originText = $searchText;
    $searchText = explode(' ', $searchText);
    foreach ($searchText as $key => $value) {
        if (!$value) {
            unset($searchText[$key]);
        }
    }

    $result = [
        'total' => 0
        , 'pid' => []
    ];



    $params = [
        'index' => $index,
        'size' => $searchSize,
        'body' => [
            'query' => [
                'bool' => [
                    'must' => [
                        ['terms' => ['pid' => $pid]], // pid 리스트들
                    ],
                    'should' => [
                        ['term' => ['gid' => $originText]],
                        ['term' => ['pid' => $originText]],
                        ['term' => ['serachJamoNgram' => linear_hangul($originText)]], //자모분해해서 검색
                        ['term' => ['serachNgram' => filterText($originText)]], //공백 특문제거 해서 ngram
                        ['term' => ['jamoSerachword' => linear_hangul($originText)]], //자모는 있는 그대로
                        ['term' => ['globalSerachwordNgram' => filterText($originText)]], //영문 검색은 ngram 공백제거
                        ['terms' => ['chosungSerachword' => $searchText]], //초성 배열로  
                        ['terms' => ['chosungSerachwordBack' => $searchText]], //초성 배열로  역색인
                    ],
                    "minimum_should_match" => 1
                ]
            ]
        ]
    ];

    $data = getEsClient()->search($params);

    //print_r($data);

    if ($data['hits']['total']['value'] > 0) {
        foreach ($data['hits']['hits'] as $key => $val) {
            $arr[] = $val['_source']['pid'];
        }

        $result['pid'] = array_values(array_unique($arr));
        $result['total'] = count($result['pid']);
//        if ($result['total'] > 0) {
//            $result = getFilterOptionCount($result['pid']);
//        } else {
//            $result['filter_option'][0]['key'] = 0;
//            $result['filter_option'][0]['value'] = 0;
//        }
    }

    return $result;
}

/**
 * 결과내검색
 * 반드시 pid 배열로 들어온다
 * @param type $pid
 */
function getMoreSearchResultGlobal($pid = [], $searchText, $searchSize = ES_SEARCH_SIZE, $index = ES_INDEX)
{
    $originText = $searchText;
    $searchText = explode(' ', $searchText);
    foreach ($searchText as $key => $value) {
        if (!$value) {
            unset($searchText[$key]);
        }
    }

    $result = [
        'total' => 0
        , 'pid' => []
    ];



    $params = [
        'index' => $index,
        'size' => $searchSize,
        'body' => [
            'query' => [
                'bool' => [
                    'must' => [
                        ['terms' => ['pid' => $pid]], // pid 리스트들
                    ],
                    'should' => [
                        ['term' => ['gid' => $originText]],
                        ['term' => ['pid' => $originText]],
                        ['term' => ['serachJamoNgram' => $originText]], //자모분해해서 검색
                        ['term' => ['serachNgram' => filterText($originText)]], //공백 특문제거 해서 ngram
                        ['term' => ['jamoSerachword' => $originText]], //자모는 있는 그대로
                        ['term' => ['globalSerachwordNgram' => filterText($originText)]], //영문 검색은 ngram 공백제거
                        ['terms' => ['chosungSerachword' => $searchText]], //초성 배열로
                        ['terms' => ['chosungSerachwordBack' => $searchText]], //초성 배열로  역색인
                    ],
                    "minimum_should_match" => 1
                ]
            ]
        ]
    ];

    $data = getEsClient()->search($params);

    //print_r($data);

    if ($data['hits']['total']['value'] > 0) {
        foreach ($data['hits']['hits'] as $key => $val) {
            $arr[] = $val['_source']['pid'];
        }

        $result['pid'] = array_values(array_unique($arr));
        $result['total'] = count($result['pid']);
//        if ($result['total'] > 0) {
//            $result = getFilterOptionCount($result['pid']);
//        } else {
//            $result['filter_option'][0]['key'] = 0;
//            $result['filter_option'][0]['value'] = 0;
//        }
    }

    return $result;
}

/**
 * 페이징용 단순 검색
 * @param type $searchText
 * @param type $page
 * @param type $size
 * @param type $index
 * @return type
 */
function getSearchList($searchText, $page = 1, $size = 100, $index = ES_INDEX)
{
    if (!$index)
        $index = ES_INDEX;
    $originText = $searchText;
    $searchText = explode(' ', $searchText);
    foreach ($searchText as $key => $value) {
        if (!$value) {
            unset($searchText[$key]);
        }
    }

    $page = $page - 1;
    if ($page < 0)
        $page = 0;
    $from = $page * $size;

    $params = [
        'index' => $index,
        'size' => $size,
        'from' => $from,
        'body' => []
    ];

    $result = getEsClient()->search($params);

    return $result;
}

/**
 * index  확인
 * @param type $index
 * @return boolean
 */
function getIndexInfo($index = ES_INDEX)
{
    if (!$index) {
        $index = ES_INDEX;
    }

    $response = getEsClient()->cat()->indices();
    $is_index = false;
    foreach ($response as $key => $val) {
        if ($val['index'] == $index) {
            $is_index = true;
        }
    }
    return $is_index;
}

function delIndex($index = ES_INDEX)
{
    if (!$index) {
        $index = ES_INDEX;
    }

    $deleteParams = [
        'index' => $index
    ];
    $response = getEsClient()->indices()->delete($deleteParams);

    return $response;
}

function resetIndex($index)
{
    $is_index = getIndexInfo($index);
    if ($is_index) {
        //해당인덱스가 있으면 삭제
        $deleteIndex = delIndex($index);
        if (isset($deleteIndex['acknowledged']) && $deleteIndex['acknowledged'] == true) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * 글로벌용 인덱스 상품
 */
function putGlobalIndex($index = ES_INDEX_EN, $min_gram = 1, $max_gram = 20, $max_ngram_diff = 50)
{
    resetIndex($index);

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
                            'min_gram' => $min_gram,
                            'max_gram' => $max_gram
                        ]
                    ],
                    'filter' => [
                    ]
                ]
                , 'max_ngram_diff' => $max_ngram_diff
            ]
        ]
    ];
    return getEsClient()->indices()->create($params);
}

/**
 * 글로벌용 맵핑
 */
function putGlobalMapping($index = ES_INDEX_EN, $properties = [])
{
    $indexParams['index'] = $index;

    // Index Settings
    $indexParams['body']['settings']['number_of_shards'] = 3;
    $indexParams['body']['settings']['number_of_replicas'] = 2;

    $properties = [
        "serachword" => [
            "type" => "keyword"
            , "boost" => 5
        ],
        "serachNgram" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "ngram_analyzer"
        ],
        "serachNgramAuto" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "ngram_analyzer"
        ],
        "pid" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "ngram_analyzer"
        ],
        "gid" => [
            "type" => "text",
            "boost" => 10,
            "analyzer" => "ngram_analyzer"
        ]
    ];

    //Index Mapping
    $myTypeMapping = array(
        '_source' => array(
            'enabled' => true
        ),
        'properties' => $properties
    );

    $indexParams['body'] = $myTypeMapping;

    // Create the index    
    return getEsClient()->indices()->putMapping($indexParams);
}

/**
 * 글로벌용 상품
 */
function putGlobalDicMake($index = ES_INDEX_EN)
{
    $view = getForbiz();
    $rows = $view->qb
            ->select("p.id")
            ->select("p.pname")
            ->select("p.search_keyword")
            ->select("g.gname")
            ->select("g.gid")
            ->from(TBL_SHOP_PRODUCT_GLOBAL . " as p")
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL_GLOBAL . " as po", "po.pid = p.id")
            ->join(TBL_INVENTORY_GOODS . " as g", "po.option_gid = g.gid")
            ->exec()->getResultArray();
    $idx = 1;
    foreach ($rows as $key => $val) {
        $pullTextSpace = $pullText = strip_tags($val['pname'] . $val['search_keyword'] . $val['gname']);
        $pullText = filterText($pullText);

        $params['body'][] = [
            'index' => [
                '_id' => $idx++,
                '_index' => $index
        ]];
        $params['body'][] = [
            'pid' => $val['id']
            , 'gid' => $val['gid']
            , 'serachNgram' => $pullText
            , 'serachword' => $pullTextSpace
            , 'serachNgramAuto' => $pullText
        ];
    }
    getEsClient()->bulk($params);
}

/**
 * 글로벌용 인덱스 필터
 */
function putGlobalIndexFilter($index = ES_FILTER_INDEX_EN, $min_gram = 1, $max_gram = 20, $max_ngram_diff = 50)
{
    resetIndex($index);
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
                            'min_gram' => $min_gram,
                            'max_gram' => $max_gram
                        ]
                    ]
                ]
                , 'max_ngram_diff' => $max_ngram_diff
            ]
        ]
    ];
    return getEsClient()->indices()->create($params);
}

/**
 * 글로벌용 필터 맵핑
 */
function putGlobalMappingFilter($index = ES_FILTER_INDEX_EN, $properties = [])
{
    $indexParams['index'] = $index;

    // Index Settings
    $indexParams['body']['settings']['number_of_shards'] = 3;
    $indexParams['body']['settings']['number_of_replicas'] = 2;

    $properties = [
        "pid" => [
            "type" => "keyword"
        ],
        "filter_id" => [
            "type" => "keyword"
        ],
        "filter_type" => [
            "type" => "keyword"
        ],
        "color_size" => [
            "type" => "keyword"
        ],
        "size" => [
            "type" => "integer"
        ],
        "price" => [
            "type" => "integer"
        ]
    ];

    //Index Mapping
    $myTypeMapping = array(
        '_source' => array(
            'enabled' => true
        ),
        'properties' => $properties
    );

    $indexParams['body'] = $myTypeMapping;

    // Create the index    
    return getEsClient()->indices()->putMapping($indexParams);
}

/**
 * 글로벌용 필터 데이터
 */
function putGlobalDicMakeFilter($index = ES_FILTER_INDEX_EN)
{
    $view = getForbiz();
    $rows = $view->qb
            ->select("p.id")
            ->select("p.sellPrice")
            ->select("pf.idx")
            ->select("sp.price")
            ->select("pf.filter_type")
            ->select("pf.filter_code")
            ->from(TBL_SHOP_PRODUCT_FILTER_RELATION . " as pfr")
            ->join(TBL_SHOP_PRODUCT . " as p", "p.id = pfr.pid")
            ->join(TBL_SHOP_PRODUCT_FILTER . " as pf", "pf.idx = pfr.filter_idx")
            ->join(TBL_SHOP_PRODUCT_SEARCH_PRICE . " as sp", "p.id = sp.pid", 'left')
            ->exec()->getResultArray();
    $idx = 1;
    foreach ($rows as $key => $val) {
        $size = null;
        $price = $val['price'];

        if (!$price || $price <= 0) {
            //검색 가격이 0원이거나 없을 경우에는 sellPrice
            $price = $val['sellPrice'];
        }

        if (is_numeric($val['filter_code'])) {
            $size = $val['filter_code']; //숫자는 숫자컬럼으로
        }
        $params['body'][] = [
            'index' => [
                '_id' => $idx++,
                '_index' => $index
            ],
            'pid' => $val['id']
            , 'price' => $price
            , 'filter_id' => $val['idx']
            , 'filter_type' => $val['filter_type']
            , 'color_size' => $val['filter_code']
            , 'size' => $size
        ];
    }
    getEsClient()->bulk($params);
}

function getProductId($searchText, $searchSize = ES_SEARCH_SIZE, $index = ES_INDEX)
{

    $params = [
        'index' => $index,
        'size' => $searchSize,
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['term' => ['pid' => $searchText]],
                    ],
                    "minimum_should_match" => 1
                    , "boost" => 1
                ]
            ]
        ]
    ];


    $data = getEsClient()->search($params);

    $all_product = [];
    if ($data['hits']['total']['value'] > 0) {
        foreach ($data['hits']['hits'] as $key => $val) {
            $all_product[] = $val['_source'];
        }
    }

    $view = getForbiz();
    $view->load->library('table');

    echo '검색엔진 검색<br>';
    if ($data['hits']['total']['value'] > 0) {
        $view->table->set_heading('상품아이디', '품목코드', 'N그램검색', '전체검색 상품명', '기본검색어', 'ED단어단위 검색', 'ED단어단위 검색 역순');
        echo $view->table->generate($all_product);
    } else {
        echo '검색 엔진 검색 결과가 없습니다';
    }

    echo '<hr>DB검색<br>';
    $rows = $view->qb
            ->select("p.id")
            ->select("p.pname")
            ->select("p.add_info")
            ->select("p.search_keyword")
            ->from(TBL_SHOP_PRODUCT . " as p")
            ->where('p.id', $searchText)
            ->exec()->getResultArray();
    $view->table->set_heading('상품아이디', '상품명', '추가색상', '키워드');
    echo $view->table->generate($rows);
}

function setProductId($searchText, $index = ES_INDEX)
{
    $view = getForbiz();



    //echo '해당 상품을 추가 등록 합니다. <br>';
    $rows = $view->qb
            ->select("p.id")
            ->select("p.pname")
            ->select("p.add_info")
            ->select("p.search_keyword")
            ->select("g.gname")
            ->select("g.gid")
            ->from(TBL_SHOP_PRODUCT . " as p")
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . " as po", "po.pid = p.id", 'left')
            ->join(TBL_INVENTORY_GOODS . " as g", "po.option_gid = g.gid", 'left')
            ->where('p.id', $searchText)
            ->exec()->getResultArray();

    //$view->load->library('table');
    //$view->table->set_heading('상품아이디', '상품명', '추가색상', '키워드', '품목명', '품목아이디');
    //echo $view->table->generate($rows);


    $index_info = getEsClient()->cat()->indices(['index' => $index]);
    $org_idx = $idx = $index_info[0]['docs.count'] ?? 0;
    $idx++; //시작전에 한개더 추가
    foreach ($rows as $key => $val) {
        $pullTextSpace = $pullText = strip_tags($val['pname'] . $val['add_info'] . $val['search_keyword'] . $val['gname']);
        $pullText = filterText($pullText);

        $params['body'][] = [
            'index' => [
                '_id' => $idx++,
                '_index' => $index
        ]];
        $params['body'][] = [
            'pid' => $val['id']
            , 'gid' => $val['gid']
            , 'serachNgram' => $pullText
            , 'serachwordStandard' => strip_tags($val['pname'])
            , 'serachword' => $pullTextSpace
            , 'serachEDgram' => $pullTextSpace
            , 'serachEDgramBack' => $pullTextSpace
        ];
    }
    if (count($rows) > 0) {
        getEsClient()->bulk($params);
    }

    $result['response'] = 'success';
    $result['data_elasticsearch'] = $params;
    $result['data_rows'] = $rows;
    echo json_encode($result);
}
