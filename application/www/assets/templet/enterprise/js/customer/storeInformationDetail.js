"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

var storesList = {

    storesListAjax: false,
    init: function () {
        var self = this;
        self.storesListAjax = common.ajaxList();
        self.storesListAjax
            .setRemoveContent(false)
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setContainerType('ul')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(false)
            .setController('getStoreList', 'customer');

        $("#devListContents").show();

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.storesListAjax.getPage($(this).data('page'));
        });

        if($('#devStoreInput').val() != '') {
            setTimeout(function(){
                $('#devSearchStore').click();
                setTimeout(function(){
                    $('.js__each__store').eq(0).find('a').click();
                },500);
            },500);
        }
    },
    initEvent: function() {
        var self = this;

        //선택된 시/도에 맞는 지역구 세팅
        $('#devCitySelect').on('change', function(){

            $('#devCity').val($('.devSortTab:checked').val());
            $('#devArea').val('');
            $('#devStoreCnt').text(0);
            self.storesListAjax.setController('getArea', 'customer');
            self.storesListAjax.init(function(response){

                var areaHtml = "<option class='devSortTab' value=''>시/군/구</option>";
                var tmp = "<option class='devSortTab' value='#areaValue#'>#area#</option>";
                for(var i=0; i< response.data.total; i++) {
                    areaHtml += tmp.replace('#areaValue#', response.data.list[i]['area_code']).replace('#area#', response.data.list[i]['area_code']);
                }
                $('#devAreaSelect > *').remove();
                $('#devAreaSelect').append(areaHtml);

                //self.storesListAjax.setContent("");
                $('#devStoreCnt').text(0);
            });
        });

        $(document).on('change', '#devAreaSelect', function(){
            $('#devArea').val($('#devAreaSelect').val());
        });

        //스토어 리스트
        $('#devSearchStore').on('click', function(){

            var city = $('#devCity').val();
            var search = $('#devStoreInput').val();

            /*if(city == "" && search == "") {
                alert("시/도 선택 또는 검색어를 입력 해주세요.");
            }else {*/

                $('#devStoreName').val($('#devStoreInput').val());

                $('#devLoading').hide();
                self.storesListAjax.setController('getStoreList', 'customer');
                self.storesListAjax.init(function(response){
                    self.storesListAjax.setContent(response.data.list, response.data.paging);
                    $('#devStoreCnt').text(response.data.total);
                });
            //}

        });
		$('#devLoading').hide();
		self.storesListAjax.setController('getStoreList', 'customer');
		self.storesListAjax.init(function(response){
			self.storesListAjax.setContent(response.data.list, response.data.paging);
			$('#devStoreCnt').text(response.data.total);
		});

    },
    storeInformation :function(x, y) {
        var $document = $(document);
        var $window = $(window);
        var marker;

        var geocoder = new kakao.maps.services.Geocoder();
        var address = $('#devAddress1').text();

        var imageSrc = '/assets/templet/enterprise/images/customer/icon-map.png',
            // 마커이미지의 주소입니다
            imageSize = new kakao.maps.Size(43, 60),
            // 마커이미지의 크기입니다
            imageOption = { offset: new kakao.maps.Point(21, 60) }; // 마커이미지의 옵션입니다. 마커의 좌표와 일치시킬 이미지 안에서의 좌표를 설정합니다.

        // 마커의 이미지정보를 가지고 있는 마커이미지를 생성합니다
        var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption);



        var store_map = function store_map() {
            var mapContainer = document.getElementById('map'),
                // 지도를 표시할 div
                mapOption = {
                    //center: new kakao.maps.LatLng(37.5043439, 127.003599), // 강남신세계 지도의 중심좌표
					center: new kakao.maps.LatLng(37.5470903, 127.044786), // 성수지도의 중심좌표
                    level: 4, // 지도의 확대 레벨
                    clickable: true
                };



            var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

            function setZoomable(zoomable) {
                // 마우스 휠로 지도 확대,축소 가능여부를 설정합니다
                map.setZoomable(zoomable);
            };

            setZoomable(false);

            kakao.maps.event.addListener(map, 'zoom_changed', function() {
                if($window.height() >= 1200) {
                    $(mapContainer).removeClass("map__small");
                    setZoomable(true);
                } else {
                    setZoomable(false);
                }
            });
                    //map.getZoomable()

            mapContainer.onmousewheel =  function(e) {

                if($window.height() >= 1200) {
                    setZoomable(true);
                } else {
                    if (e.ctrlKey) {
                        e.preventDefault();
                        $(mapContainer).removeClass("map__small");
                        setZoomable(true);
                    } else {
                        setZoomable(false);
                        $(mapContainer).addClass("map__small");
                    }

                    setTimeout(function(){
                        $(mapContainer).removeClass("map__small");
                    }, 4000);
                }
            };

            $window.on("resize", function() {
                if($window.height() >= 1200) {
                    $(mapContainer).removeClass("map__small");
                    setZoomable(true);
                } else {

                    setZoomable(false);
                }
            });

            var positions = [{
                content: '\n                <div style="width: 150px; height: 100px;">\uCE74\uCE74\uC624 \uC2E0\uC9C0\uC740\n                    <a href="#"  class="btn-kakao-map" data-seq="0"; display: block;">\uC790\uC138\uD788\uBCF4\uAE30</a>\n                </div>',

                latlng: new kakao.maps.LatLng(37.54699, 127.09598)
            }];

            //var markerPosition = new kakao.maps.LatLng(37.5043439, 127.003599); // 강남신세계 마커가 표시될 위치입니다
			var markerPosition = new kakao.maps.LatLng(37.5470903, 127.044786); // 성수지도의 마커가 표시될 위치입니다

            // 마커를 생성합니다
            marker = new kakao.maps.Marker({
                position: markerPosition,
                image: markerImage // 마커이미지 설정
            });

            // 마커가 지도 위에 표시되도록 설정합니다
            //marker.setMap(map);
            var iwRemoveable = true; // removeable 속성을 ture 로 설정하면 인포윈도우를 닫을 수 있는 x버튼이 표시됩니다

            // 인포윈도우를 생성합니다
            //         var infowindow = new kakao.maps.InfoWindow({
            //             content: positions[0].content,
            //             removable : iwRemoveable
            //         });
            // 마커에 클릭이벤트를 등록합니다

            kakao.maps.event.addListener(marker, 'click', function (mouseEvent) {
                infowindow.open(map, marker);
            });

            $document.on("click", ".btn-kakao-map", function () {
                var $this = $(this);

                console.log($this.attr("data-seq"));
            });

            // $window.on("scroll", function(e) {
            //     console.log(e);
            // });

            //주소-좌표 반환
            var geocoder = new kakao.maps.services.Geocoder();
            var address = $('#devAddress1').text();

            // 주소로 좌표를 검색합니다
            geocoder.addressSearch(address, function(result, status) {
                // 정상적으로 검색이 완료됐으면
                if (status === kakao.maps.services.Status.OK) {
                    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
                        mapOption = {
                            center: new kakao.maps.LatLng(result[0].y, result[0].x), // 지도의 중심좌표
                            level: 4, // 지도의 확대 레벨
                            clickable: true
                        };

                    // 마커의 이미지정보를 가지고 있는 마커이미지를 생성합니다
                    var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption),
                        markerPosition = new kakao.maps.LatLng(result[0].y, result[0].x); // 마커가 표시될 위치입니다

                    var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

                    // 마커를 생성합니다
                    marker = new kakao.maps.Marker({
                        position: markerPosition,
                        image: markerImage // 마커이미지 설정
                    });

                    // 마커가 지도 위에 표시되도록 설정합니다
                    marker.setMap(map);
                }
            });

            /*$document.on('click', '#devListContents > li.js__each__store > a', function () {
                var address = $(this).find('.devAddressInfo').text();

                // 주소로 좌표를 검색합니다
                geocoder.addressSearch(address, function (result, status) {

                    // 정상적으로 검색이 완료됐으면
                    if (status === kakao.maps.services.Status.OK) {
                        marker.setMap(null); //초기화
                        var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

                        // 결과값으로 받은 위치를 마커로 표시합니다
                        marker = new kakao.maps.Marker({
                            map: map,
                            position: coords,
                            image: markerImage
                        });

                        // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                        map.setCenter(coords);
                    }
                });
            });*/
        };

        var lnb_menu = function lnb_menu() {
            var $target = $(".fb__store__lnb");
            $document.on("click", ".fb__store .lnb__title", function () {
                $target.toggleClass("fb__store__lnb--folding");
            });
        };

        var store_info = function store_info() {
            var $target = $(".s-detail__slide");

            var click_store = function click_store() {
                $document.on("click", ".js__each__store a", function () {
                    var $this = $(this);
                    var _store_data = JSON.parse($this.attr("data-ob"))[0];
                    $document.find(".lnb__result__each-marker").removeClass("lnb__result__each-marker--active");
                    $this.find(".lnb__result__each-marker").addClass("lnb__result__each-marker--active");

					$(".fb__store__name").html(_store_data.store_name);
					$(".fb__store__address").html("<p>"+_store_data.store_address1+"<br />"+_store_data.store_address2+"</p>");
					$("#_bus").html(_store_data.bus);
					$("#_subway").html(_store_data.subway);
					$("#_businessDay").html(_store_data.open_time);
					$("#_businessTel").html(_store_data.store_tel);
                    $("#_businessSns").attr("onclick","window.open('"+_store_data.sns_info+"')");
					
					var imgHtml = '';
					var imgLength = 0;
					$.each(_store_data.src, function (i) {
						imgHtml += '\n                  <div class="swiper-slide">\n                        <img src="' + _store_data.src[i] + '" alt="storeImg">\n                  </div>  \n                ';
						imgLength++;
					});
					$(".swiper-wrapper").html(imgHtml);
                    return false;
                });
            };

            var img_templet = function img_templet(_store_data, callback) {

                var imgHtml = '';
                var imgLength = 0;
                $.each(_store_data.src, function (i) {
                    imgHtml += '\n                  <figure class="swiper-slide">\n                        <img src="' + _store_data.src[i] + '" alt="storeImg">\n                  </figure>  \n                ';
                    imgLength++;
                });

                return callback(imgHtml, _store_data, imgLength);
            };

            var entire_info_templet = function entire_info_templet(imgHtml, _store_data, imgLength, callback) {
                var target = _store_data;
                var info_templet = "";
                info_templet = '\n                  <div class="s-detail__each swiper-container ggg">\n                        <div class="s-detail__each__thumb swiper-wrapper">\n                           ' + imgHtml + '\n                        </div>\n                        <ul class="s-detail__each__desc">\n                            <li class="s-detail__each__desc__list s-detail__each__desc--basic">\n                                  <!--<span>\uAE30\uBCF8\uC544\uC774\uCF58</span>\n-->                                   <p class="s-detail__each__desc__title">매장정보</p>\n                                  <p class="s-detail__each__title">' + target.store_name + '</p>\n                                  <p class="s-detail__each__address">' + target.store_address1 + ' ' + target.store_address2 + '</p>\n                            <p>' + target.open_time + '</p>\n                                  <p class="s-detail__each__time">' + target.store_tel + '</p>\n                            </li>\n                            <li class="s-detail__each__desc__list s-detail__each__desc--time">\n                                  <!--<span>\uC2DC\uAC04\uC544\uC774\uCF58</span>\n-->                                  </li>\n                            <li class="s-detail__each__desc__list s-detail__each__desc--bus">\n                                  <!--<span>\uBC84\uC2A4\uC544\uC774\uCF58</span>-->\n                                  <p class="s-detail__each__desc__title">버스 이용방법</p>\n                            <p>' + target.bus + '</p>\n                            </li>\n                            <li class="s-detail__each__desc__list s-detail__each__desc--subway">\n                                  <span>\uC9C0\uD558\uCCA0\uC544\uC774\uCF58</span>\n                                  <p class="s-detail__each__desc__title">지하철 이용방법</p>\n                            <p>' + target.subway + '</p>\n                            </li>\n                        </ul>\n                    </div>\n              ';

                $target.find(".js__store__list").html(info_templet);
                if (imgLength > 3) {
                    $target.find(".s-detail__slide__nav").addClass("s-detail__slide__nav--show");
                    store_img_slide();
                } else {
                    $target.find(".s-detail__slide__nav").removeClass("s-detail__slide__nav--show");
                }
            };

            var store_img_slide = function store_img_slide() {

                if ($(".s-detail__each").get(0).swiper) {
                    $(".s-detail__each").get(0).swiper.destroy();
                }
                var storeImg = new Swiper(".s-detail__each", {
                    loop: true,
                    width: 1140,
                    slidesPerView: 3,
                    spaceBetween: 30,
                    navigation: {
                        nextEl: '.s-detail__slide__nav--next',
                        prevEl: '.s-detail__slide__nav--prev'
                    }
                });
            };

            var info_init = function info_init() {
                click_store();
            };

            info_init();
        };

        var store_detail_slide = function store_detail_slide() {
            var store_slide = new Swiper();
        };



        var store_init = function store_init() {
            store_map();
            lnb_menu();
            store_info();
        };

        store_init();

    },
    run: function(){
        var self = this;
        self.storeInformation();
        self.init();
        self.initEvent();

    }
}

$(function () {
    storesList.run();
});