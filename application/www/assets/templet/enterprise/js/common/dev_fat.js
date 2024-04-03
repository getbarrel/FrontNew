
const dev_fat = {
    $document: $(document),
    sDate: '2018-01-01',
	eDate: '2019-12-31',
	pid: false,
	statType: 'total',
	countingScreen: 'all',
    chart: {
        fat_chart_option: false,
        fat_chart_an: false,
        fat_chart_order: false
    },
    chartData: {
        fat_chart_option: {},
        fat_chart_an: {},
        fat_chart_order: {}
    },
    fat_chart_an: function () {
        var self = dev_fat;
        var options = {
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
        var drawChart = function (chartData) {
            if (self.chart.fat_chart_an === false) {
                self.chart.fat_chart_an = new google.visualization.ColumnChart(document.getElementById('option'));
            } else {
                self.chart.fat_chart_an.clearChart();
            }

            self.chart.fat_chart_an.draw(google.visualization.arrayToDataTable(chartData), options);

//            self.$document
//                    .on("click", "a[class^=filter__btn--]", function () {
//                        const $this = $(this);
//                        const _test = $this.attr("data-test");
//                        $this.parent().find("a").removeClass("filter__btn--active");
//                        $this.addClass("filter__btn--active test");
//                        if (_test == 0) {
//                            var data = google.visualization.arrayToDataTable([
//                                ['', '여성', '남성', '알수없음'],
//                                ['2011/09/27', 30, 54, 20],
//                                ['2010', 46, 22, ''],
//                            ]);
//                        } else {
//                            var data = google.visualization.arrayToDataTable([
//                                ['', '여성', '남성', '알수없음'],
//                                ['2013/09/27', 5, 24, 20],
//                                ['2022', 36, 22, ''],
//                            ]);
//                        }
//                        var chart = new google.visualization.ColumnChart(document.getElementById('option'));
//                        chart.draw(data, options);
//                        return false;
//                    })
//                    .on("click", ".fat__fn__filter a", function () {
//                        alert("Test");
//                        return false;
//                    });
        };
        var dataSet = function (data, idx) {
            var row = [];
            row.push(data.label);
            row.push(parseInt(data.W)); // 여성
            row.push(parseInt(data.M)); // 남성
            row.push(parseInt(data.N)); // 알수없음

            return row;
        };


        $(".fat__option__title")
                .html("성별 + 연령대별 구매")
                .css("margin-top", "90px");
        $(".fat__fn__filter").addClass("fat__fn__filter--show");

        // 차트그리기
        google.charts.setOnLoadCallback(function () {
            self.drawApiChart('fat_chart_an', dataSet, drawChart);
        });

    },
    fat_chart_order: function () {
        var self = dev_fat;
        var options = {
            width: 880,
            height: 290,
            chartArea: {left: 40, top: 45, width: "92%", height: "75%"},
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
        var drawChart = function (chartData) {
            console.log(chartData);
            var data = google.visualization.arrayToDataTable(chartData);

            if (self.chart.fat_chart_order === false) {
                self.chart.fat_chart_order = new google.visualization.LineChart(document.getElementById("option"));
            } else {
                self.chart.fat_chart_order.clearChart();
            }
            self.chart.fat_chart_order.draw(data, options);

//            self.$document
//                    .on("click", "a[class^=filter__btn--]", function () {
//                        const $this = $(this);
//                        const _test = $this.attr("data-test");
//                        $this.parent().find("a").removeClass("filter__btn--active");
//                        $this.addClass("filter__btn--active test");
//                        if (_test == 0) {
//                            var data = new google.visualization.DataTable();
//                            data.addColumn('date', 'Month');
//                            data.addColumn('number', "주문(전체)");
//                            data.addColumn('number', "조회(전체)");
//                            data.addRows([
//                                [new Date(2015, 0), -.5, 5.7],
//                                [new Date(2015, 1), .4, 8.7],
//                                [new Date(2015, 2), .5, 12],
//                                [new Date(2015, 3), 2.9, 15.3],
//                                [new Date(2015, 4), 6.3, -2.6],
//                                [new Date(2015, 5), 9, 20.9],
//                                [new Date(2015, 6), 10.6, 19.8],
//                                [new Date(2015, 7), 10.3, 16.6],
//                                [new Date(2015, 8), 7.4, 13.3],
//                                [new Date(2015, 9), 4.4, 9.9],
//                                [new Date(2015, 10), 1.1, 6.6],
//                                [new Date(2015, 11), -.2, 40.5]
//                            ]);
//                        } else {
//                            var data = new google.visualization.DataTable();
//                            data.addColumn('date', 'Month');
//                            data.addColumn('number', "주문(전체)");
//                            data.addColumn('number', "조회(전체)");
//                            data.addRows([
//                                [new Date(2016, 0), -.5, 5.7],
//                                [new Date(2016, 1), .4, 8.7],
//                                [new Date(2016, 2), .5, 12],
//                                [new Date(2016, 3), 2.9, 15.3],
//                                [new Date(2016, 4), 6.3, -2.6],
//                                [new Date(2016, 5), 9, 20.9],
//                                [new Date(2016, 6), 10.6, 19.8],
//                                [new Date(2016, 7), 10.3, 16.6],
//                            ]);
//                        }
//                        var materialChart = new google.visualization.LineChart(chartDiv);
//                        materialChart.draw(data, materialOptions);
//                        return false;
//                    });
        };
        var dataSet = function (data, idx) {
            var row = [];

            console.log(data);
            row.push(data.date); // 일시
            row.push(parseInt(data.order)); // 주문
            row.push(parseInt(data.view)); // 조회

            return row;
        }

        $(".fat__option__title")
                .html("주문/조회 분석")
                .css("margin-top", "");
        $(".fat__fn__filter").removeClass("fat__fn__filter--show");

        google.charts.setOnLoadCallback(function () {
            self.drawApiChart('fat_chart_order', dataSet, drawChart);
        });
    },
    fat_chart_option: function () {
        var self = dev_fat;
        var options = {
            chartArea: {left: 44, top: 0, width: "94%", height: "90%"},
            width: 880,
            height: 290,
            bar: {groupWidth: "35%"},
            legend: {position: "none"},
            axes: {
                y: {
                    0: {side: 'left'}
                }
            },
            animation: {
                duration: 1000,
                easing: 'out',
                startup: true
            },
            backgroundColor: {fill: '#1d2127'},
            vAxis: {
                //title: 'Temperature',
                textStyle: {
                    color: '#9b9da3',
                    fontSize: 14,
                    //bold: true
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
        var drawChart = function (chartData) {
            var data = google.visualization.arrayToDataTable(chartData);

            if (self.chart.fat_chart_option === false) {
                self.chart.fat_chart_option = new google.visualization.BarChart(document.getElementById("option"));
            } else {
                self.chart.fat_chart_option.clearChart();
            }
            self.chart.fat_chart_option.draw(data, options);

//                        self.$document.on("click", "a[class^=filter__btn--]", function () {
//                            const $this = $(this);
//                            const _test = $this.attr("data-test");
//                            $this.parent().find("a").removeClass("filter__btn--active");
//                            $this.addClass("filter__btn--active test");
//                            if (_test == 0) {
//                                data = google.visualization.arrayToDataTable([
//                                    ["Element", "Density", {role: "style"}],
//                                    ["L", 10, "#5077e1"],
//                                    ["M", 60, "#1fafeb"],
//                                    ["S", 40, "#63cbf7"],
//                                    ['XS', 52, "#1fafeb"],
//                                ]);
//                            } else {
//                                data = google.visualization.arrayToDataTable([
//                                    ["Element", "Density", {role: "style"}],
//                                    ["L", 20, "#5077e1"],
//                                    ["M", 10, "#1fafeb"],
//                                    ["S", 40, "#63cbf7"],
//                                    ['XS', 12, "#1fafeb"],
//                                ]);
//                            }
//                            var chart = new google.visualization.BarChart(document.getElementById("option"));
//                            chart.draw(data, options);
//                        });
        };
        var dataSet = function (data, idx) {
            var row = [];
            row.push(data.option_text); // 옵션명
            row.push(parseInt(data.cnt)); // 수량
            row.push(((parseInt(idx) + 1) % 2 == 0 ? "#1fafeb" : "#5077e1")); // 색상

            return row;
        }

        $(".fat__option__title")
                .html("옵션항목")
                .css("margin-top", "");
        $(".fat__fn__filter").removeClass("fat__fn__filter--show");

        // 차트 그리기
        google.charts.setOnLoadCallback(function () {
            self.drawApiChart('fat_chart_option', dataSet, drawChart);
        });

        return false;

    },

    fat_syn_today: function () {
        var self = dev_fat;
        google.charts.setOnLoadCallback(function () {
            var data = google.visualization.arrayToDataTable([
                ['', '주문(전체)', '조회(전체)'],
                ['00', 120, 224],
                ['02', 16, 22],
                ['03', 16, 22],
                ['04', 16, 22],
                ['05', 16, 22],
                ['06', 16, 22],
                ['07', 16, 22],
                ['08', 16, 22],
                ['09', 16, 22],
                ['10', 16, 22],
                ['11', 16, 22],
                ['12', 16, 22],
                ['13', 16, 22],
                ['14', 16, 22],
                ['15', 16, 22],
                ['16', 16, 22],
                ['17', 16, 22],
                ['18', 16, 22],
                ['19', 16, 22],
                ['20', 16, 22],
                ['21', 16, 22],
                ['22', 16, 22],
                ['23', 160, 521]
            ]);

            var options = {
                width: 880,
                height: 440,
                chartArea: {left: 40, top: 45, width: "92%", height: "80%"},
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
                },
                //bar: {groupWidth: "35%"},
                vAxis: {
                    //title: 'Temperature',
                    textStyle: {
                        color: '#9b9da3',
                        fontSize: 14,
                        //bold: true
                    },
                    // gridlines: {
                    //     count: 12
                    // },
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
                        //bold: true
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
                        //bold: true
                    },
                    gridlines: {
                        color: 'blue',
                    }
                }
            };


            var chart = new google.visualization.ColumnChart(document.getElementById('syn__toady'));
            chart.draw(data, options);
        });
    },
    fat_syn_order: function (data = []) {
        var self = dev_fat;
        google.charts.setOnLoadCallback(function () {
            var data = google.visualization.arrayToDataTable([
                ['', '주문(전체)', '조회(전체)', '알수없음'],
                ['10대', 120, 224, 0],
                ['20대', 16, 22, ''],
                ['30대', 16, 22, 100],
                ['40대', 16, 22, ''],
                ['50대', 16, 22, 20],
                ['60대', 16, 22, ''],
                ['연령 알수없음', '', '', 160]
            ]);

            var options = {
                width: 880,
                height: 440,
                chartArea: {left: 40, top: 45, width: "92%", height: "80%"},
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
                //bar: {groupWidth: "35%"},
                vAxis: {
                    //title: 'Temperature',
                    textStyle: {
                        color: '#9b9da3',
                        fontSize: 14,
                        //bold: true
                    },
                    // gridlines: {
                    //     count: 12
                    // },
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
                        //bold: true
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
                        //bold: true
                    },
                    gridlines: {
                        color: 'blue',
                    }
                }
            };


            var chart = new google.visualization.ColumnChart(document.getElementById('order_chart'));
            chart.draw(data, options);
        });
    },
    fat_syn_sex: function () {
        var self = dev_fat;
        google.charts.setOnLoadCallback(function () {

            var data = google.visualization.arrayToDataTable([
                ['', ''],
                ['여성', 11],
                ['남성', 2],
                ['알수없음', 2],
            ]);

            var options = {
                width: 880,
                height: 440,
                backgroundColor: {fill: '#1d2127'},
                legend: {position: "top", textStyle: {color: '#9b9da3', fontSize: 14}},
                chartArea: {left: 40, top: 45, width: "92%", height: "80%"},
                animation: {
                    duration: 1000,
                    easing: 'out',
                    startup: true
                },
                slices: {
                    0: {color: '#512ccb'},
                    1: {color: '#3962e6'},
                    2: {color: '#1fafeb'},
                },
                pieSliceBorderColor: '#1d2127',
            };

            var chart = new google.visualization.PieChart(document.getElementById('order_chart'));

            chart.draw(data, options);
        });
    },
    fat_syn_old: function () {
        var self = dev_fat;
        google.charts.setOnLoadCallback(function () {
            var data = google.visualization.arrayToDataTable([
                ["Element", "Density", {role: "style"}],
                ["알수없음", 40, "#5077e1"],
                ["10대", 60, "#1fafeb"],
                ["20대", 30, "#63cbf7"],
                ['30대', 12, "#1fafeb"],
                ["40대", 40, "#5077e1"],
                ["50대", 60, "#1fafeb"],
                ["60대", 30, "#63cbf7"],
            ]);

            //var view = new google.visualization.DataView(data);

            // var view = new google.visualization.DataView(data);
            // view.setColumns([0, 1,
            //     { calc: "stringify",
            //         sourceColumn: 1,
            //         type: "string",
            //         role: "annotation" },
            //     2]);


            var options = {
                //title: "Density of Precious Metals, in g/cm^3",
                chartArea: {left: 64, top: 0, width: "90%", height: "90%"},
                width: 880,
                height: 440,
                bar: {groupWidth: "35%"},
                legend: {position: "none"},
                axes: {
                    y: {
                        0: {side: 'left'}
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'out',
                    startup: true
                },
                backgroundColor: {fill: '#1d2127'},
                vAxis: {
                    //title: 'Temperature',
                    textStyle: {
                        color: '#9b9da3',
                        fontSize: 14,
                        //bold: true
                    },
                    // gridlines: {
                    //     count: 12
                    // }
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

            var chart = new google.visualization.BarChart(document.getElementById("order_chart"));
            chart.draw(data, options);
        });
    },
    fat_syn_week: function () {
        var self = dev_fat;
        var options = {
            width: 880,
            height: 440,
            chartArea: {left: 40, top: 45, width: "92%", height: "80%"},
            isStacked: true,
            legend: {position: "none", textStyle: {color: '#9b9da3', fontSize: 14}},
            animation: {
                duration: 1000,
                easing: 'out',
                startup: true
            },
            series: {
                0: {color: '#512ccb'},
            },
            vAxis: {
                textStyle: {
                    color: '#9b9da3',
                    fontSize: 14
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
                    fontSize: 14
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
                    //bold: true
                },
                gridlines: {
                    color: 'blue',
                }
            }
        };

        google.charts.setOnLoadCallback(function () {
            var data = google.visualization.arrayToDataTable([
                ['', '주문(전체)'],
                ['일요일', 120],
                ['월요일', 16],
                ['화요일', 16],
                ['수요일', 16],
                ['목요일', 16],
                ['금요일', 16],
                ['토요일', 100]
            ]);


            var chart = new google.visualization.ColumnChart(document.getElementById('order_chart'));
            chart.draw(data, options);
        });

        return false;
    },
    fat_syn_time: function () {
        var self = dev_fat;
        google.charts.setOnLoadCallback(function () {
            var data = google.visualization.arrayToDataTable([
                ['', '주문(전체)'],
                ['00', 120],
                ['02', 16],
                ['03', 16],
                ['04', 16],
                ['05', 16],
                ['06', 16],
                ['07', 16],
                ['08', 16],
                ['09', 16],
                ['10', 16],
                ['11', 16],
                ['12', 16],
                ['13', 16],
                ['14', 16],
                ['15', 16],
                ['16', 16],
                ['17', 16],
                ['18', 16],
                ['19', 16],
                ['20', 16],
                ['21', 16],
                ['22', 16],
                ['23', 160]
            ]);

            var options = {
                width: 880,
                height: 440,
                chartArea: {left: 40, top: 45, width: "92%", height: "80%"},
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
                },
                //bar: {groupWidth: "35%"},
                vAxis: {
                    //title: 'Temperature',
                    textStyle: {
                        color: '#9b9da3',
                        fontSize: 14,
                        //bold: true
                    },
                    // gridlines: {
                    //     count: 12
                    // },
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
                        //bold: true
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
                        //bold: true
                    },
                    gridlines: {
                        color: 'blue',
                    }
                }
            };


            var chart = new google.visualization.ColumnChart(document.getElementById('order_chart'));
            chart.draw(data, options);
        });
    },
    fat_syn_pay: function () {
        var self = dev_fat;
        google.charts.setOnLoadCallback(function () {

            var data = google.visualization.arrayToDataTable([
                ['', ''],
                ['신용카드', 11],
                ['실시간계좌이체', 2],
                ['가상계좌', 2],
                ['페이코', 2],
            ]);

            var options = {
                width: 880,
                height: 440,
                backgroundColor: {fill: '#1d2127'},
                legend: {position: "top", textStyle: {color: '#9b9da3', fontSize: 14}},
                chartArea: {left: 40, top: 45, width: "92%", height: "80%"},
                animation: {
                    duration: 1000,
                    easing: 'out',
                    startup: true
                },
                slices: {
                    0: {color: '#512ccb'},
                    1: {color: '#3962e6'},
                    2: {color: '#c6c6dd'},
                    3: {color: '#5ce2eb'},
                },
                pieSliceBorderColor: '#1d2127',
            };

            var chart = new google.visualization.PieChart(document.getElementById('order_chart'));

            chart.draw(data, options);
        });
    },
    fat_syn_divice: function () {
        var self = dev_fat;
        google.charts.setOnLoadCallback(function () {

            var data = google.visualization.arrayToDataTable([
                ['', ''],
                ['PC', 11],
                ['MOBILE', 2],
            ]);

            var options = {
                width: 880,
                height: 440,
                backgroundColor: {fill: '#1d2127'},
                legend: {position: "top", textStyle: {color: '#9b9da3', fontSize: 14}},
                chartArea: {left: 40, top: 45, width: "92%", height: "80%"},
                animation: {
                    duration: 1000,
                    easing: 'out',
                    startup: true
                },
                slices: {
                    0: {color: '#512ccb'},
                    1: {color: '#3962e6'},
                },
                pieSliceBorderColor: '#1d2127',
            };

            var chart = new google.visualization.PieChart(document.getElementById('order_chart'));

            chart.draw(data, options);
        });
    },
    fat_syn_part: function () {
        var self = dev_fat;
        google.charts.setOnLoadCallback(function () {

            var data = google.visualization.arrayToDataTable([
                ['', ''],
                ['PC', 11],
                ['MOBILE', 2],
            ]);

            var options = {
                width: 880,
                height: 230,
                backgroundColor: {fill: '#1d2127'},
                legend: {position: "top", textStyle: {color: '#9b9da3', fontSize: 14}},
                chartArea: {left: 0, top: 45, width: "92%", height: "80%"},
                animation: {
                    duration: 1000,
                    easing: 'out',
                    startup: true
                },
                slices: {
                    0: {color: '#512ccb'},
                    1: {color: '#3962e6'},
                },
                pieSliceBorderColor: '#1d2127',
            };

            var chart = new google.visualization.PieChart(document.getElementById('order_option'));

            chart.draw(data, options);
        });
    },

    fat_chart_date: function () {
        var self = dev_fat;
        $("#fat_day_start").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            onClose: function (selectedDate) {
                $("#fat_day_end").datepicker("option", "minDate", selectedDate);
            },
            onSelect: function (dateText, inst) {  //날짜 범위 한달까지만 가능하도록
                var stDate = dateText.split("-");
                var dt = new Date(stDate[0], stDate[1], stDate[2]);
                var year = dt.getFullYear(); // 년도 구하기
                var month = dt.getMonth() + 1; // 한달뒤의 달 구하기
                var month = month + ""; // 문자형태
                if (month.length == "1")
                    var month = "0" + month; // 두자리 정수형태
                var day = dt.getDate();
                var day = day + "";
                if (day.length == "1")
                    var day = "0" + day;

                var nextMonth = year + "-" + month + "-" + day;
                $("#fat_day_end").datepicker("option", "maxDate", nextMonth);
                $("#fat_day_end").datepicker('setDate', nextMonth);
            }
        });
        $("#fat_day_end").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            minDate: 'today',
            maxDate: "+1m",
        });
        $("#fat_day_start").datepicker('setDate', 'today');
        $("#fat_day_end").datepicker('setDate', '+1m');
    },
    fat_modal: function (callback) {
        const $target = $(".fb__fat");
        $target.addClass("fb__fat--show");
        return callback();
    },
    fat_excel_date: function () {
        var self = dev_fat;
        $("#fat_excelDay_start").datepicker({
            dateFormat: 'yy-mm-dd',
        }).datepicker("setDate", new Date());

        $("#fat_excelDay_end").datepicker({
            dateFormat: 'yy-mm-dd',
        }).datepicker("setDate", new Date());

    },
    fat_syn_modal: function (callback) {
        var self = dev_fat;
        const $target = $(".fb__fat__syn");
        $target.addClass("fb__fat__syn--show");
        return  callback();
    },
    fat_chart_init: function () {
        var self = dev_fat;
        self.fat_chart_option();
        self.fat_chart_date();
    },

    drawApiChart(apiType, makeRowFunc, drawChartFunc) {
        var self = dev_fat;
        var api = {
            fat_chart_option: {url: common.util.getControllerUrl('getOrderOption', 'fat'), title: ["옵션명", "수량", {role: "style"}]},
            fat_chart_an: {url: common.util.getControllerUrl('getOrderAge', 'fat'), title: ['', '여성', '남성', '알수없음']},
            fat_chart_order: {url: common.util.getControllerUrl('getOrderAndView', 'fat'), title: ['Date', '주문(전체)', '조회(전체)']}
        };

        if (apiType in api) {
            if (self.pid in self.chartData[apiType]) {
                console.log('cache');
                drawChartFunc(self.chartData[apiType][self.pid]);
            } else {
                common.ajaxManager.deActive().ajax(
                        api[apiType].url,
                        {sDate: self.sDate, eDate: self.eDate, pid: self.pid},
                        true,
                        function (res) {
                            var chartData = [];

                            chartData.push(api[apiType].title);

                            if (res.result == 'success' && res.data.length > 0) {
                                for (var i in res.data) {
                                    chartData.push(makeRowFunc(res.data[i], i));
                                }

                                self.chartData[apiType][self.pid] = chartData;
                            }

                            drawChartFunc(chartData);
                        }
                );
            }
        } else {
            console.log('Not define api : ' + apiType);
        }
    },

    fatSplitTpl: false,
	fatTotalTpl: false,
	
    initFatTpl: function () {
        var self = dev_fat;

        if (self.fatSplitTpl === false) {
            var html = [];

            html.push('<a href="#" data-fat="true" class="fb__fat__btn devFatStatWin" data-dev-fat-id="{[pid]}">');
            html.push('    <div class="fb__fat__btn__content">');
            html.push('        <div class="btn__content">');
            html.push('            <span class="btn__content__header">');
            html.push('                <span>PC</span>');
            html.push('                <span>MOBILE</span>');
            html.push('            </span>');
            html.push('            <ul>');
            html.push('                <li class="btn__content__order">');
            html.push('                    <span>{[wOrder]}</span>');
            html.push('                    <span>{[mOrder]}</span>');
            html.push('                </li>');
            html.push('                <li class="btn__content__search">');
            html.push('                    <span>{[wView]}</span>');
            html.push('                    <span>{[mView]}</span>');
            html.push('                </li>');
            html.push('                <li class="btn__content__persent">');
            html.push('                    <span>{[wRate]}</span>');
            html.push('                    <span>{[mRate]}</span>');
            html.push('                </li>');
            html.push('            </ul>');
            html.push('        </div>');
            html.push('    </div>');
            html.push('    <span class="fb__fat__btn__bg"></span>');
            html.push('</a>');

            self.fatSplitTpl = Handlebars.compile(html.join(''));
        }

        if (self.fatTotalTpl === false) {
            var html = [];

            html.push('<a href="#" data-fat="true" class="fb__fat__btn devFatStatWin" data-dev-fat-id="{[pid]}">');
            html.push('    <div class="fb__fat__btn__content">');
            html.push('        <div class="btn__content">');
            html.push('            <ul>');
            html.push('                <li class="btn__content__order">');
            html.push('                    <span>{[tOrder]}</span>');
            html.push('                </li>');
            html.push('                <li class="btn__content__search">');
            html.push('                    <span>{[tView]}</span>');
            html.push('                </li>');
            html.push('                <li class="btn__content__persent">');
            html.push('                    <span>{[tRate]}</span>');
            html.push('                </li>');
            html.push('            </ul>');
            html.push('        </div>');
            html.push('    </div>');
            html.push('    <span class="fb__fat__btn__bg"></span>');
            html.push('</a>');

            self.fatTotalTpl = Handlebars.compile(html.join(''));
        }
    },
    initStat: function () {
        var self = dev_fat;

        var pids = [];
        var $dataFatid = $('[data-fatid]');

        $dataFatid.each(function () {
            var pid = $(this).data('fatid');

            if (pid) {
				console.log('set piddd : ', pid);
                pids.push(pid);
            }
        });

        if (pids.length > 0) {
            common.ajax(
                    common.util.getControllerUrl('statProductList', 'fat'),
                    {pids: pids, sDate: self.sDate, eDate: self.eDate },
                    function () {
                        return true;
                    },
                    function (res) {
						$('.devFatStatWin').remove();
                        $dataFatid.each(function () {
                            var pid = $(this).data('fatid');
                            if (typeof res.data[pid] !== 'undefined') {
                                if (self.statType == 'total') {
                                    $(this).after(self.fatTotalTpl(res.data[pid]));
                                } else {
                                    $(this).after(self.fatSplitTpl(res.data[pid]));
                                }
                            }
                        });
                    }
            );
        }
    },
    initChart: function () {
        // google.charts.load('current', {'packages': ['line', 'corechart', 'bar']});
    },
    initEvent: function () {
        var self = dev_fat;

        self.$document
                .on("click", ".fb__fat .tap__list", function () {

					return;
                    const $this = $(this);
                    const _type = $this.attr("data-type");
                    $(".fb__fat .tap__list").removeClass("tap__list--active");
                    $this.addClass("tap__list--active");


                    if (_type == "option") {
                        self.fat_chart_option();
                    } else if (_type == "order") {
                        self.fat_chart_order();
                    } else if (_type == "an") {
                        self.fat_chart_an();
                    } else {

                    }
                    return false;
                })
                .on("click", "[data-fat]", function () {

					return;
					
                    // 대시보드 이벤트
                    const $this = $(this);
                    const _ckeack = $this.attr("data-fat") == "true" ? true : false;

					self.pid = $(this).data('devFatId');


                    if (_ckeack) {
                        self.fat_modal(self.fat_chart_init);
                    }
                    ;

                    return false;
                })
                .on("click", ".fb__fat .fat__close, .fb__fat .fat__bg", function () {
                    $(".fb__fat .tap__list").removeClass("tap__list--active").eq(0).addClass("tap__list--active");
//                    self.fat_modal(self.fat_chart_init);
                    $(".fb__fat").removeClass("fb__fat--show");
                    return false;
                })
                .on("click", ".fb__fat__menu .fat__btn, .fb__fat__menu .menu__close", function () {
                    $(".fb__fat__menu").toggleClass("fb__fat__menu--show");
                    return false;
                })
                .on("click", ".fb__fat__menu .menu__order .excel", function () {
                    $(".fb__fat__excel").toggleClass("fb__fat__excel--show");
                    fat_excel_date();
                    return false;
                })
                .on("click", ".fb__fat__menu .menu__order .menu__order__all", function () {
                    fat_syn_modal(fat_syn_today);
                    return false;
                })
                .on("click", ".fb__fat__excel .fat__close, .fb__fat__excel .fat__bg", function () {
                    $(".fb__fat__excel").removeClass("fb__fat__excel--show");
                    return false;
                })
                .on("click", ".fb__fat__syn  .syn__nav a", function () {
                    const $this = $(this);
                    $(".fb__fat__syn  .syn__nav a").removeClass("syn__nav--active");
                    $this.addClass("syn__nav--active");

                    $(".syn__option").removeClass("syn__option--show");
                    $(`.${$this.attr("data-target")}`).addClass("syn__option--show");

                    if ($this.attr("data-target") == "syn__option__today") {
                        fat_syn_today();
                    } else if ($this.attr("data-target") == "syn__option__order") {
                        fat_syn_order();
                    } else {
                        fat_syn_part();
                    }

                    return false;
                })
                .on("click", ".fb__fat__syn  .fat__close, .fb__fat__syn  .fat__bg", function () {
                    $(".fb__fat__syn ").removeClass("fb__fat__syn--show");
                    return false;
                })
                .on("click", ".fb__fat__syn .syn__order__filter a", function () {
                    const $this = $(this);
                                console.log($this);

                    $(".fb__fat__syn .syn__order__filter a").removeClass("syn__order__filter--active");
                    $this.addClass("syn__order__filter--active");
                    if ($this.attr("data-type") == "sexOld") {
                        dev_fat.fat_syn_order();
                    } else if ($this.attr("data-type") == "sex") {
                        dev_fat.fat_syn_sex();
                    } else if ($this.attr("data-type") == "old") {
                        dev_fat.fat_syn_old();
                    } else if ($this.attr("data-type") == "week") {
                        dev_fat.fat_syn_week();
                    } else if ($this.attr("data-type") == "time") {
                        dev_fat.fat_syn_time();
                    } else if ($this.attr("data-type") == "pay") {
                        dev_fat.fat_syn_pay();
                    } else if ($this.attr("data-type") == "divice") {
                        dev_fat.fat_syn_divice();
                    }
                    return false;
                });
    },

    run: function () {
        var self = dev_fat;

        // 차트로드
        // self.initChart();
        // // 이벤트 설정
        // self.initEvent();
        // // 템플릿 컴파일
        // self.initFatTpl();
    }

};

$(function () {
    dev_fat.run();
});

