"use strict";
/*--------------------------------------------------------------*
 * 공용변수 선언 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devAddMyVideo = {
    addVideoform: $('#addMyVideoFrom'),
    initForm: function () {
        var self = this;

        /**
         * 꾸민/일반 회원타입 획득하기
         */
        common.ajax(
            common.util.getControllerUrl('getKkuminMemberCheck', 'kkumin'),
            '',
            function () {
                return true;
            },
            function (data) {
                if (data.result == 'success') {
                    //꾸민회원일때
                    $('#devKkuminVideo').attr('disabled', false);
                } else {
                    //꾸민회원이 아닐때
                    $('#devKkuminVideo').attr('disabled', true);
                }
            }
        );

        var video_category = $('input:radio[name=video_category]:checked').val();

        if (video_category == 'Y') {
            common.validation.set($('#devYoutubeId'), {'required': true});
        } else if (video_category == 'S') {
            common.validation.set($('#devVideoType,#devVideoFile'), {'required': true});
        }
        common.validation.set($('#captcha'),{'required':true});
        // //-----set input format
        // common.inputFormat.set($('#devRecipient,#devShippingName'), {'maxLength': 20});
        // common.inputFormat.set($('#devPcs2,#devPcs3'), {'number': true, 'maxLength': 4});
        // common.inputFormat.set($('#devTel2,#devTel3'), {'number': true, 'maxLength': 4});
        //
        // //-----set validation
        // common.validation.set($('#devRecipient,#devPcs1,#devPcs2,#devPcs3'), {'required': true});
        //
        common.form.init(
            self.addVideoform,
            common.util.getControllerUrl('insertVideo', 'video'),
            function (formObj) {
                if (common.validation.check(formObj, 'alert', false) && confirm(common.lang.get('video.add.confirm'))) {
                    return true;
                } else {
                    return false;
                }
            },
            function (response) {
                if (response.result == 'success') {
                    common.noti.alert("등록되었습니다.");
                    location.reload();
                }else if(response.result == 'captcha_fail'){
                    common.noti.alert("보안문자를 다시입력 해주세요");
                    self.initCaptCha();
                }
            }
        );
    },
    initLang: function () {
        //-----load language
        common.lang.load('video.add.confirm', '동영상을 등록시겠습니까?');
    },
    initCaptCha: function () {
        common.ajax(
            common.util.getControllerUrl('getCaptChaImg', 'video'),
            '',
            '',
            function (response) {
                $('.devCaptCha').html(response.data);
            }
        );
    },
    initEvent: function () {
        var self = this;
        var inputVideoBool = false;
        $('#devYoutubeFile').on('click', function () {
            $('.devUpLoadYouTube').show();
            $('.devUpLoadMyFile').hide();
            common.validation.set($('#devYoutubeId'), {'required': true});
            common.validation.set($('#devVideoType,#devVideoFile'), {'required': false});
        });

        $('#devMyVideoFile').on('click', function () {
            $('.devUpLoadYouTube').hide();
            $('.devUpLoadMyFile').show();

            common.validation.set($('#devVideoType,#devVideoFile'), {'required': true});
            common.validation.set($('#devYoutubeId'), {'required': false});
        });

        $('#devYouTube').on('click', function () {
            var youtube_id = $('input[name=youtube_id]').val();
            common.ajax(
                common.util.getControllerUrl('getYoutubeInfo', 'video'),
                {youtube_id: youtube_id},
                function () {
                    if (youtube_id) {
                        return true;
                    } else {
                        return false;
                    }

                },
                function (response) {

                    if (response.result == 'success') {
                        $('#devYoutubeInfo').find('img').attr('src', response.data.thumbnail_url);
                        $('#devYoutubeInfo').find('#devYoutubeTitle').html(response.data.video_title);
                        $('.write__video__detail').addClass('write__video__detail--show');
                        self.videoBool = true;
                        inputVideoBool = true;
                    } else if (response.result == 'loginFail') {
                        self.videoBool = false;
                        inputVideoBool = false;
                        common.noti.alert("로그인 후 이용 바랍니다.");
                        return false;
                    } else {
                        self.videoBool = false;
                        inputVideoBool = false;
                        common.noti.alert("영상정보를 가져올 수 없습니다.");
                        return false;
                    }

                    //console.log(response)
                });
        });

        $('#devAddVideoSubmit').on('click', function () {
            var videoType = $('input:radio[name=video_category]:checked').val();
            var devYoutubeId = $('#devYoutubeId').val();
            if(videoType == 'Y'){
                if(inputVideoBool == false && devYoutubeId){
                    common.noti.alert("영상정보를 가져올 수 없습니다.");
                    return false;
                }
            }
            var pidArray = $('input[name^=pid]').length;

            if ( pidArray == 0 ){
                common.noti.alert("매칭상품을 검색해 주세요.");
                return false;
            }

            self.addVideoform.submit();
        });

    },
    run: function () {
        var self = this;

        self.initLang();
        self.initForm();
        self.initEvent();
        self.initCaptCha();
    }
}

var devMatchProduct = {
    matchProductListAjax: false,
    init: function () {
        var self = this;
        self.matchProductListAjax = common.ajaxList();
        self.matchProductListAjax
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('div')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devMatchingProducts')
            .setUseHash(false)
            .setController('getMatchProductList', 'product')
            .init(function (response) {

              //  if($('.devPidArea').length > 0) {
                    self.matchProductListAjax.setContent(response.data.list, response.data.paging);
                //}
                // lazyload();//퍼블 레이지로드 삽입
                if($('.devPidArea').length > 0) {
                    $('.devSearchAreaView').show();
                }
            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.matchProductListAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function () {
        var self = this;

        $('.devDeleteProducts').on('click',function(){
            var checkBool = false;
            $('.devCheckItem').each(function(){
               if($(this).is(':checked') == true){
                   checkBool = true;
               }
            });

            if(checkBool == true){
                if (confirm('선택된 상품을 삭제하시겠습니까?')) {
                    $('.devCheckItem').each(function(){
                        if($(this).is(':checked') == true){
                            var pid = $(this).val();
                            $('input[name]:input[value='+pid+']').remove();
                        }
                    });
                    self.matchProductListAjax.reload();
                }
            }else{
                common.noti.alert('삭제할 상품을 선택해 주세요.');
            }
        });
    },
    matchProductListReload: function () {
        var self = this;
        self.matchProductListAjax.reload();
    },
    run: function () {
        var self = this;

        self.init();
        self.initEvent();
    }
}

$(function () {
    devMatchProduct.run();
    devAddMyVideo.run();



    $('.devAllCheck').on('click',function(){
       if($(this).is(':checked') == true){
           $('.devCheckItem').attr('checked',true);
       } else {
           $('.devCheckItem').attr('checked',false);
       }
    });


});