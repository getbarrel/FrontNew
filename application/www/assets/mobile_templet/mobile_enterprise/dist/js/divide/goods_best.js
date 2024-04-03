/**
 * Created by frontend on 2019-11-29.
 */
const goods_best = () => {
    const $document = $(document);
    const bestTab_slider = () => {
		
		// TODO: 추후 정리
		// const $categoryElement = $("#goods-best-category__wrapper");
        // const categoryTop = $categoryElement.offset().top;
		// const $banner = $("#header .header__banner");
		// const $header = $("#header .br__header__inner");
        // let _arr = [];
        // let _index = -1;
        // let _result = null;

		// $($(".fb__goods-best__tnb-list")[0]).addClass("fb__goods-best__tnb-list--active");

		// $.each($(".br__slide__best-goods"), function(i, e) {
		// 	_arr.unshift($(e).offset().top);
		// });

        // $(window).on("scroll.best", function(e) {
		// 	const bannerHeight = $banner && $banner.length ? $banner.outerHeight() : 0;
		// 	const headerHeight = $header && $header.length ? $header.outerHeight() : 0;
		// 	const $headerDown = $("#header.br__header.down .br__header__inner");
		// 	const headerMarginTop = $headerDown && $headerDown.length ? parseFloat($headerDown.css("margin-top")) : 0;

        //     if(window.scrollY + headerHeight + bannerHeight + headerMarginTop >= categoryTop) {
        //         $categoryElement.css({
        //             position: "fixed",
        //             top: headerHeight + bannerHeight + headerMarginTop + "px",
        //             borderBottom: "1px solid #bcbcbc",
        //         });
        //     }
        //     else {
        //         $categoryElement.attr("style", "");
        //     }

        //     _index = _arr.findIndex(function(v, i) {
        //         return window.scrollY + (headerHeight + bannerHeight + $categoryElement.outerHeight()) + $categoryElement.outerHeight() + 5 >= v;
        //     });
        //     _result = _index < 0 ? _arr.length-1 : _index;

        //     $(".fb__goods-best__tnb-list").removeClass("fb__goods-best__tnb-list--active");
        //     $("[href='#best-contents_"+(_arr.length - _result)+"']").addClass("fb__goods-best__tnb-list--active");
        // })

        // $document.on("click", ".fb__goods-best__tnb-list", function() {
		// 	const bannerHeight = $banner && $banner.length ? $banner.outerHeight() : 0;
		// 	const headerHeight = $header && $header.length ? $header.outerHeight() : 0;
		// 	const $headerDown = $("#header.br__header.down .br__header__inner");
		// 	const headerMarginTop = $headerDown && $headerDown.length ? parseFloat($headerDown.css("margin-top")) : 0;
		// 	const _this = $(this);

        //     $('html, body').stop().animate({
        //         scrollTop: $(_this.attr("href")).offset().top - (headerHeight + bannerHeight + $categoryElement.outerHeight() - 5)
        //     }, 1);

        //     return false;
        // });
	}
	

    const goodsBest_init = () => {
        $document.ready(function() {
			bestTab_slider();
		})
	}
	
    goodsBest_init();
}

export default goods_best;