/**
 * Created by forbiz on 2019-02-11.
 */

const shop_goodsList = () => {
    const $document = $(document);
    const list_slider = () => {
        const slider_page = () => {
            $(".banner__sliderWrap .mainSlider__page__total").html($(".banner__slider .banner__sliderList").length);
        };

        const slider_content = () => {
            var main_swiper = new Swiper('.banner__sliderWrap .banner__slider', {
                autoplay: true,
                clickable: true,
                loop: true,
                autoplay: {
                    delay: 7000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.banner__sliderWrap .mainSlider__dot',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.banner__sliderWrap .mainSlider__arrow--next',
                    prevEl: '.banner__sliderWrap .mainSlider__arrow--prev',
                }
            });

            main_swiper.on('slideChangeTransitionEnd', function () {
                $(".banner__sliderWrap .mainSlider__page__now").html(main_swiper.realIndex + 1);
            });

            $document.on("click", ".banner__sliderWrap .mainSlider__auto", function(e) {
                e.preventDefault();
                const $this = $(this);
                if($this.hasClass("mainSlider__auto--play")) {
                    $this.removeClass("mainSlider__auto--play");
                    main_swiper.autoplay.start();
                } else {
                    $this.addClass("mainSlider__auto--play");
                    main_swiper.autoplay.stop();

                }

                return false;
            });
        };

        const slider_init = () => {
            slider_page();
            slider_content();
        };

        slider_init();
    };

    const list_filter = () => {
        $document.on("click", ".filter__btn", function() {
            const $this = $(this);
            $this.toggleClass("filter__btn--active");
            $this.parents(".list-contents__header").toggleClass("list-contents__header--open");
            $(".filter__content").toggleClass("filter__content--show");
        });
    };

    const pageBtn = () => {
        $document.on("click", ".wrap-pagination a", function() {
            const $targetScroll = $(".fb__goods-list__contents").offset();
            $("html").animate({scrollTop:$targetScroll.top});
        });
    }

    const list_init = () => {
        list_slider();
        list_filter();
        pageBtn();
    }

    list_init();
}

export default shop_goodsList;