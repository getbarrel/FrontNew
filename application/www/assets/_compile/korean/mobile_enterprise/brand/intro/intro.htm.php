<?php /* Template_ 2.2.8 2020/08/31 15:56:55 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/brand/intro/intro.htm 000000933 */ ?>
<section class="br__brand">
    <h2 class="br__brand__title">배럴 이슈</h2>
<?php if($TPL_VAR["param"]=='press'||$TPL_VAR["param"]=='cheeringyoursweat'||$TPL_VAR["param"]=='campaign'){?>
    <div class="br__brand__nav">
        <a class="br__brand__nav-list <?php if($TPL_VAR["param"]==''){?>br__brand__nav-list--active<?php }?>" href="#">전체</a>
        <a class="br__brand__nav-list <?php if($TPL_VAR["param"]=='press'){?>br__brand__nav-list--active<?php }?>" href="/brand/intro/press">뉴스</a>
        <a class="br__brand__nav-list <?php if($TPL_VAR["param"]=='event'){?>br__brand__nav-list--active<?php }?>" href="#">이벤트</a>
    </div>
<?php }?>
    <iframe src="<?php echo $TPL_VAR["src"]?>" frameborder="0" width="100%" height="1000"></iframe>
</section>