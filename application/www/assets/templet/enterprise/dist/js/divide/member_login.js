/**
 * Created by forbiz on 2019-04-01.
 */
const member_login = () => {
    const $document = $(document);
    $document.on("click", ".login__left__nav a", function() {
        const $this = $(this);
        $(".login__left__nav a").removeClass("fb__login--active");
        $this.addClass("fb__login--active");
        $("div[class^='fb__login__contents__']").removeClass("fb__login__contents--show");
        $(`.fb__login__contents__${$this.attr("data-target")}`).addClass("fb__login__contents--show");
        return false;
    });
}

export default member_login;