<?php
function CartDisplay($vnoninterest)
{
    global $CART;
    global $sum;

    if ($vnoninterest == 0) {
        $cart_title = "일반구매내역";
    } elseif ($vnoninterest == 3) {
        $cart_title = "무이자 3개월 구매내역";
    } elseif ($vnoninterest == 6) {
        $cart_title = "무이자 6개월 구매내역";
    } elseif ($vnoninterest == 9) {
        $cart_title = "무이자 9개월 구매내역";
    }

    $mContents = "<table cellpadding=0 cellspacing=0>
					<tr height=38>
						<td colspan=2 style='padding-left:30px;font-size:10pt;'> &nbsp;<b>".$cart_title."</b></td>
					</tr>
					</table>
					<table cellpadding=0 cellspacing=0 border=0 bgcolor=#ffffff width=650 align=center>
						<tr align=center>						
							<td width=300 colspan=2 background='/mypage/img/tit_bg.gif' height=30>제 품 명</td><td width=90 background='/mypage/img/tit_bg.gif'>무이자<!--/적립금--></td><td width=50 background='/mypage/img/tit_bg.gif'>수량</td><td width=90 background='/mypage/img/tit_bg.gif'>판 매 가</td><td width=90 background='/mypage/img/tit_bg.gif'>합 계</td><td width=80 background='/mypage/img/tit_bg.gif'>취소</td>
						</tr>";

    if ($CART) {
        $sum     = 0;
        $num     = count($CART);
        $disp_id = 0;

        for (reset($CART); $key = key($CART); next($CART)) {
            $value = pos($CART);

            $pname       = $value[0];
            $count       = $value[1];
            $price       = $value[2];
            $pid         = $value[3];
            $reserve     = $value[4];
            $noninterest = $value[5];
            // $new = $value[4];
            // $hot = $value[5];
            $option      = $value[6];
            $total       = $price * $count;
            $sum         += $total;

            if ($noninterest >= $vnoninterest) {
                if ($new == 1) {
                    $product01 = "<img src='/shop/img/icon_new.gif'> ";
                }

                if ($hot == 1) {
                    $product01 = $product01."<img src='/shop/img/icon_hot.gif'> ";
                }

                if ($event == 1) {
                    $product01 = $product01."<img src='/shop/img/icon_event.gif'> ";
                }

                $mContents = $mContents."<tr>
						    <form method='post' action='/cart.php?act=mod&id=".$key."' onsubmit='return isNum(this.count)'>
						    <!--td width='31'><div align='center'>".$num."</div></td-->
						    <td align='left' height=55><a href='/shop/pinfo.php?id=".$key."'><img src='/shop/images/product/s_".$key.".gif' border=0 width=50 align=left></a></td><td style='padding:5px;'><a href='/shop/pinfo.php?id=".$key."'>".$pname."<br><b>$option</b></a></td>
						    <td align=center><!--img src='/shop/img/smallicon_mu.gif'> ".$noninterest."--> <img src='/shop/img/smallicon_reserve.gif'> ".number_format($reserve,
                        0)." </td>
						    <td>
						      <!--div align='center'><input class='input' style='text-align: right' type='text' name='count' size='3' maxlength='3' value='".$count."' onchange=\"document.frames['ChangeCart'].location.href='Cart_CountAdd.php?id=".$key."&act=mod&count='+this.value\"> 개</div-->
						     ".PrintQuantityOption($key, $count)."
						    </td>
						    <td><div align='right'>".number_format($price)."</div></td>
						    <td><div align='right'>".number_format($total)."</div></td>
						    <td><div align='center'><a href='cart.php?act=del&id=".$key."'><img src='/shop/img/bt_del.gif' border='0'></a></div></td>
						    </form>
						  </tr>
						  <tr height=1><td background='/img/dot.gif' colspan=7></td></tr>					  
						  ";
                $disp_id++;
            }
            $num--;
        }

        if ($disp_id == 0) {
            return "";
            $mContents = $mContents."<tr height=50>
						    <td colspan='7' align='center'>쇼핑내역이 없습니다.</td>
						  </tr>
						  <tr height=1><td background='/img/dot.gif' colspan=7></td></tr>
						  <tr height=10><td colspan=7></td></tr>
						  ";
        } else {
            $mContents = $mContents."
			            <tr height=4 bgcolor=#ffffff><td colspan=7></td></tr>	
						<tr height=1 bgcolor=e6e6e6><td colspan=7></td></tr>
						<tr height=50><td colspan=7 align=right style='padding-right:10px;'><a href='javascript:goOrder($vnoninterest,$sum)'><img src='/shop/img/bt_order.gif' border=0></a> <a href='/shop/index.php'><img src='/shop/img/bt_continue.gif' border=0></a></td></tr>";
        }
    } else {
        $mContents = $mContents."		  <tr height=50>
						    <td colspan='6' align='center'>쇼핑내역이 없습니다.</td>
						  </tr>
						  <tr height=1><td background='/img/dot.gif' colspan=7></td></tr>
						  <tr height=10><td colspan=6></td></tr>
						  ";
    }
    $mContents = $mContents."</table>";
    return $mContents;
}
/*
 * @ author		
 * @ date		
 * @ contents	
 */

function PrintQuantityOption($vpid, $vSelect)
{
    $num      = "1:2:3:4:5:6:7:8:9:10:15:20";
    $numarray = explode(":", $num);
    $size     = count($numarray);

    $m_string = "<select style='width:40px;' name='quantity' onchange=\"document.frames['ChangeCart'].location.href='cart_countadd.php?PID=".$vpid."&act=mod&count='+this.value\">";
    for ($i = 0; $i < $size; $i++) {
        if ($vSelect == $numarray[$i]) {
            $m_string = $m_string."	<option value='".$numarray[$i]."' selected>".$numarray[$i]."</option>\n";
        } else {
            $m_string = $m_string."	<option value='".$numarray[$i]."'>".$numarray[$i]."</option>\n";
        }
    }
    $m_string = $m_string."</select>";

    return $m_string;
}
