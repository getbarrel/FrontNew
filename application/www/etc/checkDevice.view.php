<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView(true);

echo "
        <script>
            
            if( /Android/i.test(navigator.userAgent)) {
                // 안드로이드
                timeOutFromApp();
                location.href = 'intent://main_web#Intent;scheme=barrel;package=com.getbarrel;end';
            } else if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
                // iOS 아이폰, 아이패드, 아이팟
                timeOutFromApp();
                location.href = \"barrel://\";
            } else {
                // 그 외 디바이스
                location.href = '/';
            }
            
            function timeOutFromApp() {
                var visiteTm = ( new Date() ).getTime();
                setTimeout( function () {
                    if ( ( new Date() ).getTime() - visiteTm < 2000 ) {
                        if(/Android/i.test(navigator.userAgent)) {
                           // location.href = \"https://play.google.com/store/apps/details?id=com.getbarrel\";
            
                        } else {
                          //  location.href = \"https://itunes.apple.com/app/id1482594164\";
                        }
                    }
                } ,1500 );
            }
        </script>
";