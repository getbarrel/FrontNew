<?php /* Template_ 2.2.8 2022/11/28 14:15:40 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/goods_pop/goods_pop.htm 000012138 */ 
$TPL_title_1=empty($TPL_VAR["title"])||!is_array($TPL_VAR["title"])?0:count($TPL_VAR["title"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$(document).ready(function () {
		//모달 해드 탭 박스
		$('.modal_tab_box a').click(function () {
			var activeOn = $(this).attr('data-tab');
			var activeTab = $(this).parent().find('a');
			var activeBox = $(this).parents('.modal_wrap').find('.modal_tab_con  ');
			activeTab.removeClass('active');
			activeBox.removeClass('active').hide();
			$(this).addClass('active');
			$("#"+ activeOn).addClass('active').fadeIn();		

			$(".size_guide_tab a").removeClass('active');
			$(".size_guide_tab a:nth-child(1)").addClass('active');
			activeBox.find($(".size_guide_con")).removeClass('active').hide();
			activeBox.find($(".size_guide_con:nth-child(1)")).addClass('active').show();
		});
		

		//모달 하위 탭 박스
		$('.size_guide_tab a').click(function () {
			var activeOn = $(this).attr('data-tab');
			var activeTab = $(this).parent().find('a');
			var activeBox = $(this).parents('.modal_tab_con').find('.size_guide_con');
			activeTab.removeClass('active');
			activeBox.removeClass('active').hide();
			$(this).addClass('active');
			$("#"+ activeOn).addClass('active').fadeIn();
		});
		

	});


	//마우스 가로 스크롤
	var dragFlag = false;
	var x, y, pre_x, pre_y;

	$(function () {
		$('#mouseMove').mousedown(
			function (e) {
				dragFlag = true;
				var obj = $(this);
				x = obj.scrollLeft();
				y = obj.scrollTop();

				pre_x = e.screenX;
				pre_y = e.screenY;               
				$('#mouseMove a').css("pointer-events", "auto");
				$(this).css("cursor", "pointer");

			}
		);

		$('#mouseMove').mousemove(
			function (e) {
				if (dragFlag) {
					var obj = $(this);
					obj.scrollLeft(x - e.screenX + pre_x);
					obj.scrollTop(y - e.screenY + pre_y);
					$('#mouseMove a').css("pointer-events", "none");
					return false;
				}

			}
		);

		$('#mouseMove').mouseup(
			function () {
				dragFlag = false;
				$('#mouseMove a').css("pointer-events", "auto");
				$(this).css("cursor", "default");
			}
		);

		$('body').mouseup(
			function () {
				dragFlag = false;               
				$(this).css("cursor", "default");
			}
		);
	});
</script>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"  />
<style>
	@charset "utf-8"; 

	/* reset */
	* {font-family:'Noto Sans KR',Dotum,Helvetica,AppleGothic,Sans-serif !important; word-wrap:break-word; word-break:keep-all;}
	html {overflow-y:scroll}
	body {margin:0;  padding:0; }
	body.wait *, body.wait {cursor: wait !important;}
	html, h1, h2, h3, h4, h5, h6, form, fieldset, img {margin:0;padding:0;border:0;}
	/*article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display:block}*/
	html, body, div, span, object, iframe,h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, address, cite, code,del, dfn, em, img, ins, kbd, q, samp,small, strong, sub, sup, var, b, i, dl, dt, dd,ol, ul, li,form, fieldset, legend, label, table, caption, tbody, tfoot, thead, tr, th, td,article, aside, canvas, details, figcaption, figure,footer, header, hgroup, menu, nav, section, a, summary, time, mark, audio, video, button{ margin: 0; padding:0;  padding:0; border:0; outline:0; line-height:1.5; font-size:14px; color:#000; font-family:'Noto Sans KR',Dotum,Helvetica,AppleGothic,Sans-serif; font-style:normal; font-weight:400;}
	dl, ul, ol, li { list-style:none outside none; }
	legend {position:absolute; margin:0; padding:0; font-size:0;line-height:0;text-indent:-9999em;overflow:hidden}
	label, input, button, select, img {vertical-align:middle}
	input, button {margin:0;padding:0;font-size:14px; -webkit-border-radius:0; -webkit-appearance:none;}
	button {cursor:pointer; background:none; }
	select::-ms-expand { display: none;}
	select {cursor:pointer; margin:0; -moz-appearance:none; -webkit-appearance:none; appearance:none;  border:none; box-sizing:border-box; display:inline-block; }
	option {color:#000; font-weight:400}
	select:focus, input:focus{ outline: none; text-decoration:none;}
	p {word-wrap:break-word; word-break:keep-all; line-height:1.5}
	hr {display:none}
	pre {overflow-x:scroll; white-space: pre-wrap;  white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word; }
	a { cursor: pointer; display:inline-block; }
	a:link, a:visited, a:hover, a:focus, a:active  {text-decoration:none;}
	table {width:100%; margin-bottom: 0;  table-layout: fixed;}
	table, td, th {  border-collapse: collapse; }
	th, td {vertical-align:middle; word-wrap:break-word; /*wor d-break:keep-all;*/}
	input, select, option, textarea {font-weight:300; }
	caption {font-size:0; line-height:0; position:absolute; left:-9999px; top:-9999px}
	em, span, i, b, a, strong {font-size:inherit; color:inherit; font-weight:inherit; line-height:inherit; font-style: inherit;}
	input {border:none; -webkit-border-radius: 0; -moz-appearance:none; -webkit-appearance:none; appearance:none; background-color:transparent}
	textarea:disabled, input:disabled  {background:#fcfafa}
	textarea { display:inline-block; width:100%; border:none; color:#000; box-sizing:border-box; padding:16px; resize: none; font-size:16px; font-weight:300 }
	/*placeholder color*/
	input::-webkit-input-placeholder { color:#b3b3b3 !important; font-weight:300 }
	input::-moz-placeholder { color:#b3b3b3 !important; font-weight:300 }
	input:-ms-input-placeholder { color:#b3b3b3 !important; font-weight:300 }
	input:-moz-placeholder { color:#b3b3b3 !important; font-weight:300 }
	textarea::-webkit-input-placeholder { color:#b3b3b3 !important; font-weight:300  }
	textarea::-moz-placeholder { color:#b3b3b3 !important; font-weight:300 }
	textarea:-ms-input-placeholder { color:#b3b3b3 !important; font-weight:300 }
	textarea:-moz-placeholder { color:#b3b3b3 !important; font-weight:300 }
	/*화살표 제거*/
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button {-webkit-appearance: none; margin: 0; }
	input[type="button"] {cursor:pointer}
	img {max-width:100%; }
	/*크롬 자동완성 백그라운드 제거 */
	input:-webkit-autofill, input:-webkit-autofill:hover, input:-webkit-autofill:focus, input:-webkit-autofill:active {transition: background-color 5000s ease-in-out 0s;-webkit-transition: background-color 9999s ease-out;-webkit-box-shadow: 0 0 0px 1000px transparent inset !important;-webkit-text-fill-color: #000 !important;}

	.modal_wrap {width:calc(100% - 40px); height:100%; max-height:calc(100% - 50px); max-width:540px; background:#fff; box-sizing:border-box; position:absolute; bottom:0; left:20px; -webkit-transition: -webkit-transform .4s; transition: -webkit-transform .4s; transition: transform .4s; transition: transform .4s,-webkit-transform .4s; -webkit-transform: translate(0, 0); transform: translate(0, 0);  z-index:1002; }
	.modal_head {position:fixed; top:0; left:0; width:100%; padding:20px 20px 0;  border-bottom: 1px solid #ececec; z-index: 1; background: #fff; box-sizing: border-box;}
	.modal_tt_box {display: flex; justify-content: space-between; align-items: center; margin-bottom:20px; }
	.modal_tt {font-size:14px;}
	.modal_closed img {height:20px; }
	.modal_tab_box {display: flex;align-items: center;overflow-x: auto; overflow-y:hidden; white-space: nowrap; -ms-overflow-style: none; scrollbar-width: none; }
	.modal_tab_box::-webkit-scrollbar { display: none;}
	.modal_tab_box a {display:inline-block; font-size:14px; color:#8D8D8D; margin-right:37px; padding:10px 0; line-height:1}
	.modal_tab_box a:last-child {margin-right:0}
	.modal_tab_box a.active {color:#000} 

	.modal_body { height:100%; overflow-y: auto; box-sizing:border-box; padding-top:95px; }

	.modal_tab_con {display:none; } 
	.modal_tab_con.active {display:block; }

	.size_guide_tt {font-size:18px; font-weight:bold; }
	.size_guide_p {font-size:12px; color:#8D8D8D; line-height:1.8; margin-top:10px; font-weight:300;  }
	.size_guide_p.dot {padding-left:10px; position:relative; }
	.size_guide_p.dot:before {content:"";displaY:inline-block;width: 2px;height: 2px;position:absolute;top: 10px;left:0;background:#8D8D8D;border-radius: 100%;}

	.size_guide_top_box {padding:20px; border-bottom: 1px solid #ececec;}
	.size_guide_tab {margin-top:30px;}
	.size_guide_tab a {display: flex;margin-bottom:25px;font-size:16px;color:#8D8D8D;line-height:24px;background-position:center left;background-repeat:no-repeat;align-items: center;}
	.size_guide_tab a:last-child {margin-bottom:0}
	.size_guide_tab a em {display:inline-block; line-height: 1;}
	.size_guide_tab a .icon { margin-right:10px;}
	.size_guide_tab a.active {color:#00B3E6; font-weight:500; }
	.size_guide_tab a.active > span {font-weight:400} 

	.size_guide_con  {display:none; padding-bottom:20px;  text-align:center;  }
	.size_guide_con.active {display:block; }
	.size_guide_img {display:inline-block; text-align:center; max-width:89%; }
</style>
<div>
	<div class="modal_wrap">
		<div class="modal_head">
			<!-- <div class="modal_tt_box">
				<h1 class="modal_tt">사이즈가이드</h1>
				<button type="button" class="modal_closed"><img src="/assets/mobile_templet/mobile_enterprise/img/btn/icon_closed.svg" alt="닫기"/></button>
			</div> -->
			<div class="modal_tab_box" id="mouseMove">
<?php if($TPL_title_1){$TPL_I1=-1;foreach($TPL_VAR["title"] as $TPL_V1){$TPL_I1++;?>
					<a href="#none"<?php if($TPL_I1== 0){?> class="active" <?php }?>data-tab="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["title"]?></a>
<?php }}?>
			</div>
		</div>
		<div class="modal_body">
			<div class="modal_tab_con_box">
<?php if($TPL_list_1){$TPL_I1=-1;foreach($TPL_VAR["list"] as $TPL_V1){$TPL_I1++;
$TPL_subInfo_2=empty($TPL_V1["subInfo"])||!is_array($TPL_V1["subInfo"])?0:count($TPL_V1["subInfo"]);?>
					<div class="modal_tab_con<?php if($TPL_I1== 0){?> active <?php }?>" id="<?php echo $TPL_V1["main_cid"]?>">
						<div class="size_guide_top_box">
							<h2 class="size_guide_tt"><?php echo $TPL_V1["main_title"]?></h2>
							<div class="size_guide_tab">
<?php if($TPL_subInfo_2){$TPL_I2=-1;foreach($TPL_V1["subInfo"] as $TPL_V2){$TPL_I2++;?>
									<a href="#none" class="<?php if($TPL_I2== 0){?>active<?php }?>" data-tab="<?php echo $TPL_V2["cid"]?>">
										<em class="icon"><?php if($TPL_V2["title_img"]!=''){?><img src="https://mfhaoswulcnn3822236.cdn.ntruss.com/data/barrel_data/images/size/<?php echo $TPL_V2["title_img"]?>" width="20px" height="18px"/><?php }?></em>
										<em class="txt"><?php echo $TPL_V2["title"]?></em>
									</a>
<?php }}?>
							</div>
						</div>
						<div class="size_guide_con_box">
<?php if($TPL_subInfo_2){$TPL_I2=-1;foreach($TPL_V1["subInfo"] as $TPL_V2){$TPL_I2++;?>
							<div class="size_guide_con<?php if($TPL_I2== 0){?> active<?php }?>" id="<?php echo $TPL_V2["cid"]?>"><!-- 2022-11-17 탭메뉴 이동 시 최조 내용 노출 처리-->
							<!-- <div class="size_guide_con<?php if($TPL_I1== 0&&$TPL_I2== 0){?> active<?php }?>" id="<?php echo $TPL_V2["cid"]?>"> -->
								<span class="size_guide_img">
<?php if($TPL_V2["contents_pc"]!=''){?>
										<img src="https://mfhaoswulcnn3822236.cdn.ntruss.com/data/barrel_data/images/size/<?php echo $TPL_V2["contents_pc"]?>"/>
<?php }?>
								</span>
							</div>
<?php }}?>
						</div>
					</div>
<?php }}?>
			</div>
		</div>
	</div>
</div>