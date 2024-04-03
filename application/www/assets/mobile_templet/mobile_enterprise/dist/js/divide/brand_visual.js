
const brand_visual = () => {
    const $document = $(document);
    const $window = $(window);
    $(".cms__iframe").height($(window).height() - $(".br__header").height());
}

export default brand_visual;