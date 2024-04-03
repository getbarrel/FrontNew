/**
 * Created by forbiz on 2019-02-11.
 */
const customer_cosmeticsCaution = () => {
    const $document = $(document);

    $document.on("click", ".cosmetics__link", function() {
        $(this).toggleClass("cosmetics__link--open");
        return false;
    });
}

export default customer_cosmeticsCaution;