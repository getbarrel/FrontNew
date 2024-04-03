/**
 * Created by forbiz on 2019-02-11.
 */

const mypage_coupon = () => {
    const $document = $(document);

    const coupon_tab = () => {
        const $target = $(".br__mypage-coupon__contents");

        $document
            .on("click", ".fb__mypage__tab-menu", function(){
            const $this = $(this);
            $(".fb__mypage__tab-menu").removeClass("fb__mypage__tab-menu--active");
            $this.addClass("fb__mypage__tab-menu--active");
            $(".coupon-list__download").removeClass("coupon-list__download--show");
            $(`.coupon-list__download__${$this.attr("data-target")}`).addClass("coupon-list__download--show");
            return false;
        });

    }

    const coupon_init = () => {
        coupon_tab();
    }

    coupon_init();
}

export default mypage_coupon;