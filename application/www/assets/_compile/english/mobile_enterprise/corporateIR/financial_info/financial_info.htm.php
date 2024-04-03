<?php /* Template_ 2.2.8 2021/04/16 16:38:32 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/corporateIR/financial_info/financial_info.htm 000002548 */ ?>
<section class="br__ir">
      <header class="br__ir__top">
            <div class="br__title-box">
                  <button type="button" class="br__title-box__back">Back</button>
                  <h2 class="br__title-box__title">Corporate IR</h2>
            </div>
            <nav class="br__ir__nav">
                  <ul>
                        <li class="br__ir__nav--active"><a href="/corporateIR/financialInfo/">Financial information</a></li>
                        <li class="eng-hidden"><a href="/corporateIR/disclosureNoti/">Announcement</a></li>
                        <li><a href="/corporateIR/IRResources/">IR Data</a></li>
                        <li><a href="/corporateIR/pressReleases/">Press release</a></li>
                  </ul>
            </nav>
      </header>
      <section class="br__ir__content">
            <h3 class="br__hidden">Financial information</h3>
            <div class="br__ir__tab">
                  <button class="br__ir__tab--active tab--first">F/P</button>
                  <button class="tab--second">C/I</button>
            </div>

            <!--재무상태표 탭-->
            <div class="br__ir__detail br__ir__detail--first br__ir__detail--show">
            <!-- <?php echo $TPL_VAR["docInfo"]['0']['bbs_contents']?> -->
                  <figure>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <img src="//image.getbarrel.com/barrel_data/images/ir/m/img-finance-m.png" alt="financialData">
<?php }elseif($TPL_VAR["langType"]=='english'){?>
                        <img src="//image.getbarrel.com/barrel_data/images/ir/m/img-finance-m-en.png" alt="financialData">
<?php }?>
                  </figure>
            </div>

            <!--손익계산서 탭-->
            <div class="br__ir__detail br__ir__detail--second" style="display: none">
            <!-- <?php echo $TPL_VAR["docInfo"]['1']['bbs_contents']?> -->
                  <figure>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <img src="//image.getbarrel.com/barrel_data/images/ir/m/img-calculation-m.png" alt="financialData">
<?php }elseif($TPL_VAR["langType"]=='english'){?>
                        <img src="//image.getbarrel.com/barrel_data/images/ir/m/img-calculation-m-en.png" alt="financialData">
<?php }?>
                  </figure>
            </div>
      </section>
</section>