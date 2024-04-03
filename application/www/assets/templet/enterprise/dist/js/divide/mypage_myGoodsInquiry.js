/**
 * Created by forbiz on 2019-02-11.
 */
const mypage_myGoodsInquiry = () => {
    const $document = $(document);

    $document.on("click", ".fb__bbs__subTitle", function() {
        common.util.modal.open('ajax', '상품 Q&A', '/mypage/myGoodsInquiryDetail','');
         return false;
    });
}

export default mypage_myGoodsInquiry;