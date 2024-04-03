/**
 * Created by frontend on 2019-11-29.
 */
/**
 * Created by forbiz on 2019-05-21.
 */
const goods_best = () => {

    const $document = $(document);

    const bestTab = () => {
        const $categoryElement = $("#goods-best-category__wrapper");
        const categoryTop = $categoryElement.offset().top;
        const categoryHeight = $categoryElement.height();
        const navigationHeight = $("#header #navigation").outerHeight();
        const $banner = $("#header .fb__headerTop");
        const _arr = [];
        let _index = -1;
        let _result = null;


        $.each($(".fb__goods-list__contents.best-contents"), function(i, e) {
            _arr.unshift($(e).offset().top);
        });

        $(window).on("scroll.best", function(e) {
            const _winT = $(window).scrollTop();
            const bannerHeight = $banner.outerHeight();

            if(_winT + navigationHeight + bannerHeight >= categoryTop) {
                $categoryElement.css({
                    position: "fixed",
                    top: navigationHeight + bannerHeight + "px",
                    borderBottom: "1px solid #bcbcbc",
                });
            }
            else {
                $categoryElement.attr("style", "");
            }

            _index = _arr.findIndex(function(e, i) {
                return _winT + navigationHeight + bannerHeight + $categoryElement.outerHeight() + 1 >= e ;
            });
            _result = _index < 0 ? _arr.length-1 : _index;


            $(".fb__goods-best__tnb-list").removeClass("fb__goods-best__tnb-list--active");
            $("[href='#best-contents_"+(_arr.length - _result)+"']").addClass("fb__goods-best__tnb-list--active");

            // if(window.scrollY + navigationHeight + bannerHeight + $categoryElement.height() + 5 >=  _top[1]){
            //     $("[href='#best-contents_2']").css({
            //         "border" : " 1px solid red"
            //     })
            //     $("[href='#best-contents_1']").css({
            //         "border" : ""
            //     })
            // } else {
            //
            //     $("[href='#best-contents_2']").css({
            //         "border" : ""
            //     });
            //     $("[href='#best-contents_1']").css({
            //         "border" : " 1px solid red"
            //     })
            // }
        })

        $document.on("click", ".fb__goods-best__tnb-list", function() {
            const bannerHeight = $banner.outerHeight();
            const _this = $(this);
            $('html, body').stop().animate({
                scrollTop: $(_this.attr("href")).offset().top -( navigationHeight + bannerHeight +  $categoryElement.outerHeight())
            }, 1);

            return false;
        })
    };

    const main_new = () => {// 메인페이지 슬라이드 복사
        $(".newSlider .mainSlider__page__total").html($(".newSlider .newSlider__list").length);
        const new_swiper = new Swiper('.newSlider__slider', {
            loop: true,
            autoplay: {
                delay: 7000,
                disableOnInteraction: false,
            },
            // pagination: {
            //     el: '.newSlider .mainSlider__dot',
            //     clickable: true,
            // },
            navigation: {
                nextEl: '.newSlider .mainSlider__arrow--next',
                prevEl: '.newSlider .mainSlider__arrow--prev',
            },
        });

        new_swiper.on('slideChangeTransitionEnd', function () {
            $(".newSlider .mainSlider__page__now").html(new_swiper.realIndex + 1);
        });

        $document.on("click", ".newSlider .mainSlider__auto", function(e) {
            e.preventDefault();
            const $this = $(this);
            if($this.hasClass("mainSlider__auto--play")) {
                $this.removeClass("mainSlider__auto--play");
                new_swiper.autoplay.start();
            } else {
                $this.addClass("mainSlider__auto--play");
                new_swiper.autoplay.stop();
            }
            return false;
        });
        //new_swiper.autoplay.stop();
    };

    const goodsBest_init = () => {
        $(document).ready(function() {
            bestTab();
            main_new();
        })
    }

    goodsBest_init();
}


export default goods_best;