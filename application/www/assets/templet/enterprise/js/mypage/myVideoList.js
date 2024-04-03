"use strict";
/*--------------------------------------------------------------*
 * 공용변수 선언 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devMyVideoList = {
    myVideoListAjax: false,
    init: function () {
        var self = this;
        self.myVideoListAjax = common.ajaxList();
        self.myVideoListAjax
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('tr')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devMyVideoList')
            .setUseHash(false)
            .setController('getSearchMyVideoList', 'video')
            .init(function (response) {
                self.myVideoListAjax.setContent(response.data.list, response.data.paging);
                // lazyload();//퍼블 레이지로드 삽입
                self.initViewCount();
            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.myVideoListAjax.getPage($(this).data('page'));
        });
    },
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
                       $('.devTokenId_'+youtubeId).html(data.data);
                   }
               );
           }
        });
    },
    initEvent: function () {
        var self = this;
        var $form = $('#devMyVideoList');
        $('#devVideoSubmit').on('click',function(){
            $form.submit();
        });

        $('#devListContents').on('click', '.devChangeVideoDisp', function(){
            var video_idx = $(this).data('video_idx');
            var change_disp = $('#devVideoDisp_'+video_idx+' option:selected').val();
            var orgDisp = $(this).data('disp');
            // Ajax Call
            common.ajax(
                common.util.getControllerUrl('changeVideoStatus', 'video'),
                {
                    video_idx: video_idx,
                    disp: change_disp
                },
                function () {
                    if (orgDisp == change_disp) {
                        common.noti.alert('상태값을 변경 해주세요');
                        return false;

                    }
                    return true;
                },
                function (data) {
                    if (data.result == 'success') {
                        common.noti.alert('사용여부가 변경되었습니다.')
                        self.myVideoListAjax.reload();
                    } else {
                        alert(data.result);
                    }
                }
            );

        });
    },
    run: function () {
        var self = this;

        self.init();
        self.initEvent();
    }
}

$(function () {
    devMyVideoList.run();

    $('.devDateBtn').on('click', function () {
        $('#devSdate').val($(this).data('sdate'));
        $('#devEdate').val($(this).data('edate'));
    });
});