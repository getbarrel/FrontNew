<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/popup/order_list/order_list.htm 000002200 */ ?>
<form id="devListForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="10" />
</form>

<div class="popup-order-check">
    <div class="desc">Please check the order item you want to inquire about and press the &#39;Select&#39; button to receive the inquiry for the order item.</div>
    <table class="table-default">
        <tbody id="devListContents">
        <colgroup>
            <col width="174px">
            <col width="*">
            <col width="100px">
            <col width="90px">
        </colgroup>
        <thead>
        <tr>
            <th>order number/ Order Date</th>
            <th>Item</th>
            <th>Total Payment</th>
            <th>Select</th>
        </tr>
        </thead>
        <tr id="devListDetail">
            <td>
                <p class="order-num">{[oid]}</p>
                <p class="date">{[order_date]}</p>
            </td>
            <td class="devOrderListOid cursorP" data-oid="{[oid]}">
                <div class="thumb">
                    <img src="{[product_image_src]}">
                </div>
                <p class="title">{[buy_product_name]}</p>
            </td>
            <td>
                <p class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[payment_price]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
            </td>
            <td>
                <button class="btn-xs btn-white" devSelectOid="{[oid]}">Select</button>
            </td>
        </tr>
        <!--내역이 없을 경우-->
        <tr>
            <td colspan="4" class="sj__cash-withdraw__listbox--empty empty-content" id="devListEmpty">
                <p>
                    No order history
                </p>
            </td>
        </tr>
        </tbody>
    </table>
    <div id="devListLoading" class="devForbizTpl loading-text">loading...</div>
    <div id="devPageWrap"></div>
    <div class="popup-btn-area">
        <button class="btn-default btn-dark-line btn-orderlayer-close">Cancel</button>
    </div>

</div>