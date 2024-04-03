"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

function starRate(elm, index, target) {
    var parentDOM = $(elm).parents('.star-links');
    parentDOM.next('.rating-img').attr('src', '/assets/mobile_templet/mobile_enterprise/img/icon/m_star_' + index + '.png');
    parentDOM.prev('.input-radio').val(index);
    $(target).val(index);
}



/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('write.customer.file.find', "파일찾기");
common.lang.load('write.customer.file.change', "파일변경");
common.lang.load('write.customer.file.confirm.delete', "파일을 삭제하시겠습니까?");
common.lang.load('write.customer.review.regist.confirm', "등록하시겠습니까?");
common.lang.load('write.customer.review.success', "등록되었습니다.");
common.lang.load('write.customer.review.exists', "이미 상품후기가 등록된 상품입니다.");
common.lang.load('write.customer.file.type.check', "파일 형식이 올바르지 않습니다. \n다시 첨부해주세요.");
common.lang.load('write.customer.file.size.check', "파일 용량이 최대 30MB를 초과했습니다. \n다시 첨부해주세요.");
common.lang.load('write.customer.file.content.check', "상품 후기 내용은 최소 30자 이상 작성해주세요.");

var devMyProductReviewPopObj = {
    reviewForm: $('#devReviewForm'),
    initForm: function () {
        common.validation.set($('#devValuationGoods'), {'required': true});
        common.validation.set($('#devValuationDelivery'), {'required': true});
        //common.validation.set($('#devBbsSubject'), {'required': true});
        //common.validation.set($('#devBbsContents'), {'required': true});

        common.form.init(this.reviewForm,
                common.util.getControllerUrl('registerReview', 'customer'),
                function ($form) {

                    if (common.noti.confirm(common.lang.get('write.customer.review.regist.confirm'))) {
                        var textLength = $('#devBbsContents').val().length;
                        if(textLength < 30) {
                            common.noti.alert(common.lang.get('write.customer.file.content.check'));
                            return false;
                        }
                        return common.validation.check($form, 'alert', false);
                    } else {
                        return false;
                    }
                },
                function (data) {
                    if(data.result == 'success') {
                        common.noti.alert(common.lang.get('write.customer.review.success'));
                        opener.top.location.reload();
                        window.close();
                    } else if(data.result == 'notLogin') {
                        opener.top.location.href = '/member/login';
                        window.close();
                    } else if(data.result == 'existsReview') {
                        common.noti.alert(common.lang.get('write.customer.review.exists'));
                        window.close();
                    } else if(data.result == 'notExistsOrder') {
                        opener.top.location.href = '/mypage';
                        window.close();
                    } else {
                        console.log(data.data);
                    }
                });
    },
    getFile: function () {
        if (devAppType == 'iOS') {
            //아이폰용
            try {
                webkit.messageHandlers.showAuthority.postMessage("");
            } catch (err) {
                console.log(err);
            }
        } else if (devAppType == 'Android') {
            //안드로이드용
        }
    },
    initEvent: function () {
        var self = this;

        $('#devReviewSubmit').on('click', function () {
            //포토후기일때 파일첨부 체크
            var photoCheck = false;
            if($(":input:radio[name=type]:checked").val() == 1){
                $("input[type=file]").each(function() {
                    if($(this)[0].files.length > 0){
                        photoCheck = true;
                    }
                });
                if(photoCheck == false){
                    alert("이미지를 1개 이상 첨부해야 합니다.");
                    return false;
                }
            }
        });

        $('#nor_type').on('click', function () {
            $('#devPhotoUpload').hide();
        });

        $('#pri_type').on('click', function () {
            $('#devPhotoUpload').show();
        });
        
        $('#devReviewCancel').on('click', function () {
            if(confirm('취소하시겠습니까?')) {
                history.back();
                //window.close();
            }
        })

        $("span[id^='devFileDeleteButton']").click(function (e) {
            e.preventDefault();
            var split_num = (e.target.id).split('devFileDeleteButton');
            var num = split_num[1];
            common.noti.confirm(common.lang.get('write.customer.file.confirm.delete'), deleteConfirmOk(num))
        });

        function setShowAuthority(type1, type2) { // type1 : 카메라, type2 : 사진
            return {'type1' : type1, 'type2' : type2};
        }

        $("input[id^='devBbsFile']").click(function (e) {
            if(devAppType == 'iOS'){
                devMyProductReviewPopObj.getFile();
                var check = setShowAuthority();
                if(check.type1 == 'N' && check.type2 == 'N'){
                    return false;
                }
            }
        });

        $("input[id^='devBbsFile']").change(function (e) {
            e.preventDefault();
            var split_num = (e.target.id).split('devBbsFile');
            var num = split_num[1];
            var allowExt = ['jpg','jpeg','png','gif'];
            var ckSize = 1024 * 1024 * 3; //30MB

            //$("input[type=file]").each(function(){
            //if($(this)[0].files.length > 0) {
            var filesize = $(this)[0].files[0].size;
            var ext = (this.value).split(".");
            var rs = jQuery.inArray(ext['1'], allowExt);
            if (this.value != '' && rs == -1) {
                common.noti.alert(common.lang.get('write.customer.file.type.check'));
                $('#devFileWrap'+num).show();
                $('#devFileImageWrap'+num).hide();
                $('#devFileImage'+num).attr('src', '');
                return false;
            }else if(this.value != '' && filesize > ckSize) {
                common.noti.alert(common.lang.get('write.customer.file.size.check'));
                $('#devFileWrap'+num).show();
                $('#devFileImageWrap'+num).hide();
                $('#devFileImage'+num).attr('src', '');
                return false;
            }else{
                FileChangeEvent(num);
            }
            //}
            //});
        });

        var deleteConfirmOk = function (num) {
            $('#devFileWrap'+num).show();
            $('#devFileImageWrap'+num).hide();
            $('#devFileImage'+num).attr('src', '');
        }
        function FileChangeEvent(num) {
            if ($('#devBbsFile'+num).val() != "") {
                $('#devFileWrap'+num).hide();
                $('#devFileImageWrap'+num).show();
                common.util.previewFile($('#devBbsFile'+num), $('#devFileImage'+num));
            } else {
                //$('#devFileWrap'+num).show();
                //$('#devFileImageWrap'+num).hide();
                //$('#devFileImage'+num).attr('src', '');
            }
        }
    },
    run: function () {
        this.initEvent();
        this.initForm();
    }
}

$(function () {
    devMyProductReviewPopObj.run();
});