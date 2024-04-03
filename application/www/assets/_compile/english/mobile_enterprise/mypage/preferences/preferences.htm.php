<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/preferences/preferences.htm 000002303 */ ?>
<h1 class="setup-page">
    설정
</h1>

<div class="setup-wrap">
    <div class="setup-alarm">
        <dt class="set-tit">Agreeing to shopping information</dt>
        <label class="set-switch">
            <input type="checkbox" id="toggle-btn" class="sj__toggle-btn__input" <?php if($TPL_VAR["is_allowable"]== 1){?>checked<?php }?>>
            <span class="slider"></span>
        </label>
        <dd>
            <?php echo trans('배럴에서 제공하는 쿠폰, 이벤트, 기획전 등
            다양한 할인 혜택 및 마케팅 정보를 받으실 수 있습니다.')?>

        </dd>
        <dd>
            <span>&#183;</span> <?php echo trans('디바이스의 Push 수신 설정은 단말기의 설정에서<br>
            변경하실 수 있습니다. &#40;설정&#62;알림&#41;')?>

        </dd>
        <dd>
            <span>&#183;</span> <?php echo trans('단말기의 Push 수신에 따라 쇼핑 정보가 전달되지 않을 수<br>
            있습니다.')?>

        </dd>
    </div>

    <dl class="setup-info">
        <dt class="set-tit">Version Info</dt>
        <figure>
            <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/icon-setup-version.png" alt="배럴 앱 아이콘">
        </figure>
        <dd>
            <em>Current Version</em> <span id="appVersion">알수없음</span></br>
        </dd>
        <dd>
            <em>New Version</em> <span id="newVersion"><?php echo $TPL_VAR["newVersion"]?></span></br>
        </dd>
        <a href="#" class="version__info__update">Update</a>
    </dl>
<?php if(is_login()){?>
    <div class="setup-logout">
        <a class="devLogout">Logout</a>
    </div>
<?php }?>

    <div class="check" devUserCode="<?php echo sess_val('user','code')?>">
        <input type="checkbox" class="ios" style="display: block;" <?php if($TPL_VAR["is_allowable"]== 1){?>checked<?php }?>>
        <div class="ios-ui-select <?php if($TPL_VAR["is_allowable"]== 1){?>checked<?php }?>">
            <div class="inner"></div>
        </div>
    </div>

</div>
<script>
    var devAppType = '<?php echo getAppType()?>';
</script>