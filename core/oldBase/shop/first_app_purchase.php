<?php
/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2017-07-11
 * Time: 오후 1:24
 */

//[Start] 앱 첫 구매시 쿠폰 발행 로직 (카드,모바일결제시)- 20151127 - pyw
// 1. APP에서 결제시
// 2. 로그인 상태일때
if ( "" != sess_val('app_type')  && "" != $_SESSION["user"]["code"] ) {

    // 1. 해당 유저가 앱에서 구매한 정보가 있는지 확인한다.
    $sql = "SELECT oid FROM shop_order where user_code = '" . $_SESSION["user"]["code"] . "' AND payment_agent_type = 'A'";
    $db->query($sql);

    // 자료가 없으면 쿠폰을 발행 해 주어야 한다.
    if (0 === $db->total ) {

        include_once($_SERVER["DOCUMENT_ROOT"]."/admin/logstory/class/sharedmemory.class");

        //join_input.act.php 에서 가져와 커스터마이징
        if (file_exists($_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]["mall_data_root"]."/_shared/b2c_coupon_rule")) {
            // 쿠폰 정책 설정에 따른 쿠폰 지급

            $shmop = new Shared("b2c_coupon_rule");
            $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]["mall_data_root"]."/_shared/";
            $shmop->SetFilePath();
            $coupon_data = $shmop->getObjectForKey("b2c_coupon_rule");
            $coupon_data = unserialize(urldecode($coupon_data));

            //앱 첫 설치 쿠폰 발행
            $tmp_member_publish_ix = $coupon_data['app_order_ix'];

            //앱 첫 설치 쿠폰을 진행한다면 타야한다.
            if( $coupon_data['app_order_coupon_use_yn'] == "Y" ) {

                foreach($tmp_member_publish_ix as $key => $cupon_detail){		//다중쿠폰 발급이여서 루프 추가 2014-07-08 이학봉

                    //해당 값이 없으면 다음 루프로 돌린다.
                    if ( !$cupon_detail['publish_ix'] ) {
                        continue;
                    }

                    //본 로직 시작.
                    $member_publish_ix = $cupon_detail['publish_ix'];

                    $sql = "Select publish_ix,use_date_type,publish_date_differ,publish_type,publish_date_type , regist_date_type, regist_date_differ,date_format(use_sdate,'%Y%m%d') as use_sdate, date_format(use_edate,'%Y%m%d') as use_edate,date_format(regdate,'%Y%m%d') as regdate
										from ".TBL_SHOP_CUPON_PUBLISH."
										where publish_ix = '".$member_publish_ix."'";

                    $db->query($sql);
                    $db->fetch();
                    $publish_ix = $db->dt['publish_ix'];

                    $p_year=substr($db->dt["regdate"],0,4);
                    $p_month=substr($db->dt["regdate"],4,2);
                    $p_day=substr($db->dt["regdate"],6,2);

                    if ($db->dt['use_date_type'] == 1) {

                        if($db->dt['publish_date_type'] == 1){
                            $publish_year = $p_year + $db->dt['publish_date_differ'];
                        }else{
                            $publish_year = $p_year;
                        }
                        if($db->dt['publish_date_type'] == 2){
                            $publish_month = $p_month + $db->dt['publish_date_differ'];
                        }else{
                            $publish_month = $p_month;
                        }
                        if($db->dt['publish_date_type'] == 3){
                            $publish_day = $p_day + $db->dt['publish_date_differ'];
                        }else{
                            $publish_day = $p_day;
                        }
                        $use_sdate=mktime(0,0,0,$p_month,$p_day,$p_year);
                        $use_date_limit = mktime(0,0,0,$publish_month,$publish_day,$publish_year);

                    } else if($db->dt['use_date_type'] == 2){
                        if($db->dt['regist_date_type'] == 1){
                            $regist_year = date("Y") + $db->dt['regist_date_differ'];
                        }else{
                            $regist_year = date("Y");
                        }
                        if($db->dt['regist_date_type'] == 2){
                            $regist_month = date("m") + $db->dt['regist_date_differ'];
                        }else{
                            $regist_month = date("m");
                        }
                        if($db->dt['regist_date_type'] == 3){
                            $regist_day = date("d") + $db->dt['regist_date_differ'];
                        }else{
                            $regist_day = date("d");
                        }
                        $use_sdate = time();
                        $use_date_limit = mktime(0,0,0,$regist_month,$regist_day,$regist_year);
                    } else if($db->dt['use_date_type'] == 3){

                        //[Start] substr의 잘못된 인덱스로 날짜를 잘못 파싱 해와서 수정. 2015-01-21 pyw
                        $use_sdate = mktime(0,0,0,substr($db->dt['use_sdate'],4,2),substr($db->dt['use_sdate'],6,2),substr($db->dt['use_sdate'],0,4));
                        $use_date_limit = mktime(0,0,0,substr($db->dt['use_edate'],4,2),substr($db->dt['use_edate'],6,2),substr($db->dt['use_edate'],0,4));
                        //[End]

                    }
                    else if($db->dt['use_date_type'] == 9){
                        $use_sdate = time();							//2037년까지 무기한은 되지 않는다.
                        $use_date_limit = mktime(0,0,0,12,31,2037);		//2037년까지 무기한은 되지 않는다.
                    }
                    //[End]

                    //앱 첫 구매 타입이 없기 떄문에 주석처리
                    //if($db->dt[publish_type] == "3"){//회원가입전용 쿠폰일 경우만 kbk 12/06/13
                    $use_sdate = date("Ymd",$use_sdate);
                    $use_date_limit = date("Ymd",$use_date_limit);

                    $db->query("Select publish_ix from ".TBL_SHOP_CUPON_REGIST." where publish_ix='$publish_ix' and mem_ix = '".$_SESSION["user"]["code"]."' ");

                    //이미 발행한 쿠폰이면 발행하지 않는다.
                    if(!$db->total){
                        $sql2 = "insert into ".TBL_SHOP_CUPON_REGIST." (regist_ix,publish_ix,mem_ix,open_yn,use_yn,use_sdate, use_date_limit, regdate)
												values
												('','".$member_publish_ix."','".$_SESSION["user"]["code"]."','1','0','$use_sdate','$use_date_limit',NOW())";

                        $db->query($sql2);
                    }
                    //}
                }//foreach끝
            }//if문 끝
        }
    }
}