/**
 * Created by frontend on 2019-12-16.
 */
/**
 * Created by forbiz on 2019-07-04.
 */
const mypage_profile = () => {
    const $document = $(document);


    // 비밀번호변경 레이어
    const popupChangePW = () => {
        $document.on('click', '.btn__change-pw', function() {


            let _title = $(this).data("title");

            if(typeof _title == 'undefined' || _title == '') {
                _title = '비밀번호 변경';
                // _title = $(this).text();
            } else {
                $("#devModalTitle").text(_title);
            }
        });
    }

    const profile_init = () => {
        popupChangePW();
    }

    profile_init();



}
export default mypage_profile;