/**
 * Created by forbiz on 2019-02-11.
 */

const mypage_mileage = () => {
    const $document = $(document);

    const mileage_tab = () => {
        const $target = $(".fb__mypage__tab-menu");

        $document.on("click", ".fb__mypage__tab-menu", function(){
            const $this = $(this);
            $this.addClass("fb__mypage__tab-menu--active").siblings().removeClass("fb__mypage__tab-menu--active");
            return false;
        });


    }

    const mileage_init = () => {
        mileage_tab();
    }

    mileage_init();
}

export default mypage_mileage;