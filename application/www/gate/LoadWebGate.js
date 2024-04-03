//begin of 대기열 script

// set global variable from url
_gateId = $WG.getParam( "GateId" );
_nextUrl = $WG.getParam( "NextUrl" );


// 페이지 로드 시 대기열 호출
window.addEventListener( "load", function () {
    startWebGate();
} );

/* =====================================================================================
 * 대기열 서비스 호출 
 * ===================================================================================== */
function restartWebGate() {
    startWebGate();
}
function startWebGate() {
    if ( !_gateId || !_nextUrl ) {
        alert( "Invalid parameter" );
        return false;
    }

    $WG.startWebGate( {
        gateId: _gateId,
        onSuccess: function ( data ) {
            /* -----------------------------------------------------------------------------
             * 대기가 완료 시
             * -----------------------------------------------------------------------------*/
            window.location.href = _nextUrl;
        },
        onWaiting: function ( data ) {
            vm.response = $WG.lastResponse;
        },
        onFail: function () {
            restartWebGate();
        },
    } );
}
//end of 대기열 script 


//begin of Custom UI script
var vm = new Vue( {
    el: "#app",
    data: {
        response: {}
    },
    computed: {
        waitNo: function () {
            if ( this.response ) {
                return this.response.WaitNo;
            } else {
                return 0;
            }
        },
        waitMinutes: function () {
            if ( this.response )
                return parseInt( this.response.UserExpectWaitSeconds / 60 );
            else
                return 0;
        },
        waitSeconds: function () {
            if ( this.response )
                return ( this.response.UserExpectWaitSeconds % 60 );
            else
                return 0;

        },
        waitTime: function () {
            if ( isNaN( this.waitMinutes ) || isNaN( this.waitSeconds ) )
                return "-";
            else
                return ( this.waitMinutes > 0 ? this.waitMinutes + "분 " : "" ) + ( this.waitSeconds + "초" );
        },
        waitPercent: function () {
            if ( this.response ) {
                return this.response.ProgressPercent;
            } else {
                return 0;
            }
        }
    }
} );
//end of Custom UI script



