/**
 * Created by Forbiz on 2019-08-07.
 */
const shop_search = () => {
    const $document = $(document);
    const textareaPlaceholder = () => {

        const $placeholder = $('.textarea__placeholer');

        if($placeholder < 1) return ;

        $placeholder.siblings('textarea')
            .on('focusin', function() {
                $placeholder.hide();
            })
            .on('focusout', function() {
               if($(this).val().length < 1) {
                   $placeholder.show();
               }
            });
    }

    const email_select = () => {
        $document.on("change", ".js__email__select", function(){
            const _this_val = $(this).val();
            if (_this_val != "") {
                $(".js__email__selected").val(_this_val);
            } else {
                $(".js__email__selected").val("");
            }
        });
    }

    const shop_search_init = () => {
        textareaPlaceholder();
        email_select();
    }
    shop_search_init();
}

export default shop_search;