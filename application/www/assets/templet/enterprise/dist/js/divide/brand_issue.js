
const brand_issue = () => {
    const $document = $(document);
    const $window = $(window);
    $(".cms__iframe").height($(window).height() - $(".fb__header").height());
}

export default brand_issue;