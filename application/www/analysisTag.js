var SalesAnalysisTag = {
    data_root: '',
    campaignType: null,
    campaignID: null,
    siteID: "0002",
    agent_type: 'W',
    hosts: [document.domain],
    URL: '',
    referer: '',
    GS: '',
    setGS: function (GS) {
        this.GS = (GS ? GS : document.domain);
        return this;
    },
    setDataRoot: function (data_root) {
        this.data_root = data_root;
        return this;
    },
    setReferer: function () {
        var ref = escape((document.referrer + '').replace(/http:\/\//gi, '').replace(/https:\/\//gi, ''));
        this.referer = ref;
        return this;
    },
    setUrl: function () {
        this.URL = [
            window.location.host,
            window.location.pathname,
            window.location.search
        ].join('');
        return this;
    },
    setAgentType: function () {
        this.agent_type = this.getAgnetType();
        return this;
    },
    getAgnetType: function () {
        if (navigator.userAgent.match(/Android/i)
                || navigator.userAgent.match(/webOS/i)
                || navigator.userAgent.match(/iPhone/i)
                || navigator.userAgent.match(/iPad/i)
                || navigator.userAgent.match(/iPod/i)
                || navigator.userAgent.match(/BlackBerry/i)
                || navigator.userAgent.match(/Windows Phone/i)
                ) {
            return "M";
        } else {
            var host = "" + document.domain;

            if (host.indexOf("app.") > 0) {
                return "A";
            } else if (host.indexOf("m.") > 0) {
                return "M";
            } else {
                return "W";
            }
        }
    },
    run: function () {
        var requestURL = [
            "http://",
            this.GS,
            "/collect.php?",
            "siteID=", this.siteID,
            "&URL=", this.URL,
            "&agent_type=", this.agent_type
        ];

        if (this.referer) {
            requestURL.push('&referer=');
            requestURL.push(this.referer);
        }

        (new Image()).src = requestURL.join('');
        
//        this.testRun();
    },
    testRun: function () {
        var requestURL = [
            "http://dev.forbizkorea.co.kr",
            "/collect.php?",
            "siteID=", this.siteID,
            "&data_root=/data/enterprise_data",
            "&URL=", this.URL,
            "&agent_type=", this.agent_type
        ];

        if (this.referer) {
            requestURL.push('&referer=');
            requestURL.push(this.referer);
        }

        (new Image()).src = requestURL.join('');
    },
    init: function (data, campaignType, campaignID) {
        this.setReferer().setUrl().setAgentType();

        return this;
    }
};

function SetSalesAnalysisTag(data, siteID, data_root, GS)
{
    // 전역객체로 객체가 생성되었을 경우 수집서버로의 데이터 전송을 보장하기 위함 
    try
    {
        SalesAnalysisTag.init(data)
                .setDataRoot(data_root)
                .setGS(GS)
                .run();
    } catch (e) {
        console.log(e);
    }
}
