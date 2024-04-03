"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {
    var faqList = common.ajaxList();
    // 페이지네이션 재정의
    faqList.setContent = function (list, paging) {
		if(paging.cur_page == 1){
			this.removeContent();
		}
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
    };

    faqList.setContainerType('div')
        .setContainer('#devFaqContent')
        .setRemoveContent(false)
        .setUseHash(false)
        .setLoadingTpl('#devFaqLoading')
        .setListTpl('#devFaqList')
        .setEmptyTpl('#devFaqEmpty')
        .setForm('#devFaqForm')
        .setPagination('#devPageWrap')
        .setPageNum('#devPage')
        .setController('faqList', 'customer')
        .setGotoTop(100)
        .init(function (data) {
			console.log(data.data.list);
            faqList.setContent(data.data.list, data.data.paging);
            if ($("#bbsIx").val() != '') {
                $('.devFaqAnswer').slideDown();
            }
            if (data.data.sText != "" && data.data.total == 0) {
                $("#emptyMsg").text("등록된 FAQ 목록이 없습니다.");
            }
        });

	$('[devDivIx]').on('click', function (e) {
		e.preventDefault();
        var tmp = $(this).data('divix');
        $("#divIx").val(tmp);
        $("#bbsIx").val('');
        faqList.getPage(1);
    });

    var faqNum = -1;
    $('#devFaqContent').on('click', '.devFaqQuestion', function () {
        var idx = $('dl').index($(this).closest("dl"));
        if (faqNum != idx) {
            faqNum = idx;
            $('.devFaqAnswer').slideUp('fast');
            $(this).next('dd').slideDown();
            $(this).toggleClass("fb__bbs__faq-q--open");
        } else {
            $(this).next('dd').slideToggle();
            $(this).toggleClass("fb__bbs__faq-q--open");
        }
    });

	/*
	var faqSlide = new Swiper('#faqSlide', {
		slidesPerView: "auto",
		spaceBetween: 10,
		slidesOffsetBefore: 0,
		loop: false,
		speed: 800,
	});
	var faqItem = $('#faqSlide').find(".swiper-slide");
	var faqActiveItem = $('#faqSlide').find(".swiper-slide.active").index();
	faqSlide.slideTo(faqActiveItem, 100, false);

	faqItem.on("click", function () {
		var tabIex = $(this).index();
		swiperTab.slideTo(tabIex, 300, false);
		if ($("body").find(".br-tab__wrap").length) {
			$(this).parents(".br-tab__slide").find(".swiper-slide").removeClass("active");
			$(this).addClass("active");
			tabWrap.find(".br-tab__contents").removeClass("active");
			$(this).parents(".br-tab__wrap").find(".br-tab__contents").eq(tabIex).addClass("active");
		} else {
			$(this).parents(".br-tab__slide").find(".swiper-slide").removeClass("active");
			$(this).addClass("active");
		}
	});
	*/
    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        faqList.getPage(pageNum);
    });
});
