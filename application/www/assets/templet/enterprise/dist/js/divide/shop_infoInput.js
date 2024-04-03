/**
 * Created by Forbiz on 2019-05-31.
 */
import 'slick-carousel';
const shop_infoInput = () => {
    const $document = $(document);

    const coupon_popup_select = () => {
        $document
            .on("change", '.js__coupon__target select', function() {
                const $this = $(this);
                if($this.val()) {
                    $this.closest(".js__coupon__target").find(".js__coupon__cancel")
                        .addClass('coupon-box__choice-cancel--active');
                } else {
                    $this.closest(".js__coupon__target").find(".js__coupon__cancel")
                        .removeClass('coupon-box__choice-cancel--active');
                }
            })
    }

    const coupon_popup_cancel = () => {
        $document
            .on("click", '.js__coupon__cancel', function(){
                const $this = $(this);
                $this.closest(".js__coupon__target").find('select').val('').trigger("change");
                return false;
            })
    }

    const coupon_pop_fold = () => {
        $document.on("click", ".js__coupon__fold", function(){
            const $this = $(this);
            $this.toggleClass("couponpop__fold-icon--active");
            $this.closest("section").find(".js__coupon__fold-target").toggle();
        });
    }

    const email_select = () => {

        const $select_target = $(".js__infoinput__email-target");

        $document.on("change", ".js__infoinput__email-select", function(){
            const _email_selected = $(this).val();
            if(_email_selected != "") {
                $select_target.val(_email_selected);
            } else {
                $select_target.val("");
            }
        })
    }

    const infoInput_init = () => {
        coupon_popup_select();
        coupon_popup_cancel();
        coupon_pop_fold();
        email_select();
    }

    infoInput_init();
}

export default shop_infoInput;