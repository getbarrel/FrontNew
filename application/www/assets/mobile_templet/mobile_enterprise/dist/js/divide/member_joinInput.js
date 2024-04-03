/**
 * Created by forbiz on 2019-07-24.
 */
const member_joinInput = () => {
    const $document = $(document);

    const name_input = () => {

        $(".js__joininput__name").on("change keyup ", function () {

            const reg_special = /[!\\"'\-.:;@#$%^&*\(\)_+~|0-9]/gi;
            const $this = $(this);
            const _temp = $this.val();
            if (reg_special.test(_temp)) {
                $this.val(_temp.replace(reg_special,""));
            }
        });
    }

    const joininput_init = () => {
        name_input();
    }
    joininput_init();
}


export default member_joinInput;