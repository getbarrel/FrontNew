/**
 * Created by forbiz on 2019-07-04.
 */

const front_main = () => {
    const $body = $('body');
    const $window = $(window);
    const $document = $(document);

    const mainSlierMoving = () => {
        const $header = $('.br__header');
        const $wrap = $('.br__main__top-slide');
        const $img = $wrap.find('.slide-content__thumb img');
        const checkState = _scrollTop => {
            if($header.height() > _scrollTop){
                $img.css({
                    'transform' : '',
                    'opacity' : ''
                });
                return false;
            }else if($img.height() + $header.height() < _scrollTop) {
                return false;
            }

            const opacityGap = $img.height()/10;

            $img.css({
                'transform' : `translateY(${(_scrollTop - $header.height())/5}px)`,
                'opacity' : opacityGap < _scrollTop ? 1 - ((_scrollTop / $img.height() * 100) / 100) : 1
            });

        }

        const scollEvent = () => {
            $window.on('scroll.mainSlideScroll', function() {
                const currentScrollTop = $window.scrollTop();

                checkState(currentScrollTop);
            });
        }

        const mainSlierMoving_init = () => {
            scollEvent();
        }
        mainSlierMoving_init ();
    }

    const main_lookbook = () => {
        let swiper;
        const lookbook_slider = () => {
            swiper = new Swiper('.lookbook__slider', {
                loop: true,
                pagination : {
                    el: '.swiper-pagination',
                    type : 'fraction',
                    renderFraction : function (currentClass, totalClass) {
                        return `[ <span class="${currentClass}"></span> / <span class="${totalClass}"></span> ]`;
                    }
                },
                navigation : {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                }
            });
        }

        const lookbook_main = (html, _css, _title, callback) => {
            const lookbook_templet = `
                <div class="br__lookbook__wrap ">
                    <div class="lookbook__title">${_title}</div>
                    <div class="lookbook ${window.orientation !=0 ? "lookbook--landscape" : ""}" style="width: ${_css.width}; top: ${_css.top}; left: ${_css.left}; right: ${_css.right}; bottom: ${_css.bottom}; margin: ${_css.margin}; transform: ${_css.transform}; z-index: ${_css["z-index"]};">
                        <div class="lookbook__slider swiper-container">
                             <div class="swiper-wrapper">
                                ${html}
                             </div>
                        </div>
                        <div class="swiper-pagination"></div>
                         <div class="swiper-button-prev"></div>
                         <div class="swiper-button-next"></div>
                    </div>
                    <div class="lookbook__bg"></div>
                    <span class="lookbook__landscape">가로모드지원 아이콘</span>
                    <button class="lookbook__close">룩북 닫기</button>
                </div>
            `;

            $("body").append(lookbook_templet);
            window.bodyScroll.fix();
            return callback();
        };


        const lookbook_change = (type, _html, _title, callback) => {
            let _css = {};
            if(type == 0) {
                _css = {
                    "width": "100%" ,
                    "top" :   "50%",
                    "left" : "0",
                    "right" : "auto",
                    "bottom" : "auto",
                    "margin":0,
                    "transform" : "translateY(-50%)",
                    "z-index": 1
                }
                $(".lookbook").removeClass('lookbook--landscape');
            } else {
                _css = {
                    "width": "75%",
                    "top" :  "0",
                    "left" : "0",
                    "right" : "0",
                    "bottom": "0",
                    "transform" : "none",
                    "margin" : "auto",
                    "z-index": 1
                }
                $(".lookbook").addClass('lookbook--landscape');
            }

            if(!!callback) {
                return callback(_html, _css, _title, lookbook_slider);
            } else {
                $(".lookbook").css(_css);
            }

        }



        const lookbook_img = (src) => {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.addEventListener("load", () => resolve(img));
                img.addEventListener("error", err => reject(err));
                img.src = src;
            });
        };

        const lookbook_loop = () => {
            let number = 0;

            return function() {
                return number++;
            }
        };

        const lookbook_delet = () => {
            if(swiper) swiper.destroy();
            $(".br__lookbook__wrap ").remove();
        }


        $document
            .on('click', '.br_lookbook', function() {
                const $this = $(this);
                const _title = $this.data('title');
                const _srcArr = JSON.parse($this.attr("data-src"));
                const lookbook_fn = lookbook_loop();
                let list = "";

                lookbook_delet();

                $.each(_srcArr, function(i ,e) {
                    lookbook_img(e)
                        .then(img =>{
                            list += `
                                <div class="lookbook__list swiper-slide">
                                     <img src="${img.src}" alt="" >
                                </div>
                            `;


                            if(lookbook_fn() + 1 == _srcArr.length) {
                                lookbook_change(window.orientation, list , _title ,lookbook_main);
                            }
                        })
                        .catch(err => console.error(err));
                });


                 return false;
            })
            .on('click', '.lookbook__close, .lookbook__bg', function() {
                lookbook_delet();
                window.bodyScroll.release();
                return false;
            });


        window.onorientationchange = function() {
            var orientation = window.orientation;
            switch(orientation) {
                case 0:
                    lookbook_change(0);
                    break;
                case 90:
                    lookbook_change(90);
                    break;
                case -90:
                    lookbook_change(-90);
                    break;
            }
        };

    }

    const loginBtn = () => {
        $document.on("click", ".header-top__login", function() {
            $(this).addClass("header-top__login--active");
        });
    }

    // init
    const main_init = () => {
        mainSlierMoving();
        main_lookbook();
        loginBtn();
    };

    main_init();
}


export default front_main;