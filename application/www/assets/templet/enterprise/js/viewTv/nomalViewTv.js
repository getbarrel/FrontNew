/**
 * Created by moon on 2019-04-16.
 */
var devNomalViewTvList = {
    nomalTvAjax: false,
    init: function () {
        var self = this;
        self.nomalTvAjax = common.ajaxList();
        self.nomalTvAjax
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('div')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(true)
            .setController('getNomalViewTv', 'viewtv')
            .init(function (response) {
                // 전체 상품 수
                //$('#devTotalProduct').text(common.util.numberFormat(response.data.total));
                self.nomalTvAjax.setContent(response.data.list, response.data.paging);
                lazyload();//퍼블 레이지로드 삽입
                devVideoViewCount.run();
            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.nomalTvAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function() {
        var self = this;

        $('.devSortTab').on('click', function(){
            $('#devSort').val($(this).data('sort'));
            $(this).addClass('active').siblings().removeClass('active');

            self.nomalTvAjax.getPage(1);
        });

        $('.devSubCategoryTab').on('click', function(){
            $('#devCid').val($(this).attr('devSubCategory'));

            self.nomalTvAjax.getPage(1);
        });

        $('.devViewTvListType').on('click',function(){
            var sortVal = $(this).attr('data-type-value');
            $('#devSort').val(sortVal);
            self.nomalTvAjax.getPage(1);
        });


        $('.devPageSubSelect').on('change', function(){
            $('#devCid').val($(this).val());
            self.nomalTvAjax.getPage(1);

        });

    },
    run: function(){
        var self = this;

        self.init();
        self.initEvent();
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
    devNomalViewTvList.run();
});