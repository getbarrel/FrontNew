"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('stock.common.alarm.cancel.confirm', "입고알림 신청을 취소하시겠습니까?");
var devStockAlarm = {
    stockAlarmListAjax: false,
    init: function () {
        var self = this;
        self.stockAlarmListAjax = common.ajaxList();
        self.stockAlarmListAjax
            .setRemoveContent(false)
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('li')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(false)
            .setController('getStockReminderList', 'product')
            .init(function (response) {
                //console.log(common.util.numberFormat(response.data.total));
                $('#devAlarmTotal').text(common.util.numberFormat(response.data.total));
                self.stockAlarmListAjax.setContent(response.data.list, response.data.paging);

            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.stockAlarmListAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function() {
        var self = this;

        $('#devListContents').on('click','.devDeleteReminder',function(){
           if(common.noti.confirm(common.lang.get('stock.common.alarm.cancel.confirm'))){
               var sr_ix = $(this).data('srix');
               common.ajax(
                   common.util.getControllerUrl('deleteReminder', 'product'),
                   {
                       sr_ix: sr_ix
                   },
                   '',
                   function (data) {
                       self.stockAlarmListAjax.getPage(1);
                   }
               );

           }else{

           }

        });

        $('#devListContents').on('click','#devMoveHome',function(){
           location.href='/';
        });

    },
    run: function(){
        var self = this;

        self.init();
        self.initEvent();
    }
}

$(function () {
    devStockAlarm.run();
});
