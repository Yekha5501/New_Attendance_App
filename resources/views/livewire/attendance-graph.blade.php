<div>
    <div class="bg-white p-2 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold">Attendance Chart</h2>
        <p class="text-sm text-gray-500">Morning and Evening Attendance for the last 14 worship sessions</p>
        <div id="chart"></div>
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
            var options = {
                series: [{
                    name: 'Morning Attendance',
                    data: @json($morningAttendance)
                }, {
                    name: 'Evening Attendance',
                    data: @json($eveningAttendance)
                }],
                chart: {
                    height: 350,
                    type: 'area'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'datetime',
                    categories: @json($categories)
                },
                yaxis: {
                    max: @json($maxAttendance) + 10 // Add some padding to the max value
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy'
                    },
                },
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        chart: {
                            height: 300
                        },
                        xaxis: {
                            labels: {
                                show: true,
                                rotate: -45
                            }
                        },
                        yaxis: {
                            labels: {
                                show: true
                            }
                        }
                    }
                }, {
                    breakpoint: 600,
                    options: {
                        chart: {
                            height: 250
                        },
                        xaxis: {
                            labels: {
                                show: false
                            }
                        },
                        yaxis: {
                            labels: {
                                show: false
                            }
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
</div>
