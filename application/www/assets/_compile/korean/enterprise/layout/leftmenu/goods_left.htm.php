<?php /* Template_ 2.2.8 2024/03/12 14:06:07 /home/barrel-stage/application/www/assets/templet/enterprise/layout/leftmenu/goods_left.htm 000008603 */ 
$TPL_filter_1=empty($TPL_VAR["filter"])||!is_array($TPL_VAR["filter"])?0:count($TPL_VAR["filter"]);?>
<section class="fb__left-goodsList">
	<div class="goodsNav">
		<div class="goodsNav__header">
			<span class="goodsNav__inner">
				<h2 class="goodsNav__title"><?php echo $TPL_VAR["topCateName"]?></h2>
			</span>
		</div>
		<ul class="goodsNav__wrap">
<?php if(is_array($TPL_R1=$TPL_VAR["cateArr"]["subCate"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<li class="goodsNav__list">
				<div class="goodsNav__subHeader">
					<a href="/shop/subGoodsList/<?php echo $TPL_V1["cid"]?>" class="goodsNav__subHeader--link">
						<h3 class="goodsNav__subList <?php if($TPL_V1["cid"]==$TPL_VAR["cid"]){?> goodsNav__subList--active <?php }?>"><?php echo $TPL_V1["cname"]?></h3>
					</a>
				</div>
<?php if($TPL_V1["subCate"]){?>
				<ul class="goodsNav__cont goodsNav__cont--active">
<?php if(is_array($TPL_R2=$TPL_V1["subCate"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<li class="goodsNav__subList-inner">
						<a href="/shop/subGoodsList/<?php echo $TPL_V2["cid"]?>" class="goodsNav__subList-link <?php if($TPL_V2["cid"]==$TPL_VAR["cid"]){?> goodsNav__subList-link--active <?php }?>"><?php echo $TPL_V2["cname"]?></a>
					</li>
<?php }}?>
				</ul>
<?php }?>
			</li>
<?php }}?>
		</ul>
	</div>
	<div class="goodsNav__filter">
		<div class="filter__header">
			<h2 class="filter__header-title">필터</h2>
		</div>
		<div class="filter__content">
			<ul>
<?php if($TPL_filter_1){foreach($TPL_VAR["filter"] as $TPL_V1){?>
				<li class="filter__list">
					<dl>
						<dt class="filter__title"><?php echo $TPL_V1["filter_type_text"]?></dt>
						<dd class="filter__cont-box <?php if($TPL_V1["filter_type"]=='COLOR'){?> filter__color-box <?php }?>">
							<ul>
<?php if(is_array($TPL_R2=$TPL_V1["item"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<li class="filter__inner <?php if($TPL_V1["filter_type"]=='COLOR'){?>filter__inner--color<?php }?>">
<?php if($TPL_V1["filter_type"]=='COLOR'){?>
									<label class="filter__checkbox filter__checkbox-color">
										<input type="checkbox" class="devFilterItem" name="<?php echo $TPL_V1["filter_type"]?>" value="<?php echo $TPL_V2["filter_idx"]?>" />
										<figure class="thumb">
											<img src="<?php echo $TPL_V2["filter_img_pc"]?>" alt="<?php echo trans($TPL_V2["filter_name"])?>" title="<?php echo trans($TPL_V2["filter_name"])?>" />
										</figure>
									</label>
<?php }else{?>
									<label class="filter__checkbox2 filter__checkbox-size">
										<input type="checkbox" class="devFilterItem" name="<?php echo $TPL_V1["filter_type"]?>" value="<?php echo $TPL_V2["filter_idx"]?>" />
										<span><?php echo $TPL_V2["filter_name"]?></span>
									</label>
<?php }?>
								</li>
<?php }}?>
							</ul>
						</dd>
					</dl>
				</li>
<?php }}?>
				<!--
				<li class="filter__list">
					<dl>
						<dt class="filter__title">AAA</dt>
						<dd class="filter__price">
							<ul>
								<li class="filter__button__inner">
									<label for="filter__checkbox" class="filter__button-price">
										<input type="checkbox" class="devFilterItem" name="" value="" />
										<span>11111</span>
									</label>
								</li>
							</ul>
						</dd>
					</dl>
				</li>
				<li class="filter__list">
					<dl>
						<dt class="filter__title">의류</dt>
						<dd class="filter__cont-box">
							<ul>
								<li class="filter__inner">
									<label class="filter__checkbox filter__checkbox-size">
										<input type="checkbox" class="devFilterItem" name="" value="" />
										<span>2XS</span>
									</label>
								</li>
				-->
				<li class="filter__list">
					<dl>
						<dt class="filter__title">가격</dt>
						<dd class="filter__price">
							<ul>
								<li class="filter__button__inner">
									<label for="search_price_1" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" id="search_price_1" class="devFilterItemPrice" value="1" data-sprice="0" data-eprice="10000" />
<?php }else{?>
										<input type="radio" name="search_price" id="search_price_1" class="devFilterItemPrice" value="1" data-sprice="0" data-eprice="10" />
<?php }?>
										<span class="font-rb"> 1만원 미만 </span>
									</label>
								</li>
								<li class="filter__button__inner">
									<label for="search_price_2" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" id="search_price_2" class="devFilterItemPrice" value="2" data-sprice="10000" data-eprice="30000" />
<?php }else{?>
										<input type="radio" name="search_price" id="search_price_2" class="devFilterItemPrice" value="2" data-sprice="10" data-eprice="30" />
<?php }?>
										<span class="font-rb"> 1만원 ~ 3만원 미만 </span>
									</label>
								</li>
								<li class="filter__button__inner">
									<label for="search_price_3" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" id="search_price_3" class="devFilterItemPrice" value="3" data-sprice="30000" data-eprice="50000" />
<?php }else{?>
										<input type="radio" name="search_price" id="search_price_3" class="devFilterItemPrice" value="3" data-sprice="30" data-eprice="50" />
<?php }?>
										<span class="font-rb"> 3만원 ~ 5만원 미만 </span>
									</label>
								</li>
								<li class="filter__button__inner">
									<label for="search_price_4" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" id="search_price_4" class="devFilterItemPrice" value="4" data-sprice="50000" data-eprice="100000" />
<?php }else{?>
										<input type="radio" name="search_price" id="search_price_4" class="devFilterItemPrice" value="4" data-sprice="50" data-eprice="100" />
<?php }?>
										<span class="font-rb"> 5만원 ~ 10만원 미만 </span>
									</label>
								</li>
								<li class="filter__button__inner">
									<label for="search_price_5" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" id="search_price_5" class="devFilterItemPrice" value="5" data-sprice="100000" data-eprice="150000" />
<?php }else{?>
										<input type="radio" name="search_price" id="search_price_5" class="devFilterItemPrice" value="5" data-sprice="100" data-eprice="150" />
<?php }?>
										<span class="font-rb"> 10만원 ~ 15만원 미만 </span>
									</label>
								</li>
								<li class="filter__button__inner">
									<label for="search_price_6" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" id="search_price_6" class="devFilterItemPrice" value="6" data-sprice="150000" data-eprice="200000" />
<?php }else{?>
										<input type="radio" name="search_price" id="search_price_6" class="devFilterItemPrice" value="6" data-sprice="150" data-eprice="200" />
<?php }?>
										<span class="font-rb"> 15만원 ~ 20만원 미만 </span>
									</label>
								</li>
								<li class="filter__button__inner">
									<label for="search_price_7" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" id="search_price_7" class="devFilterItemPrice" value="7" data-sprice="200000" data-eprice="250000" />
<?php }else{?>
										<input type="radio" name="search_price" id="search_price_7" class="devFilterItemPrice" value="7" data-sprice="200" data-eprice="250" />
<?php }?>
										<span class="font-rb"> 20만원 ~ 25만원 미만 </span>
									</label>
								</li>
								<li class="filter__button__inner">
									<label for="search_price_8" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" id="search_price_8" class="devFilterItemPrice" value="8" data-sprice="250000" data-eprice="9999999999" />
<?php }else{?>
										<input type="radio" name="search_price" id="search_price_8" class="devFilterItemPrice" value="8" data-sprice="250" data-eprice="999999" />
<?php }?>
										<span class="font-rb"> 25만원 이상 </span>
									</label>
								</li>
							</ul>
						</dd>
					</dl>
				</li>
			</ul>
		</div>
	</div>
</section>