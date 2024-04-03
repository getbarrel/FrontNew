"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('productReStock.input.confirm', "입고알림 신청을 하시겠습니까?2");
common.lang.load('productReStock.Complete.confirm', "입고알림 신청이 완료 되었습니다.");
common.lang.load('productReStock.overlap.confirm', "신청된 정보가 존재합니다.");
common.lang.load('productReStock.select.option', "옵션을 선택해 주세요.");


//common.validation.set($('#devPcs2,#devPcs3'), {'required': true});
common.validation.set($('.devReStockSelect'), {'required': true});

$(function () {
    $('.devReStockSelect:not(:disabled)').on('click',function(){
        var $target = $(this).closest(".goods-alarm__options__box");
        var option_div = $(this).data('info');
        $target.find("label").addClass("goods-alarm__options__btn--active").end()
            .siblings().find("label").removeClass("goods-alarm__options__btn--active");
        $('#devSizeInfoStock').html(option_div);
	});

	$('#devChangePcs').on('click',function(){
		if($(this).is(':checked') == true){
			common.validation.set($('#devPcs2,#devPcs3'), {'required': true});
			common.inputFormat.set($('#devPcs2,#devPcs3'), {'number': true, 'maxLength': 4});
			$('#devPcs1,#devPcs2,#devPcs3').prop('disabled',false);
		}else{
			common.validation.set($('#devPcs2,#devPcs3'), {'required': false});
			$('#devPcs1,#devPcs2,#devPcs3').prop('disabled',true);
		}
	});
    var $form = $('#devReStock');
    var url = common.util.getControllerUrl('productReStock', 'product');
    var beforeCallback = function ($form) {

        if (common.validation.check($form,'alert',false)) {
            if (common.noti.confirm(common.lang.get('productReStock.input.confirm'))) {
                return true;
            }
        }

        return false;

    };
    var successCallback = function (response) {
        if (response.result == "success") {
            common.noti.alert(common.lang.get('productReStock.Complete.confirm'));
            location.reload();
        } else if(response.result == "overlap"){
            common.noti.alert(common.lang.get('productReStock.overlap.confirm'));
        }else if(response.result == "optionIdFail"){
            common.noti.alert(common.lang.get('productReStock.select.option'));
        }else {
            common.noti.alert('system error');
        }
    };

    common.form.init($form, url, beforeCallback, successCallback);

    $('#devSumbitBtn').on('click', function () {
		$form.submit();
    });
});