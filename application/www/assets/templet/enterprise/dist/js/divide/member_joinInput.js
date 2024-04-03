/**
 * Created by forbiz on 2019-05-21.
 */
const member_joinInput = () => {

        const $document = $(document);

        const file_btn = () => {

            $document.on("change", "input[type=file]", function() {
                const $this = $(this);
                const _files = $this[0].files[0];

                if(!_files) return; // accept 된 파일이 아닌경우 값이 없음

                const _acceptType = $this.attr('accept');
                const _imgType = _files.type.replace('image/','');

                if(_acceptType.indexOf(_imgType) == -1 || _imgType == "") {
                    // accept된 파일 확장자가 아닌 경우
                    $this.val('');
                    $this.closest('.inputs__content').find('[type=text]').val('');
                    $this.closest('.inputs__content').find('.btn-dark').text('파일삭제');
                    $this.closest('.inputs__content').find('.btn-dark-line').attr('disabled',true);

                    // dev_common alert
                    common.noti.alert(common.lang.get('common.inputFormat.fileFormat.fail'));
                }
            });

        }

        const name_input = () => {
            $(".input__user-name").on("keyup", function () {
                const specialCharacters = /[!@#$%^&*\(\)_+~;']/gi;
                const _temp = $(this).val();
                if(specialCharacters.test(_temp)) {
                    $(".input__user-name").val(_temp.replace(specialCharacters,""));
                }
            });
        }

    const joininput_init = () => {
        //file_btn();
        name_input();
    }

    joininput_init();

}

export default member_joinInput;