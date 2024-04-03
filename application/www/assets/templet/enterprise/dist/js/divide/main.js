/**
 * Created by forbiz on 2019-02-11.
 */
const main = () => {
    const $document = $(document);
    const $window = $(window);

    const main_slider = () => {

        const slider_page = () => {
            $(".mainSlider__page__total").html($(".mainSlider .mainSlider__item").length);
        };

        /*const slider_content = () => {
            var main_swiper = new Swiper('.fb__main__visual .mainSlider__slider', {
                autoplay: true,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.fb__main__visual .mainSlider__dot',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.fb__main__visual .mainSlider__arrow--next',
                    prevEl: '.fb__main__visual .mainSlider__arrow--prev',
                },
                // Disable preloading of all images
                //preloadImages: false,
                // Enable lazy loading
                //lazy: true
            });

            main_swiper.on('slideChangeTransitionEnd', function () {
                $(".fb__main__visual .mainSlider__page__now").html(main_swiper.realIndex + 1);
            });

            $document.on("click", ".fb__main__visual .mainSlider__auto", function(e) {
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
        };*/

        const slider_init = () => {
            slider_page();
            slider_content();
        };

        slider_init();

    };

    const main_best = () => {
        var best_swiper = new Swiper('.bestSlider__slider', {
            // slidesPerView: 'auto',
           slidesPerView: 4,
           pagination: {
               el: '.bestSlider__control .mainSlider__dot',
               clickable: true,
           },
           navigation: {
               nextEl: '.bestSlider__arrow .bestSlider__arrow--next',
               prevEl: '.bestSlider__arrow .bestSlider__arrow--prev',
           },
           preloadImages: false,
           lazy: true
       });
    }

    const main_event = () => {
        if($(".event__slider .swiper-slide").length >= 6) {
            var swiper = new Swiper('.event__slider', {
                loop: true,
                slidesPerView: 5,
                pagination: {
                    el: '.event__control .mainSlider__dot',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.event__control .mainSlider__arrow--next',
                    prevEl: '.event__control .mainSlider__arrow--prev',
                },
            });
        } else {
            $(".fb__main__event .event__control").hide();
            $(".fb__main__event .swiper-wrapper ").css({
                "display" : "block",
                "text-align" : "center"
            })
            $(".fb__main__event .event__slider__list ").css({
                "display" : "inline-block",
                "float" : "none",
                "width" : "19.5%"
            });
        }

        const $eventView = $('.event__detail__view');

        $('.event__slider').on('click', 'a', function(e) {
            e.preventDefault();
            $eventView.fadeOut();
            $($(this).attr('href')).stop().fadeIn();
        });

    };

    const main_user = () => {

        const user_slider = () => {
            var swiper = new Swiper('.user__slider', {
                loop: true,
                slidesPerView: 7,
                navigation: {
                    nextEl: '.user__control .mainSlider__arrow--next',
                    prevEl: '.user__control .mainSlider__arrow--prev',
                },
                preloadImages: false,
                lazy: true
            });
        };

        const user_popup = () => {
            const user_loop = () => {
                let number = 0;

                return function() {
                    return number++;
                }
            };

            const user_img = (src) => {
                return new Promise((resolve, reject) => {
                        const img = new Image();
                    img.addEventListener("load", () => resolve(img));
                    img.addEventListener("error", err => reject(err));
                    img.src = src;
                });
            };

            let user_swiper;
            const user_slider = (_index = 0) => {
                user_swiper = new Swiper('.user__popSlider', {
                    loop: true,
                    navigation: {
                        nextEl: '.user__popSlider__next',
                        prevEl: '.user__popSlider__prev',
                    },
                });

                user_swiper.slideTo(parseInt(_index) + 1, 0);
            }

            const user_main = (html, _css, _index, callback) => {
                const lookbook_templet = `
                <div id="fb__devModal" class="fb__modal fb__modal__user">
                    <div class="fb__modal__content user__popSlider__wrap" style="width: ${_css.width}; height: ${_css.height}; margin-top: -${ parseInt(_css.height) / 2}px; margin-left: -${ parseInt(_css.width) / 2}px;">
                        <div class="user__popSlider swiper-container">
                             <div class="swiper-wrapper">
                                ${html}
                             </div>
                        </div>
                        <div class="user__popSlider__controll">
                            <a href="#" class="user__popSlider__prev">
                                prev
                            </a>
                            <a href="#" class="user__popSlider__next">
                                next
                            </a>
                        </div>
                    </div>
                    <div class="fb__modal__bg"></div>
                </div>
            `;

                $(".user__slider").after(lookbook_templet);

                return callback(_index);
            };

            const user_delet = () => {
                if(user_swiper) user_swiper.destroy();
                $(".fb__modal__user ").remove();
            }

            $document
                .on("click", ".user__list a ", function() {
                    const $this = $(this);
                    const _srcArr = JSON.parse($this.parents(".swiper-container").attr("data-src"));
                    const user_fn = user_loop();
                    let list = "";
                    user_delet();
                    $.each(_srcArr, function(i ,e) {
                        user_img(e.src)
                            .then(img =>{
                            list += `
                            <div class="user__popSlider__list swiper-slide">
                                <div class="user__popSlider__inner">
                                     <figure class="user__popSlider__img">
                                        <img src="${img.src}" alt="" >
                                     </figure>
                                     <h3 class="user__popSlider__id">
                                        ${e.id}
                                     </h3>
                                      <p class="user__popSlider__summary">
                                        ${e.summary}
                                     </p>
                                     <ul class="user__popSlider__name">
                                        <li>${e.name.join("</li><li>")}</li>
                                     </ul>
                                </div>
                            </div>
                        `;


                        if(user_fn() + 1 == _srcArr.length) {
                            user_main(list, {"width" : "900px", "height" : "580px"}, $this.parent().attr("data-swiper-slide-index"), user_slider);
                        }
                    })
                        .catch(err => console.error(err));
                    });


                    return false;
                })
                .on('click', '.fb__modal__bg', function() {
                    user_delet();
                    return false;
                });


        }

        const user_init = () => {
            user_slider();
            user_popup();
        };

        user_init();
    };

    const main_bg = () => {

        $.each($("div[class^=bgSlider__select]"), function(e) {
            let $select = `.${$($("div[class^=bgSlider__select]")[e]).attr("class").split(" ")[0]}`;
            if($($select).find('.bgSlider__list').length > 1) {
              //  console.log($($select).find('.bgSlider__list').length)
                $(`${$select}`).find(".mainSlider__page__total").html($($select).find('.bgSlider__list').length);

                var bg_swiper = new Swiper(`${$select} .bgSlider__slider`, {
                    loop: true,
                    speed: 800,
                    autoplay: {
                        delay: 6000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: `${$select} .mainSlider__dot`,
                        clickable: true,
                    },
                    navigation: {
                        nextEl: `${$select} .mainSlider__arrow--next`,
                        prevEl: `${$select} .mainSlider__arrow--prev`,
                    },
                    on: {
                        slideChangeTransitionEnd : function(){
                            $(`${$select} .mainSlider__page__now`).html(this.realIndex + 1);
                        },
                    },
                    // preloadImages: false,
                    // lazy: true

                });
            } else {
                $(`${$select} .mainSlider__page`).hide();
            }

            $document.on("click", `${$select} .mainSlider__auto`, function(e) {
                e.preventDefault();
                const $this = $(this);
                if($this.hasClass("mainSlider__auto--play")) {
                    $this.removeClass("mainSlider__auto--play");
                    bg_swiper.autoplay.start();
                } else {
                    $this.addClass("mainSlider__auto--play");
                    bg_swiper.autoplay.stop();

                }
                return false;
            });
        });


    }

    const main_new = () => {

        $(".newSlider .mainSlider__page__total").html($(".newSlider .newSlider__list").length);

        const new_swiper = new Swiper('.newSlider__slider', {
            loop: true,
            autoplay: {
                delay: 7000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.newSlider .mainSlider__dot',
                clickable: true,
            },
            navigation: {
                nextEl: '.newSlider .mainSlider__arrow--next',
                prevEl: '.newSlider .mainSlider__arrow--prev',
            },
            on: {
                slideChangeTransitionEnd : function(){
                    $(".newSlider .mainSlider__page__now").html(this.realIndex + 1);
                },
            },
            // preloadImages: false,
            // lazy: true

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
    };

    const main_goods = () => {
        const goods_page = () => {
            let _number = 0;

            return () => {

                return _number++;
            }
        }
        const _page = goods_page();

        $.each($(".fb__main__goods .devDisplayGroup"), function(i, e) {
            $document.on("click", `.fb__goods__btn--${i}`, function() {
                const $this = $(this);
                const _group = $this.attr("data-group");
                let _page = parseInt($this.attr("data-page"));

                // console.log(mainGoodsPage);
                // console.log(_page++);
                mainGoodsPage[_group].getPage(_page);

                $this.attr("data-page", Number(_page));
            });
        });
    }

    const main_floatMenu = () => {
        const $target = $(".fb__floating");
        const $line = $(".pubFloaingLine");

        //플로팅 위치 하단
        const _btm_height = $window.height() - 270;
        //플로팅 위치 중간
        const _half_height = ($window.height()/2) - ($target.height()/2);
        $window.on("scroll.posFloating", function () {
            const _start_offset = $line.length > 0 ? $line.offset().top : $(window).height() + 100;
            if ($window.scrollTop() > _start_offset - _btm_height ) {

                $target.addClass("fb__floating--fixed").css({
                    "top" : '',
                });
            } else {
                $target.removeClass("fb__floating--fixed").css({
                    "top" : _start_offset,
                });
            }
        });
        $window.trigger('scroll.posFloating');

    }


    const main_init = () => {
        main_slider();
        main_best();
        main_event();
        main_user();
        main_bg();
        main_new();
        main_goods();
        main_floatMenu();
    };

    main_init();
}

export default main;