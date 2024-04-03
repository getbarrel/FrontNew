<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/basic/faq_list.htm 000002752 */ 
$TPL_bbs_divs_1=empty($TPL_VAR["bbs_divs"])||!is_array($TPL_VAR["bbs_divs"])?0:count($TPL_VAR["bbs_divs"]);?>
<div class="wrap-board fb__bbs br__customer-notice br__customer-faq">

<?php $this->print_("customerTop",$TPL_SCP,1);?>


    <form id="devFaqForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="10" id="devMax"/>
        <input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>" id="bType"/>
        <input type="hidden" name="sText" value="<?php echo $TPL_VAR["sText"]?>" id="sText"/>
        <input type="hidden" name="divIx" value="<?php echo $TPL_VAR["divIx"]?>" id="divIx"/>
        <input type="hidden" name="bbsIx" value="<?php echo $TPL_VAR["bbsIx"]?>" id="bbsIx"/>
        <header class="fb__bbs__header">
            <h1 class="fb__bbs__header__title br__customer-notice__title">FAQ</h1>
            <span class="count fb__bbs__header__count faq__header__count">
                <em id="keyword"></em><em id="devTotal" class="number__font"></em>
            </span>
        </header>
        <div class="fb__goods-list__menu fb__flt-top">
            <ul class="list-menu">
                <li class="list-menu__list">
                    <a href="javascript:void(0)" class=" list-menu__list--active devSubCategoryTab" devDivIx="" data-divix="">
                        All
                    </a>
                </li>
<?php if($TPL_bbs_divs_1){foreach($TPL_VAR["bbs_divs"] as $TPL_V1){?>
                <li class="list-menu__list">
                    <a href="javascript:void(0)" class=" devSubCategoryTab" devDivIx="<?php echo $TPL_V1["div_ix"]?>" data-divix="<?php echo $TPL_V1["div_ix"]?>">
                        <?php echo $TPL_V1["div_name"]?>

                    </a>
                </li>
<?php }}?>
            </ul>
        </div>

    </form>

    <div id="devFaqContent" class="fb__bbs__faq wrap-faq-list">
        <dl id="devFaqList" class="devForbizTpl fb__bbs__faq-box">
            <dt class="devFaqQuestion fb__bbs__faq-q">
                <span>{[div_name]}</span><p>{[bbs_q]}</p>
            </dt>
            <dd class="devFaqAnswer fb__bbs__faq-a">
                <div class="answer">{[{bbs_a}]}</div>
            </dd>
        </dl>

        <div id="devFaqLoading" class="empty-content">
            <div class="wrap-loading">
                <div class="loading"></div>
            </div>
        </div>

        <div id="devFaqEmpty" class="empty-content">
            <p id="emptyMsg"><em></em></p>
        </div>
    </div>

    <div id="devPageWrap"></div>
</div>