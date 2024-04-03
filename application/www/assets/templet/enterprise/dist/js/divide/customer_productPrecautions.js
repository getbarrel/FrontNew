/**
 * Created by frontend on 2019-07-26.
 */
const customer_productPrecautions = () => {
    const $document = $(document);
    const $window =  $(window);

    const productPrecautions_category = () => {
        $document.on("click", ".wash__category-link", function(e) {
            e.preventDefault();
            const $this = $(this);

            $(".wash__category-link").removeClass("wash__category-link--active");
            $this.addClass("wash__category-link--active");
            $("section[class^=wash__contents-]").removeClass("wash__contents__category--show");
            $(".wash__contents__category").removeClass("wash__contents__category--show");
            $this.addClass("wash__contents__category--show");
            $(`.wash__contents-${$this.attr("data-target")}`).addClass("wash__contents__category--show");


        });
    };


    const productPrecautions_init = () => {
        productPrecautions_category();
    };

    productPrecautions_init();
}


export default customer_productPrecautions;