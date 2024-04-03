/**
 * Created by forbiz on 2019-07-24.
 */
const mypage_receiptPrint = () => {
    const $document = $(document);
    const $window = $(window);

    const receipt_load = () => {
        $(".odeach__item__thumb").each ( function () {
            let $thumb = $(this).find("img");
            let _protocol = $thumb.data("protocol");
            let img;
            img = new Image();
            img.onload = function(e){
                $thumb.attr("src",$thumb.attr("src").replace(_protocol, ""))
            };

            img.src = $thumb.attr("src").replace(_protocol, "");
        });
    };
    const receipt_print = () => {

        const screen_shot = (e) => {
            const $capture_area =  $("#js__capture");
            $capture_area.addClass("js__capture--active");
            $window.scrollTop(0);

            html2canvas($capture_area[0], {
                allowTaint: false,
                useCORS: true,
                logging: true,
                //"proxy": "html2canvasproxy.php",
            }).then(canvas => {
                const _img_url = canvas.toDataURL();
                const iosCheck = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

                if ( navigator.userAgent.match(/WallavuAOSApp/) ) {//안드로이드 앱

                    appinterface("android", saveImg, _img_url);

                } else {
                    if ( iosCheck ) { //ios 웹, 앱
                        e.target.setAttribute("target","_blank");
                    }
                    // 안드로이드 웹
                    $window.scrollTop( $capture_area.height() );
                }

                var link = document.createElement("a");
                link.download = "receipt.jpg";
                link.href= _img_url;
                document.body.appendChild(link);
                link.click();

                // const imgLink = $('<a>').attr('href',_img_url).attr('download',"receipt.jpg").appendTo('body');
                // imgLink.get(0).click();
                // imgLink.remove();
                $capture_area.removeClass("js__capture--active");
            });
        }




        $document.on("click", ".js__receipt__print", function(e){
            screen_shot(e);
        });
    }

    const appinterface = (type, funcName, data, callback) => {
        /*
         * params
         * type     string (android, ios, both)
         * funcName  string (메서드명)
         * callback function (콜백함수)
         */
        if (type == "undefined") type="both";
        if (data == "undefined") data="";

        //const iosCheck = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

        if ( (type == 'android' || type == 'both')
            && navigator.userAgent.match(/AOSApp/i) ) {
            // 안드로이드
            window.JavascriptInterface[funcName](data);

            if (typeof callback == 'function') callback();
        }
        if ( (type == 'ios' || type == 'both')
            && navigator.userAgent.match(/IOSApp/i) ) {
            // IOS
            window.webkit.messageHandlers[funcName].postMessage(data);

            if (typeof callback == 'function') callback();
        }
    }

    const receipt_init = () => {
        receipt_load();
        receipt_print();

    }

    receipt_init();
}

export default mypage_receiptPrint;