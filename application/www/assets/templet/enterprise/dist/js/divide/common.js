/**
 * Created by forbiz on 2019-02-11.
 */
const front_common = () => {
    const $window = $(window);
    const $document = $(document);
    const $body = $("body");
    const list_h = () => {
        !(function(){if(!Handlebars.original_compile) Handlebars.original_compile = Handlebars.compile;Handlebars.compile = function(source){var s = "\\{\\[",e = "\\]\\}",RE = new RegExp('('+s+')(.*?)('+e+')','ig');var replacedSource = source.replace(RE,function(match, startTags, text, endTags, offset, string){var startRE = new RegExp(s,'ig'), endRE = new RegExp(e,'ig');startTags = startTags.replace(startRE,'\{\{');endTags = endTags.replace(endRE,'\}\}');return startTags+text+endTags;});return Handlebars.original_compile(replacedSource);};})();
    };

    const heart_btn = () => {
        $document.on("click", "[data-devwishbtn]", function() {
            const $this = $(this);
            const _pid = $this.attr('data-devwishbtn');
            if (forbizCsrf.isLogin) {
                wish.setTarget($(this)).run(_pid);
                if ( $this.hasClass("product-box__heart") ) {
                    $this.toggleClass("product-box__heart--active");
                } else {
                    $this.toggleClass("on");
                }
            } else {
                alert("A");
                /*common.noti.confirm(common.lang.get('product.wish.noMember.confirm'), function () {
                    document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + _pid);
                });*/
            }
            return false;
        });
    };

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

    const mypage_all_select = () => {

        const $all_checkbox = $("#all-check");

        const allcheck = () => {
            $document.on("click", "#all-check", function(){
                const $each_checkbox = $document.find(".item-check");
                if ( $all_checkbox.is(":checked") ) {
                    $each_checkbox.prop("checked",true);
                } else {
                    $each_checkbox.prop("checked",false);
                }
            });
        }

        const itemcheck = () => {
            $document.on("click", ".item-check", function(){
                const $item_checkbox = $(".item-check");
                const _all_box_num = $document.find(".item-check").length;
                const _item_checked = $item_checkbox.filter(":checked").length;

                if ( _all_box_num == _item_checked ) {
                    $all_checkbox.prop("checked",true);
                } else {
                    $all_checkbox.prop("checked",false);
                }
            });
        }

        const select_init = () => {
            allcheck();
            itemcheck();
        }
        select_init();
    }

    const mypage_seacharea = () => {
        $document
            .on("click", ".day-radio a", function(){
                //라디오
                const $this = $(this);
                $this.addClass("day-radio--active").siblings().removeClass("day-radio--active");
                $('#devSdate').val($this.data('sdate'));
                $('#devEdate').val($this.data('edate'));

                return false;
            })
            .on("click", "#devSearchInitBtn ", function(){
                const $this = $(this);
                //검색조건 초기화
                $('.devDateBtn').removeClass('day-radio--active');
                $('#devDateDefault').addClass('day-radio--active');
                $('#devSdate').val($this.data('sdate'));
                $('#devEdate').val($this.data('edate'));
                $('#devStatus').val('all');
                $('#devPname').val('');
            })
            .on("click", "#devBtnReset", function(){
                //검색조건 초기화(체크박스)
                $("#devSdate").val($("#sDateDef").val());
                $("#devEDate").val($("#eDateDef").val());
                $(".devDateBtn").removeClass("day-radio--active");
                $("#devDateDefault").addClass("day-radio--active");
                $("input:checkbox[name^=s]").prop("checked", true);
                $("#devBbsDiv").val("");

                return false;
            });
    }

    const mypage_datepicker = () => {
        //3년전 구하기
        var date = new Date();
        var cDate = new Date(); //현재
        var minDate = date.getTime() - (365 * 3 * 24 * 60 * 60 * 1000); //3년전
        date.setTime(minDate);

        var cYear = cDate.getFullYear();
        var cMonth = cDate.getMonth() + 1;
        var cDay = cDate.getDate();

        if(cMonth < 10) {cMonth = "0" + cMonth;}
        if(cDay < 10) {cDay = "0" + cDay;}

        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();

        if(month < 10) {month = "0" + month;}
        if(day < 10) {day = "0" + day;}

        var cDate = cYear + "-" + cMonth + "-" + cDay;
        var minDate = year + "-" + month + "-" + day;

        var langType = $('html').attr('lang');
        var yearSuffix,
            monthNames,
            dayNamesMin;
        
        if(langType == 'ko') {
            yearSuffix = '';
            monthNames = ['년 1월', '년 2월', '년 3월', '년 4월', '년 5월', '년 6월', '년 7월', '년 8월', '년 9월', '년 10월', '년 11월', '년 12월']
            dayNamesMin = ['일', '월', '화', '수', '목', '금', '토']
        }else {
            yearSuffix = $.datepicker.regional[langType].yearSuffix;
            monthNames = $.datepicker.regional[langType].monthNames;
            dayNamesMin = $.datepicker.regional[langType].dayNamesMin;
        }

        common.lang.load('alert.datepicker.maxDate', "최대 3년 내 내역까지만 조회 가능합니다.");
        common.lang.load('alert.datepicker.posibleStart', "시작일은 종료일 보다 이후일 수 없습니다.");
        common.lang.load('alert.datepicker.posibleEnd', "종료일은 시작일 보다 이전일 수 없습니다.");
        common.lang.load('alert.datepicker.posibleCourrent', "현재보다 클 수 없습니다.");

        $("#devSdate").datepicker({
            // monthNames: ['년 1월', '년 2월', '년 3월', '년 4월', '년 5월', '년 6월', '년 7월', '년 8월', '년 9월', '년 10월', '년 11월', '년 12월'],
            // dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            yearSuffix :yearSuffix, 
            monthNames: monthNames,
            dayNamesMin: dayNamesMin,
            showMonthAfterYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImageOnly: true,
            buttonText: '달력',
            onSelect: function (dateText) {
                if(dateText < minDate) {
                    $('#devSdate').val($('#sDateDef').val());
                    alert(common.lang.get('alert.datepicker.maxDate'));
                }

                if ($('#devEdate').val() != '' && $('#devEdate').val() < dateText) {
                    $('#devSdate').val($('#sDateDef').val());
                    $('#devEdate').val($('#eDateDef').val());
                    common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.doubleCheck"));
                    alert(common.lang.get('alert.datepicker.posibleStart'));
                }
            }
        });

        $('#devEdate').datepicker({
            // monthNames: ['년 1월', '년 2월', '년 3월', '년 4월', '년 5월', '년 6월', '년 7월', '년 8월', '년 9월', '년 10월', '년 11월', '년 12월'],
            // dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            yearSuffix :yearSuffix, 
            monthNames: monthNames,
            dayNamesMin: dayNamesMin,
            showMonthAfterYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImageOnly: true,
            buttonText: '달력',
            onSelect: function (dateText) {
                if(dateText > cDate) {
                    $('#devEdate').val($('#eDateDef').val());
                    alert(common.lang.get('alert.datepicker.posibleCourrent'));
                }
                if(dateText < minDate) {
                    $('#devEdate').val($('#eDateDef').val());
                    alert(common.lang.get('alert.datepicker.maxDate'));
                }

                if ($('#devSdate').val() != '' && $('#devSdate').val() > dateText) {
                    $('#devSdate').val($('#sDateDef').val());
                    $('#devEdate').val($('#eDateDef').val());
                    common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.doubleCheck"));
                    alert(common.lang.get('alert.datepicker.posibleEnd'));
                }
            }
        });

    }

    const imageLayer_slide = () => {

        const $target = $(".sj__image-layer");
        const _img_length = $target.find(".sj__image-layer__slide-item").length;

        $target.find(".sj__image-layer__slide-page--total").html(_img_length);

        if ($target.length < 1) return ;

        if ( _img_length > 1) {
            $target.find(".sj__image-layer__slide-btn").addClass("sj__image-layer__slide-btn--show");
            $target.find(".sj__image-layer__slide-page").addClass("sj__image-layer__slide-page--show");

            $target.find(".sj__image-layer__slide")
                .slick({
                    infinite: true,
                    slideToShow: 1,
                    slidesToScroll: 1,
                    prevArrow: $target.find(".sj__image-layer__slide-btn--prev"),
                    nextArrow: $target.find(".sj__image-layer__slide-btn--next"),
                })
                .on("beforeChange",function(event, slick, currentSlide, nextSlide){
                    $(".sj__image-layer__slide-page--now").html(nextSlide + 1);
                });
        }

    }

    const change_profile_img = () => {
        // 회원가입 정보입력 썸네일 미리보기
        if($('.js-profile').length < 1) return ;
        const $addTag = $('.js-profile .js-profile-add');
        const $removeTag = $('.js-profile .js-profile-remove');
        const $thumbTag = $('.js-profile .js-profile-img');
        const $checkState = $('[name=isProfileDel]');
        window.profileFileList = $addTag[0].files;    //데이터 저장 전역변수
        $addTag.on('change',function() {
            const $this = $(this);
            const fileList = this.files || this.value;

            const _acceptType = $this.attr('accept');
            let _imgType = '';
            if(fileList[0]) {
                _imgType = fileList[0].type.replace('image/','');
            }else if (this.value) {
                _imgType = fileList.replace(/.*(\..*)/,'$1');
            }
            if(_acceptType.length > 0 && !fileList || _acceptType.indexOf(_imgType) == -1 || _imgType == "") {
                // accept된 파일 확장자가 아닌 경우
                $this.val('');
                // dev_common alert
                console.log(common.lang.get('common.inputFormat.fileFormat.fail'));
                //common.noti.alert(common.lang.get('common.inputFormat.fileFormat.fail'));
                return false;
            }

            if(window.FileReader){
                if(fileList.length > 0) {
                    const reader = new FileReader();
                    window.profileFileList = fileList;
                    reader.readAsDataURL(fileList[0]);

                    reader.onload = () => {
                        $thumbTag[0].src = reader.result;
                    }
                    if($checkState.length > 0){
                        $checkState.val('0');
                    }
                } else {
                    $thumbTag[0].src = $thumbTag.data('default');
                }
            }else if((navigator.appName == "Netscape" && navigator.userAgent.search('Trident') != -1) || navigator.userAgent.toLowerCase().indexOf('msie') != -1) {
                //alert('Internet Explorer 9 이하에선 업로드한 이미지 썸네일을 확인 할 수 없습니다.');
            }

        });

        $removeTag.on('click',function() {
            $thumbTag.attr('src',$thumbTag.data('default'));
            $addTag.val('').removeClass('portrait');
            //window.profileFileList = $addTag[0].files;
            if($checkState.length > 0){
                $checkState.val('1');
            }
        });

    }

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

    const main_menu = () => {
        $document
            .on("mouseover mouseleave", ".header__menu",function(e) {
                const $this = $(this);

                if(e.type == "mouseover") {
                    $this.addClass("header__menu--over");
                } else {
                    $this.removeClass("header__menu--over");
                };

                $(".fb__page-nav select").blur();
            })
            .on("click", ".header__topMenu__global__btn",function() {
                $(this).toggleClass("header__topMenu__global__btn--open");
            })

    };

    const main_sns = () => {
        common.lang.load('instagram.layer.title.getbarrel',"배럴 오피셜");
        common.lang.load('instagram.layer.title.swim',"배럴 스윔");
        common.lang.load('instagram.layer.title.fit',"배럴 핏");
        common.lang.load('instagram.layer.title.cosmetics',"배럴 코스메틱스");
        var newImg = new Image;
        let _src;
        newImg.onload = function() {
            _src = this.src;
        }
        newImg.src = '/assets/templet/enterprise/images/customer/img-sns.gif';


        const sns_modal = (_src) => {
            const _instagram = `
                <div class="fb__sns-modal">
                    <div class="sns">
                        <a href="#" class="sns__close">
                            닫기
                        </a>
                        <div class="sns__inner">
                            <figure>
                                <img src="${_src}" alt="">
                            </figure>
                            <nav>
                                <a target="_blank" href="https://www.instagram.com/getbarrel">
                                    ${ common.lang.get('instagram.layer.title.getbarrel')}
                                </a>
                                <a target="_blank" href="https://www.instagram.com/barrel.swim">
                                    ${ common.lang.get('instagram.layer.title.swim')}
                                </a>
                                <a target="_blank" href="https://www.instagram.com/barrel.fit/?hl=ko">
                                    ${ common.lang.get('instagram.layer.title.fit')}
                                </a>
                                <a target="_blank" href="https://www.instagram.com/barrel.cosmetics">
                                    ${ common.lang.get('instagram.layer.title.cosmetics')}
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="sns__bg"></div>
                </div>
            `;
            $body.append(_instagram);
        }




        $document
            .on("click", ".fb__sns--instagram", function() {
                sns_modal(_src);
                return false;
            })
            .on("click", ".sns__close, .sns__bg", function() {
                $(".fb__sns-modal").remove();
                return false;
        });
    };

    const sport_layer = () => {

        var newImg = new Image;
        let _src;
        newImg.onload = function() {
            _src = this.src;
        }
        // 2개로 일단 쓸거면 img-sport2.png 로 변경
        newImg.src = '/assets/templet/enterprise/images/customer/img-sport.png';


        const sport_modal = (_src) => {
            const _instagram = `
                <div class="fb__sns-modal fb__sport-modal">
                    <div class="sns">
                        <a href="#" class="sns__close">
                            닫기
                        </a>
                        <div class="sns__inner">
                            <figure>
                                <img src="${_src}" alt="">
                            </figure>
                            <nav>
                                <a target="_blank" href="/event/eventDetail/47">
                                    스프린트 챔피언십
                                </a>
                                <a target="_blank" href="/event/eventDetail/208">
                                    SOS 캠페인
                                </a>
                                <a target="_blank" href="/brand/cheering">
                                    치어링 유어 스웻
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="sns__bg"></div>
                </div>
            `;
            $body.append(_instagram);
        }




        $document
            .on("click", ".fb__open__sport", function() {
                sport_modal(_src);
                return false;
            })
            .on("click", ".sns__close, .sns__bg", function() {
                $(".fb__sns-modal").remove();
                return false;
            });
    };

    // 상품리스트, 검색 필터
    const list_filter = () => {
        $document.on("click", ".fb__fat .filter__btn", function() {
            const $this = $(this);
            $this.toggleClass("filter__btn--active");
            $this.parents(".list-contents__header").toggleClass("list-contents__header--open");
            $(".filter__content").toggleClass("filter__content--show");
        });

        const filter_wide_view = () => {
            $('.filter__title__view').each(function() {
                const $this = $(this);
                const _wrapHeight = $this.closest('.filter__list').find('.filter__cont-box').height();
                const _contHeight = $this.closest('.filter__list').find('.filter__cont-box > ul').height();
                if(_wrapHeight < _contHeight) {
                    $this.addClass('filter__title__view--show');
                }
            }).on('click', function() {
                const $this = $(this);
                $this.toggleClass('filter__title__view--active');
                $this.closest('.filter__list').find('.filter__cont-box').toggleClass('filter__cont-box--show');
            });
        }

        const filter_select = () => {
            const $result_box = $('.filter__result__list');

            const filter_selected = () => {
                common.lang.load('goodsList.filter.minPrice',"최소금액을 입력해주세요.");
                common.lang.load('goodsList.filter.maxPrice',"최대금액을 입력해주세요.");
                common.lang.load('goodsList.filter.priceError',"최소금액이 최대금액보다 크게 검색할 수 없습니다.");
                $('.filter__cont-box input[type=checkbox]')
                    .add('.filter__price-btn input[type=radio]')
                    .add('.filter__text-price input[type=radio]')
                    .on('click', function() {
                        const $this = $(this);
                        const _val = $this.val();

                        if($this.is(':checked')) {
                            const _name = $this.attr('name');
                            let _text = $this.next().html();
                            let templet;
                            if(_name == 'search_price') {
                                $('.filter__result__list button[data-value=search_price]').closest('.filter__result__text').remove();
                                if($this.attr('id') == 'search_price_5') {
                                    $this.data({
                                        'sprice' : $('#devSpriceInput').val(),
                                        'eprice' : $('#devEpriceInput').val()
                                    });
                                    const _sprice = $this.data('sprice');
                                    const _eprice = $this.data('eprice');

                                    if(!_sprice) {
                                        alert(common.lang.get('goodsList.filter.minPrice'));
                                        $('#devSpriceInput').focus();
                                        return ;
                                    }

                                    if(!_eprice) {
                                        alert(common.lang.get('goodsList.filter.maxPrice'));
                                        $('#devEpriceInput').focus();
                                        return ;
                                    }

                                    if(_sprice > _eprice) {
                                        alert(common.lang.get('goodsList.filter.priceError'));
                                        $(this).prop('checked', false);
                                        $('#devSpriceInput').val('');
                                        $('#devEpriceInput').val('');
                                        $('#devSpriceInput').focus();
                                        return ;
                                    }
                                    _text = `${_sprice}원~${_eprice}원`

                                    if($('.filter__result__list').hasClass("eng")) { // 영문몰에서 달러($)단위 노출되도록 조건 추가
                                        _text = `$ ${_sprice} ~ $ ${_eprice}`
                                    }
                                } else {
                                    $('#devSpriceInput').val($this.data('sprice'));
                                    $('#devEpriceInput').val($this.data('eprice'));
                                }

                                var _selPrice = _text.trim();
                                templet = `
                                <span class="filter__result__text">
                                    <span data-selected="${_selPrice}">${_text}</span>
                                    <button type="button" class="filter__result__delete" data-value="search_price">delete</button>
                                </span>
                            `;
                            }else if (_name == 'COLOR'){
                                var _selColor = $(_text).attr("alt");
                                templet = `
                                <span class="filter__result__color">
                                    <figure class="thumb" data-selected="${_selColor}">${_text}</figure>
                                    <button type="button" class="filter__result__delete" data-value="${_val}">delete</button>
                                </span>
                            `;
                            }else {
                                var _selText = _text.trim();
                                templet = `
                                <span class="filter__result__text">
                                    <span data-selected="${_selText}">${_text}</span>
                                    <button type="button" class="filter__result__delete" data-value="${_val}">delete</button>
                                </span>
                            `;
                            }

                            $result_box.append(templet);
                        }else {
                            $result_box.find(`[data-value=${_val}]`).closest('.filter__result__color, .filter__result__text').remove();
                        }
                    });
            }
            const filter_delete = () => {
                $('.filter__result__list').on('click', '.filter__result__delete', function() {
                    let _val = $(this).data('value');
                    if(isNaN(Number(_val))) {
                        $('.filter__price').find(`[name=${_val}]`).prop('checked',false);
                    }else {
                        $('.filter__cont-box').find(`[value=${_val}]`).prop('checked',false);
                    }
                    $(this).closest('.filter__result__color, .filter__result__text').remove();
                });
            }
            const filter_reset = () => {
                $('.filter__all__release').on('click', function() {
                    $('.filter__content')
                        .find('input[type=radio], input[type=checkbox]').prop('checked',false).end()
                        .find(".filter__price").find('input[type=text]').val("").end().end()
                        .find('.filter__result__list').children().remove();
                });

            }

            filter_selected();
            filter_delete();
            filter_reset();
        }

        filter_wide_view();
        filter_select();
    }

    const comon_fat = () => {


        const fat_modal = (callback) => {

            // window.gadgets = window.gadgets || {
            //     config: {
            //         register: function () {}
            //     }
            // };
            //
            //
            // const _temple = `
            //     <div class="fb__fat">
            //         <div class="fat.htm">
            //             <div class="fat__content">
            //                 <header class="fat__header">
            //                     <h2 class="fat__title">
            //                         상품별 통계 분석
            //                     </h2>
            //                     <a href="#" class="fat__close">close</a>
            //                 </header>
            //                 <div class="fat__goods">
            //                     <figure>
            //                         <img src="" alt="">
            //                     </figure>
            //                     <h3 class="fat__goods__title">
            //                         우먼 네오프렌 후디 집업 자켓
            //                     </h3>
            //                     <p class="fat__goods__option">
            //                         브라이드 핑크
            //                     </p>
            //                     <p class="fat__goods__price"><b>54,000</b>원</p>
            //                 </div>
            //                 <div class="fat__option">
            //                     <h4 class="fat__option__title">
            //                         옵션항목
            //                     </h4>
            //                     <div class="fat__option__content" id="option"></div>
            //                 </div>
            //             </div>
            //             <div class="fat__bg"></div>
            //         </div>
            //     </div>
            // `;
            // $body.append(_temple);
            const $target = $(".fb__fat");
            $target.addClass("fb__fat--show");
            return callback();
        };

        const fat_chart_an = () => {
            $(".fat__option__title")
                .html("성별 + 연령대별 구매")
                .css("margin-top", "90px");
            $(".fat__fn__filter").addClass("fat__fn__filter--show");

            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawStacked);

            function drawStacked() {
                var data = google.visualization.arrayToDataTable([
                    ['', '여성', '남성', '알수없음'],
                    ['2010/09/27', 10, 24, 20],
                    ['2020', 16, 22, ''],
                ]);

                var options = {
                    width: 880,
                    height: 290,
                    chartArea:{left:40,top:45,width:"92%",height:"65%"},
                    isStacked: true,
                    legend: { position: "top" ,textStyle: {color: '#9b9da3', fontSize: 14}},
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    series: {
                        0: { color: '#512ccb' },
                        1: { color: '#3962e6' },
                        2: { color: '#1fafeb' },
                    },
                    bar: {groupWidth: "35%"},
                    vAxis: {
                        //title: 'Temperature',
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        // gridlines: {
                        //     count: 12
                        // },
                        gridlines: {
                            color: '#2d3136',
                        }
                    },
                    backgroundColor: { fill: '#1d2127' },
                    hAxis: {
                        baselineColor: "#444851",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: '#444851',
                        }
                    },
                    hAxis: {
                        baselineColor: "red",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: 'blue',
                        }
                    }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('option'));
                chart.draw(data, options);

                $document
                    .on("click", "a[class^=filter__btn--]", function() {
                        const $this = $(this);
                        const _test = $this.attr("data-test");
                        $this.parent().find("a").removeClass("filter__btn--active");
                        $this.addClass("filter__btn--active test");
                        if(_test == 0) {
                            var data = google.visualization.arrayToDataTable([
                                ['', '여성', '남성', '알수없음'],
                                ['2011/09/27', 30, 54, 20],
                                ['2010', 46, 22, ''],
                            ]);
                        } else {
                            var data = google.visualization.arrayToDataTable([
                                ['', '여성', '남성', '알수없음'],
                                ['2013/09/27', 5, 24, 20],
                                ['2022', 36, 22, ''],
                            ]);
                        }
                        var chart = new google.visualization.ColumnChart(document.getElementById('option'));
                        chart.draw(data, options);
                        return false;
                    })
                    .on("click", ".fat__fn__filter a", function() {
                        alert("Test");
                        return false;
                    })
            }
        };

        const fat_chart_order = () => {
            $(".fat__option__title")
                .html("주문/조회 분석")
                .css("margin-top", "");
            $(".fat__fn__filter").removeClass("fat__fn__filter--show");


            google.charts.load('current', {'packages':['line', 'corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var chartDiv = document.getElementById('option');

                var data = new google.visualization.DataTable();
                data.addColumn('date', 'Month');
                data.addColumn('number', "주문(전체)");
                data.addColumn('number', "조회(전체)");

                data.addRows([
                    [new Date(2014, 0),  -.5,  5.7],
                    [new Date(2014, 1),   .4,  8.7],
                    [new Date(2014, 2),   .5,   12],
                    [new Date(2014, 3),  2.9, 15.3],
                    [new Date(2014, 4),  6.3, -2.6],
                    [new Date(2014, 5),    9, 20.9],
                    [new Date(2014, 6), 10.6, 19.8],
                    [new Date(2014, 7), 10.3, 16.6],
                    [new Date(2014, 8),  7.4, 13.3],
                    [new Date(2014, 9),  4.4,  9.9],
                    [new Date(2014, 10), 1.1,  6.6],
                    [new Date(2015, 1), -.2,  40.5]
                ]);

                var materialOptions = {
                    width: 880,
                    height: 290,
                    chartArea:{left:40,top:45,width:"92%",height:"75%"},
                    color:["red","green"],
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    backgroundColor: { fill: '#1d2127' },
                    legend: { position: "top" ,textStyle: {color: '#9b9da3', fontSize: 14}},
                    series: {
                        0: {
                            axis: 'Temps',
                            targetAxisIndex: 0,
                            color: '#512ccb'
                        },
                        1: {

                            axis: 'Daylight',
                            targetAxisIndex: 1,
                            color: '#3962e6'
                        },
                    },
                    axes: {
                        // Adds labels to each axis; they don't have to match the axis names.
                        y: {
                            Temps: {label: 'Temps (Celsius)'},
                            Daylight: {label: 'Daylight'}
                        }
                    },
                    vAxis: {
                        //title: 'Temperature',
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        // gridlines: {
                        //     count: 12
                        // },
                        gridlines: {
                            color: '#2d3136',
                        }
                    },
                    hAxis: {
                        baselineColor: "#444851",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: '#444851',
                        }
                    },
                    hAxis: {
                        baselineColor: "red",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: 'transparent',
                        }
                    }
                };

                var materialChart = new google.visualization.LineChart(chartDiv);
                materialChart.draw(data, materialOptions);

                $document
                    .on("click", "a[class^=filter__btn--]", function() {
                        const $this = $(this);
                        const _test = $this.attr("data-test");
                        $this.parent().find("a").removeClass("filter__btn--active");
                        $this.addClass("filter__btn--active test");
                        if(_test == 0) {
                            var data = new google.visualization.DataTable();
                            data.addColumn('date', 'Month');
                            data.addColumn('number', "주문(전체)");
                            data.addColumn('number', "조회(전체)");
                            data.addRows([
                                [new Date(2015, 0),  -.5,  5.7],
                                [new Date(2015, 1),   .4,  8.7],
                                [new Date(2015, 2),   .5,   12],
                                [new Date(2015, 3),  2.9, 15.3],
                                [new Date(2015, 4),  6.3, -2.6],
                                [new Date(2015, 5),    9, 20.9],
                                [new Date(2015, 6), 10.6, 19.8],
                                [new Date(2015, 7), 10.3, 16.6],
                                [new Date(2015, 8),  7.4, 13.3],
                                [new Date(2015, 9),  4.4,  9.9],
                                [new Date(2015, 10), 1.1,  6.6],
                                [new Date(2015, 11), -.2,  40.5]
                            ]);
                        } else {
                            var data = new google.visualization.DataTable();
                            data.addColumn('date', 'Month');
                            data.addColumn('number', "주문(전체)");
                            data.addColumn('number', "조회(전체)");
                            data.addRows([
                                [new Date(2016, 0),  -.5,  5.7],
                                [new Date(2016, 1),   .4,  8.7],
                                [new Date(2016, 2),   .5,   12],
                                [new Date(2016, 3),  2.9, 15.3],
                                [new Date(2016, 4),  6.3, -2.6],
                                [new Date(2016, 5),    9, 20.9],
                                [new Date(2016, 6), 10.6, 19.8],
                                [new Date(2016, 7), 10.3, 16.6],
                            ]);
                        }
                        var materialChart = new google.visualization.LineChart(chartDiv);
                        materialChart.draw(data, materialOptions);
                        return false;
                    })

            }
        };

        const fat_chart_option = () => {
            $(".fat__option__title")
                .html("옵션항목")
                .css("margin-top", "");
            $(".fat__fn__filter").removeClass("fat__fn__filter--show");

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawStuff);

            function drawStuff() {
                var data = google.visualization.arrayToDataTable([
                    ["Element", "Density", { role: "style" } ],
                    ["L", 40, "#5077e1"],
                    ["M", 60, "#1fafeb"],
                    ["S", 30, "#63cbf7"],
                    ['XS', 12, "#1fafeb"],
                ]);

                //var view = new google.visualization.DataView(data);

                // var view = new google.visualization.DataView(data);
                // view.setColumns([0, 1,
                //     { calc: "stringify",
                //         sourceColumn: 1,
                //         type: "string",
                //         role: "annotation" },
                //     2]);


                var options = {
                    //title: "Density of Precious Metals, in g/cm^3",
                    chartArea:{left:44,top:0,width:"94%",height:"90%"},
                    width: 880,
                    height: 290,
                    bar: {groupWidth: "35%"},
                    legend: { position: "none" },
                    axes: {
                        y: {
                            0: {side: 'left'}
                        }
                    },
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    backgroundColor: { fill: '#1d2127' },
                    vAxis: {
                        //title: 'Temperature',
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        // gridlines: {
                        //     count: 12
                        // }
                    },
                    hAxis: {
                        baselineColor: "#444851",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: '#444851',
                        }
                    }
                };

                var chart = new google.visualization.BarChart(document.getElementById("option"));
                google.visualization.events.addListener(chart, 'ready', afterDraw);
                chart.draw(data, options);

                $document
                    .on("click", "a[class^=filter__btn--]", function() {
                        const $this = $(this);
                        const _test = $this.attr("data-test");
                        $this.parent().find("a").removeClass("filter__btn--active");
                        $this.addClass("filter__btn--active test");
                        if(_test == 0) {
                            data = google.visualization.arrayToDataTable([
                                ["Element", "Density", { role: "style" } ],
                                ["L", 10, "#5077e1"],
                                ["M", 60, "#1fafeb"],
                                ["S", 40, "#63cbf7"],
                                ['XS', 52, "#1fafeb"],
                            ]);
                        } else {
                            data = google.visualization.arrayToDataTable([
                                ["Element", "Density", { role: "style" } ],
                                ["L", 20, "#5077e1"],
                                ["M", 10, "#1fafeb"],
                                ["S", 40, "#63cbf7"],
                                ['XS', 12, "#1fafeb"],
                            ]);
                        }
                        var chart = new google.visualization.BarChart(document.getElementById("option"));
                        chart.draw(data, options);
                        return false;
                    })
            };

            function afterDraw(){
                //console.log("end");
            }

        };

        const fat_chart_date = () => {
            $("#fat_day_start").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                onClose: function( selectedDate ) {
                    $( "#fat_day_end" ).datepicker( "option", "minDate", selectedDate );
                },
                onSelect : function(dateText, inst) {  //날짜 범위 한달까지만 가능하도록
                    var stDate = dateText.split("-");
                    var dt = new Date(stDate[0], stDate[1], stDate[2]);
                    var year = dt.getFullYear(); // 년도 구하기
                    var month = dt.getMonth() + 1; // 한달뒤의 달 구하기
                    var month = month + ""; // 문자형태
                    if(month.length == "1") var month = "0" + month; // 두자리 정수형태
                    var day = dt.getDate();
                    var day = day + "";
                    if(day.length == "1") var day = "0" + day;

                    var nextMonth = year + "-" + month + "-" + day;
                    $( "#fat_day_end" ).datepicker( "option", "maxDate", nextMonth );
                    $( "#fat_day_end" ).datepicker('setDate', nextMonth);
                }
            });
            $( "#fat_day_end" ).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                minDate: 'today',
                maxDate: "+1m",
            });
            $("#fat_day_start").datepicker('setDate', 'today');
            $( "#fat_day_end" ).datepicker('setDate', '+1m');
        };

        const fat_excel_date = () => {

            $("#fat_excelDay_start").datepicker({
                dateFormat: 'yy-mm-dd',
            }).datepicker("setDate", new Date());

            $("#fat_excelDay_end").datepicker({
                dateFormat: 'yy-mm-dd',
            }).datepicker("setDate", new Date());

        };

        const fat_syn_today = () => {
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawAnnotations);

            function drawAnnotations() {
                var data = google.visualization.arrayToDataTable([
                    ['', '주문(전체)', '조회(전체)'],
                    ['00', 120, 224],
                    ['02', 16, 22],
                    ['03', 16, 22],
                    ['04', 16, 22],
                    ['05', 16, 22],
                    ['06', 16, 22],
                    ['07', 16, 22],
                    ['08', 16, 22],
                    ['09', 16, 22],
                    ['10', 16, 22],
                    ['11', 16, 22],
                    ['12', 16, 22],
                    ['13', 16, 22],
                    ['14', 16, 22],
                    ['15', 16, 22],
                    ['16', 16, 22],
                    ['17', 16, 22],
                    ['18', 16, 22],
                    ['19', 16, 22],
                    ['20', 16, 22],
                    ['21', 16, 22],
                    ['22', 16, 22],
                    ['23', 160, 521]
                ]);

                var options = {
                    width: 880,
                    height: 440,
                    chartArea:{left:40,top:45,width:"92%",height:"80%"},
                    isStacked: true,
                    legend: { position: "top" ,textStyle: {color: '#9b9da3', fontSize: 14}},
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    series: {
                        0: { color: '#512ccb' },
                        1: { color: '#3962e6' },
                    },
                    //bar: {groupWidth: "35%"},
                    vAxis: {
                        //title: 'Temperature',
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        // gridlines: {
                        //     count: 12
                        // },
                        gridlines: {
                            color: '#2d3136',
                        }
                    },
                    backgroundColor: { fill: '#1d2127' },
                    hAxis: {
                        baselineColor: "#444851",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: '#444851',
                        }
                    },
                    hAxis: {
                        baselineColor: "red",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: 'blue',
                        }
                    }
                };


                var chart = new google.visualization.ColumnChart(document.getElementById('syn__toady'));
                chart.draw(data, options);
            }
        }

        const fat_syn_order = (data = []) => {
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawAnnotations);

            function drawAnnotations() {
                var data = google.visualization.arrayToDataTable([
                    ['', '주문(전체)', '조회(전체)', '알수없음'],
                    ['10대', 120, 224, 0],
                    ['20대', 16, 22, ''],
                    ['30대', 16, 22, 100],
                    ['40대', 16, 22, ''],
                    ['50대', 16, 22, 20],
                    ['60대', 16, 22, ''],
                    ['연령 알수없음', '', '', 160]
                ]);

                var options = {
                    width: 880,
                    height: 440,
                    chartArea:{left:40,top:45,width:"92%",height:"80%"},
                    isStacked: true,
                    legend: { position: "top" ,textStyle: {color: '#9b9da3', fontSize: 14}},
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    series: {
                        0: { color: '#512ccb' },
                        1: { color: '#3962e6' },
                        2: { color: '#1fafeb' },
                    },
                    //bar: {groupWidth: "35%"},
                    vAxis: {
                        //title: 'Temperature',
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        // gridlines: {
                        //     count: 12
                        // },
                        gridlines: {
                            color: '#2d3136',
                        }
                    },
                    backgroundColor: { fill: '#1d2127' },
                    hAxis: {
                        baselineColor: "#444851",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: '#444851',
                        }
                    },
                    hAxis: {
                        baselineColor: "red",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: 'blue',
                        }
                    }
                };


                var chart = new google.visualization.ColumnChart(document.getElementById('order_chart'));
                chart.draw(data, options);
            }
        };

        const fat_syn_sex = () => {
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['', ''],
                    ['여성',     11],
                    ['남성',      2],
                    ['알수없음',  2],
                ]);

                var options = {
                    width: 880,
                    height: 440,
                    backgroundColor: { fill: '#1d2127' },
                    legend: { position: "top" ,textStyle: {color: '#9b9da3', fontSize: 14}},
                    chartArea:{left:40,top:45,width:"92%",height:"80%"},
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    slices: {
                        0: { color: '#512ccb' },
                        1: { color: '#3962e6' },
                        2: { color: '#1fafeb' },
                    },
                    pieSliceBorderColor: '#1d2127',
                };

                var chart = new google.visualization.PieChart(document.getElementById('order_chart'));

                chart.draw(data, options);
            }
        };

        const fat_syn_old = () => {
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawStuff);

            function drawStuff() {
                var data = google.visualization.arrayToDataTable([
                    ["Element", "Density", { role: "style" } ],
                    ["알수없음", 40, "#5077e1"],
                    ["10대", 60, "#1fafeb"],
                    ["20대", 30, "#63cbf7"],
                    ['30대', 12, "#1fafeb"],
                    ["40대", 40, "#5077e1"],
                    ["50대", 60, "#1fafeb"],
                    ["60대", 30, "#63cbf7"],
                ]);

                //var view = new google.visualization.DataView(data);

                // var view = new google.visualization.DataView(data);
                // view.setColumns([0, 1,
                //     { calc: "stringify",
                //         sourceColumn: 1,
                //         type: "string",
                //         role: "annotation" },
                //     2]);


                var options = {
                    //title: "Density of Precious Metals, in g/cm^3",
                    chartArea:{left:64,top:0,width:"90%",height:"90%"},
                    width: 880,
                    height: 440,
                    bar: {groupWidth: "35%"},
                    legend: { position: "none" },
                    axes: {
                        y: {
                            0: {side: 'left'}
                        }
                    },
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    backgroundColor: { fill: '#1d2127' },
                    vAxis: {
                        //title: 'Temperature',
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        // gridlines: {
                        //     count: 12
                        // }
                    },
                    hAxis: {
                        baselineColor: "#444851",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: '#444851',
                        }
                    }
                };

                var chart = new google.visualization.BarChart(document.getElementById("order_chart"));
                chart.draw(data, options);
            };
        };

        const fat_syn_week = () => {
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawAnnotations);

            function drawAnnotations() {
                var data = google.visualization.arrayToDataTable([
                    ['', '주문(전체)'],
                    ['일요일', 120],
                    ['월요일', 16],
                    ['화요일', 16],
                    ['수요일', 16],
                    ['목요일', 16],
                    ['금요일', 16],
                    ['토요일', 100]
                ]);

                var options = {
                    width: 880,
                    height: 440,
                    chartArea:{left:40,top:45,width:"92%",height:"80%"},
                    isStacked: true,
                    legend: { position: "none" ,textStyle: {color: '#9b9da3', fontSize: 14}},
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    series: {
                        0: { color: '#512ccb' },
                    },
                    //bar: {groupWidth: "35%"},
                    vAxis: {
                        //title: 'Temperature',
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        // gridlines: {
                        //     count: 12
                        // },
                        gridlines: {
                            color: '#2d3136',
                        }
                    },
                    backgroundColor: { fill: '#1d2127' },
                    hAxis: {
                        baselineColor: "#444851",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: '#444851',
                        }
                    },
                    hAxis: {
                        baselineColor: "red",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: 'blue',
                        }
                    }
                };


                var chart = new google.visualization.ColumnChart(document.getElementById('order_chart'));
                chart.draw(data, options);
            }
        }

        const fat_syn_time = () => {
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawAnnotations);

            function drawAnnotations() {
                var data = google.visualization.arrayToDataTable([
                    ['', '주문(전체)'],
                    ['00', 120],
                    ['02', 16],
                    ['03', 16],
                    ['04', 16],
                    ['05', 16],
                    ['06', 16],
                    ['07', 16],
                    ['08', 16],
                    ['09', 16],
                    ['10', 16],
                    ['11', 16],
                    ['12', 16],
                    ['13', 16],
                    ['14', 16],
                    ['15', 16],
                    ['16', 16],
                    ['17', 16],
                    ['18', 16],
                    ['19', 16],
                    ['20', 16],
                    ['21', 16],
                    ['22', 16],
                    ['23', 160]
                ]);

                var options = {
                    width: 880,
                    height: 440,
                    chartArea:{left:40,top:45,width:"92%",height:"80%"},
                    isStacked: true,
                    legend: { position: "top" ,textStyle: {color: '#9b9da3', fontSize: 14}},
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    series: {
                        0: { color: '#512ccb' },
                        1: { color: '#3962e6' },
                    },
                    //bar: {groupWidth: "35%"},
                    vAxis: {
                        //title: 'Temperature',
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        // gridlines: {
                        //     count: 12
                        // },
                        gridlines: {
                            color: '#2d3136',
                        }
                    },
                    backgroundColor: { fill: '#1d2127' },
                    hAxis: {
                        baselineColor: "#444851",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: '#444851',
                        }
                    },
                    hAxis: {
                        baselineColor: "red",
                        textStyle: {
                            color: '#9b9da3',
                            fontSize: 14,
                            //bold: true
                        },
                        gridlines: {
                            color: 'blue',
                        }
                    }
                };


                var chart = new google.visualization.ColumnChart(document.getElementById('order_chart'));
                chart.draw(data, options);
            }
        }

        const fat_syn_pay = () => {
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['', ''],
                    ['신용카드', 11],
                    ['실시간계좌이체', 2],
                    ['가상계좌', 2],
                    ['페이코', 2],
                ]);

                var options = {
                    width: 880,
                    height: 440,
                    backgroundColor: { fill: '#1d2127' },
                    legend: { position: "top" ,textStyle: {color: '#9b9da3', fontSize: 14}},
                    chartArea:{left:40,top:45,width:"92%",height:"80%"},
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    slices: {
                        0: { color: '#512ccb' },
                        1: { color: '#3962e6' },
                        2: { color: '#c6c6dd' },
                        3: { color: '#5ce2eb' },
                    },
                    pieSliceBorderColor: '#1d2127',
                };

                var chart = new google.visualization.PieChart(document.getElementById('order_chart'));

                chart.draw(data, options);
            }
        }

        const fat_syn_divice = () => {
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['', ''],
                    ['PC', 11],
                    ['MOBILE', 2],
                ]);

                var options = {
                    width: 880,
                    height: 440,
                    backgroundColor: { fill: '#1d2127' },
                    legend: { position: "top" ,textStyle: {color: '#9b9da3', fontSize: 14}},
                    chartArea:{left:40,top:45,width:"92%",height:"80%"},
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    slices: {
                        0: { color: '#512ccb' },
                        1: { color: '#3962e6' },
                    },
                    pieSliceBorderColor: '#1d2127',
                };

                var chart = new google.visualization.PieChart(document.getElementById('order_chart'));

                chart.draw(data, options);
            }
        }

        const fat_syn_part = () => {
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['', ''],
                    ['PC', 11],
                    ['MOBILE', 2],
                ]);

                var options = {
                    width: 880,
                    height: 230,
                    backgroundColor: { fill: '#1d2127' },
                    legend: { position: "top" ,textStyle: {color: '#9b9da3', fontSize: 14}},
                    chartArea:{left:0,top:45,width:"92%",height:"80%"},
                    animation:{
                        duration: 1000,
                        easing: 'out',
                        startup: true
                    },
                    slices: {
                        0: { color: '#512ccb' },
                        1: { color: '#3962e6' },
                    },
                    pieSliceBorderColor: '#1d2127',
                };

                var chart = new google.visualization.PieChart(document.getElementById('order_option'));

                chart.draw(data, options);
            }
        }

        const fat_syn_modal = (callback) => {
            const $target = $(".fb__fat__syn");
            $target.addClass("fb__fat__syn--show");
            return  callback();
        };



        const fat_chart_init = () => {
            fat_chart_option();
            fat_chart_date();
        };

        //fat_excel_date();

        // const fat_excel_init = () => {
        //     fat_excel_date();
        // }
        //
        // const fat_init = () => {
        //     fat_excel_init();
        //
        // };
        //
        // fat_init();
        //fat_chart_init();
        //fat_modal(fat_chart_init);
        //fat_syn_order();
        //fat_syn_modal(fat_syn_today);
        //fat_syn_part();



        $document
            .on("click", ".fb__fat .tap__list", function() {
                const $this = $(this);
                const _type = $this.attr("data-type");
                $(".fb__fat .tap__list").removeClass("tap__list--active");
                $this.addClass("tap__list--active");


                if(_type == "option") {
                    fat_chart_option();
                } else if(_type == "order") {
                    fat_chart_order();
                } else if(_type == "an") {
                    fat_chart_an();
                } else {

                }
                return false;
            })
            .on("click", "[data-fat.htm]", function() {
                const $this = $(this);
                const _ckeack = $this.attr("data-fat.htm") == "true" ? true : false;

                if(_ckeack) {
                    fat_modal(fat_chart_init);
                };

                return false;
            })
            .on("click", ".fb__fat .fat__close, .fb__fat .fat__bg", function() {
                $(".fb__fat .tap__list").removeClass("tap__list--active").eq(0).addClass("tap__list--active");
                fat_modal(fat_chart_init);
                $(".fb__fat").removeClass("fb__fat--show");
                return false;
            })
            .on("click", ".fb__fat__menu .fat__btn, .fb__fat__menu .menu__close", function() {
                $(".fb__fat__menu").toggleClass("fb__fat__menu--show");
                return false;
            })
            .on("click", ".fb__fat__menu .menu__order .excel", function() {
                $(".fb__fat__excel").toggleClass("fb__fat__excel--show");
                fat_excel_date();
                return false;
            })
            .on("click", ".fb__fat__menu .menu__order .menu__order__all", function() {
                fat_syn_modal(fat_syn_today);
                return false;
            })
            .on("click", ".fb__fat__excel .fat__close, .fb__fat__excel .fat__bg", function() {
                $(".fb__fat__excel").removeClass("fb__fat__excel--show");
                return false;
            })
            .on("click", ".fb__fat__syn  .syn__nav a", function() {
                const $this = $(this);
                $(".fb__fat__syn  .syn__nav a").removeClass("syn__nav--active");
                $this.addClass("syn__nav--active");

                $(".syn__option").removeClass("syn__option--show");
                $(`.${$this.attr("data-target")}`).addClass("syn__option--show");

                if($this.attr("data-target") == "syn__option__today") {
                    fat_syn_today();
                } else if($this.attr("data-target") == "syn__option__order") {
                    fat_syn_order();
                } else {
                    fat_syn_part();
                }

                return false;
            })
            .on("click", ".fb__fat__syn  .fat__close, .fb__fat__syn  .fat__bg", function() {
                $(".fb__fat__syn ").removeClass("fb__fat__syn--show");
                return false;
            })
            .on("click", ".fb__fat__syn .syn__order__filter a", function() {
                const $this = $(this);
                $(".fb__fat__syn .syn__order__filter a").removeClass("syn__order__filter--active");
                $this.addClass("syn__order__filter--active");
                if($this.attr("data-type") == "sexOld") {
                    fat_syn_order();
                } else if($this.attr("data-type") == "sex") {
                    fat_syn_sex();
                } else if($this.attr("data-type") == "old") {
                    fat_syn_old();
                } else if($this.attr("data-type") == "week") {
                    fat_syn_week();
                } else if($this.attr("data-type") == "time") {
                    fat_syn_time();
                } else if($this.attr("data-type") == "pay") {
                    fat_syn_pay();
                } else if($this.attr("data-type") == "divice") {
                    fat_syn_divice();
                }
                return false;
            })
    }

    //textarea 입력 글자 수
    const textarea_counting = () => {
        if ( $(".js__counting").length > 0 ) {

           $document.on("keyup", ".js__counting__textarea", function(){
               const $this = $(this);
               const $target = $this.closest(".js__counting");
               const $countingNum = $target.find(".js__counting__num");

               const _val_length = $this.val().length;
               $countingNum.html(_val_length);
           })
        }
    }

    // 메인 팝업 이벤트
    const mainPopup = () => {
        const $popupMask = $(".popup-mask");

        // $window.on("load", function () {
        //
        //     const mainPop = $("#main").children(".main_popupL");
        //
        //     if(mainPop.length >= 1){
        //         const $target = mainPop.hasClass('devForbizTpl');  // devForbizTpl : 템플릿코드 적용된 소스 display:none 처리해놓는 기능
        //
        //         mainPop.hide();
        //
        //         if($target) {
        //             $popupMask.removeClass("popup-mask--show");
        //         } else {
        //             $popupMask.addClass("popup-mask--show");
        //             $body.css({
        //                 "position": "fixed"
        //             });
        //
        //             // #6421 dim 처리 이후 팝업 뜨도록 처리
        //             setTimeout(function(){
        //                 mainPop.show();
        //             },500);
        //         }
        //     }
        // });

        $document.on("click", ".noti__popup__closebtn", function () {
            $popupMask.removeClass("popup-mask--show");
            $body.css({
                "position": ""
            });
        });

        $popupMask.on("click", function () {
            $popupMask.removeClass("popup-mask--show");
            $(".main_popupL").css({
                "display": "none",
            })
        });

        $document.on("click", "#closeToday", function () {
            const $this = $(this);
            const $closeTarget = $this.closest('.main_popupL');

            if ($this.prop('checked')) {
                $popupMask.removeClass("popup-mask--show");
                $body.css({
                    "position": ""
                });
                $closeTarget.hide();
            }
        })
    }

    // 상품상세 매장안내팝업 높이값 예외처리
    const storePopup = () => {
        const $layerPopup = $(".popup-content");
        const $storePopupInner = $layerPopup.find(".store-guide");

        if($storePopupInner.length > 0) {
            $layerPopup.css({
                "max-height" : 600,
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

        $popupBody.css('margin-top',- $popupBody.outerHeight() / 2 );

        $popup.find('.sprintAlert__btn--confirm, .sprintAlert__btn--close').on('click', function() {
            $popup.remove();
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
        if(window.location.pathname.indexOf("mypage")) {
            mypage_seacharea();
            mypage_datepicker();
            mypage_all_select();
        };
        allSelectCheckbox();
        main_menu();
        list_h();
        heart_btn();
        help_ajax(); // 도움이돼요/안돼요
        window.imageLayer_slide = imageLayer_slide; //상품상세 이미지보기레이어
        change_profile_img(); //프로필 이미지 등록 & 삭제
        main_sns();
        sport_layer(); //스포츠캠페인
        list_filter(); //상품리스트, 검색 필터
        //comon_fat();
        textarea_counting();
        mainPopup();
        storePopup();
        randomCoupon();

        window.sprintAlert = sprintAlert;
    };

    common_init();
}


export default front_common;