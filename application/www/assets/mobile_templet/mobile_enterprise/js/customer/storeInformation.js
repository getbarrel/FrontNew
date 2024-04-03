"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

var storesList = {
    storesListAjax: false,
    init: function () {
        var self = this;
        self.storesListAjax = common.ajaxList();
        self.storesListAjax
            .setRemoveContent(false)
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('ul')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(false)
            .setController('getStoreList', 'customer')
            .init(function(response) {

            });
        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.storesListAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function() {
        var self = this;

        //선택된 시/도에 맞는 지역구 세팅
        $('#devCitySelect').on('change', function(){

            $('#devCity').val($('.devSortTab:checked').val());

            self.storesListAjax.setController('getArea', 'customer');
            self.storesListAjax.init(function(response){

				console.log(response.data.list);
                var areaHtml = "";
				var tmp = "<option class='devSortTab' value=''>시/군/구</option><option class='devSortTab' value='#areaValue#'>#area#</option>";
                for(var i=0; i< response.data.total; i++) {
                    areaHtml += tmp.replace('#areaValue#', response.data.list[i]['area_code']).replace('#area#', response.data.list[i]['area_code']);
                }
                $('#devAreaSelect > *').remove();
                $('#devAreaSelect').append(areaHtml);

				$('#devArea').val($('#devAreaSelect').val());
            });
        });

        $('#devAreaSelect').on('change', function(){
			$('#devArea').val($('#devAreaSelect').val());
            //$('#devArea').val($('.devSortTab:checked').val());
        });

        //스토어 리스트
        $('#devSearchStore').on('click', function(){

            var city = $('#devCity').val();

            /*if(city == "") {
                alert("시/도를 선택 해주세요.");
            }else {*/
                $('#devStoreName').val($('#devStoreInput').val());

                $('#devLoading').hide();
                self.storesListAjax.setController('getStoreList', 'customer');
                self.storesListAjax.init(function(response){
                    self.storesListAjax.setContent(response.data.list, response.data.paging);
                });
            //}

        });
		$('#devLoading').hide();
		self.storesListAjax.setController('getStoreList', 'customer');
		self.storesListAjax.init(function(response){
				self.storesListAjax.setContent(response.data.list, response.data.paging);
		});

    },
    run: function(){
        var self = this;

        self.init();
        self.initEvent();
    }
}

$(function () {
    storesList.run();
});