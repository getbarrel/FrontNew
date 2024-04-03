/**
 * Created by forbiz on 2019-02-11.
 */
import 'slick-carousel';
const shop_b2bMall = () => {
    const b2bMall_slider = () => {
        const $target = $(".b2b-banner__slider");

        if( $target.children().length > 1 ) {
            $(".sj__b2b__main-slider .slider-btn").show();
        };

        $(".slider-btn__paging--all").html(`/ ${$target.children().length}`);
        $target.slick({
            prevArrow: $(".sj__b2b__main-slider .slider-btn__left"),
            nextArrow: $(".sj__b2b__main-slider .slider-btn__right"),
        });
        $target
            .on('beforeChange', function(event, slick, currentSlide, nextSlide){
                $(".slider-btn__paging--now").html(nextSlide + 1);
        });

    }

    const b2bMall_bestgoods = () => {
        const $target = $('.bestgoods-slider');
        console.log($target.children().length)
        if( $target.children().length > 4 ) {
            $(".bestgoods-list__nav").show();
        };

        $target.slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            prevArrow: $(".bestgoods-list__nav--left"),
            nextArrow: $(".bestgoods-list__nav--right"),
            lazyLoad: 'ondemand'
        });
    }

    const b2bMall_init = () => {
        b2bMall_slider();
        b2bMall_bestgoods();
    }

    b2bMall_init();
}

export default shop_b2bMall;