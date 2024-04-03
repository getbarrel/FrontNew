<?php /* Template_ 2.2.8 2020/08/31 15:56:55 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/basic/faq_list.htm 000002651 */ 
$TPL_bbs_divs_1=empty($TPL_VAR["bbs_divs"])||!is_array($TPL_VAR["bbs_divs"])?0:count($TPL_VAR["bbs_divs"]);?>
<section class="br__faq">
    <h2 class="br__cs__title">
        FAQ
    </h2>
    <div class="wrap-faq">
        <form id="devFaqForm">
            <div class="input-search">
                <input type="hidden" name="page"     value="1"        id="devPage"/>
                <input type="hidden" name="max"      value="20"       id="devMax"/>
                <input type="hidden" name="bType"    value="<?php echo $TPL_VAR["bType"]?>"      id="bType"/>
                <input type="hidden" name="curPage"  value=""         id="curPage"/>
                <input type="hidden" name="lastPage" value=""         id="lastPage"/>
                <input type="hidden" name="divIx"    value="<?php echo $TPL_VAR["divIx"]?>" id="divIx"/>
                <input type="hidden" name="bbsIx"    value="<?php echo $TPL_VAR["bbsIx"]?>" id="bbsIx"/>
            </div>

            <select class="br__faq__select" name="" id="devDivs">
                <option value="">All</option>
<?php if($TPL_bbs_divs_1){foreach($TPL_VAR["bbs_divs"] as $TPL_V1){?>
                <option value="<?php echo $TPL_V1["div_ix"]?>"><?php echo $TPL_V1["div_name"]?></option>
<?php }}?>
            </select>

            <div class="br__faq__content" id="devFaqContent">
                <dl class="br__faq__list devForbizTpl" id="devFaqList">
                    <dt class="br__faq__question devFaqQuestion">
                        <span class="br__faq__name">
                             <span class="br__faq__icon--ques">질문아이콘</span>
                            {[div_name]}
                        </span>
                        <p class="br__faq__title">{[{bbs_q}]}</p>
                        <span class="br__faq__icon--arrow">화살표아이콘</span>
                    </dt>
                    <dd class="br__faq__answer devFaqAnswer">
                        <span class="br__faq__icon--answer">답변아이콘</span>
                        <p class="br__faq__answer-text">{[{bbs_a}]}</p>
                    </dd>
                </dl>
            </div>

            <div class="empty-content"  id="devFaqEmpty">
                <p id="emptyMsg"><strong></strong></p>
            </div>

            <div class="empty-content" id="devFaqLoading">
                <p>Loading...</p>
            </div>

            <div id="devPageWrap"></div>

        </form>
    </div>
</section>