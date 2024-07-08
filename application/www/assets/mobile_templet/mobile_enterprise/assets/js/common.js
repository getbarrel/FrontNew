$(function () {
	layoutJS();
	topBtn();
	topSchLayer();
	swiperItem();
	tabJS();
	accordionJS();
	inputJS();
	NewPopupCloseJS();
	NewPopupCloseNewJS();

	function setScreenSize() {
		let vh = window.innerHeight * 0.01;
		document.documentElement.style.setProperty("--vh", `${vh}px`);
	}
	setScreenSize();
	window.addEventListener("resize", setScreenSize);
});

function layoutJS() {
	/* 스크롤 */
	if ($("html").find(".NEWbarrelM").length) {
		var lastScrollTop = 0,
			delta = 15;
		$(window).scroll(function (event) {
			var st = $(this).scrollTop();
			if (Math.abs(lastScrollTop - st) <= delta) return;
			if (st > lastScrollTop && lastScrollTop > 0) {
				$("body").removeClass("scrollUp").removeClass("scrollEnd").addClass("scrollDown");
			} else {
				$("body").removeClass("scrollDown").removeClass("scrollEnd").addClass("scrollUp");
			}
			lastScrollTop = st;
		});
		$(window).scroll(function () {
			var scrT = $(window).scrollTop();
			//console.log(scrT); //스크롤 값 확인용
		
			//console.log(scrT + $(window).height());
			//console.log(scrT + $(window).height());
			if(scrT + $(window).height() > $(document).height()  - ($('#footer').height()+50)){
				$('.devPageBtnCls').trigger('click');
			}


			if (scrT == 0) {
				$("body").removeClass("scrollUp").removeClass("scrollDown").removeClass("scrollEnd").removeClass("scrollGoods");
			} else if (scrT == $(document).height() - $(window).height()) {
				$("body").removeClass("scrollUp").removeClass("scrollDown").addClass("scrollEnd");
			}
			if ($("body").find(".goods-view__btn-group").length) {
				if (scrT > $(".goods-view__btn-group").offset().top) {
					$("body").addClass("scrollGoods");
				} else {
					$("body").removeClass("scrollGoods");
				}
			}
		});


	}
	/* 끝에 도달할 때 */
	/*
	$(window).scroll(function () {
		var scrT = $(window).scrollTop();
		//console.log(scrT); //스크롤 값 확인용
		if (scrT == $(document).height() - $(window).height()) {
			//스크롤이 끝에 도달했을때 실행될 이벤트
			$("header").removeClass("active");
			$("footer").removeClass("active");
			if ($("body").find(".br__goods-list").length) {
				$(".br__goods-tab").removeClass("active");
			}
			if ($("body").find(".br__filter").length) {
				$(".br__filter").removeClass("active");
			}
		} 
	});*/
	$(".information__btn").on("click", function () {
		if ($(this).next(".information__list").is(":visible")) {
			$(this).next(".information__list").slideUp();
		} else {
			$(this).next(".information__list").slideDown();
		}
	});

	/* isms */
	$(".br__footer__isms").on("click", function () {
		$(".isms__wrap").show();
	});
	$(".isms__popup__close, .isms__dimmed").on("click", function () {
		$(".isms__wrap").hide();
	});
	/*
	if ($("body").find(".select-box").length) {
		setTimeout(() => {
			$(".select-box .select-box__title").on("click", function () {
				$(this).parents(".br__select-box").toggleClass("br__select-box--toggle");
			});
			$(".select-box__layer__label").on("change", function () {
				var ChkText = $(this).find("span").text();
				$(this).parents(".br__select-box").find(".select-box__title").find("span").text(ChkText);
				$(".br__select-box").removeClass("br__select-box--toggle");
			});
		}, 150);
		if ($("body").find(".br__filter").length) {
			$("#container,#footer").on("click", function () {
				$(".br__select-box").removeClass("br__select-box--toggle");
			});
		}
	}
	*/
	if ($("body").find(".br__filter").length) {
		if ($(".br__filter").find(".filter-nav").length) {
			$(".br__floating-btn").addClass("br__floating-goods");
		}
	}
	if ($("body").find("#container").children(".br__infoinput").length) {
		$(".br__floating-btn").addClass("br__floating-shop");
	}
	if ($("body").find("#container").children(".br__cart").length) {
		$(".br__floating-btn").addClass("br__floating-shop");
	}
	if ($("body").find("#container").children(".br__mypage").find(".board-footer").length) {
		$(".br__floating-btn").addClass("br__floating-my");
	}
	if ($("body").find("#container").children(".br__address").length) {
		$(".br__floating-btn").addClass("br__floating-my");
	}
	if ($("body").find("#container").children(".br__mypage").find(".write-form__footer").length) {
		$(".br__floating-btn").addClass("br__floating-my");
	}
	if ($("body").find("#container").children(".br__order-claim").not(".br__order-claim-detail").find(".br__order-footer").length) {
		$(".br__floating-btn").addClass("br__floating-my");
	}
	if ($("body").find("#container").children(".br__goods-view").length) {
		$(".br__floating-btn").addClass("br__floating-view");
	}
	menuJS();
}

//로딩 아이콘 JS
function IconloadingON() {
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
}
function IconloadingOFF() {
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

/* 사이드 레이어 카테고리 메뉴 JS */
function menuJS() {
	$(".cate-box--depth1")
		.find("button")
		.on("click", function () {
			var cid = $(this).parents(".cate-box--depth1 .cate-box__list").attr('data-cid');

			$(this).parents(".cate-box--depth1").addClass("slide-right").removeClass("cate-box--active");
			$('#' + cid).addClass('cate-box--active');
			//$(".cate-box--depth2").addClass("slide-left").addClass("cate-box--active");
		});
	$(".cate-box--depth2")
		.find("button")
		.on("click", function (e) {
			e.preventDefault();
			if ($(this).parents(".cate-box__list").find(".cate-box--depth3").is(":visible")) {
				$(this).parents(".cate-box__list").find(".cate-box--depth3").slideUp();
			} else {
				$(this).parents(".cate-box__list").find(".cate-box--depth3").slideDown();
			}
		});
	$(".cate-box__navi__back").on("click", function () {
		$(".cate-box--depth1").addClass("slide-right").addClass("cate-box--active");
		$(".cate-box--depth2").removeClass("slide-left").removeClass("cate-box--active");
	});
}
function topBtn() {
	$(window).scroll(function () {
		//if ($(this).scrollTop() > 100) {
			$(".br__floating__btn--top").parents("li").addClass("active");
		//} else {
		//	$(".br__floating__btn--top").parents("li").removeClass("active");
		//}
	});

	$(".br__floating__btn--top").click(function () {
		$("html, body").animate(
			{
				scrollTop: 0,
			},
			400
		);
		return false;
	});
}

/* 팝업/레이어 관련 js */
function SideLayerJS(SiID) {
	$(".br__search").removeClass("active");
	$("#" + SiID).toggleClass("active");
	if ($("#inside").is(":visible")) {
		$("#inside").stop().slideUp();
	}
	if (SiID == "navigation") {
		$(".cate-box--depth1").removeClass("slide-right").addClass("cate-box--active");
		$(".cate-box--depth2").removeClass("slide-left").removeClass("cate-box--active");
		$(".cate-box--depth3").hide();
	}
	if ($("#" + SiID).hasClass("active") === true) {
		$("body").addClass("scrollNO");
	} else {
		$("body").removeClass("scrollNO");
	}
	$(".br__drawer__scroll").animate(
		{
			scrollTop: 0,
		},
		400
	);
}
function DownLayerJS(DoID) {
	$(".br__search").removeClass("active");
	$(".br__select-box").removeClass("br__select-box--toggle");
	if ($("#navigation").hasClass("active") === true) {
		$("#navigation").removeClass("active");
	}
	if ($("#" + DoID).hasClass("popup-layout__custom") === true) {
		$(".popup-mask").addClass("popup-mask--show");
	}
	if ($("#" + DoID).hasClass("popup-layout__goods") === true) {
		$(".popup-mask").addClass("popup-mask--show");
		if ($(".popup-layout__goods").is(":visible")) {
			$(".popup-layout__goods").stop().slideUp();
		}
		$("#layer-coupon2").find(".category-wrap").show();
		$("#layer-coupon2").find(".popup-goods__wrap").hide();
	} else if ($("#" + DoID).hasClass("popup-layout__password") === true) {
		$(".popup-mask").addClass("popup-mask--show");
		if ($(".popup-layout__password").is(":visible")) {
			$(".popup-layout__password").stop().slideUp();
		}
	}
	if ($("#" + DoID).is(":visible")) {
		setTimeout(() => {
			$("#" + DoID).removeClass("open");
		}, 500);
		$("#" + DoID)
			.stop()
			.slideUp();
		$("body").removeClass("scrollNO");
	} else {
		setTimeout(() => {
			$("#" + DoID).addClass("open");
		}, 500);
		$("#" + DoID)
			.stop()
			.slideDown();
		$("body").addClass("scrollNO");
	}
}

function DownLayerJSNew(DoID) {
	if(DoID == "layer-qna"){
		if (forbizCsrf.isLogin) {
			$("#devBbsIx").val('');

			$("#devQnaDiv").val('');
			$("#devQnaSubject").val('');
			$("#devEmailId").val($("#devLoginEmailId").val());
			$("#devEmailHost").val($("#devLoginEmailHost").val());

			document.goodsQnaFrom.contents.value = '';
			$('#contentsPlace').css('display', 'block');

			$("#devEmailReturn_1").prop("checked",false);
			$("#devEmailReturn_0").prop("checked",true);

			$("#devIsHidden_1").prop("checked",true);
			$("#devIsHidden_0").prop("checked",false);
		} else {
			if(confirm("상품문의 작성은 로그인 시에만 가능합니다.\n\n로그인하시겠습니까?")){
				var pid                 = $('#devPid').val();
				document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
			}
			/*common.noti.confirm(common.lang.get('product.noMember.productQna.confirm', ''), function () {
				document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
			});*/
		}
	}
	$(".br__search").removeClass("active");
	$(".br__select-box").removeClass("br__select-box--toggle");
	if ($("#navigation").hasClass("active") === true) {
		$("#navigation").removeClass("active");
	}
	if ($("#" + DoID).hasClass("popup-layout__custom") === true) {
		$(".popup-mask-goods-view").addClass("popup-mask--show");
	}
	if ($("#" + DoID).hasClass("popup-layout__goods") === true) {
		$(".popup-mask-goods-view").addClass("popup-mask--show");
		if ($(".popup-layout__goods").is(":visible")) {
			$(".popup-layout__goods").stop().slideUp();
		}
		$("#layer-coupon2").find(".category-wrap").show();
		$("#layer-coupon2").find(".popup-goods__wrap").hide();
	} else if ($("#" + DoID).hasClass("popup-layout__password") === true) {
		$(".popup-mask-goods-view").addClass("popup-mask--show");
		if ($(".popup-layout__password").is(":visible")) {
			$(".popup-layout__password").stop().slideUp();
		}
	}
	if ($("#" + DoID).is(":visible")) {
		setTimeout(() => {
			$("#" + DoID).removeClass("open");
		}, 500);
		$("#" + DoID)
			.stop()
			.slideUp();
		$("body").removeClass("scrollNO");
	} else {
		setTimeout(() => {
			$("#" + DoID).addClass("open");
		}, 500);
		$("#" + DoID)
			.stop()
			.slideDown();
		$("body").addClass("scrollNO");
	}
}

function DownLayerJSNew2(DoID) {

	if ($("#" + DoID).is(":visible")) {
		setTimeout(() => {
			$("#" + DoID).removeClass("open");
		}, 500);
		$("#" + DoID)
			.stop()
			.slideUp();
		$("body").removeClass("scrollNO");
	} else {
		setTimeout(() => {
			$("#" + DoID).addClass("open");
		}, 500);
		$("#" + DoID)
			.stop()
			.slideDown();
		$("body").addClass("scrollNO");
	}
}

function searchLayerJS() {
	$(".br__search").toggleClass("active");
	$("body").toggleClass("scrollNO");
	$("#navigation").removeClass("active");
	$("#inside").hide();
	$(".br__search__content").animate(
		{
			scrollTop: 0,
		},
		400
	);
}
//상단 검색 레이어 JS
function topSchLayer() {
	if ($("body").find(".br__search-inner").length) {
		/*
		$(".br__search-inner .search-input").on("focus keyup", function () {
			$(this).parents(".br__search__title").next(".br__search__layer").stop().show();
		});
		$(".br__search-inner .search-input").on("blur", function () {
			$(this).parents(".br__search__title").next(".br__search__layer").stop().hide();
		});
		*/
		$(".br__search .search-close").on("click", function () {
			$(this).parents(".br__search").removeClass("active");
			$("body").removeClass("scrollNO");
		});
		$(".br__search-inner .search-input").on("focus keyup", function () {
			var inputSHTXval = $(this).val().length;
			if (inputSHTXval == 0) {
				$(this).parents(".br__search__title").next(".br__search__layer").stop().hide();
			} else {
				$(this).parents(".br__search__title").next(".br__search__layer").stop().show();
			}
		});
		$(".br__search-inner .search-input").on("blur", function () {
			$(this).parents(".br__search__title").next(".br__search__layer").stop().hide();
		});
	}
}

/* 슬라이드배너 JS */
function swiperItem() {

	if ($("body").find(".goods-list__slide").length) {
		var swiperGoods = new Swiper(".goods-list__slide", {
			slidesPerView: "auto",
			spaceBetween: 8,
			navigation: {
				nextEl: ".swiper-goods-button-next",
				prevEl: ".swiper-goods-button-prev",
			},
		});
	}
	if ($("body").find(".popup-slide").length) {
		var swiperPopupSlie = new Swiper(".popup-slide", {
			slidesPerView: "auto",
			spaceBetween: 0,
			loop: true,
			speed: 400,
			autoplay: {
				delay: 3000,
				disableOnInteraction: false,
			},
			pagination: {
				el: ".popup-swiper-pagination",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".popup-swiper-scrollbar",
			},
		});
	}
	//배너형 슬라이드
	if ($("body").find(".br__slide").length) {
		var swiperBanner = new Swiper(".br__slide", {
			slidesPerView: "1",
			spaceBetween: 10,
			loop: true,
			speed: 400,
			pagination: {
				el: ".swiper-pagination",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".swiper-scrollbar",
			},
		});
	}
	//메너 비주얼 슬라이드
	if ($("body").find(".br-main__visual").length) {
		var swiperMainVisual = new Swiper(".mainSlider__slider", {
			slidesPerView: "auto",
			spaceBetween: 0,
			loop: true,
			speed: 800,
			autoplay: {
				delay: 3000,
				disableOnInteraction: false,
			},
			pagination: {
				el: ".swiper-pagination",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".swiper-scrollbar",
				dragSize: "40",
				draggable: true,
			},
		});
	}

	if ($("body").find(".br-main__card-slider").length) {
		var swiperMainCard1 = new Swiper(".card-slider", {
			slidesPerView: "auto",
			spaceBetween: 0,
			freeMode: true,
			observeParents: true,
			pagination: {
				el: ".swiper-pagination",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".swiper-scrollbar",
				dragSize: "40",
				draggable: true,
			},
		});
		var swiperMainCard2 = new Swiper(".goods-slider-add", {
			slidesPerView: "auto",
			spaceBetween: 0,
			freeMode: true,
			observeParents: true,
			pagination: {
				el: ".swiper-pagination",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".swiper-scrollbar",
				dragSize: "40",
				draggable: true,
			},
		});
	}
	/*2024-06-29 수정 시작*/
	if ($("body").find(".goods-slider").length) {
		var swiperMainCard2 = new Swiper(".goods-slider", {
			slidesPerView: "auto",
			spaceBetween: 8,
			freeMode: true,
			observeParents: true,
			pagination: {
				el: ".swiper-pagination3",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".swiper-scrollbar3",
				dragSize: "40",
				draggable: true,
			},
		});
	}
	if ($("body").find(".br-main__FocusNow-slider").length) {
		var swiperMainCardNEW2 = new Swiper(".br-main__FocusNow-slider", {
			slidesPerView: "auto",
			spaceBetween: 8,
			freeMode: true,
			observeParents: true,
			pagination: {
				el: ".swiper-pagination2",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".swiper-scrollbar2",
				dragSize: "40",
				draggable: true,
			},
		});
	}
	/*//2024-06-29 수정 끝*/
	if ($("body").find(".barrel-item__slider").length) {
		var swiperMainBarrel = new Swiper(".barrel-item__slider", {
			slidesPerView: 1,
			spaceBetween: 0,
			loop: true,
			pagination: {
				el: ".barrel-item__slider-control .swiper-pagination",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".barrel-item__slider-control .swiper-scrollbar",
				dragSize: "40",
				draggable: true,
			},
		});
	}

	//tab 메뉴 슬라이드
	if ($("body").find(".br-tab__slide").length) {
		$(".br-tab__slide").each(function (i, v) {
			let sliderName = "slider" + i;
			$(".br-tab__slide")[i].id = sliderName;
			let sliderId = "#" + sliderName;
			var swiperTab = new Swiper(sliderId, {
				slidesPerView: "auto",
				spaceBetween: 10,
				slidesOffsetBefore: 0,
				loop: false,
				speed: 800,
			});
			var tabWrap = $(this).parents(".br-tab__wrap");
			var tabItem = $(this).find(".swiper-slide");
			var Aitem = $(this).find(".swiper-slide.active").index();
			swiperTab.slideTo(Aitem, 100, false);
			tabItem.on("click", function () {
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
		});
	}

	//브랜드 슬라이드
	if ($("body").find(".detail-slide").length) {
		var swiperDetailVisual = new Swiper(".detail-slide", {
			slidesPerView: "auto",
			spaceBetween: 0,
			loop: true,
			speed: 800,
			autoplay: {
				delay: 3000,
				disableOnInteraction: false,
			},
			pagination: {
				el: ".swiper-pagination",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".swiper-scrollbar",
			},
		});
	}
	// 스토어 슬라이드
	if ($("body").find(".store-map__slide").length) {
		var swiperMainVisual = new Swiper(".store-map__slide", {
			slidesPerView: "auto",
			spaceBetween: 0,
			loop: true,
			speed: 800,
			autoplay: {
				delay: 3000,
				disableOnInteraction: false,
			},
			pagination: {
				el: ".swiper-pagination",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".swiper-scrollbar",
			},
		});
	}

	if ($("body").find(".br__goods-view").length) {
		var swiperGoodsOption = new Swiper(".goods-info__option-slide", {
			slidesPerView: "auto",
			spaceBetween: 5,
		});
		var swiperGoodsEvent = new Swiper(".goods-event__slide", {
			slidesPerView: "auto",
			spaceBetween: 0,
			loop: true,
			speed: 800,
			pagination: {
				el: ".swiper-pagination",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".swiper-scrollbar",
			},
		});
	}

	/*
	var swiperGoods = new Swiper(".swiper-goods", {
		slidesPerView: "auto",
		spaceBetween: 8,
		navigation: {
			nextEl: ".swiper-goods-button-next",
			prevEl: ".swiper-goods-button-prev",
		},
	});
	if ($("body").find(".banner__slider").length) {
		var swiperBanner = new Swiper(".banner__slider", {
			slidesPerView: "auto",
			spaceBetween: 0,
			loop: true,
			speed: 400,
			autoplay: {
				delay: 3000,
				disableOnInteraction: false,
			},
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},
			pagination: {
				el: ".swiper-pagination",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".swiper-scrollbar",
			},
		});
		$(".banner__sliderList").on("mouseenter", function (e) {
			console.log("stop autoplay");
			swiperBanner.autoplay.stop();
		});
		$(".banner__sliderList").on("mouseleave", function (e) {
			console.log("start autoplay");
			swiperBanner.autoplay.start();
		});
	}
	if ($("body").find(".fb__goods-view").length) {
		var swiperGoodsView1 = new Swiper(".fb__goods-view__event-slider", {
			slidesPerView: "auto",
			spaceBetween: 0,
			loop: true,
			speed: 800,
			autoplay: {
				delay: 3000,
				disableOnInteraction: false,
			},
			navigation: {
				nextEl: ".swiper-GoodsView-button-next",
				prevEl: ".swiper-GoodsView-button-prev",
			},
			pagination: {
				el: ".swiper-pagination",
				type: "fraction",
				formatFractionCurrent: function (number) {
					return ("0" + number).slice(-2);
				},
				formatFractionTotal: function (number) {
					return ("0" + number).slice(-2);
				},
				renderFraction: function (currentClass, totalClass) {
					return '<span class="' + currentClass + '"></span>' + " / " + '<span class="' + totalClass + '"></span>';
				},
			},
			scrollbar: {
				el: ".swiper-scrollbar",
			},
		});
	}
	if ($("body").find(".fb__goods__slide").length) {
		var swiperGoodsSlide = new Swiper(".fb__goods__slide", {
			slidesPerView: "auto",
			spaceBetween: 0,
			loop: true,
			speed: 800,
			scrollbar: {
				el: ".swiper-scrollbar",
			},
		});
	}
	if ($("body").find(".fb-main__barrel-slider").length) {
		var swiperMainBarrel = new Swiper(".fb-main__barrel-slider", {
			slidesPerView: 1,
			spaceBetween: 0,
			loop: true,
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},
		});
	}
	if ($("body").find(".fb-slider__tab").length) {
		var swiperTab = new Swiper(".fb-slider__tab-nav", {
			slidesPerView: "auto",
			spaceBetween: 10,
			loop: false,
			speed: 800,
		});
		$(".fb-slider__tab .swiper-slide").each(function () {
			$(this).on("click", function () {
				var tabIex = $(this).index();
				swiperTab.slideTo(tabIex, 300, false);
				$(".fb-slider__tab-nav .swiper-slide").removeClass("active");
				$(this).addClass("active");
				$(this).parents(".fb-slider__tab").find(".fb-slider__contents").removeClass("active");
				$(this).parents(".fb-slider__tab").find(".fb-slider__contents").eq(tabIex).addClass("active");
			});
		});
		$(".fb__goods-view__layer .btn-close").on("click", function () {
			swiperTab.slideTo(0, 300, false);
			$(".fb-slider__tab .swiper-slide").removeClass("active");
			$(".fb-slider__tab .swiper-slide").eq(0).addClass("active");
			$(".fb-slider__tab .fb-slider__contents").removeClass("active");
			$(".fb-slider__tab .fb-slider__contents").eq(0).addClass("active");
		});
	}*/
}

function tabJS() {
	if ($("body").find(".br-tab__nav").not(".br-tab__slide").length) {
		$(".br-tab__wrap").each(function () {
			if ($(this).find(".br-tab__contents-wrap").length) {
				var tabWrap = $(this);
				var tabItem = $(this).find(".br-tab__nav").find("li");
				var tabItem2 = $(this).find(".br-tab__nav-btn").find("li");
				tabItem.find("a").on("click", function () {
					var tabIex = $(this).parents("li").index();
					tabItem.removeClass("active");
					$(this).parents("li").addClass("active");
					tabWrap.find(".br-tab__contents").removeClass("active");
					tabWrap.find(".br-tab__contents").eq(tabIex).addClass("active");
				});
				tabItem2.find("a").on("click", function () {
					var tabIex = $(this).parents("li").index();
					tabItem2.removeClass("active");
					$(this).parents("li").addClass("active");
					tabWrap.find(".br-tab__contents").removeClass("active");
					tabWrap.find(".br-tab__contents").eq(tabIex).addClass("active");
				});
			}
		});
		$(".br-tab__nav").each(function () {
			$(this)
				.find("a")
				.on("click", function () {
					$(".br-tab__nav li").removeClass("active");
					$(this).parents("li").addClass("active");
				});
		});
	}
	if ($("body").find(".br__FocusNow-nav").length) {
		$(".br__FocusNow-nav li").each(function () {
			$(this)
				.find("a")
				.on("click", function () {
					var navCont = $(this).attr("title");
					var navTOP = $("#" + navCont).offset().top;
					//console.log(navCont);
					//$(".fb-FocusNow__nav li").removeClass("active");
					//$(this).parents("li").addClass("active");
					$("html, body").animate({ scrollTop: navTOP - 172 }, 400);
				});
		});
		$(window).scroll(function () {
			var newSCL = $(window).scrollTop();
			$(".br__FocusNow-nav li").each(function () {
				var navItem = $(this);
				var navCont2 = $(this).find("a").attr("title");
				var navTOP2 = $("#" + navCont2).offset().top;
				if (newSCL >= navTOP2 - 174) {
					$(".br__FocusNow-nav li").removeClass("active");
					navItem.addClass("active");
				}
			});
		});
	}
	/* Q&A 아코디언 */
	/*
	if ($("body").find(".board-qna__wrap").length) {
		$(".board-qna__item.active").find(".board-qna__cont").show();
		$(".board-qna__title").on("click", function () {
			var qnaitem = $(this).parents(".board-qna__item");
			qnaitem.toggleClass("active");
			if (qnaitem.hasClass("active")) {
				qnaitem.addClass("active");
				qnaitem.find(".board-qna__cont").stop().slideDown();
			} else {
				$(this).removeClass("active");
				qnaitem.find(".board-qna__cont").stop().slideUp();
			}
		});
	}
	*/
	/* ID / PW 탭 jS */
	if ($("body").find(".br-tab__nav-radio").length) {
		if ($(".br-tab__wrap").find(".br-tab__contents-wrap").length) {
			$(".br-tab__nav-radio")
				.find("input[type='radio']")
				.on("click", function () {
					var ChkIX = $(this).parents("li").index();
					$(".br-tab__wrap").find(".br-tab__contents").removeClass("active");
					$(this).parents(".br-tab__wrap").find(".br-tab__contents").eq(ChkIX).addClass("active");
				});
		} else {
			var ChkIX2 = $(".br-tab__nav-radio input[type='radio']:checked").attr("data-type");
			if (ChkIX2 == "email") {
				$(".find-user__input#phone").hide();
				$(".find-user__input#email").show();
			} else if (ChkIX2 == "phone") {
				$(".find-user__input#email").hide();
				$(".find-user__input#phone").show();
			}
			$(".br-tab__nav-radio")
				.find("input[type='radio']")
				.on("click", function () {
					var ChkIX = $(this).attr("data-type");
					if (ChkIX == "email") {
						$(".find-user__input#phone").hide();
						$(".find-user__input#email").show();
					} else if (ChkIX == "phone") {
						$(".find-user__input#email").hide();
						$(".find-user__input#phone").show();
					}
				});
		}
	}
	/* 주문 */
	if ($("body").find(".br__infoinput").length) {
		$(".agree-content .btn-toggle").on("click", function () {
			var agrCont = $(this).parents(".agree-content__inner").find(".agree-content__inner__cont");
			if (agrCont.is(":visible")) {
				agrCont.slideUp();
			} else {
				agrCont.slideDown();
			}
		});
	}
}
function accordionJS() {
	if ($("body").find(".board-faq__wrap").length) {
		/* 아코디언 형식의 리스트 js */
		setTimeout(() => {
			$(".board-faq__link").on("click", function () {
				var faqiem = $(this).parents(".board-faq__item");
				faqiem.toggleClass("active");
				if ($(this).parents(".board-faq__item").hasClass("active")) {
					$(".board-faq__item").removeClass("active");
					$(".board-faq__A").stop().slideUp();
					faqiem.addClass("active");
					faqiem.find(".board-faq__A").stop().slideDown();
				} else {
					faqiem.removeClass("active");
					faqiem.find(".board-faq__A").stop().slideUp();
				}
			});
		}, 50);
	}
	if ($("body").find(".claim__wrap").length) {
		/* 아코디언 형식의 리스트 js */
		$(".claim__link").on("click", function () {
			var faqiem = $(this).parents(".claim__item");
			$(this).toggleClass("claim__link--open");
			if ($(this).hasClass("claim__link--open")) {
				$(this).addClass("claim__link--open");
				faqiem.find(".claim__info-wrap").stop().slideDown();
			} else {
				$(this).removeClass("claim__link--open");
				faqiem.find(".claim__info-wrap").stop().slideUp();
			}
		});
	}
	if ($("body").find(".br__account").length) {
		$(".br__account.active").find(".br__account__content").show();
		$(".br__account").each(function () {
			$(this)
				.not(".no-effect")
				.find(".br__account__title")
				.on("click", function () {
					$(this).parents(".br__account").toggleClass("active");
					if ($(this).parents(".br__account").hasClass("active") === true) {
						$(this).addClass("active");
						$(this).parents(".br__account").find(".br__account__content").slideDown();
					} else {
						$(this).removeClass("active");
						$(this).parents(".br__account").find(".br__account__content").slideUp();
					}
				});
		});
	}
}
//패스워드
function inputJS() {
	if ($("body").find("input[type='password']").length) {
		$(".information__input").each(function () {
			var inputTXvalL = $(this).val().length;
			if (inputTXvalL >= 1) {
				$(this).addClass("active");
			}
			$(this).on("focus keyup", function () {
				var inputTXval = $(this).val().length;
				if (inputTXval == 0) {
					$(this).removeClass("error").removeClass("active");
				} else {
					$(this).addClass("active");
				}
			});
		});
		$(".br__form-input").each(function () {
			var inputTXvalL = $(this).val().length;
			if (inputTXvalL >= 1) {
				$(this).addClass("active");
			}
			$(this).on("focus keyup", function () {
				var inputTXval = $(this).val().length;
				if (inputTXval == 0) {
					$(this).removeClass("error").removeClass("active");
				} else {
					$(this).addClass("active");
				}
			});
		});
		$("input[type='password']").each(function () {
			var inputTXvalL = $(this).val().length;
			if (inputTXvalL >= 1) {
				$(this).addClass("active");
			}
			$(this).on("focus keyup", function () {
				var inputTXval = $(this).val().length;
				if (inputTXval == 0) {
					$(this).removeClass("error").removeClass("active");
				} else {
					$(this).addClass("active");
				}
			});
		});
		//패스워드 텍스트 숨김/보기
		$(".btn-pw--visibility").on("click", function () {
			var pwVH = $(this).prev("input");
			$(this).toggleClass("active");
			if ($(this).hasClass("active")) {
				$(this).find("i").removeClass("ico-eye-hide").addClass("ico-eye");
				pwVH.attr("type", "text");
			} else {
				$(this).find("i").removeClass("ico-eye").addClass("ico-eye-hide");
				pwVH.attr("type", "password");
			}
		});
	}
	if ($("body").find(".br__form-write").length) {
		$(".br__form-write").each(function () {
			var inputTXvalL = $(this).find("textarea").val().length;
			if (inputTXvalL >= 1) {
				$(this).parents(".fb__form-write").addClass("active");
			}
			$(this)
				.find("textarea")
				.on("focus keyup", function () {
					var inputTXval = $(this).val().length;
					if (inputTXval == 0) {
						$(this).parents(".br__form-write").removeClass("error").removeClass("active");
					} else {
						$(this).parents(".br__form-write").addClass("active");
					}
				});
		});
	}
}
function NewPopupJS(popID) {
	$(".popup-mask").addClass("popup-mask--show");
	$("#" + popID).show();
}
function NewPopupCloseJS() {
	$(".popup-mask").on("click", function () {
		$("body").removeClass("scrollNO");
		$(this).removeClass("popup-mask--show");
		$(".popup-layout").hide();
		$(".main_popupL").hide();
	});
	$(".main_popupL-closebtn").on("click", function () {
		$("body").removeClass("scrollNO");
		$(".popup-mask").removeClass("popup-mask--show");
		$(".main_popupL").hide();
	});
	$(".main_popupL-checkbox").on("click", function () {
		$("body").removeClass("scrollNO");
		$(".popup-mask").removeClass("popup-mask--show");
		$(".main_popupL").hide();
	});
	$(".popup-layout .btn-close").on("click", function () {
		$("body").removeClass("scrollNO");
		if ($(this).parents(".popup-layout").hasClass("popup-layout__full") === true) {
			$(this).parents(".popup-layout").stop().slideUp();
		} else {
			$(".popup-mask").removeClass("popup-mask--show");
			$(".popup-layout").hide();
		}
	});
}

function NewPopupCloseNewJS() {
	$(".popup-mask-goods-view").on("click", function () {
		$("body").removeClass("scrollNO");
		$(this).removeClass("popup-mask--show");
		$(".popup-layout").hide();
		$(".main_popupL").hide();
	});
	$(".main_popupL-closebtn").on("click", function () {
		$("body").removeClass("scrollNO");
		$(".popup-mask-goods-view").removeClass("popup-mask--show");
		$(".main_popupL").hide();
	});
	$(".main_popupL-checkbox").on("click", function () {
		$("body").removeClass("scrollNO");
		$(".popup-mask-goods-view").removeClass("popup-mask--show");
		$(".main_popupL").hide();
	});
	$(".popup-layout .btn-close").on("click", function () {
		$("body").removeClass("scrollNO");
		if ($(this).parents(".popup-layout").hasClass("popup-layout__full") === true) {
			$(this).parents(".popup-layout").stop().slideUp();
		} else {
			$(".popup-mask-goods-view").removeClass("popup-mask--show");
			$(".popup-layout").hide();
		}
	});
}
