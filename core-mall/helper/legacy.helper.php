<?php
/* * ************************************
 *  레거시 호환용 함수 영역 시작
 * ************************************ */
if (!function_exists('roundBetter')) {

    function roundBetter($number, $precision = 0, $mode = PHP_ROUND_HALF_UP, $direction = NULL)
    {
        if (!isset($direction) || is_null($direction)) {
            return round($number, $precision, $mode);
        } else {
            $factor = pow(10, -1 * $precision);

            return strtolower(substr($direction, 0, 1)) == 'd' ? floor($number / $factor) * $factor : ceil($number / $factor) * $factor;
        }
    }
}

if (!function_exists('roundBetterUp')) {

    function roundBetterUp($number, $precision = 0, $mode = PHP_ROUND_HALF_UP)
    {
        return roundBetter($number, $precision, $mode, 'up');
    }
}

if (!function_exists('roundBetterDown')) {

    function roundBetterDown($number, $precision = 0, $mode = PHP_ROUND_HALF_UP)
    {
        return roundBetter($number, $precision, $mode, 'down');
    }
}

if (!function_exists('UserSellingType')) {

    function UserSellingType()
    {
        //해당 회원의 도소매 구분 함수 2014-07-09 이학봉
        // R: 소매 W:도매

        if (sess_val("user", "selling_type") == "R") {
            return "R";
        } else if (sess_val("user", "selling_type") == "W") {
            return "W";
        } else {
            return "R";
        }
    }
}

if (!function_exists('array_insert')) {

    function array_insert(&$array, $position, $insert_array)
    {
        $first_array = array_splice($array, 0, $position);
        $array       = array_merge($first_array, $insert_array, $array);
    }
}

if (!function_exists('cartCnt')) {

    function cartCnt($code = "")
    {

        global $shop_product_type;
        global $slave_mdb;
        //$slave_mdb = new Database;
        //장바구니
        //AND est_ix = '0' AND delivery_package = 'N' 추가  // AND delivery_package = 'N' 제거 왜 들어가있는거야?? JK160422
        if (!$code) $where = " where cart_key = '".session_id()."' and product_type in (".implode(' , ', $shop_product_type).") AND est_ix = '0'";
        else $where = " where mem_ix='".$code."' and product_type in (".implode(' , ', $shop_product_type).") AND est_ix = '0' ";

        $sql = "select * from shop_cart ".$where." group by id, select_option_id";

        //echo $sql;
        $slave_mdb->query($sql);
        $total = $slave_mdb->total;

        if ($total > 0) {
            return $slave_mdb->total;
        } else {
            return 0;
        }
    }
}

if (!function_exists('historyList')) {

    function historyList()
    {
        global $HISTORY;

        $HISTORY[$_SESSION["layout_config"]['mall_ix']] = $HISTORY[$_SESSION["layout_config"]['mall_ix']] ?? '';

        if (is_array($HISTORY[$_SESSION["layout_config"]['mall_ix']])) {
            foreach ($HISTORY[$_SESSION["layout_config"]['mall_ix']] as $key => $sub_array) {
                $goods_infos[$HISTORY[$_SESSION["layout_config"]['mall_ix']][$key]['id']]['pid']    = $HISTORY[$_SESSION["layout_config"]['mall_ix']][$key]['id'];
                $goods_infos[$HISTORY[$_SESSION["layout_config"]['mall_ix']][$key]['id']]['amount'] = 1;
                $goods_infos[$HISTORY[$_SESSION["layout_config"]['mall_ix']][$key]['id']]['cid']    = $HISTORY[$_SESSION["layout_config"]['mall_ix']][$key]['cid'];
                $goods_infos[$HISTORY[$_SESSION["layout_config"]['mall_ix']][$key]['id']]['depth']  = 1; //$HISTORY[0][depth];
            }
            if (count($goods_infos) > 0) {
                $discount_info = DiscountRult($goods_infos); // $HISTORY[0][cid], $HISTORY[0][depth]);
            }
        }


        if (is_array($HISTORY[$_SESSION["layout_config"]['mall_ix']])) {
            foreach ($HISTORY[$_SESSION["layout_config"]['mall_ix']] as $key => $sub_array) {

                $select_ = array("icons_list" => explode(";",
                        (is_array($sub_array['icons']) ? implode(';', $sub_array['icons']) : $sub_array['icons'])));
                array_insert($sub_array, 14, $select_);

                $discount_item = $discount_info[$sub_array['id']];
                //print_r($discount_item);
                $_dcprice      = $sub_array['sellprice'];
                if (is_array($discount_item)) {
                    foreach ($discount_item as $_key => $_item) {
                        if ($_item['discount_value_type'] == "1") { // %
                            //echo $_item[discount_value]."<br>";
                            $_dcprice = roundBetter($_dcprice * (100 - $_item['discount_value']) / 100, $_item['round_position'], $_item['round_type']); //$_dcprice*(100 - $_item[discount_value])/100;
                            /*
                              echo "round_position : ".$_item[round_position]."<br>";
                              echo "round_type : ".$_item[round_type]."<br>";
                              echo "이전할인가 : ".$_dcprice."<br>";
                              echo roundBetter($_dcprice*(100 - $_item[discount_value])/100, $_item[round_position], $_item[round_type]) ;			;
                             */
                        } else if ($_item['discount_value_type'] == "2") {// 원
                            $_dcprice = $_dcprice - $_item['discount_value'];
                        }
                        $_item['expectation_discount_price'] = $sub_array['sellprice'] - $_dcprice;
                        //$discount_desc[] = $_item[discount_type]."-".$_item[discount_value]." ".($_item[discount_value_type] == "1" ? "%":"원")."-".$_dcprice."원";
                        $discount_desc[]                     = $_item;
                    }
                    //print_r($discount_desc);
                }
                $_dcprice      = array("dcprice" => $_dcprice);
                array_insert($sub_array, 52, $_dcprice);
                $discount_desc = array("discount_desc" => $discount_desc);
                array_insert($sub_array, 53, $discount_desc);

                $HISTORY[$_SESSION["layout_config"]['mall_ix']][$key] = $sub_array;
            }
        }

        return $HISTORY[$_SESSION["layout_config"]['mall_ix']];
    }
}

if (!function_exists('wishList')) {

    function wishList($code, $cnt = 5)
    {
        global $slave_mdb;

        $slave_mdb->query("select wid, id, pname,global_pinfo,reserve, sellprice, format(sellprice,0) as price, shotinfo ,p.brand_name from ".TBL_SHOP_WISHLIST." w, ".TBL_SHOP_PRODUCT." p where w.pid = p.id and mid ='".$code."' limit 0,$cnt ");
        $wishList = $slave_mdb->fetchall("object");

        if (is_array($wishList)) {
            foreach ($wishList as $key => $val) {
                $wishList[$key]['pname'] = getGlobalTargetName($val['pname'], $val['global_pinfo'], 'pname');
            }
        }

        if (is_array($wishList)) {
            foreach ($wishList as $key => $sub_array) {
                $goods_infos[$wishList[$key]['id']]['pid']    = $wishList[$key]['id'];
                $goods_infos[$wishList[$key]['id']]['amount'] = 1;
                $goods_infos[$wishList[$key]['id']]['cid']    = $wishList[$key]['cid'];
                $goods_infos[$wishList[$key]['id']]['depth']  = 1; //$wishList[0][depth];
            }

            if (count($wishList) > 0) {
                $discount_info = DiscountRult($goods_infos); // $wishList[0][cid], $wishList[0][depth]);
            }
        }

        if (is_array($wishList)) {
            foreach ($wishList as $key => $sub_array) {

                $select_       = array("icons_list" => explode(";", $sub_array['icons']));
                array_insert($sub_array, 14, $select_);
                $discount_item = $discount_info[$sub_array['id']];
                $_dcprice      = $sub_array['sellprice'];
                if (is_array($discount_item)) {
                    foreach ($discount_item as $_key => $_item) {
                        if ($_item['discount_value_type'] == "1") { // %
                            $_dcprice = roundBetter($_dcprice * (100 - $_item['discount_value']) / 100, $_item['round_position'], $_item['round_type']); //$_dcprice*(100 - $_item[discount_value])/100;
                        } else if ($_item['discount_value_type'] == "2") {// 원
                            $_dcprice = $_dcprice - $_item['discount_value'];
                        }
                        $_item['expectation_discount_price'] = $sub_array['sellprice'] - $_dcprice;
                        $discount_desc[]                     = $_item;
                    }
                }
                $_dcprice      = array("dcprice" => $_dcprice);
                array_insert($sub_array, 52, $_dcprice);
                $discount_desc = array("discount_desc" => $discount_desc);
                array_insert($sub_array, 53, $discount_desc);

                $wishList[$key] = $sub_array;
            }
        }

        if (count($wishList)) {
            for ($i = 0; $i < count($wishList); $i++) {
                $wishList[$i]['listprice'] = getExchangeNationPrice($wishList[$i]['listprice']);
                $wishList[$i]['sellprice'] = getExchangeNationPrice($wishList[$i]['sellprice']);
                $wishList[$i]['dcprice']   = getExchangeNationPrice($wishList[$i]['dcprice']);
            }
        }

        return $wishList;
    }
}

if (!function_exists('getGlobalTargetName')) {

    function getGlobalTargetName($target_name, $global_json, $colum, $language = "")
    {

        if (empty($language)) {
            $language = $_SESSION["layout_config"]["front_language"];
        }

        $global_json = json_decode($global_json, true);
        if ($global_json == "null") {
            return $target_name;
        }
        $global_target_name = trim(urldecode($global_json[$colum][$language]));
        if (!empty($global_target_name)) {
            return $global_target_name;
        } else {
            return $target_name;
        }
    }
}

if (!function_exists('DiscountRult')) {

    function DiscountRult($goods_infos, $cid = "", $depth = "", $amount = "1")
    {
        //global $script_times;
        global $slave_mdb;
        $discount_info = [];

        if (!is_array($goods_infos)) {
            //echo "할인상품 대상이 입력되어야 합니다. ";
            //exit;
            return;
        }
        //$slave_mdb->debug = true;
        //print_r($goods_infos);
        if (is_array($goods_infos)) {
            foreach ($goods_infos as $key => $value) {
                $_array_pid[] = $key;
            }
        } else {
            $_array_pid[] = $goods_infos;
        }
        //print_r($_array_pid);
        //exit;
        if (!is_array($_array_pid)) {
            return;
        }
        if (sess_val('user') && sess_val("user", "use_discount_type") == "g") {

            // 회원그룹별 할인
            if ($_SESSION['user']['sale_rate'] > 0) {
                $sql = "select 'MG' as discount_type, pr.cid, p.id as pid , p.sellprice , 0 as commision,
						'".$_SESSION['user']['sale_rate']."' as headoffice_rate , 0 as seller_rate, '".$_SESSION['user']['sale_rate']."' as sale_rate
						from shop_product p , shop_product_relation pr
						where p.id = pr.pid and pr.basic = '1'
						and p.id in (".implode(' , ', $_array_pid).") ";

                //and pr.cid LIKE '".substr($value[cid],0,($value[depth]+1)*3)."%'
                $script_times["discount_group_start_".rand()] = time();
                $slave_mdb->query($sql);
                $_discount_info                               = $slave_mdb->fetchall();
                $script_times["discount_group_end_".rand()]   = time();

                for ($i = 0; $i < count($_discount_info); $i++) {
                    //echo $_discount_info[$i][pid]."<br>";
                    $pid                                                                              = str_pad($_discount_info[$i]['pid'], 10, "0",
                        STR_PAD_LEFT);
                    //echo $pid;
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["pid"]                 = $pid;
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_type"]       = $_discount_info[$i]['discount_type'];
                    //$discount_info[$pid][$_discount_info[$i][discount_type]]["sellprice"] = $_discount_info[$i][sellprice];
                    //$discount_info[$pid][$_discount_info[$i][discount_type]]["dcprice"] = $_discount_info[$i][sellprice]*((100-$_discount_info[$i][sale_rate])/100);
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_value"]      = $_discount_info[$i]['sale_rate'];
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_value_type"] = "1"; // 1:%, 2:원
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["round_position"]      = $_SESSION["user"]['round_depth']; // 1, 2, 3
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["round_type"]          = $_SESSION["user"]['round_type']; // 1: 반올림, 2:반내림, 3: 올림, 4: 내림

                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["headoffice_discount_value"] = $_discount_info[$i]['headoffice_rate'];
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["seller_discount_value"]     = $_discount_info[$i]['seller_rate'];
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_code"]             = $_SESSION['user']['gp_ix'];
                }
            }
        }

        if ($amount == "" || $amount == "NaN") {
            $amount = 1;
        }
        if (UserSellingType() == "W") {
            //복수할인
            $sql = "SELECT 'MC' as discount_type, p.id as pid , p.sellprice,  pmr.rate_price as sale_rate , rate_div as discount_value_type, pmr.mr_id, pmr.round_cnt, pmr.round_type
					FROM shop_product p , shop_product_mult_rate pmr
					where p.id = pmr.pid and is_wholesale = 'W' and p.id in (".implode(' , ', $_array_pid).") and pmr.sell_mult_cnt <= '".$amount."' ";
        } else {
            //복수할인
            $sql = "SELECT 'MC' as discount_type, p.id as pid , p.sellprice,  pmr.rate_price as sale_rate , rate_div as discount_value_type, pmr.mr_id, pmr.round_cnt, pmr.round_type
				FROM shop_product p , shop_product_mult_rate pmr
				where p.id = pmr.pid and is_wholesale = 'R' and p.id in (".implode(' , ', $_array_pid).") and pmr.sell_mult_cnt <= '".$amount."' ";
        }
        //	echo $sql;
        $script_times["discount_multibuying_sale_start_".rand()] = time();
        $slave_mdb->query($sql);
        $_discount_info                                          = $slave_mdb->fetchall();
        $script_times["discount_multibuying_sale_start_".rand()] = time();

        if (is_array($_discount_info)) {
            for ($i = 0; $i < count($_discount_info); $i++) {
                //echo $_discount_info[$i][pid]."<br>";
                $pid                                                                              = str_pad($_discount_info[$i]['pid'], 10, "0",
                    STR_PAD_LEFT);
                //echo $pid;
                $discount_info[$pid][$_discount_info[$i]['discount_type']]["pid"]                 = $pid;
                $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_type"]       = $_discount_info[$i]['discount_type'];
                //$discount_info[$pid][$_discount_info[$i][discount_type]]["sellprice"] = $_discount_info[$i][sellprice];
                //$discount_info[$pid][$_discount_info[$i][discount_type]]["dcprice"] = $_discount_info[$i][sellprice]*((100-$_discount_info[$i][sale_rate])/100);
                $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_value"]      = $_discount_info[$i]['sale_rate'];
                $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_value_type"] = $_discount_info[$i]['discount_value_type']; // 1:%, 2:원
                $discount_info[$pid][$_discount_info[$i]['discount_type']]["round_position"]      = $_discount_info[$i]['round_cnt']; // 1, 2, 3
                $discount_info[$pid][$_discount_info[$i]['discount_type']]["round_type"]          = $_discount_info[$i]['round_type']; // 1: 반올림, 2:반내림, 3: 올림, 4: 내림

                $discount_info[$pid][$_discount_info[$i]['discount_type']]["headoffice_discount_value"] = $_discount_info[$i]['headoffice_rate'];
                $discount_info[$pid][$_discount_info[$i]['discount_type']]["seller_discount_value"]     = $_discount_info[$i]['seller_rate'];
                $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_code"]             = $_discount_info[$i]['mr_id'];
            }
        }

        if (sess_val("user", "use_discount_type") == "c") {
            // 카테고리별 할인
            $shmop                  = new Shared("category_discount_info");
            $shmop->filepath        = $_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]["mall_data_root"]."/_shared/";
            $shmop->SetFilePath();
            $category_discount_info = $shmop->getObjectForKey("category_discount_info");
            $category_discount_info = unserialize(urldecode($category_discount_info));

            //echo "<br><Br>";
            //echo substr($cid, 0, ($depth+1)*3);
            //$search_category_discount_info = getParentStackComplete(substr($cid, 0, ($depth+1)*3), $category_discount_info);
            if ($cid && false) {
                $search_category_discount_info = multidimensional_search($category_discount_info,
                    array("cid" => substr($cid, 0, ($depth + 1) * 3), "cid" => substr($cid, 0, 3)));
            } else {
                $search_category_discount_info = $category_discount_info[$_SESSION['user']['gp_ix']];
            }

            $cid = ""; //### 2016.03.22
            //print_r($search_category_discount_info);
            if (is_array($search_category_discount_info)) {
                unset($sql);
                foreach ($search_category_discount_info as $key => $value) {

                    if (($cid && substr($value['cid'], 0, ($depth + 1) * 3) == substr($cid, 0, ($depth + 1) * 3)) || !$cid) {

                        if ($sql != "") {
                            $sql .= "
										union
										";
                        }
                        //$exclude_cids = multidimensional_search($category_discount_info, array("cid"=>substr($value[cid], 0, ($value[depth]+1)*3)),"key");
                        //echo $value[cid]."::::".$value[depth]."<br><br>";
                        //print_r($exclude_cids);
                        //$filteredArr = array_diff($exclude_cids[cid],array($value[cid]));
                        //print_r($filteredArr);
                        if (UserSellingType() == "R") {
                            $view_reserve = $reserve_rate;
                        } else if (UserSellingType() == "W") {
                            $view_reserve = $whole_reserve_rate;
                        } else {
                            $view_reserve = $reserve_rate;
                        }
                        $sql .= "select 'C' as discount_type, pr.cid, p.id as pid , p.sellprice , 0 as commision,
									".(UserSellingType() == "W" ? $value['wholesale_dc_rate'] : $value['dc_rate'])." as headoffice_rate , 0 as seller_rate, ".(UserSellingType()
                            == "W" ? $value['wholesale_dc_rate'] : $value['dc_rate'])." as sale_rate
									from shop_product p , shop_product_relation pr
									where p.id = pr.pid and pr.basic = '1' and pr.cid LIKE '".substr($value['cid'], 0, ($value['depth'] + 1) * 3)."%'
									and p.id in (".implode(' , ', $_array_pid).") ";

                        /*
                         * 카테고리 제외
                         * 1. 2014-07-12 shs 제외 카테고리 출처를 몰라 주석처리
                         */
                        /*
                          if(is_array($filteredArr)){
                          foreach($filteredArr as $key => $excude_cid){
                          $sql .= "and pr.cid NOT LIKE  '".substr($excude_cid,0,($exclude_cids[depth][$key]+1)*3)."%' ";
                          }
                          }
                         */
                        //echo nl2br($sql)."<br><br><br>";
                        //exit;
                    }
                }
                //	echo "<br><br>".nl2br($sql)."<br><br><br>";
                if ($sql) {
                    $script_times["discount_category_start_".rand()] = time();
                    //echo nl2br($sql);
                    //$script_times["discount_category_start_".rand()] = $sql;
                    $slave_mdb->query($sql);
                    $_discount_info                                  = $slave_mdb->fetchall();
                    $script_times["discount_category_end_".rand()]   = time();
                    //echo ($script_times["discount_category_start_".rand()] - $script_times["discount_category_end_".rand()])."<br><br>";
                }
                for ($i = 0; $i < count($_discount_info); $i++) {
                    //echo $_discount_info[$i][pid]."<br>";
                    if ($_discount_info[$i]['sale_rate'] > 0) {
                        $pid                                                                              = str_pad($_discount_info[$i]['pid'], 10,
                            "0", STR_PAD_LEFT);
                        //echo $pid;
                        $discount_info[$pid][$_discount_info[$i]['discount_type']]["pid"]                 = $pid;
                        $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_type"]       = $_discount_info[$i]['discount_type'];
                        //$discount_info[$pid][$_discount_info[$i][discount_type]]["sellprice"] = $_discount_info[$i][sellprice];
                        //$discount_info[$pid][$_discount_info[$i][discount_type]]["dcprice"] = $_discount_info[$i][sellprice]*((100-$_discount_info[$i][sale_rate])/100);
                        $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_value"]      = $_discount_info[$i]['sale_rate'];
                        $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_value_type"] = "1"; //$_discount_info[$i][discount_sale_type];
                        $discount_info[$pid][$_discount_info[$i]['discount_type']]["round_position"]      = 1; // 1, 2, 3
                        $discount_info[$pid][$_discount_info[$i]['discount_type']]["round_type"]          = 1; // 1: 반올림, 2:반내림, 3: 올림, 4: 내림

                        $discount_info[$pid][$_discount_info[$i]['discount_type']]["headoffice_discount_value"] = $_discount_info[$i]['headoffice_rate'];
                        $discount_info[$pid][$_discount_info[$i]['discount_type']]["seller_discount_value"]     = $_discount_info[$i]['seller_rate'];
                        $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_code"]             = $_discount_info[$i]['cid'];
                    }
                }
                //print_r($discount_info);
            }
        }
        //dc_type 할인타입(MC:복수구매,MG:그룹,C:카테고리,GP:기획,SP:특별,CP:쿠폰,SCP:중복쿠폰,M:모바일,E:에누리,DCP:배송쿠폰,DE:배송비에누리)
        // 기획할인 , 특가할인
        $useable_dpg_ix = [];
        $useable_dc_ix  = [];
        if (is_array($_array_pid)) {
            $sql                   = "select d.dc_ix , dpg.dpg_ix
					from shop_discount d
					right join shop_discount_product_group dpg on d.dc_ix = dpg.dc_ix
					right join shop_discount_product_relation dpr on d.dc_ix = dpr.dc_ix and dpg.group_code = dpr.group_code
					where dpr.pid in (".implode(' , ', $_array_pid).") ";
            //echo nl2br($sql)."<br><br>";
            $slave_mdb->query($sql);
            $useable_discount_info = $slave_mdb->fetchall();
            if (is_array($useable_discount_info)) {
                foreach ($useable_discount_info as $key => $value) {
                    if ($value['dc_ix']) {
                        $useable_dc_ix[] = $value['dc_ix'];
                    }
                    if ($value['dpg_ix']) {
                        $useable_dpg_ix[] = $value['dpg_ix'];
                    }
                }
            }
        }

        $sql = "select d.dc_ix, d.discount_type, dpg.group_code, dpg.dpg_ix, dpg.commission, dpg.headoffice_rate, dpg.seller_rate, dpg.sale_rate, discount_sale_type, goods_display_type, display_auto_sub_type, round_type, ddr.r_ix as gp_ix, ddr2.r_ix
			from shop_discount d
			right join shop_discount_product_group dpg on d.dc_ix = dpg.dc_ix
			left join shop_discount_display_relation ddr on d.dc_ix = ddr.dc_ix and relation_type = 'G'
			left join shop_discount_display_relation ddr2 on d.dc_ix = ddr2.dc_ix and dpg.group_code = ddr2.group_code  and ddr2.relation_type = dpg.display_auto_sub_type
			where dpg.is_display = 'Y'
			and d.week_no_".date("N")." = '1' and d.is_use = '1'
			and ".time()." between discount_use_sdate and discount_use_edate
			and ((use_time = 1 and ".date("h")." between start_time and end_time and ".date("i")." between start_min and end_min) or use_time = 0 ) ";
        if (sess_val("user", "gp_ix")) {
            $sql .= "and (member_target = 'A' or (member_target = 'G' and ddr.r_ix = '".$_SESSION["user"]["gp_ix"]."' )) ";
        } else {
            $sql .= "and (member_target = 'A') ";
        }
        if (is_mobile()) {
            $sql .= "and d.discount_type = 'M' ";
        } else {
            $sql .= "and d.discount_type != 'M' ";
        }
        if (is_array($useable_dc_ix)) {
            //$sql .= "and d.dc_ix in (".implode(' , ',$useable_dc_ix).") ";
        }
        if (!empty($useable_dpg_ix)) {
            $sql .= "and ((goods_display_type = 'M' and dpg.dpg_ix in (".implode(' , ', $useable_dpg_ix).")) or goods_display_type = 'A')  ";
        } else {
            $sql .= "and (goods_display_type = 'A')  ";
        }

        //echo nl2br($sql);
        $script_times["discount_plan_start_".rand()] = time();
        $slave_mdb->query($sql);
        $plan_discount_info                          = $slave_mdb->fetchall();
        $script_times["discount_plan_end_".rand()]   = time();
        //echo "<b>".count($plan_discount_info)."</b>";
        //echo "<br><br><br><br><br>";

        if (is_array($plan_discount_info)) {
            $sql = "";

            for ($i = 0; ($i < count($plan_discount_info) && $i < 150); $i++) {
                if ($plan_discount_info[$i]['goods_display_type'] == "M") {
                    // 상품전시 타입이 수동일때
                    $union_sql = "select '".$plan_discount_info[$i]['discount_type']."' as discount_type, dpg.dpg_ix, dpg.dc_ix, dpg.group_name, p.id as pid , p.sellprice ,  dpg.commission, dpg.headoffice_rate, dpg.seller_rate, dpg.sale_rate, dpg.discount_sale_type, dpg.round_position, dpg.round_type, dpg.commission
						from shop_discount_product_group dpg , shop_discount_product_relation dpr ,   shop_product p
						where dpg.dc_ix = dpr.dc_ix and dpg.group_code = dpr.group_code and dpr.pid = p.id
						and dpg.dpg_ix = '".$plan_discount_info[$i]['dpg_ix']."'
						and p.id in (".implode(' , ', $_array_pid).") ";
                } else if ($plan_discount_info[$i]['goods_display_type'] == "A" && $plan_discount_info[$i]['display_auto_sub_type'] == "C") {
                    // 상품전시 타입이 자동일때 자동타입이 카테고리 일때
                    //$category_sql = "select cid, depth from shop_category_info ci , shop_discount_display_relation ddr where ci.cid = ddr.r_ix and ddr.relation_type = 'C' and dc_ix = '".$plan_discount_info[$i][dc_ix]."' and ddr.group_code = '".$plan_discount_info[$i][group_code]."' ";
                    $category_sql = "select cid, depth from shop_category_info ci  where cid = '".$plan_discount_info[$i]['r_ix']."' ";

                    $slave_mdb->query($category_sql);
                    $slave_mdb->fetch();
                    $cid       = $slave_mdb->dt['cid'];
                    $depth     = $slave_mdb->dt['depth'];
                    //echo $category_sql;
                    $union_sql = "select '".$plan_discount_info[$i]['discount_type']."' as discount_type,dpg.dpg_ix, dpg.dc_ix, dpg.group_name, p.id as pid , p.sellprice ,  dpg.commission, dpg.headoffice_rate, dpg.seller_rate, dpg.sale_rate, dpg.discount_sale_type, dpg.round_position, dpg.round_type, dpg.commission
						from shop_discount_product_group dpg , shop_discount_display_relation ddr , shop_product_relation pr,   shop_product p
						where dpg.dc_ix = ddr.dc_ix and dpg.group_code = ddr.group_code
						and relation_type = 'C' and substr(ddr.r_ix,0,".(($depth + 1) * 3).") = substr(pr.cid,0,".(($depth + 1) * 3).") and pr.pid = p.id
						and dpg.dpg_ix = '".$plan_discount_info[$i]['dpg_ix']."' and pr.cid LIKE '".(substr($cid, 0, ($depth + 1) * 3))."%'
						and p.id in (".implode(' , ', $_array_pid).") ";
                } else if ($plan_discount_info[$i]['goods_display_type'] == "A" && $plan_discount_info[$i]['display_auto_sub_type'] == "S") {
                    // 상품전시 타입이 자동일때 자동타입이 셀러 일때
                    $union_sql = "select '".$plan_discount_info[$i]['discount_type']."' as discount_type,dpg.dpg_ix, dpg.dc_ix, dpg.group_name, p.id as pid , p.sellprice ,  dpg.commission, dpg.headoffice_rate, dpg.seller_rate, dpg.sale_rate, dpg.discount_sale_type, dpg.round_position, dpg.round_type, dpg.commission
						from shop_discount_product_group dpg , shop_discount_display_relation ddr ,   shop_product p
						where dpg.dc_ix = ddr.dc_ix and dpg.group_code = ddr.group_code
						and relation_type = 'S' and ddr.r_ix = p.admin
						and dpg.dpg_ix = '".$plan_discount_info[$i]['dpg_ix']."'
						and p.id in (".implode(' , ', $_array_pid).") ";
                } else if ($plan_discount_info[$i]['goods_display_type'] == "A" && $plan_discount_info[$i]['display_auto_sub_type'] == "B") {
                    // 상품전시 타입이 자동일때 자동타입이 브랜드 일때
                    $union_sql = "select '".$plan_discount_info[$i]['discount_type']."' as discount_type, dpg.dpg_ix, dpg.dc_ix, dpg.group_name, p.id as pid , p.sellprice ,  dpg.commission, dpg.headoffice_rate, dpg.seller_rate, dpg.sale_rate, dpg.discount_sale_type, dpg.round_position, dpg.round_type, dpg.commission
						from shop_discount_product_group dpg , shop_discount_display_relation ddr ,   shop_product p
						where dpg.dc_ix = ddr.dc_ix and dpg.group_code = ddr.group_code
						and relation_type = 'B' and ddr.r_ix = p.brand
						and dpg.dpg_ix = '".$plan_discount_info[$i]['dpg_ix']."'
						and p.id in (".implode(' , ', $_array_pid).") ";
                }
                if (!$sql) {
                    $sql = $union_sql."\n";
                } else {
                    $sql .= "union \n".$union_sql;
                }

                //echo "<br><br>";
            }
            if ($_array_pid[0] == "0000223298") {
                //echo nl2br($sql);
                //exit;
            }
            //exit;
            if ($sql) {

                //2015-12-01 Hong 할인 순서 때문에 추가
                $sql .= "order by (case when discount_type='GP' then 1 when discount_type='SP' then 2 else 3 end) asc ";

                $script_times["discount_plan_detail_start_".rand()] = time();
                $slave_mdb->query($sql);
                $_discount_info                                     = $slave_mdb->fetchall();
                $script_times["discount_plan_detail_end_".rand()]   = time();
            }
            if ($_array_pid[0] == "0000223298") {
                //	print_r($_discount_info);
                //	exit;
            }

            for ($i = 0; $i < count($_discount_info); $i++) {
                //echo $_discount_info[$i][pid]."<br>";
                $pid = str_pad($_discount_info[$i]['pid'], 10, "0", STR_PAD_LEFT);
                //echo $pid;
                if ($_discount_info[$i]['discount_sale_type'] == 2) {
                    $discount_price = $_discount_info[$i]['sale_rate'];
                } else {
                    $discount_price = $_discount_info[$i]['sellprice'] * $_discount_info[$i]['sale_rate'] / 100;
                }

                if ($i == 0 || $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_price"] < $discount_price) {

                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["pid"]                 = $pid;
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_type"]       = $_discount_info[$i]['discount_type'];
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_desc"]       = $_discount_info[$i]['group_name'];
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_price"]      = $discount_price;
                    //$discount_info[$pid][$_discount_info[$i][discount_type]]["sellprice"] = $_discount_info[$i][sellprice];
                    //$discount_info[$pid][$_discount_info[$i][discount_type]]["dcprice"] = $_discount_info[$i][sellprice]*((100-$_discount_info[$i][sale_rate])/100);
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_value"]      = $_discount_info[$i]['sale_rate'];
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_value_type"] = $_discount_info[$i]['discount_sale_type'];
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["round_position"]      = $_discount_info[$i]['round_position']; // 1, 2, 3
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["round_type"]          = $_discount_info[$i]['round_type']; // 1: 반올림, 2:반내림, 3: 올림, 4: 내림

                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["headoffice_discount_value"] = $_discount_info[$i]['headoffice_rate'];
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["seller_discount_value"]     = $_discount_info[$i]['seller_rate'];
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["discount_code"]             = $_discount_info[$i]['dpg_ix'];
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["dc_ix"]                     = $_discount_info[$i]['dc_ix'];
                    $discount_info[$pid][$_discount_info[$i]['discount_type']]["commission"]                = $_discount_info[$i]['commission'];
                }
            }
            //print_r($discount_info);
        }

        //dc_type 할인타입(MC:복수구매,MG:그룹,C:카테고리,GP:기획,SP:특별,CP:쿠폰,SCP:중복쿠폰,M:모바일,APP:앱할인,E:에누리,DCP:배송쿠폰,DE:배송비에누리)
        if (is_array($_array_pid) && sess_val("user", 'app_dc_rate') > 0) {
            foreach ($_array_pid as $pid) {

                $pid                                               = str_pad($pid, 10, "0", STR_PAD_LEFT);
                $discount_info[$pid]['APP']["pid"]                 = $pid;
                $discount_info[$pid]['APP']["discount_type"]       = 'APP';
                //$discount_info[$pid]['APP']["sellprice"] = $_discount_info[$i][sellprice];
                //$discount_info[$pid]['APP']["dcprice"] = $_discount_info[$i][sellprice]*((100-$_discount_info[$i][sale_rate])/100);
                $discount_info[$pid]['APP']["discount_value"]      = $_SESSION["user"]['app_dc_rate'];
                $discount_info[$pid]['APP']["discount_value_type"] = "1"; // 1:%, 2:원
                $discount_info[$pid]['APP']["round_position"]      = $_SESSION["user"]['round_depth']; // 1, 2, 3
                $discount_info[$pid]['APP']["round_type"]          = $_SESSION["user"]['round_type']; // 1: 반올림, 2:반내림, 3: 올림, 4: 내림

                $discount_info[$pid]['APP']["headoffice_discount_value"] = $_SESSION["user"]['app_dc_rate'];
                $discount_info[$pid]['APP']["seller_discount_value"]     = 0;
                $discount_info[$pid]['APP']["discount_code"]             = $_SESSION['app_type'];
            }
        }

        return $discount_info;
    }
}

if (!function_exists('getExchangeNationPrice')) {

    function getExchangeNationPrice($price, $numFormatBool = false, $input_exchange_rate = false)
    {
        if (sess_val("layout_config", "front_language") == "korean" || sess_val("layout_config", "front_language") == "Japanese") {
            return ($numFormatBool ? getExchangeNationPriceNumberFormat($price) : $price );
        }

        if ($input_exchange_rate === false) {
            $exchange_rate = getExchangeNationRate();
        } else {
            $exchange_rate = $input_exchange_rate;
        }
        $return_priece = roundBetterUp($price / $exchange_rate, 2);

        return ($numFormatBool ? getExchangeNationPriceNumberFormat($return_priece) : $return_priece );
    }
}

if (!function_exists('PrintImage')) {

    //상품아이디로 이미지 불러오기...
    function PrintImage($basedir, $Pid, $type = "b", $image_db = "", $noimgType = "shop", $image_type = "")
    {
        global $DOCUMENT_ROOT, $slave_mdb;
        global $image_hosting_type;
        //return $Pid;
        $Pid     = zerofill($Pid);
        $imgdir  = UploadDirText($basedir, $Pid);
        $imgpath = $basedir.$imgdir;

        $is_adult_bool = true;

        //19금 이미지 처리
        if (sess_val('user', 'age') < '19' && !substr_count($_SERVER['PHP_SELF'], '/admin/')) {
            $is_adult_bool = false;
        }

        if (!$is_adult_bool) {
            $sql = "select id from shop_product where id='".$Pid."' and is_adult='1' ";
            $slave_mdb->query($sql);
        }

        if (!$is_adult_bool && $slave_mdb->total) {
            $imageSrc = $basedir."/product_19_200.gif";
        } else {

            if ($image_hosting_type == "ftp") {
                //echo $type."<br>";
                $imageSrc = $image_db[$type."img"];
            } else {
                $imageSrc  = $imgpath."/".$type."_".$Pid."".$image_type.".gif";
                //return $imageSrc;
                $imageSrc2 = $imgpath."/".$type."_".$Pid."".$image_type.".jpg";  // 외부이미지서버에서 jpg 파일을 퍼왔을경우 jpg도 체크하도록 추가 : 이현우(2013-05-06)
                //echo $DOCUMENT_ROOT.$imageSrc."<br>";
                if (!file_exists($DOCUMENT_ROOT.$imageSrc)) {
                    if (!file_exists($DOCUMENT_ROOT.$imageSrc2)) {
                        if (!file_exists($DOCUMENT_ROOT.$basedir."/".$noimgType."/noimg.gif")) {
                            $imageSrc = $basedir."/noimg.gif";
                        } else {
                            $imageSrc = $basedir."/".$noimgType."/noimg.gif";
                        }
                    } else {
                        $imageSrc = $imageSrc2;
                    }
                }
            }
        }



        return constant("IMAGE_SERVER_DOMAIN").$imageSrc;
    }
}


if (!function_exists('UploadDirText')) {

    //상품아이디로 폴더명 지정하기...
    function UploadDirText($basedir, $Pid, $mode = "N")
    {

        $Pid    = zerofill($Pid);
        //echo $Pid."<br>";
        $fstdir = "/".substr($Pid, 0, 2);
        $sedir  = "/".substr($Pid, 2, 2);
        $thdir  = "/".substr($Pid, 4, 2);
        $fordir = "/".substr($Pid, 6, 2);
        $fifdir = "/".substr($Pid, 8, 2);
        if ($mode == "Y") {
            if (!is_dir($basedir.$fstdir)) {

                mkdir($basedir.$fstdir);
                chmod($basedir.$fstdir, 0777);
            }
            if (!is_dir($basedir.$fstdir.$sedir)) {
                mkdir($basedir.$fstdir.$sedir);
                chmod($basedir.$fstdir.$sedir, 0777);
            }
            //echo $basedir.$fstdir.$sedir.$thdir;
            if (!is_dir($basedir.$fstdir.$sedir.$thdir)) {
                mkdir($basedir.$fstdir.$sedir.$thdir);
                chmod($basedir.$fstdir.$sedir.$thdir, 0777);
            }
            if (!is_dir($basedir.$fstdir.$sedir.$thdir.$fordir)) {
                mkdir($basedir.$fstdir.$sedir.$thdir.$fordir);
                chmod($basedir.$fstdir.$sedir.$thdir.$fordir, 0777);
            }
            if (!is_dir($basedir.$fstdir.$sedir.$thdir.$fordir.$fifdir)) {
                mkdir($basedir.$fstdir.$sedir.$thdir.$fordir.$fifdir);
                chmod($basedir.$fstdir.$sedir.$thdir.$fordir.$fifdir, 0777);
            }
        }
        //exit;
        return $fstdir.$sedir.$thdir.$fordir.$fifdir;
    }
}

if (!function_exists('getExchangeNationPrice')) {

    function getExchangeNationPrice($price, $numFormatBool = false, $input_exchange_rate = false)
    {
        if ($_SESSION["layout_config"]["front_language"] == "korean" || $_SESSION["layout_config"]["front_language"] == "Japanese") {
            return ($numFormatBool ? getExchangeNationPriceNumberFormat($price) : $price );
        }

        if ($input_exchange_rate === false) {
            $exchange_rate = getExchangeNationRate();
        } else {
            $exchange_rate = $input_exchange_rate;
        }
        $return_priece = roundBetterUp($price / $exchange_rate, 2);

        return ($numFormatBool ? getExchangeNationPriceNumberFormat($return_priece) : $return_priece );
    }
}

if (!function_exists('getExchangeNationPriceNumberFormat')) {

    function getExchangeNationPriceNumberFormat($price)
    {
        if ($_SESSION["layout_config"]["front_language"] == "english") {
            $return_price = number_format($price, 2);
        } else {
            $return_price = number_format($price);
        }
        return $return_price;
    }
}

if (!function_exists('cartList')) {

    function cartList($code, $cnt = 5)
    {

        global $shop_product_type;
        global $slave_mdb;
        //$slave_mdb = new Database;
        //장바구니
        $sql   = "select c.*, p.shotinfo from shop_cart c, ".TBL_SHOP_PRODUCT." p
			where c.id = p.id and c.mem_ix='".$code."' and c.product_type in (".implode(' , ', $shop_product_type).")
			AND est_ix = '0'
			GROUP BY id
			order by c.regdate
			limit 0, $cnt
			"; //AND c.delivery_package = 'N'
        //$sql = "select c.*, p.shotinfo from shop_cart c, ".TBL_SHOP_PRODUCT." p where c.id = p.id and c.mem_ix='".$code."' and c.product_type in (".implode(' , ',$shop_product_type).") order by c.regdate desc limit 0,$cnt";
        $slave_mdb->query($sql);
        $carts = $slave_mdb->fetchall();
        if (is_array($carts)) {
            foreach ($carts as $key => $sub_array) {
                $goods_infos[$carts[$key]['id']]['pid']    = $carts[$key]['id'];
                $goods_infos[$carts[$key]['id']]['amount'] = 1;
                $goods_infos[$carts[$key]['id']]['cid']    = $carts[$key]['cid'];
                $goods_infos[$carts[$key]['id']]['depth']  = 1; //$carts[0][depth];
            }
            $discount_info = DiscountRult($goods_infos); // $carts[0][cid], $carts[0][depth]);
        }

        if (is_array($carts)) {
            foreach ($carts as $key => $sub_array) {

                $select_ = array("icons_list" => explode(";", $sub_array['icons']));
                array_insert($sub_array, 14, $select_);

                $discount_item = $discount_info[$sub_array['id']];
                //print_r($discount_item);
                $_dcprice      = $sub_array['sellprice'];
                if (is_array($discount_item)) {
                    foreach ($discount_item as $_key => $_item) {
                        if ($_item['discount_value_type'] == "1") { // %
                            //echo $_item[discount_value]."<br>";
                            $_dcprice = roundBetter($_dcprice * (100 - $_item['discount_value']) / 100, $_item['round_position'], $_item['round_type']); //$_dcprice*(100 - $_item[discount_value])/100;
                            /*
                              echo "round_position : ".$_item[round_position]."<br>";
                              echo "round_type : ".$_item[round_type]."<br>";
                              echo "이전할인가 : ".$_dcprice."<br>";
                              echo roundBetter($_dcprice*(100 - $_item[discount_value])/100, $_item[round_position], $_item[round_type]) ;			;
                             */
                        } else if ($_item['discount_value_type'] == "2") {// 원
                            $_dcprice = $_dcprice - $_item['discount_value'];
                        }
                        $_item['expectation_discount_price'] = $sub_array['sellprice'] - $_dcprice;
                        //$discount_desc[] = $_item[discount_type]."-".$_item[discount_value]." ".($_item[discount_value_type] == "1" ? "%":"원")."-".$_dcprice."원";
                        $discount_desc[]                     = $_item;
                    }
                    //print_r($discount_desc);
                }
                $_dcprice      = array("dcprice" => $_dcprice);
                array_insert($sub_array, 52, $_dcprice);
                $discount_desc = array("discount_desc" => $discount_desc);
                array_insert($sub_array, 53, $discount_desc);

                $carts[$key] = $sub_array;
            }
        }

        if (count($carts)) {
            for ($i = 0; $i < count($carts); $i++) {
                $carts[$i]['listprice'] = getExchangeNationPrice($carts[$i]['listprice']);
                $carts[$i]['sellprice'] = getExchangeNationPrice($carts[$i]['sellprice']);
                $carts[$i]['dcprice']   = getExchangeNationPrice($carts[$i]['dcprice']);
            }
        }


        return $carts;
    }
}

if (!function_exists('getGlobalBBSName')) {

    //** 게시판 이름 예외처리
    function getGlobalBBSName($bbs_name, $language = "")
    {

        if (empty($language)) {
            //$language = $_SESSION["layout_config"]["front_language"];
            $language = "korea";
        }

        switch ($bbs_name) {
            case 'notice':
                if ($language == 'english') {
                    return 'en_notice';
                } else {
                    return 'notice';
                }
                break;

            case 'qna':
                if ($language == 'english') {
                    return 'en_qna';
                } else {
                    return 'qna';
                }
                break;

            case 'faq':
                if ($language == 'english') {
                    return 'en_faq';
                } else {
                    return 'faq';
                }
                break;
        }
    }
}

if (!function_exists('blindString')) {

    function blindString($len, $sign, $str)
    {
        // $str 문자열을 $len을 제외하고 $sign문자로 변경
        // $len = 3, $sing = *, $str = forbiz => for***
        $cut_len = mb_strlen($str, "utf-8");
        $dot     = "";
        for ($i = 0; $i < ($cut_len - $len); $i++) {
            $dot .= $sign;
        }
        $replace = str_replace(substr($str, $len, $cut_len), $dot, $str);
        return $replace;
    }
}



if (!function_exists('getRegistWishlistYn')) {

    function getRegistWishlistYn($id)
    {
        global $user;
        global $slave_mdb;
        if ($user['code'] == "") {
            return "";
        }

        $sql    = "select wid from shop_wishlist where mid = '".$user['code']."' and pid='".$id."' ";
        $slave_mdb->query($sql);
        $ptotal = $slave_mdb->total;

        if ($ptotal == 0) {
            return 0;
        } else {
            return $ptotal;
        }
    }
}

if (!function_exists('template_search_date')) {
    /*
      $sdate_name : 시작날짜 input name	이 값을 기준으로 시,분,초 name 과 id 생성
      $edate_name : 마감날짜 input name
      $basic_sdate : 시작날짜 기본값
      $basic_edate : 마감날짜 기본값
      $use_time	: 시간사용시 Y 값을 넘김
     */

    function template_search_date($sdate_name, $edate_name, $basic_sdate = '', $basic_edate = '', $use_time = '', $oneside = false)
    {


        global $_LANGUAGE;
        global $_SESSION;

        $vdate        = date("Y-m-d", time());
        $today        = date("Y-m-d", time());
        $vyesterday   = date("Y-m-d", time() - 86400);
        $voneweekago  = date("Y-m-d", time() - 86400 * 7);
        $v15ago       = date("Y-m-d", time() - 86400 * 15);
        $vonemonthago = date("Y-m-d", mktime(0, 0, 0, substr($vdate, 5, 2) - 1, substr($vdate, 8, 2) + 1, substr($vdate, 0, 4)));
        $v2monthago   = date("Y-m-d", mktime(0, 0, 0, substr($vdate, 5, 2) - 2, substr($vdate, 8, 2) + 1, substr($vdate, 0, 4)));
        $v3monthago   = date("Y-m-d", mktime(0, 0, 0, substr($vdate, 5, 2) - 3, substr($vdate, 8, 2) + 1, substr($vdate, 0, 4)));

        $v6monthago  = date("Y-m-d", mktime(0, 0, 0, substr($vdate, 5, 2) - 6, substr($vdate, 8, 2) + 1, substr($vdate, 0, 4)));
        $v12monthago = date("Y-m-d", mktime(0, 0, 0, substr($vdate, 5, 2) - 12, substr($vdate, 8, 2) + 1, substr($vdate, 0, 4)));

        $basic_sdate_array = explode(" ", $basic_sdate); //넘어온값에 시간이 붙어잇을경우 짤라서 시간을 따로 변수에 담아둠
        $basic_sdate_ymd   = $basic_sdate_array[0];

        $basic_edate_array = explode(" ", $basic_edate); //넘어온값에 시간이 붙어잇을경우 짤라서 시간을 따로 변수에 담아둠
        $basic_edate_ymd   = $basic_edate_array[0];

        if ($use_time == 'Y') { //시 까지 사용할경우 처리
            if ($basic_sdate_array[1]) {
                $start_time_h = strftime('%H', strtotime($basic_sdate));
                $start_time_i = strftime('%M', strtotime($basic_sdate));
                $start_time_s = strftime('%S', strtotime($basic_sdate));
            }

            if ($basic_edate_array[1]) {
                $end_time_h = strftime('%H', strtotime($basic_edate));
                $end_time_i = strftime('%M', strtotime($basic_edate));
                $end_time_s = strftime('%S', strtotime($basic_edate));
            }

            $start_time_select = "<select name='".$sdate_name."_h' id='".$sdate_name."_h'>";
            for ($i = 0; $i < 24; $i++) {
                $start_time_select .= "<option value='".$i."' ".($start_time_h == $i ? 'selected' : '').">".$i."</option>";
            }
            $start_time_select .= "</select> 시";

            $start_time_select .= "<select name='".$sdate_name."_i' id='".$sdate_name."_i'>";
            for ($i = 1; $i < 60; $i++) {
                $start_time_select .= "<option value='".$i."' ".($start_time_i == $i ? 'selected' : '').">".$i."</option>";
            }
            $start_time_select .= "</select> 분";

            $start_time_select .= "<select name='".$sdate_name."_s' id='".$sdate_name."_s'>";
            for ($i = 1; $i < 60; $i++) {
                $start_time_select .= "<option value='".$i."' ".($start_time_s == $i ? 'selected' : '').">".$i."</option>";
            }
            $start_time_select .= "</select> 초";


            $end_time_select = "<select name='".$edate_name."_h' id='".$edate_name."_h'>";
            for ($i = 0; $i < 24; $i++) {
                $end_time_select .= "<option value='".$i."' ".($end_time_h == $i ? 'selected' : '').">".$i."</option>";
            }
            $end_time_select .= "</select> 시";

            $end_time_select .= "<select name='".$edate_name."_i' id='".$edate_name."_i'>";
            for ($i = 1; $i < 60; $i++) {
                $end_time_select .= "<option value='".$i."' ".($end_time_i == $i ? 'selected' : '').">".$i."</option>";
            }
            $end_time_select .= "</select> 분";

            $end_time_select .= "<select name='".$edate_name."_s' id='".$edate_name."_s'>";
            for ($i = 1; $i < 60; $i++) {
                $end_time_select .= "<option value='".$i."' ".($end_time_s == $i ? 'selected' : '').">".$i."</option>";
            }
            $end_time_select .= "</select> 초";
        }

        $Contents .= "
		<span>
			<span>
				<input type='text' id='".$sdate_name."' name='".$sdate_name."' value='".$basic_sdate_ymd."' style='width:65px;' class='date-pick inputbox_05 font-en' />
			</span>
			<span>
				<input type='text' id='".$edate_name."' name='".$edate_name."' value='".$basic_edate_ymd."' style='width:65px;' class='date-pick inputbox_05 font-en' />
			</span>
		</span>

				<div class='jq-radio'>
					<a href=\"javascript:".$sdate_name."('$today','$today',1);\" onFocus='this.blur();'class='btn_date today'>"
            .getLanguageText('e1e8a7b4021650c6fbad08d9088dcd69').
            "</a>
					";

        if (!$oneside) {
            $Contents .= "<a href=\"javascript:".$sdate_name."('$voneweekago','$today',1);\" onFocus='this.blur();'class='btn_date'>"
                .getLanguageText('50c63d30b6d77cb58a8d48629b57fe01').
                "</a>
					";
        }

        $Contents .= "<a href=\"javascript:".$sdate_name."('$vonemonthago','$today', 1);\" onFocus='this.blur();'class='btn_date'>"
            .getLanguageText('df140b9da555206ce88221bdb443cb0a').
            "</a>
					<a href=\"javascript:".$sdate_name."('$v6monthago','$today',1);\" onFocus='this.blur();'class='btn_date'>"
            .getLanguageText('2b3997b1d85897c1f361801ee64badef').
            "</a>
					<a href=\"javascript:".$sdate_name."('$v12monthago','$today',1);\" onFocus='this.blur();' class='btn_date'>"
            .getLanguageText('3d5bb6802bf417e31fe7d7a8b2410d82').
            "</a>
				</div>

		<script type='text/javascript'>
		<!--
		function ".$sdate_name."(FromDate,ToDate,dType) {
			var frm = document.search_frm;
			$('#".$sdate_name."').val(FromDate);
			$('#".$edate_name."').val(ToDate);
		}

		$(document).ready(function (){
			$('#".$sdate_name."').datepicker({
				//changeMonth: true,
				//changeYear: true,
				monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
				dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				showMonthAfterYear:true,
				dateFormat: 'yy-mm-dd',
				buttonImageOnly: true,
				buttonText: '달력',
				//prevText: '先月',
				//nextText: '来月',
				//currentText: '今日',
				//monthNames: ['年 1月','年 2月','年 3月','年 4月','年 5月','年 6月','年 7月','年 8月','年 9月','年 10月','年 11月','年 12月'],
				//monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
				//dayNames: ['日','月','火','水','木','金','土'],
				//dayNamesShort: ['日','月','火','水','木','金','土'],
				//dayNamesMin: ['日','月','火','水','木','金','土'],
				//weekHeader: 'Wk',
				//dateFormat: 'yy-mm-dd',
				//firstDay: 0,
				//isRTL: false,
				//showMonthAfterYear: true,
				//yearSuffix: '',

				onSelect: function(dateText, inst){
					if($('#".$edate_name."').val() != '' && $('#".$edate_name."').val() <= dateText){
						$('#".$edate_name."').val(dateText);
					}else{
						$('#".$edate_name."').datepicker('setDate','+0d');
					}
				}
			});

			$('#".$edate_name."').datepicker({
				//changeMonth: true,
				//changeYear: true,
				monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
				dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				showMonthAfterYear:true,
				dateFormat: 'yy-mm-dd',
				buttonImageOnly: true,
				buttonText: '달력',
//				prevText: '先月',
//				nextText: '来月',
//				currentText: '今日',
//				monthNames: ['年 1月','年 2月','年 3月','年 4月','年 5月','年 6月','年 7月','年 8月','年 9月','年 10月','年 11月','年 12月'],
//				monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
//				dayNames: ['日','月','火','水','木','金','土'],
//				dayNamesShort: ['日','月','火','水','木','金','土'],
//				dayNamesMin: ['日','月','火','水','木','金','土'],
//				weekHeader: 'Wk',
//				dateFormat: 'yy-mm-dd',
//				firstDay: 0,
//				isRTL: false,
//				showMonthAfterYear: true,
//				yearSuffix: '',

			});
		});
		//-->
		</script>
	";

        return $Contents;
    }
}

if (!function_exists('getLanguageText')) {

    function getLanguageText($trans_key)
    {
        global $_LANGUAGE, $_LANGUAGE_CHECK_TRANS_KEY, $master_db;

        //운영 중일떄는 false 로 해야함
        //if(false){
        if (!($_LANGUAGE_CHECK_TRANS_KEY[$trans_key] ?? '') && true) {
            $sql = "update global_translation set call_cnt = ifnull(call_cnt,0) + 1 where trans_key = '".$trans_key."' ";
            $master_db->query($sql);

            //호출 페이지당 한번만 업데이트하기 위해서
            $_LANGUAGE_CHECK_TRANS_KEY[$trans_key] = true;
        }

        return htmlspecialchars_decode($_LANGUAGE[$trans_key]);
    }
}

// 메인페이지 시작
if (!function_exists('getScheduleBannerInfo')) {

    function getScheduleBannerInfo($banner_position, $display_cid = "", $bool_subcategory = false)
    {

        //global $script_times;
        global $slave_mdb;

        //$slave_mdb = new MySQL;

        if ($bool_subcategory) {

            if ($display_cid != "") {
                $sub_cid = substr($display_cid, 0, 3);
                $sql     = "select depth, cid
							from shop_category_info where cid like '".substr($sub_cid, 0, 3)."%' ";

                $slave_mdb->query($sql);

                if ($slave_mdb->total) {

                    $cid_list = array();
                    for ($i = 0; $i < $slave_mdb->total; $i++) {
                        $slave_mdb->fetch($i);
                        $cid_list[$i] = $slave_mdb->dt['cid'];
                    }

                    $cid_list = implode(",", $cid_list);

                    //$add_where = " and display_cid = '".substr($display_cid,0, ($slave_mdb->dt[depth]+1)*3)."' ";
                    $add_where = " and display_cid in ( ".$cid_list." )";
                }
            }
        } else {

            if ($display_cid != "") {
                $sql = "select depth
							from shop_category_info where cid = '".$display_cid."' ";
                $slave_mdb->query($sql);
                if ($slave_mdb->total) {
                    $slave_mdb->fetch();

                    //$add_where = " and display_cid = '".substr($display_cid,0, ($slave_mdb->dt[depth]+1)*3)."' ";
                    $add_where = " and display_cid = '".$display_cid."' ";
                }
            }
        }


        $sql = "select b.banner_ix , b.banner_kind , b.banner_name
						from shop_bannerinfo b
						where banner_position = '$banner_position '
						".$add_where."
						and NOW() between use_sdate and use_edate
						and mall_ix in (NULL,'','".$_SESSION['layout_config']['mall_ix']."')
						order by rand() limit 1 ";



        $slave_mdb->query($sql);

        if ($slave_mdb->total) {
            $slave_mdb->fetch();
            $script_times["banner_".$banner_position."_".$slave_mdb->dt['banner_ix']] = $slave_mdb->dt['banner_name'];
            //echo nl2br($sql);
            //echo "banner_ix:".$slave_mdb->dt[banner_ix];
            return getBannerInfo($slave_mdb->dt['banner_ix']);
        } else {
            return "";
        }
    }
}

if (!function_exists('get_maingoods_list')) {

    function get_maingoods_list($div_code = "")
    { // dev2 프론토 메인 전시  불러오기 2013-11-21 이학봉
        global $slave_mdb;
        //h$slave_mdb = new Database;

        $now_date   = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        if ($div_code != "") $add_query  = " AND md.div_code='".$div_code."' ";
        $sql        = "select
						md.div_ix,
						md.div_code,
						mg.mg_title,
						mg.mg_ix,
						mg.mp_ix,
						mg.mg_link
					from
						shop_main_div  as md
						inner join shop_main_goods as mg on (md.div_ix = mg.div_ix)
					where
						md.disp = '1' AND mg.disp = '1' ".$add_query."
						and '".time()."' between mg.mg_use_sdate and mg.mg_use_edate ";
        //	echo nl2br($sql);
        //	echo $sql;
        //	exit;
        $slave_mdb->query($sql);
        $data_array = $slave_mdb->fetchall();
        //print_r($data_array);
        //exit;
        return $data_array;
    }
}

if (!function_exists('getDisplayGoodsInfo')) {

    function getDisplayGoodsInfo($div_code = "BASIC", $mg_ixs = "", $group_codes = "", $display_goods_cnt = "", $limitStart = 0, $limitEnd = '')
    {
        global $slave_mdb, $shop_product_type, $layout_config, $_SESSION;
        global $script_times;

        //$script_times["get_display_".$div_code."_".$group_codes."_start_".rand()] = time();
        $reserve_data = GetReserveRate(); //적립금 정보 가져오기 함수 생성 2014-06-04 이학봉

        if ($reserve_data['reserve_use_yn'] == "Y") {
            $reserve_sql = " ,case when p.reserve_yn = 'N' then round(sellprice*(".$reserve_data['goods_reserve_rate']."/100)) else round(sellprice*(reserve_rate/100)) end as reserve";
        }

        if (is_array($mg_ixs)) {
            $mg_ix_str = " and erp.mg_ix in (".implode(",", $mg_ixs).") ";
        } else if ($mg_ixs != "") {
            $mg_ix_str = " and erp.mg_ix = '".$mg_ixs."' ";
        }

        if (is_array($group_codes)) {
            $group_code_str = " and group_code in (".implode(",", $group_codes).") ";
        } else if ($group_codes != "") {
            //$group_code = $group_codes;
            $group_code_str = " and group_code = '".$group_codes."' ";
        }

        if (!empty($div_code)) {
            $sql = "SELECT
							*
						FROM
							shop_main_product_group erp
						where
							div_code = '".$div_code."'
							and use_yn ='Y'
							".$mg_ix_str."
							".$group_code_str."
						ORDER BY group_code ASC ";
        } else {
            $sql = "SELECT
							*
						FROM
							shop_main_product_group erp
						where
							group_code is not null
							and use_yn ='Y'
							".$mg_ix_str."
							".$group_code_str."
						ORDER BY group_code ASC "; //div_code = '".$div_code."' and
        }
        //echo nl2br($sql)."<br>";
        //$script_times["get_display_".$div_code."_".$group_codes."_query1_start_".rand()] = time();
        $slave_mdb->query($sql);
        $displayGoods = $slave_mdb->fetchall();
        //echo "<pre>";
        //print_r($displayGoods);
        //$script_times["get_display_".$div_code."_".$group_codes."_query1_end_".rand()] = time();

        /**
         * 도매몰일때 도매가로 결제하도록 wholesale_price를 sellprice로 가져오기 bgh
         *
         * sellprice를 $select_price로 대체
         */
        /*
          if(UserSellingType() == 'W'){
          $select_price = 'wholesale_price as listprice, wholesale_sellprice as sellprice, sellprice AS ori_sellprice , pa.wholesale_free_delivery_yn as free_delivery_yn ';
          }else{
          $select_price = 'sellprice, listprice , pa.free_delivery_yn as free_delivery_yn';
          }
         */
        if (UserSellingType() == 'W') {
            if (UserProductPriceType() == 'L') {
                $select_price = 'wholesale_price as listprice, wholesale_price as sellprice, sellprice AS ori_sellprice, 0 as sale_rate ,  (listprice-sellprice)/listprice*100 as b2c_sale_rate , pa.wholesale_free_delivery_yn as free_delivery_yn ';
            } else {
                $select_price = 'wholesale_price as listprice, wholesale_sellprice as sellprice, sellprice AS ori_sellprice, (wholesale_price-wholesale_sellprice)/wholesale_price*100 as sale_rate ,  (listprice-sellprice)/listprice*100 as b2c_sale_rate , pa.wholesale_free_delivery_yn as free_delivery_yn ';
            }
        } else {
            if (UserProductPriceType() == 'P') {
                $select_price = 'premiumprice as sellprice, listprice, (listprice-premiumprice)/listprice*100 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
            } elseif (UserProductPriceType() == 'L') {
                $select_price = 'listprice as sellprice, listprice, 0 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
            } else {
                $select_price = 'sellprice, listprice, (listprice-sellprice)/listprice*100 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
            }
        }

        $nowdate = date('Y-m-d 00:00:00');

        for ($i = 0; $i < count($displayGoods); $i++) {
            switch ($displayGoods[$i]["display_type"]) {
                case ("0") : $goods_list_cnt = "5";
                    break;
                case ("1") : $goods_list_cnt = "4";
                    break;
                case ("2") : $goods_list_cnt = "3";
                    break;
                case ("3") : $goods_list_cnt = "4";
                    break;
                case ("4") : $goods_list_cnt = "7";
                    break;
                case ("5") : $goods_list_cnt = "4";
                    break;
                case ("6") : $goods_list_cnt = "6";
                    break;
                default : $goods_list_cnt = "4";
                    break;
            }
            if ($display_goods_cnt == "") {
                $display_goods_cnt_query = $displayGoods[$i]['product_cnt'];
            } else {
                $display_goods_cnt_query = $display_goods_cnt;
            }
            if ($display_goods_cnt_query == "" || $display_goods_cnt_query == "0") {
                $display_goods_cnt_query = 5;
            }//$display_goods_cnt => $display_goods_cnt_query 로 변경함 kbk 13/02/15

            if (is_mobile()) {
                $is_mobile_use_where = " and p.is_mobile_use in ('A','M')";
            } else {
                $is_mobile_use_where = " and p.is_mobile_use in ('A','W')";
            }
            if ($displayGoods[$i]['goods_display_type'] == "A") {
                if ($displayGoods[$i]['display_auto_priod'] != "") {
                    if ($displayGoods[$i]['display_auto_type'] == "order_cnt") {//구매순
                        //$select_str=", order_buy_cnt";
                        //$select_leftjoin_str=" left join (select pid, sum(pcnt) as order_buy_cnt from shop_order_detail od where   od.status not in ('".ORDER_STATUS_SETTLE_READY."','".ORDER_STATUS_REPAY_READY."','".ORDER_STATUS_EXCHANGE_COMPLETE."','".ORDER_STATUS_EXCHANGE_AGAIN_DELIVERY."') and od.regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY) group by pid ) od on od.pid=p.id ";
                        //$orderby_str = "order_buy_cnt desc";
                        $orderby_str = "pa.order_cnt_".$displayGoods[$i]['display_auto_priod']." desc";
                    } elseif ($displayGoods[$i]['display_auto_type'] == "view_cnt") {//클릭순
                        //$select_str=", com_view_cnt";
                        //$select_leftjoin_str=" left join (select pid, sum(nview_cnt) as com_view_cnt from commerce_viewingview cv where   cv.vdate between date_format(DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY),'%Y%m%d')  and  date_format(DATE_SUB('".$nowdate."', INTERVAL 1 DAY),'%Y%m%d') group by pid ) od on od.pid=p.id  ";
                        //$orderby_str = "com_view_cnt desc";
                        $orderby_str = "pa.view_cnt_".$displayGoods[$i]['display_auto_priod']." desc";
                    } elseif ($displayGoods[$i]['display_auto_type'] == "sellprice") {//최저가순
                        if ($layout_config['mall_type'] == 'BW') {
                            $order_select_price = 'p.wholesale_price';
                        } else {
                            $order_select_price = 'p.sellprice';
                        }
                        $orderby_str = " $order_select_price asc";

                        $priod_where = " and p.regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i]['display_auto_priod']." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY) ";
                    } elseif ($displayGoods[$i]['display_auto_type'] == "regdate") {
                        $orderby_str = "p.id DESC";
                    } elseif ($displayGoods[$i]['display_auto_type'] == "regdate_asc") {
                        $orderby_str = "p.id ASC";
                    } elseif ($displayGoods[$i]['display_auto_type'] == "wish_cnt") {
                        //$select_str=", list_wish_cnt";
                        //$select_leftjoin_str=" left join (select pid, count(*) as list_wish_cnt from shop_wishlist w where  w.regdate between date_format(DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY),'%Y-%m-%d')  and  date_format(DATE_SUB('".$nowdate."', INTERVAL 1 DAY),'%Y-%m-%d') group by pid ) od on od.pid=p.id ";
                        //$orderby_str = "list_wish_cnt desc";
                        $orderby_str = "pa.wish_cnt_".$displayGoods[$i]['display_auto_priod']." desc";
                    } elseif ($displayGoods[$i]['display_auto_type'] == "after_score") {
                        //$select_str=", avg_after_score ";
                        /*
                          $select_leftjoin_str=" left join (
                          select pid , avg(avg_after_score) as avg_after_score from (
                          select bbs_etc1 as pid, avg(valuation_goods+valuation_goods_info+valuation_delivery+valuation_package) as avg_after_score from bbs_after a where regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY)
                          union all
                          select bbs_etc1 as pid , avg(valuation_goods+valuation_goods_info+valuation_delivery+valuation_package) as avg_after_score from bbs_premium_after a where regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY)
                          ) od
                          group by pid
                          ) od2 on od2.pid=p.id ";
                         */
                        //$orderby_str = "avg_after_score desc";
                        $orderby_str = "pa.after_score_".$displayGoods[$i]['display_auto_priod']." desc";
                    }
                } else {
                    if ($displayGoods[$i]['display_auto_type'] == "regdate_asc") {
                        $orderby_str = " p.id ASC";
                    } else {
                        $orderby_str = "  p.".$displayGoods[$i]['display_auto_type']." ";
                        if ($displayGoods[$i]['display_auto_type'] == "sellprice") {
                            $orderby_str .= "ASC";
                        } else {
                            $orderby_str .= "DESC";
                        }
                    }
                }

                if ($displayGoods[$i]['goods_display_sub_type'] == "C") {//$goods_display_sub_type
                    $sql                                                                           = "SELECT ci.cid, ci.depth
								FROM shop_main_category_relation mcr , shop_category_info ci
								where mcr.cid = ci.cid and mcr.mg_ix='".$displayGoods[$i]['mg_ix']."' and mcr.group_code='".$displayGoods[$i]['group_code']."'  and  mcr.insert_yn ='Y'
								ORDER BY vieworder ASC"; //div_code = '".$div_code."' and
                    $script_times["get_display_".$div_code."_".$group_codes."_query1_end_".rand()] = time();
                    $slave_mdb->query($sql);
                    $cateRelation                                                                  = $slave_mdb->fetchall();
                    $script_times["get_display_".$div_code."_".$group_codes."_query2_end_".rand()] = time();

                    if (is_array($cateRelation)) {
                        $cidNo   = 0;
                        $cid_str = "";
                        foreach ($cateRelation as $_keys => $_values) {
                            if ($cidNo > 0) $cid_str .= " OR ";
                            $cid_str .= " r.cid LIKE '".substr($_values['cid'], 0, ($_values['depth'] + 1) * 3)."%' ";
                            $cidNo++;
                        }
                        if ($cid_str != "") $goods_display_sub_type_where = " and (".$cid_str.") ";
                    }

                    $sql = "select
									p.id,p.pname,p.product_color_chip,p.order_cnt,p.stock,p.stock_use_yn,p.brand,p.brand_name, r.cid,
									$select_price, p.shotinfo, p.is_sell_date, p.sell_priod_sdate,
									p.sell_priod_edate, icons,
									case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
									'".$displayGoods[$i]['mg_ix']."' as mg_ix ".$reserve_sql."  ".$select_str."
								from
									".TBL_SHOP_PRODUCT." p
									inner join shop_product_addinfo pa on p.id=pa.pid
									inner join shop_product_relation r on r.pid = p.id
									".$select_leftjoin_str."
								where
									p.state =1
									and p.disp = 1
									and r.basic = 1
									".$goods_display_sub_type_where."
									".$priod_where."
									".$is_mobile_use_where."
								order by ".$orderby_str."
								limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)."";
                }else if ($displayGoods[$i]['goods_display_sub_type'] == "B") {
                    $sql = "SELECT b_ix
								FROM shop_main_brand_relation mbr
								where mbr.group_code='".$displayGoods[$i]['group_code']."' and mbr.mg_ix='".$displayGoods[$i]['mg_ix']."' and  mbr.insert_yn ='Y'
								 "; //div_code = '".$div_code."' and

                    if ($sql != "") $goods_display_sub_type_where = " and p.brand in (".$sql.") ";
                    $sql                          = "select
										p.id,p.pname,p.product_color_chip,p.order_cnt,p.stock,p.stock_use_yn,p.brand,p.brand_name, r.cid,
										$select_price, p.shotinfo, p.is_sell_date, p.sell_priod_sdate,
										p.sell_priod_edate, icons ,
										case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
										'".$displayGoods[$i]['mg_ix']."' as mg_ix ".$reserve_sql."  ".$select_str."
									from
										".TBL_SHOP_PRODUCT." p
										inner join shop_product_addinfo pa on p.id=pa.pid
										inner join shop_product_relation r on r.pid = p.id
										".$select_leftjoin_str."
									where
										p.state =1
										and p.disp = 1
										and r.basic = 1
										".$goods_display_sub_type_where."
										".$priod_where."
										".$is_mobile_use_where."
									order by ".$orderby_str."
									limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)."";
                }else if ($displayGoods[$i]['goods_display_sub_type'] == "S") {
                    $sql = "SELECT company_id
								FROM shop_main_seller_relation msr
								where msr.group_code='".$displayGoods[$i]['group_code']."' and msr.mg_ix='".$displayGoods[$i]['mg_ix']."'  and  msr.insert_yn ='Y'
								 "; //div_code = '".$div_code."' and

                    if ($sql != "") $goods_display_sub_type_where = " and p.admin in (".$sql.") ";
                    $sql                          = "select
										p.id,p.pname,p.product_color_chip,p.order_cnt,p.stock,p.stock_use_yn,p.brand,p.brand_name, r.cid,
										$select_price, p.shotinfo, p.is_sell_date, p.sell_priod_sdate, p.sell_priod_edate, icons,
										case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
										'".$displayGoods[$i]['mg_ix']."' as mg_ix ".$reserve_sql."  ".$select_str."
									from
										".TBL_SHOP_PRODUCT." p
										inner join shop_product_addinfo pa on p.id=pa.pid
										inner join shop_product_relation r on r.pid = p.id
										".$select_leftjoin_str."
									where
										p.state =1
										and p.disp = 1
										and r.basic = 1
										".$goods_display_sub_type_where."
										".$priod_where."
										".$is_mobile_use_where."
									order by ".$orderby_str."
									limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)."";
                }
            } else {// 메뉴얼일때
                // 메인페이지 분석 모드일때 각 상품에 조회수를 이미지 위에 노출하기위해서 통계데이타와 연동
                if ($_GET["viewtype"] == "analysis" || $_SESSION["viewtype"] == "analysis") {
                    if (!$vdate) {
                        $vdate = date("Ymd");
                    }
                    //판매기간 설정 조건 추가 2014-02-04 이학봉(조건추가하면서 쿼리 라인 정리 도저히 알아보기 힘듭니다.)
                    $sql = "SELECT
								".$goods_list_cnt." AS goods_list_cnt,
								p.id,p.pname,p.product_color_chip,
								$select_price,
								p.stock, p.stock_use_yn, p.brand, p.brand_name, p.shotinfo,p.admin,
								erp.mpr_ix, erp.mg_ix, p.order_cnt,
								IFNULL(mc.ncnt,0) as ncnt,
								p.is_sell_date,
								p.sell_priod_sdate,p.product_point,
								p.sell_priod_edate, r.cid, erp.div_code,
								case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
								icons $reserve_sql
							FROM
								".TBL_SHOP_PRODUCT." p
								right join shop_product_addinfo pa on p.id=pa.pid
								left join shop_product_relation r on p.id = r.pid and r.basic = 1
								right join ".TBL_SHOP_MAIN_PRODUCT_RELATION." erp on p.id = erp.pid
								left join logstory_maingoods_click mc on erp.mpr_ix = mc.mpr_ix and mc.vdate = '".$vdate."'
							where
								1
								and if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')
								and erp.group_code = '".$displayGoods[$i]['group_code']."'
								and erp.div_code = '".$div_code."'
								".$mg_ix_str."
								and p.disp = 1 and p.state = 1 and p.product_type != 2 ".$is_mobile_use_where."
								order by ".(is_mobile() ? "erp.vieworder asc" : "p.product_point desc")."   limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)." ";

                    //ci.depth,
                    //left join shop_category_info ci on r.cid = ci.cid
                } else {
                    $offsetLimit = $display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query;
                    if ($limitEnd != '') {
                        $offsetLimit = $limitEnd;
                    }
                    $sql = "SELECT
									".$goods_list_cnt." AS goods_list_cnt,
									p.id,p.pname,p.product_color_chip,
									$select_price,
									p.stock, p.stock_use_yn, p.brand, p.brand_name,p.admin,
									p.shotinfo, erp.mpr_ix, erp.mg_ix, p.order_cnt,
									p.is_sell_date,
									p.sell_priod_sdate, p.product_point,
									p.sell_priod_edate, r.cid, ci.depth, erp.div_code, csd.shop_name,
									case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
									icons $reserve_sql
								FROM
									".TBL_SHOP_PRODUCT." p
									right join shop_product_addinfo pa on p.id=pa.pid
									left join shop_product_relation r on p.id = r.pid and r.basic = 1
									left join shop_category_info ci on r.cid = ci.cid
									left join common_seller_detail csd on p.admin = csd.company_id
									right join ".TBL_SHOP_MAIN_PRODUCT_RELATION." erp on p.id = erp.pid
								where if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')
									and erp.group_code = '".$displayGoods[$i]['group_code']."'
									and erp.div_code = '".$div_code."'
									".$mg_ix_str."
									and p.disp = 1 and p.state = 1 and p.product_type != 2 ".$is_mobile_use_where."
									order by ".(is_mobile() ? "erp.vieworder asc" : "erp.vieworder asc")."
									limit ".$limitStart.", ".$offsetLimit." ";
                    // p.product_point desc
                    //and p.brand = b.b_ix 삭제 ,,".TBL_SHOP_BRAND." b 삭제 , b.brand_name --> p.brand_name 변경
                }
            }
            //echo nl2br($sql);
            //$script_times["get_display_".$div_code."_".$group_codes."_query3_start_".rand()] = time();
            //echo nl2br($sql)."<br><br><br><br><br><br><br><br><br>";
            //$script_times["get_display_".$div_code."_".$group_codes."_query3_sql_".rand()] = $sql;
            $slave_mdb->query($sql);
            $displayGoods[$i]['goods'] = $slave_mdb->fetchall();
            //$script_times["get_display_".$div_code."_".$group_codes."_query3_end_".rand()] = time();

            $cssML   = 'ml'.$displayGoods[$i]['display_type'];
            $cssType = 'type'.$displayGoods[$i]['display_type'];
            $imgType = 'ms';
            $noImg   = 'noimg_'.$imgType.'.gif';

            if (is_array($displayGoods[$i]['goods'])) {
                if ($_SESSION["user"]["code"]) {
                    $slave_mdb->query("SELECT pid FROM shop_wishlist where mid = '".$_SESSION["user"]["code"]."' ");
                    $favorite_goods = $slave_mdb->getrows();
                    $favorite_goods = $favorite_goods[0];
                    //print_r($favorite_goods);
                }

                $products = $displayGoods[$i]['goods'];
                for ($j = 0; $j < count($products); $j++) {
                    $_array_pid[]                                                        = $products[$j]['id'];
                    $goods_infos[$products[$j]['id']]['pid']                             = $products[$j]['id'];
                    $goods_infos[$products[$j]['id']]
                        ['amount'] = $products[$j]['pcount'];
                    $goods_infos[$products[$j]['id']]['cid']                             = $products[$j]['cid'];
                    $goods_infos[$products[$j]['id']]['depth']                           = $products[$j]['depth'];
                }
                //$script_times["get_display_".$div_code."_".$group_codes."_discountresult_start_".rand()] = time();
                $discount_info = DiscountRult($goods_infos, $cid, $depth);
                //$script_times["get_display_".$div_code."_".$group_codes."_discountresult_end_".rand()] = time();

                $cnt = 0;
                foreach ($displayGoods[$i]['goods'] as $key => $sub_array) {
                    //if($key %
                    $select_ = array("icons_list" => explode(";", $sub_array['icons']));
                    array_insert($sub_array, 14, $select_);

                    $pcolor_ = array("colorchip_list" => explode(",", str_replace(" ", "", $sub_array['product_color_chip'])));
                    array_insert($sub_array, 15, $pcolor_);

                    $sub_array['is_favorite'] = false;
                    if (is_array($favorite_goods)) {
                        if (in_array($sub_array['id'], $favorite_goods)) {
                            $sub_array['is_favorite'] = true;
                        }
                    }

                    $sub_array['sold_out'] = 'N';
                    if (($sub_array['stock_use_yn'] == 'Y' || $sub_array['stock_use_yn'] == 'Q') && ($sub_array['stock'] + $sub_array['available_stock']
                        <= 0)) {
                        $sub_array['sold_out'] = 'Y';
                    }

                    $discount_item = $discount_info[$sub_array['id']];
                    //print_r($discount_item);
                    $_dcprice      = $sub_array['sellprice'];
                    if (is_array($discount_item)) {
                        foreach ($discount_item as $_key => $_item) {
                            if ($_item['discount_value_type'] == "1") { // %
                                //echo $_item[discount_value]."<br>";
                                $_dcprice = roundBetter($_dcprice * (100 - $_item['discount_value']) / 100, $_item['round_position'],
                                    $_item['round_type']); //$_dcprice*(100 - $_item[discount_value])/100;
                            } else if ($_item['discount_value_type'] == "2") {// 원
                                $_dcprice = $_dcprice - $_item['discount_value'];
                            }

                            //$discount_desc[] = $_item[discount_type]."-".$_item[discount_value]." ".($_item[discount_value_type] == "1" ? "%":"원")."-".$_dcprice."원";
                            $discount_desc[] = $_item; //array("discount_type"=>$_item[discount_type], "haddoffice_value"=>$_item[discount_value], "discount_value"=>$_item[discount_value], "discount_value"=>$_item[discount_value], "discount_value_type"=>$_item[discount_value_type], "_dcprice"=>$_dcprice);
                        }
                    }
                    $_dcprice              = array("dcprice" => $_dcprice);
                    array_insert($sub_array, 52, $_dcprice);
                    $discount_desc         = array("discount_desc" => $discount_desc);
                    array_insert($sub_array, 53, $discount_desc);
                    unset($discount_desc);
                    $sub_array['cssML']    = $cssML;
                    $sub_array['cssType']  = $cssType;
                    $sub_array['noImg']    = $noImg;
                    $sub_array['imgType']  = $imgType;
                    $sub_array['div_code'] = $div_code;
                    if ($displayGoods[$i]['display_type'] == 2) {
                        $sub_array['imgType'] = 'm';
                    } elseif ($displayGoods[$i]['display_type'] == 4) {
                        if ($cnt % 7 == 0) {
                            $sub_array['addHTML1'] = '<div style="clear:both;float:left;padding:0 0 0 0px;">';
                            $sub_array['addHTML2'] = '</div><div class="type4-2">';
                            $sub_array['imgType']  = 'b';
                            $sub_array['noImg']    = 'noimg_'.$sub_array['imgType'].'.gif';
                        } else {
                            $sub_array['cssType'] = 'type4-1';
                        }
                    } elseif ($displayGoods[$i]['display_type'] == 6) {
                        if ($cnt % 6 < 2) {
                            //$sub_array['addHTML1']	= '</div><div class="good_names" style="width:420px;padding:0 10px;">';
                            //$sub_array['addHTML2']	= '</div><div style="float:left;width:50%;">';
                            $sub_array['imgType'] = 'b';
                            $sub_array['noImg']   = 'noimg_'.$sub_array['imgType'].'.gif';
                        } else {
                            $sub_array['cssML']   = 'ml6-1';
                            $sub_array['cssType'] = 'type6-1';
                        }
                    }
                    $remain_days              = dateDiff(date('Y-m-d H:i:s'), $sub_array['sell_priod_edate'], 'day');
                    $sub_array['remain_days'] = ($remain_days > 0) ? $remain_days : 0;

                    $displayGoods[$i]['goods'][$key] = $sub_array;
                    $cnt++;
                }
            }
            unset($display_goods_cnt);
        }

        //$script_times["get_display_".$div_code."_".$group_codes."_end_".rand()] = time();
        //print_r($displayGoods)
        return $displayGoods;
    }
}

if (!function_exists('getTagsInfo')) {
    /*
      // ---------------------------------------------------------------------------------
      // Best, New, 무료배송, 쿠폰, 무이자 태그를 가져옴.
      // 쿠폰은 더 develop 시켜야함(유명호과장 확인후 적용필요->빠질수도 있음).
      // 쿠폰 : UsableCupon 함수 사용
      // 무료배송 : shop_product_addinfo.free_delivery_yn 디비기준 => shop_product_addinfo.free_delivery_yn값은 정상 변경됨(1: 무료배송)
      // BEST : 전일기준 판매된 상품(shop_product.recent_order_date 컬럼추가 고민필요)
      // New  : 일주일 이내에 등록된 상품(getProducts 함수 lib.function.php 8008 라인)
      // 무이자 : 현재 시점에 설정된 신용카드 프로모션 제한 가격이 상품가격을 넘을때
      //				=>쿼리에서 추출하는 정책 반영 --> 쿼리로 매번 호출하는건 아닌거 같음 --> 세션으로 생성 하던지? 방법 고민필요
      // SOLDOUT : 상품의 상태값이 0일경우 또는 stock_use_yn이 y거나 q이면서 재고가 0이하일때
      //
      //																						2016.11.29 김형수
      // ---------------------------------------------------------------------------------
     */

    function getTagsInfo($product_info)
    {
        $html = "";
        if (is_array($product_info)) {
            $db = gVal('db');

            $sql = sprintf("SELECT p.id
								 , IF(p.order_cnt > 0, 'Y', 'N') as BEST
								 , IF((SELECT condition_price
										 FROM shop_card_promotion cp
										WHERE date_type = 1
										  AND disp = 1
										  AND NOW() BETWEEN sdate and edate) <= p.sellprice, 'Y', 'N' ) as NOINT
							 FROM
								shop_product p
								left join shop_order_detail od on p.id = od.pid
							 WHERE
								p.id = %d
							 ORDER BY od_ix DESC
							 LIMIT 1
	 					   ", $product_info['id']);

            $db->query($sql);
            $result = $db->fetch();

            $dispAttrib = "style='display:none;'";

            $usable_coupons = UsableCupon($product_info['id'], $product_info['dcprice'], 1, 1, "array");
            $html           .= sprintf("<em class='is_sale' %s>SALE</em>", $product_info['listprice'] > $product_info['dcprice'] ? '' : $dispAttrib);
            $html           .= sprintf("<em class='is_best' %s>BEST</em>", $result['BEST'] == 'N' ? $dispAttrib : '');
            $html           .= sprintf("<em class='is_new' %s>NEW</em>", $product_info['is_new'] == '0' ? $dispAttrib : '');
            $html           .= sprintf("<em class='noninterest' %s>무이자</em>", $result['NOINT'] == 'N' ? $dispAttrib : '');
            $html           .= sprintf("<em class='soldout' %s>SOLDOUT</em>",
                $product_info['sold_out'] == 'Y' || $product_info['state'] == '0' ? '' : $dispAttrib);
        }
        return $html;
    }
}

if (!function_exists('salerate_round')) {

    //셀러판매신용점수 관리 끝 2014-06-15 이학봉
    function salerate_round($number)
    {
        if ($number < 1) {
            $number = 1;
        }
        return round($number);
    }
}

if (!function_exists('getBannerInfo')) {

    // 배너 이미지 정보
    function getBannerInfo($banner_ix, $type = "image")
    {
        // 밑에 코드가
        // 사실상 banner_kind 를 받은데가 없고(항상 공백)
        // 어떤 값을 넘겨도 getDisplayBanner 함수에서
        // 디비에서 banner_kind 값을 가져와서 처리하기 때문에
        // 항상 해당 값은 의미가 없음.
        // 즉 인자가 의미가 없는것임.
        //                                 2016. 11. 1 이철성

        return getDisplayBanner($banner_kind, $banner_ix);
        exit;
        global $layout_config, $viewtype, $vdate, $SelectReport;
        if (!$_GET["viewtype"]) {
            $viewtype = $_GET["viewtype"];
        }
        //	echo "viewtype : ".$viewtype ;

        $slave_mdb = new Database;
        $slave_mdb->slave_db_setting();
        if ($viewtype == "analysis") {
            if ($vdate == "") {
                $vdate       = date("Ymd", time());
                $vyesterday  = date("Ymd", time() - 84600);
                $voneweekago = date("Ymd", time() - 84600 * 7);
            } else {
                if ($SelectReport == 3) {
                    $vdate = $vdate."01";
                }
                $vweekenddate = date("Ymd", mktime(0, 0, 0, substr($vdate, 4, 2), substr($vdate, 6, 2), substr($vdate, 0, 4)) + 60 * 60 * 24 * 6);
                $vyesterday   = date("Ymd", mktime(0, 0, 0, substr($vdate, 4, 2), substr($vdate, 6, 2), substr($vdate, 0, 4)) - 60 * 60 * 24);
                $voneweekago  = date("Ymd", mktime(0, 0, 0, substr($vdate, 4, 2), substr($vdate, 6, 2), substr($vdate, 0, 4)) - 60 * 60 * 24 * 7);
            }

            if ($SelectReport == 1) {
                $vdate_str = " and bc.vdate = '$vdate'";
            } else if ($SelectReport == 2) {
                $vdate_str = " and bc.vdate between '$vdate' and '$vweekenddate'";
            } else if ($SelectReport == 3) {
                $vdate_str = " and bc.vdate LIKE '".substr($vdate, 0, 6)."%'  ";
            }

            //$sql = 	"SELECT banner_img,banner_ix,banner_link,banner_target,banner_width,banner_height FROM shop_bannerinfo where banner_ix = '".$banner_ix."' ";
            $sql = "select b.banner_ix, b.banner_kind, banner_img,banner_link,banner_target,banner_width,banner_height,disp,banner_name,
				IFNULL(sum(bc.ncnt),0) as ncnt
				from shop_bannerinfo b left join logstory_banner_click bc
				on b.banner_ix = bc.banner_ix and b.banner_ix = '".$banner_ix."' ".$vdate_str."
				where b.banner_ix = '".$banner_ix."' and disp = '1'
				group by b.banner_ix, banner_img,banner_link,banner_target,banner_width,banner_height  ";
            //echo $sql;
        } else {
            $sql = "SELECT banner_img,banner_ix,banner_link,banner_target,banner_width,banner_height,disp,banner_name FROM shop_bannerinfo where banner_ix = '".$banner_ix."' and disp = '1' ";
        }
        //echo $sql;
        $slave_mdb->query($sql);
        $slave_mdb->fetch();
        if ($slave_mdb->dt["disp"] == "1") {
            if ($slave_mdb->dt['banner_target'] == "_SELF") {
                $target = "";
            } else {
                $target = $slave_mdb->dt['banner_target'];
            }

            if ($viewtype == "analysis") {

                //print_r($slave_mdb->dt);
                if ($type == "image") {

                    if ($slave_mdb->dt['banner_link'] != "" && $slave_mdb->dt['banner_link'] != "#") {

                        if (substr_count($slave_mdb->dt['banner_img'], '.swf') > 0) {
                            return "<script language='javascript'>generate_flash('".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."', '".$slave_mdb->dt['banner_width']."', '".$slave_mdb->dt['banner_height']."');</script>";
                        } else {
                            exit;
                            //return "<a href='".$slave_mdb->dt[banner_link]."' target='".$target."'><img src='".$_SESSION["layout_config"][mall_data_root]."/images/banner/".$slave_mdb->dt[banner_ix]."/".$slave_mdb->dt[banner_img]."'></a>";
                            return "<div class='stats_index'><div><span>".$slave_mdb->dt['ncnt']."</span></div>
							<a href='/banner.link.php?banner_ix=".$slave_mdb->dt['banner_ix']."' target='".$target."'><img src='".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."'></a>
							</div>";
                        }
                    } else {

                        if (substr_count($slave_mdb->dt['banner_img'], '.swf') > 0) {
                            return "<script language='javascript'>generate_flash('".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."', '".$slave_mdb->dt['banner_width']."', '".$slave_mdb->dt['banner_height']."');</script>";
                        } else {
                            return "<div class='stats_index'><div><span>".$slave_mdb->dt['ncnt']."</span></div><img src='".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."' style='vertical-align:middle'></div>";
                        }
                    }
                } else {
                    return $_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img'];
                }
            } else {
                exit;
                if ($type == "image") {
                    if ($slave_mdb->dt['banner_link'] != "" && $slave_mdb->dt['banner_link'] != "#") {

                        if (substr_count($slave_mdb->dt['banner_img'], '.swf') > 0) {
                            return "<script language='javascript'>generate_flash('".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."', '".$slave_mdb->dt['banner_width']."', '".$slave_mdb->dt['banner_height']."');</script>";
                        } else {
                            return "<!--a href='".$slave_mdb->dt['banner_link']."' target='".$target."'--><a href='/banner.link.php?banner_ix=".$slave_mdb->dt['banner_ix']."' target='".$target."'><img src='".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."'></a>";
                            //return "<a href='/banner.link.php?banner_ix=".$slave_mdb->dt[banner_ix]."' target='".$target."'><img src='".$_SESSION["layout_config"][mall_data_root]."/images/banner/".$slave_mdb->dt[banner_ix]."/".$slave_mdb->dt[banner_img]."'></a>";
                        }
                    } else {
                        if (substr_count($slave_mdb->dt['banner_img'], '.swf') > 0) {
                            return "<script language='javascript'>generate_flash('".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."', '".$slave_mdb->dt['banner_width']."', '".$slave_mdb->dt['banner_height']."');</script>";
                        } else {
                            return "<img src='".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."' style='vertical-align:middle'>";
                        }
                    }
                } else {
                    return $_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img'];
                }
            }
        } else {
            return "<div style='width:".$slave_mdb->dt['banner_width']."px;height:".$slave_mdb->dt['banner_height']."px;'></div>";
        }
    }
}

if (!function_exists('fetch_banner')) {

    function fetch_banner($page, $limit, $start = 0)
    {
        global $viewtype, $vdate, $SelectReport;
        global $slave_mdb;
        //$slave_mdb = new MySQl;
        if ($viewtype == "analysis") {
            if ($vdate == "") {
                $vdate       = date("Ymd", time());
                $vyesterday  = date("Ymd", time() - 84600);
                $voneweekago = date("Ymd", time() - 84600 * 7);
            } else {
                if ($SelectReport == 3) {
                    $vdate = $vdate."01";
                }
                $vweekenddate = date("Ymd", mktime(0, 0, 0, substr($vdate, 4, 2), substr($vdate, 6, 2), substr($vdate, 0, 4)) + 60 * 60 * 24 * 6);
                $vyesterday   = date("Ymd", mktime(0, 0, 0, substr($vdate, 4, 2), substr($vdate, 6, 2), substr($vdate, 0, 4)) - 60 * 60 * 24);
                $voneweekago  = date("Ymd", mktime(0, 0, 0, substr($vdate, 4, 2), substr($vdate, 6, 2), substr($vdate, 0, 4)) - 60 * 60 * 24 * 7);
            }

            if ($SelectReport == 1) {
                $vdate_str = " and vdate = '$vdate'";
            } else if ($SelectReport == 2) {
                $vdate_str = " and vdate between '$vdate' and '$vweekenddate'";
            } else if ($SelectReport == 3) {
                $vdate_str = " and vdate LIKE '".substr($vdate, 0, 6)."%'  ";
            }
            //$sql = 	"SELECT banner_img,banner_ix,banner_link,banner_target,banner_width,banner_height FROM shop_bannerinfo where banner_ix = '".$banner_ix."' ";
            $sql = "select b.banner_ix, banner_img,banner_link,banner_target,banner_width,banner_height,
			IFNULL(sum(bc.ncnt),0) as ncnt
			from shop_bannerinfo b left join logstory_banner_click bc
			on b.banner_ix = bc.banner_ix $vdate_st
			where b.banner_page = '$page'
			group by b.banner_ix, banner_img,banner_link,banner_target,banner_width,banner_height
			limit $start, $limit  ";
            //echo $sql;
        } else {
            $sql = "select * from shop_bannerinfo where banner_page = $page limit $start, $limit";
        }
        $slave_mdb->query($sql);
        return $slave_mdb->fetchall();
    }
}

if (!function_exists("getDisplayBanner")) {

    function getDisplayBanner($banner_kind, $banner_ix = false, $banner_width = false, $banner_height = false, $div_ix = false, $cid = false,
                              $class = false)
    {
        global $layout_config;
        global $slave_mdb;
        //$slave_mdb = new Database;

        $mall_data_root = IMAGE_SERVER_DOMAIN.$_SESSION["layout_config"]['mall_data_root'];

        $sql         = "select
						b.banner_page
					from
						shop_bannerinfo b
					where
						banner_ix = '$banner_ix'
						and disp ='1'
					limit 1";
        $slave_mdb->query($sql);
        $slave_mdb->fetch();
        $banner_page = $slave_mdb->dt['banner_page'] ?? '';

        if ($banner_page == '66') {
            $sql = "select
							b.banner_ix , b.banner_kind , b.banner_name
						from
							shop_bannerinfo b
						where
							banner_ix = '$banner_ix'
							and disp ='1'
						order by use_sdate asc , use_edate asc
						limit 1 ";

            $slave_mdb->query($sql);
            $slave_mdb->fetch();
        } else {
            $sql = "select
							b.banner_ix , b.banner_kind , b.banner_name
						from
							shop_bannerinfo b
						where
							banner_ix = '$banner_ix'
							and disp ='1'
							and NOW() between use_sdate and use_edate
						order by use_sdate asc , use_edate asc
						limit 1 ";

            $slave_mdb->query($sql);
            $slave_mdb->fetch();
        }

        $banner_kind = $slave_mdb->dt['banner_kind'] ?? '';

        $today_srch = date("YmdHi");

        $where = "WHERE bi.disp='1' AND b.sdate <= '".$today_srch."' AND b.edate >= '".$today_srch."' ";

        if ($banner_kind == 1) { // 일반배너
            if ($banner_ix) $where .= " AND bi.banner_ix = ".$banner_ix;
            if ($div_ix) $where .= " AND bd.div_ix = ".$div_ix;
            if ($cid) $where .= " AND b.cid = '".$cid."'";
            /*
              $sql = "SELECT * FROM shop_bannerinfo bi
              INNER JOIN shop_display_banner b ON bi.banner_ix = b.banner_ix AND b.banner_div = '$banner_kind'
              LEFT OUTER JOIN shop_banner_div bd ON b.div_ix=bd.div_ix
              ".$where;
             */
            $sql   = "select b.banner_ix, b.banner_kind, change_effect, banner_img,banner_img_on,banner_btn_position, banner_link,banner_target,banner_width,banner_height,disp,banner_name,
				IFNULL(sum(bc.ncnt),0) as ncnt
				from shop_bannerinfo b left join logstory_banner_click bc
				on b.banner_ix = bc.banner_ix and b.banner_ix = '".$banner_ix."' ".$vdate_str."
				where b.banner_ix = '".$banner_ix."' and disp ='1'
				group by b.banner_ix, banner_img,banner_link,banner_target,banner_width,banner_height  ";

            //echo nl2br($sql);
            //exit;
            $slave_mdb->query($sql);
            if ($slave_mdb->total) {
                for ($i = 0; $i < $slave_mdb->total; $i++) {
                    $slave_mdb->fetch($i);
                    $banner_ix     = $slave_mdb->dt['banner_ix'];
                    $banner_img    = $slave_mdb->dt['banner_img'];
                    $banner_width  = $slave_mdb->dt['banner_width'];
                    $banner_height = $slave_mdb->dt['banner_height'];
                    $banner_img_on = $slave_mdb->dt['banner_img_on'];
                    $banner_on_use = $slave_mdb->dt['banner_on_use'];
                    $banner_target = strtolower($slave_mdb->dt['banner_target']); //150907 strtolower 추가 [_SELF 대문자 일떄 인식을 못해서] by pyw
                    //150907 추가 모바일 iframe으로 수정되어서 _self가 아닌 _parent by pyw
                    if (is_mobile()) $banner_target = "_parent";

                    $imgPath = $mall_data_root."/images/banner/".$banner_ix."/";
                    if ($i > 0) $mString."<BR>";

                    if (substr_count($banner_img, '.swf') > 0) {
                        $mString .= "<script language='javascript'>generate_flash('".$layout_config['mall_data_root']."/images/banner/".$banner_ix."/".$banner_img."', '".$banner_width."', '".$banner_height."');</script>";
                    } else if ($banner_on_use == "Y" || $banner_img_on) { // 마우스오버시 바로 이미지가 바뀌는 오버기능 사용시
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "<div class='stats_index'><div><span>".$slave_mdb->dt['ncnt']."</span></div>";
                        }
                        if ($slave_mdb->dt['banner_link'] != "" && $slave_mdb->dt['banner_link'] != "#") {

                            $mString .= "<a href='/banner.link.php?banner_ix=".$banner_ix."' target='".$banner_target."'><img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."' width='".$banner_width."' height='".$banner_height."' onmouseover='this.src=\"".$imgPath.$banner_img_on."\"' onmouseout='this.src=\"".$imgPath.$banner_img."\"'></a>"; //<li ".$class."></li>
                        } else {
                            $mString .= "<img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."' width='".$banner_width."' height='".$banner_height."' onmouseover='this.src=\"".$imgPath.$banner_img_on."\"' onmouseout='this.src=\"".$imgPath.$banner_img."\"'>"; //<li ".$class."></li>
                        }
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "</div>";
                        }
                    } else if ($banner_img_on) { // 롤오버 이미지가 있으면
                        //$mString .= "<li>";
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "<div><span>".$slave_mdb->dt['ncnt']."</span></div>";
                        }
                        if ($slave_mdb->dt['banner_link'] != "" && $slave_mdb->dt['banner_link'] != "#") {
                            $mString .= "<a href='/banner.link.php?banner_ix=".$banner_ix."' target='".$banner_target."'><img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."' width='".$banner_width."' height='".$banner_height."'></a>";
                            $mString .= "<a href='/banner.link.php?banner_ix=".$banner_ix."' target='".$banner_target."'><img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img_on."'  width='".$banner_width."' height='".$banner_height."'></a>";
                        } else {
                            $mString .= "<img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."' width='".$banner_width."' height='".$banner_height."'>
								<img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img_on."'  width='".$banner_width."' height='".$banner_height."'>";
                        }
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "</div>";
                        }
                    } else {
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "<div class='stats_index'><div><span>".$slave_mdb->dt['ncnt']."</span></div>";
                        }
                        if ($slave_mdb->dt['banner_link'] != "" && $slave_mdb->dt['banner_link'] != "#") {

                            $mString .= "<a href='".$slave_mdb->dt['banner_link']."' target='".$banner_target."'><img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."'  width='".$banner_width."' height='".$banner_height."'></a>";
                        } else {
                            $mString .= "<img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."'  width='".$banner_width."' height='".$banner_height."'>"; //<li ".$class."></li>
                        }
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "</div>";
                        }
                    }
                }
            }
        } else if ($banner_kind == 2 || $banner_kind == 3) { // 플래시,슬라이드배너
            if ($banner_ix) $where .= " AND bi.bd_ix = ".$banner_ix;
            if ($div_ix) $where .= " AND bd.div_ix = ".$div_ix;
            /*
              $sql = "SELECT * FROM ".TBL_SHOP_MANAGE_FLASH." bi
              INNER JOIN shop_display_banner b ON bi.bd_ix = b.banner_ix AND b.banner_div = '$banner_kind'
              LEFT OUTER JOIN shop_banner_div bd ON b.div_ix=bd.div_ix
              LEFT OUTER JOIN shop_manage_flash_detail mfd on bi.bd_ix = mfd.bd_ix
              ".$where;
             */
            $sql   = "select b.banner_ix, b.banner_kind, change_effect, banner_img,banner_link,banner_target,banner_btn_position, banner_width,banner_height,disp,banner_name, bd.*,
				IFNULL(sum(bc.ncnt),0) as ncnt
				from shop_bannerinfo b left join shop_bannerinfo_detail bd on b.banner_ix = bd.banner_ix
				left join logstory_banner_click bc
				on b.banner_ix = bc.banner_ix and b.banner_ix = '".$banner_ix."' ".$vdate_str."
				where b.banner_ix = '".$banner_ix."' and disp ='1'
				group by b.banner_ix, bd.bd_ix, banner_img,banner_link,banner_target,banner_width,banner_height
				order by bd.vieworder";

            //echo nl2br($sql);
            //exit;
            $slave_mdb->query($sql);
            if ($banner_kind == 2) { // 플래시배너
                $i_no       = 0;
                $btn_no     = "";
                $printflash = $slave_mdb->fetchall();
                $banner_ix  = $printflash[0]['banner_ix'];

                $banner_btn_position = $printflash[0]['banner_btn_position'];
                $banner_width        = $printflash[0]['banner_width'];
                $banner_height       = $printflash[0]['banner_height'];
                $change_effect       = $printflash[0]['change_effect'];
                //echo "change_effect:".$change_effect;
                $banner_btn_left     = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_left.png";
                $banner_btn_left_on  = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_left_on.png";
                $banner_btn_right    = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_right.png";
                $banner_btn_right_on = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_right_on.png";

                if (is_array($printflash)) {
                    foreach ($printflash as $_key => $_val) {
                        if ($printflash[$_key]['bd_file'] != "") { //이미지값과 네비게이션 숫자 데이터를 담아둔다
                            $i_no++;
                            $imgPath = $mall_data_root."/images/banner/".$banner_ix."/"; //$printflash[$_key][bd_ix]

                            if ($printflash[$_key]['bd_link'] != "" && $printflash[$_key]['bd_link'] != "#") {
                                $imgString .= "<a class='slide' href='/banner.link.php?banner_ix=".$banner_ix."&bd_ix=".$printflash[$_key]['bd_ix']."' target='".$target."'><!--a href='".$printflash[$_key]['bd_link']."'--><img src='".$imgPath.$printflash[$_key]['bd_file']."' title='".$printflash[$_key]['bd_title']."' width='".$banner_width."' height='".$banner_height."'></a>";
                            } else {
                                $imgString .= "<img class='slide' src='".$imgPath.$printflash[$_key]['bd_file']."' title='".$printflash[$_key]['bd_title']."' width='".$banner_width."' height='".$banner_height."' style='z-index:-1000;'>";
                            }
                        }
                    }
                }
                //echo $imgString;
                //exit;
                $bd_ix = $printflash[0]['bd_ix'];


                $time_sec = $printflash[0]['time_sec'] * 1000;
                if (!$time_sec) $time_sec = 4000;


                $mString .= "

				<STYLE>
				#slider-wrapper {
					background:url(/images/slider.png) no-repeat;
					width:".$banner_width."px;
					height:".$banner_height."px;
					margin:0 auto;
					padding-top:74px;
					margin-top:50px;
				}
				.forbizSlider {
					position:relative;
					overflow:hidden;
				}
				.fzSliderWrapper {
					display:block;
					position:absolute;
					z-index:5;
					top:0;
					left:0;
				}
				.fzSliderWrapper .fzSlide {
					display:block;
					float:left;
				}
				.forbizSlider .fzSliderPrev {
					display:block;
					position:absolute;
					top:50%;
					left:0;
					z-index:10;
				}
				.forbizSlider .fzSliderNext {
					display:block;
					position:absolute;
					top:50%;
					right:0;
					z-index:10;
				}
				.forbizSlider .fzSliderPrev.disabled ,
				.forbizSlider .fzSliderNext.disabled {
					  cursor:default;
					  -ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=10)';
					  filter: alpha(opacity=10);
					  -moz-opacity: 0.1;
					  -khtml-opacity: 0.1;
					  opacity: 0.1;
				}
				.forbizSlider .fzSliderPager {
					position:absolute;
					top:10px;
					right:10px;
					z-index:99;
					display:none;
				}
				.forbizSlider .fzPagerLink {
					display:block;
					float:left;
					width:10px;
					height:10px;
					margin-left:5px;
					background-color:#a7a7a7;
				}
				.forbizSlider .fzPagerLink.active { background-color:#000000; }
				#slider {
					position:relative;
					width:".$banner_width."px;
					height:".$banner_height."px;
					margin-left:0px;
					margin-bottom:10px;
					background:url(/images/loading.gif) no-repeat 50% 50%;
				}

				</STYLE>
					";

                $mString .= "<div id='slider_".$banner_ix."' class='forbizSlider nivoSlider' style='width:".$banner_width."px;height:".$banner_height."px; display: none;'>";
                $mString .= "{$imgString}";
                $mString .= "</div>";
                if ($i_no > 1) {

                    $mString .= "
							<script>
							$(function() { $('.nivoSlider').css('display', '');";
                    if ($change_effect == "S") {

                        /** 	$mString .= "
                          $('#slider_".$banner_ix."').nivoSlider({
                          effect:'slideInLeft',
                          pauseTime:".$time_sec.",
                          pauseOnHover:true,";

                          if(file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_left) && file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_right)){
                          $mString .= "
                          prevText: '<img src=\'".$banner_btn_left."\' off_src=\'".$banner_btn_left."\' on_src=\'".$banner_btn_left_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />',
                          nextText: '<img src=\'".$banner_btn_right."\' off_src=\'".$banner_btn_right."\' on_src=\'".$banner_btn_right_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />'";
                          }else{
                          $mString .= "
                          prevText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveL.png' />\",
                          nextText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveR.png' />\"";

                          }
                          $mString .= "
                          });
                          "; */
                        $mString .= "
								$('#slider_".$banner_ix."').forbizSlider({
									pauseTime:".$time_sec.",
									pauseOnHover:true,";
                        if (file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_left) && file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_right)) {
                            $mString .= "
									prevText: '<img src=\'".$banner_btn_left."\' off_src=\'".$banner_btn_left."\' on_src=\'".$banner_btn_left_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />',
									nextText: '<img src=\'".$banner_btn_right."\' off_src=\'".$banner_btn_right."\' on_src=\'".$banner_btn_right_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />'";
                        } else {
                            $mString .= "
									prevText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveL.png' />\",
									nextText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveR.png' />\"";
                        }
                        $mString .= "
								});
							";
                    } else if ($change_effect == "F") {
                        $mString .= "
								$('#slider_".$banner_ix."').nivoSlider({
									effect:'fade',
									pauseTime:".$time_sec.",
									pauseOnHover:true,";

                        if (file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_left) && file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_right)) {
                            $mString .= "
									prevText: '<img src=\'".$banner_btn_left."\' off_src=\'".$banner_btn_left."\' on_src=\'".$banner_btn_left_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />',
									nextText: '<img src=\'".$banner_btn_right."\' off_src=\'".$banner_btn_right."\' on_src=\'".$banner_btn_right_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />'";
                        } else {
                            $mString .= "
									prevText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveL.png' />\",
									nextText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveR.png' />\"";
                        }
                        $mString .= "
								});";
                    } else if ($change_effect == "T") {
                        $mString .= "
								$('#slider_".$banner_ix."').nivoSlider({
									effect:'fold',
									pauseTime:".$time_sec.",
									pauseOnHover:true,";

                        if (file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_left) && file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_right)) {
                            $mString .= "
									prevText: '<img src=\'".$banner_btn_left."\' off_src=\'".$banner_btn_left."\' on_src=\'".$banner_btn_left_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />',
									nextText: '<img src=\'".$banner_btn_right."\' off_src=\'".$banner_btn_right."\' on_src=\'".$banner_btn_right_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />'";
                        } else {
                            $mString .= "
									prevText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveL.png' />\",
									nextText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveR.png' />\"";
                        }
                        $mString .= "
								});";
                    } else if ($change_effect == "R") {
                        $mString .= "
								$('#slider_".$banner_ix."').nivoSlider({
									effect:'random',
									animSpeed:1500,
									pauseTime:".$time_sec.",
									startSlide:2,
									directionNav:true,
									controlNav:true,
									keyboardNav:false,
									pauseOnHover:false,";

                        if (file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_left) && file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_right)) {
                            $mString .= "
									prevText: '<img src=\'".$banner_btn_left."\' off_src=\'".$banner_btn_left."\' on_src=\'".$banner_btn_left_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />',
									nextText: '<img src=\'".$banner_btn_right."\' off_src=\'".$banner_btn_right."\' on_src=\'".$banner_btn_right_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />'";
                        } else {
                            $mString .= "
									prevText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveL.png' />\",
									nextText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveR.png' />\"";
                        }
                        $mString .= "
								});";
                    }
                    $mString .= "
						});
							</script>
							<script type='text/javascript' language=javascript src='".$_SESSION["layout_config"]["mall_data_root"]."/templet/".$_SESSION["layout_config"]["mall_use_templete"]."/js/jquery.nivo.slider.pack.js'></script>
							<script type='text/javascript' language=javascript src='".$_SESSION["layout_config"]["mall_data_root"]."/templet/".$_SESSION["layout_config"]["mall_use_templete"]."/js/jquery.forbiz.slider.js'></script>
							";
                }
            } else if ($banner_kind == 3) { // 슬라이드 배너
                $printflash          = $slave_mdb->fetchall();
                $banner_ix           = $printflash[0]['banner_ix'];
                $banner_btn_position = $printflash[0]['banner_btn_position'];
                $banner_width        = $printflash[0]['banner_width'];
                $banner_height       = $printflash[0]['banner_height'];
                $change_effect       = $printflash[0]['change_effect'];
                //echo "change_effect:".$change_effect;
                //print_r($printflash);
                if (is_array($printflash)) {
                    $html = '<div class="slide_banner_box" style="position:relative;float:left;width:'.$banner_width.'px;overflow:hidden;height:'.$banner_height.'px;z-index:9; " id="main_scroll_width1">
									<div id="slide_banner_'.$banner_ix.'" class="goods" style="float:left;width:'.$banner_width.';white-space:nowrap;margin:0; height:'.$banner_height.'px; overflow:hidden; z-index:-10;">';
                    foreach ($printflash as $_key => $_val) {
                        if ($printflash[$_key]['bd_file'] != "") { //이미지값과 네비게이션 숫자 데이터를 담아둔다
                            $i_no++;
                            $imgPath = $mall_data_root."/images/banner/".$banner_ix."/".$printflash[$_key]['bd_file']; //$printflash[$_key][bd_ix]

                            $_html .= "<ul class='banners' style='float:left;z-index:-5;'>";
                            if ($printflash[$_key]['bd_link'] != "" && $printflash[$_key]['bd_link'] != "#") {
                                $_html .= "	<li><a href='".$printflash[$_key]['bd_link']."'><img src='".$imgPath."' title='".$printflash[$_key]['bd_title']."' style='width:".$banner_width."' ></a></li>";
                            } else {
                                $_html .= "	<li><img src='".$imgPath."' title='".$printflash[$_key]['bd_title']."'  style='width:".$banner_width."'/></li>";
                            }
                            $_html .= "</ul>";
                        }
                    }
                    if (substr_count($imgPath, 'http') == 0) {
                        $imgPath = $_SERVER['DOCUMENT_ROOT'].$imgPath;
                    }
                    $img_size = getimagesize($imgPath);
                    $width    = $img_size[0];
                    $height   = $img_size[1];
                    //$_html .= $_html.$_html;
                    //	copy($banner_btn_left, $_SERVER["DOCUMENT_ROOT"]."".$mall_data_root."/images/banner/".$banner_ix."/banner_btn_left.jpg");
                    //echo $mall_data_root."/images/banner/".$banner_ix."/banner_btn_left.png";
                    //exit;

                    if (file_exists($_SERVER["DOCUMENT_ROOT"]."".$_SESSION["layout_config"]['mall_data_root']."/images/banner/$banner_ix/banner_btn_left.png")) {
                        $banner_btn_left = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_left.png";
                    } else {
                        $banner_btn_left = $_SESSION["layout_config"]['mall_templet_webpath']."/images/btns/moveL.png"; //"left.png";
                    }
                    if (file_exists($_SERVER["DOCUMENT_ROOT"]."".$_SESSION["layout_config"]['mall_data_root']."/images/banner/$banner_ix/banner_btn_left_on.png")) {
                        $banner_btn_left_on = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_left_on.png";
                    } else {
                        $banner_btn_left_on = $_SESSION["layout_config"]['mall_templet_webpath']."/images/btns/moveL_on.png"; //"left_on.png";
                    }

                    if (file_exists($_SERVER["DOCUMENT_ROOT"]."".$_SESSION["layout_config"]['mall_data_root']."/images/banner/$banner_ix/banner_btn_right.png")) {
                        $banner_btn_right = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_right.png";
                    } else {
                        $banner_btn_right = $_SESSION["layout_config"]['mall_templet_webpath']."/images/btns/moveR.png"; //"left.png";
                    }
                    if (file_exists($_SERVER["DOCUMENT_ROOT"]."".$_SESSION["layout_config"]['mall_data_root']."/images/banner/$banner_ix/banner_btn_right_on.png")) {
                        $banner_btn_right_on = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_right_on.png";
                    } else {
                        $banner_btn_right_on = $_SESSION["layout_config"]['mall_templet_webpath']."/images/btns/moveR_on.png"; //"left_on.png";
                    }

                    $html .= $_html."</div>";
                    if ($banner_btn_position == 1) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;top:0;left:0;'>
								<ul>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else if ($banner_btn_position == 2) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;top:0;left:50%;'>
								<ul style='margin-left:-50%;'>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else if ($banner_btn_position == 3) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;top:0;right:0;'>
								<ul>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else if ($banner_btn_position == 5) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;bottom:0;left:0;'>
								<ul>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else if ($banner_btn_position == 6) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;bottom:0;left:50%;'>
								<ul style='margin-left:-50%;'>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else if ($banner_btn_position == 7) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;bottom:0;right:0;'>
								<ul>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."'  nmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else {
                        $html .= $_html."
							<div class='s_l_b' style='position:absolute; z-index:9; top:41%;right:0px;'>
								<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
							</div>
							<div class='s_l_b' style='position:absolute; z-index:9; top:41%;left:0px;'>
								<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
							</div>";
                    }
                    $html .= $_html."</div>";
                }


                $html    .= "<script type='text/javascript' language=javascript src='".$_SESSION["layout_config"]["mall_data_root"]."/templet/".$_SESSION["layout_config"]["mall_use_templete"]."/js/jquery.nivo.slider.pack.js'></script>";
                $html    .= "<script type='text/javascript' language=javascript src='".$_SESSION["layout_config"]["mall_data_root"]."/templet/".$_SESSION["layout_config"]["mall_use_templete"]."/js/jquery.forbiz.slider.js'></script>";
                $html    .= "<script language='javascript'>
								<!--
									var slideBanner_".$banner_ix." = setInterval(\"clickbannerScroll('slide_banner_".$banner_ix."',-".$width.")\", 3000);
									$('div#slide_banner_".$banner_ix.",div#slide_banner_btn_".$banner_ix.", .s_l_b').hover(function()	{
										clearInterval(slideBanner_".$banner_ix.");
									}, function()
									{
										slideBanner_".$banner_ix." = setInterval(\"clickbannerScroll('slide_banner_".$banner_ix."',-".$width.")\", 3000);
									});
								//-->
								if ($.fn.forbizSlider) {
									$.fn.forbizSlider.setupTouchSlide($('#slide_banner_".$banner_ix." .banners'), function(direction) {
										switch(direction) {
											case -1:
												clickbannerScroll('slide_banner_".$banner_ix."', -".$width.", 400);
												break;

											case 1:
												clickbannerScroll('slide_banner_".$banner_ix."', ".$width.", 400);
												break;

											default:
												break;
										}
									});
								}
								</script>";
                $mString = $html;
            }
        } else if ($banner_kind == 4) { // 동영상 배너
            $sql = "select b.banner_ix, b.banner_kind, change_effect, banner_html,banner_img_on, banner_link,banner_target,banner_width,banner_height,disp,
				IFNULL(sum(bc.ncnt),0) as ncnt
				from shop_bannerinfo b left join logstory_banner_click bc
				on b.banner_ix = bc.banner_ix and b.banner_ix = '".$banner_ix."' ".$vdate_str."
				where b.banner_ix = '".$banner_ix."' and disp ='1'
				group by b.banner_ix, banner_img,banner_link,banner_target,banner_width,banner_height  ";

            //echo nl2br($sql);
            $slave_mdb->query($sql);
            $slave_mdb->fetch();
            $mString = $slave_mdb->dt['banner_html'];
        } else if ($banner_kind == 5) { // 사용자지정 배너
            $sql = "select
							b.banner_ix, b.banner_kind, b.use_sdate, b.use_edate, change_effect, banner_img,banner_link,banner_target,
							banner_width,banner_height,disp,banner_name, bd.*, IFNULL(sum(bc.ncnt),0) as ncnt
						from
							shop_bannerinfo b
							left join shop_bannerinfo_detail bd on b.banner_ix = bd.banner_ix
							left join logstory_banner_click bc on b.banner_ix = bc.banner_ix and b.banner_ix = '".$banner_ix."' ".$vdate_str."
						where
							b.banner_ix = '".$banner_ix."'
							and disp ='1'
						group by b.banner_ix, bd.bd_ix, banner_img,banner_link,banner_target,banner_width,banner_height
						order by bd.vieworder ";

            //echo nl2br($sql);
            //exit;
            //echo nl2br($sql);
            $slave_mdb->query($sql);
            $banner_infos = $slave_mdb->fetchall();
            //print_r($banner_infos);
            //exit;
            return $banner_infos;
        }

        // 배너유입수 Log Insert
        return $mString;
    }
}

if (!function_exists("fetch_company_shopname")) {

    function fetch_company_shopname($company_id)
    {
        global $slave_mdb;
        //$slave_mdb = new Database;

        $slave_mdb->query("SELECT shop_name FROM ".TBL_COMMON_SELLER_DETAIL." where company_id='".$company_id."' ");
        $slave_mdb->fetch();
        return ($slave_mdb->dt['shop_name'] ?? '');
    }
}

if (!function_exists("fetch_seller_goods")) {

    function fetch_seller_goods($company_id)
    {
        global $slave_mdb;


        $sql         = sprintf("SELECT sd.company_id, sd.shop_name, p.id as pid, p.pname, p.sellprice
						  FROM common_seller_detail sd INNER JOIN shop_minishop_product_group pg on sd.company_id = pg.company_id
						   INNER JOIN shop_minishop_product_relation pr on sd.company_id = pr.company_id and pg.group_code = pr.group_code
						   INNER JOIN shop_product p on pr.pid = p.id
						 WHERE topseller_display = 1
						   AND pg.group_code = 4
						   AND sd.company_id = '%s'
					  ORDER BY p.vieworder LIMIT 2;
						", $company_id);
        $slave_mdb->query($sql);
        $goods_infos = $slave_mdb->fetchall();


        return $goods_infos;
    }
}

if (!function_exists("getCompanyId")) {

    function getCompanyId($pid)
    {
        $db  = new Database;
        $sql = sprintf("SELECT admin
						  FROM shop_product
						 WHERE id = %s", $pid);


        $db->query($sql);
        $results   = $db->fetchall();
        $result    = $results[0];
        $companyId = $result['admin'];

        return $companyId;
    }
}

if (!function_exists("getShopNameAndLogo")) {

    function getShopNameAndLogo($pid)
    {
        $P = new msLayOut("028001000000000");

        $db  = new Database;
        $sql = sprintf("SELECT sd.shop_name , sd.company_id
						  FROM shop_product p left join common_seller_detail sd on p.admin = sd.company_id
						 WHERE p.id = %s", $pid);


        $db->query($sql);
        $results    = $db->fetchall();
        $result     = $results[0];
        $company_id = $result['company_id'];

        $logoPhysicalPath = $_SERVER["DOCUMENT_ROOT"].$P->Config['mall_image_path']."/shopimg/shop_logo_".$company_id.".gif";

        if (file_exists($logoPhysicalPath)) {
            $logoPath = $P->Config['mall_image_path']."/shopimg/shop_logo_".$company_id.".gif";
        } else {
            $logoPath = "noimage";
        }
        return array(array('logoPath' => $logoPath, 'shopName' => $result['shop_name']));
    }
}
// 메인페이지 끝
// 모바일 메인 시작
if (!function_exists("categorys")) {

    function categorys()
    {
        global $slave_mdb; // = new Database;
        $sql       = "SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where category_use = 1 and depth = 0 order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5";
        //echo $sql;
        //exit;
        $slave_mdb->query($sql);
        $categorys = $slave_mdb->fetchall();

        return $categorys;
    }
}

if (!function_exists("subcategorys")) {

    function subcategorys($cid, $depth = "")
    {
        global $slave_mdb; // = new Database;
        if ($depth == "") {
            $depth = 0;
        }

        // && 조건에서 || 로 조건 변경 => /goods_list.php?cid=000000000000000&depth=0 에서 카테고리 보이도록 처리
        if ($depth == "") { //substr($cid,0,3) == '000' 161122 한대철
            $where = "  c.depth = 0 "; //1=1
        } else {
            $where = "c.depth in (".($depth + 1).") and c.cid LIKE '".substr($cid, 0, ($depth + 1) * 3)."%'";
        }
        /*
          $sql = "SELECT *  FROM ".TBL_SHOP_CATEGORY_INFO." c
          where
          $where
          and category_use = '1'
          order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5";// 조건절을 뺌 kbk 12/01/03 //,".($depth+1)." as r_depth 2012-10-29 신훈식 뺌
         */
        $sql = "SELECT c.cid, c.cname, c.depth, sum(IF(sub_c.cid is null,0,1))  as subcategory_cnt
					FROM ".TBL_SHOP_CATEGORY_INFO." c
					left join ".TBL_SHOP_CATEGORY_INFO." sub_c on left(c.cid,3) = left(sub_c.cid,3) and sub_c.depth = ".($depth + 2)."
					where
					".$where."
					and c.category_use = '1'
					group by c.cid
					order by c.vlevel1, c.vlevel2, c.vlevel3, c.vlevel4, c.vlevel5";
        if ($_SERVER["REMOTE_ADDR"] == "221.151.188.11") {
            //	echo nl2br($sql);
        }
        //		echo nl2br($sql);
        $slave_mdb->query($sql);
        $categorys = $slave_mdb->fetchall();

        if (is_array($categorys)) {
            foreach ($categorys as $key => $val) {
                $categorys[$key]["cname"] = getGlobalTargetName($val["cname"], $val["global_cinfo"], 'cname');
            }
        }

        //print_r($categorys);
        return $categorys; //$slave_mdb->fetchall();
    }
}
// 모바일 메인 끝
/**************************************
 *  레거시 호환용 함수 영역 끝
 **************************************/
