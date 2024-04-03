<?php
function array_insert (&$array, $position, $insert_array) {
  $first_array = array_splice ($array, 0, $position);
  $array = array_merge ($first_array, $insert_array, $array);
}


function array_sum_($arrary_, $index_name){

	if(is_array($arrary_)	){
		for ( reset($arrary_); $key = key($arrary_); next($arrary_) ){
			$value = pos($arrary_);
			$totalprice = $value[$index_name];
			$sum += $totalprice;

		}

		return $sum;
	}else{
		return 0;
	}
}


function array_sampleing($arrary_, $index_name){

	for ( reset($arrary_); $key = key($arrary_); next($arrary_) ){
		$value = pos($arrary_);
		return $value[$index_name];
	}
}

function ConvertOptionText($pid, $options_){

	for($i=0;$i<count($options_);$i++){
		//echo $options_[$i]."<br>";
		if($mstr == ""){
			$mstr .= getMakeOption("", $pid, $options_[$i], "", "text",$options_[$i])."<br>";
		}else{
			$mstr .= getMakeOption("", $pid, $options_[$i], "", "text",$options_[$i])."<br>";
			//$mstr .= ",". getMakeOption("", $pid, $options_[$i], "", "text",$options_[$i]);
		}
	}

	if($mstr != ""){
		//return "<br><b>옵션 :".$mstr."</b>";
		return "<br><b>". $mstr."</b>";
	}else{
		return $mstr;
	}


}

function getcodeoptioncnt($option_name, $pid, $opn_ix="", $option_kind="c", $return_type="select",$select_option_id=""){
	global $user;
	$mdb = new Database;

	$sql = "select
			count(opn_ix) as cnt
			from
				".TBL_SHOP_PRODUCT_OPTIONS."
			where
				pid = '".$pid."'
				and option_kind in ('c','s')
				and option_use = '1'";

				//echo nl2br($sql);
	$mdb->query($sql);
	$mdb->fetch();
	
	return $mdb->dt['cnt'];
	
}

function getMakeOption($option_name, $pid, $opn_ix="", $option_kind="b", $return_type="select",$select_option_id=""){
	global $user, $shop_product_type, $_LANGUAGE;
	$mdb = new Database;
	
	$sql = "select p.id, p.listprice, p.sellprice , r.cid, c.depth
				from shop_product p,
				".TBL_SHOP_PRODUCT_RELATION." r,
				".TBL_SHOP_CATEGORY_INFO." c
				where p.id = '".$pid."' 
				and p.id = r.pid 				
				and c.cid = r.cid and r.basic = '1' ";
	$mdb->query($sql);
	$pinfos =  $mdb->fetchall();
	//$pid = $mdb->dt[id];
	

	$goods_infos[$pinfos[0]['id']]['pid'] = $pinfos[0]['id'];
	$goods_infos[$pinfos[0]['id']]['amount'] = $pinfos[0]['cid'];
	$goods_infos[$pinfos[0]['id']]['cid'] = $pinfos[0]['cid'];
	$goods_infos[$pinfos[0]['id']]['depth'] = $pinfos[0]['depth'];
	
	//$relation_display_type = $mdb->dt[relation_display_type]; 
	$discount_info = DiscountRult($goods_infos, $mdb->dt['cid'], $mdb->dt['depth']);

	foreach ($pinfos as $key => $sub_array) {
			 
		$select_ = array("icons_list"=>explode(";",$sub_array['icons']));
		array_insert($sub_array,14,$select_);

		$discount_item = $discount_info[$sub_array['id']]; 
		$_dcprice = $sub_array['sellprice'];
		if(is_array($discount_item)){				
			foreach($discount_item as $_key => $_item){ 
				if($_item['discount_value_type'] == "1"){ // % 
					$_dcprice = roundBetter($_dcprice*(100 - $_item['discount_value'])/100, $_item['round_position'], $_item['round_type']) ;//$_dcprice*(100 - $_item[discount_value])/100;		
				 
				}else if($_item['discount_value_type'] == "2"){// 원
					$_dcprice = $_dcprice - $_item['discount_value'];
				}
				$_item['expectation_discount_price'] = $sub_array['sellprice']-$_dcprice; 
				$discount_desc[] = $_item;
				
			}
			//print_r($discount_desc);				
		}
		$_dcprice = array("dcprice"=>$_dcprice);
		array_insert($sub_array,52,$_dcprice);
		$discount_desc = array("discount_desc"=>$discount_desc);
		array_insert($sub_array,53,$discount_desc);

		$pinfos[$key] = $sub_array;
	}

	$cid = $pinfos[0]['cid'];
	$depth = $pinfos[0]['depth'];
	$listprice = $pinfos[0]['listprice'];
	$sellprice = $pinfos[0]['sellprice'];
	$dcprice = $pinfos[0]['dcprice'];


	if(UserSellingType() == 'W' && ($option_kind=="b" || $option_kind=="x" || $option_kind=="x2" || $option_kind=="s2" || $option_kind=="c")){
		if(UserProductPriceType()=='L'){
			$o_select_price='option_wholesale_listprice AS option_listprice, option_wholesale_listprice AS option_price';
		}else{
			$o_select_price='option_wholesale_listprice AS option_listprice, option_wholesale_price AS option_price';//불러오는 컬럼 추가,변경 kbk 13/06/17
		}
	} else {
		if(UserProductPriceType()=='P' && ($option_kind=="b" || $option_kind=="x" || $option_kind=="x2" || $option_kind=="s2" || $option_kind=="c") ){
			$o_select_price='option_listprice, pod.option_premiumprice as option_price';
		}elseif(UserProductPriceType()=='L' && ($option_kind=="b" || $option_kind=="x" || $option_kind=="x2" || $option_kind=="s2" || $option_kind=="c") ){
			$o_select_price='option_listprice, pod.option_listprice as option_price';
		}else{
			$o_select_price='option_listprice, pod.option_price';
		}
	}

	/*
	select 박스의 option 에 attribute로 l_price(정가) 추가 함 kbk 13/06/17
	*/
	if($option_kind == "x2" || $option_kind == "s2" || $option_kind == "c") {//셋트 옵션의 경우 노출 순서를 달리함 kbk 13/07/01
		$order_by_text=" set_group ASC, id ASC ";
	} else {
		$order_by_text=" set_group_seq ASC,id ASC ";
	}
	if($return_type=="select" || $return_type=="cart_select" || $return_type=="table" || $return_type=="info"){
		if($option_kind == "c"){
			if($user['code'] != ""){
				$where = " and mem_ix = '".$user['code']."' and c.product_type in (".implode(' , ',$shop_product_type).")  ";				
				$groupby = " group by mem_ix";
			}else{
				$where = " and cart_key = '".session_id()."' and c.product_type in (".implode(' , ',$shop_product_type).") ";				
				$groupby = " group by cart_key";
			}
			if($return_type=="cart_select"){
				$sql = "select '".$pid."' as pid, pod.id, pod.id as opnd_ix, option_div, global_odinfo, pod.set_group,  set_group_seq, option_etc1 as set_cnt, ".$o_select_price.", pod.option_coprice, pod.option_stock, pod.option_sell_ing_cnt, pod.option_soldout, pod.option_etc1, pod.option_code, pod.option_barcode, IFNULL(c.select_option_id,'') as select_option_id, IFNULL(cart_ix,'') as cart_ix
							from ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." pod 
							left join shop_cart c on pod.id = c.select_option_id ".$where."
							where pod.pid = '$pid' and pod.opn_ix ='$opn_ix' 
							order by $order_by_text ";
			}else{
				$sql = "select '".$pid."' as pid,pod.id, pod.id as opnd_ix, option_div, global_odinfo, pod.set_group,  set_group_seq, option_etc1 as set_cnt, ".$o_select_price.", pod.option_coprice, pod.option_stock, pod.option_sell_ing_cnt, pod.option_soldout, pod.option_etc1, pod.option_code, pod.option_barcode
							from ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." pod 
							where pod.pid = '$pid' and pod.opn_ix ='$opn_ix' 
							order by $order_by_text ";
			}
			//left join (select pod.id as opnd_ix, pod.opn_ix from shop_product_options_detail pod , shop_cart c where c.select_option_id = pod.id ".$where.") podc on po.opn_ix = podc.opn_ix
		}else{
			$sql = "select '".$pid."' as pid, id, id as opnd_ix, option_div, global_odinfo, set_group,  set_group_seq, option_etc1 as set_cnt, ".$o_select_price.", option_coprice, option_stock, option_sell_ing_cnt, option_soldout, option_etc1, set_group, option_code,option_barcode, option_color, option_size
						from ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." pod 
						where pid = '$pid' and opn_ix ='$opn_ix' order by $order_by_text ";
		}
	}else{
		$sql = "select '".$pid."' as pid, pod.id, pod.id as opnd_ix, pod.option_div, pod.global_odinfo, set_group,  set_group_seq, option_etc1 as set_cnt, ".$o_select_price.", option_coprice, b.option_name, pod.set_group, pod.option_soldout, pod.option_etc1, option_code,option_barcode, option_color, option_size
				from ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." pod , ".TBL_SHOP_PRODUCT_OPTIONS." b 
				where pod.pid = '".$pid."' and pod.opn_ix = b.opn_ix ";
	}
	//echo nl2br($sql);
	$mdb->query($sql);
	$options = $mdb->fetchall();

	if(count($options) > 0){
		foreach ($options as $key => $sub_array) {
			//echo $key;
			$options[$key]['option_div'] = getGlobalTargetName($options[$key]['option_div'],$options[$key]['global_odinfo'],'option_div');
		}
	}



//print_r($options);
	if(count($options) > 0){
		//echo $cid.":::".$depth;
		$goods_infos[$pid]['pid'] = $pid;
		$goods_infos[$pid]['amount'] = 1;
		$goods_infos[$pid]['cid'] = $cid;
		$goods_infos[$pid]['depth'] = $depth;
		$discount_info = DiscountRult($goods_infos, $cid, $depth);
		//print_r($discount_info);

		foreach ($options as $key => $sub_array) {
			$select_ = array("icons_list"=>explode(";",$sub_array['icons']));
			array_insert($sub_array,14,$select_);

			$discount_item = $discount_info[$sub_array['pid']];
			//print_r($discount_item);
			$_dcprice = $sub_array['option_price'];
			if(is_array($discount_item)){				
				foreach($discount_item as $_key => $_item){ 
					//echo $option_kind."<br>";
					if($option_kind != "p" && $option_kind != "c2" && $option_kind != "i2" && $option_kind != "i1" && $option_kind != "c1" && $option_kind != "s" && $option_kind != "r"  && $option_kind != "a"){
						if($_item['discount_value_type'] == "1"){ // %
							//echo $_item[discount_value]."<br>";
							//$_dcprice = $_dcprice*(100 - $_item[discount_value])/100;		
							$_dcprice = roundBetter($_dcprice*(100 - $_item['discount_value'])/100, $_item['round_position'], $_item['round_type']) ;
						}else if($_item['discount_value_type'] == "2"){// 원
							$_dcprice = $_dcprice - $_item['discount_value'];
						}
						$discount_desc[] = $_item;
					}
				}
			}
			$_dcprice = array("option_dcprice"=>$_dcprice);
			array_insert($sub_array,52,$_dcprice);
			$discount_desc = array("discount_desc"=>$discount_desc);
			array_insert($sub_array,53,$discount_desc);

			$options[$key] = $sub_array;
			//print_r($options);
		}
	}
	
	if(count($options))
	{
		for($i=0 ; $i < count($options) ;$i++){
			$options[$i]['option_dcprice'] = getExchangeNationPrice($options[$i]['option_dcprice']);
			$options[$i]['option_price'] = getExchangeNationPrice($options[$i]['option_price']);
			$options[$i]['option_coprice'] = getExchangeNationPrice($options[$i]['option_coprice']);
			$options[$i]['option_listprice'] = getExchangeNationPrice($options[$i]['option_listprice']);
		}
	}

	$dcprice = getExchangeNationPrice($dcprice);

	if ($mdb->total == 0){
		//return "<input type=hidden name='options[]' value=''>";
		return "";
	}else{
		if($return_type=="select" || $return_type=="cart_select"){
			if($option_kind == "b"){

                $mdb->query("select GROUP_CONCAT(distinct option_color SEPARATOR ':') as option_color, GROUP_CONCAT(distinct option_size SEPARATOR ':') as option_size, o.option_type from ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." od , ".TBL_SHOP_PRODUCT_OPTIONS." o where o.pid = '$pid' and od.opn_ix ='$opn_ix' and od.opn_ix=o.opn_ix");
				$mdb->fetch();
				$option_color = trim($mdb->dt['option_color']);
				$option_size = trim($mdb->dt['option_size']);
                $option_type = trim($mdb->dt['option_type']);

				$relationBoolean = false;
				$mString = "";

				if(! empty($option_color) && ! empty($option_size) && $option_type == "o" ){ //칼라+색상
					$relationBoolean = true;
				}

				if($relationBoolean){
					$mString .= "<Select id='_goods_options2' class='Mgap_B5' onchange='selectRelationOptionBox($(this))'>";
					$mString .= "<option value=''>".getLanguageText('6a742e2979fd84eda83fbc4fd9c7c44a')."</option>";
					
					$distinct_option_data1 = array(); 
					for($i=0;$i < count($options); $i++){

						if(empty($distinct_option_data1[$options[$i]['option_color']])){

							$mString .= "<option value='".$options[$i]['option_color']."'>".$options[$i]['option_color']."</option>\n";

							$distinct_option_data1[$options[$i]['option_color']] = 1;
						}
					}
					$mString .= "</select>";
				}

				if(is_mobile()){
					$option_width='style="width:100%" ';
				}

				$mString .= "<Select name=options[] ".$option_width."id='_goods_options' opt_name='options_opn_ix_".$opn_ix."' class='goods_options' onchange=\"ChangeAddPriceOption('".$user['mem_level']."',$(this), this.selectedIndex,'".$option_kind."');\"  before_price=0 option_kind='".$option_kind."' title='$option_name' validation='".($return_type=="cart_select" ? "true":"true")."'>"; // 기본옵션이 왜 선택이었는지? 
				//$mString .= "<option value='' stock='0' n_price='0' m_price='0' d_price='0' a_price='0' etc1='' >선택해주세요</option>";
				$mString .= "<option value='' stock='0' l_price='0' n_price='0' etc1='' >(".getLanguageText('b63c09c8502017578f2fc4d209403471').")".getLanguageText('6a742e2979fd84eda83fbc4fd9c7c44a')."</option>";
				$i=0;
				for($i=0;$i < count($options); $i++){
					//$mdb->fetch($i);
					if(($options[$i]['option_dcprice']-$dcprice) > 0) {
						$add_op_text="(+".$_SESSION["layout_config"]["currency_unit_front"].getExchangeNationPriceNumberFormat($options[$i]['option_dcprice']-$dcprice).$_SESSION["layout_config"]["currency_unit_back"].")";
					}else if(($options[$i]['option_dcprice']-$dcprice) == 0) {
						$add_op_text="";	
					}else{
						$add_op_text="(".$_SESSION["layout_config"]["currency_unit_front"].getExchangeNationPriceNumberFormat($options[$i]['option_dcprice']-$dcprice).$_SESSION["layout_config"]["currency_unit_back"].")";
					}

                    $option_text = $option_name." : ";
                    if($relationBoolean){
                        $options[$i]['option_div'] = $options[$i]['option_size'];
                        $option_text .= $options[$i]['option_color'] . '+' . $options[$i]['option_size'];
                    }else{
                        $option_text .= $options[$i]['option_div'];
                        $option_div = $options[$i]['option_div'];
                    }

					if($select_option_id == $options[$i]['id']){
						$mString .= "<option value='".$options[$i]['id']."' stock='".($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt'])."' dc_price='".($options[$i]['option_dcprice'] > 0 ? ($options[$i]['option_dcprice']-$dcprice):$options[$i]['option_price'])."' c_price='".$options[$i]['option_coprice']."' l_price='".$options[$i]['option_listprice']."' n_price='".($options[$i]['option_dcprice'])."' soldout='".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) <= 0 ? "1":"0")."' etc1='".$options[$i]['option_etc1']."' option_text='".$option_text."' option_color='".$options[$i]['option_color']."' selected>".$options[$i]['option_div']."".$add_op_text."".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) <= 0 ? "[".getLanguageText('a80fe8671b561ae7b4b1dce5519a4e30')."]":"")."</option>\n";
					}else{
						$mString .= "<option value='".$options[$i]['id']."' stock='".($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt'])."' dc_price='".($options[$i]['option_dcprice'] > 0 ? ($options[$i]['option_dcprice']-$dcprice):$options[$i]['option_price'])."' c_price='".$options[$i]['option_coprice']."' l_price='".$options[$i]['option_listprice']."' n_price='".($options[$i]['option_dcprice'])."' soldout='".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) <= 0 ? "1":"0")."'  etc1='".$options[$i]['option_etc1']."' option_text='".$option_text."' option_color='".$options[$i]['option_color']."' >".$options[$i]['option_div']."".$add_op_text."".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) <= 0 ? "[".getLanguageText('a80fe8671b561ae7b4b1dce5519a4e30')."]":"")."</option>\n";
					}

				}
				$mString .= "</select>
				<div id='select_options_area' style='display:none;'>
					
				</div>";

				if($relationBoolean){
					$mString .= "
					<script type='text/javascript'>
						$('#select_options_area').append($('#_goods_options option:not(:first)'));

						function selectRelationOptionBox(tisObj){
							var option_color = tisObj.val();
							
							$('#select_options_area').append($('#_goods_options option:not(:first)'));

							if(option_color.length > 0){
								$('#_goods_options').append($('#select_options_area option[option_color=\"'+option_color+'\"]'));
							}
							$('#_goods_options').val('');
						}
					</script>
					";
				}


			}else if($option_kind == "p" || $option_kind == "c2" || $option_kind == "i2"){
				$mString = "<Select name=options[] id='_goods_options' opt='AddPriceOption' opt_name='options_opn_ix_".$opn_ix."' class='goods_options' onchange=\"ChangeAddPriceOption('".$user['mem_level']."',$(this), this.selectedIndex,'".$option_kind."');\"  befor_price=0 option_kind='".$option_kind."' title='$option_name' validation='false' style='width:95%;padding:3px;'>";
				//$mString .= "<option value='' stock='0' n_price='0' m_price='0' d_price='0' a_price='0' etc1='' >선택해주세요</option>";
				$mString .= "<option value='' stock='0' l_price='0' n_price='0' etc1='' >(".getLanguageText('a1c653f195c89993a6ba3f5536ec2465').")".getLanguageText('6a742e2979fd84eda83fbc4fd9c7c44a')."</option>";
				//getLanguageText('a1c653f195c89993a6ba3f5536ec2465'); - 선택
				//getLanguageText('6a742e2979fd84eda83fbc4fd9c7c44a') - 선택해주세요
				$mString .= "<option value='0' stock='0' option_text='' l_price='0' n_price='0' etc1='' >".getLanguageText('b4eab72c9875817e075e3b75d6b3d8de')."</option>";
				//getLanguageText('b4eab72c9875817e075e3b75d6b3d8de') - 선택하지 않음
				$i=0;
				for($i=0;$i < count($options); $i++){
					//$mdb->fetch($i);

					if($options[$i]['option_dcprice']>0) {
						$add_op_text="(+".$_SESSION["layout_config"]["currency_unit_front"].getExchangeNationPriceNumberFormat($options[$i]['option_dcprice']).$_SESSION["layout_config"]["currency_unit_back"].")";
					}
					if($select_option_id == $options[$i]['id']){
						/*
						$mString .= "<option value='".$options[$i][id]."' stock='".($options[$i][option_stock]-$options[$i][option_sell_ing_cnt])."' n_price='".$options[$i][option_price]."' m_price='".$options[$i][option_m_price]."' d_price='".$options[$i][option_d_price]."' a_price='".$options[$i][option_a_price]."' etc1='".$options[$i][option_etc1]."' selected>".$options[$i][option_div]."(".number_format($options[$i][option_price])." 원)</option>\n";
						*/
						$mString .= "<option value='".$options[$i]['id']."' stock='".($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt'])."' dc_price='".($options[$i]['option_dcprice'] > 0 ? $options[$i]['option_dcprice']:$options[$i]['option_price'])."'  l_price='".$options[$i]['option_listprice']."' n_price='".$options[$i]['option_price']."' soldout='".($options[$i]['option_soldout'] == "1" ? "1":"0")."' etc1='".$options[$i]['option_etc1']."' option_text='".$option_name." : ".$options[$i]['option_div']."' selected>".$options[$i]['option_div'].$add_op_text."".($options[$i]['option_soldout'] == "1" ? "[".getLanguageText('a80fe8671b561ae7b4b1dce5519a4e30')."]":"")."</option>\n";
					}else{
						/*
						$mString .= "<option value='".$options[$i][id]."' stock='".($options[$i][option_stock]-$options[$i][option_sell_ing_cnt])."' n_price='".$options[$i][option_price]."' m_price='".$options[$i][option_m_price]."' d_price='".$options[$i][option_d_price]."' a_price='".$options[$i][option_a_price]."' etc1='".$options[$i][option_etc1]."'>".$options[$i][option_div]."(".number_format($options[$i][option_price])." 원)</option>\n";
						*/
						$mString .= "<option value='".$options[$i]['id']."' stock='".($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt'])."' dc_price='".($options[$i]['option_dcprice'] > 0 ? $options[$i]['option_dcprice']:$options[$i]['option_price'])."'  l_price='".$options[$i]['option_listprice']."' n_price='".$options[$i]['option_price']."' soldout='".($options[$i]['option_soldout'] == "1" ? "1":"0")."'  etc1='".$options[$i]['option_etc1']."' option_text='".$option_name." : ".$options[$i]['option_div']."' >".$options[$i]['option_div'].$add_op_text."".($options[$i]['option_soldout'] == "1" ? "[".getLanguageText('a80fe8671b561ae7b4b1dce5519a4e30')."]":"")."</option>\n";

					}
					unset($add_op_text);
				}
				$mString .= "</select>";
			}else if($option_kind == "s"  || $option_kind == "c1" || $option_kind == "i1"){
				$mString = "<Select name=options[] id='_goods_options'  title='$option_name' opt_name='options_opn_ix_".$opn_ix."' validation='".($return_type=="cart_select" ? "false":"true")."' style='width:95%;padding:3px;' class='goods_options' onchange=\"ChangeAddPriceOption('".$user['mem_level']."',$(this), this.selectedIndex,'".$option_kind."');\" option_kind='".$option_kind."'>";
				//$mString .= "<option value='' stock='0' n_price='0' m_price='0' d_price='0' a_price='0' etc1='' >".$option_name."을 선택해주세요</option>";
				$mString .= "<option value='' stock='0' l_price='0' n_price='0' etc1='' >(".getLanguageText('b63c09c8502017578f2fc4d209403471').")".getLanguageText('6a742e2979fd84eda83fbc4fd9c7c44a')."</option>";
				//getLanguageText('6a742e2979fd84eda83fbc4fd9c7c44a') - 선택해주세요
				$i=0;
				for($i=0;$i < count($options); $i++){
					//$mdb->fetch($i);

					if($options[$i]['option_dcprice']>0) {
						$add_op_text="(+".$_SESSION["layout_config"]["currency_unit_front"].getExchangeNationPriceNumberFormat($options[$i]['option_dcprice']).$_SESSION["layout_config"]["currency_unit_back"].")";
					}

					if($select_option_id == $options[$i]['id']){
						/*
						$mString .= "<option value='".$options[$i][id]."' stock='".($options[$i][option_stock]-$options[$i][option_sell_ing_cnt])."' n_price='".$options[$i][option_price]."' m_price='".$options[$i][option_m_price]."' d_price='".$options[$i][option_d_price]."' a_price='".$options[$i][option_a_price]."' etc1='".$options[$i][option_etc1]."' selected>".$options[$i][option_div]."</option>\n";
						*/
						$mString .= "<option value='".$options[$i]['id']."' stock='".($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt'])."' dc_price='".($options[$i]['option_dcprice'] > 0 ? $options[$i]['option_dcprice']:$options[$i]['option_price'])."'  l_price='".$options[$i]['option_listprice']."' n_price='".$options[$i]['option_price']."' soldout='".($options[$i]['option_soldout'] == "1" ? "1":"0")."'  etc1='".$options[$i]['option_etc1']."' option_text='".$options[$i]['option_div']."' selected>".$options[$i]['option_div'].$add_op_text."".($options[$i]['option_soldout'] == "1" ? "[".getLanguageText('a80fe8671b561ae7b4b1dce5519a4e30')."]":"")."</option>\n";
					}else{
						/*
						$mString .= "<option value='".$options[$i][id]."' stock='".($options[$i][option_stock]-$options[$i][option_sell_ing_cnt])."' n_price='".$options[$i][option_price]."' m_price='".$options[$i][option_m_price]."' d_price='".$options[$i][option_d_price]."' a_price='".$options[$i][option_a_price]."' etc1='".$options[$i][option_etc1]."'>".$options[$i][option_div]."</option>\n";
						*/
						$mString .= "<option value='".$options[$i]['id']."' stock='".($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt'])."' dc_price='".($options[$i]['option_dcprice'] > 0 ? $options[$i]['option_dcprice']:$options[$i]['option_price'])."'  l_price='".$options[$i]['option_listprice']."' n_price='".$options[$i]['option_price']."' soldout='".($options[$i]['option_soldout'] == "1" ? "1":"0")."'  etc1='".$options[$i]['option_etc1']."' option_text='".$options[$i]['option_div']."' >".$options[$i]['option_div'].$add_op_text."".($options[$i]['option_soldout'] == "1" ? "[".getLanguageText('a80fe8671b561ae7b4b1dce5519a4e30')."]":"")."</option>\n";
					}
					unset($add_op_text);
				}
				$mString .= "</select>";

				

			}else if($option_kind == "a"){
				$mString = "<Select name=options[] id='_goods_options'  title='$option_name' opt_name='options_opn_ix_".$opn_ix."' class='goods_options' validation='false' style='width:95%;padding:3px;' onchange=\"ChangeAddPriceOption('".$user['mem_level']."',$(this), this.selectedIndex,'".$option_kind."');\" option_kind='".$option_kind."'>";
				//$mString .= "<option value='' stock='0' n_price='0' m_price='0' d_price='0' a_price='0' etc1='' >".$option_name."을 선택해주세요</option>";
				$mString .= "<option value='' stock='0' l_price='0' n_price='0' etc1='' >".getLanguageText('6a742e2979fd84eda83fbc4fd9c7c44a')."</option>";

				$i=0;
				for($i=0;$i < count($options); $i++){
					//$mdb->fetch($i);

					if($options[$i]['option_dcprice']>0) {
						$add_op_text="(".$_SESSION["layout_config"]["currency_unit_front"].getExchangeNationPriceNumberFormat($options[$i]['option_dcprice']).$_SESSION["layout_config"]["currency_unit_back"].")";
					}

					if($select_option_id == $options[$i]['id']){
						/*
						$mString .= "<option value='".$options[$i][id]."' stock='".($options[$i][option_stock]-$options[$i][option_sell_ing_cnt])."' n_price='".$options[$i][option_price]."' m_price='".$options[$i][option_m_price]."' d_price='".$options[$i][option_d_price]."' a_price='".$options[$i][option_a_price]."' etc1='".$options[$i][option_etc1]."' selected>".$options[$i][option_div]."</option>\n";
						*/
						$mString .= "<option value='".$options[$i]['id']."' stock='".($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt'])."' dc_price='".($options[$i]['option_dcprice'] > 0 ? $options[$i]['option_dcprice']:$options[$i]['option_price'])."'  l_price='".$options[$i]['option_listprice']."' n_price='".$options[$i]['option_price']."' soldout='".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) < 0 ? "1":"0")."'  etc1='".$options[$i]['option_etc1']."' option_text='".$options[$i]['option_div']."'  selected>".$options[$i]['option_div'].$add_op_text."".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) < 0 ? "[".getLanguageText('a80fe8671b561ae7b4b1dce5519a4e30')."]":"")."</option>\n";
					}else{
						/*
						$mString .= "<option value='".$options[$i][id]."' stock='".($options[$i][option_stock]-$options[$i][option_sell_ing_cnt])."' n_price='".$options[$i][option_price]."' m_price='".$options[$i][option_m_price]."' d_price='".$options[$i][option_d_price]."' a_price='".$options[$i][option_a_price]."' etc1='".$options[$i][option_etc1]."'>".$options[$i][option_div]."</option>\n";
						*/
						$mString .= "<option value='".$options[$i]['id']."' stock='".($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt'])."' dc_price='".($options[$i]['option_dcprice'] > 0 ? $options[$i]['option_dcprice']:$options[$i]['option_price'])."'  l_price='".$options[$i]['option_listprice']."' n_price='".$options[$i]['option_price']."' soldout='".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) < 0 ? "1":"0")."'  etc1='".$options[$i]['option_etc1']."' option_text='".$options[$i]['option_div']."' >".$options[$i]['option_div'].$add_op_text."".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) < 0 ? "[".getLanguageText('a80fe8671b561ae7b4b1dce5519a4e30')."]":"")."</option>\n";
					}
					unset($add_op_text);
				}
				$mString .= "</select>";
			}else if($option_kind == "r"){

				$uploaddir = UploadDirText($_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]['mall_data_root']."/images/product", $pid, 'Y');
				$mstring_images = "";
				//$mString = "<Select name=options[] id='_goods_options'  title='$option_name' opt_name='options_opn_ix_".$opn_ix."' validation='true' style='width:100%;height:20px;' class='goods_options' onchange=\"ChangeAddPriceOption('".$user[mem_level]."',this, this.selectedIndex);\">";
				//$mString .= "<option value='' stock='0' n_price='0' m_price='0' d_price='0' a_price='0' etc1='' >".$option_name."을 선택해주세요</option>";

				$i=0;
				for($i=0;$i < count($options); $i++){
					//$mdb->fetch($i);
					$opnd_ix = $options[$i]['id'];

					if($i == 0){
						$option_etc1 = $options[$i]['option_etc1'];
					}
					/*
					if($select_option_id == $options[$i][id]){
						$mString .= "<option value='".$options[$i][id]."' stock='".($options[$i][option_stock]-$options[$i][option_sell_ing_cnt])."' n_price='".$options[$i][option_price]."' m_price='".$options[$i][option_m_price]."' d_price='".$options[$i][option_d_price]."' a_price='".$options[$i][option_a_price]."' etc1='".$options[$i][option_etc1]."' selected>".$options[$i][option_div]."</option>\n";
					}else{
						$mString .= "<option value='".$options[$i][id]."' stock='".($options[$i][option_stock]-$options[$i][option_sell_ing_cnt])."' n_price='".$options[$i][option_price]."' m_price='".$options[$i][option_m_price]."' d_price='".$options[$i][option_d_price]."' a_price='".$options[$i][option_a_price]."' etc1='".$options[$i][option_etc1]."'>".$options[$i][option_div]."</option>\n";
					}
					*/

					$option_size = split(":",$options[$i]['option_etc1']);
					//print_r($option_size);
					$option_size_detail = explode("^",$option_size[1]);
					$option_size_detail_html .= "<div id='options_size_".$opn_ix."_".$opnd_ix."' class='option_relation_area' style='cursor:pointer;".($i == 0 ? "display:block;":"display:none;").";'>";
					for($j=0;$j < count($option_size_detail);$j++){
						$option_size_detail_html .= "<div style='float:left;border:1px solid silver;margin:0px 0px 2px 2px;padding:5px;' class='option_sizes' onclick=\"$('#option_size').val($(this).html());$('#options_text').val($('#option_color').val()+'-'+$('#option_size').val());$('.option_sizes').css('background-color','#ffffff');$(this).css('background-color','#efefef');\">".$option_size_detail[$j]."</div>";
					}
					$option_size_detail_html .= "</div>";

					if(file_exists($_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]["mall_data_root"]."/images/product".$uploaddir."/options/options_detail_".$opnd_ix."_s.gif")){
						if(file_exists($_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]["mall_data_root"]."/images/product".$uploaddir."/options/options_detail_".$opnd_ix."_b.gif")){
							$b_img_src = $_SESSION["layout_config"]['mall_data_root']."/images/product".$uploaddir."/options/options_detail_".$opnd_ix."_b.gif";
						}else{
							$b_img_src = "";
						}

						$mstring_images .= "<img src='".$_SESSION["layout_config"]['mall_data_root']."/images/product".$uploaddir."/options/options_detail_".$opnd_ix."_s.gif' class='option_colors' style='cursor:pointer;margin:2px 0px 0px 2px;border:2px solid #ffffff' title=\"".$options[$i]['option_div']."\"  onclick=\"SelectRelationOption($(this), '".$opn_ix."', '".$opnd_ix."')\" b_img_src='".$b_img_src."' befor_price='0' n_price='".$options[$i]['option_price']."' title='".$options[$i]['option_div']."'>
						";
					}else{
						$mstring_images .= "<div class='option_colors' style='float:left;cursor:pointer;padding:4px;margin:1px;border:2px solid silver' title=\"".$options[$i]['option_div']."\"  onclick=\"SelectRelationOption($(this), '".$opn_ix."', '".$opnd_ix."')\" >".$options[$i]['option_div']."</div>";
					}
				}
				//$mString .= "</select>";

				$mString = "<table width=100%>
									<tr><td style='padding-top:5px;'>".$mstring_images."</td></tr>
									<tr><td style='padding:10px 0px 0px 0px'>".$option_size_detail_html."</td></tr>
									<tr><td style='padding:10px 0px 0px 0px'><input type=text name=options_text id='options_text' value='' style='border:0px;width:100%;' readonly></td></tr>
									</table>
								<input type=hidden name=options[] id='select_option_color' value='' title='".getLanguageText('67633b6dfa198c366a41b0fa50514d37')."' validation='true'>
								<br>
								<input type=hidden name=option_color id='option_color' value=''><br>
								<input type=hidden name=option_size id='option_size' value='' title='".getLanguageText('090e079c32798eee14cc09da35c136a0')."' validation='true'>
				<script javascript='language'>
					function SelectRelationOption(obj_id, opn_ix, opnd_ix){
						try{
							//alert(1);
							$('#option_size').val('');
							$('#option_color').val(obj_id.attr('title'));
							$('#options_text').val($('#option_color').val()+'-'+$('#option_size').val());
							$('.option_relation_area').css('display','none');
							$('#options_size_'+$opn_ix+'_'+ opnd_ix).css('display','block');
							if(obj_id.attr('b_img_src') != ''){
							//	alert(obj_id.attr('b_img_src'));
								$('#main_img').attr('src',obj_id.attr('b_img_src'));
							}

							$('#select_option_color').val(opnd_ix);


							$('.option_colors').css('border','2px solid silver');
							obj_id.css('border','2px solid #000000');
							ChangeRelationOption('".$user['mem_level']."',obj_id, '".$options[$i]['id']."');
						}catch(e){
							//alert(e.message);
						}
					}
				</script>";
			}else if($option_kind == "c" || $return_type=="cart_select"){
				$mString = "<Select name=set_options[] id='_goods_optionsss'  minicart_id='opnd_ix' title='$option_name' opt_name='options_opn_ix_".$opn_ix."'  validation='".($return_type=="cart_select" ? "false":"true")."' style='width:95%;padding:3px;' class='codi_goods_options' option_kind='".$option_kind."'>"; //onchange=\"ChangeCodipriceOption('".$user[mem_level]."',this, this.selectedIndex);\"
				//$mString .= "<option value='' stock='0' n_price='0' m_price='0' d_price='0' a_price='0' etc1='' >".$option_name."을 선택해주세요</option>";
				$mString .= "<option value='' stock='0' l_price='0' n_price='0' etc1='' >".getLanguageText('6a742e2979fd84eda83fbc4fd9c7c44a')."</option>";

				$i=0;
				for($i=0;$i < count($options); $i++){
					//$mdb->fetch($i);

					if($options[$i]['option_dcprice']>0) {
						$add_op_text="(+".$_SESSION["layout_config"]["currency_unit_front"].getExchangeNationPriceNumberFormat($options[$i]['option_dcprice']).$_SESSION["layout_config"]["currency_unit_back"].")";
					}

					if($options[$i]['select_option_id'] == $options[$i]['id']){
						/*
						$mString .= "<option value='".$options[$i][id]."' stock='".($options[$i][option_stock]-$options[$i][option_sell_ing_cnt])."' n_price='".$options[$i][option_price]."' m_price='".$options[$i][option_m_price]."' d_price='".$options[$i][option_d_price]."' a_price='".$options[$i][option_a_price]."' etc1='".$options[$i][option_etc1]."' selected>".$options[$i][option_div]."</option>\n";
						*/
						$mString .= "<option value='".$options[$i]['id']."' opn_ix='".$opn_ix."' stock='".($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt'])."' dc_price='".($options[$i]['option_dcprice'] > 0 ? $options[$i]['option_dcprice']:$options[$i]['option_price'])."' l_price='".$options[$i]['option_listprice']."' n_price='".$options[$i]['option_price']."' soldout='".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) < 0 ? "1":"0")."' etc1='".$options[$i]['option_etc1']."' cart_ix='".$options[$i]['cart_ix']."'  option_text='".$options[$i]['option_div']."'  selected>".$options[$i]['option_div'].$add_op_text."".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) < 0 ? "[".getLanguageText('a80fe8671b561ae7b4b1dce5519a4e30')."]":"")."</option>\n";
					}else{
						/*
						$mString .= "<option value='".$options[$i][id]."' stock='".($options[$i][option_stock]-$options[$i][option_sell_ing_cnt])."' n_price='".$options[$i][option_price]."' m_price='".$options[$i][option_m_price]."' d_price='".$options[$i][option_d_price]."' a_price='".$options[$i][option_a_price]."' etc1='".$options[$i][option_etc1]."'>".$options[$i][option_div]."</option>\n";
						*/
						$mString .= "<option value='".$options[$i]['id']."' opn_ix='".$opn_ix."' stock='".($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt'])."' dc_price='".($options[$i]['option_dcprice'] > 0 ? $options[$i]['option_dcprice']:$options[$i]['option_price'])."'  l_price='".$options[$i]['option_listprice']."' n_price='".$options[$i]['option_price']."' soldout='".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) < 0 ? "1":"0")."'  etc1='".$options[$i]['option_etc1']."' option_text='".$options[$i]['option_div']."'  cart_ix='".$options[$i]['cart_ix']."'>".$options[$i]['option_div'].$add_op_text."".($options[$i]['option_soldout'] == "1" || ($options[$i]['option_stock']-$options[$i]['option_sell_ing_cnt']) < 0 ? "[".getLanguageText('a80fe8671b561ae7b4b1dce5519a4e30')."]":"")."</option>\n";
					}
					unset($add_op_text);
				}
				$mString .= "</select>";

			} else if($option_kind == "x" || $option_kind == "x2" || $option_kind == "s2" ){// || $option_kind == "a"
				//$option_details = $mdb->fetchall();;
				return $options;//$option_details;
			}
		}else if($return_type=="table"){
			
			$mString = "<table cellpadding=6 width=360 id='table_options_area'>
								<col width='20px'>
								<col width='*'>
								<col width='160px'>";
				$mString .= "<tr> <td><input type=checkbox name='check_all' id='check_all'  onclick=\"if( $(this).attr('checked')){ $('table#table_options_area input.table_options').not(':disabled').attr('checked',true);}else{ $('table#table_options_area input.table_options').attr('checked',false);};\" align=absmiddle></td><td><label for='check_all'>전체 선택</label></td></tr>";


				for($i=0;$i < count($options); $i++){
					//$mdb->fetch($i);

					$option_stock_cnt=$options[$i]['option_stock']-abs($options[$i]['option_sell_ing_cnt']);//판매진행재고가 - 인 경우도 생기므로 abs(절대값)으로 변환시켜서 계산 kbk 13/06/28
					if($option_stock_cnt>0) {
						$option_stock_cnt_text=" : ".$option_stock_cnt."개";
					} else {
						$option_stock_cnt_text=" : 0개";
						$option_stock_cnt=0;
					}

					if($select_option_id == $options[$i]['id']){						
						$mString .= "<tr><td height=25><input type=checkbox name='option[]' class='table_options' id='table_option_".$options[$i]['id']."' value='".$options[$i]['id']."' stock='".$option_stock_cnt."' n_price='".$options[$i]['option_price']."' etc1='".$options[$i]['option_etc1']."' onclick=\"($('#select_option_id').val($(this).val()))\"/> </td><td> <label for='table_option_".$options[$i]['id']."'>".$options[$i]['option_div'].$option_stock_cnt_text."</label></td>
						<td>
						<div class='btn_option_num'>
							<div class='input_box_border01'>
								<input type='text' name='option_pcount[]' id='option_pcount_".$options[$i]['id']."' value=1 size=4 maxlength=3 onkeydown='onlyEditableNumber(this)' onkeyup='onlyEditableNumber(this);' >
							</div>
							<ul>
								<li><img src='".$_SESSION["layout_config"]["mall_templet_webpath"]."/images/up_arrow.gif' alt='' onclick=\"pcount_cnts($('#option_pcount_".$options[$i]['id']."'),'p');\" style='cursor:pointer;'></li>
								<li><img src='".$_SESSION["layout_config"]["mall_templet_webpath"]."/images/down_arrow.gif' alt='' onclick=\"pcount_cnts($('#option_pcount_".$options[$i]['id']."'),'m');\" style='cursor:pointer;'></li>
							</ul>
						</div>
						</td>
						</tr>\n";
					}else{
						$mString .= "<tr><td height=25 >
						<input type=checkbox name='option[]' class='table_options'  id='table_option_".$options[$i]['id']."'  value='".$options[$i]['id']."' stock='".$option_stock_cnt."' n_price='".$options[$i]['option_price']."' etc1='".$options[$i]['option_etc1']."' onclick=\"if( $(this).attr('stock') == 0){ $(this).attr('checked',false);alert('재고수량이 부족해서 구매하실수 없습니다.');}\" ".($option_stock_cnt == 0 ? "disabled":"")."/> </td><td> <label for='table_option_".$options[$i]['id']."'>".$options[$i]['option_div'].$option_stock_cnt_text."</label></td>
						<td>
						<div class='btn_option_num'>
							<div class='input_box_border01'>
								<input type='text' name='option_pcount[]' id='option_pcount_".$options[$i]['id']."' value=1 size=4 maxlength=3 onkeydown='onlyEditableNumber(this)' onkeyup='onlyEditableNumber(this);' >
							</div>
							<ul>
								<li><img src='".$_SESSION["layout_config"]["mall_templet_webpath"]."/images/up_arrow.gif' alt='' onclick=\"pcount_cnts($('#option_pcount_".$options[$i]['id']."'),'p');\" style='cursor:pointer;'></li>
								<li><img src='".$_SESSION["layout_config"]["mall_templet_webpath"]."/images/down_arrow.gif' alt='' onclick=\"pcount_cnts($('#option_pcount_".$options[$i]['id']."'),'m');\" style='cursor:pointer;'></li>
							</ul>
						</div>
						</td>
						</tr>\n";
					}

				}
			//	print_r($_SESSION);
				$mString .= "</table>";
		}else if($return_type=="info"){
			$mString = "<table cellpadding=6 width=360 id='table_options_area'> ";
				 

				for($i=0;$i < count($options); $i++){
					//$mdb->fetch($i);

					$option_stock_cnt=$options[$i]['option_stock']-abs($options[$i]['option_sell_ing_cnt']);//판매진행재고가 - 인 경우도 생기므로 abs(절대값)으로 변환시켜서 계산 kbk 13/06/28
					if($option_stock_cnt>0) {
						$option_stock_cnt_text=" : ".$option_stock_cnt."개";
					} else {
						$option_stock_cnt_text=" : 0개";
						$option_stock_cnt=0;
					}

				 
						$mString .= "<tr> <td>[".$option_name."]  ".$options[$i]['option_div'].$option_stock_cnt_text." </td> </tr>\n";
					

				}
			//	print_r($_SESSION);
				$mString .= "</table><br> ";
		}else{
			for($i=0;$i < count($options); $i++){
				//$mdb->fetch($i);

				if($select_option_id == $options[$i]['id']){
					return $options[$i]['option_name'] ." : ".$options[$i]['option_div'];
				}
			}
		}
	}


	return $mString;
}

function getModalMakeOption($option_name, $pid, $opn_ix="",$option_kind="b", $cart_ix=""){
	global $user, $_LANGUAGE;
	$mdb = new Database;
/*
	$sql = "select id, option_div,option_price, option_m_price,option_d_price,option_a_price, option_stock, option_etc1
			from ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." a
			where pid = '$pid' and opn_ix ='$opn_ix' order by id asc";
*/
/*
	$sql = "select id, option_div,option_price, option_m_price,option_d_price,option_a_price, option_stock, option_sell_ing_cnt, option_etc1, IFNULL(opn_d_ix,'') as opn_d_ix
			from ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." a left join shop_cart_options co on pod.id = co.opn_d_ix and cart_ix = '".$cart_ix."'
			where pid = '$pid' and opn_ix ='$opn_ix' order by id asc";
*/
	
	if(UserSellingType() == 'W' && ($option_kind=="b" || $option_kind=="x" || $option_kind=="x2" || $option_kind=="s2" || $option_kind=="c")){
		if(UserProductPriceType()=='L'){
			$o_select_price='option_wholesale_listprice AS option_listprice, option_wholesale_listprice AS option_price';
		}else{
			$o_select_price='option_wholesale_listprice AS option_listprice, option_wholesale_price AS option_price';//불러오는 컬럼 추가,변경 kbk 13/06/17
		}
	} else {
		if(UserProductPriceType()=='P' && ($option_kind=="b" || $option_kind=="x" || $option_kind=="x2" || $option_kind=="s2" || $option_kind=="c") ){
			$o_select_price='option_listprice, pod.option_premiumprice as option_price';
		}elseif(UserProductPriceType()=='L' && ($option_kind=="b" || $option_kind=="x" || $option_kind=="x2" || $option_kind=="s2" || $option_kind=="c")){
			$o_select_price='option_listprice, pod.option_listprice as option_price';
		}else{
			$o_select_price='option_listprice, pod.option_price';
		}
	}

	$sql = "select id, option_div,".$o_select_price.", option_stock, option_sell_ing_cnt, option_etc1, IFNULL(opn_d_ix,'') as opn_d_ix
			from ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." a left join shop_cart_options co on a.id = co.opn_d_ix and cart_ix = '".$cart_ix."'
			where pid = '$pid' and opn_ix ='$opn_ix' order by id asc";
	//echo $sql;
	$mdb->query($sql);

	/*
	select 박스의 option 에 attribute로 l_price(정가) 추가 함 kbk 13/06/17
	*/

	if ($mdb->total == 0){
		//return "<input type=hidden name='options[]' value=''>";
		return "";
	}else{
		if($option_kind == "b") $change_func=" onchange=\"ChangeListOption(this, this.selectedIndex, 0,'".$user['mem_level']."');\" ";
		else $change_func=" onchange=\"ChangeListAddOption(this, this.selectedIndex, 0,'".$user['mem_level']."');\" ";
		$mString = "<Select name=options[0][] ".($option_kind == "b" ? "class='options'":"class='goods_options'")."  id='_goods_options' ".$change_func." title='$option_name' ".($option_kind == "p" ? "validation='false'":"validation='true'")." style='border:0px;width:188px;height:18px;font-size:11px;'>";
		$mString .= "<option value='' stock='0' l_price='0' n_price='0'>".getLanguageText('6a742e2979fd84eda83fbc4fd9c7c44a')." : ".$option_name."</option>";

		$i=0;
		for($i=0;$i < $mdb->total; $i++){
			$mdb->fetch($i);

			/*if($option_kind == "b"){
				$price_str = "(".number_format($mdb->dt[option_price])." 기본상품가격변경)";
			}else{
				if($mdb->dt[option_price] > 0){
					$price_str = "(".number_format($mdb->dt[option_price])." 추가)";
				}
			}*///옵션에 대한 설명이나 가격은 사용자가 직접 입력하는게 나은듯 11-10-13 kbk
			$mString .= "<option value='".$mdb->dt['id']."' stock='".($mdb->dt['option_stock']-$mdb->dt['option_sell_ing_cnt'])."' l_price='".$mdb->dt['option_listprice']."' n_price='".$mdb->dt['option_price']."' ".( $mdb->dt['id'] == $mdb->dt['opn_d_ix'] ? "selected" : "")." op_name='".$mdb->dt['option_div']."'>".$mdb->dt['option_div']." ".$price_str." </option>\n";

		}
		$mString .= "</select>";
	}

	return $mString;
}
