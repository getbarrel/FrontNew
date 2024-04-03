"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/


/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

/**
 * 뷰티비 상단 영상 영역
 * @type {{run: iframeAPI.run}}
 */
var iframeAPI = {
    run:function(){
        var Main_iframe = document.getElementById('devVideo');
        var contents = Main_iframe.contentWindow || Main_iframe.contentDocument;
        iframeAPI = new smIframeAPI(contents);

        iframeAPI.onEvent (smIframeEvent.READY, function(){
            //크롬 정책으로 음소거되지 않은 영상에 대한 자동재생 불가로 음소거 처리 후 자동 재생 추가
            // iframeAPI.setMuted(true);
            // iframeAPI.play();
            // console.log('play-ready');
        });

        iframeAPI.onEvent(smIframeEvent.PLAY , function(){
            // 영상 재생 시 실행
            // console.log('play1');
        });

        iframeAPI.onEvent(smIframeEvent.PAUSE , function(){
            // 영상 일지정지 이벤트
            // console.log('pause1');
        });
        iframeAPI.onEvent (smIframeEvent.COMPLETE, function(){
            // 영상 재생완료 이벤트
            // console.log('complete1');

        });


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
    iframeAPI.run();
    devVideoViewCount.run();
});