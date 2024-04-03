/**
 * Created by forbiz on 2019-05-21.
 */
const member_searchPw = () => {
    const $document = $(document);
    $document.on("click", ".fb__tab-link", function() {
        const $this = $(this);
        $(".fb__tab-link").removeClass("fb__tab-link--active");
        $this.addClass("fb__tab-link--active");
        $(".search__content").removeClass("search__content--show");
        $($this.attr("href")).addClass("search__content--show");
        return false;
    })
}

export default member_searchPw;