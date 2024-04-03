const best = () => {
    const $target = $(".fb__best__slider");
    console.log($target.children().length )
    if( $target.children().length > 1 ) {
        $(".slider-btn").show();
    };

    $(".slider-btn__paging--all").html(`/ ${$target.children().length}`);
    $target.slick({
        prevArrow: $(".fb__best__banner .slider-btn__left"),
        nextArrow: $(".fb__best__banner .slider-btn__right"),
        lazyLoad: 'ondemand',
    });
    $target
        .on('beforeChange', function(event, slick, currentSlide, nextSlide){
            $(".slider-btn__paging--now").html(nextSlide + 1);
        });

};

export default best;