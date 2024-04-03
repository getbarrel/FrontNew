/**
 * Created by forbiz on 2019-05-21.
 */
const brand_applicationFormIndivisual = () => {

    const $document = $(document);
    const $window = $(window);

    const terms_check = () => {
        //이용약관 전체동의
        $document.on("click", "#all_terms_check", function() {
            if ($(this).is(':checked')) {
                $(".agree-content input[type=checkbox]").prop('checked', true);
            } else {
                $('.agree-content input[type=checkbox]').prop('checked', false);
            }
        });

        //각 항목 클릭시
        $document.on("click", ".agree-content input[type=checkbox]", function() {
            const _termsInput = $(".agree-content input[type=checkbox]").length;
            const _checkedInput = $(".agree-content input[type=checkbox]:checked").length;
            if (_termsInput == _checkedInput) {
                $('#all_terms_check').prop('checked', true);
            } else {
                $('#all_terms_check').prop('checked', false);
            }
        });
        //이용약관 전체보기
        $(".inputs__content--use").on("click",function(e){
            e.preventDefault();
            common.util.popup('/company/agreement/sprint' ,600, 400,'',true);
        });

        //개인정보 수집 및 이용
        $(".inputs__content--private").on("click",function(e){
            e.preventDefault();
            common.util.popup('/company/privacy/sprint',600,750,'',true);
        });
    }

    const name_input = () => {
        $(".fb__application-form").on("change keypress keyup paste", ".input__user-name", function(e) {
            //const reg_special =  /[\{\}\[\]\/?.,;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"]/gi;
            const reg_special =  /[^(가-힣ㄱ-ㅎㅏ-ㅣa-zA-Z0-9)]|[\(]|[\)]/gi;
            if(e.type == 'keypress') {
                if(reg_special.test(e.key)) {
                    if(e.originalEvent) {
                        e.originalEvent.returnValue = false;
                    }else {
                        e.returnValue = false;
                    }
                    return false;
                }
            }else {
                const $this = $(this);
                const _temp = $this.val();
                if (reg_special.test(_temp)) {
                    $this.val(_temp.replace(reg_special,""));
                }
            }
        });

        $(".fb__application-form").on("change keypress keyup paste", ".input__user-number", function(e) {
            const reg_special =  /[^(0-9)]/gi;
            if(e.type == 'keypress') {
                if(reg_special.test(e.key)) {
                    if(e.originalEvent) {
                        e.originalEvent.returnValue = false;
                    }else {
                        e.returnValue = false;
                    }
                    return false;
                }
            }else {
                const $this = $(this);
                const _temp = $this.val();
                if (reg_special.test(_temp)) {
                    $this.val(_temp.replace(reg_special,""));
                }
            }

        });
    }

    //주소 찾기
    const click_zipcode = () => {
        const zipResponse = function (response) {
            $('#devZip').val(response.zipcode);
            $('#devAddress1').val(response.address1);
        };

        $document.on("click", "#devZipPopupButton", function (e) {
            e.preventDefault();
            common.util.zipcode.popup(zipResponse);
        });
    }

    const birth_input = () => {
        $(".input__user-birth").on("keyup", function () {
            const specialCharacters = /[!@#$%^&*\(\)_+~;']/gi;
            const _temp = $(this).val();
            if(specialCharacters.test(_temp)) {
                $(".input__user-birth").val(_temp.replace(specialCharacters,""));
            }
        });
    }

    //파일 업로드
    const file_upload = () => {
        $document.on("change", ".file-box .file__upload", function(){

            if(window.FileReader) { // Mordern browser
                var filename = $(this)[0].files[0].name;
            } else {    // old IE
                var filename = $(this).val().split('/').pop().split('\\').pop(); // 파일명만 추출
            }

            const filetype = filename.slice(filename.indexOf(".") + 1).toLowerCase(); // 파일 확장자를 잘라내고, 비교를 위해 소문자로 변경
            const fileSize = $('.file__upload')[0].files[0].size;
            const maxSize  = 5 * 1024 * 1024;    // 30MB

            if(filetype != "jpg" && filetype != "png" &&  filetype != "jepg"){  // 파일 확장자 체크
                alert('썸네일은 이미지 파일(jpg, jepg, png)만 등록 가능합니다.');
                $(this).siblings('.find-file__name').val("");
            } else if(fileSize > maxSize) { // 파일 용량 체크
                alert("파일은 30MB 이내로 등록 가능합니다.");
                $(this).siblings('.find-file__name').val("");
            } else {
                // 추출한 파일명 삽입
                $(this).siblings('.find-file__name').val(filename);
            }
        });
    }

    // 입급자명 체크박스 선택시 신청자이름 가져오기
    const deposit_info = () => {
        $document.on("change", ".deposit__info__name input[type=checkbox]", function () {
            const $checkbox = $(".deposit__info__checkbox input[type=checkbox]");
            const $target = $checkbox.closest(".deposit__info__name").find("input[type=text]");
            const $copy_name =  $(".target-name").val();

            if($checkbox.prop('checked')) {
                $target.val($copy_name);
            } else {
                //$target.val("");
            }
        })
            .on("keyup", ".deposit__info__name input[type=text]", function() {
                 $('.deposit__info__name input[type=checkbox]').prop('checked', false).attr('checked', false);
            });
    }

    // 비밀번호(숫자) 글자수 제한 /^[0-9]+$/
    const pw_regexp = () => {

        $document.on("keyup", ".deposit__info__password input[type=text]", function () {

            const regexp = /^[0-9]*$/

            const _val = $(this).val();

            if( !regexp.test(_val) ) {
                alert("숫자만 입력하세요");
                $(this).val("");
            }
        })
    }

    // 소속명 특수기호 사용불가 이벤트
    const partName_input = () => {

    }

    // 전체 입력폼 초기화 기능
    const btn_reset = () => {
        $document.on("click", ".group__btn--reset", function () {
            $(".inputs").find("input").val("").prop('checked', false);
            $(".inputs").find("select").prop('selectedIndex',0);
        })
    }

    const checkAttendType = () => {
        const type1 = $('#devAttendEvent1');
        const type2 = $('#devAttendEvent2');
        if(type1.val() != '') {
            type2.find('[value='+type1.val()+']').hide();
        }
    }

    const applicationForm_init = () => {
        terms_check();
        name_input();
        click_zipcode();
        file_upload();
        deposit_info();
        pw_regexp();
        birth_input();
        partName_input();
        btn_reset();
        checkAttendType();
    }

    applicationForm_init();

}

export default brand_applicationFormIndivisual;