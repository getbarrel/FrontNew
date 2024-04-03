<?php
function _is_mobile()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i',
            $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}

if(_is_mobile()){
    include __DIR__."/index_mobile.html";
}else{
    include __DIR__."/index_web.html";
}


