<?php /* Template_ 2.2.8 2020/10/22 17:01:29 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/basic/bbs_write.htm 000010008 */ 
$TPL_bbsDiv_1=empty($TPL_VAR["bbsDiv"])||!is_array($TPL_VAR["bbsDiv"])?0:count($TPL_VAR["bbsDiv"]);?>
<div class="wrap-inquiry fb__bbs__write">
    <div class="weite">
        <header class="bbs-title-area weite__header">
            <h1 class="weite__header__title">1:1 Inquiry</h1>
            <p class="weite__header__summary">
                You can check the answers to your questions through My Page > My Community > 1:1.
            </p>
        </header>
    </div>
    <form name='bbsForm' id="devBbsForm" method='post' enctype="multipart/form-data" >

        <input type="hidden" name="bbsTableName" value='<?php echo $TPL_VAR["bbs_table_name"]?>'>
        <input type="hidden" name="board" value="<?php echo $TPL_VAR["board_ename"]?>">
        <input type="hidden" name="focusInfo">
        <input type="hidden" name="isHtml" value='N'>
        <input type='hidden' name='antispamYn' value='N'>
        <input type='hidden' name='uType' value='<?php if(!empty($TPL_VAR["bbs_ix"])){?>U<?php }?>'>
<?php if($TPL_VAR["bbsIx"]){?>
        <input type='hidden' name='bbsIx' value='<?php echo $TPL_VAR["bbsIx"]?>'>
<?php }?>

        <table class="join-table type02">
            <colgroup>
                <col width="160px">
                <col width="*">
            </colgroup>
            <tr>
                <th><em>*</em>Sort</th>
                <td>
                    <select name="bbsDiv" id="devBbsDiv" title="Sort" style="width:260px;">
                        <option value="">Select</option>
<?php if($TPL_bbsDiv_1){foreach($TPL_VAR["bbsDiv"] as $TPL_V1){?>
                        <option value="<?php echo $TPL_V1["div_ix"]?>" <?php if($TPL_V1["div_ix"]==$TPL_VAR["bbs_div"]){?> selected <?php }?>><?php echo trans($TPL_V1["div_name"])?></option>
<?php }}?>
                    </select>
                    <p class="txt-guide" devTailMsg="devBbsDiv"></p>
                </td>
            </tr>
            <tr>
                <th>Order No.</th>
                <td>
                    <input type="text" name="oid" id="devOid" style="width:260px;" title="Order No." value="<?php echo $TPL_VAR["oid"]?>" readOnly>
                    <button type="button" id="devBtnOrderQuery" class="btn-default btn-dark">Search</button>
                    <button type="button" id="devBtnOrderdel" class="btn-default btn-dark">Delete</button>
                    <p class="txt-guide">If there is an order item related to this time, please check and select it.</p>
                </td>
            </tr>
            <tr>
                <th><em>*</em>Email</th>
                <td>
                    <span class="pub-email">
                        <input type="text" name="bbsEmailId" id="devBbsEmailId" style="width:160px;" title="Email" value="<?php echo $TPL_VAR["emailId"]?>">
                        <span class="hyphen_2">@</span>
                        <input type="text" name="bbsEmailHost" id="devBbsEmailHost" style="width:160px;" title="Email" value="<?php echo $TPL_VAR["emailHost"]?>">
                    </span>
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <select id="devBbsEmailHostSelect" style="width:160px; margin-left:5px;">
                        <option value="">Direct input.</option>
                        <option value="naver.com">naver.com</option>
                        <option value="gmail.com">gmail.com</option>
                        <option value="hotmail.com">hotmail.com</option>
                        <option value="hanmail.net">hanmail.net</option>
                        <option value="daum.net">daum.net</option>
                        <option value="nate.com">nate.com</option>
                    </select>
<?php }?>
                    <span class="txt-guide"></span>
                    <input type="checkbox" name="notifyEmail" id="devNotifyEmail" checked="true" value="1" class="mal10"><label>Receive response notifications</label>
                    <div style="margin-top: 8px;" devTailMsg="devBbsEmailId devBbsEmailHost"></div>
                </td>
            </tr>
<?php if($TPL_VAR["langType"]=='korean'){?>
            <tr>
                <th><em>*</em>Tel</th>
                <td>
                    <div class="selectWrap">
                        <select name="bbsHp1" id="devBbsHp1">
                            <option value="010" <?php if($TPL_VAR["phone1"]=='010'){?> selected <?php }?> >010</option>
                            <option value="011" <?php if($TPL_VAR["phone1"]=='011'){?> selected <?php }?> >011</option>
                            <option value="016" <?php if($TPL_VAR["phone1"]=='016'){?> selected <?php }?> >016</option>
                            <option value="018" <?php if($TPL_VAR["phone1"]=='018'){?> selected <?php }?> >018</option>
                            <option value="019" <?php if($TPL_VAR["phone1"]=='019'){?> selected <?php }?> >019</option>
                        </select>
                        <span class="hyphen">-</span>
                        <input type="number" name="bbsHp2" value="<?php echo $TPL_VAR["phone2"]?>" id="devBbsHp2" title="Tel">
                        <span class="hyphen">-</span>
                        <input type="number" name="bbsHp3" value="<?php echo $TPL_VAR["phone3"]?>" id="devBbsHp3" title="Tel">
                        <input type="checkbox" name="notifyHp" id="devNotifyHp" value="1" checked="true" style="width:20px;" class="mal10"><label>Receive response notifications</label>
                        <p class="txt-guide" devTailMsg="devBbsHp1 devBbsHp2 devBbsHp3"></span>
                    </div>
                </td>
            </tr>
<?php }?>
            <tr>
                <th><em>*</em>Title</th>
                <td><input type="text" name="bbsSubject" id="devBbsSubject" value="<?php echo $TPL_VAR["bbs_subject"]?>" title="Title" style="width: 100%;">
                    <p class="txt-guide" devTailMsg="devBbsSubject"></p>
                </td>
            </tr>
            <tr>
                <th><em>*</em>Content</th>
                <td><textarea name="bbsContents" id="devBbsContents" title="Content" style="width: 100%; height: 300px;" onblur="removeTag(this.value);"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
                    <p class="txt-guide" devTailMsg="devBbsContents"></p>
                </td>
            </tr>


<?php if($TPL_VAR["board_file_yn"]=='Y'){?>
            <tr>
                <th>Attachment</th>
                <td>
                    <div>
                        <input type="file" name="bbsFile1" id="devBbsFile1" style="display:none;" title="Attachment" >
                        <input type="text" class="pub-input-text" id="devBbsFileText1" style="width:500px;" readonly>
                        <button type="button" class="btn-default btn-dark" id="devBbsFileButton1">Find Files</button>
                        <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton1" style="display:none;">Change Files</button>
                        <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton1" style="display:none;">File delete</button>
                    </div>
                    <div class="mat10">
                        <input type="file" name="bbsFile2" id="devBbsFile2" style="display:none;" title="Attachment" >
                        <input type="text" class="pub-input-text" id="devBbsFileText2" style="width:500px;" readonly>
                        <button type="button" class="btn-default btn-dark" id="devBbsFileButton2">Find Files</button>
                        <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton2" style="display:none;">Change Files</button>
                        <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton2" style="display:none;">File delete</button>
                    </div>
                    <div class="mat10">
                        <input type="file" name="bbsFile3" id="devBbsFile3" style="display:none;" title="Attachment" >
                        <input type="text" class="pub-input-text" id="devBbsFileText3" style="width:500px;" readonly>
                        <button type="button" class="btn-default btn-dark" id="devBbsFileButton3">Find Files</button>
                        <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton3" style="display:none;">Change Files</button>
                        <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton3" style="display:none;">File delete</button>
                    </div>
                    <div class="mat10">
                        <input type="file" name="bbsFile4" id="devBbsFile4" style="display:none;" title="Attachment" >
                        <input type="text" class="pub-input-text" id="devBbsFileText4" style="width:500px;" readonly>
                        <button type="button" class="btn-default btn-dark" id="devBbsFileButton4">Find Files</button>
                        <button type="button" class="btn-default btn-dark mal10" id="devBbsFileUpdateButton4" style="display:none;">Change Files</button>
                        <button type="button" class="btn-default btn-dark-line mal10" id="devBbsFileDeleteButton4" style="display:none;">File delete</button>
                    </div>
                    <p class="txt-guide">All imgage file must be in (jpg, jepg,png) and can not exceed 30MB</p>
                </td>
            </tr>
<?php }?>

        </table>


        <div class="wrap-btn-area mat40">
            <button type="button" id="devBbsRegCancel" class="btn-lg btn-dark-line">Cancel</button>
            <button type="button" id="devBbsRegSubmit" class="btn-lg fb__btn-black">Submit</button>
        </div>

    </form>

</div>