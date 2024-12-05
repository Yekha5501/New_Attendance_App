<div class="bg-white p-4 rounded-lg shadow-md">
    <h2 class="text-lg font-semibold">Latest Worship Scans</h2>
    <div id="scans"></div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        var users = @json($users);

        var seriesData = users.map(function(user) {
            return user.scans;
        });

        var labels = users.map(function(user) {
            return user.name;
        });

        var options = {
            series: seriesData,
            chart: {
                height: 350,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    offsetY: 0,
                    startAngle: 0,
                    endAngle: 270,
                    hollow: {
                        margin: 5,
                        size: '30%',
                        background: 'transparent',
                        image: undefined,
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            show: false,
                        }
                    },
                    barLabels: {
                        enabled: true,
                        useSeriesColors: true,
                        margin: 8,
                        fontSize: '8px',
                        formatter: function(seriesName, opts) {
                            return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                        },
                    },
                }
            },
            colors: ['#1ab7ea', '#0084ff', '#39539E', '#9370db', '#cc7000'], // Add more colors as needed
            labels: labels,
            responsive: [{
                breakpoint: 1200,
                options: {
                    chart: {
                        height: 300
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                size: '25%'
                            },
                            barLabels: {
                                fontSize: '8px'
                            }
                        }
                    }
                }
            }, {
                breakpoint: 768,
                options: {
                    chart: {
                        height: 250
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                size: '20%'
                            },
                            barLabels: {
                                fontSize: '6px'
                            }
                        }
                    }
                }
            }, {
                breakpoint: 480,
                options: {
                    chart: {
                        height: 200
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                size: '15%'
                            },
                            barLabels: {
                                fontSize: '6px'
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#scans"), options);
        chart.render();
    });
</script>
