<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/popup/zipcode/zipcode_daum.htm 000002308 */ ?>
<div id="devDaumZipcodeWrap" style="border:1px solid;width:100%;height:600px;margin:5px 0;"></div>
<script src="<?php echo $TPL_VAR["daumJsUrl"]?>"></script>

<script>
    var elementWrap = document.getElementById('devDaumZipcodeWrap');
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

            //popup
            opener.forbizCsrf.hash = forbizCsrf.hash;
            opener.common.util.zipcode.callback(returnData);
            self.close();
        },
        // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
        onresize: function (size) {
            //elementWrap.style.height = size.height + 'px';
            elementWrap.style.height = $(window).height();
        },
        width: '100%',
        height: '100%'
    }).embed(elementWrap);
</script>