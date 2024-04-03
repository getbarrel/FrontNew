"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('videoWishlist.delete.confirm', "선택한 영상을 삭제하시겠습니까?"); //Confirm_12
common.lang.load('videoWishlist.delete.alert', "삭제할 영상을 선택해 주세요."); //Confirm_12



var devVideoWishListObj = {
    myVideoWishList: common.ajaxList(),
    initAjaxList: function () {
        var self = this;

        self.myVideoWishList.setContainerType('div')
            .setContainer('#devMyVideoWishContent')
            .setEmptyTpl('#devMyVideoWishEmpty')
            .setLoadingTpl('#devMyVideoWishLoading')
            .setListTpl('#devMyVideoWishList')
            .setForm('#devMyVideoWishForm')
            .setController('getWishMyVideo', 'video')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .init(function (response) {

               self.myVideoWishList.setContent(response.data.list, response.data.paging);
               devVideoViewCount.run();
            });
    },
    initEvent: function () {
        var self = this;

        $('#devPageWrap').on('click', '.devPageBtnCls', function () {
            var pageNum = $(this).data('page');
            self.myVideoWishList.getPage(pageNum);
        });


        // 관심상품 일괄삭제
        $('#devBtnDelVideoWish').on('click', function () {

            var searchIDs = $("#devMyVideoWishContent input:checkbox:checked").map(function () {
                return $(this).val();
            }).get();

            if (searchIDs == "") {
                common.noti.alert(common.lang.get("videoWishlist.delete.alert"));
                return false;
            } else {

                if (common.noti.confirm(common.lang.get('videoWishlist.delete.confirm'))) {
                    common.ajax(
                        common.util.getControllerUrl('deleteMyVideoWishList', 'video'),
                        {videoWishList: searchIDs},
                        function () {},
                        function (response) {
                            if (response.result == "success") {
                                self.myWishList.reload();
                            } else {
                                common.noti.alert('system error');
                            }
                        }
                    );
                }
            }
        });
    },
    run: function () {
        this.initAjaxList();
        this.initEvent();
    }
}

var devVideoViewCount = {
    videoViewCountAjax: false,
    initViewCount: function(){
        var self = this;
        $('.devViewCount').each(function(){
            var video_category = $(this).data('video_category');
            if(video_category == 'Y'){
                var youtubeId = $(this).data('token');
                common.ajax(
                    common.util.getControllerUrl('getYoutubeInfoByViewCount', 'video'),
                    {
                        youtube_id: youtubeId
                    },
                    '',
                    function (data) {
                        $('.devTokenId_'+youtubeId+' em').html(data.data);
                    }
                );
            }
        });
    },
    run: function () {
        var self = this;
        self.initViewCount();
    }
}

$(function () {
    devVideoWishListObj.run();
});