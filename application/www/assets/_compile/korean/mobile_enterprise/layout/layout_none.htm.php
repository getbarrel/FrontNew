<?php /* Template_ 2.2.8 2023/07/18 10:19:57 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/layout/layout_none.htm 000000500 */ ?>
<!-- 메인 컨텐츠 [S] -->
<?php $this->print_("contents",$TPL_SCP,1);?>

<!-- 메인 컨텐츠 [E] -->

<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["PageJsSrc"])){?>
<!-- 퍼블&개발 공통:각 페이지 별 -->
<script src="<?php echo $TPL_VAR["layout"]["PageJsSrc"]?>?version=<?php echo CLIENT_VERSION?>"></script>
<?php }?>