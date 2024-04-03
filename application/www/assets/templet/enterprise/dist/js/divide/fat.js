import '../modules/polyfill';
import fbFilters from '../modules/fb_filters';
import fbLogger from '../modules/fb_logger';
import moment from 'moment';

'use strict';

const data = {
    isLoaded: false,
    isChrome: false,
    today: null,
    pathname: null,
    message: {
        noStatisticalData: '통계 데이터가 없습니다.'
    },
    usePaths: [{
        path: '/',
        regex: /^\/$/
    }, {
        path: '/shop/goodsList/',
        regex: /shop\/goodsList/,
    }, {
        path: '/shop/subGoodsList/',
        regex: /shop\/subGoodsList/,
    }, {
        path: '/shop/goodsView/',
        regex: /shop\/goodsView/,
    }],
    counting: {
        model: null
    },
    side: {
        childElements: {
            comprehensiveAnalysisButton: null,
            excelDownloadButton: null,
        },
        applyElement: null,
        filter: null,
        requestUUID: null,
        pidLength: 0,
        requestParameterProperties: {
            counting: {
                pids: 'pids',
                sDate: 'startDate',
                eDate: 'endDate',
                statType: 'countingSystem',
                countingScreen: 'countingScreen',
                curl: 'path'
            }
        },
    },
    statisticalAnalysisModal: {
        id: null,
        rootElement: null,
        childElements: {
            title: null,
            thumbnail: null,
            price: null,
            tabList: null,
            chartTitle: null,
            orderTrackingCheckboxDetail: null,
        },
        tabs: {
            activeTab: 'orderByOption',
        },
        models: {
            orderByOption: null,
            orderCountByPeriod: null,
            orderTracking: null,
            orderPatternAge: null,
            orderTargetGoods: null,
            orderPatternWeek: null,
            orderPatternHour: null,
            orderPatternPayment: null,
            orderTogether: null
        },
        requests: {
            tab: null,
            uuid: null,
        },
        requestParameterProperties: {
            orderByOption: {
                sDate: 'startDate',
                eDate: 'endDate',
            },
            orderCountByPeriod: {
                sDate: 'startDate',
                eDate: 'endDate',
                option: 'optionName',
            },
            orderTracking: {
                sDate: 'startDate',
                eDate: 'endDate',
            },
            orderPatternAge: {
                sDate: 'startDate',
                eDate: 'endDate',
            },
            orderTargetGoods: {
                sDate: 'startDate',
                eDate: 'endDate',
                sex: 'sex',
                age : 'age'
            },
            orderPatternWeek: {
                sDate: 'startDate',
                eDate: 'endDate',
            },
            orderPatternHour: {
                sDate: 'startDate',
                eDate: 'endDate',
            },
            orderPatternPayment: {
                sDate: 'startDate',
                eDate: 'endDate',
            },
            orderTogether: {
                sDate: 'startDate',
                eDate: 'endDate',
            },
        },
        googleChartProperties: {
            orderByOption: {titleId: 'fat__content__option__chart__title', wrapperId: 'fat__content__option__chart__wrapper'},
            orderCountByPeriod: {titleId: 'fat__content__option__sub__chart__title', wrapperId: 'fat__content__option__sub__chart__wrapper'},
            orderTracking: {titleId: 'fat__content__option__chart__title', wrapperId: 'fat__content__option__chart__wrapper'},
            orderPatternAge: {titleId: 'fat__content__option__chart__title', wrapperId: 'fat__content__option__chart__wrapper'},
            orderTargetGoods: {titleId: 'fat__content__option__chart__title', wrapperId: 'fat__content__option__chart__wrapper'},
            orderPatternWeek: {titleId: 'fat__content__option__chart__title', wrapperId: 'fat__content__option__chart__wrapper'},
            orderPatternHour: {titleId: 'fat__content__option__chart__title', wrapperId: 'fat__content__option__chart__wrapper'},
            orderPatternPayment: {titleId: 'fat__content__option__chart__title', wrapperId: 'fat__content__option__chart__wrapper'},
            orderTogether: {titleId: 'fat__content__option__chart__title', wrapperId: 'fat__content__option__chart__wrapper'},
        }
    },
    comprehensiveAnalysisModal: {
        id: null,
        rootElement: null,
        childElements: {
            orderOptionSelectElement: null,
            todaySummary: null,
            todayTable: null,
            categoriesArea: null,
            optionResult: null
        },
        tabs: {
            elements: {
                orderToday: null,
                orderPattern: null,
                orderOption: null
            },
            activeTab: null
        },
        models: {
            orderToday: null,
            orderPatternAgeAndSex: null,
            orderPatternSex: null,
            orderPatternAge: null,
            orderTargetGoods: null,
            orderPatternWeek: null,
            orderPatternHour: null,
            orderPatternPayment: null,
            orderPatternDevice: null,
            orderOption: null,
            orderOptionCategory: null
        },
        requests: {
            orderToday: {},
            orderPatternAgeAndSex: {},
            orderPatternSex: {},
            orderPatternAge: {},
            orderTargetGoods: {},
            orderPatternWeek: {},
            orderPatternHour: {},
            orderPatternPayment: {},
            orderPatternDevice: {},
            orderOption: {},
            orderOptionCategory: {},
        },
        requestParameterProperties: {
            orderPatternAgeAndSex: {
                sDate: 'patternStartDate',
                eDate: 'patternEndDate',
                ptype: 'patternDetailCode',
            },
            orderPatternSex: {
                sDate: 'patternStartDate',
                eDate: 'patternEndDate',
                ptype: 'patternDetailCode',
            },
            orderPatternAge: {
                sDate: 'patternStartDate',
                eDate: 'patternEndDate',
                ptype: 'patternDetailCode',
            },
            orderTargetGoods: {
                sDate: 'patternStartDate',
                eDate: 'patternEndDate',
                age : 'targetAge',
                sex : 'targetSex'
            },
            orderPatternWeek: {
                sDate: 'patternStartDate',
                eDate: 'patternEndDate',
                ptype: 'patternDetailCode',
            },
            orderPatternHour: {
                sDate: 'patternStartDate',
                eDate: 'patternEndDate',
                ptype: 'patternDetailCode',
            },
            orderPatternPayment: {
                sDate: 'patternStartDate',
                eDate: 'patternEndDate',
                ptype: 'patternDetailCode',
            },
            orderPatternDevice: {
                sDate: 'patternStartDate',
                eDate: 'patternEndDate',
                ptype: 'patternDetailCode',
            },
            orderOption: {
                sDate: 'optionStartDate',
                eDate: 'optionEndDate',
                ptype: 'ptype',
                cid: 'third|second|first',
            },
            orderOptionCategory: {
                cid: 'third|second|first',
            },
        },
        googleChartProperties: {
            orderToday: {titleId: 'syn__today__chart__title', wrapperId: 'syn__today__chart__wrapper'},
            orderPattern: {titleId: 'syn__order__pattern__chart__title', wrapperId: 'syn__order__pattern__chart__wrapper'},
            orderTargetGoods: {titleId: 'syn__order__target__goods__title', wrapperId: 'syn__order__target__goods__wrapper' },
            orderOption: {titleId: 'syn__order__option__chart__title', wrapperId: 'syn__order__option__chart__wrapper'},
        },
        //
        orderOptionCategoryDepth: ['first', 'second', 'third'],
    },
    excelModal: {
        rootElement: null,
        childElements: {
            applyButton: null,
        },
        id: null,
        models: {
            excel: null,
        },
        requests: {
            uuid: null,
        },
        requestParameterProperties: {
            excel: {
                sDate: 'startDate',
                eDate: 'endDate',
                pids: 'pids',
            }
        },
    }
};

const requests = {
    side: {
        counting: {
            method: 'statProductList',
            parameters: {pids: null, sDate: null, eDate: null, statType: null, countingScreen: null, curl: null}
        },
    },
    statisticalAnalysisModal: {
        orderByOption: {method: 'getOrderOption', parameters: {pid: null, sDate: null, eDate: null}},
        orderCountByPeriod: {method: 'getOrderOption', parameters: {pid: null, sDate: null, eDate: null, option: null}},
        orderTracking: {method: 'getOrderAndView', parameters: {pid: null, sDate: null, eDate: null}},
        orderPatternAge: {method: 'getOrderAge', parameters: {pid: null, sDate: null, eDate: null}},
        orderPatternWeek: {method: 'getOrderWeek', parameters: {pid: null, sDate: null, eDate: null}},
        orderPatternHour: {method: 'getOrderHour', parameters: {pid: null, sDate: null, eDate: null}},
        orderPatternPayment: {method: 'getOrderPayment', parameters: {pid: null, sDate: null, eDate: null}},
        orderTogether: {method: 'getTogetherProuct', parameters: {pid: null, sDate: null, eDate: null}},
    },
    comprehensiveAnalysisModal: {
        orderToday: {method: 'getTodayTotal', parameters: {}},
        orderPatternAgeAndSex: {method: 'purchasePattern', parameters: {sDate: null, eDate: null, ptype: null}},
        orderPatternSex: {method: 'purchasePattern', parameters: {sDate: null, eDate: null, ptype: null}},
        orderPatternAge: {method: 'purchasePattern', parameters: {sDate: null, eDate: null, ptype: null}},
        // orderPatternAgeAndSex: {method: 'purchasePatternMock', parameters: {sDate: null, eDate: null, ptype: null}},
        // orderPatternSex: {method: 'purchasePatternMock', parameters: {sDate: null, eDate: null, ptype: null}},
        // orderPatternAge: {method: 'purchasePatternMock', parameters: {sDate: null, eDate: null, ptype: null}},

        orderTargetGoods: {method: 'purchaseTargetGoods', parameters: {sDate: null, eDate: null, sex: null, age: null}},

        orderPatternWeek: {method: 'purchasePattern', parameters: {sDate: null, eDate: null, ptype: null}},
        orderPatternHour: {method: 'purchasePattern', parameters: {sDate: null, eDate: null, ptype: null}},
        orderPatternPayment: {method: 'purchasePattern', parameters: {sDate: null, eDate: null, ptype: null}},
        orderPatternDevice: {method: 'purchasePattern', parameters: {sDate: null, eDate: null, ptype: null}},
        orderOption: {method: 'purchasePattern', parameters: {sDate: null, eDate: null, ptype: null, cid: null}},
        orderOptionCategory: {method: 'getCategory', parameters: {cid: 0}}
    },
    excelModal: {
        excel: {method: 'getExcelData', parameters: {sDate: null, eDate: null, pids: null}},
    }
};
const pids = {
    elements: [],
    values: [],
};
const fatFilters = {
    external: null,
    side: null,
    statisticalAnalysisModal: null,
    comprehensiveAnalysisModal: null,
    excelModal: null
};
const googleCharts = {
    targetId: null,
    chartTitleWrapperIds: {},
    chartWrapperIds: {},
    charts: {},
    bar: {
        options: null,
    },
    line: {
        options: null,
    },
    column: {
        options: null,
    },
    pipe: {
        options: null,
    },
    combo: {
        options: null,
    }
}

/*
 https://gist.github.com/ahtcx/0cd94e62691f539160b32ecda18af3d6
 Merge a `source` object to a `target` recursively
 */
const merge = (target, source) => {
    // Iterate through `source` properties and if an `Object` set property to merge of `target` and `source` properties
    for (let key of Object.keys(source)) {
        if (source[key] instanceof Object) Object.assign(source[key], merge(target[key], source[key]));
    }

    // Join `target` and modified `source`
    Object.assign(target || {}, source);

    return target;
}

// TODO: 다른 곳으로 옮겨야 함.
const tempNetwork = (payload) => {
    return new Promise((resolve, reject) => {
            const {action, method, parameters} = payload;
    const requestParameters = Object.assign({}, parameters);

    try {
        switch(action) {
            case 'deActive':
                common.ajaxManager.deActive().ajax(
                    method,
                    requestParameters,
                    true,
                    (res) => {
                    common.ajaxManager.active();

                if('success' == res.result) {
                    resolve({
                        parameters: requestParameters,
                        rows: res.data,
                    });
                }
                else {
                    reject({code: 999, message: 'response failed', request: requestParameters, res: res});
                }
        }
    );
        break;
    default:
        common.ajax(
            method,
            requestParameters,
            () => true,
            (res) => {
            if('success' == res.result) resolve({
                parameters: requestParameters,
                rows: res.data,
            });
            else reject({code: 999, message: 'response failed', request: requestParameters, res: res});
        }
    );
        break;
    }
    }
    catch(ex) {
        fbLogger.error('network', 'request error', ex);
    }
});
}

// set
const setPids = () => {
    pids.elements = [];
    pids.values = [];

    const elements = document.querySelectorAll('[data-fatid]');

    for(let element of elements) {
        const pid = element.dataset.fatid;

        if(pid) {
            pids.elements.push(element);
            pids.values.push(pid);
        }
    }

    return pids.elements.length && pids.values.length;
}

const setSessionStorageItem = (id, value) => {
    window.sessionStorage.setItem(id, value);
}

const setLocalStorageItem = (id, value) => {
    window.localStorage.setItem(id, value);
}

const setGoogleChartTargetId = (googleChartTargetIds, requestId) => {
    const googleCharttTitleWrapperIds = googleCharts.chartTitleWrapperIds;
    const googleCharttWrapperIds = googleCharts.chartWrapperIds;

    if(googleChartTargetIds) {
        if(!googleCharttTitleWrapperIds[requestId]) googleCharttTitleWrapperIds[requestId] = googleChartTargetIds.titleId;
        if(!googleCharttWrapperIds[requestId]) googleCharttWrapperIds[requestId] = googleChartTargetIds.wrapperId;
    }
}

const getDateDiff = (property) => {
    const dateDiff = {
        today: 0,
        yesterday: 1,
        week: 7,
        halfmonth: 15,
        month: 30,
    }

    return dateDiff.hasOwnProperty(property) ? dateDiff[property] : 0;
}

const getGoogleChartDrawOptions = (option) => {
    const googleChartOptions = {
        orderByOption: {
            title: '옵션항목',
            column: ["옵션명", "수량", {role: 'style'}],
            dataColumn: ['option_text', 'cnt', 'style_options'],
            columnDataType: ['string', 'number', 'string'],
            chartType: 'bar',
        },
        orderTracking: {
            title: '주문/조회 분석',
            column: ['Date', '주문(전체)', '조회(전체)'],
            dataColumn: ['date', 'order', 'view'],
            columnDataType: ['string', 'number', 'number'],
            chartType: 'line',
        },
        orderTrackingDivision: {
            title: '주문/조회 분석',
            column: ['Date', '주문(PC)', '주문(Mobile)', '조회(PC)', '조회(Mobile)'],
            dataColumn: ['date', 'wOrder', 'mOrder', 'wView', 'mView'],
            columnDataType: ['string', 'number', 'number', 'number', 'number'],
            chartType: 'line',
        },
        orderPatternAge: {
            title: '성별 + 연령대별 구매',
            column: ['', '여성', '남성', '알수없음'],
            dataColumn: ['label', 'W', 'M', 'N'],
            columnDataType: ['string', 'string', 'string', 'string'],
            chartType: 'column',
        },
        orderPatternWeek: {
            title: '요일별 구매',
            column: ['', '주문수'],
            dataColumn: ['type', 'value'],
            columnDataType: ['string', 'number'],
            chartType: 'column',
        },
        orderPatternHour: {
            title: '시간대별 구매',
            column: ['', '주문수'],
            dataColumn: ['type', 'value'],
            columnDataType: ['string', 'number'],
            chartType: 'column',
        },
        orderPatternPayment: {
            title: '결제수단별',
            column: ['', '주문수'],
            dataColumn: ['type', 'value'],
            columnDataType: ['string', 'number'],
            chartType: 'pipe',
        },
        orderView: {
            title: '오늘 주문/조회 분석',
            column: ["", '조회수', '주문수'],
            dataColumn: ['time', 'view', 'order'],
            columnDataType: ['string', 'number', 'number'],
            chartType: 'combo',
        },
        orderAgeAndSex: {
            title: '성별 + 연령대별',
            column: ['', '여성', '남성', '알수없음'],
            dataColumn: ['label', 'W', 'M', 'N'],
            columnDataType: ['string', 'number', 'number', 'number'],
            chartType: 'column',
        },
        orderSex: {
            title: '성별',
            column: ['', '주문수'],
            dataColumn: ['type', 'value'],
            columnDataType: ['string', 'number'],
            chartType: 'pipe',
        },
        orderAge: {
            title: '연령대',
            column: ['', '주문수'],
            dataColumn: ['label', 'cnt'],
            columnDataType: ['string', 'number'],
            chartType: 'bar',
        },
        orderWeek: {
            title: '요일별',
            column: ['', '주문수'],
            dataColumn: ['type', 'value'],
            columnDataType: ['string', 'number'],
            chartType: 'column',
        },
        orderHour: {
            title: '시간대',
            column: ['', '주문수'],
            dataColumn: ['type', 'value'],
            columnDataType: ['string', 'number'],
            chartType: 'column',
        },
        orderPayment: {
            title: '결제수단',
            column: ['', '주문수'],
            dataColumn: ['type', 'value'],
            columnDataType: ['string', 'number'],
            chartType: 'pipe',
        },
        orderDevice: {
            title: '디바이스',
            column: ['', '주문수'],
            dataColumn: ['type', 'value'],
            columnDataType: ['string', 'number'],
            chartType: 'pipe',
        },
        orderOption: {
            column: ['', '주문수'],
            dataColumn: ['type', 'order'],
            columnDataType: ['string', 'number'],
            chartType: 'pipe',
        },
        lineOrderDate: {
            title: '기간별 옵션 주문수',
            column: ['', '주문수'],
            dataColumn: ['date', 'order'],
            columnDataType: ['string', 'number'],
            chartType: 'line',
        }
    };

    return googleChartOptions[option] || null;
}

const getComprehensiveAnalysisModalLoadingWrapperClass = (requestId) => {
    let loadingClass = null;

    switch(true) {
        case /orderOption$/.test(requestId):
            loadingClass = 'syn__order__option__result__wrapper';
            break;
        case /orderToday/.test(requestId):
            loadingClass = 'syn__today__summary__wrapper';
            break;
        case /orderPattern/.test(requestId):
            loadingClass = 'syn__order__pattern__chart__wrapper';
            break;
        case /orderTargetGoods/.test(requestId):
            loadingClass = 'syn__order__target__goods__wrapper';
            break;
    }

    return loadingClass;
}

const getCountingDummy = () => {
    return {
        tOrder: 0,
        tView: 0,
        tRate: 0,
        wOrder: 0,
        mOrder: 0,
        wView: 0,
        mView: 0,
        wRate: 0,
        mRate: 0
    }
}

const getSessionStorageItem = (id) => {
    return window.sessionStorage.getItem(id);
}

const getLocalStorageItem = (id) => {
    return window.localStorage.getItem(id);
}

const getComprehensiveAnalysisLastOrderOptionCategory = (filter) => {
    return (filter.getValue('third') ? 'third' : null) || (filter.getValue('second') ? 'second' : null) || (filter.getValue('first') ? 'first' : null);
}

const checkDateFilter = (filter, startDateKey, endDateKey, isConvert) => {
    const startDate = filter.getValue(startDateKey);
    const endDate = filter.getValue(endDateKey);
    const compareDate = compareDateFilter(startDate, endDate);

    switch(compareDate) {
        case -1:
            if(isConvert) filter.setValue(endDateKey, filter.getValue(startDateKey));
            alert('종료일은 시작일보다 빠를 수 없습니다.');
            break;
        case 1:
            if(isConvert) dateMapping(startDateKey, filter, startDate);
            alert('최대 1개월 이내의 데이터만 조회가 가능합니다.');
            break;
    }
    document.querySelectorAll('.fat input[type=date]').forEach(function(el){el.blur()})


    return 0 == compareDate;
}

const compareDateFilter = (startDate, endDate) => {
    return 0 > moment(endDate).diff(moment(startDate), 'month', true) ? -1 : (1 < moment(endDate).diff(moment(startDate), 'month', true) ? 1 : 0);
}

const addStatisticalAnalysisModalFilter = () => {
    if(!fatFilters.statisticalAnalysisModal.getValue('orderPattern')) {
        fatFilters.statisticalAnalysisModal.addFilter({
            selector: {
                name: 'fat_tab_filters_order_pattern'
            },
            key: 'orderPattern'
        });
    }
    else {
        fatFilters.statisticalAnalysisModal.setValue('orderPattern', 'orderPatternAge');
    }
}

const addStatisticalAnalysisModalFilters = () => {
    const modalData = data.statisticalAnalysisModal;
    const modalTabs = modalData.tabs;

    fatFilters.statisticalAnalysisModal = new fbFilters([{
        selector: {
            name: 'fat_order_by_option_date'
        },
        key: 'period'
    }, {
        selector: {
            id: 'fat_order_by_option_start_date'
        },
        key: 'startDate'
    }, {
        selector: {
            id: 'fat_order_by_option_end_date'
        },
        key: 'endDate'
    }, {
        selector: {
            id: 'order__tracking__type'
        },
        key: 'orderTrackingType'
    }], {
        event: function(e, key, value) {
            switch(key) {
                case 'startDate':
                case 'endDate':
                    if(checkDateFilter(fatFilters.statisticalAnalysisModal, 'startDate', 'endDate', true)) requestStatisticalAnalysisModal(modalTabs.activeTab);
                    else e.target.focus();
                    break;
                case 'orderPattern':
                    modalTabs.activeTab = value;
                    requestStatisticalAnalysisModal(value);
                    break;
                case 'period':
                    bindPeriod('statisticalAnalysisModal', value);
                    requestStatisticalAnalysisModal(modalTabs.activeTab);
                    break;
                case 'orderTrackingType':
                    drawStatisticalAnalysisModalOrderTracking(modalData.models.orderTracking, value, false);
                    break;
            }
        }
    });
}

const addComprehensiveAnalysisModalFilters = () => {
    const modalData = data.comprehensiveAnalysisModal;
    const modalTabs = modalData.tabs;

    if(!fatFilters.comprehensiveAnalysisModal) {
        fatFilters.comprehensiveAnalysisModal = new fbFilters([{
            selector: {
                name: 'syn_nav'
            },
            key: 'nav'
        }], {
            event: function(e, key, value) {
                let model = null;
                var targetId = getComprehensiveAnalysisModalLoadingWrapperClass('orderTargetGoods');    //상품리스트 초기화
                if(typeof targetId != 'undefined' && targetId != null && targetId != '') {
                    document.getElementById(targetId).innerHTML = '';
                }
                
                switch(key) {
                    case 'nav':
                        
                        changeComprehensiveAnalysis(modalTabs.activeTab, value);
                        break;
                    case 'patternStartDate':
                    case 'patternEndDate':
                        if(checkDateFilter(fatFilters.comprehensiveAnalysisModal, 'patternStartDate', 'patternEndDate', true)) changeComprehensiveAnalysis(modalTabs.activeTab, modalTabs.activeTab);
                        else e.target.focus();
                        break;
                    case 'optionStartDate':
                    case 'optionEndDate':
                        if(!checkDateFilter(fatFilters.comprehensiveAnalysisModal, 'optionStartDate', 'optionEndDate', true)) e.target.focus();
                        break;
                    case 'patternPeriod':
                        bindPeriod('comprehensiveAnalysisModal', value, 'patternStartDate', 'patternEndDate');
                        changeComprehensiveAnalysis(modalTabs.activeTab, modalTabs.activeTab);
                        break;
                    case 'optionPeriod':
                        bindPeriod('comprehensiveAnalysisModal', value, 'optionStartDate', 'optionEndDate');
                        break;
                    case 'patternDetailCode':
                        if(!checkDateFilter(fatFilters.comprehensiveAnalysisModal, 'patternStartDate', 'patternEndDate', false)) return;
                        requestComprehensiveAnalysisModal(`orderPattern${firstStringUppercase(value)}`);
                        break;
                    case 'optionOptionResultOption':
                        model = modalData.models['orderOption'];

                        drawGoogleChart('orderOption', model.rows[value], {height: 240}, {title: model.kind[value]}, {id: 'orderOption'});
                        break;
                    case 'first':
                    case 'second':
                    case 'third':
                        if(!checkDateFilter(fatFilters.comprehensiveAnalysisModal, 'optionStartDate', 'optionEndDate', false)) return;

                        for(let i = modalData.orderOptionCategoryDepth.indexOf(key) + 1; i < 3; i++) {
                            removeOrderOptionSelectHtml(modalData.orderOptionCategoryDepth[i]);
                        }

                        requestComprehensiveAnalysisModal('orderOptionCategory');
                        break;
                }
            }
        });
    }
}

const addComprehensiveAnalysisFilter = (tab) => {
    const sideFilter = data.side.filter;
    const filter = fatFilters.comprehensiveAnalysisModal;
    switch(tab) {
        case 'orderPattern':
            if(!filter.getValue('patternStartDate')) {
                filter.addFilters([{
                    selector: {
                        name: 'syn__order__pattern__filter__date'
                    },
                    key: 'patternPeriod'
                }, {
                    selector: {
                        id: 'syn__order__pattern__start__date'
                    },
                    key: 'patternStartDate'
                }, {
                    selector: {
                        id: 'syn__order__pattern__end__date'
                    },
                    key: 'patternEndDate'
                }, {
                    selector: {
                        name: 'syn__order__pattern__deatil__filter'
                    },
                    key: 'patternDetailCode'
                }]);
                filter.setValue('patternPeriod', sideFilter.period);
                filter.setValue('patternStartDate', sideFilter.startDate);
                filter.setValue('patternEndDate', sideFilter.endDate);
            }
            break;
        case 'orderOption':
            if(!filter.getValue('optionPeriod')) {
                filter.addFilters([{
                    selector: {
                        name: 'syn__order__option__filter__date'
                    },
                    key: 'optionPeriod'
                }, {
                    selector: {
                        id: 'syn__order__option__start__date'
                    },
                    key: 'optionStartDate'
                }, {
                    selector: {
                        id: 'syn__order__option__end__date'
                    },
                    key: 'optionEndDate'
                }]);
                filter.setValue('optionPeriod', sideFilter.period);
                filter.setValue('optionStartDate', sideFilter.startDate);
                filter.setValue('optionEndDate', sideFilter.endDate);
            }
            break;
    }
}

const addExcelModalFilters = () => {
    const sideFilter = fatFilters.side;

    if(!fatFilters.excelModal) {
        fatFilters.excelModal = new fbFilters([{
            selector: {
                name: 'fat__excel__filter__date'
            },
            key: 'period'
        }, {
            selector: {
                id: 'fat__excel__start__date'
            },
            key: 'startDate'
        }, {
            selector: {
                id: 'fat__excel__end__date'
            },
            key: 'endDate'
        }], {
            event: function(e, key, value) {
                switch(key) {
                    case 'period':
                        bindPeriod('excelModal', value);
                        break;
                    case 'startDate':
                    case 'endDate':
                        checkDateFilter(fatFilters.excelModal, 'startDate', 'endDate', true);
                        break;
                }
            }
        });
        fatFilters.excelModal.setValue('startDate', sideFilter.getValue('startDate'));
        fatFilters.excelModal.setValue('endDate', sideFilter.getValue('endDate'));
        fatFilters.excelModal.setValue('period', sideFilter.getValue('period'));
    }
}

const addGoogleChartEvents = (chart, dataView, events) => {
    for(let event of events) {
        google.visualization.events.addListener(chart, event.type, event.callback.bind(null, chart, dataView));
    }
}

const addLoadingMessageClass = (id) => {
    const resultWrapperElement = document.getElementById(id);

    if(!resultWrapperElement) return false;
    while(resultWrapperElement.firstChild) {
        resultWrapperElement.removeChild(resultWrapperElement.firstChild);
    };

    resultWrapperElement.classList.add('loading__message');

    return true;
}

const createCountingHtml = (type) => {
    let html = null;

    if('total' == type) {
        html = `
			<a href="javascript:void(0);" data-fat="true" class="fb__fat__btn fb__fat__counting" data-dev-fat-id="{[pid]}">
				<div class="fb__fat__btn__content">
					<div class="btn__content">
						<ul>
							<li class="btn__content__order">
								<span>{[tOrder]}</span>
							</li>
							<li class="btn__content__search">
								<span>{[tView]}</span>
							</li>
							<li class="btn__content__persent">
								<span>{[tRate]}</span>
							</li>
						</ul>
					</div>
				</div>
				<span class="fb__fat__btn__bg"></span>
			</a>
		`;
    }
    else {
        html = `
			<a href="javascript:void(0);" data-fat="true" class="fb__fat__btn fb__fat__counting" data-dev-fat-id="{[pid]}">
				<div class="fb__fat__btn__content">
					<div class="btn__content">
						<span class="btn__content__header">
							<span>PC</span>
							<span>MOBILE</span>
						</span>
						<ul>
							<li class="btn__content__order">
								<span>{[wOrder]}</span>
								<span>{[mOrder]}</span>
							</li>
							<li class="btn__content__search">
								<span>{[wView]}</span>
								<span>{[mView]}</span>
							</li>
							<li class="btn__content__persent">
								<span>{[wRate]}</span>
								<span>{[mRate]}</span>
							</li>
						</ul>
					</div>
				</div>
				<span class="fb__fat__btn__bg"></span>
			</a>
		`;
    }

    return html;
}

const createTogetherTableRowsHtml = (rows) => {
    const tableRow = [];
    const tableRowHtml = `
		<tr class="cursor__pointer new__tab__link" data-link="/shop/goodsView/{[pid]}">
			<td></td>
			<td><img src="{[thumb]}"></td>
			<td>{[pname]}</td>
			<td>{[dcprice]}</td>
			<td>{[viewCnt]}</td>
			<td>{[orderCnt]}</td>
			<td>{[cnv_rt]}</td>
		</tr>
	`;

    for(let row of rows) {
        row.dcprice = convertCommaString(row.dcprice);
        row.viewCnt = convertCommaString(row.viewCnt);
        row.orderCnt = convertCommaString(row.orderCnt);
        row.cnv_rt = convertCommaString(row.cnv_rt);
        tableRow.push(Handlebars.compile(tableRowHtml)(row));
    }

    return tableRow;
}

const createTableRowsHtml = (rows, keysOrder) => {
    const tableRow = [];
    const tableRowHtml = ['<tr>'];

    for(let key of keysOrder) {
        tableRowHtml.push(`<td>{[${key}]}</td>`);
    }
    tableRowHtml.push('</tr>');

    for(let row of rows) {
        tableRow.push(Handlebars.compile(tableRowHtml.join(''))(row));
    }

    return tableRow.join('');
}

const createComprehensiveAnalysisTodayTableRowsHtml = (rows) => {
    const tableRow = [];
    const tableRowHtml = `
		<tr class="cursor__pointer new__tab__link" data-link="/shop/goodsView/{[pid]}">
			<td>{[rank]}</td>
			<td><img src="{[thumb]}"></td>
			<td>{[pname]}</td>
			<td>{[dcprice]}</td>
			<td>{[viewCnt]}</td>
			<td>{[orderCnt]}</td>
			<td>{[cnv_rt]}</td>
		</tr>
	`;

    for(let row of rows) {
        row.dcprice = convertCommaString(row.dcprice);
        row.viewCnt = convertCommaString(row.viewCnt);
        row.orderCnt = convertCommaString(row.orderCnt);
        row.cnv_rt = convertCommaString(row.cnv_rt);
        tableRow.push(Handlebars.compile(tableRowHtml)(row));
    }

    return tableRow;
}

const createComprehensiveAnalysisSummaryElement = (rows) => {
    const elementRows = [];
    const html = `
		<div class="syn__summary__today__list">
			<span class="syn__today__title">
				{[title]}
			</span>
			<div class="syn__today__content">
				<span class="syn__today__all">
					<b>전체</b>
					{[all]}
				</span>
				<ul class="syn__today__divide">
					<li class="syn__today__pc">
						{[pc]}
					</li>
					<li class="syn__today__mo">
						{[mobile]}
					</li>
				</ul>
			</div>
		</div>
	`;

    for(let row of rows) {
        switch(row.type) {
            case 'view':
                row.title = '상품 조회수(오늘)';
                break;
            case 'order':
                row.title = '상품 주문수(오늘)';
                break;
            case 'conversionRate':
                row.title = '상품 주문 전환율(오늘)';
                break;
        }

        elementRows.push(Handlebars.compile(html)(row));
    }

    return elementRows.join('');
}

const createDivisionOrderOptionData = (rows) => {
    const divisionCategoryName = {};

    return {
        rows: rows.reduce((accumulator, currentValue, currentIndex, array) => {
            if(!accumulator[currentValue.option]) accumulator[currentValue.option] = [];
    if(!divisionCategoryName[currentValue.option]) divisionCategoryName[currentValue.option] = currentValue.optionName;

    accumulator[currentValue.option].push({
        type: currentValue.type,
        order: currentValue.order
    });

    return accumulator;
}, {}),
    kind: divisionCategoryName
};
}

const createChartRows = (rows, column, dataColumn, chartDataType, chartOptions) => {
    const chartRows = [];
    chartRows.push(column);

    for(let [i, row] of rows.entries()) {
        chartRows.push(createChartRow(i, row, dataColumn, chartDataType, chartOptions));
    }

    return chartRows;
}

const createChartRow = (parentIndex, row, columns, dataType, chartOptions) => {
    const chartRow = [];

    for(let i = 0, maxCnt = columns.length; i < maxCnt; i++) {
        const column = columns[i];

        if('style_options' == column) {
            chartRow.push(((parseInt(parentIndex) + 1) % 2 == 0 ? '#1fafeb' : '#5077e1'));

            continue;
        }

        switch(dataType[i]) {
            case 'number':
                chartRow.push(parseInt(row[column]));
                break;
            case 'float':
                chartRow.push(parseFloat(row[column]));
                break;
            default:
                chartRow.push(row[column]);
                break;
        }
    }

    return chartRow;
}

const createOrderOptionCategoryRows = (model, rows, type, cid) => {
    let makeRows = null;
    const modelCategory = model.find(v => type == v.type) || {};
    const items = rows.map(v => {return Object.assign(v, {parent: cid})});
    const category = {
        type,
        items
    };

    if(modelCategory.type) {
        modelCategory.items = modelCategory.items.concat(items);
        makeRows = model;
    }
    else {
        model.push(category);
        makeRows = model;
    }

    return makeRows;
}

const removeCountingHtml = () => {
    const countingElements = document.getElementsByClassName('fb__fat__counting');

    for(let i = countingElements.length; i--;) {
        countingElements[i].remove();
    }
}

const removeOrderOptionSelectHtml = (type) => {
    const optionElement = document.getElementById(`syn__order__option__filter__select__category__step__${type}`);

    try {
        if(optionElement) {
            fatFilters.comprehensiveAnalysisModal.removeFilter(type);
            optionElement.remove();

            return true;
        }
    }
    catch(ex) {
        fbLogger.error('fat', 'removeOrderOptionSelectHtml exception', ex);

        return false;
    }
}

const removeLoadingMessageClass = (value) => {
    try {
        const resultWrapperElement = value instanceof Element ? value : document.getElementById(value);

        if(resultWrapperElement) resultWrapperElement.classList.remove('loading__message');

        return true;
    }
    catch(ex) {
        fbLogger.error('fat', 'removeLoadingMessageClass exception', ex);

        return false;
    }
}

const renameObjectKey = (rows, renameKeys) => {
    for(let row of rows) {
        Object.keys(renameKeys).forEach((oldKey) => {
            const newKey = renameKeys[oldKey];

        if(newKey) {
            Object.defineProperty(row, newKey, Object.getOwnPropertyDescriptor(row, oldKey));
            delete row[oldKey];
        }
    })
    }

    return rows;
}

const resetCounting = () => {
    const sideData = data.side;
    const requestParameters = requests.side;

    sideData.requestUUID = null;
    sideData.pidLength = 0;

    resetSideMenuParameters();
    removeCountingHtml();
}

const resetStatisticalAnalysisModalFilter = () => {
    const filter = fatFilters.statisticalAnalysisModal;

    filter.setValue('orderPattern', 'orderPatternAge');
    filter.setValue('orderTrackingType', false);
    filter.dispose();
    fatFilters.statisticalAnalysisModal = null;
}

const resetStatisticalAnalysisModalRequests = () => {
    const statisticalAnalysisModalRequests = requests.statisticalAnalysisModal;

    Object.keys(statisticalAnalysisModalRequests).forEach(key => {
        const parameters = statisticalAnalysisModalRequests[key].parameters;

    parameters.pid = null;
    parameters.sDate = null;
    parameters.eDate = null;
});
}

const resetStatisticalAnalysisModalModels = () => {
    const models = data.statisticalAnalysisModal.models;

    Object.keys(models).forEach(key => {
        delete models[key];
});
}

const resetComprehensiveAnalysisModalRequests = () => {
    const comprehensiveAnalysisModalRequests = requests.comprehensiveAnalysisModal;

    comprehensiveAnalysisModalRequests.orderToday.parameters = {};
    comprehensiveAnalysisModalRequests.orderPatternAgeAndSex.parameters = {sDate: null, eDate: null, ptype: null};
    comprehensiveAnalysisModalRequests.orderPatternSex.parameters = {sDate: null, eDate: null, ptype: null};
    comprehensiveAnalysisModalRequests.orderPatternAge.parameters = {sDate: null, eDate: null, ptype: null};
    comprehensiveAnalysisModalRequests.orderTargetGoods.parameters = {sDate: null, eDate: null, sex: null, age: null};
    comprehensiveAnalysisModalRequests.orderPatternWeek.parameters = {sDate: null, eDate: null, ptype: null};
    comprehensiveAnalysisModalRequests.orderPatternHour.parameters = {sDate: null, eDate: null, ptype: null};
    comprehensiveAnalysisModalRequests.orderPatternPayment.parameters = {sDate: null, eDate: null, ptype: null};
    comprehensiveAnalysisModalRequests.orderPatternDevice.parameters = {sDate: null, eDate: null, ptype: null};
    comprehensiveAnalysisModalRequests.orderOption.parameters = {sDate: null, eDate: null, cid: null, ptype: null, cid: null};
    comprehensiveAnalysisModalRequests.orderOptionCategory.parameters = {cid: 0};
}

const resetComprehensiveAnalysisFilter = () => {
    const filter = fatFilters.comprehensiveAnalysisModal;

    filter.setValue('nav', 'orderToday');
    filter.setValue('patternDetailCode', 'ageAndSex');
    filter.setValue('patternPeriod', 'today');
    filter.setValue('optionPeriod', 'today');
    filter.dispose();
    fatFilters.comprehensiveAnalysisModal = null;
}

const resetComprehensiveAnalysisModalHtml = () => {
    const modalData = data.comprehensiveAnalysisModal;
    const modalChildElements = modalData.childElements;
    const childElements = modalData.childElements;

    modalData.id = null;
    modalChildElements.todaySummary.innerHTML = '';
    modalChildElements.todayTable.innerHTML = '';
    modalChildElements.categoriesArea.innerHTML = '';
    modalChildElements.optionResult.innerHTML = '';

    removeLoadingMessageClass(modalChildElements.optionResult);

    childElements.orderOptionSelectElement.disabled = true;
}

const resetExcelModal = () => {
    const modalData = data.excelModal;
    const filter = fatFilters.excelModal;

    if(!modalData.id) return;

    modalData.id = null;
    modalData.childElements.applyButton.disabled = false;
    modalData.requestParameterProperties.excel = {sDate: 'startDate', eDate: 'endDate', pids: 'pids'};
    filter.setValue('startDate', null);
    filter.setValue('endDate', null);
    filter.dispose();
    fatFilters.excelModal = null;
}

const resetGoogleCharts = () => {
    Object.keys(googleCharts.chartWrapperIds).forEach((key) => {
        if(googleCharts.charts[key]) {
        googleCharts.charts[key].clearChart();
        delete googleCharts.charts[key];
    }

    if(googleCharts.chartTitleWrapperIds[key]) delete googleCharts.chartTitleWrapperIds[key];
    if(googleCharts.chartWrapperIds[key]) delete googleCharts.chartWrapperIds[key];
});
}

const resetSideMenuParameters = () => {
    const sideRequest = requests.side;

    sideRequest.counting.parameters = {pids: null, sDate: null, eDate: null, statType: null, countingScreen: null, curl: null};
}

const convertObjectToArray = (targetObject, column) => {
    const rows = [];

    Object.keys(targetObject).forEach((key) => {
        rows.push(Object.assign({}, {type: column[key], value: targetObject[key]}));
});

    return rows;
}

const convertObjectCommaString = (row, keys) => {
    Object.keys(row).forEach(key => {
        if(keys.includes(key)) row[key] = convertCommaString(row[key]);
});

    return row;
}

const convertCommaString = (number) => {
    return parseFloat(number).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); //parseInt(number).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// TODO: convertObjectToArray로 바꿀 수 있는 애들은 바꿀 것
const convertOrderPatternRows = (rows) => {
    const convertRows = [];

    for(let row in rows) {
        convertRows.push({
            label: row,
            value: rows[row]
        });
    }

    return convertRows;
}

const isSameParameters = (parameters1, parameters2) => {
    return JSON.stringify(parameters1) == JSON.stringify(parameters2);
}

const isUseFat = () => {
    const path = data.pathname;
    let isUse = false;

    for(let usePath of data.usePaths) {
        isUse = usePath.regex.test(path);
        if(isUse) break;
    }

    return isUse;
}

const verificationRowsValue = (rows, properties) => {
    for(let row of rows) {
        for(let property of properties) {
            if(row[property]) {
                return true;
            }
        }
    }

    return false;
}

const requestCounting = async(requestId, mergeFilter) => {
    const sideData = data.side;
    const applyElement = sideData.applyElement;

    try {
        const request = requests.side[requestId];
        const beforeRequestParameters = Object.assign({}, request.parameters);
        const modalData = data.side;
        const modalFilter = fatFilters.side;
        const modalRequestParameterProperties = modalData.requestParameterProperties[requestId];
        const filters = mergeFilter ? merge(modalFilter.getFilters(), mergeFilter) : modalFilter.getFilters();
        const pidValues = pids.values;
        const pidCount = pidValues.length;
        const uuid = uuidv4();

        if('off' == modalFilter.getValue('isCounting')) {
            resetCounting();
            setLocalStorageItem('fat-side-settings', JSON.stringify(fatFilters.side.getFilters()));
            applyElement.disabled = false;

            return;
        }
        if(!checkDateFilter(modalFilter, 'startDate', 'endDate', false)) return;

        request.parameters = modalRequestParameterProperties ? createFiltersPropertiesLink(filters, modalRequestParameterProperties) : {sDate: data.today, eDate: data.today};

        if(isSameParameters(beforeRequestParameters, request.parameters) && sideData.requestPidLength == pidCount) {
            fbLogger.log('fat', 'requestCounting lock');
            return;
        }

        if(pidCount) {
            applyElement.disabled = true;
            sideData.requestUUID = uuid;
            sideData.requestPidLength = pidCount;

            viewCountingLoading();
            const result = await tempNetwork({
                action: 'deActive',
                method: common.util.getControllerUrl(request.method, 'fat'),
                parameters: request.parameters
            });

            if(uuid == sideData.requestUUID) {
                data.counting.model = result.rows;
                drawCountingHtml(result.rows, filters.countingSystem);
                setLocalStorageItem('fat-side-settings', JSON.stringify(fatFilters.side.getFilters()));
            }
            else {
                data.counting.model = null;
                fbLogger.error('fat', 'requestCounting response cancel', {code: 999, message: 'response cancel', request: result.parameters});
            }

            sideData.filter = filters;
            applyElement.disabled = false;
        }
        else {
            fbLogger.error('fat', 'requestCounting pidCount is null');
        }
    }
    catch(ex) {
        fbLogger.error('fat', 'requestCounting exception', ex);
        applyElement.disabled = false;
    }
}

const requestStatisticalAnalysisModal = async(requestId, mergeFilter) => {
    try {
        const request = requests.statisticalAnalysisModal[requestId];
        const beforeRequestParameters = Object.assign({}, request.parameters);
        const modalData = data.statisticalAnalysisModal;
        const modalTabs = modalData.tabs;
        const modalDataRequest = modalData.requests;
        const modalDataRequestTab = modalData.requests.tab;
        const modalId = modalData.id;
        const modalRequestParameterProperties = modalData.requestParameterProperties[requestId];
        const modalFilter = fatFilters.statisticalAnalysisModal;
        const filters = mergeFilter ? merge(modalFilter.getFilters(), mergeFilter) : modalFilter.getFilters();
        const activeTab = modalData.tabs.activeTab;
        const googleChartTargetOptions = {id: requestId};
        let googleChartTargetIds = modalData.googleChartProperties[activeTab];
        const googleCharttWrapperIds = googleCharts.chartWrapperIds;
        const uuid = uuidv4();

        request.parameters = modalRequestParameterProperties ? createFiltersPropertiesLink(filters, modalRequestParameterProperties) : {sDate: data.today, eDate: data.today};
        request.parameters.pid = modalData.pid;

        if(isSameParameters(beforeRequestParameters, request.parameters) && modalTabs.activeTab == modalDataRequestTab) {
            fbLogger.log('fat', 'requestStatisticalAnalysisModal lock');

            return;
        }

		/*
		 FIXME: 현재 tab당 chart 1개로 설정되어 있음
		 orderByOption 탭에선 chart 2개가 있으므로 나중에 한번에 처리 할 수 있도록 수정 필요

		 if('orderCountByPeriod' == requestId) {...}
		 */
        if('orderCountByPeriod' == requestId) {
            if(!googleCharttWrapperIds['orderCountByPeriod']) googleCharttWrapperIds['orderCountByPeriod'] = 'fat__content__option__sub__chart__wrapper';

            googleChartTargetIds = modalData.googleChartProperties['orderCountByPeriod'];
        }

        changeStatusStatisticalAnalysisSubChart('hide');
        setGoogleChartTargetId(googleChartTargetIds, requestId);
        changeChartLoadingElement(requestId, true);
        modalDataRequest.uuid = uuid;
        modalDataRequest.tab = modalTabs.activeTab;
        modalData.models[requestId] = null;

        const result = await tempNetwork({
            action: 'deActive',
            method: common.util.getControllerUrl(request.method, 'fat'),
            parameters: request.parameters
        });
        const rows = result.rows;
        let finallyRows = rows;

        if(uuid == modalDataRequest.uuid && modalId == modalData.id) {
            switch(requestId) {
                case 'orderTogether':
                    drawTogetherHtml(rows);
                    break;
                case 'orderTracking':
                    drawStatisticalAnalysisModalOrderTracking(finallyRows, filters.orderTrackingType, true);
                    break;
                case 'orderPatternAge':
                    if(!verificationRowsValue(finallyRows, ['M', 'W', 'N'])) finallyRows = null;

                    drawGoogleChart(requestId, finallyRows, {tooltip: {isHtml: true}}, {chart_tooltip: ['M', 'W']}, googleChartTargetOptions, [{type: 'onmouseover', callback: modifyOrderPatternAgeChartTooltip}]);
                    break;
                case 'orderPatternWeek':
                case 'orderPatternPayment':
                    finallyRows = convertObjectToArray(rows, createSameKeyValue(rows));

                    if(!verificationRowsValue(finallyRows, ['value'])) finallyRows = null;
                    drawGoogleChart(requestId, finallyRows, null, null, googleChartTargetOptions, null);
                    break;
                case 'orderPatternHour':
                    finallyRows = convertObjectToArray(rows, createSameKeyValue(rows)).sort((a, b) => {return a.type - b.type;});

            if(!verificationRowsValue(finallyRows, ['value'])) finallyRows = null;
            drawGoogleChart(requestId, finallyRows, null, null, googleChartTargetOptions, null);
            break;
        case 'orderByOption':
            drawGoogleChart(requestId, finallyRows, {chartArea: {left: 65}}, null, googleChartTargetOptions, [{type: 'select', callback: clickOrderByOptionChart}]);
            break;
        case 'orderCountByPeriod':
            changeStatusStatisticalAnalysisSubChart('show');
            drawGoogleChart('lineOrderDate', renameObjectKey(rows, {ldate: 'date', cnt: 'order'}), {tooltip: {isHtml: true}}, null, googleChartTargetOptions, [{type: 'onmouseover', callback: modifyOrderCountByPeriodChartTooltip}, {type: 'select', callback: modifyOrderCountByPeriodChartTooltip}]);

            document.getElementById('fat__content__option__sub__chart').scrollIntoView();
            break;
        default:
            drawGoogleChart(requestId, finallyRows, null, null, googleChartTargetOptions, null);
            break;
        };

            modalData.models[requestId] = finallyRows;
        }
        else {
            fbLogger.error('fat', 'response cancel', {code: 999, message: 'response cancel', request: result.parameters});
        }
    }
    catch(ex) {
        fbLogger.error('fat', 'requestStatisticalAnalysisModal exception', ex);
    }
}

const requestComprehensiveAnalysisModal = async(requestId, mergeFilter) => {
    fbLogger.log('fat', 'requestComprehensiveAnalysisModal', requestId);

    

    const modalData = data.comprehensiveAnalysisModal;
    const activeTab = requestId == 'orderTargetGoods' ? 'orderTargetGoods' : modalData.tabs.activeTab;
    const modalFilter = fatFilters.comprehensiveAnalysisModal;

    try {
        const request = requests.comprehensiveAnalysisModal[requestId];
        const beforeRequestParameters = Object.assign({}, request.parameters);
        const modalDataModel = modalData.models[requestId];
        const modalDataRequest = modalData.requests[requestId];
        const modalRequestParameterProperties = modalData.requestParameterProperties[requestId];
        const modalId = modalData.id;
        const filters = mergeFilter ? merge(modalFilter.getFilters(), mergeFilter) : modalFilter.getFilters();
        const uuid = uuidv4();
        const chartOptions = {height: 436};
        const googleChartTargetOptions = {id: requestId};
        const googleChartTargetIds = modalData.googleChartProperties[activeTab];
        const loadingClass = getComprehensiveAnalysisModalLoadingWrapperClass(requestId);

        request.parameters = modalRequestParameterProperties ? createFiltersPropertiesLink(filters, modalRequestParameterProperties) : {sDate: data.today, eDate: data.today};

        if(isSameParameters(beforeRequestParameters, request.parameters)) {
            fbLogger.log('fat', 'requestComprehensiveAnalysisModal lock');
            
            if('orderPattern' == activeTab && null != modalDataModel) drawGoogleChart(requestId.replace('Pattern', ''), modalDataModel, chartOptions, null, googleChartTargetOptions, [{type: 'select', callback: clickOrderByGoods}]);

            return;
        }
        if('orderPattern' == activeTab) modalFilter.setElementsAttribute('patternDetailCode', 'disabled', true);
        if('orderOptionCategory' == requestId && drawExistingOrderOptionCategory(requestId, modalData, modalFilter, request.parameters.cid)) return;
        if('orderOptionCategory' != requestId) {
            setGoogleChartTargetId(googleChartTargetIds, requestId);
            changeChartLoadingElement(requestId, true);
        }

        addLoadingMessageClass(loadingClass);
        modalDataRequest.uuid = uuid;
        modalData.rootElement.classList.remove('error');
        modalData.models[requestId] = null;

        const result = await tempNetwork({
            action: 'deActive',
            method: common.util.getControllerUrl(request.method, 'fat'),
            parameters: request.parameters
        });
        const rows = result.rows;
        let finallyRows = null;

        if(uuid == modalDataRequest.uuid && modalId == modalData.id) {
            let optionCategoryType = null;
            let selectedOption = null;

            switch(requestId) {
                case 'orderToday':
                    drawGoogleChart('orderView', rows.time, {height: 300, series: {0: {targetAxisIndex: 0}, 1: {type: 'line', targetAxisIndex: 1}}}, null, googleChartTargetOptions);
                    viewComprehensiveAnalysisSummary([rows.view, rows.order, rows.conversionRate]);
                    drawComprehensiveAnalysisTodayHtml(rows.product);
                    break;
                case 'orderPatternAgeAndSex':
                case 'orderPatternAge':
                    finallyRows = rows;

                    if(!verificationRowsValue(finallyRows, ['M', 'W', 'N', 'cnt'])) finallyRows = null;
                    drawGoogleChart(requestId.replace('Pattern', ''), finallyRows, chartOptions, null, googleChartTargetOptions, [{type: 'select', callback: clickOrderByGoods}]);
                    break;
                case 'orderPatternSex':
                    finallyRows = convertObjectToArray(rows, {W: '여성', M: '남성', N: '알 수 없음'});

                    if(!verificationRowsValue(finallyRows, ['value'])) finallyRows = null;
                    drawGoogleChart(requestId.replace('Pattern', ''), finallyRows, chartOptions, null, googleChartTargetOptions, [{type: 'select', callback: clickOrderByGoods}]);
                    break;
                case 'orderTargetGoods' :
                    drawComprehensiveAnalysisTargetGoodsHtml(rows, filters.param);
                    break;
                case 'orderPatternPayment':
                    finallyRows = convertObjectToArray(rows, createSameKeyValue(rows));
                    drawGoogleChart(requestId.replace('Pattern', ''), finallyRows, chartOptions, null, googleChartTargetOptions);
                    break;
                case 'orderPatternDevice':
                    finallyRows = convertObjectToArray(rows, {W: 'PC', M: '모바일'});

                    if(!verificationRowsValue(finallyRows, ['value'])) finallyRows = null;
                    drawGoogleChart(requestId.replace('Pattern', ''), finallyRows, chartOptions, null, googleChartTargetOptions);
                    break;
                case 'orderPatternHour':
                    finallyRows = convertObjectToArray(rows, createSameKeyValue(rows)).sort((a, b) => {return a.type - b.type;});

            if(!verificationRowsValue(finallyRows, ['value'])) finallyRows = null;
            drawGoogleChart(requestId.replace('Pattern', ''), finallyRows, chartOptions, null, googleChartTargetOptions);
            break;
        case 'orderOptionCategory':
            if(!rows.length) break;

            optionCategoryType = modalData.orderOptionCategoryDepth[rows[0].depth];
            finallyRows = createOrderOptionCategoryRows(modalData.models[requestId] ? modalData.models[requestId].slice() : [], rows, optionCategoryType, request.parameters.cid);
            drawOrderOptionSelectHtml([{type: optionCategoryType, items: rows}]);
            document.getElementById('syn__order__option__filter__select__button').disabled = false;
            break;
        case 'orderOption':
            finallyRows = createOrderOptionDetailRows(rows);
            finallyRows = createDivisionOrderOptionData(finallyRows);
            drawOrderOptionResultHtml(finallyRows);
            selectedOption = modalFilter.getValue('optionOptionResultOption');
            drawGoogleChart(requestId, finallyRows.rows[selectedOption], {height: 240}, {title: finallyRows.kind[selectedOption]}, googleChartTargetOptions);
            break;
        default:
            finallyRows = convertObjectToArray(rows, createSameKeyValue(rows));

            if(!verificationRowsValue(finallyRows, ['value'])) finallyRows = null;
            drawGoogleChart(requestId.replace('Pattern', ''), finallyRows, chartOptions, null, googleChartTargetOptions);
            break;
        };

            if('orderPattern' == activeTab) modalFilter.setElementsAttribute('patternDetailCode', 'disabled', false);

            modalData.models[requestId] = finallyRows;
            removeLoadingMessageClass(loadingClass);
        }
        else {
            fbLogger.error('fat', 'response cancel', {code: 999, message: 'response cancel', request: result.parameters});
        }
    }
    catch(ex) {
        if('orderPattern' == activeTab) modalFilter.setElementsAttribute('patternDetailCode', 'disabled', false);

        changeChartLoadingElement(requestId, false);
        modalData.rootElement.classList.add('error');
        fbLogger.error('fat', 'requestComprehensiveAnalysisModal exception', ex);
    }
}

const requestExcel = async (requestId, mergeFilter) => {
    try {
        const request = requests.excelModal[requestId];
        const beforeRequestParameters = Object.assign({}, request.parameters);
        const modalData = data.excelModal;
        const modalDataRequest = modalData.requests;
        const modalId = modalData.id;
        const modalRequestParameterProperties = modalData.requestParameterProperties[requestId];
        const modalFilter = fatFilters.excelModal;
        const filters = mergeFilter ? merge(modalFilter.getFilters(), mergeFilter) : modalFilter.getFilters();
        const uuid = uuidv4();

        request.parameters = modalRequestParameterProperties ? createFiltersPropertiesLink(filters, modalRequestParameterProperties) : {sDate: data.today, eDate: data.today};

        if(isSameParameters(beforeRequestParameters, request.parameters)) {
            fbLogger.log('fat', 'requestExcel lock');

            downloadExcel('상품통계', '통계', createExcelData(modalData.models[requestId]));

            return;
        }

        modalDataRequest.uuid = uuid;

        const result = await tempNetwork({
            action: 'deActive',
            method: common.util.getControllerUrl(request.method, 'fat'),
            parameters: request.parameters
        });
        const rows = result.rows;

        if(uuid == modalDataRequest.uuid && modalId == modalData.id) {
            downloadExcel('상품통계', '통계', createExcelData(rows));
            modalData.models[requestId] = rows;
        }
        else {
            fbLogger.error('fat', 'response cancel', {code: 999, message: 'response cancel', request: result.parameters});
        }
    }
    catch(ex) {
        fbLogger.error('fat', 'requestExcel exception', ex);
    }
}

const createOrderOptionSelectOption = (items, name, value, selectedValue) => {
    const optionHtml = [];

    for(let item of items) {
        optionHtml.push(Handlebars.compile(`<option value="{[${value}]}" ${item[value] == selectedValue ? 'selected' : ''}>{[${name}]}</option>`)(item));
    }

    return optionHtml.join('');
}

const createOrderOptionDetailRows = (rows) => {
    const resultRows = [];

    for(let i = 0, maxCnt = rows.optName.length; i < maxCnt; i++) {
        const optionKindRow = rows.optName[i];
        const optionDetailRows = rows.stat[optionKindRow.idx];

        for(let j = 0, maxCntJ = optionDetailRows.length || 0; j < maxCntJ; j++) {
            const optionDetailRow = optionDetailRows[j];

            resultRows.push({
                option: i,
                optionName: optionKindRow.name,
                type: optionDetailRow.option,
                order: optionDetailRow.cnt,
            });
        }
    }

    return resultRows;
}

const createFiltersPropertiesLink = (filters, parameterProperties) => {
    const result = {};

    for([key, value] of Object.entries(parameterProperties)) {
        const valueKeys = (value || '').split('|');
        const insertKey = valueKeys.find(v => !!filters[v]);

        result[key] = filters[insertKey] || null;
    }

    return result;
}

const createSameKeyValue = (rows) => {
    const keys = {};

    Object.keys(rows).forEach(key => {
        keys[key] = key;
});

    return keys;
}

const createExcelData = (rows) => {
    let exportTable = [`
		<table x:str>
			<thead>
				<tr>
					<th>상품코드</th>
					<th>시스템코드</th>
					<th>상품명</th>
					<th>가격</th>
					<th>조회수(전체)</th>
					<th>조회수(PC)</th>
					<th>조회수(Mobile)</th>
					<th>주문수(전체)</th>
					<th>주문수(PC)</th>
					<th>주문수(Mobile)</th>
					<th>주문율(전체)</th>
					<th>주문율(PC)</th>
					<th>주문율(Mobile)</th>
					<th>상품상세경로</th>
				</tr>
			</thead>
			<tbody>
	`];

    for(let [key, value] of Object.entries(rows)) {
        if(!value.pid) continue;

        exportTable.push(`
			<tr>
				<td>${value.pid}</td>
				<td>${value.pcode}</td>
				<td>${value.pname}</td>
				<td>${convertCommaString(value.price)}</td>
				<td>${convertCommaString(value.tView)}</td>
				<td>${convertCommaString(value.wView)}</td>
				<td>${convertCommaString(value.mView)}</td>
				<td>${convertCommaString(value.tOrder)}</td>
				<td>${convertCommaString(value.wOrder)}</td>
				<td>${convertCommaString(value.mOrder)}</td>
				<td>${convertCommaString(value.tRate)}</td>
				<td>${convertCommaString(value.wRate)}</td>
				<td>${convertCommaString(value.mRate)}</td>
				<td>${value.url}</td>
			</tr>
		`);
    }

    exportTable.push('</tbody></table>');

    return exportTable.join('');
}

const firstStringUppercase = (value) => {
    return value.charAt(0).toUpperCase() + value.slice(1)
}

const viewComprehensiveAnalysisSummary = (rows) => {
    const element = data.comprehensiveAnalysisModal.childElements.todaySummary;

    if(element) element.insertAdjacentHTML('afterbegin', createComprehensiveAnalysisSummaryElement(rows));
}

const viewCountingLoading = () => {
    const pidElements = document.querySelectorAll('[data-fatid]');

    if(pidElements.length) {
        for(let element of pidElements) {
            const isLIElement = 'LI' == element.tagName;
            const countingElement = isLIElement ? element.getElementsByClassName('fb__fat__counting')[0] : element.parentElement.getElementsByClassName('fb__fat__counting')[0];

            if(!countingElement) {
                const loadingDiv = '<div class="fb__fat__counting" style="position: absolute; top: 0; right: 0; padding: 16px; background: rgba(255, 255, 255);"><img src="/assets/templet/enterprise/images/common/default_spinner.gif" style="width: 32px; height: 32px;"></div>';

                if(isLIElement) element.insertAdjacentHTML('beforeend', loadingDiv);
                else element.insertAdjacentHTML('afterend', loadingDiv);
            }
        }
    }
}

const clearGoogleChart = (id) => {
    if(googleCharts.charts[id]) {
        googleCharts.charts[id].clearChart();
        delete googleCharts.charts[id];
    }
}

const clearGoogleCharts = () => {
    Object.keys(googleCharts.chartWrapperIds).forEach((key) => {
        if(googleCharts.charts[key]) {
        googleCharts.charts[key].clearChart();
        delete googleCharts.charts[key];
    }
});
}

const drawCountingHtml = (rows, type) => {
    try {
        const pidElements = pids.elements;
        if(pidElements.length) {
            removeCountingHtml();

            for(let element of pidElements) {
                const pid = element.dataset.fatid;

                if(undefined === rows[pid]) rows[pid] = getCountingDummy();
                if('LI' == element.tagName) element.insertAdjacentHTML('beforeend', Handlebars.compile(createCountingHtml(type))(convertObjectCommaString(rows[pid], ['tOrder', 'tView', 'wOrder', 'mOrder', 'wView', 'mView', 'tRate', 'mRate', 'wRate'])));
                else element.insertAdjacentHTML('afterend', Handlebars.compile(createCountingHtml(type))(convertObjectCommaString(rows[pid], ['tOrder', 'tView', 'wOrder', 'mOrder', 'wView', 'mView', 'tRate', 'mRate', 'wRate'])));
            }

            return true;
        }

        return false;
    }
    catch(ex) {
        fbLogger.error('fat', 'drawCountingHtml exception', ex);

        return false;
    }
}

const drawStatisticalAnalysisModalOrderTracking = (rows, orderTrackingType, isDrawTable) => {
    if(!rows || !rows.length) return;

    const resultRows = extractRowsProperties(rows, orderTrackingType ? ['date', 'wView', 'mView', 'wOrder', 'mOrder'] : ['date', 'view', 'order']);
    const type = orderTrackingType ? 'orderTrackingDivision' : 'orderTracking';
    let chartOptions = null;

    if(orderTrackingType) {
        chartOptions = {
            series: {
                0: {targetAxisIndex: 0},
                1: {targetAxisIndex: 0},
                2: {targetAxisIndex: 1},
                3: {targetAxisIndex: 1},
            },
        };
    }
    if(isDrawTable) drawOrderTrackingTable(rows, orderTrackingType);
    drawGoogleChart(type, resultRows, chartOptions, null, {id: 'orderTracking'}, null);
}

const extractRowsProperties = (rows, properties) => {
    const resultRows = [];

    for(let row of rows) {
        resultRows.push(extractRowProperties(row, properties));
    }

    return resultRows;
}

const extractRowProperties = (row, properties) => {
    const resultRow = {};

    for(let property of properties) {
        resultRow[property] = row[property];
    }

    return resultRow;
}

const drawTogetherHtml = (rows) => {
    try {
        const googleCharttWrapperId = googleCharts.chartWrapperIds.orderTogether;
        const element = document.getElementById(googleCharttWrapperId);
        let html = null;

        html = `
			<table class="fat__option__content__table">
				<thead>
					<tr>
						<th class="rank">순위</th>
						<th>상품이미지</th>
						<th>상품명</th>
						<th>가격</th>
						<th>조회수</th>
						<th>주문수</th>
						<th>주문 전환율</th>
					</tr>
				</thead>
				<tbody>${createTogetherTableRowsHtml(rows).join('')}</tbody>
			</table>
		`;

        // element.attachShadow({mode: 'open'}).innerHTML = Handlebars.compile(html)(data);
        if(element)	{
            element.innerHTML = Handlebars.compile(html)(data);
            return true;
        }

        return false;
    }
    catch(ex) {
        fbLogger.error('fat', 'drawTogetherHtml exception', ex);

        return false;
    }
}


const drawComprehensiveAnalysisTodayHtml = (rows) => {
    try {
        const element = data.comprehensiveAnalysisModal.childElements.todayTable;
        let html = `
			<table class="syn__content__today__table">
				<caption>오늘 구매율이 높은 상품</caption>
				<thead>
					<tr>
						<th class="rank">순위</th>
						<th>상품이미지</th>
						<th>상품명</th>
						<th>가격</th>
						<th>조회수</th>
						<th>주문수</th>
						<th>주문 전환율</th>
					</tr>
				</thead>
				<tbody>${createComprehensiveAnalysisTodayTableRowsHtml(rows).join('')}</tbody>
			</table>
		`;

        if(element) {
            element.innerHTML = Handlebars.compile(html)(data);
            return true;
        }

        return false;
    }
    catch(ex) {
        fbLogger.error('fat', 'drawComprehensiveAnalysisTodayHtml exception', ex);

        return false;
    }
}

const drawOrderOptionResultHtml = (drawData) => {
    try {
        const optionHtml = [];
        const rows = drawData.rows;
        const kind = drawData.kind;
        const resultWrapperElement = data.comprehensiveAnalysisModal.childElements.optionResult;
        let optionCategoryHtml = '';
        let html = '';

        Object.keys(rows).forEach((key, index) => {
            optionHtml.push(`${createOrderOptionSelectOption([{name: kind[key], value: key}], 'name', 'value', 0 == index ? '' : '')}`);
    });

        resultWrapperElement.innerHTML = '';
        optionCategoryHtml = optionHtml.length ? `
			<div class="filter">
				<div class="filter__calendar">
					<span class="filter__calendar__title">
						옵션선택
					</span>
					<div class="filter__select">
						<div id="syn__order__option__result__category__area" class="filter__select">
							<select id="syn__order__option__result__category">
								${optionHtml.join('')}
							</select>
						</div>
					</div>
				</div>
			</div>
		` : '';
        html = `
			${optionCategoryHtml}
			<div class="fat__syn__option fat__syn__option__order syn__order__option__chart__group">
				<h4 id="syn__order__option__chart__title" class="fat__option__title">옵션 - 신발 사이즈2</h4>
				<div id="syn__order__option__chart__wrapper" class="fat__option__content wrap-loading" id="order_option"><span class="loading"></span></div>
			</div>
		`;
        resultWrapperElement.insertAdjacentHTML('afterbegin', html);

        if(optionCategoryHtml) {
            fatFilters.comprehensiveAnalysisModal.addFilter({
                selector: {
                    id: 'syn__order__option__result__category'
                },
                key: 'optionOptionResultOption'
            });
        }

        return true;
    }
    catch(ex) {
        fbLogger.error('fat', 'drawComprehensiveAnalysisTodayHtml exception', ex);

        return false;
    }
}

const drawComprehensiveAnalysisTargetGoodsHtml = (rows, param) => {
    try {
        const element = data.comprehensiveAnalysisModal.childElements.orderTargetGoods;
        let title = '';
        if(param.sex != '' && param.age != '') {
            title = `${param.age} + ${param.sex}`
        }else {
            title = param.age || param.sex;
        }
        let html = `
			<table class="syn__content__today__table">
				<caption>${title} 구매율이 높은 상품</caption>
				<thead>
					<tr>
						<th class="rank">순위</th>
						<th>상품이미지</th>
						<th>상품명</th>
						<th>가격</th>
						<th>조회수</th>
						<th>주문수</th>
						<th>주문 전환율</th>
					</tr>
				</thead>
				<tbody>${createComprehensiveAnalysisTodayTableRowsHtml(rows).join('')}</tbody>
			</table>
		`;

        if(element) {
            element.innerHTML = Handlebars.compile(html)(data);
            return true;
        }

        return false;
    }
    catch(ex) {
        fbLogger.error('fat', 'drawComprehensiveAnalysisTargetGoodsHtml exception', ex);

        return false;
    }
}

const drawGoogleChart = (id, rows, chartOptions, chartDrawOptions, targetOptions, events) => {
    google.charts.setOnLoadCallback(async () => {
        let googleChartDrawOption = getGoogleChartDrawOptions(id);

    if(googleChartDrawOption) {
        const googleChart = googleCharts[googleChartDrawOption.chartType];
        const chartTargetId = (targetOptions ? targetOptions.id : null) || id;
        const googleCharttTitleWrapperId = googleCharts.chartTitleWrapperIds[chartTargetId];
        const googleCharttWrapperId = googleCharts.chartWrapperIds[chartTargetId];
        const chartElement = document.getElementById(googleCharttWrapperId);
        let googleChartOption = JSON.parse(JSON.stringify(googleChart.options));

        if(!googleChart) throw({code: 999, message: 'chart type error'});
        if(googleChart.options && chartOptions) googleChartOption = merge(googleChartOption, chartOptions);
        if(chartDrawOptions) googleChartDrawOption = merge(googleChartDrawOption, chartDrawOptions);
        if(googleCharttTitleWrapperId) document.getElementById(googleCharttTitleWrapperId).innerHTML = googleChartDrawOption.title || '';
        if(rows && rows.length) {
            clearGoogleChart(chartTargetId);

            const chartDataType = googleChartDrawOption.columnDataType;
            const dataColumn = googleChartDrawOption.dataColumn;
            const chartRows = createChartRows(rows, googleChartDrawOption.column, dataColumn, chartDataType, chartDrawOptions);
            const charts = googleCharts.charts;
            const chartDataView = new google.visualization.DataView(google.visualization.arrayToDataTable(chartRows));

            switch(googleChartDrawOption.chartType) {
                case 'bar':
                    charts[chartTargetId] = new google.visualization.BarChart(chartElement);
                    break;
                case 'line':
                    charts[chartTargetId] = new google.visualization.LineChart(chartElement);
                    break;
                case 'column':
                    charts[chartTargetId] = new google.visualization.ColumnChart(chartElement);
                    break;
                case 'pipe':
                    charts[chartTargetId] = new google.visualization.PieChart(chartElement);
                    break;
                case 'combo':
                    charts[chartTargetId] = new google.visualization.ComboChart(chartElement);
                    break;
                default:
                    throw({code: 999, message: ''});
            }

            if(events) addGoogleChartEvents(charts[chartTargetId], chartDataView, events);

            charts[chartTargetId].draw(chartDataView, googleChartOption);
            charts[chartTargetId].setSelection([]);
        }
        else {
            chartElement.innerHTML = '<div class="display__flex flex__justify__content__center margin__top">조회 결과가 없습니다.</div>';
        }
    }
    else {
        chartElement.innerHTML = '<div class="display__flex flex__justify__content__center margin__top">오류가 발생하였습니다.</div>';
        fbLogger.error('fat', 'googleChartDrawOption is null');
    }
});
}

const drawOrderTrackingTable = (rows) => {
    const element = document.getElementById('fat__content__option__chart__wrapper');
    const tableElement = document.getElementById('fat__content__option__table');

    try {
        if(tableElement) tableElement.remove();
        if(rows.length && element) {
            element.insertAdjacentHTML('afterend', `
				<table id="fat__content__option__table" class="fat__default__table">
					<caption>주문/조회 상세내역</caption>
					<thead class="border__bottom">
						<tr>
							<th rowspan="2" class="vertical-align__middle border__top">날짜</th>
							<th colspan="3" class="vertical-align__middle border__top border__bottom border__left">조회수</th>
							<th colspan="3" class="vertical-align__middle border__top border__bottom border__left">주문수</th>
						</tr>
						<tr>
							<th class="vertical-align__middle">전체</th>
							<th class="vertical-align__middle">PC</th>
							<th class="vertical-align__middle border__right">MOBILE</th>
							<th class="vertical-align__middle">전체</th>
							<th class="vertical-align__middle">PC</th>
							<th class="vertical-align__middle">MOBILE</th>
						</tr>
					</thead>
					<tbody>
						${createTableRowsHtml(rows, ['date', 'view', 'wView', 'mView', 'order', 'wOrder', 'mOrder'])}
					</tbody>
				</table>
			`);

            document.querySelector('.fb__fat .fat__content').style.overflowY = 'auto';
        }

        return true;
    }
    catch(ex) {
        fbLogger.error('fat', 'drawOrderTrackingTable exception', ex);

        return false;
    }
}

const drawOrderOptionSelectHtml = (rows) => {
    const categoriesElement = data.comprehensiveAnalysisModal.childElements.categoriesArea;
    const selectHtml = [];
    const addFilters = [];

    try {
        for(let row of rows) {
            const optionElement = document.getElementById(`syn__order__option__filter__select__category__step__${row.type}`);

            if(optionElement) {
                fatFilters.comprehensiveAnalysisModal.removeFilter(row.type);
                optionElement.remove();
            }

            selectHtml.push(`
				<select id="syn__order__option__filter__select__category__step__${row.type}">
					<option value="" selected>카레고리를 선택해 주세요.</option>
					${createOrderOptionSelectOption(row.items, 'cname', 'cid')}
				</select>
			`);

            addFilters.push({
                selector: {
                    id: `syn__order__option__filter__select__category__step__${row.type}`
                },
                key: row.type
            });
        }

        categoriesElement.insertAdjacentHTML('beforeend', selectHtml.join(''));
        fatFilters.comprehensiveAnalysisModal.addFilters(addFilters);

        return true;
    }
    catch(ex) {
        fbLogger.error('fat', 'drawOrderOptionSelectHtml exception', ex);

        return false;
    }
}

const drawExistingOrderOptionCategory = (requestId, modalData, filter, cid) => {
    try {
        const categoryType = getComprehensiveAnalysisLastOrderOptionCategory(filter);
        const nextCategory = 'first' == categoryType ? 'second' : ('second' == categoryType) ? 'third' : null;

        if('third' == categoryType) return;
        if(nextCategory) {
            const model = modalData.models[requestId] ? modalData.models[requestId].slice() : [];
            const category = model.find(v => nextCategory == v.type);

            if(category) {
                let items = category.items.filter(v => cid == v.parent);

                if(items && items.length) {
                    drawOrderOptionSelectHtml([{
                        type: nextCategory,
                        items
                    }]);

                    return true;
                }
            }
        }
    }
    catch(ex) {
        fbLogger.error('fat', 'drawExistingOrderOptionCategory exception', ex);

        return false;
    }
}

const syncPeriodSideStatisticalAnalysisModal = () => {
    const sideFilters = data.side.filter;
    const modalFilters = fatFilters.statisticalAnalysisModal;

    modalFilters.setValue('startDate', sideFilters.startDate);
    modalFilters.setValue('endDate', sideFilters.endDate);
    modalFilters.setValue('period', sideFilters.period);
}

// TODO: thumbnail은 임시로 사용중... 서버에서 받아와야 함
const openStatisticalAnalysisModal = (thumbnail) => {
    const modalData = data.statisticalAnalysisModal;
    const childElements = modalData.childElements;
    const pidInfo = data.counting.model[data.statisticalAnalysisModal.pid];

    addStatisticalAnalysisModalFilters();
    syncPeriodSideStatisticalAnalysisModal();
    childElements.title.innerHTML = pidInfo.pname;
    childElements.price.innerHTML = convertCommaString(pidInfo.price);
    childElements.thumbnail.src = thumbnail;
    modalData.id = uuidv4();
    modalData.rootElement.classList.add('fb__fat--show');
    document.body.style.overflow = 'hidden';
    requestStatisticalAnalysisModal(data.statisticalAnalysisModal.activeTab);
}

const openComprehensiveAnalysisModal = () => {
    const modalData = data.comprehensiveAnalysisModal;
    const modalTabs = modalData.tabs;
    const tabElements = modalTabs.elements;

    if(!tabElements.orderToday) tabElements.orderToday = document.getElementById('syn__content__today__wrapper');
    if(!tabElements.orderPattern) tabElements.orderPattern = document.getElementById('syn__order__pattern__wrapper');
    if(!tabElements.orderOption) tabElements.orderOption = document.getElementById('syn__order__option__wrapper');

    document.body.style.overflow = 'hidden';
    modalData.id = uuidv4();
    modalData.rootElement.classList.add('fb__fat__syn--show');
    modalTabs.activeTab = 'orderToday';
    addComprehensiveAnalysisModalFilters();
    changeComprehensiveAnalysis(null, 'orderToday');
}

const openExcelModal = () => {
    const modalData = data.excelModal;

    modalData.id = uuidv4();
    modalData.rootElement.classList.add('fb__fat__excel--show');
    addExcelModalFilters();
}

const closeStatisticalAnalysisModal = () => {

    const modalData = data.statisticalAnalysisModal;
    const tabElements = modalData.childElements.tabList;
    const orderTrackingTableElement = document.getElementById('fat__content__option__table');

    if(!modalData.id) return;

    document.body.style.overflow = 'unset';
    modalData.childElements.chartTitle.style.marginTop = 'unset';
    modalData.childElements.orderTrackingCheckboxDetail.style.display = 'none';
    modalData.id = null;
    modalData.rootElement.classList.remove('fb__fat--show');
    modalData.requestUUID = null;
    modalData.tabs.activeTab = 'orderByOption';
    document.getElementById('fat__tab__filters__order__pattern__group').classList.remove('fat__fn__filter--show');
    resetStatisticalAnalysisModalFilter();
    resetStatisticalAnalysisModalRequests();
    resetStatisticalAnalysisModalModels();
    changeStatusStatisticalAnalysisSubChart('hide');
    activeRadioButtonCSS(tabElements[0].closest('.tap'), 'tap__list--active', 'tap__list', 'orderByOption');
    resetGoogleCharts();
    if(orderTrackingTableElement) orderTrackingTableElement.remove();
}

const closeComprehensiveAnalysisModal = () => {

    const modalData = data.comprehensiveAnalysisModal;

    if(!modalData.id) return;

    document.body.style.overflow = 'unset';
    modalData.rootElement.classList.remove('fb__fat__syn--show');
    modalData.id = null;
    activeRadioButtonCSS(document.querySelector('.syn__content'), 'syn__option--show', 'syn__content__wrapper', null);
    resetComprehensiveAnalysisFilter();
    resetComprehensiveAnalysisModalHtml();
    resetComprehensiveAnalysisModalRequests();
    resetGoogleCharts();
}

const closeExcelModal = () => {
    const modalData = data.excelModal;
    modalData.rootElement.classList.remove('fb__fat__excel--show');

    resetExcelModal();
}

const changeStatusStatisticalAnalysisSubChart = (type) => {
    const subChartElement = document.getElementById('fat__content__option__sub__chart');
    const parentRootElement = document.querySelector('.fb__fat .fat__content');

    if('show' == type) {
        subChartElement.classList.remove('display__none');
        subChartElement.classList.add('display__block');
        parentRootElement.style.overflowY = 'auto';
    }
    else if('hide' == type) {
        subChartElement.classList.remove('display__block');
        subChartElement.classList.add('display__none');
        parentRootElement.style.overflowY = 'unset';
    }
}

const changeComprehensiveAnalysis = (oldTab, newTab) => {
    const modalData = data.comprehensiveAnalysisModal;
    const tabElements = modalData.tabs.elements;
    const filter = fatFilters.comprehensiveAnalysisModal;

    if(oldTab) tabElements[oldTab].classList.remove('syn__option--show');

    tabElements[newTab].classList.add('syn__option--show');
    modalData.tabs.activeTab = newTab;
    
    switch(newTab) {
        case 'orderToday':
            requestComprehensiveAnalysisModal(newTab);
            break;
        case 'orderPattern':
            addComprehensiveAnalysisFilter(newTab);
            requestComprehensiveAnalysisModal(`orderPattern${firstStringUppercase(filter.getValue('patternDetailCode'))}`);
            break;
        case 'orderOption':
            addComprehensiveAnalysisFilter(newTab);
            requestComprehensiveAnalysisModal('orderOptionCategory');
            break;
    }
}

const changeChartLoadingElement = (targetId, isView) => {
    const googleCharttWrapperId = googleCharts.chartWrapperIds[targetId];
    const chartWrapperElement = document.getElementById(googleCharttWrapperId);

    if(chartWrapperElement) {
        if(isView) chartWrapperElement.innerHTML = '<span class="loading"></span>';
        else chartWrapperElement.innerHTML = '';
    }
}

const activeRadioButtonCSS = (parentElement, activeClass, targetClass, targetValue) => {
    const targetElements = parentElement.getElementsByClassName(targetClass);
    let activeElement = null;

    for(let targetElement of targetElements) {
        if(targetValue && targetValue == targetElement.dataset.activeType) activeElement = targetElement;

        targetElement.classList.remove(activeClass);
    }

    if(activeElement) activeElement.classList.add(activeClass);
}

const modifyOrderPatternAgeChartTooltip = (chart, dataView, eventData) => {
    const tooltipElement = chart.container.getElementsByClassName('google-visualization-tooltip')[0];
    const tooltipUlElement = tooltipElement.getElementsByTagName('ul')[0];
    const tooltipLabelElement = tooltipUlElement.getElementsByTagName('span');
    const model = data.statisticalAnalysisModal.models['orderPatternAge'][eventData.row];
    const chartOption = getGoogleChartDrawOptions('orderPatternAge');
    const columnProperty = chartOption.column[eventData.column];
    const dataColumnProperty = chartOption.dataColumn[eventData.column];

    if(tooltipUlElement) {
        let share = 0;
        const labelStyle = tooltipLabelElement[0] ? tooltipLabelElement[0].getAttribute('style') : '';
        const valueStyle = tooltipLabelElement[1] ? tooltipLabelElement[1].getAttribute('style') : '';

        tooltipUlElement.innerHTML = '';

        for(let [key, value] of Object.entries(model)) {
            if('label' == key) continue;

            share += value;
        }

        share = model[dataColumnProperty] / share * 100;
        tooltipElement.style.width = 'auto';
        tooltipElement.style.height = 'auto';
        tooltipUlElement.insertAdjacentHTML('beforeend', `
			<li class="google-visualization-tooltip-item">
				<span style="${labelStyle}">${columnProperty}</span>
				<span style="${valueStyle}">(${model.label})</span>
			</li>
			<li class="google-visualization-tooltip-item">
				<span style="${labelStyle}">주문수</span>
				<span style="${valueStyle}">${model[dataColumnProperty]}(${share.toString().split('.')[1] ? share.toFixed(2) : share}%)</span>
			</li>
		`);
    }
}


const clickOrderByGoods = (chart, dataView) => {
    const selected = chart.getSelection();
    const selectedRange = selected[0] || null;
    const activeTab = document.querySelector('[name=syn__order__pattern__deatil__filter]:checked').value;

    if(selectedRange) {
        const formSex = { "남성" : "M", "여성" : "W", "알수없음" : "N", "전체" : "A" };
        const formAge = { "10대" : 0, "20대" : 1, "30대" : 2, "40대" : 3, "50대" : 4, "60대" : 5, "60대 이상" : 6, "연령 알수없음" : 7, "전체" : "A" };
        let sex = '', age = '';
        const param = { sex : '', age : '' };
        switch(activeTab) {
            case "ageAndSex" :
                sex = formSex[dataView.getColumnLabel(selectedRange.column)];
                age = formAge[dataView.getFormattedValue(selectedRange.row, 0)];
                param.sex = dataView.getColumnLabel(selectedRange.column);
                param.age = dataView.getFormattedValue(selectedRange.row, 0);
                break;
            case "sex" :
                sex = formSex[dataView.getValue(selectedRange.row, 0)];
                age = formAge["전체"];
                param.sex = dataView.getValue(selectedRange.row, 0);
                break;
            case "age" :
                sex = formSex["전체"];
                age = formAge[dataView.getFormattedValue(selectedRange.row, 0)];
                param.age = dataView.getFormattedValue(selectedRange.row, 0);
                break;
            default :
                return false;
        }
        data.comprehensiveAnalysisModal.childElements.orderTargetGoods.innerHmtl = '';
        requestComprehensiveAnalysisModal('orderTargetGoods', {
            targetSex : sex,
            targetAge : age,
            param : param
        });
        requests.comprehensiveAnalysisModal.orderTargetGoods.parameters = {
            'age' : null,
            'sex' : null
        }

    }
}

const resetOrderTargetGoods = () => {
    
}

const modifyOrderCountByPeriodChartTooltip = (chart, dataView, eventData) => {
    const tooltipElement = chart.container.getElementsByClassName('google-visualization-tooltip')[0];
    const tooltipUlElement = chart.container.getElementsByTagName('ul')[0];
    const tooltipLabelElements = chart.container.getElementsByTagName('span');

    if(tooltipUlElement) {
        tooltipLabelElements[1].innerHTML = `${requests.statisticalAnalysisModal['orderCountByPeriod'].parameters.option.replace('사이즈:', '')} ${tooltipLabelElements[1].innerHTML}`;

        tooltipElement.style.width = 'auto';
        tooltipElement.style.height = 'auto';
    }
}

const clickOrderByOptionChart = (chart, dataView) => {
    const selected = chart.getSelection();
    const selectedRow = selected[0] || null;

    if(selectedRow) {
        const itemName = dataView.getFormattedValue(selectedRow.row, 0);

        requestStatisticalAnalysisModal('orderCountByPeriod', {optionName: itemName});
    }
}

const dateMapping = (type, filter, date) => {
    const today = moment();
    const regex = /(\w+)*(startDate$|endDate$)/gi.exec(type);
    let setDate = null;
    let isMapping = false;

    if(!regex || !regex[2]) return false;
    switch(regex[2].toLowerCase()) {
        case 'startdate':
            setDate = moment(date);

            if(1 == setDate.date()) setDate.endOf('month').format('YYYY-MM-DD');
            else setDate.add(1, 'month').format('YYYY-MM-DD');

            isMapping = filter.setValue(`${regex[1] ? regex[1] + 'EndDate' : 'endDate'}`, 0 > today.diff(setDate, 'days') ? data.today : setDate.format('YYYY-MM-DD'));
            break;
        case 'enddate':
            setDate = moment(date);
            isMapping = filter.setValue(`${regex[1] ? regex[1] + 'StartDate' : 'startDate'}`, setDate.date() == setDate.clone().endOf('month').format('DD') ? setDate.startOf('month').format('YYYY-MM-DD') : setDate.subtract(1, 'month').format('YYYY-MM-DD'));
            break;
    }

    return isMapping;
}

const downloadExcel = (fileName, sheetName, table) => {
    const uri = 'data:application/vnd.ms-excel;base64,';
    const template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>{table}</body></html>';
    const base64 = function(s) {return window.btoa(unescape(encodeURIComponent(s)))};
    const format = function(s, c) {return s.replace(/{(\w+)}/g, function(m, p) {return c[p];})};
    const ctx = {worksheet: sheetName || 'Worksheet', table}
    const downloadElement = document.createElement('a');

    downloadElement.download = `${fileName}.xls`;
    downloadElement.href = uri + base64(format(template, ctx));
    downloadElement.click();
}

// uuid
const uuidv4 = () => {
    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ (!!navigator.userAgent.match(/Trident.*rv\:11\./) ? msCrypto : crypto).getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
);
}

const addEvents = () => {
    const sideMenuChildElements = data.side.childElements;
    const statisticalAnalysisModalChildElements = data.statisticalAnalysisModal.childElements;
    const comprehensiveAnalysisModalChildElements = data.comprehensiveAnalysisModal.childElements;
    const excelModalChildElements = data.excelModal.childElements;

    // fat button
    const fatEventElements = document.querySelectorAll('.fb__fat__menu .fat__btn, .fb__fat__menu .menu__close');
    for(let fatEventElement of fatEventElements) {
        fatEventElement.addEventListener('click', function(e) {
            if(!data.isChrome) {
                alert('현재 FAT은 크롬 브라우저에서만 이용이 가능합니다.');

                return;
            }

            const parentElements = this.parentNode.closest('.fb__fat__menu');
            parentElements.classList.toggle('fb__fat__menu--show');
        });
    }

    // 설정 적용하기
    data.side.applyElement.addEventListener('click', function(e) {
        if(!fatFilters.side) return;
        try {
            requestCounting('counting', {path: data.pathname, pids: pids.values});
        }
        catch(ex) {
            fbLogger.error('fat', 'applyElement click exception', ex);
        }
    });

    sideMenuChildElements.excelDownloadButton.addEventListener('click', function(e) {
        openExcelModal();
    });

    excelModalChildElements.applyButton.addEventListener('click', async function(e) {
        try {
            this.disabled = true;
            await requestExcel('excel', {pids: 'all'});
        }
        catch(ex) {
            fbLogger.error('fat', 'downloadExcelPeriodButtonElement click exception', ex);
        }
        finally {
            this.disabled = false;
        }
    });

    // 종합분석
    sideMenuChildElements.comprehensiveAnalysisButton.addEventListener('click', async function(e) {
        openComprehensiveAnalysisModal();
    });

    comprehensiveAnalysisModalChildElements.orderOptionSelectElement.addEventListener('click', async function(e) {
        try {
            const filter = fatFilters.comprehensiveAnalysisModal;
            if(!checkDateFilter(filter, 'optionStartDate', 'optionEndDate', false)) return;
            if(!getComprehensiveAnalysisLastOrderOptionCategory(filter)) {
                alert('카테고리를 선택 해 주세요.');

                return;
            }

            this.disabled = true;
            await requestComprehensiveAnalysisModal('orderOption', {
                ptype: 'option'
            });
        }
        catch(ex) {
            fbLogger.error('fat', 'comprehensiveAnalysisOrderOptionSelectElement click exception', ex);
        }
        finally {
            this.disabled = false;
        }
    });

    // modal
    const statisticalAnalysisModalTabListElements = statisticalAnalysisModalChildElements.tabList;
    for(let statisticalAnalysisModalElement of statisticalAnalysisModalTabListElements) {
        statisticalAnalysisModalElement.addEventListener('click', function(e) {
            e.stopPropagation();

            const modalData = data.statisticalAnalysisModal;
            const modalTabs = modalData.tabs;
            let type = this.dataset.type;

            if(type == modalTabs.activeTab) return;

            const chartTitleElement = modalData.childElements.chartTitle;
            const chartElement = document.getElementById('fat__content__option__chart__wrapper');
            const orderTrackingCheckboxDetailStyle = modalData.childElements.orderTrackingCheckboxDetail.style;
            const tableElement = document.getElementById('fat__content__option__table');

            activeRadioButtonCSS(this.parentNode.closest('.tap'), 'tap__list--active', 'tap__list', this.dataset.activeType);
            clearGoogleChart('orderCountByPeriod');
            orderTrackingCheckboxDetailStyle.display = 'none';

            if(tableElement) tableElement.remove();
            switch(type) {
                case 'orderPattern':
                    type = 'orderPatternAge';

                    addStatisticalAnalysisModalFilter();
                    changeStatisticalAnalysisModalTabs('add', chartTitleElement, chartElement, '90px', 'block', 'hidden');
                    break;
                case 'orderTogether':
                    changeStatisticalAnalysisModalTabs('remove', chartTitleElement, chartElement, 'unset', 'none', 'auto');
                    break;
                case 'orderTracking':
                    orderTrackingCheckboxDetailStyle.display = 'block';
                default:
                    changeStatisticalAnalysisModalTabs('remove', chartTitleElement, chartElement, 'unset', 'block', 'hidden');
                    break;
            }

            modalTabs.activeTab = type;
            changeStatusStatisticalAnalysisSubChart('hide');
            requestStatisticalAnalysisModal(type);
        });
    }

    //
    document.addEventListener('click', function(e) {
        e.stopPropagation();

        const parentNode = e.target.parentNode;
        // 상품통계 modal open
        const countingElement = parentNode.closest('.fb__fat__counting');

        if(countingElement) {
            const goodsListElement = parentNode.closest('.fb__goods__list') || parentNode.closest('.fb__goods-view__photo');
            const isFat = 'true' == countingElement.dataset.fat ? true : false;
            const pid = countingElement.dataset.devFatId || null;
            const imageSrc = goodsListElement.querySelector('img') ? goodsListElement.querySelector('img').src : null;

            if(isFat && pid) {
                data.statisticalAnalysisModal.pid = pid;
                data.statisticalAnalysisModal.activeTab = 'orderByOption';

                openStatisticalAnalysisModal(imageSrc);
            }
            else {
                alert(data.message.noStatisticalData);
            }
        }

        // fat modal close
        if(e.target.classList.contains('fat__bg') || e.target.classList.contains('fat__close')) {
            if(parentNode.closest('.fb__fat')) closeStatisticalAnalysisModal();
            if(parentNode.closest('.fb__fat__syn')) closeComprehensiveAnalysisModal();
            if(parentNode.closest('#fb__fat__excel__wrapper')) closeExcelModal();
        }

        // new tab link...
        const newTabLinkElement = e.target.closest('.new__tab__link');
        if(newTabLinkElement) window.open(newTabLinkElement.dataset.link, '_blank');
    });
}

const externalElementAddEvents = () => {
    // TODO: 현재 사용 안함
    // devSortTab
    // fbFilters.external = new fbFilters([{
    // 	selector: {
    // 		id: 'devSortTab'
    // 	},
    // 	key: 'sort'
    // }], {
    // 	event: function(e, key, value) {
    // 		switch(key) {
    // 			case 'sort':
    // 				// common.ajaxManager.active();
    // 			break;
    // 		}
    // 	}
    // });
}

const changeStatisticalAnalysisModalTabs = (type, chartTitleElement, chartElement, marginTop, display, overflow) => {
    document.getElementById('fat__tab__filters__order__pattern__group').classList[type]('fat__fn__filter--show');

    chartTitleElement.style.marginTop = marginTop;
    chartTitleElement.style.display = display;
    chartElement.style.overflow = overflow;
}

const settingAppendScript = () => {
    return new Promise((resolve, reject) => {
            const scripts = ['https://www.gstatic.com/charts/loader.js'];
    let loadScriptCount = 0;

    for(let script of scripts) {
        let documentScript = document.createElement('script');

        documentScript.type = 'text/javascript';
        documentScript.src = script;
        documentScript.onerror = function() {reject('script load error...', script);};
        documentScript.onload = function() {
            loadScriptCount++;

            if(loadScriptCount == scripts.length) resolve();
        }
        document.head.appendChild(documentScript);
    }
});
};

const settingData = () => {
    data.isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    data.today = moment().format('YYYY-MM-DD');
    data.pathname = window.location.pathname;
}

const settingSideData = () => {
    const fatSideButtonElement = document.getElementById('fat__side__open__button');

    fatSideButtonElement.classList.remove('opacity--05');
    data.side.applyElement = document.getElementById('fat_filter_apply')
}

const settingModalData = () => {
    const sideData = data.side;
    const statisticalAnalysisModalData = data.statisticalAnalysisModal;
    const statisticalAnalysisModalChildElements = statisticalAnalysisModalData.childElements;
    const comprehensiveAnalysisModalData = data.comprehensiveAnalysisModal;
    const comprehensiveAnalysisModalChildElements = comprehensiveAnalysisModalData.childElements;
    const excelModalData = data.excelModal;

    //TODO: querySelectorAll -> getElementById로 바꿀 수 있는것은 바꿀 것
    // side menu
    sideData.childElements.comprehensiveAnalysisButton = document.getElementById('comprehensive_analysis_btn');
    sideData.childElements.excelDownloadButton = document.getElementById('download__excel__btn');

    // statistical analysis modal
    statisticalAnalysisModalData.rootElement = document.getElementById('fb__fat__wrapper');
    statisticalAnalysisModalChildElements.title = document.getElementById('fat__content__goods__title');
    statisticalAnalysisModalChildElements.thumbnail = document.getElementById('fat__content__goods__thumbnail');
    statisticalAnalysisModalChildElements.price = document.getElementById('fat__content__goods__price');
    statisticalAnalysisModalChildElements.tabList = statisticalAnalysisModalData.rootElement.getElementsByClassName('tap__list');
    statisticalAnalysisModalChildElements.chartTitle = document.getElementById('fat__content__option__chart__title');
    statisticalAnalysisModalChildElements.orderTrackingCheckboxDetail = document.getElementById('syn__content__order__tracking__type__area');

    // comprehensive analysis modal
    comprehensiveAnalysisModalData.rootElement = document.getElementById('fb__fat__syn__wrapper');
    comprehensiveAnalysisModalChildElements.orderOptionSelectElement = document.getElementById('syn__order__option__filter__select__button');
    comprehensiveAnalysisModalChildElements.todaySummary = document.getElementById('syn__today__summary__wrapper');
    comprehensiveAnalysisModalChildElements.todayTable = document.getElementById('syn__content__today__table__wrapper');
    comprehensiveAnalysisModalChildElements.categoriesArea = document.getElementById('syn__order__option__categories__area');
    comprehensiveAnalysisModalChildElements.optionResult = document.getElementById('syn__order__option__result__wrapper');
    comprehensiveAnalysisModalChildElements.orderTargetGoods = document.getElementById('syn__order__target__goods__wrapper');

    // excel modal
    excelModalData.rootElement = document.getElementById('fb__fat__excel__wrapper');
    excelModalData.childElements.applyButton = document.getElementById('download__excel__period__btn');
}

const settingFilters = () => {
    const fatFilterElements = {
        side: [{
            selector: {
                name: 'fat_side_filter_date'
            },
            key: 'period'
        }, {
            selector: {
                name: 'fat_menu_filter_view_counting'
            },
            key: 'isCounting'
        }, {
            selector: {
                id: 'fat_menu_filter_start_date'
            },
            key: 'startDate'
        }, {
            selector: {
                id: 'fat_menu_filter_end_date'
            },
            key: 'endDate'
        }, {
            selector: {
                name: 'fat_menu_filter_counting_screen'
            },
            key: 'countingScreen'
        }, {
            selector: {
                name: 'fat_menu_filter_counting_system'
            },
            key: 'countingSystem'
        }],
    };
    const fatFilterOptions = {
        side: {
            event: function(e, key, value) {
                switch(key) {
                    case 'startDate':
                    case 'endDate':
                        checkDateFilter(fatFilters.side, 'startDate', 'endDate', true);
                        break;
                    case 'period':
                        bindPeriod('side', value);
                        break;
                }
            }
        },
    };

    fatFilters.side = new fbFilters(fatFilterElements.side, fatFilterOptions.side);
    bindStorageSettings();
}

const bindPeriod = (filterType, standardStartDate, startDateProperty, endDateProperty) => {
    const filters = fatFilters[filterType].getFilters();
    const startDate = moment().subtract(getDateDiff(standardStartDate), 'days').format('YYYY-MM-DD');
    const endDate = data.today;

    if(filters.startDate === startDate && filters.endDate === endDate) return;

    fatFilters[filterType].setValue(startDateProperty || 'startDate', startDate);
    fatFilters[filterType].setValue(endDateProperty || 'endDate', endDate);
}

const bindStorageSettings = () => {
    // TODO: 새로고침 시 설정내역을 초기화 하려면 주석 해제
    // if(1 == performance.navigation.type) window.localStorage.clear();

    const filter = fatFilters.side;
    let fatSideSettings = getLocalStorageItem('fat-side-settings');
    fatSideSettings = fatSideSettings ? JSON.parse(fatSideSettings) : null;

    if(fatSideSettings) {
        Object.keys(fatSideSettings).forEach((key) => {
            const value = fatSideSettings[key];

        filter.setValue(key, value);
    });
    }
    else {
        filter.setValue('startDate', data.today);
        filter.setValue('endDate', data.today);
    }

    data.side.filter = filter.getFilters();
}

const settingCalendar = () => {
    const inputDateElements = document.querySelectorAll('.fb__fat__menu input[type="date"], .fb__fat input[type="date"]');

    for(let inputDateElement of inputDateElements) {
        inputDateElement.max = data.today;
    }
}

const settingCharts = () => {
    google.charts.load('current', {'packages': ['line', 'corechart', 'bar']});

    const barChart = googleCharts.bar;
    const lineChart = googleCharts.line;
    const columnChart = googleCharts.column;
    const pipeChart = googleCharts.pipe;
    const comboChart = googleCharts.combo;

    // chart option settings
    barChart.options = {
        chartArea: {
            left: 44,
            top: 0,
            width: "94%",
            height: "90%"
        },
        width: 880,
        height: 290,
        bar: {
            groupWidth: "35%"
        },
        legend: {
            position: "none"
        },
        axes: {
            y: {
                0: {
                    side: 'left'
                }
            }
        },
        animation: {
            duration: 1000,
            easing: 'out',
            startup: true
        },
        backgroundColor: {
            fill: '#1d2127'
        },
        vAxis: {
            textStyle: {
                color: '#9b9da3',
                fontSize: 14,
            }
        },
        hAxis: {
            baselineColor: "#444851",
            textStyle: {
                color: '#9b9da3',
                fontSize: 14,
                //bold: true
            },
            gridlines: {
                color: '#444851',
            }
        }
    };

    lineChart.options = {
        width: 880,
        height: 290,
        chartArea: {left: 50, right: 80, width: 750},
        color: ["red", "green"],
        animation: {
            duration: 1000,
            easing: 'out',
            startup: true
        },
        backgroundColor: {fill: '#1d2127'},
        legend: {position: "top", textStyle: {color: '#9b9da3', fontSize: 14}},
        series: {
            0: {
                axis: 'Temps',
                targetAxisIndex: 0,
                color: '#512ccb'
            },
            1: {

                axis: 'Daylight',
                targetAxisIndex: 1,
                color: '#3962e6'
            },
        },
        axes: {
            y: {
                Temps: {label: 'Temps (Celsius)'},
                Daylight: {label: 'Daylight'}
            }
        },
        vAxis: {
            textStyle: {
                color: '#9b9da3',
                fontSize: 14,
            },
            gridlines: {
                color: '#2d3136',
            }
        },
        hAxis: {
            baselineColor: "#444851",
            textStyle: {
                color: '#9b9da3',
                fontSize: 14,
            },
            gridlines: {
                color: '#444851',
            }
        },
        hAxis: {
            baselineColor: "red",
            textStyle: {
                color: '#9b9da3',
                fontSize: 14,
            },
            gridlines: {
                color: 'transparent',
            }
        }
    };

    columnChart.options = {
        width: 880,
        height: 290,
        chartArea: {left: 40, top: 45, width: "92%", height: "65%"},
        isStacked: true,
        legend: {position: "top", textStyle: {color: '#9b9da3', fontSize: 14}},
        animation: {
            duration: 1000,
            easing: 'out',
            startup: true
        },
        series: {
            0: {color: '#512ccb'},
            1: {color: '#3962e6'},
            2: {color: '#1fafeb'},
        },
        bar: {groupWidth: "35%"},
        vAxis: {
            textStyle: {
                color: '#9b9da3',
                fontSize: 14,
            },
            gridlines: {
                color: '#2d3136',
            }
        },
        backgroundColor: {fill: '#1d2127'},
        hAxis: {
            baselineColor: "#444851",
            textStyle: {
                color: '#9b9da3',
                fontSize: 14,
            },
            gridlines: {
                color: '#444851',
            }
        },
        hAxis: {
            baselineColor: "red",
            textStyle: {
                color: '#9b9da3',
                fontSize: 14,
            },
            gridlines: {
                color: 'blue',
            }
        }
    };

    pipeChart.options = {
        width: 880,
        height: 290,
        backgroundColor: {
            fill: '#1d2127'
        },
        pieSliceTextStyle: {
            color: '#fff',
        },
        legend: {
            textStyle: {
                color: '#fff'
            },
            pagingTextStyle: {
                color: '#9b9da3'
            },
            scrollArrows: {
                inactiveColor: '#9b9da3',
                activeColor: '#9b9da3'
            }
        },
        pieSliceBorderColor: 'none'
    };

    comboChart.options = {
        seriesType: 'bars',
        series: {1: {type: 'line'}},
        chartArea: {
            left: 40,
            right: 40,
            width: '100%',
        },
        width: 880,
        height: 290,
        legend: {position: "top", textStyle: {color: '#9b9da3', fontSize: 14}},
        animation: {
            duration: 1000,
            easing: 'out',
            startup: true
        },
        backgroundColor: {
            fill: '#1d2127'
        },
        vAxis: {
            textStyle: {
                color: '#9b9da3',
                fontSize: 14,
            },
            gridlines: {
                color: '#2d3136',
            },
        },
        hAxis: {
            baselineColor: "#444851",
            textStyle: {
                color: '#9b9da3',
                fontSize: 14,
            },
            gridlines: {
                color: '#444851',
            },
        },
        colors : ['#512ccb','#3962e6']
    };
}

const watchPidElements = () => {
    return new Promise((resolve, reject) => {
            const watch = setInterval(() => {
                    if(setPids()) {
        requestCounting('counting', {path: data.pathname, pids: pids.values});
        clearInterval(watch);
        resolve();
    }
}, 1000);
})
}

const initialization = () => {
    window.addEventListener('load', async function(e) {
        // devSortTab
        await settingAppendScript();
        settingData();
        settingSideData();
        settingModalData();
        settingFilters();
        settingCharts();
        settingCalendar();
        addEvents();
        externalElementAddEvents();
        if(!data.isChrome) return;
        await watchPidElements();
        data.isLoaded = true;
    });
}

const fat = () => {
    try {
        if(!isUseFat) return;

        try {
            initialization();
        }
        catch(ex) {
            fbLogger.error('fat', 'fat initialization', ex);
        }

        return {
                initStat: () => {
                fbLogger.log('fat', 'initStat');

        try {
            if(!data.isLoaded || !data.isChrome) return;

            resetSideMenuParameters();
            setPids();
            requestCounting('counting', {path: data.pathname, pids: pids.values});
        }
        catch(ex) {
            fbLogger.error('fat', 'initStat exception', ex);
        }
    }
    }
    }
    catch(ex) {
        fbLogger.error('fat', 'fat initialization exception', ex);
    }
}

export default fat;