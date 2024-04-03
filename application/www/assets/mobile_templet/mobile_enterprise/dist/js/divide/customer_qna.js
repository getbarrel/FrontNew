/**
 * Created by forbiz on 2019-07-22.
 */
const mypage_myInquiry = () => {
    const $window = $(window);

    //파일 선택
    const changeFile = () => {
        const $input = $('.write-upload-file input[type=file]');

        // 파일 삭제
        const emptyFile = $wrap => {
            $wrap.removeClass('write-upload-box--active');
            $wrap.find('.write-upload-name').val($wrap.find('.write-upload-name').attr('data-default'));
            //$wrap.find('input[type=file]').val('');
            $wrap.find('.write-upload-close').attr('disabled',true);
        };

        // 파일 변경 이벤트
        common.lang.load('joinInput.company.file.confirm.delete', "파일을 삭제하시겠습니까?");
        $input.on('change', function() {
            const $this = $(this);
            const _files = $this[0].files;
            const $wrap = $this.closest('.write-upload-box');
            if(_files.length > 0 ) {
                // 파일이 들어온 경우
                $wrap.addClass('write-upload-box--active');
                $wrap.find('.write-upload-name').val(_files[0].name);
                $wrap.find('.write-upload-close').attr('disabled',false)
                    .on('click', function() {

                        if(confirm(common.lang.get('joinInput.company.file.confirm.delete'))) {
                            emptyFile($wrap);
                        } else {
                            return false;
                        }
                    });
            }else {
                // 파일을 지운 경우
                emptyFile($wrap);
            }
        }).trigger('change');

    };

    const orderListLayer = () => {
        const $body = $('#customer_qna');

        // 팝업 커스텀을 위한 콜백
        const orderListCallback = () => {
            $body.find('.popup-layout').addClass('popup-layout__order-list');
            $body.find('.popup-layout .close, .popup-mask').off('click.removeOrderList')
                .one('click.removeOrderList', function() {
                    $body.find('.popup-layout').removeClass('popup-layout__order-list');
                });
            $body.find('.orderlist-bottom__btn').off('click.tirggerClose').on('click.tirggerClose', function() {
               $('.popup-layout .close').trigger('click');
            });
        }
        window.orderListCallback = orderListCallback;
    }

    const qnaText = () => {
        var textareaPlaceholder = function textareaPlaceholder() {

            var $placeholder = $('.textarea__placeholer');

            if ($placeholder < 1) return;

            $placeholder.siblings('textarea').on('focusin', function () {
                $placeholder.hide();
            }).on('focusout', function () {
                if ($(this).val().length < 1) {
                    $placeholder.show();
                }
            });
        };

        var shop_search_init = function shop_search_init() {
            textareaPlaceholder();
        };
        shop_search_init();
    }

    const mypage_myInquiry_init = () => {
        orderListLayer();
        changeFile();
        qnaText();
    }
    mypage_myInquiry_init();
}


export default mypage_myInquiry;