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
    addressBookList: common.ajaxList(),
    initEvent: function(){
        // 배송지 추가 버튼 이벤트
        $('#devAddressBookAddBtn').on('click', function () {
            if($('#devIsInsert').val() == 'N'){
                common.noti.alert('등록가능한 배송지가 초과되었습니다. 기존의 배송지를 삭제 후 새 배송지를 등록해주세요.');
                return false;
            }
        });

    },
    run: function () {
        var self = this;

        //-----load language
        common.lang.load('addressbook.delete.confirm', '해당 배송지를 목록에서 삭제하시겠습니까?');

        // 배송지 리스트 설정
        self.addressBookList
                .setLoadingTpl('#devAddressBooKLoading')
                .setListTpl('#devAddressBooKList')
                .setEmptyTpl('#devAddressBooKEmpty')
                .setContainerType('ul')
                .setContainer('#devAddressBooKContent')
                .setPagination('#devPageWrap')
                .setPageNum('#devPage')
                .setForm('#devAddressBookForm')
                .setUseHash(false)
                .setController('addressBook', 'mypage')
                .init(function (data) {
                    self.addressBookList.setContent(data.data.list, data.data.paging);

                    if(data.data.list.length >= 10){
                        $('#devIsInsert').val('N');
                    }else{
                        $('#devIsInsert').val('Y');
                    }
                });

        // 배송지 저장
        $('#devAddressBookAddBtn').on('click', function (e) {
            e.preventDefault();
            self.addressBookform.submit();
        });

        // 배송지 삭제
        $('#devAddressBooKContent').on('click', '.devAddressBookDelete', function () {
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
		
        $('.br-tab__nav').on('click', '#menu1', function () {
			$("#devShippingName").val("");
			$("#devRecipient").val("");
			$("#devZip").val("");
			$("#devAddress1").val("");
			$("#devAddress2").val("");
			$("#devDefaultYn").prop('checked', false);
			$("#devPcs1").val("");
			$("#devPcs2").val("");
			$("#devPcs3").val("");
			$("#devAddressBookAddBtn").html("등록하기");
		});

		$('#devAddressBookAddCancelBtn').on('click',function(){
			$("#menu2").removeClass("active");
			$("#menu1").addClass("active");

			var tabIex = $(".br-tab__contents").index();

			$(".br-tab__contents").eq(tabIex+1).removeClass("active");
			$(".br-tab__contents").eq(tabIex).addClass("active");

			$("#devShippingName").val("");
			$("#devRecipient").val("");
			$("#devZip").val("");
			$("#devAddress1").val("");
			$("#devAddress2").val("");
			$("#devDefaultYn").prop('checked', false);
			$("#devPcs1").val("");
			$("#devPcs2").val("");
			$("#devPcs3").val("");
		});

        // 배송지 수정 버튼 이벤트
        $('#devAddressBooKContent').on('click', '.devAddressBookModify', function () {

			$("#menu1").removeClass("active");
			$("#menu2").addClass("active");

			var tabIex = $(".br-tab__contents").index();

			$(".br-tab__contents").eq(tabIex).removeClass("active");
			$(".br-tab__contents").eq(tabIex+1).addClass("active");

			$(".br-tab__contents").find("#devIx").eq(tabIex).val($(this).data('ix'));
			$(".br-tab__contents").find("#devMode").eq(tabIex).val("update");
			$(".br-tab__contents").find("#devShippingName").eq(tabIex).val($(this).data('shipping_name'));
			$(".br-tab__contents").find("#devRecipient").eq(tabIex).val($(this).data('recipient'));
			$(".br-tab__contents").find("#devZip").eq(tabIex).val($(this).data('zipcode'));
			$(".br-tab__contents").find("#devAddress1").eq(tabIex).val($(this).data('addr1'));
			$(".br-tab__contents").find("#devAddress2").eq(tabIex).val($(this).data('addr2'));

			if ($(this).data('default_yn') == "Y"){
				$(".br-tab__contents").find("#devDefaultYn").eq(tabIex).prop('checked', true);
			}else{
				$(".br-tab__contents").find("#devDefaultYn").eq(tabIex).prop('checked', false);
			}
			
			
			const phoneNumber = $(this).data('mobile');
			const parts = phoneNumber.split("-");
			
			$(".br-tab__contents").find("#devPcs1").eq(tabIex).val(parts[0]);
			$(".br-tab__contents").find("#devPcs2").eq(tabIex).val(parts[1]);
			$(".br-tab__contents").find("#devPcs3").eq(tabIex).val(parts[2]);
			
			$(".br-tab__contents").find("#devAddressBookAddBtn").eq(tabIex).html("수정하기");

			
			/*
            var popWindow = common.util.popup('/mypage/addressbookManage/' + $(this).data('ix'), 580, 700, common.lang.get('addressbook.popup.modify.title'));
            $(popWindow).on('load', function () {
                popWindow.devAddressBookAddPopObj.callbackUpdate = function () {
                    self.addressBookList.reload();
                };
            });
			*/
        });
    }
};

$(function () {
    devObj.run();
});