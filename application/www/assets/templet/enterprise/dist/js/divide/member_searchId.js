/**
 * Created by forbiz on 2019-05-21.
 */
const member_searchId = () => {
    const $document = $(document);
    $document
        .on("click", ".search__nav input", function() {
            const $this = $(this);
            const $target = $(".search__wrap");
            $target.find(".search__inner").removeClass("search__inner--show");
            $(`.fb__member-search__${$this.val()}`).addClass("search__inner--show");
        })


}

export default member_searchId;