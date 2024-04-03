"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
(function ($) {
    $.fn.extend({
        iosCheckbox: function () {
            $(this).each(function () {
                /**
                 * Original checkbox element
                 */
                var org_checkbox = $(this);
                /**
                 * iOS checkbox div
                 */
                var ios_checkbox = jQuery("<div>", {class: 'ios-ui-select'}).append(jQuery("<div>", {class: 'inner'}));

                // If the original checkbox is checked, add checked class to the ios checkbox.
                if (org_checkbox.is(":checked")) {
                    ios_checkbox.addClass("checked");
                }
                // Hide the original checkbox and print the new one.
                org_checkbox.hide().after(ios_checkbox);
                // Add click event listener to the ios checkbox
                ios_checkbox.click(function () {
                    // Toggel the check state
                    ios_checkbox.toggleClass("checked");
                    // Check if the ios checkbox is checked
                    if (ios_checkbox.hasClass("checked")) {
                        // Update state
                        org_checkbox.prop('checked', true);

                        devPreferencesObj.updateToken($(this).closest('[devUserCode]').closest('[devUserCode]').attr('devUserCode'), '1');
                    } else {
                        // Update state
                        org_checkbox.prop('checked', false);

                        devPreferencesObj.updateToken($(this).closest('[devUserCode]').closest('[devUserCode]').attr('devUserCode'), '0');
                    }
                });
            });
        }
    });
})(jQuery);
$(document).ready(function () {
    $(".ios").iosCheckbox();
});


/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devPreferencesObj = {

    agent: false,
    deviceId: false,
    version : false,
    initDeviceId: function (){
        if(this.deviceId === false) {
            var agentInfo = navigator.userAgent.split('//');
            this.agent = agentInfo[1];
            this.deviceId = agentInfo[2];
            this.version = agentInfo[3];
        }
    },
    setAppVersion: function () {
        var newV = $('#newVersion').text();
        $('#appVersion').text(this.version);
        if(this.version == newV) {
            $('.version__info__update').hide();
        }
    },
    updateToken: function (deviceId, isAllowed) {
        var self = this;

        common.ajax(
            common.util.getControllerUrl('modifyPushAllowable', 'mypage'),
            {
                deviceId: self.deviceId,
                isAllowed: isAllowed
            },
            '',
            function (response) {
                if (response.data == '1') {
                    //self.checkOn();
                } else {
                    //self.checkOff();
                }
            }
        );
    },
    setDeviceId: function () {
        var self = this;
        common.ajax(
            common.util.getControllerUrl('isAllowableCheck', 'mypage'),
            {
                id: this.deviceId,
            },
            '',
            function (response) {
                if (response.data == '1') {
                    self.checkOn();
                } else {
                    self.checkOff();
                }
            }
        );
    },
    logout: function () {
        if (devAppType == 'iOS') {
            //아이폰용
            try {
                webkit.messageHandlers.logout.postMessage("");
            } catch (err) {
                console.log(err);
            }
        } else if (devAppType == 'Android') {
            //안드로이드용
            try {
                window.JavascriptBridge.logout();
            } catch (err) {
                console.log(err);
            }
        }

        location.href='../member/logout';
    },
    checkOn: function () {
        $('#toggle-btn').prop('checked', true);
        $('.ios-ui-select').addClass('checked');
    },
    checkOff: function () {
        $('#toggle-btn').prop('checked', false);
        $('.ios-ui-select').removeClass('checked');
    },
    run: function () {
        var self = this;
        self.initDeviceId();
        self.setAppVersion();
        self.initEvent();
        self.setDeviceId();
    },
    initEvent: function () {
        var self = this;

        $('.logout').on('click', function () {
            devPreferencesObj.logout();
        });

        $('.login').on('click', function () {
            document.location.href = '/member/login?url=' + encodeURI('/mypage/preferences');
        });

        $('.version__info__update').on('click', function () {
            if(self.agent.match(/BarrelAOSApp/i)){
                window.JavascriptInterface.updateStore();
            }else if(self.agent.match(/BarrelIOSApp/i)){
                var obj = {};
                window.webkit.messageHandlers.updateStore.postMessage(JSON.stringify(obj));
            }
        });

        $('#toggle-btn').on('click', function () {
            var check = 0;

            if($(this).is(':checked') == true) {
                check = 1;
            }

            self.updateToken(self.deviceId, check)
        });
    }
};

function setAppVersion(appVersion) {
    devPreferencesObj.setAppVersion(appVersion);
}

function setDeviceId(id) {
    devPreferencesObj.setDeviceId(id);
}

$(function () {
    devPreferencesObj.run();
});