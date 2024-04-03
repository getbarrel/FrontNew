<?php /* Template_ 2.2.8 2020/10/27 11:32:12 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/teacher/bbs_write.htm 000008576 */ 
$TPL_bbsDiv_1=empty($TPL_VAR["bbsDiv"])||!is_array($TPL_VAR["bbsDiv"])?0:count($TPL_VAR["bbsDiv"]);?>
<div class="wrap-inquiry fb__bbs__write fb__teacher">
    <div class="weite apply">
        <header class="bbs-title-area weite__header">
            <h1 class="weite__header__title">티처멤버 모집</h1>
            <p class="weite__header__summary">
                배럴 티처 멤버가 되시면, 종목에 따른 구분을 하여 상품구매 시 해당 카테고리 15% 할인 혜택을 받으실 수 있습니다.
            </p>
        </header>
        <form name='bbsForm' id="devBbsForm" method='post' enctype="multipart/form-data" >
            <input type="hidden" name="bbsTableName" value='<?php echo $TPL_VAR["bbs_table_name"]?>'>
            <input type="hidden" name="board" value="<?php echo $TPL_VAR["board_ename"]?>">
            <input type="hidden" name="focusInfo">
            <input type="hidden" name="isHtml" value='N'>
            <input type='hidden' name='antispamYn' value='N'>
            <input type='hidden' name='uType' value='<?php if(!empty($TPL_VAR["bbs_ix"])){?>U<?php }?>'>
            <input type="hidden" id="isAjaxList" value="N" />
<?php if($TPL_VAR["bbs_ix"]){?>
            <input type='hidden' name='bbsIx' value='<?php echo $TPL_VAR["bbs_ix"]?>'>
<?php }?>

            <table class="join-table type02 apply__table">
                <colgroup>
                    <col width="160px">
                    <col width="*">
                </colgroup>
<?php if($TPL_VAR["bbsDiv"]){?>
                <tr class="apply__type">
                    <th>분류</th>
                    <td>
<?php if($TPL_bbsDiv_1){foreach($TPL_VAR["bbsDiv"] as $TPL_V1){?>
                        <label>
                            <input type="radio" name="bbsDiv" class="devBbsDiv" value="<?php echo $TPL_V1["div_ix"]?>" <?php if($TPL_VAR["bbs_div"]==$TPL_V1["div_ix"]){?> checked <?php }?>>
                            <span><?php echo $TPL_V1["div_name"]?></span>
                        </label>
<?php }}?>
                    </td>
                </tr>
<?php }?>
                <tr>
                    <th>제목</th>
                    <td><input type="text" name="bbsSubject" id="devBbsSubject" value="<?php echo $TPL_VAR["bbs_subject"]?>" title="제목" style="width: 100%;">
                        <p class="txt-guide" devTailMsg="devBbsSubject"></p>
                    </td>
                </tr>
                <tr>
                    <th>내용</th>
                    <td>
                        <textarea name="bbsContents" id="devBbsContents" title="내용" style="width: 100%; height: 300px;" onblur="removeTag(this.value);"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
                        <p class="txt-guide" devTailMsg="devBbsContents"></p>
                    </td>
                </tr>
                <tr>
                    <th>UCC</th>
                    <td>
                        <input type="text" name="bbs_etc1" id="" value="<?php echo $TPL_VAR["bbs_etc1"]?>" title="UCC" style="width: 100%;">
                    </td>
                </tr>

<?php if($TPL_VAR["board_file_yn"]=='Y'){?>
                <tr>
                    <th>첨부파일</th>
                    <td>
                        <div>
                            <input type="file" name="bbsFile1" id="devBbsFile1" style="display:none;" title="첨부파일" >
                            <input type="text" class="pub-input-text" id="devBbsFileText1" value="<?php echo $TPL_VAR["bbs_file_1"]?>" style="width:500px;" readonly>
                            <button type="button" class="btn-default btn-dark" id="devBbsFileButton1">파일찾기</button>
                            <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton1" style="display:none;">파일변경</button>
                            <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton1" style="display:none;">파일삭제</button>
                        </div>
                        <div class="mat10">
                            <input type="file" name="bbsFile2" id="devBbsFile2" style="display:none;" title="첨부파일" >
                            <input type="text" class="pub-input-text" id="devBbsFileText2" value="<?php echo $TPL_VAR["bbs_file_2"]?>" style="width:500px;" readonly>
                            <button type="button" class="btn-default btn-dark" id="devBbsFileButton2">파일찾기</button>
                            <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton2" style="display:none;">파일변경</button>
                            <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton2" style="display:none;">파일삭제</button>
                        </div>
                        <div class="mat10">
                            <input type="file" name="bbsFile3" id="devBbsFile3" style="display:none;" title="첨부파일" >
                            <input type="text" class="pub-input-text" id="devBbsFileText3" value="<?php echo $TPL_VAR["bbs_file_3"]?>" style="width:500px;" readonly>
                            <button type="button" class="btn-default btn-dark" id="devBbsFileButton3">파일찾기</button>
                            <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton3" style="display:none;">파일변경</button>
                            <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton3" style="display:none;">파일삭제</button>
                        </div>
                        <!--
                        <div class="mat10">
                            <input type="file" name="bbsFile4" id="devBbsFile4" style="display:none;" title="첨부파일" >
                            <input type="text" class="pub-input-text" id="devBbsFileText4" style="width:500px;" readonly>
                            <button type="button" class="btn-default btn-dark" id="devBbsFileButton4">파일찾기</button>
                            <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton4" style="display:none;">파일변경</button>
                            <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton4" style="display:none;">파일삭제</button>
                        </div>
                        -->
                        <p class="txt-guide">파일 형식은 이미지 파일(jpg, jepg, png)로 제출 가능하며, 파일당 최대 30MB까지 가능합니다.</p>
                    </td>
                </tr>
<?php }?>
                <tr class="apply__secret">
                    <th>비밀글 설정</th>
                    <td>
                        <span class="apply__secret__ask">비밀글 설정을 하시겠습니까?</span>
                        <label>
                            <input type="radio" name="isHidden" value="1" checked>
                            <span>예</span>
                        </label>
                        <label>
                            <input type="radio" name="isHidden" value="0" disabled>
                            <span>아니오</span>
                        </label>
                        <p class="apply__secret__desc">
                            - 전화번호, 이메일, 배송지 주소, 환불계좌 정보 등 개인정보가 포함된 게시글은 개인정보 도용의
                            위험이 있으니<br> 비밀글로 문의해 주시기 바랍니다.
                        </p>
                        <p class="apply__secret__desc">
                            - 상품과 관계없는 내용, 비방, 욕설, 광고, 도배 등의 게시물은 예고없이 삭제될 수 있습니다.
                        </p>
                    </td>
                </tr>
            </table>
            <div class="wrap-btn-area mat40 fb__teacher__btn">
                <button type="button" id="devBbsRegCancel" class="btn-lg btn-dark-line">취소</button>
                <button type="button" id="devBbsRegSubmit" class="btn-lg fb__btn-black">등록</button>
                <a href="/brand/teacherMember/" class="fb__teacher__list btn-lg btn-dark-line">목록</a>
            </div>

        </form>
    </div>
</div>