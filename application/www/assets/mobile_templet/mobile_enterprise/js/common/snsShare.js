"use strict";

var snsShare = new function() {
    //속성값 세팅
    this.schema = "enter40";
    this.kakaoKey = common.kakaoScriptKey;
    this.kakaoInit = false;
    this.title = $("meta[property='og:title']").attr('content');
    this.description = $("meta[property='og:description']").attr('content');
    this.url = $("meta[property='og:url']").attr('content');
    this.image = $("meta[property='og:image']").attr('content');

    this.snsUrl = {};
    this.snsUrl['naver'] = "http://share.naver.com/web/shareView.nhn?url=" + encodeURIComponent(this.url) + "&title=" + encodeURIComponent(this.title);
    this.snsUrl['twitter'] = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(this.title) + ' ' + encodeURIComponent(this.url);
    this.snsUrl['facebook'] = "http://www.facebook.com/share.php?u=" + encodeURIComponent(this.url);
    this.snsUrl['pinterest'] = "http://www.pinterest.com/pin/create/button/?url=" + encodeURIComponent(this.url) + "&media="+ this.image +"&description=" + encodeURIComponent(this.title);
    this.snsUrl['band'] = "http://band.us/plugin/share?body=" + encodeURIComponent(this.title) + "  " + encodeURIComponent(this.url) + "&route=" + encodeURIComponent(this.url);
    this.snsUrl['line'] = "http://line.me/R/msg/text/?" + encodeURIComponent(this.title + "\n" + this.url);
    this.snsUrl['google'] = "https://plus.google.com/share?url=" + encodeURIComponent(this.url) + "&t=" + encodeURIComponent(this.title);

    this.appData = {};
    this.appData['pname'] = this.title;
    this.appData['url'] = this.url;
    this.appData['shotinfo'] = this.description;
    this.appData['img'] = this.image;
    this.appData['sendtype'] = "";

    //SNS 공유 스크립트!
    this.toSNS = function (sns,appType){
        if(appType !=""){
            this.toSNSApp(sns,appType);
        }else{
            this.toSNSWeb(sns);
        }
    }

    //SNS 공유 <웹>
    this.toSNSWeb = function (sns){

        if(sns == 'kakaotalk'){
            if(!this.kakaoInit){ this.setKakaoInit(); }
            this.kakaoTalkShare();
        }else if(sns == 'kakaostory'){
            if(!this.kakaoInit){ this.setKakaoInit(); }
            this.kakaoStoryShare();
        }else if(sns == 'url-copy'){
            var url = '';    // <a>태그에서 호출한 함수인 clip 생성
            var textarea = document.createElement("textarea");
            //url 변수 생성 후, textarea라는 변수에 textarea의 요소를 생성

            document.body.appendChild(textarea); //</body> 바로 위에 textarea를 추가(임시 공간이라 위치는 상관 없음)
            url = window.document.location.href;  //url에는 현재 주소값을 넣어줌
            textarea.value = url;  // textarea 값에 url를 넣어줌
            textarea.select();  //textarea를 설정
            document.execCommand("copy");   // 복사
            document.body.removeChild(textarea); //extarea 요소를 없애줌

            alert('상품의 URL이 복사되었습니다.'); // alert창을 띄워서 확인.
            //this.copyClip();
            return false;
        }else{
            window.open(this.snsUrl[sns], 'pop', 'menubar=no,status=no,scrollbars=yes,resizable=yes,width=500,height=300,top=50,left=50');
        }
    }

    //SNS 공유 <APP>
    this.toSNSApp = function (sns,appType){
        if(sns == 'kakaotalk') {
            if(appType=='I'){
                document.location.href= this.schema+'://app_type=kakaotalk&app_link='+ encodeURIComponent(this.url) +'&pname='+this.title+ '&img_url=' +encodeURIComponent(this.image);
            }else if(appType=='A'){
                window.JavascriptBridge.setSocialData( this.getAppData(appType) );
                return false;
            }
        }else{
            document.location.href=this.schema+'://share_link_url='+ encodeURIComponent(this.snsUrl[sns]);
        }
    }

    //App 데이터 생성
    this.getAppData = function( appType ){
        this.appData['sendtype'] = appType;
        return JSON.stringify(this.appData);
    }

    //카카오 세팅
    this.setKakaoInit = function (){
        // 사용할 앱의 JavaScript 키를 설정해 주세요
        Kakao.init(this.kakaoKey);
        this.kakaoInit = true;
    }

    // 카카오링크 버튼을 생성합니다. 처음 한번만 호출하면 됩니다.
    this.kakaoTalkShare = function () {
        console.log(this);
        console.log("===");
        console.log(this.url);
        Kakao.Link.sendScrap({
            requestUrl: this.url
        });
    }

    //카카오 스토리 공유
    this.kakaoStoryShare = function () {
        Kakao.Story.share({
            url: this.url,
            text: this.title
        });
    }

    //URL 복사
    this.copyClip = function () {
        common.lang.load('goodsView.shareLayer.uriCopy.ie', '이 글의 단축url이 클립보드에 복사되었습니다.');
        common.lang.load('goodsView.shareLayer.uriCopy', '이 글의 단축url입니다. Ctrl+C를 눌러 클립보드로 복사하세요.');
        if (navigator.userAgent.match(/BarrelAOSApp/)) {
            window.JavascriptInterface.copyClipBoard(this.url);
        } else if (navigator.userAgent.match(/BarrelIOSApp/i)) {
            window.webkit.messageHandlers.copyClipBoard.postMessage(this.url);
        } else {
            var IE = (document.all) ? true : false;
            console.log( this.url)
            if (IE) {
                window.clipboardData.setData("Text", this.url);
                alert(common.lang.get('goodsView.shareLayer.uriCopy.ie'));
            } else {
                var temp = prompt(common.lang.get('goodsView.shareLayer.uriCopy'), this.url);
            }

        }

    }
};

$(function () {
    $('body').on('click', '[devSnsShare]', function () {
        var snsType = $(this).attr('devSnsShare');
        var appType = '';
        snsShare.toSNS(snsType, appType);
    });
});