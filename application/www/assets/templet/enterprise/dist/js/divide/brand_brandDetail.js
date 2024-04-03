/**
 * Created by forbiz on 2019-02-11.
 */

import 'slick-carousel';
const brand_brandDetail = () => {
    const $document = $(document);

    const banner_slide = () => {
        const $target = $(".detail__slider");
        const _bannerLength = $target.find(".detail__slider__item").length;

        if (_bannerLength > 1) {
            $target.find(".detail__slider-btn").addClass("detail__slider-btn--show");
            $target.find(".slider-btn__paging--all").html(_bannerLength);
            $target.find(".detail__slider__inner").slick({
                infinite: true,
                slideToShow: 1,
                slideToScroll: 1,
                prevArrow: $target.find(".slider-btn__left"),
                nextArrow: $target.find(".slider-btn__right"),
            })
            .on("afterChange", function( event, slick, currentSlide, nextSlide ) {
                $target.find(".slider-btn__paging--now").html(currentSlide + 1);
            });

        }
    }

    const bestproduct_slide = () => {
        const $target = $(".detail__best");
        if ($target.find(".today-box__list").length > 4) {
            $target.find(".detail__best-nav").addClass("detail__best-nav--show");

            $target.find(".detail__best-box").slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                prevArrow: $target.find(".bestgoods-list__nav--left"),
                nextArrow: $target.find(".bestgoods-list__nav--right"),
            });
        }
    }

    const tab_active = () => {
        const $all_nav = $(".list-contents__nav a");
        $document.on("click", ".list-contents__nav a", function(){
            const $this = $(this);
            $all_nav.removeClass("list-contents__nav--active");
            $this.addClass("list-contents__nav--active");
        });
    };

    const brandDetail_init = () => {
        banner_slide();
        bestproduct_slide();
        tab_active();
    }

    brandDetail_init();
}
export default brand_brandDetail;