
const memberBenefit = () => {
    const $document = $(document);
    const $window = $(window);
    common.lang.load('memberBenefit.wasJoin.message', '고객님은 이미 회원가입을 한 상태입니다.');
    $document.on('click', '.benefits__join .member', function() {
        alert(common.lang.get('memberBenefit.wasJoin.message'));
    });
}

export default memberBenefit;