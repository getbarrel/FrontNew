<?php /* Template_ 2.2.8 2021/09/09 10:24:38 /home/barrel-stage/application/www/assets/templet/enterprise/brand/brand_story/brand_story.htm 000001241 */ ?>
<section class="br__brand-story">
    <div class="br__brand-story__header">
        <h2 class="br__brand-story__title">BRAND STORY</h2>
        <nav class="story__menu">
            <ul>
                <li class="story__menu__link <?php if($TPL_VAR["layoutCommon"]["bodyId"]=='brand_brandStory'){?>story__menu__link--active<?php }?>"><a href="/brand/brandStory">Barrel Sportswear</a></li>
                <li class="story__menu__link <?php if($TPL_VAR["layoutCommon"]["bodyId"]=='brand_cosmeticsStory'){?>story__menu__link--active<?php }?>"><a href="/brand/cosmeticsStory">Barrel Cosmetics</a></li>
            </ul>
        </nav>
    </div>
    <div class="br__brand-story__content">
<?php if($TPL_VAR["langType"]=='korean'){?>
        <img src="//image2.getbarrel.com/landing/brand_story_kr/brandstory_pc_kr_20210908.jpg" alt="스포츠웨어">
<?php }else{?>
        <img src="//image2.getbarrel.com/landing/brand_story_en/brandstory_pc_en_20210908.jpg" alt="스포츠웨어">
<?php }?>
        <a href="/brand/technology">(english)자세히 보러가기</a>
    </div>
</section>