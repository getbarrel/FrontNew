/**
 * Created by moon on 2019-08-13.
 */
common.lang.load('product.bbsQnaDelete.alert', "문의 내역을 삭제 하시겠습니까?.");
common.lang.load('product.bbsQnaDeleteFail.alert', "삭제가 실패 되었습니다. 다시 시도 바랍니다.");
$(function () {
    $('.devModifyQna').on('click',function(){
        var bbs_ix = $(this).data('bbs_ix');
        var pid = $(this).data('pid');
        var modal_title = '상품 Q&A';

        if(common.langType == 'english') {
            modal_title = 'product Q&A';
        }
        common.util.modal.open('ajax', modal_title, '/shop/goodsQnaWrite/' + pid +'/' +bbs_ix, '');
    });

    $('.devDeleteQna').on('click',function(){
        var bbs_ix = $(this).data('bbs_ix');

        common.ajax(
            common.util.getControllerUrl('deleteQna', 'mypage'),
            {
                bbs_ix: bbs_ix
            },
            function () {
                if (confirm(common.lang.get('product.bbsQnaDelete.alert'))) {
                    return true;
                } else {
                    return false;
                }
            },
            function (data) {
                if (data.result == 'success') {
                    document.location.href='/mypage/myGoodsInquiry';
                }else{
                    common.noti.alert(common.lang.get('product.bbsQnaDeleteFail.alert'));
                }
            }

        );
    });
});