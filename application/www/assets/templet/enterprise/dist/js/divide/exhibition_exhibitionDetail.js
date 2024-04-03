"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
import 'slick-carousel';
const exhibition_exhibitionDetail = () => {
    const $document = $(document);

    const exhibitionDetail_stickyMenu = () => {

        window.onscroll = function() {fixedTab()};

        const $tabMenu = document.getElementById("stickytab");
        const $tabMenuClass = $(".goodsbox-tab");
        //const $tabMenu = document.getElementsByClassName("goodsbox-tab");
        //const $tabMenu = $(".sj__event-detail .sj__event-detail__goodsbox .goodsbox-tab");

        const $sticky = $tabMenu.offsetTop;

        function fixedTab() {
            if (window.pageYOffset >= $sticky) {
                $tabMenu.classList.add("goodsbox-tab--sticky");
            } else {
                $tabMenu.classList.remove("goodsbox-tab--sticky");
            }
        }
    }

    const exhibitionDetail_init = () => {
        exhibitionDetail_stickyMenu();
    }

    exhibitionDetail_init();
}

export default exhibition_exhibitionDetail;