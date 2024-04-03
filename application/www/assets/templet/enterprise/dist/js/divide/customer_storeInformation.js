/**
 * Created by forbiz on 2019-02-11.
 */
const customer_storeInformation = () => {
    const $document = $(document);
    var marker;
    const store_map = () => {
        var mapContainer = document.getElementById('map'), // 지도를 표시할 div
            mapOption = {
                center: new kakao.maps.LatLng(37.54699, 127.09598), // 지도의 중심좌표
                level: 4, // 지도의 확대 레벨
                clickable: true
            };

        var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

        var positions = [
            {
                content: `
                <div style="width: 150px; height: 100px;">카카오 신지은
                    <a href="#"  class="btn-kakao-map" data-seq="0"; display: block;">자세히보기</a>
                </div>`
                ,
                latlng: new kakao.maps.LatLng(37.54699, 127.09598)
            }
        ];

        var imageSrc = '/assets/templet/enterprise/images/customer/icon-map.png', // 마커이미지의 주소입니다
            imageSize = new kakao.maps.Size(43, 60), // 마커이미지의 크기입니다
            imageOption = {offset: new kakao.maps.Point(21, 60)}; // 마커이미지의 옵션입니다. 마커의 좌표와 일치시킬 이미지 안에서의 좌표를 설정합니다.

// 마커의 이미지정보를 가지고 있는 마커이미지를 생성합니다
        var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption),
            markerPosition = new kakao.maps.LatLng(37.54699, 127.09598); // 마커가 표시될 위치입니다

// 마커를 생성합니다
        marker = new kakao.maps.Marker({
            position: markerPosition,
            image: markerImage // 마커이미지 설정
        });

// 마커가 지도 위에 표시되도록 설정합니다
        marker.setMap(map);
        var iwRemoveable = true; // removeable 속성을 ture 로 설정하면 인포윈도우를 닫을 수 있는 x버튼이 표시됩니다

// 인포윈도우를 생성합니다
//         var infowindow = new kakao.maps.InfoWindow({
//             content: positions[0].content,
//             removable : iwRemoveable
//         });
// 마커에 클릭이벤트를 등록합니다

        kakao.maps.event.addListener(marker, 'click', function(mouseEvent) {
            infowindow.open(map, marker);
        });

        $document.on("click", ".btn-kakao-map", function() {
            const $this = $(this);

            console.log($this.attr("data-seq"));
        });

        //주소-좌표 반환
        var geocoder = new kakao.maps.services.Geocoder();

        $document.on('click', '#devListContents > li.js__each__store > a', function() {
            const address = $(this).find('.devAddressInfo').text();

            // 주소로 좌표를 검색합니다
            geocoder.addressSearch(address, function(result, status) {

                // 정상적으로 검색이 완료됐으면
                if (status === kakao.maps.services.Status.OK) {
                    marker.setMap(null);//초기화
                    var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

                    // 결과값으로 받은 위치를 마커로 표시합니다
                    marker = new kakao.maps.Marker({
                        map: map,
                        position: coords
                    });

                    // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                    map.setCenter(coords);
                }
            });

        });
    }

    const lnb_menu = () => {
        const $target = $(".fb__store__lnb");
        $document.on("click", ".fb__store .lnb__title", function () {
            $target.toggleClass("fb__store__lnb--folding");
        })
    }

    const store_info = () => {
        const $target = $(".s-detail__slide");

        const click_store = () => {
            $document.on("click", ".js__each__store a", function(){
                const $this = $(this);
                const _store_data = JSON.parse($this.attr("data-ob"))[0];
                $document.find(".lnb__result__each-marker").removeClass("lnb__result__each-marker--active");
                $this.find(".lnb__result__each-marker").addClass("lnb__result__each-marker--active");
                img_templet( _store_data, entire_info_templet);
                return false;
            });
        }

        const img_templet = ( _store_data, callback) => {

            let imgHtml = '';
            let imgLength = 0;
            $.each(_store_data.src, function(i){
                imgHtml += `
                  <figure class="swiper-slide">
                        <img src="${_store_data.src[i]}" alt="storeImg">
                  </figure>  
                `;
                imgLength++;
            });


            return callback(imgHtml, _store_data, imgLength);
        }

        const entire_info_templet = (imgHtml, _store_data, imgLength, callback) => {
            const target = _store_data;
            let info_templet = "";
            info_templet = `
                  <div class="s-detail__each swiper-container gggg">
                        <div class="s-detail__each__thumb swiper-wrapper">
                           ${imgHtml}
                        </div>
                        <ul class="s-detail__each__desc">
                            <li class="s-detail__each__desc--basic">
                                  <span>기본아이콘</span>
                                  <p class="s-detail__each__title">${target.store_name}</p>
                                  <p>${target.store_address1}</p>
                                  <p>${target.store_address2}</p>
                            </li>
                            <li class="s-detail__each__desc--time">
                                  <span>시간아이콘</span>
                                  <p>${target.open_time}</p>
                                  <p>${target.open_time2}</p>
                                  <p>${target.store_tel}</p>
                            </li>
                            <li class="s-detail__each__desc--bus">
                                  <span>버스아이콘</span>
                                  <p>${target.bus}</p>
                            </li>
                            <li class="s-detail__each__desc--subway">
                                  <span>지하철아이콘</span>
                                  <p>${target.subway}</p>
                            </li>
                        </ul>
                    </div>
              `;

            $target.find(".js__store__list").html(info_templet);
            if ( imgLength > 3) {
                $target.find(".s-detail__slide__nav").addClass("s-detail__slide__nav--show");
                store_img_slide();
            } else {
                $target.find(".s-detail__slide__nav").removeClass("s-detail__slide__nav--show");
            }

        }

        const store_img_slide = () => {

            if($(".s-detail__each").get(0).swiper) {
                $(".s-detail__each").get(0).swiper.destroy();
            }
            const storeImg = new Swiper(".s-detail__each", {
                loop: true,
                width: 1140,
                slidesPerView : 3,
                spaceBetween: 30,
                navigation: {
                    nextEl: '.s-detail__slide__nav--next',
                    prevEl: '.s-detail__slide__nav--prev',
                }
            });
        }



        const info_init = () => {
            click_store();
        }

        info_init();
    }

    const store_detail_slide = () => {
        const store_slide = new Swiper()
    }

    const store_init = () => {
        store_map();
        lnb_menu();
        store_info();
    }

    store_init();
}

export default customer_storeInformation;