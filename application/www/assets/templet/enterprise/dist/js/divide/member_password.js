/**
 * Created by forbiz on 2019-07-05.
 */
const member_password = () => {
    const $document = $(document);
    const $window = $(window);

    const check_validation = () => {

        const $target = $(".js__pw__form");

        $document.on("keyup change", ".js__check__pw, .js__pw", function(){

            const _pw_value = $target.find(".js__pw").val();
            const _check_value = $target.find(".js__check__pw").val();

            if (_check_value != _pw_value) {
                $target.find(".js__pw__error").addClass("fb__password__error--show");
            } else {
                $target.find(".js__pw__error").removeClass("fb__password__error--show");
            }
        })
    }

    const password_init = () => {
        check_validation();
    }

    password_init();
}


export default member_password;