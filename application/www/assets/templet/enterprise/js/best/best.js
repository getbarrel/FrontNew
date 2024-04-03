// "use strict";
// /*--------------------------------------------------------------*
//  * 퍼블 *
//  *--------------------------------------------------------------*/
//
// /*--------------------------------------------------------------*
//  * 개발 *
//  *--------------------------------------------------------------*/
//
// var devBestProductList = {
//     bestProductListAjax: false,
//     init: function () {
//         var self = this;
//         self.bestProductListAjax = common.ajaxList();
//         self.bestProductListAjax
//             .setLoadingTpl('#devListLoading')
//             .setListTpl('#devListDetail')
//             .setEmptyTpl('#devListEmpty')
//             .setContainerType('ul')
//             .setContainer('#devListContents')
//             .setPagination('#devPageWrap')
//             .setPageNum('#devPage')
//             .setForm('#devListForm')
//             .setUseHash(true)
//             .setController('getBestProducts', 'product')
//             .init(function (response) {
//
//                 self.bestProductListAjax.setContent(response.data.list, response.data.paging);
//                 lazyload();//퍼블 레이지로드 삽입
//             });
//
//         $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
//             self.bestProductListAjax.getPage($(this).data('page'));
//         });
//     },
//     initEvent: function() {
//         var self = this;
//
//         $('.devSubCategoryTab').on('click', function(){
//             $('#devCid').val($(this).attr('devSubCategory'));
//             $('.devSubCategoryTab').removeClass('list-menu__list--active');
//             $(this).addClass('list-menu__list--active');
//             self.bestProductListAjax.getPage(1);
//         });
//
//     },
//     run: function(){
//         var self = this;
//
//         self.init();
//         self.initEvent();
//     }
// }
//
// $(function () {
//     devBestProductList.run();
// });
