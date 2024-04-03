<?php /* Template_ 2.2.8 2023/07/18 10:20:05 /home/barrel-stage/application/www/assets/templet/enterprise/layout/layout_modal.htm 000000427 */ ?>
<?php $this->print_("contents",$TPL_SCP,1);?>


<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["PageJsSrc"])){?>
<!-- 퍼블&개발 공통:각 페이지 별 -->
<script src="<?php echo $TPL_VAR["layout"]["PageJsSrc"]?>?version=<?php echo CLIENT_VERSION?>"></script>
<?php }?>