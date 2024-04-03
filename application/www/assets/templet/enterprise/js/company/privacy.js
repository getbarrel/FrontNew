"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

$(function () {
    $('.devContents .devPolicyContentsClass').hide();
    $('.devContents .devPolicyContentsClass:first').show();
});

$('#devPolicyHistory').on('change', function () {
    var ix = $('#devPolicyHistory option:selected').val();
    $('.devContents .devPolicyContentsClass').hide();
    $('.devContents #devPolicyContentsId' + ix).show();
});
