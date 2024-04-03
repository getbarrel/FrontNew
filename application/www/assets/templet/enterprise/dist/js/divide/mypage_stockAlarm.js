const stock_alarm = () => {
    const $document = $(document);
    $document.on("click", ".alarm-list__goods__wish", function() {
        $(this).toggleClass("alarm-list__goods__wish--active");
    });
}

export default stock_alarm;