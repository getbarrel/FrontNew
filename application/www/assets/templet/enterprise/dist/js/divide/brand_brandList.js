/**
 * Created by forbiz on 2019-02-11.
 */


const brand_brandList = () => {
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
    };

    const brandList_init = () => {
        banner_slide();
    }

    brandList_init();
}

export default brand_brandList;