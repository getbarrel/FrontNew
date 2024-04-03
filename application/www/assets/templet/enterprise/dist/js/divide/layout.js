/**
 * Created by forbiz on 2019-02-11.
 */


const layout = () => {
    const $document = $(document);
    const $window = $(window);
    const $body = $("body, html");

    const header_topbanner = () => {
        const $banner = $(".header__top-banner");
        //if($banner.length < 1) return;

        // const itemName = 'mobileTopBanner';
        // const _hideDate = localStorage.getItem(itemName) ? localStorage.getItem(itemName) : null;
        //
        // //banner check
        // const checkTopBanner = state => {
        //     const _day = 24 * 60 * 60 * 1000;   // h * m * s * ms
        //     if(_hideDate) {
        //         // has Date
        //         const _currentDate = new Date().getTime();
        //         if(_currentDate - _day > _hideDate) {
        //             localStorage.removeItem(itemName);
        //             $banner.removeClass("header__top-banner--hidden");
        //             $('body').addClass('has-banner');
        //         }else {
        //             $banner.addClass("header__top-banner--hidden");
        //             $('body').removeClass('has-banner');
        //         }
        //     }else if(state){
        //         // set Date
        //         localStorage.setItem(itemName, new Date().getTime());
        //         $banner.addClass("header__top-banner--hidden")
        //         $('body').removeClass('has-banner');
        //     }else {
        //         $banner.removeClass("header__top-banner--hidden")
        //         $('body').addClass('has-banner');
        //     }
        // }
        // checkTopBanner();
        //
        function setCookie(name, value, expiredays) {

            var today = new Date();
            today.setDate(today.getDate() + expiredays);

            document.cookie = name + '=' + escape(value) + '; path=/; expires=' + today.toGMTString() + ';'

        };

        function getCookie(name)

        {

            var cName = name + "=";

            var x = 0;

            while ( i <= document.cookie.length )

            {

                var y = (x+cName.length);

                if ( document.cookie.substring( x, y ) == cName )

                {

                    if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )

                        endOfCookie = document.cookie.length;

                    return unescape( document.cookie.substring( y, endOfCookie ) );

                }

                x = document.cookie.indexOf( " ", x ) + 1;

                if ( x == 0 )

                    break;

            }

            return "";

        }

        // var deleteCookie = function(name) {
        //     document.cookie = name + '=; expires=Thu, 01 Jan 1999 00:00:10 GMT;';
        // }
        //
        // window.deleteCookie = deleteCookie;
        const $header = $(".fb__header");
        if(document.cookie.indexOf("notToday=Y") >= 0) {
            $banner.hide();

        } else {
            $banner.show();
        }

        $("body").css({
            "padding-top" : $header.height()
        });

        $window
            .on("resize", function() {
                let _height = $header.height() ? $header.height() : $header.find('.fb__headerTop').height() + $("#navigation").height();
                $("body").css({
                    "padding-top" : _height
                });
            })
            .on("scroll", function() {
                const $headerTop_banner = !!$(".header__top-banner").height() ? $(".header__top-banner").height() : 0;
                const _win_t = $window.scrollTop();
                const $target = $("#navigation");
                if(_win_t >= $headerTop_banner) {
                    $target.addClass("fb__main_nav--fixed");
                } else {
                    $target.removeClass("fb__main_nav--fixed");
                }
            })



        $banner.find('.header__top-banner__close').on('click', function() {
            //checkTopBanner(true);
            if($("[name^='today__close']").prop('checked'))  setCookie('notToday','Y', 1);
            $banner.hide();
            $("body").css({
                "padding-top" : $header.height()
            })
        });

        const banner_slide = () => {
            if ($(".banner-slide").length > 0) {
                const banner_swiper = new Swiper(".banner-slide", {
                    loop: true,
                    autoplay: {
                        delay: 7000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.banner-slide .swiper-pagination',
                        clickable: true,
                    },
                });
            }
        };

        const banner_init = () => {
            banner_slide();
        };
        banner_init();
    };

    const header_fav = () => {
        $document.on("click", ".fb__header__etc-fav", function() {
            var bookmarkURL = window.location.href;
            var bookmarkTitle = document.title;
            var triggerDefault = false;
            if (window.sidebar && window.sidebar.addPanel) {
                // Firefox version < 23
                window.sidebar.addPanel(bookmarkTitle, bookmarkURL, '');
            } else if ((window.sidebar && (navigator.userAgent.toLowerCase().indexOf('firefox') > -1)) || (window.opera && window.print)) {
                // Firefox version >= 23 and Opera Hotlist
                var $this = $(this); $this.attr('href', bookmarkURL);
                $this.attr('title', bookmarkTitle);
                $this.attr('rel', 'sidebar');
                $this.off(e);
                triggerDefault = true;
            } else if (window.external && ('AddFavorite' in window.external)) {
                // IE Favorite
                window.external.AddFavorite(bookmarkURL, bookmarkTitle);
            } else {
                // WebKit - Safari/Chrome
                alert((navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') + '+D 키를 눌러 즐겨찾기에 등록하실 수 있습니다.');
            }
            return triggerDefault;
        });
    };

    const search = () => {

        const searchlayer = (type) => {
            if(type == "focusin") {
                $(".wrap-search-layer").show();
            } else {
                $(".wrap-search-layer").hide();
                $('.header__search--show').removeClass('header__search--show');
            }
        }

        $document
            .on("focusin ", ".search-area__text", function(e){
                if(e.type == "focusin") {
                    searchlayer(e.type);
                } else {
                    searchlayer(e.type);
                }
            })
            .on("focusin ", ".nav__all-btn", function(e){
                searchlayer("blur");
            })
            .on("click", function(e) {
               if(!($(e.target).hasClass("wrap-search-layer") || $(e.target).parents(".wrap-search-layer").hasClass("wrap-search-layer") || $(e.target).hasClass("search-area__text") || $(e.target).hasClass("header__search__opener"))) {
                   searchlayer("blur");
               }
             })
            .on("keyup", ".search-area__text", function(){
                const $this = $(this);
                const $close_btn = $('.search_close_btn')
                const $del_btn = $(".search-area__del");
                if($this.val().length > 0){
                    $close_btn.addClass('search-area__close-btn')
                    $del_btn.addClass("search-area__del--show");
                } else {
                    $close_btn.removeClass('search-area__close-btn');
                    $del_btn.removeClass("search-area__del--show");
                }
            })
            .on("click", ".search-area__del", function(){
                const $this = $(this);
                const $target = $this.closest(".search-area__inner");
                $target.find("input[type='text']").val("");
                $this.removeClass("search-area__del--show");
                return false;
            });

        $('.header__search__opener').on('click', function() {
            const $wrap = $('.header__search');
            if($wrap.hasClass("header__search--show")) {
                $wrap.removeClass("header__search--show");
            }else {
                $wrap.addClass("header__search--show");
                $wrap.find(".search-area__text").trigger("focus");
            }

        });
    };

    const all_menu = () => {
        const menu_close = () => {
            const $allLayer = $(".all-layer");
            const $entire_menu = $allLayer.find(".all-layer__list");

            $allLayer.toggleClass("all-layer--show");

            const sub_menu = () => {
                $(".all-layer__list--active .all-layer__box .all-layer__sub-list:eq(0)")
                    .addClass("all-layer__sub-list--active")
                    .find(".all-layer__menu ").addClass('all-layer__menu--show');
            };


            $document.on("mouseleave", ".all-layer", function(){
                $allLayer.removeClass("all-layer--show");
                $(".all-layer__sub-list").removeClass("all_divide")
            });

            $document
                .on("mouseover", ".all-layer__list" ,function(){
                   const $this = $(this);
                   $this
                       .addClass("all-layer__list--active")
                       .siblings().removeClass("all-layer__list--active");

                   $this
                       .find(".all-layer__sub").addClass("all-layer__sub--show")
                       .siblings().find(".all-layer__sub").removeClass("all-layer__sub--show");



                   if(!$this.find(".all-layer__sub-list:eq(0)").hasClass("all_divide")) {
                       sub_menu();
                   }

                })
                // 2depth 서브메뉴호버시
                .on("mouseover", ".all-layer__sub-list", function(){
                    const $this = $(this);

                    $this.parent().find(".all-layer__sub-list:eq(0)").addClass("all_divide")
                    $this
                        .addClass("all-layer__sub-list--active ")
                        .siblings().removeClass("all-layer__sub-list--active");
                    $this.find(".all-layer__menu").addClass("all-layer__menu--show");
                    $this.siblings().find(".all-layer__menu").removeClass("all-layer__menu--show");
                })

                // 3depth 서브메뉴호버시
                .on("mouseover", ".all-layer__menu-list", function(){
                    const $this = $(this);
                    const $target = $this.children();
                    const $nontarget = $this.siblings().children();
                    $target
                        .addClass("all-layer__menucategory--active ")
                    $nontarget
                        .removeClass("all-layer__menucategory--active");
                });

            const all_menu_init = () => {
                sub_menu();
            };

            all_menu_init();
        }

        $document
            .on("click", ".nav__all-btn, .all-layer .all-layer__close", function() {
                menu_close();
                return false;
        });





    };

    const lazyload = () =>{
        /*
         * {layoutCommon.templetSrc}/images/common/loading.gif 로딩 이미지 샘플
         * attribute : data-src
         * */
        const $target = $('img[data-src]');
        $target.Lazy({
            threshold: 50
        });

    };

    const up_btn = () => {
        $window.on("scroll", function() {
            const scrollGap = 0;
            const winScroll = $window.scrollTop();
            const win_b = winScroll + $window.height() - 100;
                if($("#footer").length) {
                if(winScroll > scrollGap) {
                    // top btn visible
                    $(".fb__footer__top").addClass("fb__footer__top--show");
                    if(win_b > $("#footer").offset().top) {
                        $(".fb__footer__top").addClass("fb__footer__top--hold");
                    } else {
                        $(".fb__footer__top").removeClass("fb__footer__top--hold");
                    }
                } else {
                    // top btn hidden
                    $(".fb__footer__top").removeClass("fb__footer__top--show");
                }
            }
        });

        $document.on("click", ".fb__footer__top", function() {
            $body.stop().animate({scrollTop:0}, 300, 'swing');
            return false;
        });
    };

    const floating_menu = () => {
        if ($(".fb__floating").length > 0) {
            $document
                .on("click", ".fb__floating__btn--recent", function(e){
                    $(".fb__floating__layer").addClass("fb__floating__layer--show");
                    $(".fb__floating").addClass("fb__floating--active");
                    $(this).addClass("fb__floating__btn--recent--active");
                    e.preventDefault();
                })
                .on("click", ".fb__floating__layer-close", function(){
                    $(".fb__floating__layer").removeClass("fb__floating__layer--show");
                    $(".fb__floating").removeClass("fb__floating--active");
                    $(".fb__floating__btn--recent").removeClass("fb__floating__btn--recent--active");
                })
                .on("click",".fb__floating__btn--recent--active",function(e) {
                    $(".fb__floating__layer").removeClass("fb__floating__layer--show");
                    $(".fb__floating").removeClass("fb__floating--active");
                    $(this).removeClass("fb__floating__btn--recent--active");
                    e.preventDefault();
                })
                .on("click", ".fb__floating__btn--top", function(){
                    const cmsIframe = $('#cms__iframe');

                    $window.scrollTop(0);

                    // cms에서 가져오는 iframe에 데이터 전송
                    if(cmsIframe.length > 0) {
                        document.getElementById('cms__iframe').contentWindow.postMessage({
                            cmd: 'scrollTop',
                        }, '*');
                    }
                })
        }
    }

    const headerSns = () => {
        $('.header__sns')
            .on('mouseover', function(e) {
                e.stopPropagation();
                $(this).find('> ,header__sns__list').addClass('header__sns__list--show');
        });
        $('.header__sns__link--instagram').on({
           'mouseenter' : function() {
               $(this).find('.header__sns__list--insta').addClass('header__sns__list--show');
           },
            'mouseleave' : function() {
                $(this).find('.header__sns__list--insta').removeClass('header__sns__list--show');
            }
        });
        $body.on('mouseover', function() {
            $('.header__sns__list').removeClass('header__sns__list--show');
        });
    }
    const checkHiddenArea = () => {
        if(window.top != window.self) {
            $('#header, #footer, .fb__floating').hide();
            $('body').css('padding-top','50px');
            /*window.top.postMessage({
                cmd: "contentHeight",
                contentHeight : $('#container').outerHeight() + parseInt($('body').css('padding-top')) + 1
            }, '*');*/
        }
        window.addEventListener("message", function(event) {
            const type = event.data.cmd;
            if(type != '' && type == 'scrollTop') {
                $(window).scrollTop(0);
            }
            /*if(type == 'contentHeight') {
                var cmsIframe = $('#cms__iframe');
                if(cmsIframe.length < 1) return ;
                cmsIframe.height(event.data.contentHeight);
                console.log(cmsIframe, event.data.contentHeight);

            }*/
        });
        $('.fb__floating__btn--top').on('click', function() {
            if($(window).find('iframe').length < 1) return ;
            $(window).find('iframe').get(0).constentWindow.window.postMessage({
                cmd: "scrollTop"
            }, '*');
        });
    }

    const layout_init = () => {
        header_fav();
        header_topbanner();
        search();
        all_menu();
        lazyload();
        window.lazyload = lazyload;
        up_btn();
        floating_menu();
        checkHiddenArea();
        //headerSns();
    };

    layout_init();
}

export default layout;