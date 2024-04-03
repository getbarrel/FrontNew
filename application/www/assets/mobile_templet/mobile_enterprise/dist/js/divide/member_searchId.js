/**
 * Created by forbiz on 2019-07-08.
 */
const member_searchId = () => {
    const $window = $(window);

    const searchIdType = () => {
        const $inputs = $('.br__find-user__label input');
        const $contents =  $('.br__find-user__form');

        $inputs.on('change', function() {
            const $this = $(this);
            const type = $this.attr('data-type');
            if($this.prop('checked')){
            $contents.removeClass('br__find-user__form--show')
                .filter(`[class*=${type}]`).addClass('br__find-user__form--show');
            }
        }).trigger('change');

    }

    const member_searchId_init = () => {
        searchIdType();
    }
    member_searchId_init();
}


export default member_searchId;