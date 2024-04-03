/**
 * Created by forbiz on 2019-02-11.
 */


import common from './divide/common';
import layout from './divide/layout';
//import module from './divide/module';

import main from './divide/main';
import shop_goodsList from './divide/shop_goodsList';
import shop_goodsView from './divide/shop_goodsView';
import shop_infoInput from './divide/shop_infoInput';
import shop_cart from './divide/shop_cart';
import shop_search from './divide/shop_search';
import mypage_mileage from './divide/mypage_mileage';
import mypage_myGoodsInquiry from './divide/mypage_myGoodsInquiry';
import mypage_orderHistory from './divide/mypage_orderHistory';
import mypage_orderClaim from './divide/mypage_orderClaim';
import mypage_coupon from './divide/mypage_coupon';
import mypage_receiptPrint from './divide/mypage_receiptPrint';
import mypage_returnHistory from './divide/mypage_returnHistory';
import mypage_profile from './divide/mypage_profile';
import member_login from './divide/member_login';
import member_searchId from './divide/member_searchId';
import member_searchPw from './divide/member_searchPw';
import member_joinInput from './divide/member_joinInput';
import customer_faq from './divide/customer_faq';
import customer_storeInformationDetail from './divide/customer_storeInformationDetail';
import customer_qna from './divide/customer_qna';
import customer_cliamGuide from './divide/customer_cliamGuide';
import customer_productPrecautions from './divide/customer_productPrecautions';
import customer_productRepairGuide from './divide/customer_productRepairGuide';
import customer_cosmeticsCaution from './divide/customer_cosmeticsCaution';
import customer_memberBenefit from './divide/customer_memberBenefit';
import shop_goodsQnaWrite from './divide/shop_goodsQnaWrite';
import brand_technology from './divide/brand_technology';
import brand_sponsorship from './divide/brand_sponsorship';
import brand_issue from './divide/brand_issue';
import brand_visual from './divide/brand_visual';
import brand_cheering from './divide/brand_cheering';
import brand_applicationFormGroup from './divide/brand_applicationFormGroup';
import brand_applicationFormIndivisual from './divide/brand_applicationFormIndivisual';
import shop_goodsBest from './divide/goods_best';



const mypage_stockAlarm = customer_faq;
import 'jquery-form';
import 'jquery-ui';
import 'jquery-datetimepicker';
import datepickerFactory from 'jquery-datepicker';
import datepickerJAFactory from 'jquery-datepicker/i18n/jquery.ui.datepicker-ko';
datepickerFactory($);
datepickerJAFactory($);
import 'jstree';
window.$ = window.jquery = window.jQuery = require('jquery');

import Swiper from 'swiper';
window.Swiper = Swiper;

import html2canvas from 'html2canvas';
window.html2canvas = html2canvas;

require('jquery-lazy');
window.CryptoJS = require("crypto-js");
window.Handlebars = require("handlebars/dist/handlebars.js");


// rem 적용 페이지
if($('html').hasClass('crema-type')) {
    /* resize */
    var htmlDoc = document.documentElement,
        enSizing = false;

    function setFontSize() {
        //if( window.innerWidth > window.innerHeight ) return;
        if(window.innerWidth > window.innerHeight) {
            htmlDoc.style.fontSize =  (parseInt((window.innerHeight/320*62.5) * 100000) / 100000) + '%';
        }else {
            htmlDoc.style.fontSize =  (parseInt((window.innerWidth/320*62.5) * 100000) / 100000) + '%';
        }
        
    }
    window.onresize = function() {
        if (!enSizing) {
            window.requestAnimationFrame(function() {
                setFontSize();
                enSizing = false;
            });
        }
        enSizing = true;
    }
    window.dispatchEvent(new Event('resize'));
}


const appMethods = {
    main,
    shop_goodsList,
    mypage_mileage,
    mypage_myGoodsInquiry,
    member_login,
    member_searchId,
    member_searchPw,
    member_joinInput,
    customer_faq,
    shop_goodsView,
    customer_storeInformationDetail,
    shop_infoInput,
    shop_cart,
    shop_search,
    customer_qna,
    mypage_stockAlarm,
    mypage_orderHistory,
    mypage_orderClaim,
    mypage_coupon,
    mypage_receiptPrint,
    mypage_returnHistory,
    customer_cliamGuide,
    customer_productPrecautions,
    customer_productRepairGuide,
    customer_cosmeticsCaution,
    customer_memberBenefit,
    shop_goodsQnaWrite,
    brand_issue,
    brand_visual,
    brand_technology,
    brand_sponsorship,
    brand_cheering,
    brand_applicationFormGroup,
    brand_applicationFormIndivisual,
    shop_goodsBest,
    mypage_profile,

};
const appInit = () => {
    const appName = $('body').attr('id');
    if(appName) [common, layout, appMethods[appName]].forEach(method  => {
        if(method) method();
    });
};
document.addEventListener('DOMContentLoaded', () => {
    appInit();
});

