$(function () {
	main_menu();
	topSchLayer();
	swiperItem();
	popupSlide();
	topBtn();
	paginationLayer();
	tabJS();
	inputJS();
	NewPopupCloseJS();
	NewPopupCloseJSNew();
	SidePopupCloseJS();

	// 상단 검색 레이어 1200px 너비일 경우 가로스크롤 따라가기
	window.addEventListener("scroll", () => {
		const bwLeft = window.scrollX;
		document.querySelector(".sch_window").style.left = `-${bwLeft}px`;
	});

	//2023.12.27 JS 추가
	if ($("body").find(".detail-layout").length) {
		if ($("body").find(".detail-slide").length) {
			var detailH = $(".detail-layout").outerHeight();
			var detailS = $(".detail-slide").outerHeight();
			if (detailH < detailS) {
				$(".detail-slide").css("position", "static");
			} else {
				$(".detail-slide").css("position", "relative");
			}
			$(window).resize(function () {
				var detailH = $(".detail-layout").outerHeight();
				var detailS = $(".detail-slide").outerHeight();
				if (detailH < detailS) {
					$(".detail-slide").css("position", "static");
				} else {
					$(".detail-slide").css("position", "relative");
				}
			});
		}
	}
});

//상단 카테고리 서브 레이어 노출 제이쿼리(기존 배럴 꺼 붙임)
function main_menu() {
	$(document)
		.on("mouseover mouseleave", ".header__menu", function (e) {
			var $this = $(this);

			if (e.type == "mouseover") {
				$this.addClass("header__menu--over");
				//$this.find(".header__sub").stop().slideDown();
			} else {
				$this.removeClass("header__menu--over");
				//$this.find(".header__sub").stop().slideUp();
			}

			$(".fb__page-nav select").blur();
		})
		.on("click", ".header__topMenu__global__btn", function () {
			$(this).toggleClass("header__topMenu__global__btn--open");
		});

	//배럴 인사이드 서브 레이어
	$(document).on("mouseover mouseleave", ".btn-inside", function (e) {
		var $this2 = $(this);
		if (e.type == "mouseover") {
			$this2.addClass("active");
		} else {
			$this2.removeClass("active");
		}

		$(".fb__page-nav select").blur();
	});
}

//상단 검색 레이어 관련 퍼블리싱(기존 배럴 꺼 붙임)
function wrapWindowByMask() {
	//화면의 높이와 너비를 구한다.
	var maskHeight = $(document).height();
	var bodyHeight = $(window).height();
	var maskWidth = $(window).width();
	var headH = $(".fb__header").outerHeight(true);

	//마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
	$("#sch_mask").css({ width: maskWidth, height: maskHeight });
	$(".sch_window").css({ top: headH, height: bodyHeight - headH });

	//애니메이션 효과 - 일단 0초동안 까맣게 됐다가 60% 불투명도로 간다.
	$("#sch_mask").fadeIn(0);
	$("#sch_mask").fadeTo("slow", 0.6);

	//윈도우 같은 거 띄운다.
	$(".sch_window").show();

	//리사이징
	$(window).resize(function () {
		//화면의 높이와 너비를 구한다.
		var maskHeight = $(document).height();
		var bodyHeight = $(window).height();
		var maskWidth = $(window).width();
		var headH = $(".fb__header").outerHeight(true);

		//마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
		$("#sch_mask").css({ width: maskWidth, height: maskHeight });
		$(".sch_window").css({ top: headH, height: bodyHeight - headH });
	});
}

//상단 검색 레이어 JS
function topSchLayer() {
	//검은 막 띄우기(기본 배럴 꺼)
	$(".openMask").on("click", function (e) {
		e.preventDefault();
		wrapWindowByMask();
		$("body").addClass("scrollNO");
	});
	//닫기 버튼을 눌렀을 때
	$(".sch_window .btn_sch_close").on("click", function (e) {
		//링크 기본동작은 작동하지 않도록 한다.
		e.preventDefault();
		$("#sch_mask, .sch_window").hide();
		$("body").removeClass("scrollNO");
	});

	//검은 막을 눌렀을 때
	$("#sch_mask").on("click", function () {
		$(this).hide();
		$(".sch_window").hide();
		$("body").removeClass("scrollNO");
	});

	$(".ipt_sch #devHeaderSearchText").on("focus keyup", function () {
		$(this).parent(".search-area__inner").find(".search-area__layer").stop().show();
	});
	$(".ipt_sch #devHeaderSearchText").on("blur", function () {
		$(this).parent(".search-area__inner").find(".search-area__layer").stop().hide();
	});

	if ($("body").find(".fb__search").length) {
		$(".fb__search .header-input-search").on("focus keyup", function () {
			$(this).parent(".search-area__inner").find(".search-area__layer").stop().show();
		});
		$(".fb__search .header-input-search").on("blur", function () {
			$(this).parent(".search-area__inner").find(".search-area__layer").stop().hide();
		});
	}
}

/* 슬라이드배너 JS */
function swiperItem() {
	var swiperGoods = new Swiper(".swiper-goods", {
		slidesPerView: "auto",
		spaceBetween: 8,
		navigation: {
			nextEl: ".swiper-goods-button-next",
			prevEl: ".swiper-goods-button-prev",
		},
	});
	if ($("body").find(".swiper-goods-default").length) {
		var swiperDefault = new Swiper(".swiper-goods-default", {
			slidesPerView: 3,
			loop: true,
			//freeMode: true,
			spaceBetween: 8,
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},
		});
	}
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
	if ($("body").find(".fb__main__visual").length) {
		
		var index = 0;
		$(".mainSlider__slider").each(function(){
			var $this = $(this);
			$this.addClass("instance-" + index);

			new Swiper(".instance-" + index, {
				slidesPerView: "auto",
				spaceBetween: 0,
				loop: true,
				speed: 800,
				autoplay: {
					delay: 3000,
					disableOnInteraction: false,
				},
				navigation: {
					nextEl: ".instance-" + index + " .swiper-button-next",
					prevEl: ".instance-" + index + " .swiper-button-prev",
				},
				pagination: {
					el: ".instance-" + index + " .swiper-pagination",
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
					el: ".instance-" + index + " .swiper-scrollbar",
				},
			});
			index++;
		});

		var sub_index = 0;
		$(".mainSlider__sub_slider").each(function(){
			var $this = $(this);
			$this.addClass("sub_instance-" + sub_index);

			new Swiper(".sub_instance-" + sub_index, {
				slidesPerView: "auto",
				spaceBetween: 0,
				loop: true,
				speed: 800,
				autoplay: {
					delay: 3000,
					disableOnInteraction: false,
				},
				navigation: {
					nextEl: ".sub_instance-" + sub_index + " .swiper-button-next",
					prevEl: ".sub_instance-" + sub_index + " .swiper-button-prev",
				},
				pagination: {
					el: ".sub_instance-" + index + " .swiper-pagination",
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
					el: ".sub_instance-" + sub_index + " .swiper-scrollbar",
				},
			});
			sub_index++;
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
	if ($("body").find(".fb__store-slide").length) {
		var swiperMainVisual = new Swiper(".fb__store-slide", {
			slidesPerView: "auto",
			spaceBetween: 0,
			loop: true,
			speed: 800,
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
	}
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
		$(".detail-slide").on("mouseenter", function (e) {
			swiperDetailVisual.autoplay.stop();
		});
		$(".detail-slide").on("mouseleave", function (e) {
			swiperDetailVisual.autoplay.start();
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
	if ($("body").find(".fb-main__card-slider").length) {
		var swiperMainCard1 = new Swiper(".goods-slider1", {
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
				dragSize: "460",
				draggable: true,
			},
		});
		var swiperMainCard2 = new Swiper(".goods-slider2", {
			slidesPerView: "auto",
			spaceBetween: 0,
			//freeMode: true,
			freeModeMomentumRatio: 0.5, // 슬라이드 이동 속도를 줄임
			freeModeMomentumBounce: false, // 슬라이드 이동 튕김 효과를 없앰
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
				dragSize: "280",
				draggable: true,
			},
		});
		var swiperMainCard3 = new Swiper(".goods-slider3", {
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
				dragSize: "300",
				draggable: true,
			},
		});
		var swiperMainCard4 = new Swiper(".goods-slider-add", {
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
				dragSize: "339",
				draggable: true,
			},
		});
	}
	if ($("body").find(".fb-main__goods-slider").length) {
		/*2024-06-29 수정 시작*/
		var swiperMainGoods = new Swiper(".fb-main__goods-slider", {
			slidesPerView: "auto",
			spaceBetween: 0,
			loop: false,
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
				dragSize: "339",
				draggable: true,
			},
		});
		/*//2024-06-29 수정 끝*/
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
	}
}

//2024.04.14 수정 S
function popupSlide() {
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
	if ($("body").find(".popup-slide2").length) {
		var swiperPopupSlie = new Swiper(".popup-slide2", {
			slidesPerView: "auto",
			spaceBetween: 0,
			loop: true,
			speed: 400,
			autoplay: {
				delay: 3000,
				disableOnInteraction: false,
			},
			pagination: {
				el: ".popup-swiper-pagination2",
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
				el: ".popup-swiper-scrollbar2",
			},
		});
	}
}
//2024.04.14 수정 E

function topBtn() {
	$(window).scroll(function () {
		if ($(this).scrollTop() > 500) {
			$(".fb__floating__btn--top").parents("li").addClass("active");
		} else {
			$(".fb__floating__btn--top").parents("li").removeClass("active");
		}
	});

	$(".fb__floating__btn--top").click(function () {
		$("html, body").animate(
			{
				scrollTop: 0,
			},
			400
		);
		return false;
	});
}

function paginationLayer() {
	$(".fb__bubble")
		.children("a")
		.on("click", function () {
			if ($(this).next(".fb__go-page").is(":visible")) {
				$(this).removeClass("on");
				$(this).next(".fb__go-page").stop().fadeOut();
			} else {
				$(".fb__go-page").stop().fadeOut();
				$(".fb__bubble").find("a").removeClass("on");
				$(this).addClass("on");
				$(this).next(".fb__go-page").stop().fadeIn();
				$(this).next(".fb__go-page").find("input").focus();
			}
		});
}

function tabJS() {
	$(".fb-tab__wrap").each(function () {
		if ($(this).find(".fb-tab__contents-wrap").length) {
			var tabWrap = $(this);
			var tabItem = $(this).find(".fb-tab__nav").find("li");
			var tabItem2 = $(this).find(".fb-tab__nav-btn").find("li");
			tabItem.find("a").on("click", function () {
				var tabIex = $(this).parents("li").index();
				tabItem.removeClass("active");
				$(this).parents("li").addClass("active");
				tabWrap.find(".fb-tab__contents").removeClass("active");
				tabWrap.find(".fb-tab__contents").eq(tabIex).addClass("active");
				tabWrap.find("#devShippingName").eq(tabIex).val("");
				tabWrap.find("#devRecipient").eq(tabIex).val("");
				tabWrap.find("#devPcs2").eq(tabIex).val("");
				tabWrap.find("#devPcs3").eq(tabIex).val("");
				tabWrap.find("#devZip").eq(tabIex).val("");
				tabWrap.find("#devAddress1").eq(tabIex).val("");
				tabWrap.find("#devAddress2").eq(tabIex).val("");
				tabWrap.find("#devDefaultYn").eq(tabIex).prop('checked', false);
			});
			tabItem2.find("a").on("click", function () {
				var tabIex = $(this).parents("li").index();
				tabItem2.removeClass("active");
				$(this).parents("li").addClass("active");
				tabWrap.find(".fb-tab__contents").removeClass("active");
				tabWrap.find(".fb-tab__contents").eq(tabIex).addClass("active");
			});
		}
	});
	if ($("body").find(".fb-FocusNow__nav").length) {
		$(".fb-FocusNow__nav li").each(function () {
			$(this)
				.find("a")
				.on("click", function () {
					var navCont = $(this).attr("title");
					var navTOP = $("#" + navCont).offset().top;
					//console.log(navCont);
					//$(".fb-FocusNow__nav li").removeClass("active");
					//$(this).parents("li").addClass("active");
					$("html, body").animate({ scrollTop: navTOP - 212 }, 400);
				});
		});
		$(window).scroll(function () {
			var newSCL = $(window).scrollTop();
			$(".fb-FocusNow__nav li").each(function () {
				var navItem = $(this);
				var navCont2 = $(this).find("a").attr("title");
				var navTOP2 = $("#" + navCont2).offset().top;
				if (newSCL >= navTOP2 - 214) {
					$(".fb-FocusNow__nav li").removeClass("active");
					navItem.addClass("active");
				}
			});
		});
	}
	/* 상품 상세 좌측 tab JS */
	if ($("body").find(".fb__goods-view").length) {
		$(".detail-tab__nav")
			.find("li")
			.each(function () {
				$(this)
					.find("a")
					.on("click", function () {
						var navCont = $(this).attr("title");
						var navTOP = $("#" + navCont).offset().top;
						$("html, body").animate({ scrollTop: navTOP - 151 }, 400);
					});
			});
		$(".info__review-score")
			.find(".info__box-link")
			.on("click", function () {
				var navCont = $(this).attr("title");
				var navTOP = $("#" + navCont).offset().top;
				$("html, body").animate({ scrollTop: navTOP - 151 }, 400);
			});
		$(window).scroll(function () {
			var newSCL = $(window).scrollTop();
			$(".detail-tab__nav")
				.find("li")
				.each(function () {
					var navItem = $(this);
					var navCont2 = $(this).find("a").attr("title");
					var navTOP2 = $("#" + navCont2).offset().top;
					if (newSCL >= navTOP2 - 214) {
						$(".detail-tab__nav").find("li").removeClass("active");
						navItem.addClass("active");
					}
				});
		});
	}
	/* Q&A 아코디언 */
	/*
	if ($("body").find(".QnA-list__wrap").length) {
		$(".QnA-list__item.active").find(".QnA-list__cont").show();
		$(".QnA-list__title").on("click", function () {
			var qnaitem = $(this).parents(".QnA-list__item");
			qnaitem.toggleClass("active");
			if (qnaitem.hasClass("active")) {
				qnaitem.addClass("active");
				qnaitem.find(".QnA-list__cont").stop().slideDown();
			} else {
				$(this).removeClass("active");
				qnaitem.find(".QnA-list__cont").stop().slideUp();
			}
		});
	}
	*/
	/* 검색 */
	if ($("body").find(".fb__member-search").length) {
		$(".fb__member-search")
			.find(".search__nav__btn")
			.find("input[name='idsearch']")
			.on("click", function () {
				var ChkIX = $(this).parents("label").index();
				$(".search__wrap").find(".search__inner").removeClass("search__inner--show");
				$(this).parents(".search__wrap").find(".search__inner").eq(ChkIX).addClass("search__inner--show");
			});
		$(".fb__member-search")
			.find(".search__nav__btn")
			.find("input[name='searchType']")
			.on("click", function () {
				var ChkVal = $(this).val();
				//console.log(ChkVal);
				if (ChkVal == "email") {
					$(this).parents(".search__wrap").find(".search__inner").find(".phone_group").hide();
					$(this).parents(".search__wrap").find(".search__inner").find(".email_group").show();
				} else {
					$(this).parents(".search__wrap").find(".search__inner").find(".email_group").hide();
					$(this).parents(".search__wrap").find(".search__inner").find(".phone_group").show();
				}
			});
	}
}

function inputJS() {
	if ($("body").find("input[type='password']").length) {
		$(".fb__form-input").each(function () {
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
	if ($("body").find(".fb__form-write").length) {
		$(".fb__form-write").each(function () {
			var inputTXvalL = $(this).find("textarea").val().length;
			if (inputTXvalL >= 1) {
				$(this).parents(".fb__form-write").addClass("active");
			}
			$(this)
				.find("textarea")
				.on("focus keyup", function () {
					var inputTXval = $(this).val().length;
					if (inputTXval == 0) {
						$(this).parents(".fb__form-write").removeClass("error").removeClass("active");
					} else {
						$(this).parents(".fb__form-write").addClass("active");
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
		$(this).removeClass("popup-mask--show");
		$(".popup-layout").hide();
		$(".main_popupL").hide();
	});
	$(".main_popupL-closebtn").on("click", function () {
		$(".popup-mask").removeClass("popup-mask--show");
		$(".main_popupL").hide();
	});
	$(".main_popupL-checkbox").on("click", function () {
		$(".popup-mask").removeClass("popup-mask--show");
		$(".main_popupL").hide();
	});
	$(".popup-layout .btn-close").on("click", function () {
		$(".popup-mask").removeClass("popup-mask--show");
		$(".popup-layout").hide();
	});
}

function NewPopupJSNew(popID) {
	$(".popup-mask-goods-view").addClass("popup-mask--show");
	$("#" + popID).show();
}

function NewPopupCloseJSNew() {
	$(".popup-mask-goods-view").on("click", function () {
		$(this).removeClass("popup-mask--show");
		$(".popup-layout").hide();
		$(".main_popupL").hide();
	});
	$(".main_popupL-closebtn").on("click", function () {
		$(".popup-mask-goods-view").removeClass("popup-mask--show");
		$(".main_popupL").hide();
	});
	$(".main_popupL-checkbox").on("click", function () {
		$(".popup-mask-goods-view").removeClass("popup-mask--show");
		$(".main_popupL").hide();
	});
	$(".popup-layout .btn-close").on("click", function () {
		$(".popup-mask-goods-view").removeClass("popup-mask--show");
		$(".popup-layout").hide();
	});
}


function SidePopupJS(popID) {
	$(".fb__goods-view__info .info").hide();
	$(".fb__goods-view__layer").hide();
	$("#" + popID).show();
	$("#" + popID)
		.parents(".fb__goods-view__info")
		.addClass("layer");
}
function SidePopupCloseJS() {
	$(".fb__goods-view__layer .btn-close").on("click", function () {
		$(".fb__goods-view__layer").hide();
		$(".fb__goods-view__info .info").show();
		$(".fb__goods-view__info").removeClass("layer");
		/* 쿠폰 레이어 부분 JS */
		$(".fb__goods-view__layer").find(".popup-product__wrap").hide();
		$(".fb__goods-view__layer").find(".category-wrap").show();
		/* 반품&환불 안내 부분 JS */
		$(".fb__goods-view__layer").find(".cosmetics__link").removeClass("cosmetics__link--open");
		$(".fb__goods-view__layer").find(".cosmetics__info-wrap").hide();
		/* TAB JS */
		$(".fb__goods-view__layer").each(function () {
			$(this).find(".fb-tab__nav").find("li").removeClass("active");
			$(this).find(".fb-tab__nav").find("li").eq(0).addClass("active");
			$(this).find(".fb-tab__contents").removeClass("active");
			$(this).find(".fb-tab__contents").eq(0).addClass("active");
		});
	});
}
