/**
 * Created by forbiz on 2019-02-11.
 */
const shop_goodsList = () => {
    const $document = $(document);
    const list_slider = () => {
        const slider_page = () => {
            $(".fb__subGoods-list  .mainSlider__page__total").html($(".fb__subGoods-list  .banner__sliderList").length);
        };

        const slider_content = () => {
            var main_swiper = new Swiper('.fb__subGoods-list  .banner__slider', {
                autoplay: true,
                loop: true,
                autoplay: {
                    delay: 4000,
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
                $(".fb__subGoods-list  .mainSlider__page__now").html(main_swiper.realIndex + 1);
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
            });
        };

        const slider_init = () => {
            slider_page();
            slider_content();
        };

        slider_init();

    }

    const list_filter = () => {
        const $this = $(this);
        $document.on("click", ".filter__btn", function() {
            const $this = $(this);
            $this.toggleClass("filter__btn--active");
            $this.parents(".list-contents__header").toggleClass("list-contents__header--open");
            $(".filter__content").toggleClass("filter__content--show");
        });
    }

    const left_menu = () => {
        const $navCont = $(".goodsNav__wrap");


        //1depth 메뉴 접기
        $(document).on("click",".goodsNav__header a",function(e) {
            if($navCont.is(":visible")){
                $(".goodsNav__wrap").slideUp();
                $(this).find("span").addClass("goodsNav__btn--close");
            } else {
                $(".goodsNav__wrap").slideDown();
                $(this).find("span").removeClass("goodsNav__btn--close");
            }
            e.preventDefault();
        });

        //2depth 메뉴 접기
        $(document).on("click",".goodsNav__subHeader",function() {
            const $this = $(this);
            const $navContInner = $(".goodsNav__list").find("ul");
            if(!$this.next().is(":visible")) {
                $(".goodsNav__subHeader").find(".goodsNav__btn").removeClass("goodsNav__btn--close");
                $this.find(".goodsNav__btn").addClass("goodsNav__btn--close");
                $navContInner.slideUp();
                $this.next().slideDown();
                //$this.next().addClass("goodsNav__cont--active");
            } else {
                $(".goodsNav__subHeader").find(".goodsNav__btn").removeClass("goodsNav__btn--close");
                $navContInner.slideUp();
            }
          // const $this = $(this);
          // const $navContInner = $this.parents(".goodsNav__list").find("ul");
          // if($this.next().is(":visible")) {
          //     console.log('1234!');
          //   $this.next().removeClass("goodsNav__cont--active");
          //   $this.find(".goodsNav__btn").addClass("goodsNav__btn--close");
          //
          // } else {
          //   console.log('1234');
          //   $navContInner.slideUp();
          //   $this.next().addClass("goodsNav__cont--active");
          //   $this.find(".goodsNav__btn").removeClass("goodsNav__btn--close");
          // }
        });

        $(document).on("click",".goodsNav__subHeader--link",function(e) {
          e.stopPropagation();
        });

    }
    const list_init = () => {
        list_slider();
        list_filter();
        left_menu();
    }

    list_init();
}

export default shop_goodsList;