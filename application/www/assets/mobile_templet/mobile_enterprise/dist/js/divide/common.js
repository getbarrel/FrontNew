/**
 * Created by forbiz on 2019-02-11.
 */
const front_common = () => {
    const $document = $(document);
    const $window = $(window);

    const list_h = () => {
        !(function(){if(!Handlebars.original_compile) Handlebars.original_compile = Handlebars.compile;Handlebars.compile = function(source){var s = "\\{\\[",e = "\\]\\}",RE = new RegExp('('+s+')(.*?)('+e+')','ig');var replacedSource = source.replace(RE,function(match, startTags, text, endTags, offset, string){var startRE = new RegExp(s,'ig'), endRE = new RegExp(e,'ig');startTags = startTags.replace(startRE,'\{\{');endTags = endTags.replace(endRE,'\}\}');return startTags+text+endTags;});return Handlebars.original_compile(replacedSource);};})();
    };

    const replyWrite = () => {
        const $wrap = $('.sj__reply');
        const $write = $wrap.find('.sj__reply__write');
        const TEXT_MAX_LENGTH = 100;

        /* textarea 입력 이벤트 */
        $document.on('input.reply','.sj__reply textarea',function() {
            checkTextLength(this);
        });

        /* 수정버튼 이벤트 */
        $document.on('click', '.sj__reply .modify__btn', function() {
            const $this = $(this);
            $this.attr('disabled',true);
            checkTextLength($this.siblings('.sj__reply__write').find('textarea'));
        });
        /* 수정 취소버튼 */
        $document.on('click','.sj__reply .sj__reply__write__cancel',function() {
            const $this = $(this);
            const $wrap = $this.closest('.sj__reply__list__content');
            const $modifyBtn = $wrap.find('.modify__btn');
            const $modifyTextarea = $wrap.find('textarea');
            const originalText = $wrap.find('.comment').html();

            $modifyBtn.attr('disabled',false);
            $modifyTextarea.val(originalText);
        });

        function checkTextLength (target) {
            const $this = $(target);   // textarea
            const $currentByte = $this.siblings('.byte').find('.current');
            const $btnSubmit = $this.closest('.write-area').siblings('.sj__reply__write__submit');

            $currentByte.html($this.val().length);
            if($this.val().length > 0) {
                $btnSubmit.attr('disabled',false);
            } else {
                $btnSubmit.attr('disabled',true);
            }
        }
        // 댓글 입력란 버튼 현재 상태
        $write.find('textarea').map(idx => {
            checkTextLength($write.find('textarea').eq(idx));
    });

    };

    const historyBackCheck = () => {
        const $backBtn = $(".br__floating-btn--historyback");

        //history 있는지 체크
        const history_check = () => {

            // 이전페이지가 있거나 앱이면서 이전페이지가 goodsView일 경우
            if ( document.referrer || ( (navigator.userAgent.match(/BarrelAOSApp/) || navigator.userAgent.match(/BarrelIOSApp/i)) && window.location.href.indexOf('goodsView') != -1) ) {
                //console.log(window.location.pathname);
                $backBtn.removeClass("br__floating-btn--historyback-none");
                pageHistoryBack();
            } else {
                $backBtn.addClass("br__floating-btn--historyback-none");
            }
        }

        // history back 이벤트
        const pageHistoryBack = () => {
            //console.log('1번 함수확인');
            $('.br__title-box__back, .br__floating-btn--historyback').on('click',function (e){
                //console.log('2번 이벤트 연결확인');
                // 함수호출됐는지 확인

                e.preventDefault();
                e.stopPropagation();

                //console.log('3번 조건확인', '1 '+ document.referrer.indexOf('goodsView') == -1 , '2 ' + window.location.href.indexOf('goodsView') > -1);
                    if( window.location.href.indexOf('goodsView') > -1 ){   // 현재페이지가 goodsView 이면
                    //console.log('4-1번 앱호출 조건확인');
                    if ( navigator.userAgent.match(/BarrelAOSApp/) ){
                        //console.log('4-2번 앱호출 조건확인');
                        // android app
                        window.JavascriptInterface.back();  // 제품상세 back 버튼
                    }else if(navigator.userAgent.match(/BarrelIOSApp/i)) {
                        //console.log('4-2번 앱호출 조건확인');
                        // ios app
                        window.webkit.messageHandlers.back.postMessage("");  // 제품상세 back 버튼
                    } else {
                        //console.log('4-3번 앱호출 -> historyback 조건확인');
                        history.back();
                    }
                } else{
                    //console.log('5번 앱호출 조건확인 - historyback');
                    history.back();
                }
            });
        }

        const history_init = () => {
            history_check();
        }

        history_init();
    }

    // btnTop 이벤트
    const btnTopScroll = () => {

        //localStorage.removeItem('scrollY');
        const $btnTop = $(".br__floating-btn--top");
        const $header = $('.br__header');
        const $footer = $('.br__dockbar');
        const $floatingMenu = $('.br__floating-btn');

        $btnTop.on('click', function(e) {
            // localStorage.scrollY = $(window).scrollTop();
            // window.location.href = "/mypage/preferences";
            // e.preventDefault();

            const cmsIframe = $('#brand_info__content');

            e.stopPropagation();
            $('body, html').stop().animate({
                scrollTop : 0
            });

            //최상단으로 갈때 헤더 보이지 않는 경우 있어 빈공간처럼 노출됨 #6333 >> 헤더,푸터 보이도록 추가
            $header.addClass('up').removeClass('down').css({
                'margin-top':''
            });

            $(".br__header__inner").css({
                'margin-top': ''
            });
            $footer.css({
                'margin-bottom':''
            });
            $floatingMenu.css({
                'margin-bottom':''
            });

            // cms에서 가져오는 iframe에 데이터 전송
            if(cmsIframe.length > 0) {
                document.getElementById('brand_info__content').contentWindow.postMessage({
                    cmd: 'scrollTop',
                }, '*');
            }
        });

    }

    const frontAppEvent = () => {
        $(document).on('click', '.front-app-event', function(e) {
            const $this = $(this);
            if(this.tagName == 'A') {
                if ( navigator.userAgent.match(/WallavuAOSApp/) ){
                    // android app
                    window.backWithRefresh.back();  // 갱신을 필요로 하는 홈 버튼
                    return false;
                }else if(navigator.userAgent.match(/WallavuIOSApp/i)) {
                    window.webkit.messageHandlers.backWithRefresh.postMessage("");  // 갱신을 필요로 하는 홈 버튼
                    return false;
                }
            }
        })
    }

    const inputCancel = () => {

        $document.on('input.cancel','.sj__input-text__wrap input', function() {
            const $this = $(this);
            const $btnCancel = $this.siblings('.cancel');
            if($this.val().length > 0 ){
                $btnCancel
                    .show()
                    .one('click',function() {
                        $this.val('');
                        $btnCancel.css('display','');
                    });
            } else {
                $btnCancel
                    .css('display','')
                    .off('click');
            }
        });

        $document.trigger('input.cancel');
    }

    const helpEvent = {
        // 도움 돼요/안돼요 클릭이벤트
        setLikes: function(likeType, pid, bbsIx, returnFunction) {
            if (forbizCsrf.isLogin) {
                common.ajax(common.util.getControllerUrl('updateLikes', 'review'), {'pid': pid, 'likeType' : likeType, 'bbs_ix' : bbsIx}, "",
                    function (response) {
                        if(typeof returnFunction == 'function'){
                            returnFunction({
                                upDown : response.data.upDown,
                                upCnt : response.data.upCnt,
                                downCnt : response.data.downCnt
                            });
                        }
                    });
            } else {
                common.noti.confirm(common.lang.get('product.noMember.productReview.confirm'), function () {
                    document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
                });
            }
        },

        run: function () {
            var self = this;

            self.initMinicart();
            self.initEvent();
            window.setLikes = self.setLikes;
        },
    }

    const help_ajax = () => {
        // if ( $(".devLike").length < 0) return ;
        $document.on("click", ".devLike", function(){
            const $this = $(this);
            const _data_type =  $this.data("type");

            const returnFn = (data) => {

                if ( _data_type == "U") {

                    const $btn_dont = $this.next();
                    $btn_dont.removeClass("help-btns--dont");

                    if (data.upDown == "up") {
                        $this.addClass("help-btns--like");
                    } else {
                        $this.removeClass("help-btns--like");
                    }

                    $this.find("em").html(data.upCnt);
                    $btn_dont.find("em").html(data.downCnt);
                }

                else if ( _data_type == "D") {

                    const $btn_like = $this.prev();

                    $btn_like.removeClass("help-btns--like");

                    if (data.upDown == "up") {
                        $this.addClass("help-btns--dont");
                    } else {
                        $this.removeClass("help-btns--dont");
                    }

                    $btn_like.find("em").html(data.upCnt);
                    $this.find("em").html(data.downCnt);

                }
            }

            helpEvent.setLikes($this.data("type"), $this.data("pid"), $this.data("bbsix"), returnFn);

            return false;
        });
    }

    // checkbox 전체체크
    const allSelectCheckbox = () => {
        $document.on('click','.js__check-all',function(){
            const $this = $(this);
            const $btnPorsonal = $this.closest('.js__check-wrap').find('.js__check-porsonal');
            if($this.is(':checked')) {
                $this.add($btnPorsonal).prop('checked', true);
            }else {
                $this.add($btnPorsonal).prop('checked', false);
            }

        });
        $document.on('click','.js__check-porsonal',function() {
            const $this = $(this);
            const $btnAll = $this.closest('.js__check-wrap').find('.js__check-all');
            const $btnPorsonal = $this.closest('.js__check-wrap').find('.js__check-porsonal');
            let checkFlag = true;   // 모두 체크 상태
            $btnPorsonal.map(idx => {
                if(!$btnPorsonal.eq(idx).is(':checked')) {
                checkFlag = false;
                return false;
            }
        });
            $btnAll.prop('checked',checkFlag).attr('checked',checkFlag);
        });
    }

    // 슬라이드 기본양식
    const styleSlider = () => {
        const initSlider = ($slider, options) => {
            if($slider.length > 0 && $slider.find('.slide-content').length <= 1) return false;

            $slider.each(function() {
                const $this = $(this);
                const $container = $this.find('.swiper-container')[0];
                const $linkLIst = $this.find('.slide-content__link');

                // swiper init
                const $swiper = new Swiper($container, options);

                // 자동재생 이벤트
                if(options.autoplay) {
                    $this.find('.slide-controller__player__btn').on('click', function() {
                        if($(this).hasClass('slide-controller__player__btn--playing')) {
                            $swiper.autoplay.stop();
                            $(this)
                                .addClass('slide-controller__player__btn--stop')
                                .removeClass('slide-controller__player__btn--playing');
                        }else {
                            $swiper.autoplay.start();
                            $(this)
                                .addClass('slide-controller__player__btn--playing')
                                .removeClass('slide-controller__player__btn--stop');
                        }
                    }).trigger('click');
                }

                // 전체보기 레이어 이벤트
                if(options.pagination.type == 'fraction') {
                    const $layer = $this.find('.slide-layer');
                    const $layerContBox = $layer.find('.slide-layer__content');
                    $this.find('.slide-controller__page__all-view').on('click', function() {
                        const listTag = $linkLIst.clone().map((idx, _this) => {
                                return $('<li>').addClass('slide-layer__list').append(_this)[0];
                    });
                        listTag.find('img').attr('style','');
                        $layerContBox.empty().append(listTag);
                        window.bodyScroll.fix();
                        $layer.addClass('slide-layer--show');
                    });
                    $layer.find('.slide-layer__close, .slide-layer__bg, .slide-layer__title').on('click', function() {
                        $layer.removeClass('slide-layer--show');
                        window.bodyScroll.release();
                    });

                }
            });
        }

        const sliderType1 = () => {
            const $slider = $('.br__slide--type1');
            initSlider($slider, {
                loop : true,
                speed : 700,
                autoplay : {
                    delay: 5000,
                    disableOnInteraction : false
                },
                pagination : {
                    el : '.slide-controller__page__wrap',
                    type : 'fraction',
                    currentClass : 'slide-controller__page__current',
                    totalClass : 'slide-controller__page__total'
                },
                navigation : {
                    prevEl : '.slide-controller__arrow__btn--prev',
                    nextEl : '.slide-controller__arrow__btn--next',
                    hiddenClass : 'slide-controller__arrow__btn--hidden'
                }
            });
        }
        const sliderType2 = () => {
            const $slider = $('.br__slide--type2');
            initSlider($slider, {
                loop : true,
                speed : 700,
                autoplay : {
                    delay: 5000,
                    disableOnInteraction : false
                },
                pagination : {
                    el : '.slide-controller__page__wrap',
                    type : 'fraction',
                    currentClass : 'slide-controller__page__current',
                    totalClass : 'slide-controller__page__total'
                }
            });
        }
        const sliderType3 = () => {
            const $slider = $('.br__slide--type3');
            initSlider($slider, {
                speed : 700,
                loop: true,
                loopedSlides: 10,
                pagination : {
                    el : '.slide-controller__bullet',
                    type : 'bullets',
                    clickable: true,
                    bulletClass : 'slide-controller__bullet__paging',
                    bulletActiveClass : 'slide-controller__bullet__paging--active'
                },
                navigation : {
                    prevEl : '.slide-controller__arrow__btn--prev',
                    nextEl : '.slide-controller__arrow__btn--next',
                    //disabledClass : 'slide-controller__arrow__btn--hidden'
                }
            });
        }
        const sliderType4 = () => {
            const $slider = $('.br__slide--type4');
            initSlider($slider, {
                loop : true,
                speed : 700,
                autoplay : {
                    delay: 7000,
                    disableOnInteraction : false
                },
                pagination : {
                    el : '.slide-controller__bullet',
                    type : 'bullets',
                    bulletClass : 'slide-controller__bullet__paging',
                    bulletActiveClass : 'slide-controller__bullet__paging--active'
                }
            });
        }
        const sliderType5 = () => {
            const $slider = $('.br__slide--type5');
            initSlider($slider, {
                //loop : true,
                speed : 700,
                // autoplay : {
                //     delay: 7000,
                //     disableOnInteraction : false
                // },
                pagination : {
                    el : '.slide-controller__bullet',
                    type : 'bullets',
                    clickable: true,
                    bulletClass : 'slide-controller__bullet__paging',
                    bulletActiveClass : 'slide-controller__bullet__paging--active'
                }
            });
        }

        const styleSlider_init = () => {
            sliderType1();
            sliderType2();
            sliderType3();
            sliderType4();
            sliderType5();
        }
        styleSlider_init();
    }

    // selectbox 디자인형 공통
    const selectLayer = () => {
        const $wrapper = $('.br__select-box');
        $wrapper.each(function() {
            const $wrap = $(this);
            $wrap.on('click', '.select-box__title', function(e) {
                e.stopPropagation();
                $wrapper.not($wrap).removeClass('br__select-box--toggle');
                $wrap.toggleClass('br__select-box--toggle');
            });
            $wrap.on('change', 'input[type=radio]', function(e) {
                $wrap.find('.select-box__title span').text($(this).next().text());
                $wrap.removeClass('br__select-box--toggle');
            });
            $wrap.on('click', 'label', function(e) {
                e.stopPropagation();
            });
            $wrap.on('click', '.alarm', function() {
                $wrap.removeClass('br__select-box--toggle');
            });
            
            // 초기값 텍스트 설정
            if($wrap.find(':checked').length > 0) {
                var _valueText = $wrap.find(':checked').next().text();
                $wrap.find('.select-box__title span').text(_valueText);
            }
        });
        $document.on('click', function() {
            $wrapper.removeClass('br__select-box--toggle');
        });
    }

    // layer alert
    const frontAlert = () => {
        const $wrap = $('.br__layer-alert');
        const $title = $wrap.find('.layer-alert__title');
        const $script = $wrap.find('.layer-alert__body__script');
        const $btn = $wrap.find('.layer-alert__btn');
        const $close = $wrap.find('.layer-alert__close');

        const fn = {
            'data' : {
                'title' : '',
                'script' : '',
                'btn' : '',   //  1: 확인, 2: 확인, 취소
                'callback' : '',
            },
            'open' (title, script, btn = false, callback) {
                this.data.title = title;
                this.data.script = script;
                this.data.btn = btn;
                this.data.callback = callback;
                fn.setContent();
                window.bodyScroll.fix();
                $wrap.addClass('br__layer-alert--show');
                return this;
            },
            'close' (useCallback = true, eventTarget = 'undefined') {
                if(useCallback && typeof this.data.callback == 'function') {
                    if(eventTarget == 'undefined' || $(eventTarget).hasClass('layer-alert__btn--submit') || !this.data.btn) {
                        this.data.callback();
                    }
                }
                $wrap.removeClass('br__layer-alert--show');
                window.bodyScroll.release();
                // 데이터 리셋
                this.data = {
                    'title' : '',
                    'script' : '',
                    'btn' : '',   //  1: 확인, 2: 확인, 취소
                    'callback' : '',
                };
                return this;
            },
            'setContent' () {
                $title.empty().html(this.data.title);
                $script.empty().html(this.data.script);
                $btn.removeClass('layer-alert__btn--show');
                if(this.data.btn) {
                    // 확인, 취소
                    $btn.addClass('layer-alert__btn--show');
                }else {
                    // 확인
                    $btn.filter('.layer-alert__btn--submit').addClass('layer-alert__btn--show');
                }

                const _self = this;
                $wrap.off('click').on('click.close', '.layer-alert__close, .layer-alert__btn',function(e) {
                    e.preventDefault();
                    _self.close(true, this);
                });
                return this;
            }
        }
        return fn;
    }
    // layer alert
    const frontLogin = () => {
        const $wrap = $('.br__layer-login');
        const $close = $wrap.find('.layer-login__close');

        const fn = {
            _target : $wrap,
            'open' () {
                window.bodyScroll.fix();
                $wrap.addClass('br__layer-login--show');
                return this;
            },
            'close' () {
                $wrap.removeClass('br__layer-login--show');
                window.bodyScroll.release();
                return this;
            },
            'set' () {
                $close.off('click').on('click', function() {
                    fn.close();
                });
                return this;
            }
        }
        return fn.set();
    }

    // 팝업 레이어 띄우기
    const frontLayer = () => {
        const fn = {
            //_target : $wrap,
            'open' ($target) {
                window.bodyScroll.fix();
                $target.addClass('br__layer--show');
                return this;
            },
            'close' ($target) {
                $target.removeClass('br__layer--show');
                window.bodyScroll.release();
                return this;
            },
            'set' ($close) {
                $close.off('click').on('click', function() {
                    fn.close();
                });
                return this;
            }
        }
        return fn;
    }

    const frontLayerOpen = () => {
        const layerOpen = ($open, $close, $target) => {
            $document
                .on("click", $open, function(){
                    window.frontLayer.open($target);
                })
                .on("click", $close, function(){
                    window.frontLayer.close($target);
                });
        }

        const snsLayer = () => {
            layerOpen( ".js__sns__open", ".js__sns__close",  $('.br__layer-sns'));
        }

        const langLayer = () => {
            layerOpen( ".js__lang__open", ".js__lang__close", $(".br__layer-lang"));
        }

        const campaignLayer = () => {
            layerOpen( ".drawer__menu__campaign a", ".js__sns__close",  $('.br__layer-campaign'));
        }

        const front_init = () => {
            snsLayer();
            langLayer();
            campaignLayer();
        }

        front_init();

    }

    // scroll fix
    const bodyScroll = () => {
        let scrollTop = 0;
        const fixScroll = () => {
            scrollTop = $window.scrollTop();
            $('body').css({
                'position' : 'fixed',
                'top' : -scrollTop
            });
        }
        const releaseScroll = () => {
            $('body').css({
                'position' : '',
                'top' : ''
            });
            $(window).scrollTop(scrollTop);
        }
        return {
            "fix" : fixScroll,
            'release' : releaseScroll
        };
    }

    const irTab = () => {
        $document.on("click", ".br__ir__tab button", function(){
           const $this = $(this);
           const $firstTab = $(".br__ir__tab-detail--first");
           const $secondTab = $(".br__ir__tab-detail--second");
           $this
               .addClass("br__ir__tab--active")
               .siblings().removeClass("br__ir__tab--active");

            if ( $this.hasClass("tab--first") ) {
                $firstTab.addClass("br__ir__tab-detail--show");
                $secondTab.removeClass("br__ir__tab-detail--show");
            } else {
                $firstTab.removeClass("br__ir__tab-detail--show");
                $secondTab.addClass("br__ir__tab-detail--show");
            }
        });
    }

    const tooltip = () => {
        $document.on("click", function ( e ) {
            const $this = $(e.target);
            const $layer = $(".tooltip__layer");
            if ( $this.hasClass("tooltip__icon") ) {
                const $tooltip_layer = $this.closest(".tooltip__wrap").find(".tooltip__layer");
                $tooltip_layer.addClass("tooltip__layer--show");

            } else if (!$layer.is(e.target) && $layer.has(e.target).length === 0 || $this.hasClass("tooltip__layer__close")) {
                $layer.removeClass("tooltip__layer--show");
            }
        })
    };

    //textarea 입력 글자 수
    const textarea_counting = () => {
        if ( $(".js__counting").length > 0 ) {

            const $counting = $(".js__counting__num");
            const _val_length = $(".js__counting__textarea").val().length;
            $counting.html(_val_length);

            $document.on("keyup", ".js__counting__textarea", function(){
                const $this = $(this);
                const $target = $this.closest(".js__counting");
                const $countingNum = $target.find(".js__counting__num");

                const _val_length = $this.val().length;
                $countingNum.html(_val_length);
            })
        }
    };

    // 주문결제 배송지선택팝업 예외처리
    const addressPopup = () => {
        const $layerPopup = $(".popup-content");
        const $addressPopupInner = $layerPopup.find(".address-select");

        if($addressPopupInner) {
            $layerPopup.css({
                "overflow-y" : "unset",
            });
        }
    }

    const sprintAlert = data => {
        const form = $.extend({}, {
            title : "",
            desc : "",
            callback : function(){}
        }, data);

        const html = `
            <div class="sprintAlert">
                <div class="sprintAlert__body">
                    <p class="sprintAlert__title">${form["title"]}</p>
                    <p class="sprintAlert__desc">${form["desc"]}</p>
                    <button type="button" class="sprintAlert__btn sprintAlert__btn--confirm">확인</button>
                    <button type="button" class="sprintAlert__btn sprintAlert__btn--close">닫기</button>
                </div>
            </div>
        `;

        const $popup = $(html).appendTo('body');
        const $popupBody = $popup.find('.sprintAlert__body');

        window.bodyScroll.fix();
        $popupBody.css('margin-top',- $popupBody.outerHeight() / 2 );

        $popup.find('.sprintAlert__btn--confirm, .sprintAlert__btn--close').on('click', function() {
            $popup.remove();
            window.bodyScroll.release();
            if(typeof form.callback == 'function') {
                form.callback();
            }
        });

    };

    const randomCoupon = () => {
        var permitPage = ['main', 'shop_goodsList', 'shop_subGoodsList', 'shop_goodsView'];
        var $couponBox = $('.randomCoupon');
        if(permitPage.indexOf($('body').attr('id')) != -1 && (Math.random() * 100).toFixed(2) <= parseInt($couponBox.data('percent'))) {   // % 기준
            $couponBox.addClass("show");
        }else {
            //$('.randomCoupon').remove();
            $('.randomCoupon').remove();
        }
    }

    const common_init = () => {
        if (window.location.pathname.indexOf("corporateIR")) {
            irTab();
        }
        list_h();
        replyWrite();
        historyBackCheck();
        //pageHistoryBack();
        btnTopScroll();
        inputCancel();
        help_ajax();
        allSelectCheckbox();
        styleSlider();
        selectLayer();
        window.bodyScroll = bodyScroll();
        window.frontAlert = frontAlert();
        window.frontLogin = frontLogin();
        window.frontLayer = frontLayer();
        frontLayerOpen();
        tooltip();
        textarea_counting();
        addressPopup();
        randomCoupon();

        window.sprintAlert = sprintAlert;
    };

    common_init();
}


export default front_common;