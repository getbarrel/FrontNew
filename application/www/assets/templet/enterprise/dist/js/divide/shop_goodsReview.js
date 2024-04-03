/**
 * Created by forbiz on 2019-02-11.
 */


const shop_goodsReview = () => {
    const $document = $(document);

    const review_tab = () => {
        $document.on("click", ".fb__review-write__type .fb__wrap-radio__label", function(){
            const $this = $(this);
            if ($this.hasClass("menu-video")) {
                $(".write__video").addClass("write__video--show");
                $(".write__photo").removeClass("write__video--show");
            }
            else if ( $this.hasClass("menu-photo") ) {
                $(".write__photo").addClass("write__video--show");
                $(".write__video").removeClass("write__video--show");
            } else {
                $(".write__photo").removeClass("write__video--show");
                $(".write__video").removeClass("write__video--show");
            }
0
        });

    }

    const video_tab = () => {
        $document.on("click", ".write__video__type .fb__wrap-radio__label", function(){
            const $this = $(this);
            const $tab_youtube = $(".tab-youtube");
            const $tab_myVideo = $(".tab-myVideo");

            if ($this.hasClass("youtube")){
                $tab_youtube.addClass("write__video__tab--show");
                $tab_myVideo.removeClass("write__video__tab--show");
            } else {
               $tab_youtube.removeClass("write__video__tab--show");
               $tab_myVideo.addClass("write__video__tab--show");
            }
        });
    }

    // const show_comment = () => {
    //     $document.on("click",".bp-popup__comment-btn", function(){
    //         const $target = $(this).siblings(".review-detail__user-comment");
    //         if(!$target.hasClass("review-detail__user-comment--show")) {
    //            $target.addClass("review-detail__user-comment--show");
    //
    //         } else {
    //            $target.removeClass("review-detail__user-comment--show");
    //         }
    //
    //     });
    //
    //
    //
    // }

    const edit_comment = () => {

        $document.on("click", ".fb__goodsReview-read .list__edit-btn", function(){
            const $this = $(this);
            const $edit_area = $this.parent().find(".list__edit-area");
            const _ori_comment = $this.parent().find(".ori_comment").html();
            $this.addClass("list__edit-btn--disable");
            $this.siblings().find("textarea").html(_ori_comment);

            if( ! $edit_area.hasClass("list__edit-area--show")) {
                $edit_area.addClass("list__edit-area--show");
            }
        });

    }

    const cancel_click = () => {
        $document.on( "click", ".list__edit-area__btns--cancel", function(){
            const $this = $(this);
            $this.parents(".list__edit-area").removeClass("list__edit-area--show");
            $this.parents(".list").find(".list__edit-btn").removeClass("list__edit-btn--disable");

        });
    }

    const file_upload = () => {
        const $target = $(".myVideoFile");

        const input_filename = ($target, filename, fileType) => {
            let regFile = /(mp4|m4v|mov|flv|wmv|asf|avi|mkv)/;
            if ( regFile.test(fileType) ){
                $target.val(filename);
                $(".tab-myVideo__cancel").removeClass("tab-myVideo__cancel--disable");
            } else {
                alert('파일 형식이 올바르지 않습니다.');
            }
        };

        const file_reader = ($target, callback) => {
            let filename = '';
            let fileType = '';
            if ( window.FileReader ){
                filename = $target[0].files[0].name;
                fileType = filename.split('.').pop();

            } else {
                filename = $target.val()
                    .split('/').pop()
                    .split('\\').pop();
                fileType = filename.split('.').pop();
            }

            return callback( $target.parent().siblings(".tab-myVideo__filename"), filename, fileType );
        };

        $document.on("change", ".myVideoFile", function(){
            const $this = $(this);
            file_reader($this, input_filename);
        });
    }

    const file_del = () => {
        $document.on("click", ".tab-myVideo__cancel", function(){
            const $this = $(this);
            if($this.siblings(".tab-myVideo__filename").val()) $this.addClass("tab-myVideo__cancel--disable");
            $this.siblings().find('.myVideoFile').val('');
            $this.siblings(".tab-myVideo__filename").val('');

            return false;
        });
    }

    const write_init = () => {
        review_tab();
        video_tab();
        file_upload();
        file_del();
        cancel_click();
        edit_comment();
    }

    write_init();
}



export default shop_goodsReview;