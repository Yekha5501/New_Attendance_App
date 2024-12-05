<div class="bg-purple-100 p-4 rounded-lg shadow-md">
    <p class="text-lg font-semibold mb-4">Latest Worship Attendance</p>
    <div class="flex items-center justify-between">
        <!-- Left: Total Students Attended -->
        <div class="text-center">
            <p class="text-4xl font-bold text-gray-800">{{ $attendedStudents }}</p>
            <p class="text-sm text-gray-500">Total Students Attended</p>
        </div>

        <!-- Right: Attendance Chart -->
        <div id="attendance-chart" class="w-2/3"></div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        var options = {
            series: [@this.attendancePercentage],
            chart: {
                type: 'radialBar',
                height: 180,
                offsetY: -20,
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    track: {
                        background: "#e7e7e7",
                        strokeWidth: '77%',
                        margin: 5,
                        dropShadow: {
                            enabled: true,
                            top: 2,
                            left: 0,
                            color: '#999',
                            opacity: 1,
                            blur: 2
                        }
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            offsetY: -2,
                            fontSize: '14px'
                        }
                    }
                }
            },
            fill: {
                colors: ['#e69500'],
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    shadeIntensity: 0.4,
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 53, 91]
                },
            },
            labels: ['Attendance'],
            responsive: [{
                breakpoint: 768,
                options: {
                    chart: {
                        height: 150
                    },
                    plotOptions: {
                        radialBar: {
                            dataLabels: {
                                value: {
                                    fontSize: '12px'
                                }
                            }
                        }
                    }
                }
            }, {
                breakpoint: 480,
                options: {
                    chart: {
                        height: 120
                    },
                    plotOptions: {
                        radialBar: {
                            dataLabels: {
                                value: {
                                    fontSize: '10px'
                                }
                            }
                        }
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#attendance-chart"), options);
        chart.render();

        Livewire.on('refreshChart', (attendancePercentage) => {
            chart.updateSeries([attendancePercentage]);
        });
    });
</script>
