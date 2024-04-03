const apply_group = () => {
    const $document = $(document);
    const $window = $(window);

    const terms_check = () => {
        //이용약관 전체동의
        $document.on("click", "#all_terms_check", function() {
            if ($(this).is(':checked')) {
                $(".br__join__terms ul input").prop('checked', true);
            } else {
                $('.br__join__terms ul input').prop('checked', false);
            }
        });

        //각 항목 클릭시
        $document.on("click", ".br__join__terms ul input", function() {
            const _termsInput = $(".br__join__terms ul input").length;
            const _checkedInput = $(".br__join__terms ul input[type='checkbox']:checked").length;
            if (_termsInput == _checkedInput) {
                $('#all_terms_check').prop('checked', true);
            } else {
                $('#all_terms_check').prop('checked', false);
            }
        });
        //약관 내용 보기
        $document.on("click", ".term-content", function() {
            const _termsTitle = $(this).siblings().find("input").attr("data-title");
            const _dataName = $(this).siblings().find("input").attr("data-name");

            $(".term__popup").show();
            $(".term__popup-name").html(_termsTitle);
            $(".term__popup-content").hide();
            $(".term__popup-content"+ "." + _dataName).show();
        });
        $document.on("click", ".term__popup .close", function() {
            $(".term__popup").hide();
        });
    }

    const name_input = () => {
        //$(".input__user-name").on("cahnge keypress keyup paste", function (e) {
        $(".br__group").on("change keypress keyup paste", ".js__joininput__name", function(e) {
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

        $(".br__group").on("change keypress keyup paste", ".js__joininput__number", function(e) {
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

    // 선수입력폼
    const team_number = () => {

        const addBtnDisable = () => {
            const btnAdd = $(".btn-add a");
            const _maxCount = $(".team-number .team-number__input").data('max');
            const _min = 0;
            const _sheetNum = $(".group-list").length;

            if(_sheetNum > _min && _sheetNum < _maxCount) {
                btnAdd.show();
            } else {
                btnAdd.hide();
            }
        };

        $document.on("keyup", ".team-number .team-number__input", function () {
            const $this = $(this);
            const $entryForm = $(".group-list-wrap");
            const _maxCount = $this.data('max');
            let _num = $this.val();

            // 최대 인원수 50명 제한
            if(_num > _maxCount) {
                _num = _maxCount;
                $this.val(_num);
            }

            if(_num>=1) {
                // 개수 노출
                $entryForm.addClass("group-list-wrap--show");


                var html = '';
                for(var i=0; i < _num; i++) {
                    var template = $('#entry-form__template').html();
                    html += template.replace(/#num#/gi, i);
                }
                $('.entry-form__list').empty().append(html);

                $(".devFile").fileupload({
                    dataType: 'json',
                    done: function (e, data) {
                        if(data.result.result == 'success') {
                            $(this).siblings('.devFileUrl').val(data.result.data.name);
                            $(this).siblings('.devImageUrlPath').val(data.result.data.newName);
                        }else {
                            alert('파일 업로드에 실패하였습니다.');
                        }
                    }
                });
                common.validation.set($('.devRequire'), {'required': true});
                common.inputFormat.set($('.devBirthday'), {'maxLength': 6});
                common.inputFormat.set($('.devPcs2,.devPcs3'), {'number': true, 'maxLength': 4});

            } else {
                // 비노출 상태
                $entryForm.removeClass("group-list-wrap--show");
            }
        });

        // 입력폼 삭제 버튼 클릭 이벤트
        // $document.on("click", ".group-list--delete", function(e){
        //     e.preventDefault();
        //
        //     const $sheet = $(this).parents(".group-list");
        //     const $numberInput = $(".team-number__input");
        //     const count = parseInt($numberInput.val()) - 1;
        //
        //     $sheet.remove();
        //     $numberInput.val(count);
        //
        //     addBtnDisable();
        // });

        // 선수추가하기 버튼 클릭시 입력폼 추가
        // $document.on("click", ".btn-add a", function(e){
        //     e.preventDefault();
        //
        //     const $numberInput = $(".team-number__input");
        //     const count = parseInt($numberInput.val());
        //
        //     var html = '';
        //     var template = $('#entry-form__template').html();
        //     html += template.replace(/#num#/gi, count);
        //     $('.entry-form__list').append(html);
        //
        //     $(".devFile").fileupload({
        //         dataType: 'json',
        //         done: function (e, data) {
        //             $(this).siblings(".devFileUrl").val(data.result.data);
        //         }
        //     });
        //
        //     $numberInput.val(count + 1);
        //
        //     addBtnDisable();
        // });

        // 참가종목 중복선택 방지 이벤트
        $document.on("change", ".firstPartEvent", function(){

            const $this = $(this);
            const $wrap = $this.closest('.group-list');
            const _val = $this.val();
            const $target = $wrap.find(".secondPartEvent");

            // 참가종목1에 값이 있을 경우에만 종목2 선택 가능하도록
            if(_val) {
                $target.val("");
                $target.attr("disabled", false);

                // 참가종목1의 선택값과 같은 참가종목2의 값 비노출
                $target.find("option").show()
                    .filter("[value="+_val+"]").hide();

            } else {
                $target.attr("disabled", true);
                $target.find("option").show();
            }
        });
    };

    const sheet_email = () => {
        $document.on("change", ".entry-form__sheet .email__select", function(){
            const $this = $(this);
            const $target = $this.find("option:selected").attr("value");;
            const $write_direct = $(".email__direct");

            if($target == "byself") {
                $this.addClass("email__select--hide");
                $write_direct.addClass("email__direct--show");
            } else {
                $this.removeClass("email__select--hide");
                $write_direct.removeClass("email__direct--show");
            }
        })
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

    // 전체 입력폼 초기화 기능
    const btn_reset = () => {
        $document.on("click", ".group__btn--reset", function () {
            $(".inputs").find("input").val("").prop('checked', false);
            $(".inputs").find("select").prop('selectedIndex',0);
        })
    }

    const checkAttendType = () => {
        $('.entry-form__sheet').each(function() {
            var $this = $(this);
            const type1 = $this.find('.firstPartEvent');
            const type2 = $this.find('.secondPartEvent');
            if(type1.val() != '') {
                type2.find('[value='+type1.val()+']').hide();
            }
        });

    }

    const apply_group_init = () => {
        terms_check();
        name_input();
        click_zipcode();
        team_number();
        // sheet_email();
        // file_upload();
        pw_regexp();
        btn_reset();
        checkAttendType();
    }
    apply_group_init();

}
export default apply_group;