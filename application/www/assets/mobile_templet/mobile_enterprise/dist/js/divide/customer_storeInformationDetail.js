/**
 * Created by forbiz on 2019-06-26.
 */

const customer_storeInformationDetail = () => {
    const $document = $(document);
    const $window =  $(window);

    const map_folding = () => {
        // const $target = $(".store-map");
        // const _top_name = $(".store-each__text").offset().top;
        // const $pointIcon =  $(".store-map__foldicon--point");
        //
        // $document.on("click", $target, function(){
        //    if (!$target.hasClass("store-map--fold")) {
        //        $target.addClass("store-map--fold");
        //        $pointIcon.removeClass("store-map__foldicon--active");
        //
        //    } else {
        //        $target.removeClass("store-map--fold");
        //        $pointIcon.addClass("store-map__foldicon--active");
        //
        //    }
        // });
        $document
            .on("click", ".store-map__top", function() {
                const $target = $(".store-map");
                const $pointIcon =  $(".store-map__foldicon--point");

                if (!$target.hasClass("store-map--fold")) {
                    $target.addClass("store-map--fold");
                    $pointIcon.removeClass("store-map__foldicon--active");
                } else {
                    $target.removeClass("store-map--fold");
                    $pointIcon.addClass("store-map__foldicon--active");
                }
            })
            .on("click", ".store-map__by__open", function() {
                const $this = $(this);
                const $arrow = $this.find(".store-map__foldicon--normal");
                if (!$arrow.hasClass("store-map__foldicon--normal--active")) {
                    $arrow.addClass("store-map__foldicon--normal--active");
                    $this.next(".store-map__by__detail").slideUp(200);
                    //$this.next(".store-map__by__detail").addClass("store-map__by__detail--hidden");
                } else {
                    $arrow.removeClass("store-map__foldicon--normal--active");
                    $this.next(".store-map__by__detail").slideDown(200);
                    $this.next(".store-map__by__detail").removeClass("store-map__by__detail--hidden");
                }
            })
    }

    const storeDetail_init = () => {
        map_folding();
    }

    storeDetail_init();
};
export default customer_storeInformationDetail;