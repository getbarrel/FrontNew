"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

$(function () {
    const $document = $(document);
    var marker;
    const store_map = () => {

        //주소-좌표 반환
        var geocoder = new kakao.maps.services.Geocoder();
        var address = $('#devAddress1').text();

        var imageSrc = '/assets/templet/enterprise/images/customer/icon-map.png', // 마커이미지의 주소입니다
            imageSize = new kakao.maps.Size(43, 60), // 마커이미지의 크기입니다
            imageOption = {offset: new kakao.maps.Point(21, 60)}; // 마커이미지의 옵션입니다. 마커의 좌표와 일치시킬 이미지 안에서의 좌표를 설정합니다.

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
    }

    const store_init = () => {
        store_map();
    }

    store_init();
});