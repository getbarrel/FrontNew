<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/brand/cosmetics_story/cosmetics_story.htm 000001124 */ ?>
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
<?php if($TPL_VAR["langType"]=='korean'){?>
    <img src="//image2.getbarrel.com/landing/brand_story_kr/brandstory_cosmetics_pc.jpg" alt="코스메틱스 스토리">
<?php }else{?>
    <img src="//image2.getbarrel.com/landing/brand_story_en/brandstory_cosmetics_pc_en.jpg" alt="스포츠웨어">
<?php }?>
</section>