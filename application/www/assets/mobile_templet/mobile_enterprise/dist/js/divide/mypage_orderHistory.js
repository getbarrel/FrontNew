/**
 * Created by forbiz on 2019-07-04.
 */
const mypage_orderHistory = () => {
    const $document = $(document);

    const time_select = () => {
        $document.on("change", ".js__sDate", function(){
            const $this = $(this);
            if ($this.val() == "timeSelect") {
                $(".br__sort__timeselect").addClass("br__sort__timeselect--show");
            } else {
                $(".br__sort__timeselect").removeClass("br__sort__timeselect--show");
            }
        });
    };

    const exchange_fold = () => {
        $document.on("click", ".odeach__exchange-detail__fold", function(){
            $(this).closest(".odeach__exchange-detail").toggleClass("odeach__exchange-detail--hide");
        })
    };

    const od_init = () => {
        time_select();
        exchange_fold();
    }

    od_init();



}
export default mypage_orderHistory;