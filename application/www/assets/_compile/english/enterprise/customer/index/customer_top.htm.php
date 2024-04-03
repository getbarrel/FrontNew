<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/customer/index/customer_top.htm 000001769 */ ?>
<div class="fb__customer__top fb__customer-faq__top">
    <section class="fb__customer__greetings">
        <div class="fb__customer__inner">
            <h2 class="fb__main__title--hidden">
                {=trans(고객센터')}
            </h2>
            <p >
                <b>Hello!</b>
                We would like to give you a quick response.
            </p>
        </div>
    </section>
    <section class="fb__customer__info">
        <div class="fb__customer__inner">
            <h3 class="fb__customer__info-title">Contact us</h3>
            <p>
                <b>
<?php if($TPL_VAR["langType"]=='english'){?>
                    en_help@getbarrel.com
<?php }else{?>
                    <?php echo $TPL_VAR["companyInfo"]["cs_phone"]?>

<?php }?>
                </b>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <?php echo nl2br($TPL_VAR["companyInfo"]["opening_time"])?>

<?php }?>
            </p>
        </div>
    </section>
    <!--<div class="fb__customer__form">
        <form name='searchFaqFrm' method="get" action="/customer/faq" onsubmit='return searchFaq(this)'>
            <fieldset>
                <legend>  search form</legend>
                <span class="tit"> Quick FAQ search</span>
                <input type="text" name="sText" id="devSearchFaqText" value="<?php echo $TPL_VAR["sText"]?>" placeholder="please enter search word" title="search word">
                <input type="button" value="Search" title="Search" class="btn-customer-search" id="devBtnSearchFaq" onclick="searchFaq(this)">
            </fieldset>
        </form>
    </div>-->
</div>