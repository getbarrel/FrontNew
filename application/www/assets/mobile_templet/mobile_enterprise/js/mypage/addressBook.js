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
var devAddressBookObj = {
    addressBookList: common.ajaxList(),
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
    initLang: function () {
        common.lang.load('addressbook.delete.confirm', '해당 배송지를 목록에서 삭제하시겠습니까?');
        common.lang.load('addressbook.delete.default', '기본배송지로 설정된 배송지는 삭제할 수 없습니다.');
        common.lang.load('addressbook.popup.add.title', '배송지 추가');
        common.lang.load('addressbook.popup.modify.title', '배송지 수정');
		
        common.lang.load('addressbook.add.cancel.confirm', '배송지 추가를 취소하시겠습니까?');
        common.lang.load('addressbook.modify.cancel.confirm', '배송지 수정을 취소하시겠습니까?');
        common.lang.load('addressbook.add.confirm', '배송지를 저장하시겠습니까?');
    },
    initAjaxList: function () {
        var self = this;
        // 배송지 리스트 설정
        self.addressBookList
            .setLoadingTpl('#devAddressBooKLoading')
            .setListTpl('#devAddressBooKList')
            .setEmptyTpl('#devAddressBooKEmpty')
            .setContainerType('div')
            .setContainer('#devAddressBooKContent')
            .setForm('#devAddressBookForm')
            .setUseHash(true)
            .setController('addressBook', 'mypage')
            .init(function (data) {
                self.addressBookList.setContent(data.data.list, data.data.paging);
				console.log(data);
                if(data.data.list.length >= 10){
                    $('#devIsInsert').val('N');
                }else{
                    $('#devIsInsert').val('Y');
                }
            });
    },
    initEvent: function () {
        var self = this;

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

        //주소 찾기
        $('#devZipPopupButton').on('click', function (e) {
            e.preventDefault();
            common.util.zipcode.popup(function (response) {
                $('#devZip').val(response.zipcode);
                $('#devAddress1').val(response.address1);
            });
        });

        // 배송지 수정 버튼 이벤트
        $('#devAddressBooKContent').on('click', '.devAddressBookModify', function () {

			$("#menu1").removeClass("active");
			$("#menu2").addClass("active");

			var tabIex = $(".fb-tab__contents").index();

			$(".fb-tab__contents").eq(tabIex).removeClass("active");
			$(".fb-tab__contents").eq(tabIex+1).addClass("active");

			$(".fb-tab__contents").find("#devIx").eq(tabIex).val($(this).data('ix'));
			$(".fb-tab__contents").find("#devMode").eq(tabIex).val("update");
			$(".fb-tab__contents").find("#devShippingName").eq(tabIex).val($(this).data('shipping_name'));
			$(".fb-tab__contents").find("#devRecipient").eq(tabIex).val($(this).data('recipient'));
			$(".fb-tab__contents").find("#devZip").eq(tabIex).val($(this).data('zipcode'));
			$(".fb-tab__contents").find("#devAddress1").eq(tabIex).val($(this).data('addr1'));
			$(".fb-tab__contents").find("#devAddress2").eq(tabIex).val($(this).data('addr2'));

			if ($(this).data('default_yn') == "Y"){
				$(".fb-tab__contents").find("#devDefaultYn").eq(tabIex).prop('checked', true);
			}else{
				$(".fb-tab__contents").find("#devDefaultYn").eq(tabIex).prop('checked', false);
			}
			
			
			const phoneNumber = $(this).data('mobile');
			const parts = phoneNumber.split("-");
			
			$(".fb-tab__contents").find("#devPcs1").eq(tabIex).val(parts[0]);
			$(".fb-tab__contents").find("#devPcs2").eq(tabIex).val(parts[1]);
			$(".fb-tab__contents").find("#devPcs3").eq(tabIex).val(parts[2]);
			
			/*
            var popWindow = common.util.popup('/mypage/addressbookManage/' + $(this).data('ix'), 580, 700, common.lang.get('addressbook.popup.modify.title'));
            $(popWindow).on('load', function () {
                popWindow.devAddressBookAddPopObj.callbackUpdate = function () {
                    self.addressBookList.reload();
                };
            });
			*/
        });

        // 배송지 삭제
        $('#devAddressBooKContent').on('click', '.devAddressBookDelete', function () {
            if($(this).data('default_yn') == 'Y'){
                var notDelAddr = '기본배송지로 설정된 배송지는 삭제할 수 없습니다.';
                if(common.langType=='english'){
                    notDelAddr = "You can't delete a shipping address set as the default.";
                }
                common.noti.alert(notDelAddr);
                return false;
            }

            if (confirm(common.lang.get('addressbook.delete.confirm'))) {
                common.ajax(
                    common.util.getControllerUrl('adreessBookDelete', 'mypage'),
                    {ix: $(this).data('ix')},
                    '',
                    function (data) {
                        if (data.result == 'success') {
                            self.addressBookList.reload();
                        } else {
                            console.log(data);
                        }
                    }
                );
            }
        });
    },
    run: function () {
        var self = this;

        self.initLang();
        self.initAjaxList();
        self.initEvent();
    }
}

// reload function
function cbReload() {
    devAddressBookObj.addressBookList.reload();
}


$(function () {
    devAddressBookObj.run();
});