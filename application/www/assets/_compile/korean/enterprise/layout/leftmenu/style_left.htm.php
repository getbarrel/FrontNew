<?php /* Template_ 2.2.8 2024/04/02 18:03:14 /home/barrel-stage/application/www/assets/templet/enterprise/layout/leftmenu/style_left.htm 000001941 */ 
$TPL_displayContentClassStyleList_1=empty($TPL_VAR["displayContentClassStyleList"])||!is_array($TPL_VAR["displayContentClassStyleList"])?0:count($TPL_VAR["displayContentClassStyleList"]);?>
<section class="fb__left-brandList StyleCuration">
	<div class="brandNav">
		<div class="brandNav__header">
<?php if($TPL_displayContentClassStyleList_1){$TPL_I1=-1;foreach($TPL_VAR["displayContentClassStyleList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
					<h2 class="brandNav__title" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["cname"]?></h2>
<?php }?>
<?php }}?>
		</div>
		<div class="brandNav__wrap">
			<ul class="brandNav__list">
				<li class="brandNav__main-menu <?php if($TPL_VAR["con_ix"]=='001002'){?> active<?php }?>">
					<a href="/content/styleList/" class="brandNav__main-link">전체</a>
				</li>
<?php if($TPL_displayContentClassStyleList_1){$TPL_I1=-1;foreach($TPL_VAR["displayContentClassStyleList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
<?php }else{?>
						<li class="brandNav__sub-menu<?php if($TPL_VAR["con_ix"]==$TPL_V1["cid"]){?> active<?php }?>"><!-- color:<?php echo $TPL_V1["c_preface"]?>; -->
							<a href="/content/styleList/<?php echo $TPL_V1["cid"]?>" class="brandNav__sub-link" style="<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["cname"]?></a>
						</li>
<?php }?>
<?php }}?>
			</ul>
		</div>
	</div>
</section>