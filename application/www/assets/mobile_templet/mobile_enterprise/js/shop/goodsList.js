"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('product.SearchPriceMinCheck.alert', "최소금액을 입력해주세요.");
common.lang.load('product.SearchPriceMaxCheck.alert', "최대금액을 입력해주세요.");
common.lang.load('product.SearchPriceFail.alert', "최소금액이 최대금액보다 크게 검색할 수 없습니다.");

var goodsList = {
    goodsListAjax: false,
    initFormat: function () {
        //-----set input format
        common.inputFormat.set($('#devSpriceInput,#devEpriceInput'), {'number': true, 'maxLength': 10});
    },
    init: function () {
		
        var self = this;
		
        self.goodsListAjax = common.ajaxList();
        self.goodsListAjax
            .setRemoveContent(false)
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('ul')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(true)
            .setController('getGoodsList', 'product')
            .init(function (response) {
                if(response.result == 'emptySearchFilter'){
                    $('#devListContents').css('display','none');
                    $('#devFilterEmpty').css('display','');
                }else{
                    $('#devFilterEmpty').css('display','none');
                    $('#devListContents').css('display','');
                }
				self.loadingOn();

                // 전체 상품 수
                $('#devTotalProduct').text(common.util.numberFormat(response.data.total));
                self.goodsListAjax.setContent(response.data.list, response.data.paging);
						
				setTimeout(() => {
					self.loadingOff();
				}, 1500);
				if ($("body").find(".goods-list__thumb-slide").length > 0) {
					var swiperThumb = new Swiper(".goods-list__thumb-slide", {
						slidesPerView: "auto",
						spaceBetween: 0,
						loop: false,
						observeParents : true,
						observer : true,
						speed: 400,
						scrollbar: {
							el: ".swiper-scrollbar",
						},
					});
				}
            });


		

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.goodsListAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function() {
        var self = this;

        $('.devSortTab').on('click', function(){
            $('#devSort').val($(this).val());
            $('#devListContents').html("");
            self.goodsListAjax.setRemoveContent(false);
            self.goodsListAjax.getPage(1);
        });

        $('.devSortPopTab').on('click', function(){
			if (('.box__layer').hasClass("open")){
				$('.select-box__layer').show();
			}else{
				$('.select-box__layer').hide();
			}
        });

        //$('#devFilterSubmit').on('click',function(){
        $('.devFilterItem').on('click',function(){
            $('#devListForm #devProductFilter').val('');
            var fillterData = [];
            $('.devFilterItem').each(function(){
                if($(this).is(':checked') == true){
                    fillterData.push($(this).val());
                }
            });

            if(fillterData.length > 0){
                $('#devListForm #devProductFilter').val(encodeURIComponent(JSON.stringify(fillterData)));
            }else{
                $('#devListForm #devProductFilter').val('');
            }

            //가격대 검색 영역
            var searchPriceArea = $('input[name=search_price]:checked');
            if(searchPriceArea.length){
                var sprice = parseInt($(searchPriceArea).data('sprice'));
                var eprice = parseInt($(searchPriceArea).data('eprice'));


                if(sprice == ''&& eprice == ''){
                    sprice = parseInt($('#devSpriceInput').val());
                    eprice = parseInt($('#devEpriceInput').val());
                }

                if(sprice > eprice){
                    common.noti.alert(common.lang.get('product.SearchPriceFail.alert'));
                    return false;
                }

                $('#devListForm #devSprice').val(sprice);
                $('#devListForm #devEprice').val(eprice);
            }else{
                $('#devListForm #devSprice').val('');
                $('#devListForm #devEprice').val('');
            }
        });

        $('.devPriceType').on('click',function(){
            $('#devListForm #devProductFilter').val('');
            var fillterData = [];
            $('.devFilterItem').each(function(){
	
                if($(this).is(':checked') == true){
                    fillterData.push($(this).val());
                }
            });


            if(fillterData.length > 0){
                $('#devListForm #devProductFilter').val(encodeURIComponent(JSON.stringify(fillterData)));
            }else{
                $('#devListForm #devProductFilter').val('');
            }

            //가격대 검색 영역
            var searchPriceArea = $('input[name=search_price]:checked');
            if(searchPriceArea.length){
                var sprice = parseInt($(searchPriceArea).data('sprice'));
                var eprice = parseInt($(searchPriceArea).data('eprice'));


                if(sprice == ''&& eprice == ''){
                    sprice = parseInt($('#devSpriceInput').val());
                    eprice = parseInt($('#devEpriceInput').val());
                }

                if(sprice > eprice){
                    common.noti.alert(common.lang.get('product.SearchPriceFail.alert'));
                    return false;
                }

				if ($('#devListForm #devSprice').val() == sprice && $('#devListForm #devEprice').val() == eprice )
				{
					$('#devListForm #devSprice').val('');
					$('#devListForm #devEprice').val('');
					$(this).prop('checked', false);
					$('.filter-layer__content__acco--price .accordion__opner__value').html("");
					//console.log($('.filter-layer__content__acco--price .accordion__opner__value').html());
				}else{
					$('#devListForm #devSprice').val(sprice);
					$('#devListForm #devEprice').val(eprice);
				}

            }else{
                $('#devListForm #devSprice').val('');
                $('#devListForm #devEprice').val('');
            }
        });

        $('#devFilterSubmit').on('click',function(){
            $('#devListForm #devProductFilter').val('');
            var fillterData = [];
            $('.devFilterItem').each(function(){
				console.log($(this).is(':checked'));
                if($(this).is(':checked') == true){
                    // var filterName = $(this).attr('name');
                    // var filterIdx = $(this).val();
                    // var inputItem = "<input type='hidden' name='product_filter["+filterName+"][]' value='"+filterIdx+"' > ";
                    fillterData.push($(this).val());
                }
               // alert($(this).attr('name'))
            });
            if(fillterData.length > 0){
                $('#devListForm #devProductFilter').val(encodeURIComponent(JSON.stringify(fillterData)));
            }else{
                $('#devListForm #devProductFilter').val('');
            }



            //가격대 검색 영역
            var searchPriceArea = $('input[name=search_price]:checked');
            if(searchPriceArea.length){
                var sprice = $(searchPriceArea).data('sprice') == '' ? 0 : $(searchPriceArea).data('sprice');
                var eprice = $(searchPriceArea).data('eprice') == '' ? 0 : $(searchPriceArea).data('eprice');

                var price_type = ($(searchPriceArea).val());
                $('#devListForm #devPriceType').val(price_type);

                if((sprice == '' || sprice == 0)&& (eprice == '' || eprice == 0)){
                    sprice = $('#devSpriceInput').val() == '' ? 0 : $('#devSpriceInput').val();
                    eprice = $('#devEpriceInput').val() == '' ? 0 : $('#devEpriceInput').val();
                }

                sprice = parseInt(sprice);
                eprice = parseInt(eprice);

                //NaN 체크
                if(isNaN(sprice)){
                    sprice = null;
                }
                if( isNaN(eprice)){
                    eprice = null;
                }

                if(sprice == null) {
                    common.noti.alert(common.lang.get('product.SearchPriceMinCheck.alert'));
                    $('#devSpriceInput').focus();
                    return false;
                }

                if(!eprice) {
                    common.noti.alert(common.lang.get('product.SearchPriceMaxCheck.alert'));
                    $('#devEpriceInput').focus();
                    return false;
                }

                if(sprice > eprice){
                    common.noti.alert(common.lang.get('product.SearchPriceFail.alert'));
                    $('#devSpriceInput').val('');
                    $('#devEpriceInput').val('');
                    $('#devSpriceInput').focus();
                    return false;
                }

                $('#devListForm #devSprice').val(sprice);
                $('#devListForm #devEprice').val(eprice);
            }else{
                $('#devListForm #devSprice').val('');
                $('#devListForm #devEprice').val('');
                $('#devListForm #devPriceType').val('');
            }


            self.goodsListAjax.getPage(1);

			setTimeout(() => {
				$("#search-filter").removeClass("open");
			}, 500);
			$("#search-filter")
				.stop()
				.slideUp();
			$("body").removeClass("scrollNO");


            $('.br__filter-layer').removeClass('br__filter-layer--show');
        });

        $('#devFilterView').on('click',function(){
            var filterItem = $('#devListForm #devProductFilter').val();
            if(filterItem){
                filterItem = JSON.parse(decodeURIComponent(filterItem));
                $(filterItem).each(function(i,e){
                    var item = e;
                   // $('class[name=devFilterItem], input[value='+item+']').attr('checked',true);
                   //  $('class[name=devFilterItem], input[value='+item+']').trigger('click');
                })
            }
        });
    },
    refreshInitEvent : function (){

        var filterItem = $('#devListForm #devProductFilter').val();
        var priceSelectType = $('#devListForm #devPriceType').val();

        if(filterItem) {
            filterItem = JSON.parse(decodeURIComponent(filterItem));
            $('.devFilterItem').prop('checked',false);
            $(filterItem).each(function (i, e) {
                var item = e;
                $('class[name=devFilterItem], input[ value=' + item + '].devFilterItem').trigger('click');
            });
        }

        if(priceSelectType){

            $('.devPriceType').prop('checked',false);
            $('.devPriceType:input[value=' + priceSelectType + ']').trigger('click');
        }
    },
    run: function(){
        var self = this;
        self.initFormat();
        self.init();
        self.initEvent();

        self.refreshInitEvent();
    },
	loadingOn : function(){
		$("body").find(".br-loading").show();
		setTimeout(() => {
			$(".br-loading").addClass("active");
			$("body").find(".br-loading").show();
			setTimeout(() => {
				$(".ico-loading").addClass("on");
				setTimeout(() => {
					$(".ico-loading").addClass("active");
				}, 300);
			}, 300);
		}, 100);
	},
	loadingOff : function(){
		setTimeout(() => {
			$(".br-loading").removeClass("active");
			setTimeout(() => {
				$(".ico-loading").removeClass("on");
				$(".ico-loading").removeClass("active");
				setTimeout(() => {
					$("body").find(".br-loading").hide();
				}, 200);
			}, 200);
		}, 100);
	}
}

$(function () {
    goodsList.run();
});

function productWish(pid){
    if (forbizCsrf.isLogin) {
        if($('#wishCheckBox_'+pid).is(':checked')){
            var gubun = "N";
        }else{
            var gubun = "Y";
        }

        var allData = { "pid": pid, "type": gubun };
        common.ajax(common.util.getControllerUrl('wish', 'product'), allData, "", function (result) {
            if (result.result == 'insert') {
                //$(e).toggleClass("active");
                alert('해당 상품이 관심 상품 목록에 추가되었습니다.\n\n마이페이지 > 관심 상품에서 확인 가능합니다.');
            } else if (result.result == 'delete') {
                //$(e).removeClass("active");
            } else {
                common.noti.alert('error');
            }
        })
    } else {
        if(confirm("관심상품 등록은 로그인 시에만 가능합니다.\n\n로그인하시겠습니까?")){
            document.location.href = '/member/login?url=';
        }
    }
}