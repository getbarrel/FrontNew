/**
 * Created by forbiz on 2019-06-26.
 */

const customer_faq = () => {
    const $document = $(document);

    const faq_init = () => {

        $document.on("click", ".br__faq__question", function(){
            const $this = $(this);
            const $answer = $this.parents(".br__faq__list").find(".br__faq__answer");

            if ( !$answer.hasClass("br__faq__answer--show")) {

                $this.addClass("br__faq__question--opened");
                $answer.slideDown().addClass("br__faq__answer--show");

            } else {

                $this.removeClass("br__faq__question--opened");
                $answer.slideUp().removeClass("br__faq__answer--show");

            }
        });
    }

    faq_init();
}

export default customer_faq;