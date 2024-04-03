/**
 * Created by forbiz on 2019-02-11.
 */


import common from './divide/common';
import layout from './divide/layout';
import module from './divide/module';
import main from './divide/main';
import brand_brandList from './divide/brand_brandList';
import brand_brandDetail from './divide/brand_brandDetail';
import customer_cosmeticsCaution from './divide/cosmeticsCaution';
import customer_cliamGuide from './divide/customer_cliamGuide';
import customer_productPrecautions from './divide/customer_productPrecautions';
import customer_productRepairGuide from './divide/customer_productRepairGuide';
import customer_memberBenefit from './divide/customer_memberBenefit';
import event_eventList from './divide/event_eventList';
import event_eventDetail from './divide/event_detail';
import exhibition_exhibitionList from './divide/exhibition_exhibitionList';
import exhibition_exhibitionDetail from './divide/exhibition_exhibitionDetail';
import member_login from './divide/member_login';
import member_joinInput from './divide/member_joinInput';
import member_searchId from './divide/member_searchId';
import member_password from './divide/member_password';

import mypage_mileage from './divide/mypage_mileage';
import mypage_coupon from './divide/mypage_coupon';
import mypage_myGoodsInquiry from './divide/mypage_myGoodsInquiry';
import mypage_returnHistory from './divide/mypage_returnHistory';
import mypage_stockAlarm from './divide/mypage_stockAlarm';

import shop_goodsView from './divide/shop_goodsView';
import shop_b2bMall from './divide/shop_b2bMall';
import shop_goodsReview from './divide/shop_goodsReview';
import shop_infoInput from './divide/shop_infoInput';
import shop_goodsList from './divide/shop_goodsList';
import shop_subGoodsList from './divide/shop_subGoodsList';
import shop_search from './divide/shop_search';
import shop_goodsQnaWrite from './divide/shop_goodsQnaWrite';
import shop_cart from './divide/shop_cart';
import brand_info from './divide/brand_info';
import brand_issue from './divide/brand_issue';
import brand_technology from './divide/brand_technology';
import brand_sponsorship from './divide/brand_sponsorship';
import brand_visual from './divide/brand_visual';
import brand_cheering from './divide/brand_cheering';
import brand_applicationForm from './divide/brand_applicationForm';
import brand_applicationFormIndivisual from './divide/brand_applicationFormIndivisual';
import brand_applicationFormGroup from './divide/brand_applicationFormGroup';


import fat from './divide/fat';

import shop_goodsBest from './divide/goods_best';



import 'jquery-form';
import 'jquery-ui';
import 'jquery-datetimepicker';
import datepickerFactory from 'jquery-datepicker';
import datepickerJAFactory from 'jquery-datepicker/i18n/jquery.ui.datepicker-ko';
datepickerFactory($);
datepickerJAFactory($);
import 'jstree';
window.$ = window.jquery = window.jQuery = require('jquery');
require('jquery-lazy');
window.CryptoJS = require("crypto-js");
window.Handlebars = require("handlebars/dist/handlebars.js");

import Swiper from 'swiper/dist/js/swiper.js';
window.Swiper = Swiper;
//window.d = require("handlebars/dist/handlebars.js");
// window.common = './divide/common';
//import './divide/library';
//require('ax5core/dist/ax5core.js');
//import "ax5core/dist/ax5core.js";
//require('handlebars/dist/handlebars.js');
//import "handlebars/dist/handlebars.js";

const appMethods = {
    layout,
    module,
    main,
    //best_best,

    brand_brandList,
    brand_brandDetail,
    brand_info,
    brand_issue,
    brand_technology,
    brand_sponsorship,
    brand_visual,
    brand_cheering,
    brand_applicationForm,
    brand_applicationFormIndivisual,
    brand_applicationFormGroup,

    customer_cosmeticsCaution,
    customer_cliamGuide,
    customer_productPrecautions,
    customer_productRepairGuide,
    customer_memberBenefit,

    event_eventList,
    event_eventDetail,

    exhibition_exhibitionList,
    exhibition_exhibitionDetail,

    member_login,
    member_joinInput,
    member_searchId,
    member_password,

    mypage_mileage,
    mypage_coupon,
    //mypage_wishlist,
    mypage_myGoodsInquiry,
    mypage_returnHistory,
    mypage_stockAlarm,

    shop_goodsList,
    shop_goodsView,
    shop_goodsReview,
    shop_infoInput,
    shop_subGoodsList,
    shop_b2bMall,
    shop_search,
    shop_goodsQnaWrite,
	shop_cart,

    shop_goodsBest,
};

const appInit = () => {
    const appName = $('body').attr('id');
    if(appName) [common, layout, appMethods[appName]].forEach(method  => {
        if(method) method();

    });

};
document.addEventListener('DOMContentLoaded', async () => {
	appInit();

	if(window.barrelFat && window.barrelFat.useFat) window.dev_fat2 = await fat();
});
