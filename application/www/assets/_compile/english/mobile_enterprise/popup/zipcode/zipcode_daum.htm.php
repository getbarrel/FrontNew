<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/popup/zipcode/zipcode_daum.htm 000003312 */ ?>
<div id="devDaumZipcodeWrap" style="position:relative;border:1px solid;width:100%;height:600px;margin:5px 0;"></div>

<style>
    /*
        #6385 IOS에서 주소찾기팝업 검색결과 스크롤 안되는 오류
        >> iframe을 둘러싸고 있는 부모 엘리먼트에 position 적용되어 발생되는 현상
        >> position 적용된 부모 엘리먼트에  -webkit-overflow-scrolling 속성 추가
    */
    #__daum__layer_1 {
        overflow:auto !important;
        -webkit-overflow-scrolling:touch !important;
    }
</style>

<script>
    var elementWrap = document.getElementById('devDaumZipcodeWrap');

    daum.postcode.load(function () {
        new daum.Postcode({
            oncomplete: function (data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = data.address; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 기본 주소가 도로명 타입일때 조합한다.
                if (data.addressType === 'R') {
                    //법정동명이 있을 경우 추가한다.
                    if (data.bname !== '') {
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if (data.buildingName !== '') {
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' (' + extraAddr + ')' : '');
                }

                var returnData = {};
                returnData['zipcode'] = data.zonecode;
                returnData['address1'] = fullAddr;

                //modal
                common.util.zipcode.callback(returnData);
                common.util.modal.close();
                /* modal -> window popup 변경 */
//                opener.common.util.zipcode.callback(returnData);
//                setTimeout(function() {
//                    self.close();
//                }, 300);

            },
            // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
            onresize: function (size) {

                $(elementWrap).css({
                    "max-height" : "100%",
                    "height" : "500px",
                    "-webkit-overflow-scrolling":"touch",
//                    "height" : size.height + 'px'
                })
            },
            width: '100%',
            height: '100%',
        }).embed(elementWrap);
    });
    function winClose(){
        // 앱에서 윈도우 강제로 닫을경우 호출
        self.close();
    }
</script>