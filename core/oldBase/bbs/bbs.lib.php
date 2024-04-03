<?php

function getTempletPath($cid, $depth = '-1')
{
    global $user, $HTTP_URL;
    $mdb = new Database;
    if ($depth == '0') {
        $sql = "select * from ".TBL_SHOP_LAYOUT_INFO." where depth = 0 and cid LIKE '".substr($cid, 0, 3)."%' order by depth asc";
    } else if ($depth == '1') {
        $sql = "select * from ".TBL_SHOP_LAYOUT_INFO." where depth <= 1 and ((depth = 0 and cid LIKE '".substr($cid, 0, 3)."%') or (depth = 1 and cid LIKE '".substr($cid,
                0, 6)."%'))  order by depth asc";
    } else if ($depth == '2') {
        $sql = "select * from ".TBL_SHOP_LAYOUT_INFO." where depth <= 2 and ((depth = 0 and cid LIKE '".substr($cid, 0, 3)."%') or (depth = 1 and cid LIKE '".substr($cid,
                0, 6)."%') or (depth = 2 and cid LIKE '".substr($cid, 0, 9)."%'))  order by depth asc";
    } else if ($depth == '3') {
        $sql = "select * from ".TBL_SHOP_LAYOUT_INFO." where depth <= 3 and ((depth = 0 and cid LIKE '".substr($cid, 0, 3)."%') or (depth = 1 and cid LIKE '".substr($cid,
                0, 6)."%') or (depth = 2 and cid LIKE '".substr($cid, 0, 9)."%') or (depth = 3 and cid LIKE '".substr($cid, 0, 12)."%'))  order by depth asc";
    } else if ($depth == '4') {
        $sql = "select * from ".TBL_SHOP_LAYOUT_INFO." where depth <= 4 and ((depth = 0 and cid LIKE '".substr($cid, 0, 3)."%') or (depth = 1 and cid LIKE '".substr($cid,
                0, 6)."%') or (depth = 2 and cid LIKE '".substr($cid, 0, 9)."%') or (depth = 3 and cid LIKE '".substr($cid, 0, 12)."%') or (depth = 4 and cid LIKE '".substr($cid,
                0, 15)."%'))  order by depth asc";
        //$sql = "select * from ".TBL_SHOP_LAYOUT_INFO." where (depth = 0 and cid '".substr($cid,0,3)."%') or (depth = 0 and cid '".substr($cid,0,3)."%')LIKE cid LIKE '".substr($cid,0,3*($depth+1))."%' and depth <= '$depth' order by depth asc";
    } else {
        return "";
    }
    $mdb->query($sql);

    for ($i = 0; $i < $mdb->total; $i++) {
        $mdb->fetch($i);

        if ($i == 0) {
            $mstring .= $mdb->dt['path'];
        } else {
            $mstring .= "/".$mdb->dt['path'];
        }
    }
    return $mstring;
}

function checkOwner($o_ix, $mem_ix)
{
    $mdb = new Database();

    return true;
    //$sql = "SELECT o.o_ix,o.mem_ix, o.togather_mem_ix from cardstory_service_order o where o.o_ix = '$o_ix' ";
    //echo $sql;

    $mdb->query($sql);
    $mdb->fetch();

    if ($mem_ix != "" && ($mem_ix == $mdb->dt['mem_ix'] || $mem_ix == $mdb->dt['togather_mem_ix'])) {
        return true;
    } else {
        return false;
    }
}

function CheckNewContents($new, $templet_path = "/bbs/bbs_templet/basic/")
{
    if ($new) {
        return "<img src='".$templet_path."icon/icon_new.gif' align='texttop'>";
    }
}


function bbs_page_bar($total, $page, $max, $bbs_list_url, $templet_path = "/bbs/bbs_templet/basic/", $add_query = "")
{

    global $nset;
    global $HTTP_URL;
    //echo $HTTP_URL;

    if ($total % $max > 0) {
        $total_page = floor($total / $max) + 1;
    } else {
        $total_page = floor($total / $max);
    }

    if ($nset == "") {
        $nset = 1;
    }

    $next = (($nset) * 10 + 1);
    $prev = (($nset - 2) * 10 + 1);

    if ($paging_type == "inner") {
        $paging_type_param  = "view=innerview&";
        $paging_type_target = " target=act";
    } else {
        $paging_type_param  = "";
        $paging_type_target = "";
    }


    //echo $total_page.":::".$next."::::".$prev."<br>";
    if ($total) {
        $prev_mark = ($prev > 0) ? "<a href='".$HTTP_URL."?".$paging_type_param."nset=".($nset - 1)."&page=".(($nset - 2) * 10 + 1)."$add_query' ".$paging_type_target."><img src='".$templet_path."/img/pre10_a.gif' border=0 align=absmiddle></a> "
                : "<img src='".$templet_path."/img/pre10_b.gif' border=0 align=absmiddle> ";
        $next_mark = ($next <= $total_page) ? "<a href='".$HTTP_URL."?".$paging_type_param."nset=".($nset + 1)."&page=".($nset * 10 + 1)."$add_query' ".$paging_type_target."><img src='".$templet_path."/img/next10_a.gif' border=0 align=absmiddle></a>"
                : " <img src='".$templet_path."/img/next10_b.gif' border=0 align=absmiddle>";
    }

    $page_string = $prev_mark;

    for ($i = ($nset - 1) * 10 + 1; $i <= (($nset - 1) * 10 + 10); $i++) {
        if ($i > 0) {
            if ($i <= $total_page) {

                if ($i != $page) {
                    if ($i != (($nset - 1) * 10 + 1)) {
                        $page_string = $page_string.("<font color='silver'>|</font> 11<a href='".$HTTP_URL."?".$paging_type_param."nset=$nset&page=$i$add_query' style='font-weight:bold;color:gray' ".$paging_type_target.">$i</a> ");
                    } else {
                        $page_string = $page_string.(" <a href='".$HTTP_URL."?".$paging_type_param."nset=$nset&page=$i$add_query' style='font-weight:bold;color:gray' ".$paging_type_target.">$i</a> ");
                    }
                } else {

                    if ($i != (($nset - 1) * 10 + 1)) {
                        $page_string = $page_string.("<font color='silver'>|</font> <font color=#FF0000 style='font-weight:bold'>$i</font> ");
                    } else {
                        $page_string = $page_string.("<font color=#FF0000 style='font-weight:bold'>$i</font>1111 ");
                    }
                }
            }
        }
    }
    if ($nset < (floor($total_page / 10) + 1)) {
        $last_page_string = "<b style='color:gray'>...</b> <a href='".$HTTP_URL."?".$paging_type_param."nset=".(floor($total_page / 10) + 1)."&page=$total_page$add_query' style='font-weight:bold;color:gray' ".$paging_type_target.">$total_page</a> ";
    }
    $page_string = $page_string.$last_page_string.$next_mark;

    return $page_string;
}

function CompanyInfos($mem_ix, $cloum_name)
{
    $db = new Database;

    $sql = "select
				csd.md_code,
				AES_DECRYPT(UNHEX(cmd.name),'".$db->ase_encrypt_key."') as md_name
			from
				common_user as cu
				inner join common_member_detail as cmd on (cu.code = cmd.code)
				left join common_company_detail as ccd on (cu.company_id = ccd.company_id)
				left join common_seller_detail as csd on (ccd.company_id = csd.company_id)
			where
				cu.code = '".$mem_ix."'";

    $db->query($sql);
    $db->fetch();

    return $db->dt[$cloum_name];
}