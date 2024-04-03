/**
 * Created by forbiz on 2019-02-11.
 */
const mypage_returnHistory = () => {
    const $document = $(document);

    $document.on("click", ".cosmetics__link", function() {
        $(this).toggleClass("cosmetics__link--open");
        return false;
    });
}

export default mypage_returnHistory;