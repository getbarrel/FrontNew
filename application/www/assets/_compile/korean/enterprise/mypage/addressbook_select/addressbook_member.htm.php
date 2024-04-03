<?php /* Template_ 2.2.8 2023/07/18 10:20:05 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/addressbook_select/addressbook_member.htm 000002582 */ ?>
<script>var addressPopMode = 'member';</script>
<div class="popup-content">
    <h1 class="clearfix fn-bold">
        배송지 목록

        <button class="btn-xs fn-bold btn-dark-line float-r address-link" id="devAddressBookAddBtn">배송지 추가</button>

    </h1>

    <table class="table-default address-list-table">
        <colgroup>
            <col width="14%">
            <col width="*">
            <col width="19%">
            <col width="17%" class="eng-hidden">
            <col width="13%">
        </colgroup>
        <thead>
        <th>받는 분</th>
        <th>주소</th>
        <th>연락처</th>
        <th class="eng-hidden">배송지 별칭</th>
        <th></th>
        </thead>
        <tbody id="devAddressBooKContent">
            <tr id="devAddressBooKLoading"  class="devForbizTpl">
                <td colspan="5">
                    <div class="empty-content">
                        <p>Loading...</p>
                    </div>
                </td>
            </tr>
            <tr id="devAddressBooKList" class="devForbizTpl">
                <td>
                    {[#if default_yn]}<span class="default-icon">기본</span>{[/if]}
                    <p class="text-black">{[recipient]}</p>
                </td>
                <td class="td-address">
                    {[#if nation_name]}{[nation_name]}<br>{[/if]}
                    {[address1]}<br>{[address2]}
                    {[#if city]}<br>{[city]}{[/if]}
                    {[#if state]}<br>{[state]}{[/if]}
                </td>
                <td><p class="font-rb">{[mobile]}</p><p class="font-rb">{[tel]}</p></td>
                <td class="eng-hidden">{[shipping_name]}</td>
                <td>
                    <button class="btn-xs btn-dark devAddressBookItemSelect" data-oid="<?php echo $TPL_VAR["oid"]?>" data-ix="{[ix]}">선택</button>
                </td>
            </tr>
            <tr id="devAddressBooKEmpty" class="devForbizTpl">
                <td colspan="5">
                    <div class="empty-content">
                        <p>등록된 배송지가 없습니다.</p>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>

    <div id="devPageWrap"></div>

    <div class="popup-btn-area">
        <button class="btn-default btn-dark-line fn-bold" id="devAddressBookPopColseBtn">닫기</button>
    </div>
</div>