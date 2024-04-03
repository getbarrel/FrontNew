"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
//주소록 관리
$('.br__address__manage-box').on('click', function () {
    if($(this).hasClass("active")){
        $(this).removeClass("active").siblings(".br__address__manage-info").hide();
    }else {
        $(this).addClass("active").siblings(".br__address__manage-info").show();
    }
});
/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devObj = {
    addressBookform: $('#devAddressBookAddForm'),
    formInit: function () {
        var self = this;
        
        common.form.init(
                this.addressBookform,
                common.util.getControllerUrl('addressBookReplace', 'mypage'),
                function (formObj) {
                    var msg = common.lang.get('addressbook.add.confirm');
                    if(common.langType=='english'){
                        msg = 'Do you want to save your shipping address?';
                    }
                    if (common.validation.check(formObj, 'alert', false) && confirm(msg)) {
                        return true;
                    } else {
                        return false;
                    }
                },
                function (res) {
                    if(res.result == 'success') {
                        var uri = $(location).attr('href');
                        if(uri.indexOf('orderDetail') > 0) {
                            uri = uri.split('?url=');
                            location.href = uri[1];
                        }else {
                            location.replace('/mypage/addressBook');
                        }
                    }else if(res.result == 'over'){
                        common.noti.alert('등록가능한 배송지가 초과되었습니다. 기존의 배송지를 삭제 후 새 배송지를 등록해주세요.');
                    }else{
                        console.log(res);
                    }
                }
        );
    },
    run: function () {
        var self = this;

        //-----load language
        common.lang.load('addressbook.add.cancel.confirm', '배송지 추가를 취소하시겠습니까?');
        common.lang.load('addressbook.modify.cancel.confirm', '배송지 수정을 취소하시겠습니까?');
        common.lang.load('addressbook.add.confirm', '배송지를 저장하시겠습니까?');

        //-----set input format
        common.inputFormat.set($('#devRecipient'), {'maxLength': 20});
        common.inputFormat.set($('#devShippingName'), {'maxLength': 10});
        common.inputFormat.set($('#devPcs2,#devPcs3'), {'number': true, 'maxLength': 4});
        common.inputFormat.set($('#devTel2,#devTel3'), {'number': true, 'maxLength': 4});

        //-----set validation
        common.validation.set($('#devRecipient,#devZip,#devAddress1,#devAddress2,#devPcs1,#devPcs2,#devPcs3,#devShippingName'), {'required': true});

        common.validation.set($('#devCity,#devPcs,#devStateSelect,#devCountry, #devStateText'), {'required': true});

        //Form init
        self.formInit();

        // 배송지 저장
        $('#devAddressBookAddBtn').on('click', function (e) {
            e.preventDefault();
            self.addressBookform.submit();
        });

        // 배송지 창 닫기
        $('#devAddressBookAddCancelBtn').on('click', function (e) {
            e.preventDefault();
            var msg;

            if ($('#devMode').val() == 'insert') {
                msg = common.lang.get('addressbook.add.cancel.confirm');
                if(common.langType=='english'){
                    msg = 'Are you sure you want to cancel adding shipping destinations?';
                }
            } else {
                msg = common.lang.get('addressbook.modify.cancel.confirm');
                if(common.langType=='english'){
                    msg = 'Do you want to cancel the shipping edit?';
                }
            }

            if (confirm(msg)) {
//                location.replace('/mypage/addressBook');
                history.back();
            }
        });

        //주소 찾기
        $('#devZipPopupButton').on('click', function (e) {
            e.preventDefault();
            common.util.zipcode.popup(function (response) {
                $('#devZip').val(response.zipcode);
                $('#devAddress1').val(response.address1);
            });
        });

        var devMode = $('#devMode').val();

        $('#devStateSelect').on('change',function(){
            $('#devStateText').val($(this).val());
        });

        $('.devNationArea').on('change',function(){
            var country = $(this).children("option:selected").data('nation_code');

            $('.devNationArea').find('[data-nation_code='+country+']').prop('selected','selected');

            if(devMode == 'insert'){
                if(country == 'US'){
                    $('#devStateSelect option:eq(0)').prop('selected', true);
                    $('#devStateSelect').show();
                    $('#devStateText').hide();
                }else{
                    $('#devStateText').val('');
                    $('#devStateText').show();
                    $('#devStateSelect').hide();
                }
            }else{
                if(country == 'US'){
                    $('#devStateSelect').show();
                    $('#devStateText').hide();
                }else{
                    $('#devStateText').show();
                    $('#devStateSelect').hide();
                }
            }

        });

        //기본배송지가 없을 경우 필수로 체크 유지하도록 처리
        $('#devDefaultYn').on('click',function(){
            var force_default_yn = $(this).data('force_default_yn');
            if(force_default_yn == 'Y'){
                $(this).prop('checked',true);
            }
        });
    }
}

$(function () {
    devObj.run();
});