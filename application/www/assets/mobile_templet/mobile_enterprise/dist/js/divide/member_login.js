/**
 * Created by forbiz on 2019-07-05.
 */
const member_login = () => {
    const $window = $(window);
    const $document = $(document);
    const $header = $('.br__header');
    const $footer = $('.br__dockbar');
    const $floatingMenu = $('.br__floating-btn');

    const nomemShow = () => {
        const $btn = $('.br__login--member .information__btn__nomem');
        $btn.on('click', function() {
           $('.br__login').toggleClass('br__login--show');
           $window.scrollTop(0);
            $header.addClass('up').removeClass('down').css({
                'margin-top':''
            });
           $window.trigger('scroll');

        });
    };

    const keyboard_show = () => {
        $document
            .on("focus", "#devLoginForm", function(){
                $header.addClass('down').removeClass('up').css({
                    'margin-top': - $header.height()
                });
                $footer.css({
                    'margin-bottom': - $footer.height()
                });
                $floatingMenu.css({
                    'margin-bottom': - $footer.height()
                });
            })
            .on("blur", "#devLoginForm", function(){
                $header.addClass('up').removeClass('down').css({
                    'margin-top':''
                });
                $footer.css({
                    'margin-bottom':''
                });
                $floatingMenu.css({
                    'margin-bottom':''
                });
            })
    }

    const member_login_init = () => {
        nomemShow();
        keyboard_show();
    }
    member_login_init();
}


export default member_login;