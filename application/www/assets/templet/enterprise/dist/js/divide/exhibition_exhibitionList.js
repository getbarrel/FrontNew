/**
 * Created by forbiz on 2019-02-11.
 */
import 'slick-carousel';
const exhibition_exhibitionList = () => {
    const $target = $(".exhibition-list__slider");

    if( $target.children().length > 1 ) {
        $(".slider-btn").show();
    };

    $(".slider-btn__paging--all").html(`/ ${$target.children().length}`);
    $target.slick({
        prevArrow: $(".sj__exhibition-list .slider-btn__left"),
        nextArrow: $(".sj__exhibition-list .slider-btn__right"),
    });
    $target
        .on('beforeChange', function(event, slick, currentSlide, nextSlide){
            $(".slider-btn__paging--now").html(nextSlide + 1);
        });
}

export default exhibition_exhibitionList;