"use strict";

/**
 * 개발 공통
 * @type {{environment: string, regExp, util, noti, form, validation, crypto, ajax: common.ajax, lang}}
 */

var common = {
    /**
     * 개발 환경 정보 (return -> development, testing, production)
     * 사용하는 layout.htm 에 common.environment = "{c.ENVIRONMENT}"; set을함
     */
    environment: "",

    langType: "korean",

    bcscale: 0,
    /**
     * 정규식
     */
    regExp: {
        number: /[0-9]/g,
        exceptNumber: /[^0-9]/g,
        english: /[a-z]/ig,
        specialCharacters: /[!@#$%^&*\(\)_+~]/gi,
        space: /\s/,
        allowPw: /^[0-9a-zA-Z!@#$%^&*\(\)_+~\sㄱ-ㅎ|ㅏ-ㅣ|가-힣]+$/,
        email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,
        hangul: /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/g,
        mobile: /^\d{3}-\d{3,4}-\d{4}$/
    },
    math: {
        add: function (a, b) {
            return Decimal.add(a, b).toNumber();
        },
        sub: function (a, b) {
            return Decimal.sub(a, b).toNumber();
        },
        mul: function (a, b) {
            return Decimal.mul(a, b).toNumber();
        },
        div: function (a, b) {
            return Decimal.div(a, b).toNumber();
        }
    },
    util: {
        copyText: function (text, $target)
        {
            var $tempInput = $("<textarea>");
            //익스에서 스크롤이 아래로 내려가서.. 클릭하는 대상을 넘겨 옆에다가 처리
            $target.after($tempInput);
            $tempInput.val(text).select();
            document.execCommand("copy");
            $tempInput.remove();
        },
        dates: {
            convert: function (d) {
                // Converts the date in d to a date-object. The input can be:
                //   a date object: returned without modification
                //  an array      : Interpreted as [year,month,day]. NOTE: month is 0-11.
                //   a number     : Interpreted as number of milliseconds
                //                  since 1 Jan 1970 (a timestamp)
                //   a string     : Any format supported by the javascript engine, like
                //                  "YYYY/MM/DD", "MM/DD/YYYY", "Jan 31 2009" etc.
                //  an object     : Interpreted as an object with year, month and date
                //                  attributes.  **NOTE** month is 0-11.
                return (
                    d.constructor === Date ? d :
                        d.constructor === Array ? new Date(d[0], d[1], d[2]) :
                            d.constructor === Number ? new Date(d) :
                                d.constructor === String ? new Date(d) :
                                    typeof d === "object" ? new Date(d.year, d.month, d.date) :
                                        NaN
                );
            },
            compare: function (a, b) {
                // Compare two dates (could be of any type supported by the convert
                // function above) and returns:
                //  -1 : if a < b
                //   0 : if a = b
                //   1 : if a > b
                // NaN : if a or b is an illegal date
                // NOTE: The code inside isFinite does an assignment (=).
                return (
                    isFinite(a = this.convert(a).valueOf()) &&
                    isFinite(b = this.convert(b).valueOf()) ?
                        (a > b) - (a < b) :
                        NaN
                );
            },
            inRange: function (d, start, end) {
                // Checks if date in d is between dates in start and end.
                // Returns a boolean or NaN:
                //    true  : if d is between start and end (inclusive)
                //    false : if d is before start or after end
                //    NaN   : if one or more of the dates is illegal.
                // NOTE: The code inside isFinite does an assignment (=).
                return (
                    isFinite(d = this.convert(d).valueOf()) &&
                    isFinite(start = this.convert(start).valueOf()) &&
                    isFinite(end = this.convert(end).valueOf()) ?
                        start <= d && d <= end :
                        NaN
                );
            }
        },
        /**
         * getCookie
         * @param {String} cname
         * @returns {String}
         */
        getCookie: function (cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        /**
         * setCookie
         * @param {type} cName
         * @param {type} cValue
         * @param {type} cDay
         * @returns {undefined}
         */
        setCookie: function (cName, cValue, cDay) {
            var expire = new Date();
            expire.setDate(expire.getDate() + cDay);
            var cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
            if (typeof cDay != 'undefined')
                cookies += ';expires=' + expire.toGMTString() + ';';
            document.cookie = cookies;
        },
        /**
         * php 컨트롤 url 정보 가지고 오기
         * @param methodName
         * @param className
         * @returns {string}
         */
        getControllerUrl: function (methodName, className) {
            return "/controller/" + className + "/" + methodName;
        },
        /**
         * javascript null 체크
         * @param value
         */
        isNull: function (value) {
            return ((typeof value != "boolean" && value == "") || value == null || typeof value == 'undefined' || (value != null && typeof value == "object" && !Object.keys(value).length) ? true : false);
        },
        /**
         * 팝업
         * @param path
         * @param width
         * @param height
         * @param name
         * @param scroll
         * @returns {Window}
         */
        popup: function (path, width, height, name, scroll) {
            scroll = this.isNull(scroll) ? false : scroll;
            var winl = (screen.width - width) / 2;
            var wint = (screen.height - height) / 2;
            var winprops = 'height=' + height + ',width=' + width + ',top=' + wint + ',left=' + winl + ',scrollbars=' + (scroll ? 'yes' : 'no') + ',menubar=no,status=no,toolbar=no,resizable=no';
            return window.open(path, name, winprops);
        },
        /**
         * 모달
         */
        modal: {
            /**
             * 진행중 상태 bool
             * @type Boolean
             */
            _ingBool: false,
            /**
             * 모달 보여주기
             */
            _show: function () {
                common.util.modal._ingBool = false;
                //퍼블쪽에서 만든 스크립트 실행
                popup_customer();
            },
            /**
             * 모달 닫기
             */
            close: function () {
                $('.popup-layout .close').trigger('click');
            },
            /**
             * 모달 열기
             * @param type
             * @param title
             * @param parameter1
             * @param parameter2
             */
            open: function (type, title, parameter1, parameter2, completeFunction, _target) {
                var target = _target ? _target : "";
                if (!common.util.modal._ingBool) {
                    common.util.modal._ingBool = true;
                    parameter2 = common.util.isNull(parameter2) ? '' : parameter2;
                    //패딩값 없어야해서 퍼블에서 추가
                    if (title == "Best Pick 보기" || title == "포토/동영상" || title == "쿠폰 다운로드" || title == "1:1 문의 내역" || title == "비밀번호 변경") {
                        $("#devModalContent").css({
                            "padding-top" : 0
                        })
                    };


                    $('#devModalTitle').text(title);

                    var $modalContent = $('#devModalContent');
                    $modalContent.empty();

                    if (type == 'html') {
                        $modalContent.append(parameter1.clone(true));
                        common.util.modal._show();
                        if (typeof completeFunction === "function") {
                            completeFunction();
                        }
                    } else {
                        common.ajax(parameter1, parameter2, '', (function (response) {
                            $modalContent.attr("data-visible", !!target)
                            if(!!target) {
                                $modalContent.attr("data-target", target)
                            }
                            $modalContent.append(response);
                            common.util.modal._show();
                            if (typeof completeFunction === "function") {
                                completeFunction();
                            }
                            $('.popup-content img[data-src]').lazy({
                                appendScroll: $('.popup-content')
                            });
                            imageLayer_slide(); //상품상세- 포토후기- 이미지보기 레이어 팝업 slick함수실행

                        }), 'html');
                    }
                }
            }
        },
        /**
         * 주소찾기
         */
        zipcode: {
            callback: false, //response = {zipcode: "000000", address1: "주소"}
            /**
             * 팝업 열기
             * @param callback
             */
            popup: function (callback) {
                this.callback = callback;
                common.util.popup('/popup/zipcode', 422, 607, 'zipcode', false);
            }
        },
        /**
         * 요소의 성격에 따라 포커스 이동
         * @param element
         */
        focus: function (element) {
            if (common.util.getElementInputType(element) == 'select') {
                var offset = $(element).offset();
                $('html, body').animate({scrollTop: offset.top - 200}, 0);
            } else {
                $(element).focus();
            }
        },
        /**
         * element 의 태그명과 타입에 따라서 결과 리턴
         * @param element
         * @returns {*} select, checkbox, text
         */
        getElementInputType: function (element) {
            if (element.tagName.toLowerCase() == "select") {
                return "select";
            } else if (element.tagName.toLowerCase() == "input" && element.type == "checkbox") {
                return "checkbox";
            } else if (element.tagName.toLowerCase() == "input" && element.type == "radio") {
                return "radio";
            } else if (element.tagName.toLowerCase() == "input" && (element.type == "text" || element.type == "number" || element.type == "password" || element.type == "hidden")) {
                return "text";
            } else if (element.tagName.toLowerCase() == "input" && element.type == "file") {
                return "file";
            } else if (element.tagName.toLowerCase() == "textarea") {
                return "textarea";
            }
        },
        /**
         * 이미지 미리보기
         * @param $image
         * @param $file
         */
        previewFile: function ($file, $image) {
            var file = $file.get(0).files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                $image.attr('src', e.target.result);
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        },
        /**
         * Get template
         * @param $selector
         * @returns {jQuery}
         */
        getTpl: function ($selector) {
            var html = $($selector).clone().removeAttr('id').removeClass('devForbizTpl').wrapAll("<div/>").parent().html();
            return html.replace(/\{\[/g, '{{').replace(/\]\}/g,'}}');
        },
        /**
         * number format
         * @param {type} number
         * @param {type} decimals
         * @param {type} decPoint
         * @param {type} thousandsSep
         * @returns {unresolved}
         */
        numberFormat: function (number, decimals, decPoint, thousandsSep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? common.bcscale : Math.abs(decimals),
                sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep,
                dec = (typeof decPoint === 'undefined') ? '.' : decPoint,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + (Math.round(n * k) / k)
                            .toFixed(prec);
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
                .split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '')
                    .length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1)
                    .join('0');
            }
            return s.join(dec);
        },
        /**
         * 파라미터 가지고 오는 함수
         * @param {type} name
         * @param {type} url
         * @returns {String}
         */
        getParameterByName: function (name, url) {
            if (!url)
                url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results)
                return null;
            if (!results[2])
                return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        },
        /**
         * 우측문자열채우기
         * @params
         *  - padLen : 최대 채우고자 하는 길이
         *  - padStr : 채우고자하는 문자(char)
         */
        rpad : function (str, padLen, padStr) {
            if (padStr.length > padLen) {
                return str + "";
            }
            str += ""; // 문자로
            padStr += ""; // 문자로
            while (str.length < padLen)
                str += padStr;
            str = str.length >= padLen ? str.substring(0, padLen) : str;
            return str;
        },
        /**
         * 좌측문자열채우기
         * @params
         *  - str : 원 문자열
         *  - padLen : 최대 채우고자 하는 길이
         *  - padStr : 채우고자하는 문자(char)
         */
        lpad : function(str, padLen, padStr) {
            if (padStr.length > padLen) {
                return str;
            }
            str += ""; // 문자로
            padStr += ""; // 문자로
            while (str.length < padLen)
                str = padStr + str;
            str = str.length >= padLen ? str.substring(0, padLen) : str;
            return str;
        }
    },
    /**
     * 알림
     */
    noti: {
        /**
         * @param txt
         */
        alert: function (txt, callback) {
            alert(txt);
            if (typeof callback === "function") {
                callback();
            }
        },
        /**
         * @param message
         * @param okCallback
         * @param cancelCallback
         */
        confirm: function (message, okCallback, cancelCallback) {
            if (confirm(message)) {
                if (typeof okCallback === "function") {
                    okCallback();
                }

                return true;
            } else {
                if (typeof cancelCallback === "function") {
                    cancelCallback();
                }

                return false;
            }
        },
        /**
         * 인풋 박스 아래 text 노출
         * devTailMsg="element.id" 에 해당하는 영역에 message 노출
         * type basic|error|success
         * @param attributeTailMsgVal
         * @param message
         * @param type
         */
        tailMsg: function (attributeTailMsgVal, message, type) {
            message = common.util.isNull(message) ? '' : message;
            type = common.util.isNull(type) ? 'error' : type;
            var cssClass = '';
            if (type == 'basic')
                cssClass = 'txt-guide';
            else if (type == 'success')
                cssClass = 'txt-success';
            else
                cssClass = 'txt-error';
            $('[devTailMsg~=' + attributeTailMsgVal + ']').attr('class', cssClass).html(message);
        },
        /**
         * common.environment 가 development 일떄만 로그 보임
         * @param message
         * @param type (log, warn, error)
         */
        log: function (message, type) {
            type = common.util.isNull(type) ? 'log' : type;
            if (common.environment == 'development') {
                if (!window.console) {
                    eval('var console =  {"' + type + '": function() {} }');
                }
                eval('console.' + type + '("' + message + '")');
            }
        },
        popup: {
            layerPopupTpl: false,
            compileLayerPopup: function () {
                if (common.noti.popup.layerPopupTpl === false) {
                    var selector = '#devNotiPopupTpl';
                    common.noti.popup.layerPopupTpl = Handlebars.compile(common.util.getTpl(selector));

                    $(selector).remove();

                    // 프론트엔드팀 코드 추가 >> 메인에서 팝업뜰때 배경 dim 처리
                    if(document.getElementById('main')){
                        $(".popup-mask").addClass("popup-mask--show");
                        $("body").css({
                            "position" : "fixed",
                        });
						/* 찹업노출 확인*/
						$(".main_popupL").show();
						/* 찹업노출 확인*/
                    }
                }
            },
            showLayerPopupData: function (data) {
                var html = common.noti.popup.layerPopupTpl(data);
				if(document.getElementById('main')){
					$(html).appendTo('body').css({left: data.popup_left + "px", top: data.popup_top + "px"});
					/* 찹업노출 확인*/
					$(".main_popupL").show();
					/* 찹업노출 확인*/
				}

            },
            getCookieKey: function (popupIx) {
                return 'notiPopup' + popupIx;
            },

            load: function (datas) {
				$.each(datas, function (i, data) {
					if (common.util.getCookie(common.noti.popup.getCookieKey(data.banner_ix)) != '1') {
						if (i == 0){
							var url = '/popup/noti/' + data.banner_ix;
							common.noti.popup.compileLayerPopup();
							common.ajax(url, {}, '', (function (response) {
								data['popup_text'] = response;
								common.noti.popup.showLayerPopupData(data);
							 }), 'html');
						}
					}
                })
            },
            close: function (popupType, popupIx) {
                //쿠키 관련 set 처리
                if ($('.devPopupToday[devPopupIx=' + popupIx + ']:checked').length > 0) {
                    common.util.setCookie(common.noti.popup.getCookieKey(popupIx), '1', 1);
                }
                if (popupType == 'L') { //레이어 POPUP
                    $(".main_popupL").hide();
					//$('.devNotiPopup[devPopupIx=' + popupIx + ']').remove();
                } else {
                    window.close();
                }
            }
        }
    },
    /**
     * 데이터 입력 포멧 제어
     */
    inputFormat: {
        /**
         * format set
         * number = true
         * maxLength = 20
         * fileFormat = image
         * devFileSize = 30 (메가바이트)
         * @param $element
         * @param setData
         */
        set: function ($element, setData) {
            setData = common.util.isNull(setData) ? {} : setData;
            if (setData['number'] == true) {
                $element.attr('devNumber', true);
            }
            if (typeof setData['maxLength'] != 'undefined' && setData['maxLength'] != '') {
                $element.attr('devMaxLength', setData['maxLength']);
            }
            if (typeof setData['fileFormat'] != 'undefined' && setData['fileFormat'] != '') {
                $element.attr('devFileFormat', setData['fileFormat']);
            }
            if (typeof setData['fileSize'] != 'undefined' && setData['fileSize'] != '') {
                $element.attr('devFileSize', setData['fileSize']);
            }
        },
        /**
         * evnet bind
         */
        eventBind: function () {
            //number
            $(document).on({
                'input': function (e) {
                    this.value = this.value.replace(common.regExp.exceptNumber, '');
                }
            }, 'input[devNumber]');
            //maxLength
            $(document).on({
                'input': function (e) {
                    var maxLength = $(this).attr('devMaxLength');
                    if (maxLength && this.value.length > maxLength) {
                        this.value = this.value.slice(0, maxLength);
                    }
                }
            }, 'input[devMaxLength]');
            //fileFormat
            $(document).on({
                'change': function (e) {
                    if (this.files.length > 0) {
                        var file = this.files[0];
                        if (file.type.search('image') < 0) {
                            this.value = null;
                            $(this).trigger('change');
                            common.noti.alert(common.lang.get('common.inputFormat.fileFormat.fail'));
                        }
                    }
                }
            }, 'input[devFileFormat=image]');
            //fileSize
            $(document).on({
                'change': function (e) {
                    if (this.files.length > 0) {
                        var file = this.files[0];
                        var fileSize = $(this).attr('devFileSize');
                        //file.size (바이트), fileSize (메가바이트)
                        if (file.size > fileSize * 1048576) {
                            this.value = null;
                            $(this).trigger('change');
                            common.noti.alert(common.lang.get('common.inputFormat.fileSize.fail', {'size': fileSize}));
                        }
                    }
                }
            }, 'input[devFileSize]');
        }
    },
    ajaxManager: {
        activeStatus: true,
        deActive: function(){
            var self = common.ajaxManager;
            self.activeStatus = false;
            return common;
		},
		active: function(){
			var self = common.ajaxManager;
			self.activeStatus = true;
			return common;
		},
        eventCalback: {
            allFinish: false
        },
        reqCnt: 0,
        on: function (eventType, func) {
            var self = common.ajaxManager;

            if ($.isFunction(func)) {
                self.eventCalback[eventType] = func;
            }

            return self;
        },
        inc: function () {
            var self = common.ajaxManager;

            if (self.activeStatus === true && self.reqCnt == 0 && $.isFunction(self.eventCalback.allFinish) === false && typeof dev_fat2 !== 'undefined') {
                self.on('allFinish', dev_fat2.initStat);
            }
            
            self.reqCnt++;

            return self;
        },
        dec: function () {
            var self = common.ajaxManager;
            self.reqCnt--;

            if (self.reqCnt == 0 && $.isFunction(self.eventCalback.allFinish)) {
                self.eventCalback.allFinish();
                self.eventCalback.allFinish = false;
                self.activeStatus = true;
            }

            return self;
        }
    },
    /**
     * form
     */
    form: {
        /**
         * form 에 ajaxForm 스크립트 set
         * @param $form
         * @param url
         * @param beforeCallback
         * @param successCallback
         */
        init: function ($form, url, beforeCallback, successCallback) {
            (function () {
                /**
                 * submit 진행 여부 (중복 액션 막기 위한 플레그)
                 * @type {boolean}
                 */
                var _ingSubmit = false;

                $form.attr('action', url);
                // CSRF 로직 추가
                $('<input>').attr({
                    type: 'hidden',
                    name: forbizCsrf.name,
                    class: 'clsForbizCsrfId'
                }).appendTo($form);

                $form.ajaxForm({
                    method: 'post',
                    beforeSerialize: function ($form, options) {
                        $('.clsForbizCsrfId').val(common.util.getCookie('ForbizCsrfCookieName'));
                    },
                    beforeSubmit: function () {
                        common.ajaxManager.inc();
                        
                        if (_ingSubmit) {
                            // common.noti.alert('ajaxForm 처리중입니다.');
                            console.log('ajaxForm 처리중입니다.');
                            return false;
                        }
                        _ingSubmit = true;
                        if (typeof beforeCallback === "function") {
                            if (beforeCallback($form)) {
                                return true;
                            } else {
                                _ingSubmit = false;
                                return false;
                            }
                        } else {
                            return true;
                        }
                    },
                    success: function (response, status) {
                        //성공후 서버에서 받은 데이터 처리
                        if (typeof successCallback === "function") {
                            successCallback(response);
                            lazyload(); //프론트엔드에서 추가
                        }
                        _ingSubmit = false;
                    },
                    error: function (xhr) {
                        _ingSubmit = false;
                        if (xhr.status == 403) {
                            $form.submit();
                        }
                    },
                    complete: function () {
                        forbizCsrf.hash = common.util.getCookie('ForbizCsrfCookieName');
                        common.ajaxManager.dec();
                    }
                });
            }());
        }
    },
    /**
     * 유효성
     * 'required': true (필수)
     * 'requiredMessageTag' : common.lang.get("joinAgreement.required.message") (노출 언어 지정)
     * 'dataFormat' : 'userPassword' (회원 비밀번호), 'userId' (회원 아이디), 'companyNumber'(사업자 번호), 'email' (이메일)
     * 'compare': '#devUserPassword' (값 동일 체크 대상 jQuery 선택자 입력)
     * 'getValueFunction' : function (input 값을 조합해서 체크해야할때 사용)
     */
    validation: {
        /**
         * 유효성 체크 하기 위한 attribute명
         * @type {string}
         */
        _validationAttributeName: 'devValidation',
        /**
         * element 의 이름을 가지고 오기위한 attribute명
         * @type {string}
         */
        _titleAttributeName: 'title',
        /**
         * element에 유효성 체크 규칙 적용
         * @param $element
         * @param setData
         */
        set: function ($element, setData) {
            setData = common.util.isNull(setData) ? {} : setData;
            $element.attr(this._validationAttributeName, JSON.stringify(setData));
        },
        /**
         * 해당 $object 에 유효성 적용된 elemnet 모두 체크
         * @param $object
         * @returns {boolean}
         */
        check: function ($object, notiType, betch) {
            notiType = common.util.isNull(notiType) ? 'tailMsg' : notiType;
            betch = (betch !== false && common.util.isNull(betch)) ? true : betch;
            var result = true;
            var first = true;
            var $target = $.merge($object.find('[' + this._validationAttributeName + ']'), $object.filter('[' + this._validationAttributeName + ']'));
            $target.each(function (i, elemnet) {
                var re = common.validation.checkElement(elemnet);
                if (!re.success) {
                    if (notiType == 'alert')
                        common.noti.alert(re.message);
                    else
                        common.noti.tailMsg(elemnet.id, re.message);
                    result = false;
                    if (first) {
                        common.util.focus(elemnet);
                        first = false;
                        if (!betch) {
                            return false;
                        }
                    }
                } else {
                    if (notiType == 'tailMsg') {
                        common.noti.tailMsg(elemnet.id);
                    }

                }
            });
            return result;
        },
        /**
         * element 에 적용된 유효성 체크
         * @param element
         * @returns {{success, message}}
         */
        checkElement: function (element) {
            //초기화
            var result = this._returnStructure(true);
            var $element = $(element);
            var setData = JSON.parse($element.attr(this._validationAttributeName));
            var title = $element.attr(this._titleAttributeName);

            var value = $element.val().trim();
            if (typeof setData['getValueFunction'] != 'undefined' && setData['getValueFunction'] != '') {
                value = eval(setData['getValueFunction'] + '()');
            }

            //필수
            if (setData['required'] == true) {
                var elementType = common.util.getElementInputType(element);
                var requiredMessageTag = (typeof setData['requiredMessageTag'] != 'undefined' && setData['requiredMessageTag'] != ''
                    ? setData['requiredMessageTag'] : "");
                var messageTag = "";
                switch (elementType) {
                    case "select":
                    case "text":
                    case "textarea":
                    case "file":
                        if (!(value.length > 0)) {
                            switch (common.util.getElementInputType(element)) {
                                case "select":
                                    messageTag = (requiredMessageTag != '' ? requiredMessageTag : "common.validation.required.select");
                                    return this._returnStructure(false, common.lang.get(messageTag, {'title': title}));
                                    break;
                                case "text":
                                case "textarea":
                                    messageTag = (requiredMessageTag != '' ? requiredMessageTag : "common.validation.required.text");
                                    return this._returnStructure(false, common.lang.get(messageTag, {'title': title}));
                                    break;
                                case "file":
                                    messageTag = (requiredMessageTag != '' ? requiredMessageTag : "common.validation.required.file");
                                    return this._returnStructure(false, common.lang.get(messageTag, {'title': title}));
                                    break;
                            }
                        }
                        break;
                    case "checkbox":
                        if (!($('input[type=checkbox][name="' + $element.attr('name') + '"]:checked').length > 0)) {
                            messageTag = (requiredMessageTag != '' ? requiredMessageTag : "common.validation.required.checkbox");
                            return this._returnStructure(false, common.lang.get(messageTag, {'title': title}));
                        }
                        break;
                    case "radio":
                        if (!($('input[type=radio][name="' + $element.attr('name') + '"]:checked').length > 0)) {
                            messageTag = (requiredMessageTag != '' ? requiredMessageTag : "common.validation.required.checkbox");
                            return this._returnStructure(false, common.lang.get(messageTag, {'title': title}));
                        }
                        break;
                }
            }
            //회원 비밀번호
            if (setData['dataFormat'] == 'userPassword') {
                var num = value.search(common.regExp.number);
                var eng = value.search(common.regExp.english);
                var spe = value.search(common.regExp.specialCharacters);
                var space = value.search(common.regExp.space);
                var hangul = value.search(common.regExp.hangul);
                var checkItemCnt = 0;
                if (num < 0 ) {
                    checkItemCnt++;
                }
                if(eng < 0 ){
                    checkItemCnt++;
                }
                if(spe < 0){
                    checkItemCnt++;
                }

                if (value.length < 8 || value.length > 16) {
                    return this._returnStructure(false, common.lang.get("common.validation.userPassword.fail"));
                }
                if(value.replace(common.regExp.allowPw,"")){
                    return this._returnStructure(false, common.lang.get("common.validation.userPasswordSpecialChracter.fail"));
                }
                if (hangul != -1) {
                    return this._returnStructure(false, common.lang.get("common.validation.userPassword.space"));
                }
                if (space != -1) {
                    return this._returnStructure(false, common.lang.get("common.validation.userPassword.space"));
                }

                if (checkItemCnt > 1) {
                    return this._returnStructure(false, common.lang.get("common.validation.userPassword.fail"));
                }

				if ($('#devUserId').val() && ($('#devUserPassword').val() == $('#devUserId').val())) {
					return this._returnStructure(false, common.lang.get("common.validation.userPassword.fail1"));
				}
            }
            //회원 아이디
            if (setData['dataFormat'] == 'userId') {
                var remainStr = value.replace(common.regExp.number, '');
                // 1. 숫자만 존재시
                if (remainStr.length == 0) {
                    return this._returnStructure(false, common.lang.get("common.validation.userId.fail"));
                }
                var remainStr = value.replace(common.regExp.number, '').replace(common.regExp.english, '');
                // 2. 6자 미만, 20자 초과 일시
                if (value.length < 6 || value.length > 20) {
                    return this._returnStructure(false, common.lang.get("common.validation.userId.fail"));
                }
                // 3.영문 숫자외 문자가 존재 시
                if (remainStr.length > 0) {
                    return this._returnStructure(false, common.lang.get("common.validation.userId.fail"));
                }
            }
            //사업자 번호
            if (setData['dataFormat'] == 'companyNumber') {
                // bizID는 숫자만 10자리로 해서 문자열로 넘긴다.
                var checkID = new Array(1, 3, 7, 1, 3, 7, 1, 3, 5, 1);
                var tmpBizID, i, chkSum = 0, c2, remander;
                value = value.replace(/-/gi, '');

                for (i = 0; i <= 7; i++)
                    chkSum += checkID[i] * value.charAt(i);
                c2 = "0" + (checkID[8] * value.charAt(8));
                c2 = c2.substring(c2.length - 2, c2.length);
                chkSum += Math.floor(c2.charAt(0)) + Math.floor(c2.charAt(1));
                remander = (10 - (chkSum % 10)) % 10;

                if (Math.floor(value.charAt(9)) != remander) {
                    return this._returnStructure(false, common.lang.get("common.validation.companyNumber.fail"));
                }
            }
            //주민 번호
            if (setData['dataFormat'] == 'juminNumber') {
                //주민등록 번호 13자리를 검사한다.
                var fmt = /^\d{6}[1234]\d{6}$/;  //포멧 설정
                if (!fmt.test(value)) {
                    return this._returnStructure(false, common.lang.get("common.validation.juminNumber.fail"));
                }
                // 생년월일 검사
                var birthYear = (value.charAt(6) <= "2") ? "19" : "20";
                birthYear += value.substr(0, 2);
                var birthMonth = value.substr(2, 2) - 1;
                var birthDate = value.substr(4, 2);
                var birth = new Date(birthYear, birthMonth, birthDate);
                if ( birth.getYear() % 100 != value.substr(0, 2) || birth.getMonth() != birthMonth || birth.getDate() != birthDate) {
                    return false;
                }
                // Check Sum 코드의 유효성 검사
                var buf = new Array(13);
                for (var i = 0; i < 13; i++) buf[i] = parseInt(value.charAt(i));
                var multipliers = [2,3,4,5,6,7,8,9,2,3,4,5];
                for (var sum = 0, i = 0; i < 12; i++) sum += (buf[i] *= multipliers[i]);
                if ((11 - (sum % 11)) % 10 != buf[12]) {
                    return this._returnStructure(false, common.lang.get("common.validation.juminNumber.fail"));
                }

            }
            //email
            if (setData['dataFormat'] == 'email') {
                if (!common.regExp.email.test(value)) {
                    return this._returnStructure(false, common.lang.get("common.validation.email.fail"));
                }
            }
            //값 비교
            if (typeof setData['compare'] != 'undefined' && setData['compare'] != '') {
                if (value != $(setData['compare']).val()) {
                    var title = $(setData['compare']).attr(this._titleAttributeName);
                    return this._returnStructure(false, common.lang.get("common.validation.compare.fail", {'title': title}));
                }
            }
            // 모바일폰
            if (setData['dataFormat'] == 'mobile') {
                if (!common.regExp.mobile.test(value)) {
                    return this._returnStructure(false, common.lang.get("common.validation.mobile.fail", {'title': title}));
                }
            }
            //성공
            return result;
        },
        /**
         * 유효성 결과 구조
         * @param success
         * @param message
         * @returns {{success: *, message: *}}
         */
        _returnStructure: function (success, message) {
            message = common.util.isNull(message) ? "" : message;
            return {'success': success, 'message': message};
        }
    },
    /**
     * 암호화
     */
    crypto: {
        /**
         * md5 라이브러리는 library.js 에 있음
         * @param str
         * @returns {string|*}
         */
        md5: function (str) {
            return CryptoJS.MD5(str).toString();
        }
    },
    /**
     * ajax
     * @param url
     * @param data
     * @param beforeCallback
     * @param successCallback
     * @param async
     */
    ajax: function (url, data, beforeCallback, successCallback, dataType, async) {
        dataType = common.util.isNull(dataType) ? "json" : dataType;
        async = common.util.isNull(async) ? true : async;
        data = typeof data !== 'object' ? {tmpData: data} : data;

        // csrf 처리
        data[forbizCsrf.name] = common.util.getCookie('ForbizCsrfCookieName');

        $.ajax({
            type: 'post',
            data: data,
            url: url,
            dataType: dataType,
            async: async,
            beforeSend: function () {
                common.ajaxManager.inc();
                if (typeof beforeCallback === "function") {
                    return beforeCallback();
                } else {
                    return true;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
            success: function (data) {
                if (typeof successCallback === "function") {
                    successCallback(data);

                }
            },
            complete: function () {
                forbizCsrf.hash = common.util.getCookie('ForbizCsrfCookieName');
                common.ajaxManager.dec();
            }
        });
    },
    /**
     * language
     */
    lang: {
        /**
         * 공통 치환 리스트 정의
         * @type {{[common.lineBreak]: string}}
         */
        _commonChangeStrList: {'common.lineBreak': '\n'},
        /**
         * ENVIRONMENT 가 development 때 사용 layout.htm 에 load 된 언어를 서버쪽으로 보내기 위한 저장소
         * @type {{}}
         */
        _storage: {},
        /**
         * tag 를 키로 언어 데이터를 storage 에 저장함
         * js 파일에 먼저 명시 하여 번역 데이터 관리하기 위해 만들어짐
         * @param tag
         * @param basicStr
         * @param key
         */
        load: function (tag, basicStr, key) {
            key = common.util.isNull(key) ? "" : key;
            if (key == '') {
                key = common.crypto.md5(basicStr);
            }
            var transStr = this._getTransStr(key);
            var text = (typeof transStr !== 'undefined' && transStr != '' ? transStr : basicStr);
            this._storage[tag] = {'key': key, 'text': text};
        },
        /**
         * load 된 언어 정보를 가지고 오기
         * @param tag
         * @param changeStr
         * @returns {string}
         */
        get: function (tag, changeStr) {
            changeStr = common.util.isNull(changeStr) ? {} : changeStr;
            var returnStr = '';
            if (typeof this._storage[tag] == 'undefined') {
                common.noti.log('js lang no load [' + tag + "]", 'error');
            } else {
                returnStr = this._storage[tag].text;
            }
            if (typeof this._commonChangeStrList == "object" && typeof returnStr !== 'undefined') {
                for (var search in this._commonChangeStrList) {
                    returnStr = common.lang._replace(search, this._commonChangeStrList[search], returnStr);
                }
            }
            if (typeof changeStr == "object" && typeof returnStr !== 'undefined') {
                for (var search in changeStr) {
                    returnStr = common.lang._replace(search, changeStr[search], returnStr);
                }
            }
            return returnStr;
        },
        /**
         * 정규식으로 replace 처리 특수문자를 처리
         * @param searchStr
         * @param replaceStr
         * @param str
         * @returns {XML|void|string}
         */
        _replace: function (searchStr, replaceStr, str) {
            var re = eval('/\\{' + searchStr + '\\}/g');
            return str.replace(re, replaceStr);
        },
        /**
         * 사용 layout.htm 에 _LANGUAGE 변수로 된 현재 사용언어 번역 데이터에서 trans_key로 가지고 오기
         * @param key
         * @returns {*}
         */
        _getTransStr: function (key) {
            return _LANGUAGE[key];
        },
        /**
         * ENVIRONMENT 가 development 때 사용 layout.htm 맨 마지막에 load 된 데이터를 서버에 요청
         */
        jsLanguageCollection: function () {
            common.ajax(common.util.getControllerUrl('jsLanguageCollection', 'global'), {'storage': JSON.stringify(this._storage)});
        }
    },
    /**
     * 회원 인증
     */
    certify: {
        _success: null,
        /**
         * 기본 인증 실패할때
         * @param message
         */
        _fail: function (message) {
            common.noti.alert(message);
        },
        /**
         * 인증 응답
         * @param result
         * @param message
         * @param data
         */
        response: function (result, message, data) {
            if (result) {
                if (typeof this._success === "function") {
                    this._success(data);
                }
            } else {
                this._fail(message);
            }
        },
        /**
         * 인증 수단 요청
         * @param type
         */
        request: function (type) {
            if (type == 'certify') {
                common.util.popup('/member/cretify/request/certify', 500, 500, 'cretify');
            } else if (type == 'ipin') {
                common.util.popup('/member/cretify/request/ipin', 500, 500, 'cretify');
            }
        },
        /**
         * 인증 성공시 처리 set
         * @param successFunction
         */
        setSuccess: function (successFunction) {
            this._success = successFunction;
        },
        /**
         * 인증 실패시 처리 set
         * @param failFunction
         */
        setFail: function (failFunction) {
            this._fail = failFunction;
        }
    },
    /**
     * 페이징
     */
    pagination: {
        pagingTpl: [
            '<div class="wrap-pagination">',
            '<button class="prev btn-pagination-prev devPageBtnCls" data-page="{[underPageNum]}" {[#if underPageNumDisable]}disabled{[/if]}><i class="ico ico-arrow-left">under</i></button>',
			'<button class="prev btn-pagination-prev devPageBtnCls on" data-page="{[firstPageNum]}" {[#if firstPageNumDisable]}disabled{[/if]}><a href="javascript:void(0);">{[firstPageNum]}</a><div class="fb__bubble"><a href="javascript:void(0);">...</a><</button>',
            '{[{pageNumList}]}',
            '<button class="next btn-pagination-next devPageBtnCls" data-page="{[lastPageNum]}" {[#if lastPageNumDisable]}disabled{[/if]}><a href="javascript:void(0);">...</a><a href="javascript:void(0);">{[lastPageNum]}</a><div class="fb__bubble"></button>',
            '<button class="next btn-pagination-next devPageBtnCls" data-page="{[nextPageNum]}" {[#if nextPageNumDisable]}disabled{[/if]}><i class="ico ico-arrow-right">next</i></button>',
            '</div>'
        ],
        pageNumTpl: '<a href="javascript:void(0)" class="devPageBtnCls {[pageOn]}" data-page="{[pageNum]}">{[pageNum]}</a>',
        getHtml: function (data)
        {
			//console.log(data);

            if (typeof data.page_list !== 'undefined') {
                var pagingHtml = [];
                var pageNum = Handlebars.compile(this.pageNumTpl);
                var paging = Handlebars.compile(this.pagingTpl.join(''));
				if(data.page_list.length > 10){
					//data.page_list.length = 10;
				}
                for (var i = 0; i < data.page_list.length; i++) {
                    pagingHtml.push(pageNum({
                        pageNum: data.page_list[i],
                        pageOn: (data.cur_page == data.page_list[i] ? 'on' : '')
                    }));
                }

                return paging({
                    firstPageNum: data.first_page
                    , firstPageNumDisable: (data.cur_page != data.first_page && data.last_page > 10 ? false : true)
                    , underPageNum: data.prev_page
                    , underPageNumDisable: (data.cur_page != data.prev_page && data.last_page > 10 ? false : true)
                    , pageNumList: pagingHtml.join('')
                    , nextPageNum: data.next_page
                    , nextPageNumDisable: (data.cur_page != data.next_page  && data.last_page > 10 ? false : true)
                    , lastPageNum: data.last_page
                    , lastPageNumDisable: (data.cur_page != data.last_page  && data.last_page > 10 ? false : true)
                });
            } else {
                return '';
            }
        }
    },
    /**
     * ajaxList
     */
    ajaxList: function () {
        return {
            container: '',
            containerType: 'table',
            pagination: '',
            pageNum: '#devPage',
            listTpl: '',
            emptyTpl: '',
            loadingTpl: '',
            formObj: '',
            utl: '',
            topPosition: 0,
            onLoading: false,
            useHash: true,
            useGotoTop: false,
            changeSearch: false,
            validName: function (name) {
                switch (name) {
                    case 'max':
                    case 'page':
                    case 'ForbizCsrfTestName':
                        return false;
                        break;
                }

                return true;
            },
            getHash: function (page) {
                var tail = [];
                var self = this;

                $.each(self.formObj.serializeArray(), function (idx, field) {
                    if (self.validName(field.name) && field.value) {
                        tail.push(field.name + '=' + escape(field.value));
                    }
                });

                return '#page' + page + '&' + tail.join('&');
            },
            parseHash: function () {
                var self = this;
                var query = location.hash.substr(1).split('&');

                self.changeSearch = false;

                if (query.length > 0) {
                    $.each(query, function (idx, part) {
                        if (part.indexOf('=') > 0) {
                            var item = part.split("=");

                            if (self.validName(item[0])) {
                                var el = self.formObj.find('[name=' + item[0] + ']');

                                item[1] = unescape(item[1]);
                                if (el.length > 0 && el.val() != item[1]) {
                                    el.val($.trim(item[1]));
                                    self.changeSearch = true;
                                }
                            }
                        }
                    });
                }
            },
            gotoTop: function () {
                $('html, body').animate({scrollTop: this.topPosition}, 0);
            },
            beforCallback: function () {
                return true;
            },
            successCallback: function () {
                return false;
            },
            compileTpl: function (tplId) {
                try {
                    var tplObj = Handlebars.compile(common.util.getTpl(tplId));
                    $(tplId).remove();
                    return tplObj;
                } catch (e) {
                    alert("Not define ForbizTpl [" + tplId + "]");
                }
            },
            setRemoveContent: function (remove) {
                this.remove = remove;

                return this;
            },
            setListTpl: function (tpl) {
                this.listTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setEmptyTpl: function (tpl) {
                this.emptyTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setLoadingTpl: function (tpl) {
                this.loadingTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setGotoTop: function (topPosition) {
                if (topPosition || topPosition === 0) {
                    this.topPosition = topPosition;
                    this.useGotoTop = true;
                } else {
                    this.topPosition = 0;
                    this.useGotoTop = false;
                }

                return this;
            },
            setForm: function (formId) {
                this.formObj = $(formId);
                return this;
            },
            setContainer: function (containerId) {
                this.container = containerId;
                return this;
            },
            setPagination: function (paginationId) {
                this.pagination = paginationId;
                return this;
            },
            setPageNum: function (pageNum) {
                this.pageNum = pageNum;
                return this;
            },
            setContainerType: function (containerType) {
                this.containerType = containerType;
                return this;
            },
            setController: function (methodName, controllerName) {
                this.url = common.util.getControllerUrl(methodName, controllerName);
                return this;
            },
            setContent: function (list, paging) {
                if (this.remove === true || !paging || paging.cur_page == 1) {
                    this.removeContent();
                }
                if (list.length > 0) {
                    for (var i = 0; i < list.length; i++) {
                        var row = list[i];
//console.log(row)
                        $(this.container).append(this.listTpl(row));
                    }

                    if (paging) {
                        $(this.pagination).html(common.pagination.getHtml(paging));
                    }
                } else {
                    $(this.container).append(this.emptyTpl());
                }
            },
            setUseHash: function (useHash) {
                if (useHash === true) {
                    this.useHash = true;
                } else {
                    this.useHash = false;
                }

                return this;
            },
            removeContent: function () {
                if (this.containerType == 'table') {
                    $(this.container + ' > tr').remove();
                } else {
                    $(this.container).empty();
                }

                $(this.pagination).empty();
            },
            init: function (callback, beforeCallback) {
                var self = this;
                var page = 1;

                if (self.useHash) {
                    self.parseHash();
                    page = parseInt(location.hash.slice(5));
                    if (isNaN(page)) {
                        page = 1;
                    }

                    $(window).on('hashchange', function () {
                        self.parseHash();
                        var page = parseInt(location.hash.slice(5));
                        if (isNaN(page)) {
                            page = 1;
                        }

                        if (self.onLoading !== page || self.changeSearch) {
                            self.getPage(page);
                        }
                    });
                }

                if (typeof callback === "function") {
                    self.successCallback = callback;

                    if (typeof beforeCallback === "function") {
                        self.beforCallback = beforeCallback;
                    }

                    common.form.init(self.formObj, self.url, self.beforeCallback, self.successCallback);

                    var orgUseGotoTop = self.useGotoTop;
                    self.useGotoTop = false;
                    self.getPage(page);
                    self.useGotoTop = orgUseGotoTop;
                } else {
                    alert('Not define callback');
                }
            },
            showLoading: function () {
                this.removeContent();
                $(this.container).append(this.loadingTpl());
            },
            getPage: function (page) {
                var self = this;

                if (self.useGotoTop) {
                    self.gotoTop();
                }

                self.showLoading();
                $(self.pageNum).val(page);
                self.formObj.submit();
                self.onLoading = page;
                if (self.useHash && page >= 1) {
                    window.location.hash = self.getHash(page);
                }
            },
            reload: function () {
                this.getPage(this.onLoading);
            }
        };
    },

    /**
     * ajaxList -DIV 
     */
    ajaxList2: function () {
        return {
            container: '',
            containerType: 'div',
            pagination: '',
            pageNum: '#devPage',
            listTpl: '',
            emptyTpl: '',
            loadingTpl: '',
            formObj: '',
            utl: '',
            topPosition: 0,
            onLoading: false,
            useHash: true,
            useGotoTop: false,
            changeSearch: false,
            validName: function (name) {
                switch (name) {
                    case 'max':
                    case 'page':
                    case 'ForbizCsrfTestName':
                        return false;
                        break;
                }

                return true;
            },
            getHash: function (page) {
                var tail = [];
                var self = this;

                $.each(self.formObj.serializeArray(), function (idx, field) {
                    if (self.validName(field.name) && field.value) {
                        tail.push(field.name + '=' + escape(field.value));
                    }
                });

                return '#page' + page + '&' + tail.join('&');
            },
            parseHash: function () {
                var self = this;
                var query = location.hash.substr(1).split('&');

                self.changeSearch = false;

                if (query.length > 0) {
                    $.each(query, function (idx, part) {
                        if (part.indexOf('=') > 0) {
                            var item = part.split("=");

                            if (self.validName(item[0])) {
                                var el = self.formObj.find('[name=' + item[0] + ']');

                                item[1] = unescape(item[1]);
                                if (el.length > 0 && el.val() != item[1]) {
                                    el.val($.trim(item[1]));
                                    self.changeSearch = true;
                                }
                            }
                        }
                    });
                }
            },
            gotoTop: function () {
                $('html, body').animate({scrollTop: this.topPosition}, 0);
            },
            beforCallback: function () {
                return true;
            },
            successCallback: function () {
                return false;
            },
            compileTpl: function (tplId) {
                try {
                    var tplObj = Handlebars.compile(common.util.getTpl(tplId));
                    $(tplId).remove();
                    return tplObj;
                } catch (e) {
                    alert("Not define ForbizTpl [" + tplId + "]");
                }
            },
            setRemoveContent: function (remove) {
                this.remove = remove;

                return this;
            },
            setListTpl: function (tpl) {
                this.listTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setEmptyTpl: function (tpl) {
                this.emptyTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setLoadingTpl: function (tpl) {
                this.loadingTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setGotoTop: function (topPosition) {
                if (topPosition || topPosition === 0) {
                    this.topPosition = topPosition;
                    this.useGotoTop = true;
                } else {
                    this.topPosition = 0;
                    this.useGotoTop = false;
                }

                return this;
            },
            setForm: function (formId) {
                this.formObj = $(formId);
                return this;
            },
            setContainer: function (containerId) {
                this.container = containerId;
                return this;
            },
            setPagination: function (paginationId) {
                this.pagination = paginationId;
                return this;
            },
            setPageNum: function (pageNum) {
                this.pageNum = pageNum;
                return this;
            },
            setContainerType: function (containerType) {
                this.containerType = containerType;
                return this;
            },
            setController: function (methodName, controllerName) {
                this.url = common.util.getControllerUrl(methodName, controllerName);
                return this;
            },
            setContent: function (list, paging) {
                this.removeContent();
                if (list.length > 0) {
                    for (var i = 0; i < list.length; i++) {
                        var row = list[i];

                        $(this.container).append(this.listTpl(row));
                    }

                    if (paging) {
                        $(this.pagination).html(common.pagination.getHtml(paging));
                    }
                } else {
                    $(this.container).append(this.emptyTpl());
                }
            },
            setUseHash: function (useHash) {
                if (useHash === true) {
                    this.useHash = true;
                } else {
                    this.useHash = false;
                }

                return this;
            },
            removeContent: function () {
                if (this.containerType == 'div') {
                    $(this.container + ' > li').remove();
                } else {
                    $(this.container).empty();
                }

                $(this.pagination).empty();
            },
            init: function (callback, beforeCallback) {
                var self = this;
                var page = 1;

                if (self.useHash) {
                    self.parseHash();
                    page = parseInt(location.hash.slice(5));
                    if (isNaN(page)) {
                        page = 1;
                    }

                    $(window).on('hashchange', function () {
                        self.parseHash();
                        var page = parseInt(location.hash.slice(5));
                        if (isNaN(page)) {
                            page = 1;
                        }

                        if (self.onLoading !== page || self.changeSearch) {
                            self.getPage(page);
                        }
                    });
                }

                if (typeof callback === "function") {
                    self.successCallback = callback;

                    if (typeof beforeCallback === "function") {
                        self.beforCallback = beforeCallback;
                    }

                    common.form.init(self.formObj, self.url, self.beforeCallback, self.successCallback);

                    var orgUseGotoTop = self.useGotoTop;
                    self.useGotoTop = false;
                    self.getPage(page);
                    self.useGotoTop = orgUseGotoTop;
                } else {
                    alert('Not define callback');
                }
            },
            showLoading: function () {
                this.removeContent();
                $(this.container).append(this.loadingTpl());
            },
            getPage: function (page) {
                var self = this;

                if (self.useGotoTop) {
                    self.gotoTop();
                }

                self.showLoading();
                $(self.pageNum).val(page);
                self.formObj.submit();
                self.onLoading = page;
                if (self.useHash && page >= 1) {
                    window.location.hash = self.getHash(page);
                }
            },
            reload: function () {
                this.getPage(this.onLoading);
            }
        };
    },
    /**
     * more 페이징
     */
    morePagination: {
        morePagingTpl: [
            '<button class="btn-lg btn-gray-line devPageBtnCls" data-page="{[nextPageNum]}" type="button">',
            '<span>더보기</span>',
            '</button>'
        ],
        morePagingGlobalTpl: [
            '<button class="btn-lg btn-gray-line devPageBtnCls" data-page="{[nextPageNum]}" type="button">',
            '<span>More({[currentPageNum]}/{[lastPageNum]})</span>',
            '</button>'
        ],
        getHtml: function (data)
        {
            if (typeof data.page_list !== 'undefined') {
                var pagingHtml = [];
                if(common.langType=='korean'){
                    var paging = Handlebars.compile(this.morePagingTpl.join(''));
                }else{
                    var paging = Handlebars.compile(this.morePagingGlobalTpl.join(''));
                }

                return paging({
                    currentPageNum: data.cur_page,
                    nextPageNum: data.next_page,
                    lastPageNum: data.last_page
                });
            } else {
                return '';
            }
        }
    },
    /**
     * more ajaxList
     */
    moreAjaxList: function () {
        return {
            container: '',
            containerType: 'table',
            pagination: '',
            pageNum: '#devPage',
            lastPage: false,
            listTpl: '',
            emptyTpl: '',
            loadingTpl: '',
            formObj: '',
            utl: '',
            topPosition: 0,
            remove: true,
            onLoading: false,
            useHash: true,
            useGotoTop: false,
            changeSearch: false,
            validName: function (name) {
                switch (name) {
                    case 'max':
                    case 'page':
                    case 'ForbizCsrfTestName':
                        return false;
                        break;
                }

                return true;
            },
            getHash: function (page) {
                var tail = [];
                var self = this;

                $.each(self.formObj.serializeArray(), function (idx, field) {
                    if (self.validName(field.name) && field.value) {
                        tail.push(field.name + '=' + escape(field.value));
                    }
                });

                return '#page' + page + '&' + tail.join('&');
            },
            parseHash: function () {
                var self = this;
                var query = location.hash.substr(1).split('&');

                self.changeSearch = false;

                if (query.length > 0) {
                    $.each(query, function (idx, part) {
                        if (part.indexOf('=') > 0) {
                            var item = part.split("=");

                            if (self.validName(item[0])) {
                                var el = self.formObj.find('[name=' + item[0] + ']');

                                item[1] = unescape(item[1]);
                                if (el.length > 0 && el.val() != item[1]) {
                                    el.val($.trim(item[1]));
                                    self.changeSearch = true;
                                }
                            }
                        }
                    });
                }
            },
            gotoTop: function () {
                $('html, body').animate({scrollTop: this.topPosition}, 0);
            },
            beforCallback: function () {
                return true;
            },
            successCallback: function () {
                return false;
            },
            compileTpl: function (tplId) {
                try {
                    var tplObj = Handlebars.compile(common.util.getTpl(tplId));
                    $(tplId).remove();
                    return tplObj;
                } catch (e) {
                    alert("Not define ForbizTpl [" + tplId + "]");
                }
            },
            setRemoveContent: function (remove) {
                this.remove = remove;

                return this;
            },
            setListTpl: function (tpl) {
                this.listTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setEmptyTpl: function (tpl) {
                this.emptyTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setLoadingTpl: function (tpl) {
                this.loadingTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setGotoTop: function (topPosition) {
                if (topPosition || topPosition === 0) {
                    this.topPosition = topPosition;
                    this.useGotoTop = true;
                } else {
                    this.topPosition = 0;
                    this.useGotoTop = false;
                }

                return this;
            },
            setForm: function (formObj) {
                this.formObj = $(formObj);
                return this;
            },
            setContainer: function (containerId) {
                this.container = containerId;
                return this;
            },
            setPagination: function (paginationId) {
                this.morePagination = paginationId;
                return this;
            },
            setPageNum: function (pageNum) {
                this.pageNum = pageNum;
                return this;
            },
            setContainerType: function (containerType) {
                this.containerType = containerType;
                return this;
            },
            setController: function (methodName, controllerName) {
                this.url = common.util.getControllerUrl(methodName, controllerName);
                return this;
            },
            setContent: function (list, paging) {
                //마지막 페이지 또는 page가 1일때 숨김
                if (paging && (paging.cur_page == paging.last_page || paging.page_list.length <= 1)) {
                    this.hidePagination();
                } else {
                    this.sowPagination();
                }
                //삭제옵션, 페이지 검색시 1페이지, paging 정보 없을때
                if (this.remove === true || !paging || paging.cur_page == 1) {
                    this.removeContent();
                }
                if (list.length > 0) {
                    for (var i = 0; i < list.length; i++) {
                        var row = list[i];
                        $(this.container).append(this.listTpl(row));
                    }

                    if (paging) {
                        $(this.morePagination).html(common.morePagination.getHtml(paging));
                    }
                } else {
                    $(this.container).append(this.emptyTpl());
                }
            },
            setUseHash: function (useHash) {
                if (useHash === true) {
                    this.useHash = true;
                } else {
                    this.useHash = false;
                }

                return this;
            },
            removeContent: function () {
                if (this.containerType == 'table') {
                    $(this.container + ' > tr').remove();
                } else {
                    $(this.container).empty();
                }

                $(this.pagination).empty();
            },
            init: function (callback, beforeCallback) {
                var self = this;
                var page = 1;

                if (self.useHash) {
                    self.parseHash();
                    page = parseInt(location.hash.slice(5));
                    if (isNaN(page)) {
                        page = 1;
                    }

                    $(window).on('hashchange', function () {
                        self.parseHash();
                        var page = parseInt(location.hash.slice(5));
                        if (isNaN(page)) {
                            page = 1;
                        }
                        if (self.onLoading !== page || self.changeSearch) {
                            self.getPage(page);
                        }
                    });
                }

                if (typeof callback === "function") {
                    self.successCallback = callback;

                    if (typeof beforeCallback === "function") {
                        self.beforCallback = beforeCallback;
                    }

                    common.form.init(self.formObj, self.url, self.beforeCallback, self.successCallback);

                    var orgUseGotoTop = self.useGotoTop;
                    self.useGotoTop = false;
                    self.getPage(page);
                    self.useGotoTop = orgUseGotoTop;
                } else {
                    alert('Not define callback');
                }
            },
            showLoading: function () {
                //this.removeContent();
                //$(this.container).append(this.loadingTpl());
            },
            getPage: function (page) {
                var self = this;
                var curPage = $(self.pageNum).val();

                if (page == 1 || page != curPage) {
                    if (self.useGotoTop) {
                        self.gotoTop();
                    }

                    self.showLoading();
                    $(self.pageNum).val(page);
                    self.formObj.submit();
                    self.onLoading = page;
                    if (self.useHash && page > 1) {
                        window.location.hash = self.getHash(page);
                    }
                }


            },
            reload: function () {
                this.getPage(this.onLoading);
            },
            hidePagination: function () {
                $(this.container).next(".fb__goods__add").hide();
                $(this.pagination).hide();
            },
            sowPagination: function () {
                $(this.pagination).show();
            }
        };
    },
    /**
     * more ajaxList
     */
    moreArrayList: function () {
        return {
            container: '',
            containerType: 'table',
            pagination: '',
            pageNum: '#devPage',
            lastPage: false,
            listTpl: '',
            emptyTpl: '',
            loadingTpl: '',
            formObj: '',
            utl: '',
            topPosition: 0,
            remove: true,
            onLoading: false,
            useHash: true,
            useGotoTop: false,
            changeSearch: false,
            responseData: false,
            setResponseData: function (response) {
                this.responseData = response;
                return this;
            },
            validName: function (name) {
                switch (name) {
                    case 'max':
                    case 'page':
                    case 'ForbizCsrfTestName':
                        return false;
                        break;
                }

                return true;
            },
            getHash: function (page) {
                var tail = [];
                var self = this;

                $.each(self.formObj.serializeArray(), function (idx, field) {
                    if (self.validName(field.name) && field.value) {
                        tail.push(field.name + '=' + escape(field.value));
                    }
                });

                return '#page' + page + '&' + tail.join('&');
            },
            parseHash: function () {
                var self = this;
                var query = location.hash.substr(1).split('&');

                self.changeSearch = false;

                if (query.length > 0) {
                    $.each(query, function (idx, part) {
                        if (part.indexOf('=') > 0) {
                            var item = part.split("=");

                            if (self.validName(item[0])) {
                                var el = self.formObj.find('[name=' + item[0] + ']');

                                item[1] = unescape(item[1]);
                                if (el.length > 0 && el.val() != item[1]) {
                                    el.val($.trim(item[1]));
                                    self.changeSearch = true;
                                }
                            }
                        }
                    });
                }
            },
            gotoTop: function () {
                $('html, body').animate({scrollTop: this.topPosition}, 0);
            },
            beforCallback: function () {
                return true;
            },
            successCallback: function () {
                return false;
            },
            compileTpl: function (tplId) {
                try {
                    var tplObj = Handlebars.compile(common.util.getTpl(tplId));
                    $(tplId).remove();
                    return tplObj;
                } catch (e) {
                    alert("Not define ForbizTpl [" + tplId + "]");
                }
            },
            setRemoveContent: function (remove) {
                this.remove = remove;

                return this;
            },
            setListTpl: function (tpl) {
                this.listTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setEmptyTpl: function (tpl) {
                this.emptyTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setLoadingTpl: function (tpl) {
                this.loadingTpl = (typeof tpl === 'function' ? tpl : this.compileTpl(tpl));
                return this;
            },
            setGotoTop: function (topPosition) {
                if (topPosition || topPosition === 0) {
                    this.topPosition = topPosition;
                    this.useGotoTop = true;
                } else {
                    this.topPosition = 0;
                    this.useGotoTop = false;
                }

                return this;
            },
            setForm: function (formObj) {
                this.formObj = $(formObj);
                return this;
            },
            setContainer: function (containerId) {
                this.container = containerId;
                return this;
            },
            setPagination: function (paginationId) {
                this.morePagination = paginationId;
                return this;
            },
            setPageNum: function (pageNum) {
                this.pageNum = pageNum;
                return this;
            },
            setContainerType: function (containerType) {
                this.containerType = containerType;
                return this;
            },
            setController: function (methodName, controllerName) {
                this.url = common.util.getControllerUrl(methodName, controllerName);
                return this;
            },
            setContent: function (list, paging) {
                //마지막 페이지 또는 page가 1일때 숨김
                if (paging && (paging.cur_page == paging.last_page)) {
                    this.hidePagination();
                } else {
                    this.sowPagination();
                }
                //삭제옵션, 페이지 검색시 1페이지, paging 정보 없을때
                if (this.remove === true || !paging || paging.cur_page == 1) {
                    this.removeContent();
                }
                if (list.length > 0) {
                    for (var i = 0; i < list.length; i++) {
                        var row = list[i];
                        $(this.container).append(this.listTpl(row));
                    }

                    if (paging) {
                        $(this.morePagination).html(common.morePagination.getHtml(paging));
                    }
                } else {
                    $(this.container).append(this.emptyTpl());
                }
            },
            setUseHash: function (useHash) {
                if (useHash === true) {
                    this.useHash = true;
                } else {
                    this.useHash = false;
                }

                return this;
            },
            removeContent: function () {
                if (this.containerType == 'table') {
                    $(this.container + ' > tr').remove();
                } else {
                    $(this.container).empty();
                }

                $(this.pagination).empty();
            },
            init: function (callback, beforeCallback) {
                var self = this;
                var page = 1;

                if (self.useHash) {
                    self.parseHash();
                    page = parseInt(location.hash.slice(5));
                    if (isNaN(page)) {
                        page = 1;
                    }

                    $(window).on('hashchange', function () {
                        self.parseHash();
                        var page = parseInt(location.hash.slice(5));
                        if (isNaN(page)) {
                            page = 1;
                        }
                        if (self.onLoading !== page || self.changeSearch) {
                            self.getPage(page);
                        }
                    });
                }

                if (typeof callback === "function") {
                    self.successCallback = callback;

                    if (typeof beforeCallback === "function") {
                        self.beforCallback = beforeCallback;
                    }

                    // common.form.init(self.formObj, self.url, self.beforeCallback, self.successCallback);

                    var orgUseGotoTop = self.useGotoTop;
                    self.useGotoTop = false;
                    self.getPage(page);
                    self.useGotoTop = orgUseGotoTop;
                } else {
                    alert('Not define callback');
                }
            },
            showLoading: function () {
            },
            getPage: function (page) {
                var self = this;
                var curPage = $(self.pageNum).val();

                if (page == 1 || page != curPage) {
                    if (self.useGotoTop) {
                        self.gotoTop();
                    }

                    self.showLoading();
                    $(self.pageNum).val(page);
                    
                    var idx = parseInt(page) - 1;
                    var paging = false;
                    if (self.responseData && self.responseData.length > 0) {
                        paging = {
                            cur_page: page,
                            next_page: parseInt(page) + 1,
                            last_page: self.responseData.length,
                            page_list: [true]
                        };
                    }
                    self.successCallback({data: {list: self.responseData[idx], paging: paging}});
                    
                    self.onLoading = page;
                    if (self.useHash && page > 1) {
                        window.location.hash = self.getHash(page);
                    }
                }


            },
            reload: function () {
                this.getPage(this.onLoading);
            },
            hidePagination: function () {
                $(this.container).next(".fb__goods__add").hide();
                $(this.pagination).hide();
            },
            sowPagination: function () {
                $(this.morePagination).show();
            }
        };
    }
};

//사용하는 언어 로드
common.lang.load('common.validation.required.text', "{title}을/를 입력해 주세요."); //Alert_05
common.lang.load('common.validation.required.checkbox', "{title}을/를 체크해 주세요.");
common.lang.load('common.validation.required.select', "{title}을/를 선택해 주세요.");
common.lang.load('common.validation.required.file', "{title}을/를 첨부해 주세요.");
common.lang.load('common.validation.userPassword.fail', "영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합하여 최소 8자~최대 16자로 입력해 주세요."); //Alert_64
common.lang.load('common.validation.userPassword.fail1', "아이디와 비밀번호가 동일합니다. 다시 입력해주시기 바랍니다.");
common.lang.load('common.validation.userPasswordSpecialChracter.fail', "특수문자는 !@#$%^&*()_+~ 만 사용해 주세요.");
common.lang.load('common.validation.userPassword.space', "비밀번호는 공백 없이 입력해주세요.");
common.lang.load('common.validation.compare.fail', "{title}와 일치하게 입력해 주세요.");
common.lang.load('common.validation.userId.fail', "영문 혹은 영문+숫자를 조합하여 6~20자리로 입력해 주세요.");
common.lang.load('common.validation.companyNumber.fail', "유효한 사업자 정보가 아닙니다."); //Alert_08
common.lang.load('common.validation.juminNumber.fail', "유효한 주민등록 정보가 아닙니다."); //Alert_08
common.lang.load('common.validation.email.fail', "유효한 이메일을 입력해 주세요.");
common.lang.load('common.inputFormat.fileFormat.fail', "파일 형식이 올바르지 않습니다.{common.lineBreak}다시 첨부해 주세요.");
common.lang.load('common.inputFormat.fileSize.fail', "파일 용량이 최대 {size}MB를 초과했습니다.{common.lineBreak}다시 첨부해 주세요.");
common.lang.load('common.validation.mobile.fail', "휴대전화번호를  올바르게 입력해 주세요.");
//inputFormat bind
common.inputFormat.eventBind();