<?php
if (!function_exists('bootLangSet')) {

    // 언어 설정
    function bootLangSet()
    {
        $qb = getForbiz()->qb;

        // 언어설정
        if (sess_val("layout_config", "mall_domain") != $_SERVER['HTTP_HOST']) {
            $_SESSION["layout_config"]["front_language"] = "";
        }

        if (empty(sess_val("layout_config", "front_language"))) {
            $domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);

            if (substr($_SERVER['HTTP_HOST'], 0, 2) != 'm.') {
//                $sql = "select * from ".TBL_SHOP_SHOPINFO." where mall_domain = '{$domain}'";
                $qb->where('mall_domain', $domain);
            } else {
//                $sql = "select * from ".TBL_SHOP_SHOPINFO." where mall_mobile_domain = '{$domain}'";
                $qb->where('mall_mobile_domain', $domain);
            }

            $row = $qb
                ->from(TBL_SHOP_SHOPINFO)
                ->exec()
                ->getRowArray();

//            $db->query("SELECT config_value FROM `shop_mall_config` where mall_ix = '".$row['mall_ix']."' and config_name='nation_code' ");
//            $db->fetch();

            $row = $qb
                ->select('config_value')
                ->from('shop_mall_config')
                ->where('mall_ix', $row['mall_ix'])
                ->where('config_name', 'nation_code')
                ->exec()
                ->getRowArray();

            $sql = "SELECT gn.nation_name,gn.nation_code, gc.currency_name, gc.currency_code, gc.currency_unit_front, gc.currency_unit_back, gl.language_name, gl.language_code
			FROM global_nation gn
			left join global_currency gc on gn.currency_ix  = gc.currency_ix
			left join global_language gl on gn.language_ix  = gl.language_ix
		WHERE
			gn.nation_code='".$row['config_value']."' ";
            $row = $qb->exec($sql)->getResultArray();

            if (!empty($row)) {
                $front_language                       = $row['language_code'] ?? '';
                $layout_config["currency_unit_front"] = $row['currency_unit_front'] ?? '';
                $layout_config["currency_unit_back"]  = $row['currency_unit_back'] ?? '';
            } else {
                $front_language                       = "korean";
                $layout_config["currency_unit_front"] = "";
                $layout_config["currency_unit_back"]  = "원";
            }

            if ($front_language == 'korea') {
                $front_language = 'korean';
            }

            $_SESSION["layout_config"]["front_language"]      = $front_language;
            $_SESSION["layout_config"]["currency_unit_front"] = $layout_config["currency_unit_front"];
            $_SESSION["layout_config"]["currency_unit_back"]  = $layout_config["currency_unit_back"];
        } else {
            $front_language = $_SESSION["layout_config"]["front_language"];
        }


        // 언어파일 경로

        $_SESSION["layout_config"]["front_language"] = 'korean';
        $front_language                              = 'korean';
        return DOCUMENT_ROOT."/data/".MALL_ID."_data/_language/".$front_language."/*.php";
    }
}