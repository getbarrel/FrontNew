<?php /* Template_ 2.2.8 2023/07/18 10:19:58 /home/barrel-qa/application/www.bak/assets/mobile_templet/mobile_enterprise/mypage/search_goods_flow/search_goods_flow.htm 000001175 */ ?>
<html>
<body>
<?php if($TPL_VAR["error"]){?>
<script>alert('<?php echo $TPL_VAR["error"]?>');</script>
<?php }elseif($TPL_VAR["code_etc3"]=='POST'){?>
<form name='goods_flow' id='goods_flow' method='POST' action='<?php echo $TPL_VAR["code_etc1"]?>'>
    <input type='hidden' name='<?php echo $TPL_VAR["code_etc4"]?>' value='<?php echo $TPL_VAR["invoice_no"]?>' />
<?php if($TPL_VAR["code_ix"]== 41){?>
    <input type='hidden' name='search_type' value='1' />
    <input type='hidden' name='mode' value='SEARCH' />";
<?php }?>
</form>
<script language='javascript'>
    frm = document.goods_flow;
    frm.submit();
</script>
<?php }else{?>
<?php if($TPL_VAR["code_ix"]== 5){?>
<script language='javascript'>location.href='<?php echo $TPL_VAR["code_etc1"]?><?php echo $TPL_VAR["invoice_no"]?>&gubun=slipno';</script>
<?php }else{?>
<script language='javascript'>location.href='<?php echo $TPL_VAR["code_etc1"]?><?php echo $TPL_VAR["invoice_no"]?>';</script>
<?php }?>
<?php }?>
</body>
</html>