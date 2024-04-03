<?php
//namespace Crema;

/**
 * 크리마 API
 * 쇼핑몰에서 사용하는 ID와 CREMA에서 사용하는 ID를 구분하기 위해 쇼핑몰의 ID는 code, CREMA의 ID는 id라고 지칭합니다
 * https://dev.cre.ma/crema-api/order?atarget=content
 * API 구현 후 정상작동 유무 확인이 필요할 경우 담당자에게 문의바랍니다.(담당자: 팀장 - 공미라 Mira Kong <mi@cre.ma>)
 * create by []
 */
class CremaHandler
{
    private $curl;
    protected $apiServer = 'https://sapi.cre.ma';
    protected $uri       = [
        'oauth' => '/oauth/token'
        , 'brands' => '/v1/brands'
        , 'sub_brands' => '/v1/sub_brands'
        , 'user_grades' => '/v1/user_grades'
        , 'users' => '/v1/users'
        , 'caterorys' => '/v1/categories'
        , 'products' => '/v1/products'
        , 'reviews' => '/v1/reviews'
        , 'review_code' => '/v1/comments'
        , 'cart_items' => '/v1/cart_items'
        , 'review_sms' => '/v1/review_sms'
        , 'review_biz_messages' => '/v1/review_biz_messages'
        , 'orders' => '/v1/orders'
        , 'sub_orders' => '/v1/sub_orders'
    ];
    protected $qb = false;

    public function __construct($config = [])
    {

        //init api url 
        $this->setServer(CREMA_API_URL);
//        $this->setServer('https://api.cre.ma');
        //init curl
        $this->curl = new \Curl\Curl();
        $this->qb = getForbiz()->qb;

        //init token
        $this->initAuth();
    }

    public function setServer($server)
    {
        $this->apiServer = $server;
    }

    /**
     * api 주소 리턴
     * @param type $uri
     * @return boolean
     */
    public function getUrl($uri)
    {
        if ($uri) {
            return $this->apiServer.$this->uri[$uri];
        } else {
            return false;
        }
    }

    /**
     * 인증 엑세스
     * @return type
     */
    public function getAccess()
    {
        $url  = $this->getUrl('oauth');
        $data = ['grant_type' => 'client_credentials'
            , 'client_id' => CREMA_APP_ID
            , 'client_secret' => CREMA_SECRET
        ];
        return $this->curl->post($url, $data);
    }

    /**
     * 엑세스한 것에서 토큰 값을 출력      
     * 값이 없으면 error 값이 채워져서 넘어옴
     * response
     * @return json
     */
    public function getToken()
    {
        return json_decode($this->getAccess()->response);
    }

    /**
     * 공통으로 토큰 발급 받아서 셋해서 넘겨줌
     */
    public function initAuth()
    {
        $token = $this->getToken();

        $access_token = $token->{'access_token'} ?? false;
        $token_type   = $token->{'token_type'} ?? false;
        $this->curl->reset();
        $this->curl->setHeader('Authorization', $token_type." ".$access_token);
    }

    /**
     * 해당 업체의 브랜드명 가져오기
     * response
     * ["id": , "name": "", "created_at": "2018-08-30T10:54:52.000+09:00", "updated_at": "2019-01-06T19:22:39.000+09:00"]
     * return json
     */
    public function getBrands($id = null)
    {
        $url = $this->getUrl('brands');
        if ($id) {
            $url .= "/".$id;
        }
        return $this->result($this->curl->get($url));
    }

    /**
     * 카트 ITEM 추가 및 수정
     * @param array $params
     * @return array
     */
    public function putCartItem($params)
    {
        $url = $this->getUrl('cart_items');

        $ret = $this->resultLogType($this->curl->post($url, $params));
        $this->insertCremaLog('putCartItem', $params, $ret['response'], $ret['response_heder'], $ret['curl_error']);

        return $ret;
    }

    /**
     * 유저 등급 리스트
     * @param array $param
     * @return array
     */
    public function getUserGrades($param = [])
    {
        $url = $this->getUrl('user_grades');
        $id  = $param['id'] ?? null;
        if ($id) {
            $url .= '/'.$id.'';
        }
        return $this->result($this->curl->get($url));
    }

    /**
     * 유저 등급 상세
     * @param string $id
     * @return array
     */
    public function getUserGradesInfo($id)
    {
        $url = $this->getUrl('user_grades');
        $url .= '/'.$id;
        return $this->result($this->curl->get($url));
    }

    /**
     * 유저등급 생성 및 수정
     * @param type $param
     * @return type
     */
    public function putUserGrades($param = [])
    {
        $url = $this->getUrl('user_grades');
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 유저등급 삭제
     * @param type $param
     * @return type
     */
    public function delUserGrades($id)
    {
        $url = $this->getUrl('user_grades');
        $url .= '/'.$id;
        return $this->result($this->curl->delete($url));
    }

    /**
     * 서브 브랜드
     * @param type $param
     * @return type
     */
    public function getSubBrands($param = [])
    {
        $url = $this->getUrl('sub_brands');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 서브 브랜드 상세
     * @param type $param
     * @return type
     */
    public function getSubBrandsInfo($param = [])
    {
        $url = $this->getUrl('sub_brands');
        return $this->result($this->curl->get($url, $param));
    }

    public function getSubOrderDetail($param = [])
    {
        $url = $this->getUrl('sub_orders');
        $url .= '/'.$param['id'];
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 서브 브랜드 업데이트
     * @param type $param
     * @return type
     */
    public function patchSubBrandUpdate($param = [])
    {
        $url = $this->getUrl('sub_brands');
        return $this->result($this->curl->patch($url, $param));
    }

    /**
     * 서브브랜드 삭제
     * @param type $param
     * @return type
     */
    public function delSubBrands($param = [])
    {
        $url = $this->getUrl('sub_brands');
        return $this->result($this->curl->delete($url, $param));
    }

    /**
     * 유저 정보리스트
     * @param type $page
     * @param type $limit
     * @return type
     */
    public function getUsers($param = [])
    {
        $url = $this->getUrl('users');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 유저 상세 정보
     * @param type $id
     * @return type
     */
    public function getUsersInfo($id)
    {
        $url = $this->getUrl('users');
        $url .= '/'.$id;
        return $this->result($this->curl->get($url));
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function getUsersInfoName($param = [])
    {
        $url = $this->getUrl('users');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 유저 생성 및 수정
     * @param type $param
     * @return type
     */
    public function putUser($param = [])
    {
        $url = $this->getUrl('users');
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 유저 생성 및 수정
     * @param type $param
     * @return type
     */
    public function putUserLog($param = [])
    {
        $url = $this->getUrl('users');
        return $this->resultLogType($this->curl->post($url, $param));
    }

    /**
     * 유저 삭제
     * @param type $param
     * @return type
     */
    public function delUser($param = [])
    {
        $url = $this->getUrl('users');
        return $this->result($this->curl->delete($url, $param));
    }

    /**
     * Category
     * @param type $param
     * @return type
     */
    public function getCategorys($param = [])
    {
        $url = $this->getUrl('caterorys');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 카테고리 상세
     * code 
     * @param type $param
     * @return type
     */
    public function getCategoryInfo($param = [])
    {
        $url = $this->getUrl('caterorys');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 카테고리 생성 or 수정 
     * @param type $param
     * @return type
     */
    public function putCategory($param = [])
    {
        $url = $this->getUrl('caterorys');
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 카테고리 생성 or 수정 
     * @param type $param
     * @return type
     */
    public function putCategoryLog($param = [])
    {
        $url = $this->getUrl('caterorys');
        return $this->resultLogType($this->curl->post($url, $param));
    }

    /**
     * 카테고리 삭제
     * @param type $param
     * @return type
     */
    public function delCategory($param = [])
    {
        $url = $this->getUrl('caterorys');
        return $this->result($this->curl->delete($url, $param));
    }

    /**
     * 리뷰 리스트
     * limit, page, product_id, product_code, score, photo, date_updated_at, date_order_desc, start_date, end_date
     * @param type $param
     * @return type
     */
    public function getReviews($param = [])
    {
        $url = $this->getUrl('reviews');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 리뷰 상세 정보
     * code
     * @param type $param
     * @return type
     */
    public function getReviewInfo($param = [])
    {
        $url = $this->getUrl('reviews');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 리뷰 상세 정보
     * code
     * @param type $param
     * @return type
     */
    public function putReview($param = [])
    {
        $url = $this->getUrl('reviews');
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 리뷰 삭제
     */
    public function delReview($param = [])
    {
        $url = $this->getUrl('reviews');
        return $this->result($this->curl->delete($url, $param));
    }

    /**
     * 리뷰 코멘트
     * code
     * @param type $param
     * @return type
     */
    public function getReviewComment($param = [])
    {
        $url = $this->getUrl('review_code');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 리뷰 코멘트 생성
     * @param type $param
     * @return type
     */
    public function putReviewComment($param = [])
    {
        $url = $this->getUrl('review_code');
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 리뷰 코멘트 수정
     * @param type $param
     * @return type
     */
    public function patchReviewComment($param = [])
    {
        $url = $this->getUrl('review_code');
        return $this->result($this->curl->patch($url, $param));
    }

    /**
     * 리뷰 코멘트 삭제
     * @param type $param
     * @return type
     */
    public function delReviewComment($param = [])
    {
        $url = $this->getUrl('review_code');
        return $this->result($this->curl->delete($url, $param));
    }

    /**
     * 상품 리스트
     * @param type $param
     * @return type
     */
    public function getProducts($param = [])
    {
        $url = $this->getUrl('products');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 상품 상세
     * @param type $param
     * @return type
     */
    public function getProductInfo($param = [])
    {
        $url = $this->getUrl('products');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 상품 정보 1개
     * @param type $id
     * @return type
     */
    public function getProductInfoId($id)
    {
        $url = $this->getUrl('products');
        $url = $url.'/'.$id;
        return $this->result($this->curl->get($url));
    }

    /**
     * 상품 등록 수정
     * @param type $data
     * @return type
     */
    public function putProduct($param = [])
    {

        $url = $this->getUrl('products');
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 상품 등록 수정 / json type
     * @param type $param
     * @return type
     */
    public function putJsonProduct($param = [])
    {

        $this->initAuth(); //새로 토큰 발급
        $url = $this->getUrl('products');
        $this->curl->setHeader('Content-Type', 'application/json');
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 상품 등록 수정 / json type
     * @param type $param
     * @return type
     */
    public function putJsonProductLog($param = [])
    {

        $this->initAuth(); //새로 토큰 발급
        $url = $this->getUrl('products');
        $this->curl->setHeader('Content-Type', 'application/json');
        return $this->resultLogType($this->curl->post($url, $param));
    }

    /**
     * 상품 수정
     * @param type $param
     * @return type
     */
    public function patchProduct($param = [])
    {
        $url = $this->getUrl('products');
        return $this->result($this->curl->patch($url, $param));
    }

    public function patchJsonProduct($param = [])
    {
        $this->initAuth(); //새로 토큰 발급
        $url = $this->getUrl('products');
        $this->curl->setHeader('Content-Type', 'application/json');
        return $this->result($this->curl->patch($url, $param));
    }

    /**
     * 상품 삭제
     * @param type $data
     * @return type
     */
    public function delProduct($param = [])
    {
        $url = $this->getUrl('products');
        return $this->result($this->curl->delete($url, $param));
    }

    /**
     * 카트 아이템
     * @param type $param
     * @return type
     */
    public function getCartItems($param = [])
    {
        $url = $this->getUrl('cart_items');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 크리마 sms 발송내역
     * @param type $param
     * @return type
     */
    public function getReviewSms($param = [])
    {
        $url = $this->getUrl('review_sms');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 크리마 알림톡 발송 내역
     * @param type $param
     * @return type
     */
    public function getReviewBizMessages($param = [])
    {
        $url = $this->getUrl('review_biz_messages');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 주문리스트
     * @param type $param
     * @return type
     */
    public function getOrders($param = [])
    {
        $url = $this->getUrl('orders');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 주문 상세
     * code
     * @param type $param
     * @return type
     */
    public function getOrderInfo($param = [])
    {
        $url = $this->getUrl('orders');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 주문생성
     * @param type $param
     * @return type
     */
    public function putOrder($param = [])
    {
        $this->initAuth(); //새로 토큰 발급
        $url = $this->getUrl('orders');
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 주문생성 로그타입
     * @param type $param
     * @return type
     */
    public function putOrderLog($param = [])
    {
        $this->initAuth(); //새로 토큰 발급
        $url = $this->getUrl('orders');
        return $this->resultLogType($this->curl->post($url, $param));
    }

    /**
     * 주문 수정
     * @param type $param
     * @return type
     */
    public function patchJsonOrder($param = [], $order_id)
    {
        $this->initAuth(); //새로 토큰 발급
        $this->curl->setHeader('Content-Type', 'application/json');
        $url = $this->getUrl('orders');
        $url = $url.'/'.$order_id;
        return $this->result($this->curl->patch($url, $param));
    }

    /**
     * 주문 수정
     * @param type $param
     * @return type
     */
    public function patchOrder($param = [])
    {
        $url = $this->getUrl('orders');
        return $this->result($this->curl->patch($url, $param));
    }

    /**
     * 주문 삭제
     * @param type $param
     * @return type
     */
    public function delOrder($param = [])
    {
        $url = $this->getUrl('orders');
        return $this->result($this->curl->delete($url, $param));
    }

    /**
     * 주문 상세 리스트
     * @param type $param
     * @return type
     */
    public function getSubOrders($param = [])
    {
        $url = $this->getUrl('sub_orders');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 주문 ID 로 검색
     * @param type $id
     * @param type $param
     * @return type
     */
    public function getSubOrdersId($id, $param)
    {
        $url = $this->getUrl('orders');
        $url = $url.'/'.$id.'/sub_orders';
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 주문 Code 로 검색
     * @param type $param
     * @return type
     */
    public function getSubOrdersCode($param)
    {
        $url = $this->getUrl('sub_orders');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 서브주문 리스트 상세 아이템
     * @param type $param
     * @return type
     */
    public function getSubOrderInfo($param = [])
    {
        $url = $this->getUrl('sub_orders');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 서브주문 상세 ID로 검색
     * @param type $param
     * @return type
     */
    public function getSubOrderInfoId($param = [])
    {
        $url = $this->getUrl('sub_orders');
        return $this->result($this->curl->get($url, $param));
    }

    /**
     * 서브 주문 생성
     * @param type $param
     * @return type
     */
    public function putSubOrder($param = [])
    {
        $url = $this->getUrl('sub_orders');
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 서브 주문 등록
     * @param type $param
     * @return type
     */
    public function postSubOrder($param = [])
    {
        $url = $this->getUrl('orders');
        $url = $url.'/'.$param['order_id'].'/sub_orders';
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 서브 주문 등록 / json type
     * @param type $param
     * @param type $order_id
     * @return type
     */
    public function postSubJsonOrder($param = [], $order_id)
    {
        $this->curl->setHeader('Content-Type', 'application/json');
        $url = $this->getUrl('orders');
        $url = $url.'/'.$order_id.'/sub_orders';
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 서브 주문 등록 / json type
     * @param type $param
     * @param type $order_id
     * @return type
     */
    public function postSubJsonOrderLog($param = [], $order_id)
    {
        $this->curl->setHeader('Content-Type', 'application/json');
        $url = $this->getUrl('orders');
        $url = $url.'/'.$order_id.'/sub_orders';

        return $this->resultLogType($this->curl->post($url, $param));
    }

    /**
     * 주문 리스트 상세 아이템 수정
     * @param type $param
     * @return type
     */
    public function patchSubOrder($param = [])
    {
        $url = $this->getUrl('sub_orders');
        return $this->result($this->curl->post($url, $param));
    }

    /**
     * 주문 리스트 상세 아이템 삭제
     * @param type $param
     * @return type
     */
    public function delSubOrder($param = [])
    {
        $url = $this->getUrl('sub_orders');
        return $this->result($this->curl->delete($url, $param));
    }

    /**
     * json decode 
     * @param type $obj
     * @return type
     */
    public function result($obj)
    {
        if ((json_decode($obj->response) ?? false) || $obj->response) {
            return json_decode($obj->response, true);
        } else {
            if ($obj->error_code == '401') {
                $this->initAuth(); //새로 토큰 발급
                return [];
            } else {
                $curl_error = [];
                if ($this->curl->error_message) {
                    $curl_error['error_message'] = $this->curl->error_message;
                    $curl_error['error_code']    = $this->curl->error_code;
                }
                return ['error' => $obj->error_code, 'curl_error' => $curl_error];
            }
        }
    }

    /**
     * json decode 
     * @param type $obj
     * @return type
     */
    public function resultLogType($obj)
    {
        if ($obj->error_code == "00") {
            if ((json_decode($obj->response) ?? false) || $obj->response) {
                return [
                    'response' => json_decode($obj->response, true)
                    , 'response_heder' => $obj->response_headers
                    , 'error_code' => $obj->error_code
                    , 'curl_error' => []
                ];
            }
        } else {
            $curl_error = [];
            if ($this->curl->error_message) {
                $curl_error['error_message'] = $this->curl->error_message;
                $curl_error['error_code']    = $this->curl->error_code;
            }

            return [
                'response' => json_decode($obj->response, true)
                , 'response_heder' => $obj->response_headers
                , 'error_code' => $obj->error_code
                , 'curl_error' => $curl_error
            ];
        }
    }

    public function issetJson($data)
    {
        return ($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : null;
    }

    public function issetErrorJson($arr = [], $arr2 = [])
    {
        $data = ['response_error' => $arr, 'curl_error' => $arr2];
        if ($arr || $arr2) {
            return ($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : null;
        } else {
            return null;
        }
    }

    /**
     * 크리마 관련 로그
     * @param type $type
     * @param type $params
     * @param type $response
     */
    public function insertCremaLog($type, $params, $response, $response_heder, $response_error)
    {
        $this->qb
            ->set('type', $type)
            ->set('params', (!empty($params) ? json_encode($params, JSON_UNESCAPED_UNICODE) : null))
            ->set('response', (!empty($response) ? json_encode($response, JSON_UNESCAPED_UNICODE) : null))
            ->set('response_heder', (!empty($response_heder) ? json_encode($response_heder, JSON_UNESCAPED_UNICODE) : null))
            ->set('response_error', (!empty($response_error) ? json_encode($response_error, JSON_UNESCAPED_UNICODE) : null))
            ->set('regdate', date("Y-m-d H:i:s"))
            ->insert('crema_logs')
            ->exec();
    }
}